<?php

class Database
{
    private $server;
    private $user;
    private $password;
    private $database;
    public $error;
    public $errorno = 0;
    protected $affect_rows = 0;
    protected $query_counter = 0;
    protected $link_id = 0;
    protected $query_id = 0;

    /**
     * Database __construct()
     *
     * @param mixed $server
     * @param mixed $user
     * @param mixed $password
     * @param mixed $database
     */
    public function  __construct($server, $database, $user, $password)
    {
        $this->server = $server;
        $this->user = $user;
        $this->password = $password;
        $this->database = $database;
    }
    /**
     * Database::connect()
     * Ket noi, su dung database duoc cung cap
     * @return
     */
    public function connect()
    {
        $this->link_id = $this->connect_db($this->server, $this->user, $this->password);
        if(!$this->link_id)
        {
            $this->error("<div style='text-align:center'>"
                . "<span style='padding: 5px; border: 1px solid #999; background-color:#EFEFEF;"
                . "font-family: Verdana; font-size: 11px; margin-left:auto; margin-right:auto'>"
                . "<b>Database Error:</b>Connection to Database " . $this->database . " Failed</span></div>");
        }
        if(!$this->select_db($this->database, $this->link_id))
        {
            $this->error("<div style='text-align:center'>"
                . "<span style='padding: 5px; border: 1px solid #999; background-color: #EFEFEF;"
                . "font-family: Verdana; font-size: 11px; margin-left:auto; margin-right:auto'>"
                . "<b>Database Error:</b>mySQL database (" . $this->database . ")cannot be used</span></div>");
        }

        mysqli_set_charset($this->link_id, 'utf8');

        unset($this->password);

        return $this->link_id;
    }

    /**
     * Database::db_connect()
     * Database connect
     * @param mixed $server
     * @param mixed $user
     * @param mixed $password
     * @return
     */
    private function connect_db($server, $user, $password) {
        try {
            $cnn = mysqli_connect($server, $user, $password);
        }
        catch ( mysqli_sql_exception $e ) {
            throw $e;
        }
        return $cnn;
    }

    function close_db()
    {
        mysqli_close( $this->link_id );
    }

    /**
     * Database::select_db()
     *
     * @param mixed $database
     * @param mixed $link_id
     * @return
     *
     */
    private function select_db($database, $link_id)
    {
        return mysqli_select_db($link_id, $database);
    }

    /**
     * DB:query
     * @param $sql
     * @return bool|mysqli_result
     */
    public function query($sql)
    {
        if (trim($sql != "")) {
            $this->query_id = mysqli_query($this->link_id, $sql);
        }

        if (!$this->query_id)
            $this->error("mySQL Error on Query : " . $sql);

        return $this->query_id;

    }

    /**
     * Database::first()
     * Fetches the first row only, frees resultset
     * @param mixed $string
     * @return array
     */
    public function first($string)
    {
        $query_id = $this->query($string);
        $record = $this->fetch($query_id);
        $this->free($query_id);

        return $record;
    }

    /**
     * Database::fetch_all()
     * Returns all the results
     * @param mixed $sql
     * @return assoc array
     */
    public function fetch_all($sql)
    {
        $query_id = $this->query($sql);
        $record = array();

        while ($row = $this->fetch($query_id, $sql)) :
            $record[] = $row;
        endwhile;

        $this->free($query_id);

        return $record;
    }

    /**
     * Database::fetch()
     * Fetches and returns results one line at a time
     * @param integer $query_id
     * @return array
     */
    public function fetch($query_id)
    {
        if ($query_id)
            $this->query_id = $query_id;

        if (isset($this->query_id)) {
            $record = mysqli_fetch_array($this->query_id, MYSQL_ASSOC);
        } else
            $this->error("Invalid query_id: <b>" . $this->query_id . "</b>. Records could not be fetched.");

        return $record;
    }

    /**
     * Database::free()
     * Frees the resultset
     * @param integer $query_id
     * @return query_id
     */
    public function free($query_id)
    {
        if ($query_id)
            $this->query_id = $query_id;

        return mysqli_free_result($this->query_id);
    }

    /**
     * Database::insert()
     * Insert query with an array
     * @param mixed $table
     * @param mixed $data
     * @return id of inserted record, false if error
     */
    public function insert($table = null, $data)
    {
        if ($table === null or empty($data) or !is_array($data)) {
            $this->error("Invalid array for table: <b>".$table."</b>.");
            return false;
        }
        $q = "INSERT INTO `" . $table . "` ";
        $v = '';
        $k = '';

        foreach ($data as $key => $val) :
            $k .= "`$key`, ";
            if (strtolower($val) == 'null')
                $v .= "NULL, ";
            else
                $v .= "'" . $this->escape($val) . "', ";
        endforeach;

        $q .= "(" . rtrim($k, ', ') . ") VALUES (" . rtrim($v, ', ') . ")";

        if ($this->query($q)) {
            return $this->insertid();
            //return true;
        } else
            return false;
    }

    /**
     * Database::update()
     * Update query with an array
     * @param mixed $table
     * @param mixed $data
     * @param string $where
     * @return query_id
     */
    public function update($table = null, $data, $where = '1')
    {
        if ($table === null or empty($data) or !is_array($data)) {
            $this->error("Invalid array for table: <b>" . $table . "</b>.");
            return false;
        }

        $q = "UPDATE `" . $table . "` SET ";
        foreach ($data as $key => $val) :
            if (strtolower($val) == 'null')
                $q .= "`$key` = NULL, ";
            elseif (strtolower($val) == 'default()')
                $q .= "`$key` = DEFAULT($val), ";
            elseif(preg_match("/^inc\((\-?[\d\.]+)\)$/i",$val,$m))
                $q.= "`$key` = `$key` + $m[1], ";
            else
                $q .= "`$key`='" . $this->escape($val) . "', ";
        endforeach;
        $q = rtrim($q, ', ') . ' WHERE ' . $where;

        return $this->query($q);
    }

    /**
     * Database::delete()
     * Delete records
     * @param mixed $table
     * @param string $where
     * @return int
     */
    public function delete($table, $where = '')
    {
        $q = !$where ? 'DELETE FROM ' . $table : 'DELETE FROM ' . $table . ' WHERE ' . $where;
        return $this->query($q);
    }

    /**
     * Database::affected()
     * Returns the number of affected rows
     * @param integer $query_id
     * @return
     */
    public function affected() {
        return mysqli_affected_rows($this->link_id);
    }

    /**
     * Database::numrows()
     *
     * @param integer $query_id
     * @return
     */
    public function numrows($query_id)
    {
        if ($query_id)
            $this->query_id = $query_id;

        $this->num_rows = mysqli_num_rows($this->query_id);
        return $this->num_rows;
    }

    /**
     * Database::fetchrow()
     * Fetches one row of data
     * @param integer $query_id
     * @return fetched row
     */
    public function fetchrow($query_id)
    {
        if ($query_id)
            $this->query_id = $query_id;

        $this->fetch_row = mysqli_fetch_row($this->query_id);
        return $this->fetch_row;
    }

    /**
     * Database::numfields()
     *
     * @param integer $query_id
     * @return
     */
    public function numfields($query_id)
    {
        if ($query_id)
            $this->query_id = $query_id;

        $this->num_fields = mysqli_num_fields($this->query_id);
        return $this->num_fields;
    }

    /**
     * Database::getDB()
     *
     * @return
     */
    public function getDB()
    {
        return $this->database;
    }

    /**
     * Database::getServer()
     *
     * @return
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * Database::getLink()
     *
     * @return
     */
    public function getLink()
    {
        return $this->link_id;
    }

    /**
     * Database::insert_id()
     * Returns last inserted ID
     * @param integer $query_id
     * @return
     */
    public function insertid()
    {
        return mysqli_insert_id($this->link_id);
    }

    /**
     * Database::escape()
     * @param mixed $string
     * @return
     */
    public function escape($string)
    {
        if (is_array($string)) {
            foreach ($string as $key => $value) :
                $string[$key] = $this->escape_($value);
            endforeach;
        } else
            $string = $this->escape_($string);

        return $string;
    }

    /**
     * Database::escape_()
     *
     * @param mixed $string
     * @param bool $do
     * @return Database::quote()
     */
    private function escape_($string)
    {
        return mysqli_real_escape_string($this->link_id, $string);
    }

    /**
     * Database::error()
     * Output error message
     * @param mixed $msg
     * @return
     */
    public function error($msg = '')
    {
        global $_SERVER;

        $the_error = "<div style=\"background-color:#FFF; border: 3px solid #999; padding:10px\">";
        $the_error .= "<b>mySQL WARNING!</b><br />";
        $the_error .= "DB Error: $msg <br /> More Information: <br />";
        $the_error .= "<ul>";
        $the_error .= "<li> Date : " . date("F j, Y, g:i a") . "</li>";
        $the_error .= "<li> Referer: " . isset($_SERVER['HTTP_REFERER']) . "</li>";
        $the_error .= "<li> Script: " . $_SERVER['REQUEST_URI'] . "</li>";
        $the_error .= '</ul>';
        $the_error .= '</div>';

        echo $the_error;
        die();
    }
}

