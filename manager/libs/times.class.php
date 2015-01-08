<?php
/**
 * Cấu hình thời gian, múi giờ, định dạng hiển thị cho thời gian trên hệ thống.
 */

class timer
{

    function __construct()
    {

    }
    function getDateTime()
    {
        $tz_string = "Asia/Ho_Chi_Minh"; // Use one from list of TZ names http://php.net/manual/en/timezones.php
        $tz_object = new DateTimeZone($tz_string);

        $datetime = new DateTime();
        $datetime->setTimezone($tz_object);

        return $datetime->format('Y/m/d H:i:s');
    }

    function add( $addString, $date = '', $format = 'Y/m/d H:i:s' )
    {
        $tz_string = "Asia/Ho_Chi_Minh"; // Use one from list of TZ names http://php.net/manual/en/timezones.php
        $tz_object = new DateTimeZone($tz_string);

        if ( $date === '' )
            $datetime = new DateTime();
        else
            $datetime = new DateTime($date);
        $datetime->setTimezone($tz_object);

        $interval = DateInterval::createfromdatestring( $addString ); // +1 day +2 hours +15 seconds
        $datetime->add($interval);

        return $datetime->format( $format );
    }

    function sub( $subString ) {

        $tz_string = "Asia/Ho_Chi_Minh"; // Use one from list of TZ names http://php.net/manual/en/timezones.php
        $tz_object = new DateTimeZone($tz_string);

        $datetime = new DateTime();
        $datetime->setTimezone($tz_object);

        $interval = DateInterval::createfromdatestring( $subString ); // +1 day +2 hours +15 seconds
        $datetime->sub( $interval );

        return $datetime->format('Y/m/d H:i:s');
    }

    function time_elapsed_A($secs){
        $bit = array(
            'y' => $secs / 31556926 % 12,
            'w' => $secs / 604800 % 52,
            'd' => $secs / 86400 % 7,
            'h' => $secs / 3600 % 24,
            'm' => $secs / 60 % 60,
            's' => $secs % 60
        );

        foreach($bit as $k => $v)
            if($v > 0)$ret[] = $v . $k;

        //return join(' ', $ret);
        return $bit['w'];
    }

    function timeFormat( $value, $format = 'd M Y H:i' )
    {
        return date_format( date_create( $value ), $format );
    }
}

$timer = new timer();