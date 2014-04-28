( function() {

	function updateRecordLaunched( agentId, connection ) {	
		var queryString = "INSERT INTO run_machine_record (regi_machineId,start,userId) SELECT '" + agentId + "',UNIX_TIMESTAMP(), userId FROM regi_machines WHERE machineId = '" + agentId + "';";
		var query = connection.query( queryString, function(err, rows){		
			if( err ){
                		console.log( err );
        		}else{
                		console.log( 'start set' );
			}
        	});	
	}

	function updateRecordTerminated( agentId, connection ) {
		var queryString = "UPDATE run_machine_record SET end=UNIX_TIMESTAMP() WHERE regi_machineId = '" + agentId + "';";
		var query = connection.query( queryString, function(err, rows){		
			if( err ){
                		console.log( err );
        		}else{
                		console.log( 'end set' );
			}
        	});
			
	}

	module.exports.updateRecordLaunched = updateRecordLaunched;
	module.exports.updateRecordTerminated = updateRecordTerminated;

})();
