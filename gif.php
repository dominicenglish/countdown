<?php
date_default_timezone_set('Australia/Brisbane');
include 'GIFEncoder.class.php';


function countdown($date, $duration, $backgroundPath=false, $font=false) {
  if (!$backgroundPath) { $backgroundPath = dirname( __FILE__)  . '/countdown.png'; }
  $backgroundImage = imagecreatefrompng($backgroundPath);

  if (!font) {
    $font = array(
  		'size'=>40,
  		'angle'=>0,
  		'x-offset'=>10,
  		'y-offset'=>70,
  		'file'=>dirname( __FILE__ ) . '/GothamMedium.ttf',
  		'color'=>imagecolorallocate($backgroundImage, 255, 255, 255),
  	);
  }

	$now = new DateTime(date('r', time()));
  $delay = 100; // milliseconds
  $frames = array();
  $delays = array();

  // Just draw 00:00:00:00 if expired
  if ($future_date < $now) {
    $frame = cloneImage($backgroundImage);
    $text = $interval->format('00:00:00:00');
    imagettftext ($frame , $font['size'] , $font['angle'] , $font['x-offset'] , $font['y-offset'] , $font['color'] , $font['file'], $text );
    ob_start();
    imagegif($frame);
    $frames[]=ob_get_contents();
    $delays[]=$delay;
    $loops = 1;
    ob_end_clean();
  }

  // Else draw a frame for each second ($duration)
  else {
  	for($i = 0; $i <= $duration; $i++){
      // Calculate time left
  		$interval = date_diff($future_date, $now);
      $frame = cloneImage($backgroundImage);
			$text = $interval->format('%D:%H:%I:%S');
			imagettftext ($frame , $font['size'] , $font['angle'] , $font['x-offset'] , $font['y-offset'] , $font['color'] , $font['file'], $text );
			ob_start();
			imagegif($frame);
			$frames[]=ob_get_contents();
			$delays[]=$delay;
	    $loops = 0;
			ob_end_clean();

      // Increase time for next frame
  		$now->modify('+1 second');
  	}
  }

  // Compose frames into an animated gif
	$gif = new AnimatedGif($frames, $delays, $loops);
	return $gif;
}

// Doesn't seem to be a way to actually clone a GD resource...
function cloneImage($img){
  // Get dimensions
  $w = imagesx($img);
  $h = imagesy($img);
  // Create blank image of same dimensions
  $copy = imagecreatetruecolor($w, $h);
  // Copy image data to new image
  imagecopy($copy, $img, 0, 0, 0, 0, $w, $h);

  return $copy;
}
