<?php 

namespace MyReactPlugin\Ajax;

class FormSubmissionHandler {
    public function register(){
        add_action('wp_ajax_save_form_data', [$this, 'handle']);
        add_action('wp_ajax_get_section_data', [$this, 'fetch_section']);
    }

    public function handle(){
        check_ajax_referer('form_data_nonce', 'nonce');
        
        if(!current_user_can('manage_options')){
            wp_send_json_error(['message' => 'Unauthorized']);
        }

        $field_type = sanitize_text_field($_POST['field_type'] ?? 'general');
        global $wpdb;

        $data_table = $wpdb->prefix . 'form_' . strtolower($field_type) . '_data';
        $section_table = $wpdb->prefix . 'form_sections';

        $inserted = $wpdb->insert($data_table, [
            'name' => sanitize_text_field($_POST['name'] ?? ''),
            'username' => sanitize_text_field($_POST['username'] ?? ''),
            'email' => sanitize_email($_POST['email'] ?? ''),
            'message' => sanitize_textarea_field($_POST['message'] ?? ''),
        ]);
        if ($inserted) {
            $existing = $wpdb->get_row($wpdb->prepare("SELECT * FROM $section_table WHERE field_type = %s", ucfirst($field_type)));
            $user_id = get_current_user_id();

            if ($existing) {
                $existing_users = array_filter(explode(',', $existing->created_by));
                if (!in_array($user_id, $existing_users)) {
                    $existing_users[] = $user_id;
                }
                $wpdb->update(
                    $section_table,
                    [
                        'total_data' => $existing->total_data + 1,
                        'created_by' => implode(',', $existing_users)
                    ],
                    ['id' => $existing->id]
                );
            } else {
                $wpdb->insert($section_table, [
                    'field_type' => ucfirst($field_type),
                    'total_data' => 1,
                    'created_by' => $user_id
                ]);
            }

            wp_send_json_success(['message' => 'Saved successfully']);
        } else {
            wp_send_json_error(['message' => 'Failed to save']);
        }
    }

    public function fetch_section() {
        check_ajax_referer('form_data_nonce', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error(['message' => 'Unauthorized']);
        }

        global $wpdb;
        $field_type = sanitize_text_field($_POST['field_type'] ?? 'General');
        $section_table = $wpdb->prefix . 'form_sections';
        $data_table = $wpdb->prefix . 'form_' . strtolower($field_type) . '_data';

        $section = $wpdb->get_row($wpdb->prepare("SELECT * FROM $section_table WHERE field_type = %s", $field_type), ARRAY_A);
        $entries = $wpdb->get_results("SELECT * FROM $data_table ORDER BY created_at DESC", ARRAY_A);

        if ($section) {
            $user_ids = array_filter(explode(',', $section['created_by']));
            $roles = [];
            foreach ($user_ids as $id) {
                $user = get_userdata((int)$id);
                if ($user) {
                    $roles[] = implode(', ', $user->roles);
                }
            }
            $response = [
                'section' => [
                    'field_type' => $section['field_type'],
                    'total_data' => $section['total_data'],
                    'created_by_count' => count($user_ids),
                    'created_by_roles' => $roles,
                    'created_at' => $section['created_at']
                ],
                'entries' => $entries
            ];
            wp_send_json_success($response);
        } else {
            wp_send_json_error(['message' => 'Section not found']);
        }
    }

}