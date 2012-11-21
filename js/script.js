/* Author: Anabelle Handdoek */
jQuery(document).ready(function($) {
	// Videos
	$('.videolink').asyncml();

	// Main function call to seriallscroll is in index.php to allow for php config

	$('.slide:not(.video)').click(function(){
		$('#slideshow').trigger( 'next' );
	})

	// mousewheel
	$(window).mousewheel(function(event,delta)
	{
		event.preventDefault();
		if(delta < 0){
			$('#slideshow').trigger( 'next' );
		}else{
			$('#slideshow').trigger( 'prev' );
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
	var checkTime = 0;

	$(document).bind("keydown", function (event) {
		// left = 37
		// right = 39
		// up = 38
		// down = 40
		if(p == 40 || p == 38)
		{
			event.preventDefault();
		}

		var p = event.keyCode;
		if(p == 40 || p == 38 || p == 37 || p == 39)
		{
			event.preventDefault();
			var currentTime = new Date();

			if((currentTime.getTime() - checkTime) > 42){

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

				checkTime = currentTime.getTime();
			}
		}
	});

});