var mysql = require('mysql');
var restify = require('restify');
var http = require('http');
var url = require('url');
var heartBeat = require('./ResourceMonitorPackage.js');
var scheduler = require('./SchedulerPackage.js');
var updateRecord = require('./UpdateRecordPackage.js');
var selenium = require('./SeleniumManagerPackage.js');
var util = require('./UtilPackage.js');

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

// Rest handler
app.get('/resource/updateHeartbeat', function(req, res){
	if( typeof req.query.deviceId != 'undefined' )
	{
		console.log( "got heartbeat" );
		var deviceId = req.query.deviceId;
		var queryString = "UPDATE regi_machines SET heartbeat='1' WHERE deviceId='" + deviceId + "';";
		var query = connection.query( queryString, function(err, rows){
			util.handleResponse( err, res, deviceId );
		});
	}
});

app.get('/resource/registerDevice', function(req, res){
	var deviceId = req.query.deviceId;
	var deviceType = req.query.deviceType;
	var deviceIp = req.query.deviceIp;
	
	var queryString = "SELECT regi_machines.* FROM mac_web.regi_machines WHERE deviceId='" + deviceId + "';";
	var query = connection.query( queryString, function(err, rows){
		if( rows.length == 0 )
		{
			var queryString = "INSERT INTO regi_machines (status,type,deviceId,deviceIp,userId) SELECT 'idle','" + deviceType + "', '"  + deviceIp + "', '" + deviceId + "',userId FROM user WHERE userName = 'mascloud';";
			var query = connection.query( queryString, function(err, rows){
				util.handleResponse( err, res, rows.insertId );
			});
		}
	});
});

app.get('/resource/launchMachine', function(req, res){
	updateRecord.launchMachine( req.query.deviceId, req.query.deviceIp, req.query.userId, res, connection );
});

app.get('/resource/terminateMachine', function(req, res){
	updateRecord.terminateMachine( req.query.deviceId, req.query.deviceIp, res, connection );
});

app.get('/resource/launchApp', function(req, res){
	selenium.launchApp( req.query.deviceIp );
	util.handleResponse( err, res, req.query.deviceIp );	
});

app.get('/resource/terminateApp', function(req, res){
	selenium.terminateApp( req.query.deviceIp );
	util.handleResponse( err, res, req.query.deviceIp );
});

app.get('/resource/launchedApp', function(req, res){
	var queryUpdateLaunchedStatusString = "UPDATE regi_machines SET launchedApp='1' WHERE deviceId='" + req.query.deviceId + "';";
	connection.query( queryUpdateLaunchedStatusString, function(err, rows){
		util.handleResponse( err, res, deviceId );
	});
});

app.get('/resource/terminatedApp', function(req, res){
	var queryUpdateLaunchedStatusString = "UPDATE regi_machines SET launchedApp='0' WHERE deviceId='" + req.query.deviceId + "';";
	connection.query( queryUpdateLaunchedStatusString, function(err, rows){
		util.handleResponse( err, res, deviceId );
	});
});

app.get('/resource/increaseMachine', function(req, res){
	var userId = req.query.userId;
	var queryString = "UPDATE user SET requests=requests + 1 WHERE userId='" + userId + "' AND requests < " + MAX_INSTANCE + ";";
	var query = connection.query( queryString, function(err, rows){
		util.handleResponse( err, res, 0 );
	});
});

app.get('/resource/decreaseMachine', function(req, res){
	var userId = req.query.userId;
	var queryString = "UPDATE user SET requests=requests - 1 WHERE userId='" + userId + "' AND requests > " + MIN_INSTANCE + ";";
	var query = connection.query( queryString, function(err, rows){
		util.handleResponse( err, res, 0 );	
	});
});

app.get('/resource/updateLaunchedMachine', function(req, res){
	var deviceId = req.query.deviceId;
	var queryUpdateLaunchedStatusString = "UPDATE regi_machines SET status='launched' WHERE deviceId='" + deviceId + "';";
	connection.query( queryUpdateLaunchedStatusString, function(err, rows){
		util.handleResponse( err, res, deviceId );
		updateRecord.updateRecordLaunched( deviceId, connection );
	});
});

app.get('/resource/updateTerminatedMachine', function(req, res){
	var deviceId = req.query.deviceId;
	var queryUpdateTerminatedStatusString = "UPDATE regi_machines SET status='idle',userId='2' WHERE deviceId='" + deviceId + "';";
	connection.query( queryUpdateTerminatedStatusString, function(err, rows){
		util.handleResponse( err, res, deviceId );
		updateRecord.updateRecordTerminated( deviceId, connection );
	});
});


app.listen(8000);
