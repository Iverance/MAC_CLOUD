( function() {
var updateRecord = require('./UpdateRecord.js');
	
	var healthReset = '3';
	var userAdmin ='2';
	var userSupport = '3';
	function start( connection ) {
		
		// Setup the timeout handler
		var timeoutProtect = setInterval( function() {
						// Get machineId, heartbeat, health
			var queryGetHealth = "SELECT regi_machines.status,regi_machines.userId,regi_machines.machineId,regi_machines.heartbeat,regi_machines.health,regi_machines.timeout FROM mac_web.regi_machines;";
			var query = connection.query( queryGetHealth, function(err, rows){

				if( err ){
                                        console.log( err );
                                }else{
                                        console.log( rows );
					for( i = 0; i < rows.length; i++ )
					{
						var timeout = parseInt( rows[i].timeout );
						var health = parseInt( rows[i].health );
						var queryUpdateHealth = "";
						// Process timeout for pending devices
						if( timeout > 0 ){
							queryUpdateHealth = "UPDATE regi_machines SET timeout='" + ( timeout - 1 ) + "' WHERE machineId='" + rows[i].machineId + "';";
							connection.query( queryUpdateHealth, function(err, rows){
                	                        		if( err ){
                	                               	 		console.log( err );
                	                        		}else{
                	                                		console.log( 'Reseting health' );
                		                        	}
        		                        	}); 			
						}

						// Move problem devices to support
						if( ( rows[i].status == 'launching' || rows[i].status == 'terminating' ) && rows[i].timeout == '0' && rows[i].userId != userSupport ){
							queryUpdateHealth = "UPDATE regi_machines SET userId='" + userSupport + "' WHERE machineId='" + rows[i].machineId + "';";
							connection.query( queryUpdateHealth, function(err, rows){
                	                        		if( err ){
                	                               	 		console.log( err );
                	                        		}else{
                	                                		console.log( 'Reseting health' );
                		                        	}
        		                        	}); 			
						}

						// Move idle devices to admin
						if( rows[i].status == 'idle' && rows[i].userId != userAdmin ){
							queryUpdateHealth = "UPDATE regi_machines SET userId='" + userAdmin + "' WHERE machineId='" + rows[i].machineId + "';";
							connection.query( queryUpdateHealth, function(err, rows){
                	                        		if( err ){
                	                               	 		console.log( err );
                	                        		}else{
                	                                		console.log( 'Reseting health' );
                		                        	}
        		                        	}); 			
						}					
		
                                		// Remove if poor health
						if( rows[i].heartbeat == '0' && rows[i].health == '0'  && rows[i].userId != userAdmin && rows[i].userId != userSupport ){
							queryUpdateHealth = "UPDATE regi_machines SET userId='" + userSupport + "' WHERE machineId='" + rows[i].machineId + "';";
							connection.query( queryUpdateHealth, function(err, rows){
                	                        		if( err ){
                	                               	 		console.log( err );
                	                        		}else{
                	                                		console.log( 'Reseting health' );
                		                        	}
        		                        	});
							updateRecord.updateRecordTerminated( rows[i].machineId, connection ); 			
						}								
						// Set health to good if heartbeat and was in bad health
						else if( rows[i].heartbeat == '1' && health == 0 ){
							queryUpdateHealth = "UPDATE regi_machines SET health='" + healthReset + "' WHERE machineId='" + rows[i].machineId + "';";
							connection.query( queryUpdateHealth, function(err, rows){
                	                        		if( err ){
                	                               	 		console.log( err );
                	                        		}else{
                	                                		console.log( 'Reseting health' );
                		                        	}
        		                        	}); 			
						}						
						// decrease health to poor if no heartbeat									
						else if( rows[i].heartbeat == '0' && health > 0 ){
							queryUpdateHealth = "UPDATE regi_machines SET health='" + (health - 1) + "' WHERE machineId='" + rows[i].machineId + "';";
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
				
				// Reset heart beats in connection
        			var queryResetHeartbeat = "UPDATE regi_machines SET heartbeat='0';";
				var query = connection.query( queryResetHeartbeat, function(err, rows){
	            		    	if( err ){
						console.log( err );
             			   	}else{
						console.log( 'Reseting heartbeat' );
                			}
        			});
			});
		}, 5000);
	}

	module.exports.start = start;

})();
