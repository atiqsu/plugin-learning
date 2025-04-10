<?php 

namespace MyReactPlugin\Database;

class FormTableCreator {
    private $wpdb;
    private $charset;

    public function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->charset = $wpdb->get_charset_collate();    
    }

    public function createTabsTable(){
        $table = $this->wpdb->prefix . 'show_tabs';
        $sql = "CREATE TABLE IF NOT EXISTS $table (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            tab_name varchar(50) NOT NULL,
            total_form_data INT DEFAULT 0,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $this->charset;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        //Ensure column exists
        $check_column =$this->wpdb->get_results("SHOW COLUMNS FROM $table LIKE 'total_form_data'");
        if(empty($check_column)){
            $this->wpdb->query("ALTER TABLE $table ADD total_form_data INT DEFAULT 0 AFTER tab_name");
        }

        $default_tabs = ['General', 'Advanced', 'Custom'];
        foreach($default_tabs as $tab){
            $tab_exists =  $this->wpdb->get_var(
                $this->wpdb->prepare("SELECT COUNT(*) FROM $table WHERE tab_name = %s", $tab)
            );
            if(!$tab_exists) {
                $this->wpdb->insert($table, ['tab_name' => $tab]);
            }
        }
    }


    public function createNestedFormDataTable($tab_name){
        $tabs_table = $this->wpdb->prefix . 'show_tabs';
        $tab_id = $this->wpdb->get_var(
            $this->wpdb->prepare("SELECT id FROM $tabs_table WHERE tab_name = %s", $tab_name )
        );
        if(!$tab_id) return;

        $sanitized = strtolower(sanitize_title($tab_name));
        $table = $this->wpdb->prefix . $sanitized . '_default_form_data';

        $sql = "CREATE TABLE IF NOT EXISTS $table (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            tab_id mediumint(9) NOT NULL,
            name varchar(100),
            username varchar(100),
            email varchar(100),
            message text,
            submitted_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $this->charset;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    public function insertToNestedFormTable($tab_name, $name, $username, $email, $message){
        $tabs_table = $this->wpdb->prefix . 'show_tabs';
        $tab_id = $this->wpdb->get_var(
            $this->wpdb->prepare("SELECT id FROM $tabs_table WHERE tab_name = %s", $tab_name)
        );
        if(!$tab_id) return false;

        $sanitized = strtolower(sanitize_title($tab_name));
        $table = $this->wpdb->prefix . $sanitized . '_default_form_data';

        $inserted = $this->wpdb->insert($table, [
            'tab_id' => $tab_id,
            'name' => $name,
            'username' => $username,
            'email' => $email,
            'message' => $message
        ]);

        if($inserted) {
           $total = $this->wpdb->get_var("SELECT COUNT(*) FROM $table WHERE tab_id = $tab_id");

           //update with correct total form data
           $this->wpdb->update(
            $tabs_table,
            ['total_form_data' => $total],
            ['id' => $tab_id]
           );
        }
        return $inserted;
    }

    // public function createGeneralDataTable() {
    //     $tabs_table = $this->wpdb->prefix . 'show_tabs';
    //     $tab_id = $this->wpdb->get_var("SELECT id FROM $tabs_table WHERE tab_name = 'General'");
    //     if(!$tab_id) return;

    //     $table = $this->wpdb->prefix . 'general_default_form_data';
    //     $sql = "CREATE TABLE IF NOT EXISTS $table (
    //         id mediumint(9) NOT NULL AUTO_INCREMENT,
    //         tab_id mediumint(9) NOT NULL,
    //         name varchar(100),
    //         username varchar(100),
    //         email varchar(100),
    //         message text,
    //         submitted_at datetime DEFAULT CURRENT_TIMESTAMP,
    //         PRIMARY KEY (id)
    //     ) $this->charset;";
    //     require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    //     dbDelta($sql);
    // }

    // public function insertGeneralData($name, $username, $email, $message) {
    //     $tabs_table = $this->wpdb->prefix . 'show_tabs';
    //     $tab_id = $this->wpdb->get_var("SELECT id FROM $tabs_table WHERE tab_name = 'General'");
    //     if(!$tab_id) return false;

    //     $table = $this->wpdb->prefix . 'general_default_form_data';
    //     return $this->wpdb->insert($table, [
    //         'tab_id' => $tab_id,
    //         'name' => $name,
    //         'username' => $username,
    //         'email' => $email,
    //         'message' => $message
    //     ]);

    // }


}