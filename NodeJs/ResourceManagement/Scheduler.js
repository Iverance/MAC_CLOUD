( function() {
	
	var healthReset = '2';
	var userAdmin ='2';
	var userSupport = '3';
	function start( connection ) {
		
		// Setup the timeout handler
		var timeoutProtect = setInterval( function() {
			
			// Get launched count
			var queryLaunchedString = "SELECT user.userId,IFNULL( regi_machines.status, 'launched'), COUNT( regi_machines.userId ) AS statusCount FROM user LEFT JOIN regi_machines ON user.userId = regi_machines.userId AND regi_machines.status='launched' GROUP BY 1;";
			var queryLaunched = connection.query( queryLaunchedString, function(err, rows) {

				if( err )
				{
                                        console.log( err );
                                }else{
					for( i = 0; i < rows.length; i++ )
					{
						queryUpdateString = "UPDATE user SET running='" + rows[i].statusCount + "' WHERE userId='" + rows[i].userId + "';"; 			
						var queryUpdate = connection.query( queryUpdateString, function(err, rows) {
							if( err )
							{
						                console.log( err );
						        }
						});
					}
                        	}
			});

			// Get launching count
			var queryLaunchingString = "SELECT user.userId,IFNULL( regi_machines.status, 'launching'), COUNT( regi_machines.userId ) AS statusCount FROM user LEFT JOIN regi_machines ON user.userId = regi_machines.userId AND regi_machines.status='launching' GROUP BY 1;";
			var queryLaunching = connection.query( queryLaunchingString, function(err, rows) {

				if( err )
				{
                                        console.log( err );
                                }else{
					for( i = 0; i < rows.length; i++ )
					{
						queryUpdateString = "UPDATE user SET launching='" + rows[i].statusCount + "' WHERE userId='" + rows[i].userId + "';"; 			
						var queryUpdate = connection.query( queryUpdateString, function(err, rows) {
							if( err )
							{
						                console.log( err );
						        }
						});
					}
                        	}
			});

			// Get terminating count
			var queryLaunchedString = "SELECT user.userId,IFNULL( regi_machines.status, 'terminating'), COUNT( regi_machines.userId ) AS statusCount FROM user LEFT JOIN regi_machines ON user.userId = regi_machines.userId AND regi_machines.status='terminating' GROUP BY 1;";
			var queryLaunched = connection.query( queryLaunchedString, function(err, rows) {

				if( err )
				{
                                        console.log( err );
                                }else{
					for( i = 0; i < rows.length; i++ )
					{
						queryUpdateString = "UPDATE user SET terminating='" + rows[i].statusCount + "' WHERE userId='" + rows[i].userId + "';"; 			
						var queryUpdate = connection.query( queryUpdateString, function(err, rows) {
							if( err )
							{
						                console.log( err );
						        }
						});
					}
                        	}
			});

			// Get idle count
			var queryLaunchedString = "SELECT user.userId,IFNULL( regi_machines.status, 'idle'), COUNT( regi_machines.userId ) AS statusCount FROM user LEFT JOIN regi_machines ON user.userId = regi_machines.userId AND regi_machines.status='idle' GROUP BY 1;";
			var queryLaunched = connection.query( queryLaunchedString, function(err, rows) {

				if( err )
				{
                                        console.log( err );
                                }else{
					for( i = 0; i < rows.length; i++ )
					{
						queryUpdateString = "UPDATE user SET idle='" + rows[i].statusCount + "' WHERE userId='" + rows[i].userId + "';"; 			
						var queryUpdate = connection.query( queryUpdateString, function(err, rows) {
							if( err )
							{
						                console.log( err );
						        }
						});
					}
                        	}
			});
			

			/*var queryRequestString = "SELECT user.userId,user.requests,user.running,user.launching,user.terminating, FROM mac_web.user;";
			var queryRequest = connection.query( queryRequestString, function(err, rows){

				if( err ){
                                        console.log( err );
                                }else{
                                        console.log( rows );
					for( i = 0; i < rows.length; i++ )
					{
						var timeout = parseInt( rows[i].timeout );
						var health = parseInt( rows[i].health );
						var queryUpdateHealth = "";
						console.log( rows[i].machineId );
						// Process timeout for pending devices
						if( timeout > 0 ){
							queryUpdateHealth = "UPDATE regi_machines SET timeout='" + ( timeout - 1 ) + "' WHERE machineId='" + rows[i].machineId + "';"; 			
						}

						// Move problem devices to support
						if( ( rows[i].status == 'launching' || rows[i].status == 'terminating' ) && rows[i].timeout == '0' && rows[i].userId != userSupport ){
							queryUpdateHealth = "UPDATE regi_machines SET userId='" + userSupport + "' WHERE machineId='" + rows[i].machineId + "';"; 			
						}					
		
                                		// Remove if poor health
						if( rows[i].heartbeat == '0' && rows[i].health == '0'  && rows[i].userId != userAdmin && rows[i].userId != userSupport ){
							queryUpdateHealth = "UPDATE regi_machines SET userId='" + userAdmin + "' WHERE machineId='" + rows[i].machineId + "';"; 			
						}						
		
						// Set health to good if heartbeat and was in bad health
						if( rows[i].heartbeat == '1' && health == 0 ){
							queryUpdateHealth = "UPDATE regi_machines SET health='" + healthReset + "' WHERE machineId='" + rows[i].machineId + "';"; 			
						}
						
						// Set health to poor if no heartbeat
									
						if( rows[i].heartbeat == '0' && health > 0 ){
							queryUpdateHealth = "UPDATE regi_machines SET health='" + (health - 1) + "' WHERE machineId='" + rows[i].machineId + "';"; 			
						}

						// Reset heart beats in connection
						if( queryUpdateHealth.length > 0 )
						{
                	       		        	var query = connection.query( queryUpdateHealth, function(err, rows){
                	                        		if( err ){
                	                               	 		console.log( err );
                	                        		}else{
                	                                		console.log( 'Reseting health' );
                		                        	}
        		                        	});
						}
					}
                        	}
			});*/
		}, 5000);
	}

	module.exports.start = start;

})();
