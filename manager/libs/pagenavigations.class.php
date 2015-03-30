<?php
/**
 * Created by BeanNguyen.
 * To create a page navigation
 * User: mrbean
 * Date: 10/30/14
 * Time: 10:22 PM
 */

class PageNavigation extends Connect {

    // member variables
    private $db;
    var $php_self;
    var $rows_per_page = 10; //Number of records to display per page
    var $total_rows = 0; //Total number of rows returned by the query
    var $links_per_page = 5; //Number of links to display per page
    var $sql = "";
    var $debug = false;
    var $page = 1;
    var $max_pages = 0;
    var $offset = 0;
    var $append = ""; //Parameters to append to pagination links
    var $type; // navigation for frontend or backend

    /**
     * Constructor
     */
    function __construct( $sql, $rows_per_page = 10, $links_per_page = 5, $url = '', $page = 1, $append = "", $type )
    {
        // Call the connection
        $this->db = parent::dbObj();
        $this->db->connect();
        // set up custom settings
        $this->rows_per_page = (int)$rows_per_page;
        if ( intval($links_per_page ) > 0 ) {
            $this->links_per_page = (int)$links_per_page;
        } else {
            $this->links_per_page = 5;
        }
        $this->sql = $sql;
        $this->append = $append;
        $this->php_self = $url;
        $this->page = intval( $page );
        $this->type = $type;
    }

    /**
     * Executes the SQL query and initializes internal variables
     *
     * @access public
     * @return resource
     */
    function paginate() {

        //Find total number of rows
        $all_rs = $this->db->query( $this->sql );
        if (! $all_rs) {
            if ($this->debug)
                echo "SQL query failed. Check your query.<br /><br />Error Returned: " . mysql_error();
            return false;
        }
        $this->total_rows = $this->db->numrows( $all_rs );

        //Return FALSE if no rows found
        if ($this->total_rows == 0) {
            if ($this->debug)
                echo "Query returned zero rows.";
            return FALSE;
        }

        //Max number of pages
        $this->max_pages = ceil($this->total_rows / $this->rows_per_page );
        if ($this->links_per_page > $this->max_pages) {

            $this->links_per_page = $this->max_pages;
        }

        //Check the page value just in case someone is trying to input an aribitrary value
        if ($this->page > $this->max_pages || $this->page <= 0) {

            $this->page = 1;
        }

        //Calculate Offset
        $this->offset = $this->rows_per_page * ($this->page - 1);

        //Fetch the required result set
        $rs = $this->sql . " LIMIT {$this->offset}, {$this->rows_per_page}";
        return $rs;
    }

    function createURL ( $page )
    {
        $url = '';
        if ( $this->type === 'backend' ) {
            $url .= $this->php_self;
        }

        $url .= '?page=' . $page;

        if ( $this->append !== '' )
            $url .= '&' . $this->append;
        return $url;
    }
    /**
     * show the next icon
     * @param string $tag icon for next item
     * @return bool|int
     */
    function renderNext( $tag = '&gt;&gt;' ) {

        if ($this->total_rows == 0)
            return FALSE;

        if ( $this->page < $this->max_pages ) {
            $url = $this->createURL( $this->page + 1 );
            if ( $this->type === 'index' )
                return '<a href="'. $url .'">Next <i class="m-icon-swapright m-icon-gray"></i></a> &nbsp;';
            else
                return '<a href="'. $url .'" class="btn btn-sm blue btn-next"><i class="icon-angle-right"></i></a>';
        } else {
            if ( $this->type === 'index' )
                return '<a href="javascript:;" class="disabled" disabled>Next <i class="m-icon-swapright m-icon-gray"></i></a> &nbsp;';
            else
                return '<a href="javascript:;" class="btn btn-sm blue btn-next" disabled><i class="icon-angle-right"></i></a>';
        }
    }

    /**
     * Show prev number of page
     * @param string $tag icon for prev item
     * @return bool|int
     */
    function renderPrev( $tag = '&lt;&lt;' ) {

        if ($this->total_rows == 0)
            return FALSE;

        if ($this->page > 1) {

            $url = $this->createURL($this->page - 1);
            if ( $this->type === 'index' )
                return '<a href="'. $url .'"><i class="m-icon-swapleft m-icon-gray"></i> Prev</a> &nbsp;';
            else
                return '<a href="'. $url .'" class="btn btn-sm blue btn-prev"><i class="icon-angle-left"></i></a>';
        } else {
            if ( $this->type === 'index' )
                return '<a href="javascript:;" class="disabled" disabled><i class="m-icon-swapleft m-icon-gray"></i> Prev</a> &nbsp;';
            else
                return '<a href="javascript:;" class="btn btn-sm blue btn-prev" disabled><i class="icon-angle-left"></i></a>';
        }
    }

    function renderNav($prefix = '<li>', $suffix = '</li>') {

        if ($this->total_rows == 0)
            return FALSE;

        $batch = ceil($this->page / $this->links_per_page );
        $end = $batch * $this->links_per_page;
        if ($end == $this->page) {

            //$end = $end + $this->links_per_page - 1;
            //$end = $end + ceil($this->links_per_page/2);
        }
        if ($end > $this->max_pages) {

            $end = $this->max_pages;
        }
        $start = $end - $this->links_per_page + 1;
        $links = '';

        for($i = $start; $i <= $end; $i ++) {

            if ($i == $this->page) {
                $links .= ' <li class="active"><a href="javascript:;">' . $i . '</a></li>';
            } else {

                $url = $this->createURL( $i );
                $links .= ' ' . $prefix . '<a href="' . $url . '">' . $i . '</a>' . $suffix . ' ';
            }
        }

        return $links;
    }

    function renderFullNav( $prevTag = '&lt;&lt;', $nextTag = '&gt;&gt;' ) {

        return $this->renderPrev( $prevTag ) . $this->renderNext( $nextTag );
    }

    /**
     * Set debug mode
     *
     * @access public
     * @param bool $debug Set to TRUE to enable debug messages
     * @return void
     */
    function setDebug($debug) {
        $this->debug = $debug;
    }
} 