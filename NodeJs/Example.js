var mysql = require('mysql');
var restify = require('restify');
var http = require('http');
var url = require('url');

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

app.get('/resource/heartbeat', function(req, res){
	console.log( 'heartbeat' );
	// Example on how to send rest
	var sendRegisterAgentIdWithRest = {
  		host: "localhost",
  		port: 8000,
  		path: "/resource/registerAgentId?agentId=darrel&deviceType=win",
  		method: 'GET'
		};
	console.log( 'build rest' );
	http.request( sendRegisterAgentIdWithRest, function(res) {
  		console.log('STATUS: ' + res.statusCode);
  		console.log('HEADERS: ' + JSON.stringify(res.headers));
  		res.setEncoding('utf8');
  		res.on('end', function (chunk) {
    		console.log('BODY: ' + chunk);
  		});
		}).end(); 
	console.log( 'send rest' );
	res.send( 'res: heartbeat' + req.query.agentId );
});

app.get('/resource/registerAgentId', function(req, res){
	var agentId = req.query.agentId;
	var deviceType = req.query.deviceType;
	var queryString = "INSERT INTO regi_machines (status,type,userId) SELECT '" + agentId + "','" + deviceType + "',userId FROM user WHERE userName = 'mascloud';";
	var query = connection.query( queryString, function(err, rows){
		if( err ){
			throw err;
		}else{
			console.log( rows );
		}
	});
	res.send( 'res: registerAgentId ' + req.query.agentId + " " + req.params.agentId + " " + req.query.deviceType + " " + req.params.deviceType );
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


// Start listening socket
app.listen(8000);
