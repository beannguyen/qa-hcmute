<?php
require( 'generics.class.php' );
class Login extends Generic
{
    protected $db;
    private $user;
    private $pass;
    private $token;
    public $error;
    private $result;

    function __construct()
    {
        parent::__construct();

        // if you are logged
        if ( parent::guestOnly() ) { // Only user can view this page

            URL::redirect_to( BASE_PATH .'manager' );
            exit();
        }

        // general token
        parent::generateToken();

        // if user login
        if ( isset( $_POST['login'] ) ) {

            $this->user = parent::secure($_POST['username']);
            $this->pass = parent::secure($_POST['password']);

            $this->token = !empty($_POST['token']) ? $_POST['token'] : '';
            $processCheck = $this->process($this->user, $this->pass, $this->token);
            if( $processCheck == 'invalid_token' || $processCheck == 'error_found' || $processCheck == 'incorrect_password' || $processCheck == 'banned_user' || $processCheck == 'disable-login')
            {
                $this->error = $processCheck;
            }
        }
    }

    function process( $user, $pass, $token )
    {
        $this->user = $user;
        $this->pass = $pass;
        $this->token = $token;

        // Check that the token is valid, prevents exploits
        if(!parent::valid_token($this->token)) {
            return 'invalid_token';
        }


        // Confirm all details are correct and fetch result
        $valid = $this->validate();
        if($valid == 1)
        {
            // Log the user in
            $result = $this->login();
            return $result;
        } else
        {
            return $valid;
        }
    }

    private function validate() {

        if(!empty($this->error)) return 'error_found';

        $stmt = $this->db->query("SELECT * FROM users WHERE username = '$this->user'");
        if( $this->db->numrows($stmt) == 1 )
        {
            $this->result = $this->db->fetch( $stmt );

            if( parent::getOption( 'disable-logins-enable' ) == '1' && $this->result['user_id'] !== '1' ) {

                return 'disable-login';
            } elseif ( $this->result['restricted'] == 1) {

                return 'banned_user';
            } elseif ( !parent::validatePassword( $this->pass, $this->result['password'] ) ) {

                return 'incorrect_password';
            }
        } else
            return 'incorrect_password';

        return 1;
    }

    // Once everything's filled out
    public function login() {

        // Just double check there are no errors first
        if( !empty($this->error) ) return 'error_found';

        // Session expiration
        $minutes = parent::getOption('default_session');
        ini_set('session.cookie_lifetime', 60 * $minutes);

        session_regenerate_id();

        // Save if user is restricted
        if ( !empty($this->result['restricted']) ) $_SESSION['ithcmute']['restricted'] = 1;

        // Save user's current level

        $_SESSION['ithcmute']['email'] = $this->result['email'];

        $_SESSION['ithcmute']['gravatar'] = parent::get_gravatar($this->result['email'], true, 26);

        // Stay signed via checkbox?
        if( isset( $_POST['remember'] ) ) {
            ini_set('session.cookie_lifetime', 60*60*24*100); // Set to expire in 3 months & 10 days
            session_regenerate_id();
        }

        // And our magic happens here ! Let's sign them in
        $_SESSION['ithcmute']['username'] = $this->result['username'];

        // User ID of the logging in user
        $_SESSION['ithcmute']['user_id'] = $this->result['user_id'];

        if ( isset ( $_SESSION['ithcmute']['referer'] ) )
            $redirect = $_SESSION['ithcmute']['referer'];
        else
            $redirect = getenv('HTTP_REFERER') ? getenv('HTTP_REFERER') : BASE_PATH . '/manager';

        unset(
        $_SESSION['ithcmute']['referer'],
        $_SESSION['ithcmute']['token'],
        $_SESSION['ithcmute']['facebookMisc'],
        $_SESSION['ithcmute']['twitterMisc'],
        $_SESSION['ithcmute']['openIDMisc']
        );

        // Redirect after it's all said and done
        URL::redirect_to( $redirect );
        exit();

    }
}