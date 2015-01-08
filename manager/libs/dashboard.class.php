<?php
require('generics.class.php');
require_once('times.class.php');
require_once('urls.class.php');
require_once('mailers.class.php');

class Dashboard extends Generic
{
    public $db;
    public $timer;
    public $error = '';

    function __construct()
    {
        parent::__construct();
        $this->timer = new timer();

        // if you are not logged
        if (!parent::guestOnly()) { // Only user can view this page

            $_SESSION['ithcmute']['referer'] = URL::curURL();
            URL::redirect_to(BASE_PATH . 'manager/login.php');
            exit();
        }

        if (isset($_POST['general']) && $_POST['general'] == 1) {

            $data = array();
            foreach ($_POST as $k => $v) {

                $data[$k] = $v;
            }
            $this->updateGeneralSetting($data);
        }

        // add and edit field
        if (isset($_POST['field'])) {

            if ($_POST['field'] == 1) {

                $fieldName = $_POST['field_name'];
                $this->addField($fieldName);
            } else {

                $data['id'] = $_POST['field_id'];
                $data['name'] = $_POST['field_name'];
                $this->updateField($data);
            }
        }
        // add and edit user position
        if (isset($_POST['position'])) {

            if ($_POST['position'] == 1) {

                $positionName = $_POST['position_name'];
                $this->addField($positionName, 'position');
            } else {

                $data = array(
                    'id' => $_POST['position_id'],
                    'name' => $_POST['position_name']
                );
                $this->updateField($data);
            }
        }

        // add and user
        if (isset($_POST['register'])) {

            if ($_POST['register'] == 1) {

                $data = array();
                foreach ($_POST as $k => $v) {

                    if ($k !== 'register') {

                        $data[$k] = $v;
                    }
                }
                $this->addNewUser($data);
            }
        }

        // edit user information
        if (isset($_POST['update_info'])) {

            $data = array();
            foreach ($_POST as $k => $v) {

                if ($k !== 'update_info') {

                    $data[$k] = $v;
                }
            }
            $this->updateUserInfo($data);
        }

        // change password
        if (isset($_POST['change_password'])) {

            $userId = $_POST['user_id'];
            $password = $_POST['new_password'];

            $this->changePassword($userId, $password);
        }

        // reset password
        if ( isset( $_POST['reset_password'] ) ) {

            $this->resetPassword( $_POST['user_id'] );
        }

        // restrict user
        if (isset($_POST['restricted'])) {

            $userId = $_POST['user_id'];
            $restricted = 0;
            if (isset($_POST['user_restricted'])) {

                $restricted = $_POST['user_restricted'];
            }
            $this->restrictUser($userId, $restricted);
        }

        // reply a question
        if (isset($_POST['reply'])) {

            $this->reply();
        }

        // upload avatar
        if (isset($_POST['upload_avatar'])) {
            $this->addGallery();
        }

        // question spam
        if ( isset( $_POST['spam'] ) ) {

            $this->spamQuestion( $_POST['question_id'] );
        }

        // delete question
        if ( isset( $_POST['delete_question'] ) ) {

            $this->deleteQuestion( $_POST['question_id'] );
        }

        // delete answer
        if ( isset( $_POST['delete_answer'] ) ) {

            $this->deleteAnswer( $_POST['answer_id'] );
        }

        // update answer
        if ( isset( $_POST['edit_answer'] ) ) {
            $this->editAnswer();
        }

        // add new question from admin
        if ( isset( $_POST['new-question'] ) ) {

            $this->newQuestion();
        }

    }

    private function updateGeneralSetting($data)
    {
        foreach ($data as $k => $v) {

            parent::updateOption($k, $v);
        }

        $_SESSION['ithcmute']['action-status'] = 'success';
        URL::goBack();
        exit();
    }

    private function addField($fieldName, $type = 'field')
    {
        $sql = "INSERT INTO terms(name, type) VALUES  ('" . $fieldName . "', '" . $type . "')";
        $query = $this->db->query($sql);

        if ($query) {

            $_SESSION['ithcmute']['action-status'] = 'success';
        } else {
            $_SESSION['ithcmute']['action-status'] = 'failed';
        }

        URL::goBack();
        exit();
    }

    private function updateField($data)
    {
        $sql = "UPDATE terms SET name = '" . $data['name'] . "' WHERE term_id = " . $data['id'];
        $query = $this->db->query($sql);

        if ($query) {

            $_SESSION['ithcmute']['action-status'] = 'success';
        } else {
            $_SESSION['ithcmute']['action-status'] = 'failed';
        }

        URL::goBack();
        exit();
    }

    private function addNewUser($data)
    {
        require_once('times.class.php');
        $timer = new timer();

        /* Create their account */
        $sql = "INSERT INTO users (username, email, password, fullname, registed_date)
						VALUES ('" . $data['username'] . "', '" . $data['email'] . "', '" . parent::hashPassword($data['password']) . "', '" . $data['full_name'] . "', '" . $timer->getDateTime() . "')";

        $this->db->query($sql);

        $sql = "SELECT user_id FROM users WHERE username = '" . $data['username'] . "'";
        $query = $this->db->query($sql);
        $user_id = $this->db->fetch($query)['user_id'];

        /* add user position */
        $sql = "INSERT INTO term_relationships( term_id, object_id, type ) VALUES ('" . $data['user_position'] . "', '" . $user_id . "', 'position')";
        $this->db->query($sql);

        /* add user meta */
        $sql = "INSERT INTO user_meta (user_id, meta_key, meta_value) VALUES (" . $user_id . ", 'profile_img', 'public/uploads/default-avatar.png')";
        $this->db->query($sql);

        unset(
        $_SESSION['ithcmute']['referer'],
        $_SESSION['ithcmute']['token']
        );

        $_SESSION['ithcmute']['action_status'] = 'success';
        URL::goBack();
        exit();
    }

    private function updateUserInfo($data)
    {
        $sql = "UPDATE users SET username = '" . $data['username'] . "',
                                email = '" . $data['email'] . "',
                                fullname = '" . $data['fullname'] . "'
                WHERE user_id = " . $data['user_id'];
        $this->db->query($sql);

        $sql = "UPDATE term_relationships SET term_id = " . $data['user_position'] . " WHERE object_id = " . $data['user_id'];
        $this->db->query($sql);

        $_SESSION['ithcmute']['action_status'] = 'success';
        URL::goBack();
        exit();
    }

    private function changePassword($userId, $password)
    {
        $sql = "UPDATE users SET password = '" . parent::hashPassword($password) . "' WHERE user_id = " . $userId;
        $this->db->query($sql);

        $_SESSION['ithcmute']['action_status'] = 'success';
        URL::goBack();
        exit();
    }

    private function resetPassword( $userId )
    {
        $password = parent::randomPassword();

        // update password to database
        $sql = "UPDATE users SET password = '" . parent::hashPassword($password) . "' WHERE user_id = " . $userId;
        $this->db->query( $sql );

        // get user data
        $sql = "SELECT * FROM users WHERE user_id = " . $userId;
        $query = $this->db->query( $sql );
        $user = $this->db->fetch( $query );

        // send an email alert to user
        parent::sendEmail( $user['email'], 'Mật khẩu mới hệ thống Tư vấn Sinh Viên', '<strong>Mật khẩu mới của bạn: </strong> '. $password );

        // response text
        echo $password;
        exit();
    }

    private function restrictUser($userId, $restricted)
    {
        $sql = "UPDATE users SET restricted = " . $restricted . " WHERE user_id = " . $userId;
        $this->db->query($sql);

        $_SESSION['ithcmute']['action_status'] = 'success';
        URL::goBack();
        exit();
    }

    private function reply()
    {
        $userId = $_SESSION['ithcmute']['user_id'];
        $questionId = $_POST['question_id'];
        $message = parent::secure($_POST['message']);
        $type = $_POST['type'];
        $date = $this->timer->getDateTime();

        if ( $message === '' ) {

            $_SESSION['ithcmute']['action_status'] = 'no-message';
            URL::goBack();
            exit();
        }
        $sql = "INSERT INTO `answers`
                            (`author_id`,
                            `content`,
                            `date`)
                            VALUES
                            (" . $userId . ",
                            '" . $message . "',
                            '" . $date . "');";
        $query = $this->db->query($sql);
        $answerId = $this->db->insertid($query);

        // add relationships
        $sql = "INSERT INTO `QA_relationships`
                            (`question_id`,
                            `answer_id`)
                            VALUES
                            (" . $questionId . ",
                            " . $answerId . ");";
        $this->db->query($sql);

        // update type (private or public) of questions
        $sql = "UPDATE questions SET type = '" . $type . "' WHERE id = " . $questionId;
        $this->db->query($sql);

        // get
        $sql = "SELECT title, content, author_email, i_am FROM questions WHERE id = " . $questionId;
        $query = $this->db->query($sql);
        $question = $this->db->fetch($query);


        // get author infomation
        $sql = "SELECT * FROM users WHERE user_id = " . $_SESSION['ithcmute']['user_id'];
        $q = $this->db->query( $sql );
        $user = $this->db->fetch( $q );

        if ( $question['i_am'] !== 'admin' ) {

            // send an email to user
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
            $headers .= 'From: ' . $this->getOption('mailserver_login') . "\r\n";
            $headers .= 'Reply-To: ' . $this->getOption('mailserver_login') . "\r\n";

            $to = $question['author_email'];
            $subj = "BQT đã trả lời câu hỏi : '" . $question['title'] . "'";
            $subj = "=?utf-8?b?" . base64_encode($subj) . "?=";
            $msg = '<strong>Question: </strong><blockquote>' . $question['content'] . '</blockquote><br /><hr />';
            $msg .= '<strong>Answer by '. $user['fullname'] .': </strong>' . $message . '<br /> (' . $date . ')';
            // init mailer
            $sender = new Mailer();
            $debug = $sender->send($to, $subj, $msg, $headers);
        }

        $_SESSION['ithcmute']['action_status'] = 'sent';
        URL::redirect_to(BASE_PATH . 'manager/fqa/questions.php');
        exit();
    }

    /**
     * add image to product details gallery
     * @return bool
     */
    function addGallery()
    {
        // process to upload file
        $imageSrc = $this->upload_process();

        if ($imageSrc == false) {

            $_SESSION['ithcmute']['action_status'] = 'not_allowed';
            URL::goBack();
            exit();
        } else {

            // create image 100x100 to response text
            $image45 = parent::getFileNameWithImageSize($imageSrc, 45, 45);

            $sql = "SELECT * FROM user_meta WHERE meta_key = 'profile_img' AND user_id = " . $_POST['user_id'];
            $q = $this->db->query( $sql );

            if ( $this->db->numrows( $q ) > 0 )
                $sql = "UPDATE user_meta SET meta_value = '" . $image45 . "' WHERE meta_key = 'profile_img' AND user_id = " . $_POST['user_id'];
            else
                $sql = "INSERT INTO `user_meta`
                        (`user_id`,
                        `meta_key`,
                        `meta_value`)
                        VALUES
                        (". $_POST['user_id'] .",
                        'profile_img',
                        '". $image45 ."')";
            $this->db->query($sql);

            $_SESSION['ithcmute']['action_status'] = 'success';
            URL::goBack();
            exit();
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
        $data['author_stuID'] = 0;
        $data['author_name'] = 'Ý kiến sinh viên';
        $data['author_email'] = $this->getOption('mailserver_login');
        $data['i_am'] = 'admin';

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

        $_SESSION['ithcmute']['action_status'] = 'success';
        URL::goBack();
        exit();
    }


    /**
     * upload processing
     * @param bool $flag type of process for
     * @return bool|string
     */
    function upload_process($flag = false)
    {
        $ds = DIRECTORY_SEPARATOR;

        // create folder to store file
        $today = getdate();
        $storeFolder = 'public/uploads/';

        if (!empty($_FILES)) {

            $tempFile = $_FILES['file']['tmp_name']; //3
            $targetPath = ROOT_PATH . $storeFolder . $ds; //4
            $targetFile = $targetPath . '/' . $_FILES['file']['name']; //5
            $allowext = array("jpg", "jpeg", "png");

            //get image extension
            $file = strtolower($_FILES['file']['name']);
            $f = pathinfo($file);
            $fname = $f['filename'];
            $exts = $f['extension'];
            // make sure file is allow to upload
            if (!in_array($exts, $allowext)) {
                return false;
            }
            // make sure file is existed
            $src = '';
            $filename = '';
            if (file_exists($targetFile)) {

                $files_array = parent::scanDirectories($targetPath, $allowext);

                foreach ($files_array as $k => $v) {

                    if ($targetFile === $v) {
                        rename:
                        // create unique file name using time()
                        $file = $fname . '-' . time();
                        $filename = $file . '.' . $exts;
                        $targetFile = $targetPath . '/' . $filename;
                        // check unique filename again
                        if (file_exists($targetFile))
                            goto rename; // create again
                        else {
                            // load image url
                            $src = $storeFolder . $filename;
                        }
                        break;
                    }
                }
            } else
                $src = $storeFolder . $_FILES['file']['name'];

            // if files are stored
            if (move_uploaded_file($tempFile, $targetFile)) {
                // save to database
                //$this->model->saveAttachedFile($storeFolder.$_FILES['file']['name'], $_POST['post-id']);
                //phpthumb resizing - get the php class and start it up
                require_once('phpthumb/phpthumb.class.php');
                $phpThumb = new phpThumb();
                //set the output format. We will save the images as jpg.
                $output_format = 'jpeg';
                // set height for image sizes
                $thumbnail_widths = array(45);
                $thumbnail_heights = array(45);
                //loop through the heights array above and create the different size image
                $count = 0;
                foreach ($thumbnail_heights as $thumbnail_height) {

                    //get image extension
                    if ($filename !== '') {

                        $file = ($filename);
                        $f = pathinfo($file);
                        $fname = $f['filename'];
                        $exts = $f['extension'];
                    }
                    // resize image
                    $phpThumb->resetObject();
                    $phpThumb->setSourceFilename($targetFile);
                    $phpThumb->setParameter('h', $thumbnail_height);
                    $phpThumb->setParameter('w', $thumbnail_widths[$count]);
                    $phpThumb->setParameter('config_output_format', $output_format);

                    //pass for xsmall, square pics
                    //q (quality) is set to 92
                    $phpThumb->setParameter('q', 92);
                    //zc (zoom-crop) is on (off by default), so the smaller of the width/height will be used to make a square cropped thumbnail.
                    $phpThumb->setParameter('zc', 1);
                    //set image thumbnail destination
                    $thumb_name = $fname . '-' . $thumbnail_widths[$count] . 'x' . $thumbnail_height . '.' . $exts;
                    $store_filename = $targetPath . '/' . $thumb_name;

                    if ($phpThumb->GenerateThumbnail()) {
                        if ($phpThumb->RenderToFile($store_filename)) {
                            //image uploaded - you will probably need to put image info into a database at this point
                            $message = "Image uploaded successfully.";
                        } else {
                            //unable to write file to final destination directory - check folder permissions
                            $message = "Error! Please try again (render).";
                        }
                    } else {
                        //unable to generate the image
                        $message = "Error! Please try again (generate).";
                    }
                    $count++;
                }
            }

            return $src;
        }
    }

    private function spamQuestion( $questionId )
    {
        $sql = "UPDATE questions SET type = 'spam' WHERE id = " . $questionId;
        $this->db->query( $sql );

        echo 1;
        exit();
    }

    private function deleteQuestion( $questionId )
    {
        // delete field relationship
        $sql = "DELETE FROM term_relationships WHERE type = 'field' AND object_id = " . $questionId;
        $this->db->query( $sql );

        // delete Q&A relationships
        $sql = "DELETE FROM QA_relationships WHERE question_id = " . $questionId;
        $this->db->query( $sql );

        $sql = "DELETE FROM questions WHERE id = " . $questionId;
        $this->db->query( $sql );

        echo 1;
        $_SESSION['ithcmute']['action_status'] = 'success';
        exit();
    }

    private function deleteAnswer( $answerId )
    {
        // delete QA relationships
        $sql = "DELETE FROM QA_relationships WHERE answer_id = " . $answerId;
        $this->db->query( $sql );

        // delete answer
        $sql = "DELETE FROM answers WHERE id = " . $answerId;
        $this->db->query( $sql );

        echo 1;
        exit();
    }

    private function editAnswer()
    {
        // update answer content
        $sql = "UPDATE answers SET content = '". $_POST['message'] ."' WHERE id = " . $_POST['answer_id'];
        $this->db->query( $sql );

        // update question type
        $sql = "UPDATE questions SET type = '". $_POST['type'] ."' WHERE id = " . $_POST['question_id'];
        $this->db->query( $sql );

        // get question information
        $sql = "SELECT * FROM questions WHERE id = " . $_POST['question_id'];
        $query = $this->db->query ( $sql );
        $question = $this->db->fetch( $query );

        // get author infomation
        $sql = "SELECT * FROM users WHERE user_id = " . $_SESSION['ithcmute']['user_id'];
        $q = $this->db->query( $sql );
        $user = $this->db->fetch( $q );

        // send an email to user
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'From: ' . $this->getOption('mailserver_login') . "\r\n";
        $headers .= 'Reply-To: ' . $this->getOption('mailserver_login') . "\r\n";

        $to = $question['author_email'];
        $subj = "BQT đã chỉnh sửa câu trả lời cho câu câu hỏi : '" . $question['title'] . "'";
        $subj = "=?utf-8?b?" . base64_encode($subj) . "?=";
        $msg = '<strong>Question: </strong><blockquote>' . $question['content'] . '</blockquote><br /><hr />';
        $msg .= '<strong>Chỉnh sửa bởi '. $user['fullname'] .': </strong>' . $_POST['message'] . '<br /> (' . $date = $this->timer->getDateTime() . ')';
        // init mailer
        $sender = new Mailer();
        $debug = $sender->send($to, $subj, $msg, $headers);

        $_SESSION['ithcmute']['action_status'] = 'success';
        URL::goBack();
        exit();
    }
}