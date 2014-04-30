( function() {

	function updateRecordLaunched( machineId, connection ) {	
		var queryString = "INSERT INTO run_machine_record (regi_machineId,start,userId) SELECT '" + machineId + "',UNIX_TIMESTAMP(), userId FROM regi_machines WHERE machineId = '" + machineId + "';";
		var query = connection.query( queryString, function(err, rows){		
			if( err ){
                		console.log( err );
        		}else{
                		console.log( 'start set' );
			}
        	});	
	}

	function updateRecordTerminated( machineId, connection ) {
		var queryString = "UPDATE run_machine_record SET end=IF( end IS NULL, UNIX_TIMESTAMP(), end) WHERE regi_machineId = '" + machineId + "';";
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
