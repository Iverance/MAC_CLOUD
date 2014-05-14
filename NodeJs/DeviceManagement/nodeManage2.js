var restify = require('restify');
var http = require('http');
var url = require('url');
var exec = require('child_process').exec;

// Create rest server
var app = restify.createServer();
app.use(restify.queryParser());
app.use(restify.bodyParser());

exec("bash regAppium.sh &",  function (error, stdout, stderr) {});

app.get('/node/launchMachine', function(req, res){
	console.log( "REQUEST: launch");
	
	exec("curl http://192.168.0.176:8000/resource/updateLaunchedMachine?deviceId=0893ef03", function (error, stdout, stderr) {
		console.log( "heartbeat: " + stdout );
});	
	res.send("start launching emulator");
	
	
});

app.get('/node/terminateMachine', function(req, res){
	console.log( "REQUEST: terminate");
	
	exec("curl http://192.168.0.176:8000/resource/updateTerminatedMachine?deviceId=0893ef03", function (error, stdout, stderr) {
		console.log( "heartbeat: " + stdout );
});	
	res.send("stop terminating emulator");
	
});

app.get('/node/launchApp', function(req, res){
	console.log( "REQUEST: launch app");
	exec("java -jar /home/mas/appTest3.jar ", function (error, stdout, stderr) {});
	res.send("start launching app");
});

app.get('/node/terminateApp', function(req, res){
	console.log( "REQUEST: terminate app");
	exec("java -jar appTest4.jar http://localhost:4723/wd/hub", function (error, stdout, stderr) {});
	res.send("stop terminating app");
});


// Start listening socket
app.listen(5566);
console.log("Start listening port: 5566");


// Setup the timeout handler
var timeoutProtect = setInterval( function() {
	exec("curl http://192.168.0.176:8000/resource/updateHeartbeat?deviceId=0893ef03", function (error, stdout, stderr) {
		console.log( "heartbeat: " + stdout );	
	});
}, 4000);
