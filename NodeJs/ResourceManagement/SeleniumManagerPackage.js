( function() {

	var exec = require('child_process').exec;

	function launchDevice( deviceIp ) {
		// Launch device here
		
		console.log( "curl http://" + deviceIp + ":5566/node/launchMachine" );
		exec("curl http://" + deviceIp + ":5566/node/launchMachine", function (error, stdout, stderr) {
		 // output is in stdout
		 if( stdout == '"' + deviceIp + '"' ){
		 	console.log( "launchMachine: " + stdout );
		 }
		 else{
		 	console.log( "launchMachine: Command execution failed" );
		 }
		});
		console.log( 'starting device' );	
	}

	function terminateDevice( deviceIp ) {
		// stop device here	
		exec("curl http://" + deviceIp + ":5566/node/terminateMachine", function (error, stdout, stderr) {
		 // output is in stdout
		 if( stdout == '"' + deviceIp + '"' ){
		 console.log( "terminateMachine: " + stdout );
		 }
		 else{
		 console.log( "terminateMachine: Command execution failed" );
		 }
		});
		console.log( 'stopping device' );	
	}

	function launchApp( deviceIp ) {
		// Launch app here
		exec("curl http://" + deviceIp + ":5566/node/launchApp", function (error, stdout, stderr) {
		 // output is in stdout
		 if( stdout == '"' + deviceIp + '"' ){
		 console.log( "terminateMachine: " + stdout );
		 }
		 else{
		 console.log( "terminateMachine: Command execution failed" );
		 }
		});
		console.log( 'Starting app' );	
	}

	function terminateApp( deviceIp ) {
		// stop app here
		exec("curl http://" + deviceIp + ":5566/node/terminateApp", function (error, stdout, stderr) {
		 // output is in stdout
		 if( stdout == '"' + deviceIp + '"' ){
		 console.log( "terminateMachine: " + stdout );
		 }
		 else{
		 console.log( "terminateMachine: Command execution failed" );
		 }
		});	
		console.log( 'Stopping app' );
	}

	module.exports.launchDevice    = launchDevice;
	module.exports.terminateDevice = terminateDevice;
	module.exports.launchApp       = launchApp;
	module.exports.terminateApp    = terminateApp;

})();
