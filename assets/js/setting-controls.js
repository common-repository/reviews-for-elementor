jQuery( document ).ready(function() {
	setTimeout(function(){ 
	console.log(jQuery( "#elementor-panel-footer-tools" ));
	console.log(jQuery( "#elementor-panel" ));
	jQuery( "#elementor-panel-footer-tools" ).click(function() {
  		alert( "Handler for .click() called." );
	});
		}, 30000);
});