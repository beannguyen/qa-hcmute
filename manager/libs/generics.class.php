<?php
/**
 * Generic functions used throughout the user control script.
 *
 */

include_once("times.class.php");
require_once('urls.class.php');
require('connects.class.php');

class Generic extends Connect
{
    private $error;
    protected $db;

    function __construct()
    {

        // Start the session. Important.
        if (!isset($_SESSION)) session_start();

        // Call the connection
        $this->db = parent::dbObj();
        $this->db->connect();

        $this->definePaths();

        // Check if an upgrade is required
        //if(empty($this->error)) include_once( 'upgrade.class.php' );

        // Check for any errors and quit if there are
        $this->displayMessage($this->error);

    }

    /**
     * Returns a mySQL query.
     *
     * @param     string $query An SQL statement.
     * @param     array $params The binded variables to an SQL statement.
     * @return    resource    Returns the query's execution.
     */
    public function query($query)
    {

        $stmt = $this->db->query($query);
        return $stmt;

    }

    /**
     * @param $option string Name of option to retrieve.
     * @param bool $check Whether the option is a checkbox.
     * @param bool $profile Whether to return a profile field, or an admin setting.
     * @param string $id Required if profile is true; the user_id of a user.
     * @return bool|string
     */
    public function getOption($option, $check = false, $profile = false, $id = '')
    {

        if (empty($option)) return false;

        $option = trim($option);

        if ($profile) {
            $sql = "SELECT `meta_value` FROM `user_meta` WHERE `meta_key` = '$option' AND `user_id` = $id LIMIT 1;";
        } else {
            $sql = "SELECT option_value FROM options WHERE option_key = '" . $option . "' LIMIT 1;";
        }

        $stmt = $this->db->query($sql);

        if (!$stmt) return false;

        $result = $this->db->fetch($stmt);

        if ($result == NULL)
            return false;
        elseif ($profile)
            $res = $result['meta_value'];
        else
            $res = $result['option_value'];

        if ($check)
            $res = ($res == "1") ? 'checked="checked"' : '';

        return $res;

    }

    /**
     * Updates an option in the database.
     *
     * If an option exists in the database, it will be updated. If it does not exist,
     * the option will be created.
     *
     * @param $option
     * @param $newvalue
     * @param bool $profile
     * @param string $id
     * @return bool|id|query_id
     */
    public function updateOption($option, $newvalue, $profile = false, $id = '')
    {

        $option = trim($option);
        if (empty($option) || !isset($newvalue))
            return false;


        //$oldvalue = $profile ? $this->getOption($option, false, true, false, $id)
        //    : $this->getOption($option);
        if ($profile)
            $oldvalue = $this->getOption($option, false, true, false, $id);
        else
            $oldvalue = $this->getOption($option);

        if ($newvalue === $oldvalue)
            return false;

        if (false === $oldvalue) :

            if ($profile) {
                $params = array(
                    'user_id' => $id,
                    'meta_key' => $option,
                    'meta_value' => is_array($newvalue) ? serialize($newvalue) : $newvalue
                );
                $table = 'members_meta';
            } else {
                $params = array(
                    'option_key' => $option,
                    'option_value' => is_array($newvalue) ? serialize($newvalue) : $newvalue
                );
                $table = 'options';
            }

            return $this->db->insert($table, $params);
        endif;

        if ($profile) {
            $params = array(
                'meta_value' => is_array($newvalue) ? serialize($newvalue) : $newvalue
            );

            $table = 'user_meta';
            $where = "`meta_key` = '$option' AND `user_id` = $id";
        } else {
            $params = array(
                'option_value' => is_array($newvalue) ? serialize($newvalue) : $newvalue
            );
            $table = 'options';
            $where = "`option_key` = '$option'";
        }

        return $this->db->update($table, $params, $where);

    }

    /**
     * Sanitizes titles intended for SQL queries.
     *
     * Specifically, HTML and PHP tag are stripped. The return value
     * is not intended as a human-readable title.
     *
     * @param     string $title The string to be sanitized.
     * @return    string    The sanitized title.
     */
    public function sanitize_title($title)
    {

        $title = strtolower($title);
        $title = preg_replace('/&.+?;/', '', $title); // kill entities
        $title = str_replace('.', '-', $title);
        $title = preg_replace('/[^%a-z0-9 _-]/', '', $title);
        $title = preg_replace('/\s+/', '-', $title);
        $title = preg_replace('|-+|', '-', $title);
        $title = trim($title, '-');

        return $title;

    }

    /**
     * Sends HTML emails with optional shortcodes.
     *
     * @param     string $to Receiver of the mail.
     * @param     string $subj Subject of the email.
     * @param     string $msg Message to be sent.
     * @param     array $shortcodes Shortcode values to replace.
     * @param     bool $bcc Whether to send the email using Bcc: rather than To:
     *                                     Useful when sending to multiple recepients.
     * @return    bool      Whether the mail was sent or not.
     */
    public function sendEmail($to, $subj, $msg, $shortcodes = '')
    {

        if (!empty($shortcodes) && is_array($shortcodes)) :

            foreach ($shortcodes as $code => $value)
                $msg = str_replace('{{' . $code . '}}', $value, $msg);

        endif;

        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf8' . "\r\n";
        $headers .= 'From: ' . $this->getOption('admin_email') . "\r\n";
        $headers .= 'Reply-To: ' . $this->getOption('admin_email') . "\r\n";


        $sender = new Mailer();
        $subj = "=?utf-8?b?" . base64_encode($subj) . "?=";

        return $sender->send($to, $subj, $msg, $headers);
    }

    /**
     * Checks if a user has access to view their own access log
     *
     * @return    bool    Whether the user can view access logs or not
     */
    public function denyAccessLogs()
    {

        return (($this->getOption('profile-timestamps-admin-enable') && !in_array(1, $_SESSION['ithcmute']['user_level'])) || !$this->getOption('profile-timestamps-enable'));

    }

    /** Generates the access logs for a particular user in table format */
    public function generateAccessLogs()
    {

        $user_id = $this->getField('user_id');

        $sql = "SELECT `ip`, `timestamp` FROM `" . DB_PRE . "login_timestamps` WHERE `user_id` = $user_id ORDER BY `timestamp` DESC LIMIT 0,10";
        $stmt = $this->query($sql);

        ?>
        <table class="table table-condensed span6">
            <thead>
            <tr>
                <th><?php _e('Last Login'); ?></th>
                <th><?php _e('Location'); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php if ($stmt->rowCount() > 0) : ?>
                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
                    <tr>
                        <td><?php echo date('M d, Y', strtotime($row['timestamp'])) . ' ' . _('at') . ' ' . date('h:i a', strtotime($row['timestamp'])); ?></td>
                        <td><?php echo $row['ip']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else : ?>
                <tr>
                    <td><?php _e('Has not logged in yet'); ?></td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    <?php

    }

    /**
     *
     */
    public function randomPassword()
    {
        $alpha = "abcdefghijklmnopqrstuvwxyz";
        $alpha_upper = strtoupper($alpha);
        $numeric = "0123456789";
        $special = ".-+=_,!@$#*%<>[]{}";
        $chars = "";

        if (isset($_POST['length'])){
            // if you want a form like above
            if (isset($_POST['alpha']) && $_POST['alpha'] == 'on')
                $chars .= $alpha;

            if (isset($_POST['alpha_upper']) && $_POST['alpha_upper'] == 'on')
                $chars .= $alpha_upper;

            if (isset($_POST['numeric']) && $_POST['numeric'] == 'on')
                $chars .= $numeric;

            if (isset($_POST['special']) && $_POST['special'] == 'on')
                $chars .= $special;

            $length = $_POST['length'];
        }else{
            // default [a-zA-Z0-9]{9}
            $chars = $alpha . $alpha_upper . $numeric;
            $length = 9;
        }

        $len = strlen($chars);
        $pw = '';

        for ($i=0;$i<$length;$i++)
            $pw .= substr($chars, rand(0, $len-1), 1);

        // the finished password
        $pw = str_shuffle($pw);

        // Password is stored in `$pw`
        return $pw;
    }

    /**
     * Only allows guests to view page.
     *
     * A logged in user will be shown an error and denied from viewing the page.
     */
    public function guestOnly()
    {

        if (!empty($_SESSION['ithcmute']['username'])) {
            return true;
        }
        return false;
    }

    /**
     * Generates a unique token.
     *
     * Intended for form validation to prevent exploit attempts.
     */
    public function generateToken()
    {

        if (empty($_SESSION['ithcmute']['token']))
            $_SESSION['ithcmute']['token'] = md5(uniqid(mt_rand(), true));

    }

    /**
     * Prevents invalid form submission attempts.
     *
     * @param     string $token The POST token with a form.
     * @return    bool      Whether the token is valid.
     */
    public function valid_token($token)
    {

        if (empty($_SESSION['ithcmute']['token']))
            return false;

        if ($_SESSION['ithcmute']['token'] != $token)
            return false;

        return true;

    }

    /**
     * Validates an email address.
     *
     * @param     string $email The email address.
     * @return    bool      Whether the email address is valid or not.
     */
    public function isEmail($email)
    {

        if (!empty($email))
            $email = (string)$email;
        else
            return false;

        return (preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i", $email));
    }

    /**
     * ss any string intended for SQL execution.
     *
     * @param     string $string
     * @return    string    The secured value string.
     */
    public function secure($string)
    {

        // Because some servers still use magic quotes
        if (get_magic_quotes_gpc()) :

            if (!is_array($string)) :
                $string = htmlspecialchars(stripslashes(trim($string)));
            else :
                foreach ($string as $key => $value) :
                    $string[$key] = htmlspecialchars(stripslashes(trim($value)));
                endforeach;
            endif;

            return $string;

        endif;


        if (!is_array($string)) :
            $string = htmlspecialchars(trim($string));
        else :
            foreach ($string as $key => $value) :
                $string[$key] = htmlspecialchars(trim($value));
            endforeach;
        endif;

        return $string;

    }

    /**
     * Get either a Gravatar URL or complete image tag for a specified email address.
     *
     * @param string $email The email address
     * @param string $s Size in pixels, defaults to 80px [ 1 - 512 ]
     * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
     * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
     * @param boole $img True to return a complete IMG tag False for just the URL
     * @param array $atts Optional, additional key/value attributes to include in the IMG tag
     * @return String containing either just a URL or a complete image tag
     * @source http://gravatar.com/site/implement/images/php/
     */
    public function get_gravatar($email, $img = false, $s = 80, $d = 'mm', $r = 'g', $atts = array())
    {
        $http = (!empty($_SERVER['HTTPS'])) ? 'https://' : 'http://';
        $url = $http . 'gravatar.com/avatar/';
        $url .= md5(strtolower(trim($email)));
        $url .= "?s=$s&d=$d&r=$r";
        if ($img) {
            $url = '<img class="gravatar thumbnail" src="' . $url . '"';
            foreach ($atts as $key => $val)
                $url .= ' ' . $key . '="' . $val . '"';
            $url .= ' />';
        }
        return $url;
    }

    /**
     * Defines variables used throughout the script.
     *
     * Definitions:
     * cINC                   The current directory, whether /admin/ or root.
     * address                Administrator's email address.
     * SITE_PATH              Should be set with a trailing slash, where userActivate.php is located.
     * phplogin_db_version    The current script's database version.
     *                        Used for keeping track of necessary db updates.
     *                        Follows format - Year : Month : Day : Revision.
     * phplogin_version       Core version of the script.
     */
    public function definePaths()
    {

        if (!defined('cINC')) define('cINC', dirname($_SERVER['SCRIPT_FILENAME']) . '/');
        //if (!defined('address'))                define( 'address',             $this->getOption('admin_email') );
        //if (!defined('SITE_PATH'))              define( 'SITE_PATH',           $this->getOption('site_address') );

    }

    /**
     * Hashes a password for either MD5 or SHA256.
     *
     * If hashing SHA256, a unique salt will be hashed with it.
     *
     * @param     string $password A plain-text password.
     * @return    string    Hashed password.
     */
    public function hashPassword($password)
    {

        $type = $this->getOption('pw-encryption');

        // Checks if the pw should be MD5, if so, don't continue
        if ($type == 'MD5') return md5($password);

        $salt = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
        $hash = hash($type, $salt . $password);
        $final = $salt . $hash;

        return $final;

    }

    /**
     * Finds the current IP address of a visiting user.
     *
     * @return    string    The IP address
     */
    public function getIPAddress()
    {

        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) :
            $ipAddress = $_SERVER["HTTP_X_FORWARDED_FOR"];
        else :
            $ipAddress = isset($_SERVER["HTTP_CLIENT_IP"]) ? $_SERVER["HTTP_CLIENT_IP"] : $_SERVER["REMOTE_ADDR"];
        endif;

        return $ipAddress;
    }

    /**
     * Validates a password.
     *
     * A plain-text password is compared against the hashed version.
     *
     * @param     string $password A plain-text password.
     * @param     string $correctHash The hashed version of a correct password.
     * @return    bool      Whether or not the plain-text matches the correct hash.
     */
    public function validatePassword($password, $correctHash)
    {

        $type = $this->getOption('pw-encryption');

        $password = (string)$password;

        // Checks if the password is MD5 and return
        if (strlen($correctHash) == 32)
            return md5($password) === $correctHash;
        else $type = 'SHA256';

        // Continue testing the hash against the salt
        $salt = substr($correctHash, 0, 64);
        $validHash = substr($correctHash, 64, 64);

        $testHash = hash($type, $salt . $password);

        return $testHash === $validHash;

    }

    /**
     * Displays an error and optionally quits the script.
     *
     * @param     string $error The error message to display.
     * @param     bool $exit Whether to exit after the error and prevent the
     *                                page from loading any further.
     */
    public function displayMessage($error, $exit = true)
    {

        if (!empty($error)) :
            // The error itself
            //$url = URL::get_site_url()."/error/errHandler/".$error;
            //URL::redirect_to($url);

            return ($error);
        endif;
    }

    public function vietnamese_permalink($title, $search = false)
    {
        /* 	Replace with "-"
            Change it if you want
        */

        if ( $search )
            $replacement = ' ';
        else
            $replacement = '-';
        $map = array();
        $quotedReplacement = preg_quote($replacement, '/');

        $default = array(
            '/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ|À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ|å/' => 'a',
            '/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ|È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ|ë/' => 'e',
            '/ì|í|ị|ỉ|ĩ|Ì|Í|Ị|Ỉ|Ĩ|î/' => 'i',
            '/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ|Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ|ø/' => 'o',
            '/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ|Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ|ů|û/' => 'u',
            '/ỳ|ý|ỵ|ỷ|ỹ|Ỳ|Ý|Ỵ|Ỷ|Ỹ/' => 'y',
            '/đ|Đ/' => 'd',
            '/ç/' => 'c',
            '/ñ/' => 'n',
            '/ä|æ/' => 'ae',
            '/ö/' => 'oe',
            '/ü/' => 'ue',
            '/Ä/' => 'Ae',
            '/Ü/' => 'Ue',
            '/Ö/' => 'Oe',
            '/ß/' => 'ss',
            '/[^\s\p{Ll}\p{Lm}\p{Lo}\p{Lt}\p{Lu}\p{Nd}]/mu' => ' ',
            '/\\s+/' => $replacement,
            sprintf('/^[%s]+|[%s]+$/', $quotedReplacement, $quotedReplacement) => '',
        );
        //Some URL was encode, decode first
        $title = urldecode($title);

        $map = array_merge($map, $default);
        return strtolower(preg_replace(array_keys($map), array_values($map), $title));
        #---------------------------------o
    }

    /**
     * Makes directory and returns BOOL(TRUE) if exists OR made.
     *
     * @param  $path Path name
     * @return bool
     */
    function rmkdir($path, $mode = 0755)
    {
        $path = rtrim(preg_replace(array("/\\\\/", "/\/{2,}/"), "/", $path), "/");
        $e = explode("/", ltrim($path, "/"));
        if (substr($path, 0, 1) == "/") {
            $e[0] = "/" . $e[0];
        }
        $c = count($e);
        $cp = $e[0];
        for ($i = 1; $i < $c; $i++) {
            if (!is_dir($cp) && !@mkdir($cp, $mode)) {
                return false;
            }
            $cp .= "/" . $e[$i];
        }
        return @mkdir($path, $mode);
    }

    function split_words($string, $nb_caracs, $separator)
    {
        $string = strip_tags(html_entity_decode($string));
        if (strlen($string) <= $nb_caracs) {
            $final_string = $string;
        } else {
            $final_string = "";
            $words = explode(" ", $string);
            foreach ($words as $value) {
                if (strlen($final_string . " " . $value) < $nb_caracs) {
                    if (!empty($final_string)) $final_string .= " ";
                    $final_string .= $value;
                } else {
                    break;
                }
            }
            $final_string .= $separator;
        }
        return $final_string;
    }

    function post_permalink($postId)
    {
        $sql = "SELECT " . DB_PRE . "posts.post_name, " . DB_PRE . "terms.slug
                FROM " . DB_PRE . "posts, " . DB_PRE . "terms, " . DB_PRE . "term_taxonomy, " . DB_PRE . "term_relationships
                WHERE " . DB_PRE . "term_relationships.object_id = " . $postId . " AND " . DB_PRE . "term_taxonomy.taxonomy = 'category' AND " . DB_PRE . "term_taxonomy.term_taxonomy_id = " . DB_PRE . "term_relationships.term_taxonomy_id AND " . DB_PRE . "term_taxonomy.term_id = " . DB_PRE . "terms.term_id AND " . DB_PRE . "posts.ID = " . DB_PRE . "term_relationships.object_id";
        $query = $this->db->query($sql);
        $result = $this->db->fetch($query);

        return $permalink = URL::get_site_url() . '/p/' . $result['slug'] . '/' . $result['post_name'] . '.html';
    }

    function scanDirectories($rootDir, $allowext, $allData = array())
    {
        $dirContent = scandir($rootDir);
        foreach ($dirContent as $key => $content) {
            $path = $rootDir . '/' . $content;
            $ext = substr($content, strrpos($content, '.') + 1);

            if (in_array($ext, $allowext)) {
                if (is_file($path) && is_readable($path)) {
                    $allData[] = $path;
                } elseif (is_dir($path) && is_readable($path)) {
                    // recursive callback to open new directory
                    $allData = scanDirectories($path, $allData);
                }
            }
        }
        return $allData;
    }

    /**
     * check permission for user
     * @param $userId
     * @param $action
     * @return bool
     */
    public function getAction($userId, $action)
    {
        // admin are allow all action
        if ( $userId == 0 ) {
            return true;
        }

        // get user position
        $sql = "SELECT term_id 
                FROM term_relationships
                WHERE object_id = ". $userId ."
                AND type = 'position'";
        $query = $this->db->query( $sql );
        $result = $this->db->fetch( $query )['term_id'];

        // get permission
        $sql = "SELECT * 
                FROM user_permission
                WHERE pos_id = ". $result ."
                AND name = '". $action ."'";
        $query = $this->db->query( $sql );
        
        if ( $this->db->numrows( $query ) > 0 ) {
            return true;
        }

        return false;
    }

    /**
     * rename image with width and height
     * @param $url
     * @param $width
     * @param $height
     * @return string
     */
    public function getFileNameWithImageSize($url, $width, $height)
    {
        // get filename
        $urlArray = explode('/', $url);
        $filename = $urlArray[sizeof($urlArray) - 1];
        // get filename and extension
        $file = pathinfo($filename);
        $extension = $file['extension'];
        $filename = $file['filename'];

        // rename to width and height
        $filename .= '-' . $width . 'x' . $height . '.' . $extension;
        // create new array to hold path
        $urlArray[sizeof($urlArray) - 1] = $filename;
        // create new url
        $newURL = '';
        for ($i = 0; $i < sizeof($urlArray); $i++) {
            if ($i == (sizeof($urlArray) - 1)) {
                $newURL .= $urlArray[$i];
                break;
            }
            $newURL .= $urlArray[$i] . '/';
        }
        return $newURL;
    }

    /**
     * usage: send a string: cat=1&page=7, return $filters { 'cat' => 1, 'page' => 7 }
     * @param $string
     * @return array
     */
    function getFilters($string)
    {
        // store all request filter
        $filters = array();
        $temp = explode(';', $string);
        foreach ($temp as $k => $v) {

            if ($v !== '') {

                $temp1 = explode('=', $v);
                $filters[$temp1[0]] = $temp1[1];
            }
        }

        return $filters;
    }
}