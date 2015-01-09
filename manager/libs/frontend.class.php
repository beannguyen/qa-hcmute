<?php
require( 'generics.class.php' );
require_once( 'urls.class.php' );
require_once( 'times.class.php' );
require_once( 'mailers.class.php' );

class Frontend extends Generic
{
    public $db;
    protected $timer;
    public $error = '';

    function __construct()
    {
        parent::__construct();
        $this->timer = new timer();

        if ( isset( $_POST['question'] ) ) {

            $this->newQuestion();
        }

        if ( isset( $_POST['recaptcha_response_field'] ) ) {

            $this->validReCatcha();
        }
    }

    private function newQuestion()
    {

        $data = array();
        foreach ( $_POST as $k => $v ) {

            if ( $k !== 'question' ) {

                $data[$k] = $v;
            }
        }
        // add question information
        $sql = "INSERT INTO `questions`
                            (`title`,
                            `author_stuID`,
                            `author_name`,
                            `author_email`,
                            `content`,
                            `date`,
                            `i_am`)
                            VALUES
                            ('". $data['title'] ."',
                            '". $data['author_stuID'] ."',
                            '". $data['author_name'] ."',
                            '". $data['author_email'] ."',
                            '". $data['content'] ."',
                            '". $this->timer->getDateTime() ."',
                            '". $data['i_am'] ."');";
        $query = $this->db->query( $sql );
        $questionId = $this->db->insertid( $query );
        // add term relationships
        $sql = "INSERT INTO `term_relationships`
                            (`term_id`,
                            `object_id`,
                            `type`)
                            VALUES
                            (". $data['question_field'] .",
                            ". $questionId .",
                            'field');";
        $this->db->query( $sql );

        // send an email alert to manager
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'From: ' . $this->getOption('mailserver_login') . "\r\n";
        $headers .= 'Reply-To: ' . $this->getOption('mailserver_login') . "\r\n";

        $to = $this->getOption('mailserver_login');
        $subj = "Có một câu hỏi mới : '" . $data['title'] . "'";
        $subj = "=?utf-8?b?".base64_encode( $subj )."?=";
        $msg = '<span>Hệ thống quản lý câu hỏi của Ban tư vấn sinh viên <strong>khoa Công Nghệ Thông Tin - Trường Đại học Sư Phạm Kỹ Thuật Tp.HCM</strong> đã nhận được một câu hỏi mới vào lúc <em>' . $this->timer->getDateTime() . '</em></span><br />';
        $msg .= '<blockquote>
                    <strong>Tiêu đề: "'. $data['title'] .'"</strong>
                    <span>Nội dung: "'. $data['content'] .'"</span>
                </blockquote>';
        $msg .= '<span>Vui lòng <a href="http://localhost/hcmute/manager/fqa/questions.php">Nhấn vào đây</a> để kiểm tra và trả lời</span>';
        // init mailer
        $sender = new Mailer();
        $debug = $sender->send($to, $subj, $msg, $headers);

        $_SESSION['ithcmute']['action-status'] = 'success';
        URL::goBack();
        exit();
    }

    function validReCatcha()
    {
        require_once('recaptchalib.php');
        /* BeanNguyen: Update : update private key for recaptcha */
        // $privatekey = "6LcHX_4SAAAAAA84hSJ6aFsx2wZZHAbwSwHKX201";
        /* BeanNguyen: Update : update private key for recaptcha */
        $privatekey = "6LcBY_4SAAAAAAzySoporuvhVEK8uqQNUbZJ5W9k";
        $resp = recaptcha_check_answer ($privatekey,
            $_SERVER["REMOTE_ADDR"],
            $_POST["recaptcha_challenge_field"],
            $_POST["recaptcha_response_field"]);
        if (!$resp->is_valid) {
            // What happens when the CAPTCHA was entered incorrectly
            echo 0;
        } else {
            echo 1;
        }
        exit();
    }
}