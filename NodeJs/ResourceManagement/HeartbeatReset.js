( function() {

	function start( database ) {
		
		// Setup the timeout handler
		var timeoutProtect = setInterval( function() {
						// Get machineId, heartbeat, health
			var queryGetHealth = "SELECT regi_machines.machineId,regi_machines.heartbeat,regi_machines.health FROM mac_web.regi_machines;";
			var query = database.query( queryGetHealth, function(err, rows){

				if( err ){
                                        console.log( err );
                                }else{
                                        console.log( rows );
					for( i = 0; i < rows.length; i++ )
					{
						var queryUpdateHealth = "";
						console.log( rows[i].machineId );
                                		// Remove if poor health
						// TODO						
		
						// Set health to good if heartbeat and was in bad health
						if( rows[i].heartbeat == '1' && rows[i].health == '0' ){
							queryUpdateHealth = "UPDATE regi_machines SET health='1' WHERE machineId='" + rows[i].machineId + "';"; 			
						}
						
						// Set health to poor if no heartbeat			
						if( rows[i].heartbeat == '0' && rows[i].health == '1' ){
							queryUpdateHealth = "UPDATE regi_machines SET health='0' WHERE machineId='" + rows[i].machineId + "';"; 			
						}

						// Reset heart beats in database
						if( queryUpdateHealth.length > 0 )
						{
                	       		        	var query = database.query( queryUpdateHealth, function(err, rows){
                	                        		if( err ){
                	                               	 		console.log( err );
                	                        		}else{
                	                                		console.log( 'Reseting health' );
                		                        	}
        		                        	});
						}
					}
                        	}
				
				// Reset heart beats in database
        			var queryResetHeartbeat = "UPDATE regi_machines SET heartbeat='0';";
				var query = database.query( queryResetHeartbeat, function(err, rows){
	            		    	if( err ){
						console.log( err );
             			   	}else{
						console.log( 'Reseting heartbeat' );
                			}
        			});
			});
		}, 10000);
	}

	module.exports.start = start;

})();
