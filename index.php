<!doctype html>
<?php require_once('config.php'); ?>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="<?php echo $lang; ?>"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="<?php echo $lang; ?>"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="<?php echo $lang; ?>"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="<?php echo $lang; ?>"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title><?php echo $slides_title; ?></title>
  <meta name="description" content="<?php echo $slides_description; ?>">

  <meta name="viewport" content="width=device-width">
  <link rel="stylesheet" href="css/style.css">
  <style>
    a {
      color:<?php echo $text_color; ?>;
    }
    body {
      background-color:<?php echo $background_color; ?>;
      color:<?php echo $text_color; ?>;
    }

    .slide {
        -webkit-background-size:<?php echo $slide_size; ?>;
        -moz-background-size:<?php echo $slide_size; ?>;
        background-size:<?php echo $slide_size; ?>;
    }
  </style>

  <script src="js/libs/modernizr-2.5.3.min.js"></script>
</head>
<body>
  <!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->
  <header>
    <h1 class="visuallyhidden"><?php echo $slides_title; ?></h1>
    <h2 class="visuallyhidden"><?php echo $slides_description; ?></h2>
  </header>

  <div id="container" role="main">
    <ul id="slideshow">
    <?php
        $img_dir = opendir($images_folder);

        while($file_name = readdir($img_dir)) {
          $img_array[] = $file_name;
        }

        closedir($img_dir);

        sort($img_array);

        $count = count($img_array);
        $img_count = 0;
        $hash = md5($count);

        for($index=0; $index < $count; $index++) {
          $extension = substr($img_array[$index], -3);
          if ($extension == 'jpg' || $extension == 'png' || $extension == 'gif'){
            if($videos[$img_count+1]){
              echo '<li class="slide video" id="s'.$img_count.$hash.'"><a class="videolink" href="'.$videos[$img_count+1].'" target="_blank">Video '.($img_count+1).'</a></li>'.PHP_EOL;
            }
              echo '<li class="slide" id="s'.$img_count.$hash.'"><img class="visuallyhidden" src="g.gif" data-original="' . $images_folder . '/' . $img_array[$index] . '" alt="" /></li>'.PHP_EOL;
            $img_count++;
          } 
        }

        if( $img_count == 0 ){
          echo ("<h2>Oops! No images found</h2>".PHP_EOL."<h3>Go ahead and add some files to the images folder</h3>");
        }
    ?>
    </ul>

    <?php if( $soundtrack_play == true ){ ?>
    <ul id="soundtrack">
    <?php 
      $audio_dir  = opendir($sounds_folder);

      while($audio_file_name = readdir($audio_dir)) {
        $audio_array[] = $audio_file_name;
      }

      closedir($sounds_folder);

      sort($audio_array);

      $audio_count = count($audio_array);
      $audio_int_count = 0;

      for($index=0; $index < $audio_count; $index++) {
        $extension = substr($audio_array[$index], -3);
        if ($extension == 'mp3'){
          $audios_mp3[] = $audio_array[$index];
        }elseif ($extension == 'ogg') {
          $audios_ogg[] = $audio_array[$index];
        }
        $audio_int_count++;
      }

      $mp3_count = count($audios_mp3);
      $ogg_count = count($audios_ogg);

      for($index=0; $index < $mp3_count && $index < $ogg_count; $index++) {
      ?>

        <audio controls preload="auto" id="audio-<?php echo $index; ?>">
          <source src="<?php echo $sounds_folder; ?>/<?php echo $audios_mp3[$index]; ?>" controls></source>
          <source src="<?php echo $sounds_folder; ?>/<?php echo $audios_ogg[$index]; ?>" controls></source>
          Tu navegador no soporta audio.
        </audio>

      <?php
      }

    ?>
    </ul>
    <?php } ?>

  </div>

  <footer>

  </footer>

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.1.min.js"><\/script>')</script>

  <script src="js/plugins.js"></script>

  <script>
    jQuery(document).ready(function($) {
      hashname = window.location.hash;
      elem = hashname.substring(0, hashname.length-1);

      var start = 0; 

      function loadImage( elem ){
        var original = $(elem).find('img').data('original');
        $('<img/>').attr('src', original).load(function() {
          $(elem).css('background-image', 'url('+original+')').addClass('loaded');
          if( $(elem).next( '.slide:not(.loaded)' ).length > 0 ){
            loadImage( $(elem).next( '.slide') );
            //console.log('next');
          }else if( $(elem).prev( '.loaded').length > 0 ){
            loadImage( $(elem).prev() );
            //console.log('backflip');
          }else if( $(elem).prev( '.slide:not(.loaded)' ).length > 0 ){
            loadImage( $(elem).prev( '.slide') );
            //console.log('prev');
          }
        });
      }

      if(elem) {
         $('#slideshow').scrollTo(elem, 0);
         start = $(elem).index();
         loadImage( elem );
         
      }else{
        var elem = $('.slide:first-child');
        loadImage( elem );
      }

      $('#slideshow').serialScroll({
        axis: 'y',
        start: start,
        cycle: <?php echo $cycle; ?>,
        easing: 'easeInOutExpo',
        items: '.slide',
        onAfter: function(elem){ 
          window.location.hash = $(elem).attr('id')+1;
          var index = $(elem).index();
          loadImage( elem );
          $('#soundtrack audio:eq('+index+')').addClass("play");
          <?php if($callback){
            echo( $callback );
          } ?>
        },
        onBefore: function(  e, elem, $pane, $items, pos ) {
          if( $('#slideshow .slide:eq('+pos+')').hasClass( 'loaded' ) ) {
            return true;
          }else{
            loadImage( elem );
            return false;
          }
        },
        duration: <?php echo $duration; ?><?php if($interval != "false"){ ?>,
        interval: <?php echo $interval; ?>,
        force: true <?php } ?>
      });
    });
  </script>
  <script src="js/script.js"></script>

  <?php if($google_analytics_id != "UA-XXXXX-X"){ ?>
  <script>
    var _gaq=[['_setAccount','<?php echo $google_analytics_id; ?>'],['_trackPageview']];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));
  </script>
  <?php } ?>

</body>
</html>