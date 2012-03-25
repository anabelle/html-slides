/* Author: Anabelle Handdoek */
jQuery(document).ready(function($) {
	// Main function call to seriallscroll is in index.php to allow for php config

	$('.slide').click(function(){
		$('#slideshow').trigger( 'next' );
	})

	// mousewheel
	$(window).mousewheel(function(event,delta)
	{
		event.preventDefault();
		if(delta < 0){
			$('#slideshow').trigger( 'next' );
			console.log(delta);
		}else{
			$('#slideshow').trigger( 'prev' );
			console.log(delta);
		}
	});

	// keyboard
	$(document).bind("keydown", function (event) {
		var p = event.keyCode;
		if(p == 40 || p == 38)
		{
			event.preventDefault();
		}
	});
	$(document).bind("keyup", function (event) {
		// left = 37
		// right = 39
		// up = 38
		// down = 40
		var p = event.keyCode;
		if(p == 40 || p == 38 || p == 37 || p == 39)
		{
			event.preventDefault();
			switch(p)
			{
				case 40:
					// down
					$('#slideshow').trigger( 'next' );
					break;
				case 38:
					//up
					$('#slideshow').trigger( 'prev' );
					break;
				case 37:
					// left
					$('#slideshow').trigger( 'prev' );
					break;
				case 39:
					// right
					$('#slideshow').trigger( 'next' );
					break;
			}
		}
	});
});