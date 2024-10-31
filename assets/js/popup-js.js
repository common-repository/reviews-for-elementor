function catapultAcceptCookies() {
	//catapultSetCookie('euCookiePolicy', ecp_vars.version, ecp_vars.expiry);
	jQuery("html").removeClass('has-cookie-bar');
	jQuery("html").css("margin-top","0");
	jQuery("#catapult-cookie-bar").fadeOut();
}
// The function called by the timer
function cpoCloseNotification() {
		catapultAcceptCookies();
}
// The function called if first page only is specified
function cpoFirstPage() {
	if ( ecp_vars.method ) {
		//catapultSetCookie('euCookiePolicy', ecp_vars.version, ecp_vars.expiry);
	}
}
jQuery(document).ready(function($){
	$('.x_close').on('click', function(){
		catapultAcceptCookies();
	});
});
