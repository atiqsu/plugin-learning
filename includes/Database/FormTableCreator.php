<?php 

namespace MyReactPlugin\Database;

class FormTableCreator {

    public function register() {
        register_activation_hook(MY_REACT_PLUGIN_FILE, [$this, 'create_table']);
    }

    public function create_table(){
        global $wpdb;
        $charset= $wpdb->get_charset_collate();

        $table_section = $wpdb->prefix . 'form_sections';
        
        $sql_section = "CREATE TABLE IF NOT EXISTS $table_section(
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            field_type varchar(50) NOT NULL,
            total_data int DEFAULT 0,
            created_by text NOT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset;";

        $tables = ['general', 'advanced', 'custom'];
        $sqls = [$sql_section];

        foreach($tables as $type){
            $table = $wpdb->prefix . "form_{$type}_data";
            $sqls[] = "CREATE TABLE IF NOT EXISTS $table (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                name varchar(100) NOT NULL,
                username varchar(100) NOT NULL,
                email varchar(100) NOT NULL,
                message text NOT NULL,
                created_at datetime DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (id)
            ) $charset;";
        }

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        foreach($sqls as $sql) {
            dbDelta($sql);
        }
    }
}