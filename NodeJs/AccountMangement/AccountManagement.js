var mysql = require('mysql');
var restify = require('restify');
var http = require('http');
var url = require('url');

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

app.get('/account/createUser', function(req, res){
	console.log( "REQUEST: createUser");
	var user = req.query.userName;
	var mail = req.query.email;
	var passwd = req.query.passwd;
	var queryString = "INSERT INTO user ( 'userName','pw','mail' ) VALUE ('"+user+"','"+passwd+"','"+mail+"');";
	console.log( "START INSERT..." );
	connection.query( queryString, function(err, rows){
		if( err ){
			console.log( "ERROR: " + err );
			res.send('ERROR' + err);
			throw err;
		}else{
			console.log( rows );
			res.send('SUCCESS');
		}
	});
});

app.get('/account/editProfile', function(req, res){
	console.log( "REQUEST: editProfile");
	var user = req.query.userName;
	var mail = req.query.email;
	var queryString = "UPDATE user SET mail='" + mail + "' WHERE userName='" + user +"';";
	console.log( "START UPDATE..." );
	connection.query( queryString, function(err, rows){
		if( err ){
			console.log( "ERROR: " + err );
			res.send('ERROR');
			throw err;
		}else{
			console.log( rows );
			res.send('SUCCESS');
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
