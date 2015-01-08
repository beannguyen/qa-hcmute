<?php

include_once("class.phpmailer.php");
require_once( 'generics.class.php' );

class Mailer extends Generic
{

    /**
     * Sends HTML emails with optional shortcodes.
     *
     * @param     string    $to            Receiver of the mail.
     * @param     string    $subj          Subject of the email.
     * @param     string    $msg           Message to be sent.
     * @param     array     $shortcodes    Shortcode values to replace.
     * @param     bool      $bcc           Whether to send the email using Bcc: rather than To:
     *                                     Useful when sending to multiple recepients.
     * @return    bool      Whether the mail was sent or not.
     */
    public function send($to, $subj, $msg, $headers)
    {
        $mail = new PHPMailer();  // tạo một đối tượng mới từ class PHPMailer
        $mail->IsSMTP(); // bật chức năng SMTP
        $mail->IsHTML(true);
        //$mail->SMTPDebug = 2;  // kiểm tra lỗi : 1 là  hiển thị lỗi và thông báo cho ta biết, 2 = chỉ thông báo lỗi
        $mail->SMTPAuth = true;  // bật chức năng đăng nhập vào SMTP này
        $mail->SMTPSecure = 'ssl'; // sử dụng giao thức SSL vì gmail bắt buộc dùng cái này
        $mail->Host = parent::getOption('mailserver_url');
        $mail->Port = parent::getOption('mailserver_port');
        $mail->Username = parent::getOption('mailserver_login');
        $mail->Password = parent::getOption('mailserver_pass');
        $mail->addCustomHeader($headers);
        $mail->Subject = $subj;
        $mail->Body = nl2br(html_entity_decode($msg));
        $mail->AddAddress($to);
        $mail->SetFrom(parent::getOption('mailserver_login'), parent::getOption('site_name'));
        $mail->AddReplyTo(parent::getOption('mailserver_login'), parent::getOption('site_name'));
        if(!$mail->Send()) {
            $error = 'Can not send this email: '.$mail->ErrorInfo;
            return $error;
        } else {
            return true;
        }
    }
}