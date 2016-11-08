<?php
require( dirname( __FILE__ ) . '/wp-blog-header.php' );
require( dirname( __FILE__ ) . '/countdown-clock/gif.php' );

// futureDate=2016-11-04T15:00:00%2b09&duration=60
if ($_GET) {

  // Max gif duration in seconds
	$max_duration = 120;
	// Default gif duration in seconds
	$default_duration = 60;

	// The date we are counting down to
  $future_date_input = $_GET['futureDate'];
	// The number of seconds to put in the gif;
  $duration_input = +$_GET['duration'];

  $backgroundPath = dirname( __FILE__)  . '/countdown.png';

	$future_date = new DateTime(date('r',strtotime($future_date_input)));
	if (!$duration_input) {
		$duration = $default_duration;
	} else if ($duration_input > $max_duration) {
		$duration = $max_duration;
	} else {
		$duration = $duration_input;
	}


  $gif = generate();

  header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' );
	header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
	header( 'Cache-Control: no-store, no-cache, must-revalidate' );
	header( 'Cache-Control: post-check=0, pre-check=0', false );
	header( 'Pragma: no-cache' );
  $gif->display();
} else {
  ?>
<html>
  <body>
    <form action='' method='get'>
      <input type='text' name='date'/>
      <input type='text' name='time'/>
      <input type='text' name='timezone'/>
      <select></select>
      <button type='submit'>Generate Countdown Code</button>
    </form>
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js"
      integrity="sha256-/SIrNqv8h6QGKDuNoLGA4iret+kyesCkHGzVUUV0shc="
      crossorigin="anonymous"></script>
    <script src='./timezones.js'/>
    <script>
      $('select').timezones();
    </script>
  </body>
</html>
  <?php
};
?>
