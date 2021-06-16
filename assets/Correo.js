
$(document).ready(function()
{
	$(function() {
        $('#InputCorreo').on('keypress', function(e) {
            if (e.which == 32){
                //console.log('Space Detected');
                return false;
            }
        });
    });
});
	

