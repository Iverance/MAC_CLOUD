( function() {

	function launchDevice( deviceId, deviceIp ) {
		// Launch device here
		console.log( 'starting device' );	
	}

	function terminateDevice( deviceId ) {
		// stop device here	
		console.log( 'stopping device' );	
	}

	function launchApp( deviceId, deviceIp ) {
		// Launch app here
		console.log( 'Starting app' );	
	}

	function terminateApp( deviceId ) {
		// stop app here	
		console.log( 'Stopping app' );
	}

	module.exports.launchDevice    = launchDevice;
	module.exports.terminateDevice = terminateDevice;
	module.exports.launchApp       = launchApp;
	module.exports.terminateApp    = terminateApp;

})();
