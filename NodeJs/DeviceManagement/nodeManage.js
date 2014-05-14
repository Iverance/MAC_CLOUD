var restify = require('restify');
var http = require('http');
var url = require('url');
var exec = require('child_process').exec;

// Create rest server
var app = restify.createServer();
app.use(restify.queryParser());
app.use(restify.bodyParser());

<<<<<<< HEAD
app.get('/node/register', function(req, res){
	console.log( "REQUEST: register");
	var user = req.query.userName;
	var mail = req.query.email;
	var passwd = req.query.passwd;

	exec("appium --nodeconfig /home/mas/test.json", function (error, stdout, stderr) {
		// output is in stdout
		if( stdout.indexOf("Appium successfully") ){
			console.log('Appium registered');
			exec("adb devices", function (error, stdout, stderr) {
				// output is in stdout
				var check= 'list of devices attached\n';
				if( stdout.length>check.length ){
					console.log('Detect real device');
					//send launch back 
					exec("curl -XGET http://sth/resource", function (error, stdout, stderr) {
					});
				}
				else{
					console.log('No real device');
					exec("emulator -avd test", function (error, stdout, stderr) {
						//send launch back after 5 mins
					});
				}			
			});
		}
		else{
			console.log('Appium register fail');
			//fail and try again
			exec("curl -XGET http://localhost:8000/resource/register", function (error, stdout, stderr) {
			});
		}			
	});
});

app.get('/node/testapp', function(req, res){
	console.log( "REQUEST: testapp");
	exec("", function (error, stdout, stderr) {
		// output is in stdout
		if( stdout.indexOf("Appium successfully") ){
			
		}
		else{
			
		}			
	});
});

app.get('/account/pwReset', function(req, res){
	console.log( "REQUEST: pwReset");
	var user = req.query.userName;
	var pwOld = req.query.pwOld;
	var pwNew = req.query.pwNew;
  var getPwQuery = "SELECT pw FROM user WHERE userName='" + user +"' AND pw='" + pwOld + "';";
	console.log( "START CHECKING..." );
	connection.query(getPwQuery,function(error, rows, fields){
		//CHECK ERROR
		if(error){
			console.log('ERROR: OLD PASSWORD IS WRONG');
			res.send('wrongOldPwErr');
			throw error;
		}else {
			console.log('Password checking: correct');
		}
		console.log(rows[0].solution);
	});
	var queryString = "UPDATE user SET pw='" + pwNew + "' WHERE userName='" + user +"';";
	console.log( "START UPDATE..." );
	connection.query( queryString, function(err, rows){
		if( err ){
			console.log( 'ERROR: ' + err );
			res.send('DBErr');
			throw err;
		}else{
			console.log( rows );
			res.send('SUCCESS');
		}
	});
=======
exec("bash regAppium.sh &",  function (error, stdout, stderr) {});

app.get('/node/launchMachine', function(req, res){
	console.log( "REQUEST: launch");
	exec("bash runemu.sh &",  function (error, stdout, stderr) {});
	exec("curl http://192.168.0.176:8000/resource/updateLaunchedMachine?deviceId=0893ef03", function (error, stdout, stderr) {
		console.log( "heartbeat: " + stdout );
});	
	res.send("start launching emulator");
	
	
});

app.get('/node/terminateMachine', function(req, res){
	console.log( "REQUEST: terminate");
	exec("bash stopemu.sh &",  function (error, stdout, stderr) {});
	exec("curl http://192.168.0.176:8000/resource/updateTerminatedMachine?deviceId=0893ef03", function (error, stdout, stderr) {
		console.log( "heartbeat: " + stdout );
});	
	res.send("stop terminating emulator");
	
});

app.get('/node/launchApp', function(req, res){
	console.log( "REQUEST: launch app");
exec("curl http://192.168.0.176:8000/resource/launchedApp?deviceId=0893ef03", function (error, stdout, stderr) {
		console.log( "heartbeat: " + stdout );
});	
	exec("java -jar ./appTest3.jar", function (error, stdout, stderr) {
		exec("curl http://192.168.0.176:8000/resource/terminatedApp?deviceId=0893ef03", function (error, stdout, stderr) {
			console.log( "heartbeat: " + stdout );
		});
	});
	res.send("start launching app");
});

app.get('/node/terminateApp', function(req, res){
	console.log( "REQUEST: terminate app");
	 {
		exec("curl http://192.168.0.176:8000/resource/terminatedApp?deviceId=0893ef03", function (error, stdout, stderr) {
				console.log( "heartbeat: " + stdout );
		});		
	});
	res.send("stop terminating app");
>>>>>>> f7a765840b65069d7020df8cccc82e929cc237af
});


// Start listening socket
<<<<<<< HEAD
app.listen(8000);
console.log("Start listening port: 8000");
=======
app.listen(5566);
console.log("Start listening port: 5566");


// Setup the timeout handler
var timeoutProtect = setInterval( function() {
	exec("curl http://192.168.0.176:8000/resource/updateHeartbeat?deviceId=0893ef03", function (error, stdout, stderr) {
		console.log( "heartbeat: " + stdout );	
	});
}, 4000);
>>>>>>> f7a765840b65069d7020df8cccc82e929cc237af
