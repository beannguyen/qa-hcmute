<?php
/**
 * Runs several checks against the user before allowing access to a page.
 */

class Check extends Generic {

    function __construct($forceLogin = true) {

        parent::__construct();
        $this->isGuest($forceLogin);
        $this->isRestricted();
    }

    /**
     * * Checks whether or not the user has logged in.
     *
     * If the user is not logged in, we will store the page the user
     * is coming from and redirect the user later after logging in.
     * @param $forceLogin
     * @return bool
     */
    private function isGuest( $forceLogin ) {

        if ( !$forceLogin )
            return empty( $_SESSION['ithcmute']['user_id'] );

        if ( empty($_SESSION['ithcmute']['user_id']) ) :

            // IIS compatibility
            // http://davidwalsh.name/iis-php-server-request_uri
            if (!isset($_SERVER['REQUEST_URI'])) {
                $_SERVER['REQUEST_URI'] = substr($_SERVER['PHP_SELF'],1 );
                if (isset($_SERVER['QUERY_STRING'])) { $_SERVER['REQUEST_URI'].='?'.$_SERVER['QUERY_STRING']; }
            }

            $_SESSION['ithcmute']['referer'] = $_SERVER['REQUEST_URI'];

            $page = parent::getOption('guest-redirect');
            URL::redirect_to( $page );
            exit();

        endif;

    }

    /**
     * Checks if the user's account is restricted.
     *
     * The user is redirected to disabled.php if the account is restricted.
     */
    private function isRestricted() {

        if ( !empty($_SESSION['ithcmute']['restricted']) || !empty($_SESSION['ithcmute']['level_disabled']) ) :
            header('Location: '. URL::get_site_url() . '/userDisable');
            exit();
        endif;

    }

}