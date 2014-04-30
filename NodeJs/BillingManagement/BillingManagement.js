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

/*INSERT INTO `mac_web`.`bill`
(`userId`)
SELECT
userId FROM user WHERE userId='3';*/

// Setup the timeout handler
var timeoutProtect = setInterval( function() {
	// Generate new bill
	var queryGetHealth = "SELECT userId,payId,start,end FROM mac_web.run_machine_record WHERE payId IS NULL AND end IS NOT NULL;";
	var query = connection.query( queryGetHealth, function(err, rows)
	{
		if( err ){
			console.log( err );
		}else{
			console.log( rows );
			for( i = 0; i < rows.length; i++ )
			{
				var timeout = parseInt( rows[i].timeout );
				var health = parseInt( rows[i].health );
				// Process timeout for pending devices
				if( timeout > 0 ){
					var queryAddNewBill = "UPDATE regi_machines SET timeout='" + ( timeout - 1 ) + "' WHERE machineId='" + rows[i].machineId + "';";
					connection.query( queryUpdateHealth, function(err, rows){
						if( err ){
								console.log( err );
						}else{
								console.log( 'Reseting health' );
						}
					}); 			
				}
			}
		}
	});
}, 5000);


app.listen(8001);
