( function() {
var selenium = require('./SeleniumManagerPackage.js');
	
	var healthReset = '2';
	var userAdmin ='2';
	var userSupport = '3';
	var queryToComplete = 0;
	var queryToCompleting = 0;	

	function countLaunchedDevices( connection ) {
		// Get launched count
		var queryLaunchedString = "SELECT user.userId,IFNULL( regi_machines.status, 'launched'), COUNT( regi_machines.userId ) AS statusCount FROM user LEFT JOIN regi_machines ON user.userId = regi_machines.userId AND regi_machines.status='launched' GROUP BY 1;";
		connection.query( queryLaunchedString, function(err, rows) {

			if( err )
			{
                                console.log( err );
				countLaunchingDevices( connection );
                        }else{
				if( queryToCompleting == 0 )
				{				
					queryToComplete = rows.length;
					if( queryToComplete == 0 )
					{
						countLaunchingDevices( connection );
					} 
					for( i = 0; i < rows.length; i++ )
					{
						var queryUpdateString = "UPDATE user SET running='" + rows[i].statusCount + "' WHERE userId='" + rows[i].userId + "';"; 			
						var queryUpdate = connection.query( queryUpdateString, function(err, rows) {						
							queryToCompleting++;
							if( err )
							{
							        console.log( err );
							}
							if( queryToCompleting == queryToComplete )
							{
								countLaunchingDevices( connection );
							}
						});
					}
				}
                	}
		});
	}

	function countLaunchingDevices( connection ) {
	// Get launching count
		var queryLaunchingString = "SELECT user.userId,IFNULL( regi_machines.status, 'launching'), COUNT( regi_machines.userId ) AS statusCount FROM user LEFT JOIN regi_machines ON user.userId = regi_machines.userId AND regi_machines.status='launching' GROUP BY 1;";
		connection.query( queryLaunchingString, function(err, rows) {

			if( err )
			{
                                console.log( err );				
				countTerminatingDevices( connection );
                        }else{
				queryToCompleting = 0;
				queryToComplete = rows.length;
				if( queryToComplete == 0 )
				{
					countTerminatingDevices( connection );
				} 
				for( i = 0; i < rows.length; i++ )
				{
					var queryUpdateString = "UPDATE user SET launching='" + rows[i].statusCount + "' WHERE userId='" + rows[i].userId + "';"; 			
					var queryUpdate = connection.query( queryUpdateString, function(err, rows) {					
						queryToCompleting++;
						if( err )
						{
					                console.log( err );
					        }
						if( queryToCompleting == queryToComplete )
						{
							countTerminatingDevices( connection );
						}
					});
				}
                	}
		});
	}

	function countTerminatingDevices( connection ) {
		// Get terminating count
		var queryLaunchedString = "SELECT user.userId,IFNULL( regi_machines.status, 'terminating'), COUNT( regi_machines.userId ) AS statusCount FROM user LEFT JOIN regi_machines ON user.userId = regi_machines.userId AND regi_machines.status='terminating' GROUP BY 1;";
		connection.query( queryLaunchedString, function(err, rows) {

			if( err )
			{
                                console.log( err );
				countIdleDevices( connection );
                        }else{
				queryToCompleting = 0;
				queryToComplete = rows.length;
				if( queryToComplete == 0 )
				{
					countIdleDevices( connection );
				} 
				for( i = 0; i < rows.length; i++ )
				{
					var queryUpdateString = "UPDATE user SET terminating='" + rows[i].statusCount + "' WHERE userId='" + rows[i].userId + "';"; 			
					var queryUpdate = connection.query( queryUpdateString, function(err, rows) {					
						queryToCompleting++;
						if( err )
						{
					                console.log( err );
					        }
						if( queryToCompleting == queryToComplete )
						{
							countIdleDevices( connection );
						}
					});
				}
                	}
		});	
	}

	function countIdleDevices( connection ) {
		// Get idle count
		var queryLaunchedString = "SELECT user.userId,IFNULL( regi_machines.status, 'idle'), COUNT( regi_machines.userId ) AS statusCount FROM user LEFT JOIN regi_machines ON user.userId = regi_machines.userId AND regi_machines.status='idle' GROUP BY 1;";
		connection.query( queryLaunchedString, function(err, rows) {

			if( err )
			{
                                console.log( err );
				resourceAllocating( connection );
                        }else{
				queryToCompleting = 0;
				queryToComplete = rows.length;
				if( queryToComplete == 0 )
				{
					resourceAllocating( connection );
				} 
				for( i = 0; i < rows.length; i++ )
				{
					var queryUpdateString = "UPDATE user SET idle='" + rows[i].statusCount + "' WHERE userId='" + rows[i].userId + "';"; 			
					var queryUpdate = connection.query( queryUpdateString, function(err, rows) {					
						queryToCompleting++;
						if( err )
						{
					                console.log( err );
					        }
						if( queryToCompleting == queryToComplete )
						{
							resourceAllocating( connection );
						}
					});
				}
                	}
		});
	}

	function resourceAllocating( connection ) {
		// Write resource allocation here
		var queryRequestsString = "SELECT userId,requests,running,launching,terminating FROM user;";
		connection.query( queryRequestsString, function(err, rows) {
			queryToCompleting = 0;
			if( err )
			{
                console.log( err );
            }else{
				for( i = 0; i < rows.length; i++ )
				{
					if( rows[i].requests > rows[i].running + rows[i].launching + rows[i].terminating )
					{;
						// Get available devices
						var queryGetAvailableDevicesString = "SELECT machineId,deviceId,deviceIp,'" + rows[i].userId + "' AS userToUpdateId FROM regi_machines WHERE userId='2' AND status='idle' LIMIT 1";
						connection.query( queryGetAvailableDevicesString, function(err, rows) {
							if( err )
							{
							        console.log( err );
							}
							else
							{								
								if( rows.length > 0 )
								{
									// Get available devices
									var queryUpdateString = "UPDATE regi_machines SET status='launching',userId='" + rows[0].userToUpdateId + "',timeout='60' WHERE machineId='" + rows[0].machineId + "'LIMIT 1;";
									console.log( "Launching Device: " + rows[0].deviceId  );
									connection.query( queryUpdateString, function(err, rows) {
										if( err )
										{
											console.log( err );
										}									
									});
									// Launch device
									selenium.launchDevice( rows[0].deviceIp );	
								}
							}
						});
					}
					else if( rows[i].requests > rows[i].running + rows[i].launching + rows[i].terminating )
					{
						// Get running devices							
						var queryGetRunningDevicesString = "SELECT deviceId,deviceIp,'" + rows[i].userId + "' AS userToUpdateId FROM regi_machines WHERE userId='" + rows[i].userId + "' AND status='launched' LIMIT 1";
						connection.query( queryGetAvailableDevicesString, function(err, rows) {
							if( err )
							{
							        console.log( err );
							}
							else
							{								
								if( rows.length > 0 )
								{
									// Get available devices
									var queryUpdateString = "UPDATE regi_machines SET status='idle',userId='" + userAdmin + "',timeout='0' WHERE userId='" + rows[0].userToUpdateId + "' AND deviceId='" + rows[0].deviceId + "' LIMIT 1;";
									console.log( "Launching Device: " + rows[0].deviceId  );
									connection.query( queryUpdateString, function(err, rows) {
										if( err )
										{
											console.log( err );
										}									
									});
									// Launch device
									selenium.terminateDevice( rows[0].deviceIp );	
								}
							}
						});					
					}
					else
					{
						// do nothing
					}						
				}
                	}
		});
	}

	function start( connection ) {
		
		// Setup the timeout handler
		var timeoutProtect = setInterval( function() {
			
			countLaunchedDevices( connection );

		}, 5000);
	}

	module.exports.start = start;

})();
