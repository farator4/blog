<?php

/**
 * Admin dashboard table : 404 dashboard table
 * @package WSW_Table
 */

if(!class_exists('WP_List_Table'))
    require_once(ABSPATH.'wp-admin/includes/class-wp-list-table.php');

/**
 * Table class that handles loading and displaying WordPress list table for contests.
 * @package INVTable
 */
/**
 * Table class that handles loading and displaying WordPress list table for contests.
 * @package INVTable
 */

class WSW_Table_Log extends WP_List_Table
{
    /**
     * Number of all contests.
     * @var int
     */
    private $found_posts;

    /**
     * Number of contests per page.
     * @var int
     */
    private $per_page;

    /**
     * Table constructor.
     * @return INV_Table_Account
     */
    function __construct()
    {
        $this->per_page = 20;

        parent::__construct();
    }

    /**
     * Sets table columns.
     * @return mixed
     */
    function get_columns()
    {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'error_url' => 'URL',
            'client_ip' => 'IP Address',
            'error_date' => 'Date'
        );

        return $columns;
    }

    /**
     * Retrieves contest data.
     */
    function get_data()
    {
        $orderby = 'url';
        $order = 'asc';

        if(isset($_GET['orderby'])){
            $param = $_GET['orderby'];
            if($param == 'error_url') {
                $orderby = 'url';
            } elseif($param == 'client_ip') {
                $orderby = 'ip';
            } elseif($param == 'error_date') {
                $orderby = 'date';
            } else {
                $orderby = 'url';
            }
        }

        if(isset($_GET['order']))
            $order = $_GET['order'];

        $dm = '0';
        $ft = '0';
        if(isset($_GET['dm'])) {
            $dm = $_GET['dm'];
        }
        if(isset($_GET['ft'])) {
            $ft = $_GET['ft'];
        }

        $data = WSW_Model_Log::get_all($orderby, $order, $this->get_pagenum(), $this->per_page, $dm, $ft);
        $this->found_posts = WSW_Model_Log::$found_count;
        return $data;
    }

    /**
     * Sets sortable table columns.
     */
    function get_sortable_columns()
    {
        $sortable_columns = array(
            'error_url' => array('url', false),
            'client_ip' => array('ip', false),
            'error_date' => array('date', false)

        );

        return $sortable_columns;
    }

    /**
     * Initializes table data.
     */
    function prepare_items()
    {
        $columns = $this->get_columns();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, array(), $sortable);

        $this->items = $this->get_data();

        $this->set_pagination_args( array(
            'total_items' => $this->found_posts,
            'per_page'    => $this->per_page
        ));
    }

    /**
     * Generates columns.
     *
     * @param CH_Contest $item Current contest.
     * @param string $column_name Current column text ID.
     */
    function column_default($item, $column_name)
    {

        switch($column_name)
        {
           case 'client_ip':
                $output = $item['ip'];
                break;
            case 'error_date':
                $output = $item['date'];
                break;
           default:
                $output = '';
                break;
        }
        return $output;
    }

    function column_cb($item) {
        return sprintf('<input type="checkbox" name="log404[]" value="%s" />', $item['id']);
    }


    function column_error_url($item){

        $actions = array(
            'trash'    => sprintf('<a href="?page=%s&action=%s&book=%s">Trash</a>',$_REQUEST['page'],'Trash',$item['id']),
        );

        $title = sprintf('<a href="%s">%s</a>',$item['url'], $item['url']);
        $field = sprintf('%1$s %2$s', $title, $this->row_actions($actions) );

        return $field;
    }

    function get_bulk_actions() {

        $actions = array(
            'trash' => 'Trash',
        );

        return $actions;
    }

}
