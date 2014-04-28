var mysql = require('mysql');
var restify = require('restify');
var http = require('http');
var url = require('url');
var heartBeat = require('./HeartbeatReset.js');

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


// Rest handler
app.get('/resource/heartbeat', function(req, res){
	if( typeof req.query.agentId != 'undefined' )
	{
		var agentId = req.query.agentId;
		var queryString = "UPDATE regi_machines SET heartbeat='1' WHERE machineId='" + agentId + "';";
		var query = connection.query( queryString, function(err, rows){
			if( err ){
				res.send( "heartbeat: failed" );
				console.log( rows );
			}else{
				res.send( "heartbeat: success" );
			}
		});
	}
});

app.get('/resource/registerAgentId', function(req, res){
	var agentId = req.query.agentId;
	var deviceType = req.query.deviceType;
	var queryString = "INSERT INTO regi_machines (status,type,userId) SELECT '" + agentId + "','" + deviceType + "',userId FROM user WHERE userName = 'mascloud';";
	var query = connection.query( queryString, function(err, rows){
		if( err ){
			res.send( "-1" );
			console.log( err );
		}else{
			res.send( "" + rows.insertId );
			console.log( rows );
		}
	});
});

app.get('/resource/runningInstances', function(req, res){
	res.send( 'res: runningInstances' + req.query.userId );
});

app.get('/resource/increaseAgent', function(req, res){
	res.send( 'res: increaseAgent' );
});

app.get('/resource/reduceAgent', function(req, res){
	res.send( 'res: reduceAgent' );
});


app.listen(8000);
