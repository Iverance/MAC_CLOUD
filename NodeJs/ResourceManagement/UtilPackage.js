( function() {

	function handleResponse( err, res, validResponse ){
		if( err ){
			res.send( "-1" );
		        console.log( err );
		}else{
		        res.send( "" + validResponse );
		}
	}

	module.exports.handleResponse = handleResponse;

})();
