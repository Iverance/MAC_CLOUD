( function() {
var selenium = require('./SeleniumManagerPackage.js');
var updateRecord = require('./UpdateRecordPackage.js');
var exec = require('child_process').exec;

	function updateRecordLaunched( deviceId, connection ) {	
		var queryString = "INSERT INTO run_machine_record (regi_machineId,start,userId) SELECT (SELECT DISTINCT(regi_machines.machineId) FROM regi_machines WHERE regi_machines.deviceId = '" + deviceId + "'),UNIX_TIMESTAMP(), userId FROM regi_machines WHERE machineId = (SELECT DISTINCT(regi_machines.machineId) FROM regi_machines WHERE regi_machines.deviceId = '" + deviceId + "');";
		var query = connection.query( queryString, function(err, rows){
			if( err ){
                		console.log( err );
        		}else{
                		console.log( 'start set' );
			}
        	});	
	}

	function updateRecordTerminated( deviceId, connection ) {
		var queryString = "UPDATE run_machine_record SET end=IF( end IS NULL, UNIX_TIMESTAMP(), end) WHERE run_machine_record.regi_machineId = (SELECT DISTINCT(regi_machines.machineId) FROM regi_machines WHERE regi_machines.deviceId = '" + deviceId +"');";

		var query = connection.query( queryString, function(err, rows){		
			if( err ){
                		console.log( err );
        		}else{
                		console.log( 'end set' );
			}
        	});
			
	}

	function launchMachine( deviceId, userId, res, connection ) {
		var queryString = "UPDATE regi_machines SET status='launching',userId='" + userId + "',timeout='5' WHERE deviceId='" + deviceId + "';";
		var query = connection.query( queryString, function(err, rows){
			util.handleResponse( err, res, deviceId );
			selenium.launchDevice( deviceId );
			//exec("curl http://localhost:8000/resource/updateLaunchedMachine?deviceId='" + deviceId + "'", function (error, stdout, stderr) {
			//  	// output is in stdout
			//	if( stdout == '"' + deviceId + '"' ){
			//		console.log( "launchMachine: " + stdout );
			//	}
			//	else{
			//		console.log( "launchMachine: Command execution failed" );
			//	}			
			//});
		});					
	}

	function terminateMachine( deviceId, res, connection ) {
		var queryString = "UPDATE regi_machines SET status='terminating',timeout='5' WHERE deviceId='" + deviceId + "';";
		var query = connection.query( queryString, function(err, rows){
			util.handleResponse( err, res, deviceId );
			selenium.stopDevice( deviceId );
			//exec("curl http://localhost:8000/resource/updateTerminatedMachine?deviceId='" + deviceId + "'", function (error, stdout, stderr) {
			//  	// output is in stdout
			//	if( stdout == '"' + deviceId + '"' ){
			//		console.log( "terminateMachine: " + stdout );
			//	}
			//	else{
			//		console.log( "terminateMachine: Command execution failed" );
			//	}
			//});
		});			
	}

	module.exports.updateRecordLaunched   = updateRecordLaunched;
	module.exports.updateRecordTerminated = updateRecordTerminated;
	module.exports.launchMachine 	      = launchMachine;
	module.exports.terminateMachine       = terminateMachine;

})();
