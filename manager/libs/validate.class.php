<?php
require_once( 'generics.class.php' );

class Validate extends Generic
{
    function __construct()
    {
        parent::__construct();

        //
        if ( isset( $_POST['username'] ) ) {

            $this->checkExitedUser( $_POST['username'] );
        }

        if ( isset( $_POST['email'] ) ) {

            $this->checkExitedEmail( $_POST['email'] );
        }
    }

    function checkExitedUser( $username )
    {
        $sth = $this->db->query("SELECT username FROM users WHERE username = '$username'");

        $count = $this->db->numrows($sth);

        if ($count > 0) {
            echo 1; // username already existed
        } else
            echo 0;
    }

    function checkExitedEmail( $email )
    {
        $sth = $this->db->query("SELECT email FROM users WHERE email = '$email'");

        $count = $this->db->numrows($sth);

        if ($count > 0) {
            echo 1; // username already existed
        } else
            echo 0;
    }
}

$validation = new Validate();