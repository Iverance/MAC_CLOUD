var mysql = require('mysql');
var restify = require('restify');
var http = require('http');
var url = require('url');
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

// Defines/Global
var cost = 0.0001;

// Setup the timeout handler
var timeoutProtect = setInterval( function() {
	// Generate new bill
	var queryGetMachineRecordString = "SELECT instanceId,userId,start,end FROM mac_web.run_machine_record WHERE end IS NOT NULL AND start IS NOT NULL AND processed=0";
	var query = connection.query( queryGetMachineRecordString, function(err, rows){
		if( err ){
			console.log( err );
		}else{
			console.log( rows );
			for( i = 0; i < rows.length; i++ )
			{
				var balance = parseInt( rows[i].end ) - parseInt( rows[i].start );
				// Add new statement
				var queryAddNewBillString = "INSERT INTO mac_web.statements(amount,dueDate,billingDate,userId) SELECT '" + balance + "',DATE_ADD(NOW(), INTERVAL 30 DAY ),NOW(),userId FROM mac_web.user WHERE userId ='" + rows[i].userId +"';";
				connection.query( queryAddNewBillString, function(err, rows ){
					if( err ){
							console.log( err );
					}else{
							console.log( 'New Bill Added' );
					}
				});

				// Marked record as processed
				var queryUpdateRecordString = "UPDATE mac_web.run_machine_record SET processed =1 WHERE instanceId='" + rows[i].instanceId + "';";
				connection.query( queryUpdateRecordString, function(err, rows ){
					if( err ){
							console.log( err );
					}else{
							console.log( 'UpdateRecord' );
					}
				});  
			}
		}
	});
}, 5000);


app.listen(8001);
