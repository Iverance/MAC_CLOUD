var mysql = require('mysql');
var restify = require('restify');
var http = require('http');
var url = require('url');
var heartBeat = require('./HeartbeatReset.js');
var exec = require('child_process').exec;

// Create mysql connection
var connection = mysql.createConnection( {
	host		: 'macdb.ctijsbuenarr.us-west-2.rds.amazonaws.com',
	user		: 'mac',
	password	: 'mac4thewin',
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
	if( typeof req.query.agentId != 'undefined' )
	{
		var agentId = req.query.agentId;
		var queryString = "UPDATE regi_machines SET heartbeat='1' WHERE machineId='" + agentId + "';";
		var query = connection.query( queryString, function(err, rows){
			handleResponse( err, res, agentId );
		});
	}
});

app.get('/resource/registerAgentId', function(req, res){
	var agentId = req.query.agentId;
	var deviceType = req.query.deviceType;
	var queryString = "INSERT INTO regi_machines (status,type,userId) SELECT 'idle','" + deviceType + "',userId FROM user WHERE userName = 'mascloud';";
	var query = connection.query( queryString, function(err, rows){
		handleResponse( err, res, rows.insertId );
	});
});

app.get('/resource/launchAgent', function(req, res){
	var agentId = req.query.agentId;
	var userId = req.query.userId;
	var queryString = "UPDATE regi_machines SET status='launching',userId='" + userId + "' WHERE machineId='" + agentId + "';";
	var query = connection.query( queryString, function(err, rows){
		handleResponse( err, res, agentId );
		exec("curl http://localhost:8000/resource/updateLaunchedAgent?agentId='" + agentId + "'", function (error, stdout, stderr) {
		  	// output is in stdout
			if( stdout == '"' + agentId + '"' ){
				console.log( "launchAgent: " + stdout );
			}
			else{
				console.log( "launchAgent: Command execution failed" );
			}			
		});
	});
});

app.get('/resource/terminateAgent', function(req, res){
	var agentId = req.query.agentId;
	var userId = req.query.userId;
	var queryString = "UPDATE regi_machines SET status='terminating',userId='2' WHERE machineId='" + agentId + "';";
	var query = connection.query( queryString, function(err, rows){
		handleResponse( err, res, agentId );
		exec("curl http://localhost:8000/resource/updateTerminatedAgent?agentId='" + agentId + "'", function (error, stdout, stderr) {
		  	// output is in stdout
			if( stdout == '"' + agentId + '"' ){
				console.log( "terminateAgent: " + stdout );
			}
			else{
				console.log( "terminateAgent: Command execution failed" );
			}
		});
	});
});

app.get('/resource/updateLaunchedAgent', function(req, res){
	var agentId = req.query.agentId;
	var queryString = "UPDATE regi_machines SET status='launched' WHERE machineId='" + agentId + "';";
	var query = connection.query( queryString, function(err, rows){
		handleResponse( err, res, agentId );
	});
});

app.get('/resource/updateTerminatedAgent', function(req, res){
	var agentId = req.query.agentId;
	var queryString = "UPDATE regi_machines SET status='idle' WHERE machineId='" + agentId + "';";
	var query = connection.query( queryString, function(err, rows){
		handleResponse( err, res, agentId );
	});
});


app.listen(8000);
