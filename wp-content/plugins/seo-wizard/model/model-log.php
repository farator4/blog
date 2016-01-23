<?php
/**
 * Model: WSW_Model_Log
 * @package WSO_Model
 */

/**
 * Model class <i>WSW_Model_Log</i> represents account
 * @package WSO_Model
 */

class WSW_Model_Log
{
    /**
     * Tab table name
     */
    const table_name = 'wsw_404_log';

    /**
     * Holds found campaign count
     */
    static $found_count;

    /**
     * Holds all campaign count
     */
    static $all_count;

    /** Create Table */
    public static function create_table()
    {
        global $wpdb;
        // create list table
        $creation_query =
            'CREATE TABLE IF NOT EXISTS ' . self::table_name . ' (
			`id` int(20) NOT NULL AUTO_INCREMENT,
			`date` varchar(40),
			`ref` varchar(512),
			`url` varchar(512),
			`ip` varchar(40),
			`ua` varchar(512),
			PRIMARY KEY (`id`)
			);';

        $wpdb->query( $creation_query );
    }

    /**
     * Remove table
     */
    public static function remove_table()
    {
        global $wpdb;
        $query = 'DROP TABLE IF EXISTS ' . self::table_name . ';';
        $wpdb->query($query);
    }

    /**
     * Get data by id
     * @param $id
     */
    public static function get_data($id)
    {
        global $wpdb;
        $query = 'select * from ' . self::table_name . ' where id=' . $id . ';';
        $results = $wpdb->get_results($query, ARRAY_A);

        if(is_array($results))
            return $results[0];
        else
            return false;
    }

    /**
     * Get data by id
     * @param $id
     */
    public static function get_data_by_page_id($page_id)
    {
        global $wpdb;
        $query = "select * from " . self::table_name . " where page_id=" . $page_id . " and status='active';";
        $results = $wpdb->get_results($query, ARRAY_A);

        if(is_array($results))
            return $results[0];
        else
            return false;
    }


    /** Update views */
    public static function update_record_views($page_id, $views, $optin_percent)
    {
        global $wpdb;
        $query = "update " . self::table_name . " ";
        $query .= "set optin_percent='{$optin_percent}', views={$views} ";
        $query .= "where page_id=" . $page_id . ";";

        $wpdb->query( $query );
         return;
    }


    /** Add Product */
    public static function add_record($data)
    {
        global $wpdb;
        $query = 'INSERT INTO ' .  self::table_name  . ' ';
        $query .= '(date, url, ip, ref, ua) ';
        $query .= "VALUES ('{$data['date']}','{$data['url']}','{$data['ip']}','{$data['ref']}','{$data['ua']}');";

        $wpdb->query( $query );

        $index = $wpdb->get_var('SELECT LAST_INSERT_ID();');
        return $index;
    }

    /** Add Product */
    public static function save_record($data)
    {
        global $wpdb;

        // if exist extra, save code here...
        $extra_info = array(
            'display_position' => $data['display_position'],
            'overlay_type' => $data['overlay_type'],
            'overlay_effect' => $data['overlay_effect'],
            'time_overlay_appear' => $data['time_overlay_appear'],
            'overlay_template' => $data['overlay_template'],

            'message_text' => $data['message_text'],
            'message_font' => $data['message_font'],
            'message_color' => $data['message_color'],
            'message_bold' => $data['message_bold'],
            'message_size' => $data['message_size'],

            'link_text' => $data['link_text'],
            'link_font' => $data['link_font'],
            'link_url' => $data['link_url'],
            'link_color' => $data['link_color'],
            'link_bold' => $data['link_bold'],
            'link_size' => $data['link_size'],

            'privacy_text' => $data['privacy_text'],
            'privacy_font' => $data['privacy_font'],
            'privacy_color' => $data['privacy_color'],
            'privacy_bold' => $data['privacy_bold'],
            'privacy_size' => $data['privacy_size'],

            'description_font' => $data['description_font'],
            'description_color' => $data['description_color'],
            'description_bold' => $data['description_bold'],
            'description_size' => $data['description_size'],

            'social_media_icons' => $data['social_media_icons'],
            'product_info' => $data['product_info'],
            'overlay_sub_type' => $data['overlay_sub_type'],
            'overlay_just_email_type' =>$data['overlay_just_email_type'],
            'overlay_privacy_type' =>$data['overlay_privacy_type'],
            'use_iframe_type' =>$data['use_iframe_type'],
            'description_info' => $data['description_info']
        );
        $extra_info = maybe_serialize($extra_info);


        $views = 0;
        $optins = 0;
        $optin_percent = 0;
        $current_time = date("Y-m-d h:i a");
        $local_time = strtotime($current_time) + intval(get_option('gmt_offset')) * 60 * 60;
        $start_date = date('Y-m-d', $local_time);

        $query = "update " . self::table_name . " ";
        $query .= "set page_id='{$data['page_id']}', name='{$data['campaign_name']}', url='{$data['campaign_url']}', views='{$views}', ";
        $query .= "optins='{$optins}', optin_percent='{$optin_percent}', start_date='{$start_date}', overlay_design_type='{$data['overlay_design_type']}', ";
        $query .= "autoresponder_code='{$data['autoresponder_code']}', autoresponder_hidden_field='{$data['autoresponder_hidden_field']}', autoresponder_action_field='{$data['autoresponder_action_field']}', ";
        $query .= "autoresponder_name_field='{$data['autoresponder_name_field']}', autoresponder_email_field='{$data['autoresponder_email_field']}', extra='{$extra_info}' ";
        $query .= "where id=" . $data['campaign_id'] . ";";

        $wpdb->query( $query );

        $index = $wpdb->get_var('SELECT LAST_INSERT_ID();');
        return $index;
    }


    /** Remove Product */
    public static function remove_record($id)
    {
        global $wpdb;

        $query = 'delete from ' . self::table_name . ' ';
        $query .= 'where id=' . $id . ';';

        $wpdb->query($query);
    }

    /** Get all Products */
    public static function get_all($orderby, $order, $pagenum, $per_page, $dm, $ft)
    {
        global $wpdb;

        $limit = ($pagenum - 1) * $per_page;

        $query = 'SELECT * FROM ' . self::table_name . ' ';

        // filtering
        $filter = '';
        if($dm != '0') {
            $current_time = date("Y-m-d h:i a");
            $local_time = strtotime($current_time) + intval(get_option('gmt_offset')) * 60 * 60;
            $start_date = date('Y-m-d', $local_time);
            list($year, $month, $day) = explode('-', $start_date);

            if($dm == 'last_month') {
                $month = intval($month) - 1;
            }
            elseif ($dm == 'last_month_3') {
                $month = intval($month) - 3;
            }
            elseif ($dm == 'last_month_6') {
                $month = intval($month) - 6;
            }
            elseif ($dm == 'last_year') {
                $year = intval($year) - 1;
            }
            if($month <= 0) {
                $month = intval($month) + 12;
                $year = $year - 1;
            }
            $compare_date = sprintf("%04d-%02d-00", $year, $month);
            $filter .= "where date >= '{$compare_date}' ";
        }

        if($ft != '0') {
            if($dm != '0') {
                $filter .= "and status = '{$ft}' ";
            }
            else {
                $filter .= "where status = '{$ft}' ";
            }
        }

        $query1 = 'Select count(*) from ' . self::table_name . ' ' . $filter;
        self::$found_count =  $wpdb->get_var($query1);

        $query .= $filter;

        $query .= 'ORDER BY ' . $orderby . ' ' . $order . ' ';
        $query .= 'LIMIT ' . $limit . ',' . $per_page . ';';

        $results = $wpdb->get_results($query, ARRAY_A);

        if(!is_array($results)) {
            $results = array();
            self::$found_count = 0;
            return $results;
        }

        return $results;
    }


    public static function get_count_element()
    {
        global $wpdb;
        $query = 'Select count(*) from ' . self::table_name . ';';
        $count = $wpdb->get_var($query);
        return $count;
    }

    public static function update_element($page_id, $data)
    {
        /*
        global $wpdb;
        $query = "update " . self::table_name . " ";
        $query .= "set sync_flag='{$data['sync_flag']}',photo_ids='{$data['photo_ids']}',product_ids='{$data['product_ids']}',extra='{$data['extra']}' ";
        $query .= "where page_id=" . $page_id . ";";
        $wpdb->query($query);
        */
    }
}
