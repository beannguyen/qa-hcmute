<?php
require_once( 'libs/urls.class.php' );
require_once( '../config.php' );

// Start the session. Important.
if (!isset($_SESSION)) session_start();

/**
 * Begin removing their existence.
 *
 * Good bye friend :(. Promise you'll come back?!
 */
if (isset($_SESSION['ithcmute']['username'])) :
    session_unset();
    session_destroy();
endif;

/** Voila! Here we shall gently nudge them somewhere else. */
URL::redirect_to( BASE_PATH );
exit();