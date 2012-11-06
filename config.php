<?php

/*
 * Welcome to HTML Slides config file!
 * Just setup this simple options, upload the folder to a server and you will be good to go.
 */

// Basic settings
$slides_title = "My first html slides";
$slides_description = "This is a description of my slides in no more than one line";

// Display settings
$background_color = "#000";
$text_color = "#fff";
$slide_size = "cover"; /* contain or cover | contain to fit image inside screen (letterbox may occur), cover to fill screen with image (cropping may occur)*/

// Slideshow settings
$cycle = "true"; /* Back to first image after reaching the last one either true or false*/
$duration = "0"; /* Duration of the scrolling between slides in miliseconds, 0 for instant slide change */
$interval = "false"; /* Interval between automatic slide change in miliseconds, set 0 to disable auto advance */

// Soundtrack settings
$soundtrack_play = "true"; // Set to false if you don't wan't sound along with your slides

// Video settings
/* An array containing desired position within slideshow and video URLs  */

$videos = array(
    // "2" => "http://www.youtube.com/watch?v=MejbOFk7H6c", /* You can add all videos you want in the positions you like. There can not be more videos than images or they won't show up. */
    // "5" => "http://vimeo.com/36160341",
    // "6" => "http://www.youtube.com/watch?v=MejbOFk7H6c",
    // "10" => "http://vimeo.com/36160348",
);

// Advanced settings
$google_analytics_id = "UA-XXXXX-X";
$sounds_folder = "audio";
$images_folder = "img";
$lang = "en";