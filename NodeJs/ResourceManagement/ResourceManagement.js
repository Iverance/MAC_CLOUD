var mysql = require('mysql');
var restify = require('restify');
var http = require('http');
var url = require('url');
var heartBeat = require('./ResourceMonitor.js');
var scheduler = require('./Scheduler.js');
var updateRecord = require('./UpdateRecord.js');
var exec = require('child_process').exec;

// Create mysql connection
var connection = mysql.createConnection( {
	host		: 'freesql.ctijsbuenarr.us-west-2.rds.amazonaws.com',
	user		: 'admin',
	password	: 'adminpasswd',
});

// Connect to mysql connection
connection.connect( function(err) {
	if( err ){
		console.log( 'mysql connection failed' );
		throw err;
	}else{
		console.log( 'mysql connected' );
	}
});
connection.query( 'use mac_web' );

// Create rest server
var app = restify.createServer();
app.use(restify.queryParser());
app.use(restify.bodyParser());

// Start heartbeat monitor
heartBeat.start( connection );

// Start schedular
scheduler.start( connection );

// Defines (global variable)
var MAX_INSTANCE = 10;
var MIN_INSTANCE =  0;

function handleResponse( err, res, validResponse ){
	if( err ){
		res.send( "-1" );
                console.log( err );
        }else{
                res.send( "" + validResponse );
        }
}

// Rest handler
app.get('/resource/heartbeat', function(req, res){
	if( typeof req.query.machineId != 'undefined' )
	{
		var machineId = req.query.machineId;
		var queryString = "UPDATE regi_machines SET heartbeat='1' WHERE machineId='" + machineId + "';";
		var query = connection.query( queryString, function(err, rows){
			handleResponse( err, res, machineId );
		});
	}
});

app.get('/resource/registerMachineId', function(req, res){
	var machineId = req.query.machineId;
	var deviceType = req.query.deviceType;
	var queryString = "INSERT INTO regi_machines (status,type,userId) SELECT 'idle','" + deviceType + "',userId FROM user WHERE userName = 'mascloud';";
	var query = connection.query( queryString, function(err, rows){
		handleResponse( err, res, rows.insertId );
	});
});

app.get('/resource/launchMachine', function(req, res){
	var machineId = req.query.machineId;
	var userId = req.query.userId;
	var queryString = "UPDATE regi_machines SET status='launching',userId='" + userId + "',timeout='5' WHERE machineId='" + machineId + "';";
	var query = connection.query( queryString, function(err, rows){
		handleResponse( err, res, machineId );
		exec("curl http://localhost:8000/resource/updateLaunchedMachine?machineId='" + machineId + "'", function (error, stdout, stderr) {
		  	// output is in stdout
			if( stdout == '"' + machineId + '"' ){
				console.log( "launchMachine: " + stdout );
			}
			else{
				console.log( "launchMachine: Command execution failed" );
			}			
		});
	});
});

app.get('/resource/terminateMachine', function(req, res){
	var machineId = req.query.machineId;
	var userId = req.query.userId;
	var queryString = "UPDATE regi_machines SET status='terminating',timeout='5' WHERE machineId='" + machineId + "';";
	var query = connection.query( queryString, function(err, rows){
		handleResponse( err, res, machineId );
		exec("curl http://localhost:8000/resource/updateTerminatedMachine?machineId='" + machineId + "'", function (error, stdout, stderr) {
		  	// output is in stdout
			if( stdout == '"' + machineId + '"' ){
				console.log( "terminateMachine: " + stdout );
			}
			else{
				console.log( "terminateMachine: Command execution failed" );
			}
		});
	});
});

app.get('/resource/increaseMachine', function(req, res){
	var userId = req.query.userId;
	var queryString = "UPDATE user SET requests=requests + 1 WHERE userId='" + userId + "' AND requests < " + MAX_INSTANCE + ";";
	var query = connection.query( queryString, function(err, rows){
		handleResponse( err, res, 0 );
	});
});

app.get('/resource/decreaseMachine', function(req, res){
	var userId = req.query.userId;
	var queryString = "UPDATE user SET requests=requests - 1 WHERE userId='" + userId + "' AND requests > " + MIN_INSTANCE + ";";
	var query = connection.query( queryString, function(err, rows){
		handleResponse( err, res, 0 );	
	});
});

app.get('/resource/updateLaunchedMachine', function(req, res){
	var machineId = req.query.machineId;
	var queryUpdateLaunchedStatusString = "UPDATE regi_machines SET status='launched' WHERE machineId='" + machineId + "';";
	connection.query( queryUpdateLaunchedStatusString, function(err, rows){
		handleResponse( err, res, machineId );
		updateRecord.updateRecordLaunched( machineId, connection );
	});
});

app.get('/resource/updateTerminatedMachine', function(req, res){
	var machineId = req.query.machineId;
	var queryUpdateTerminatedStatusString = "UPDATE regi_machines SET status='idle',userId='2' WHERE machineId='" + machineId + "';";
	connection.query( queryUpdateTerminatedStatusString, function(err, rows){
		handleResponse( err, res, machineId );
		updateRecord.updateRecordTerminated( machineId, connection );
	});
});


app.listen(8000);
