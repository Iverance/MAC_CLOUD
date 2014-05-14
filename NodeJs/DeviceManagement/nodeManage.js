var restify = require('restify');
var http = require('http');
var url = require('url');
var exec = require('child_process').exec;

// Create rest server
var app = restify.createServer();
app.use(restify.queryParser());
app.use(restify.bodyParser());

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
});


// Start listening socket
app.listen(8000);
console.log("Start listening port: 8000");
