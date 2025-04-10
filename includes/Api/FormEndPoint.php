<?php 
namespace MyReactPlugin\Api;

use MyReactPlugin\Database\FormTableCreator;

class FormEndPoint {
    public function registerRoutes(){
        register_rest_route('my-plugin/v1', '/submit-form', [
            'methods' => 'POST',
            'callback' => [$this, 'handleForm'],
            'permission_callback' => '__return_true',
        ]);
    }

    // public function handleForm($request) {
    //     $data = $request->get_json_params();

    //     $name = sanitize_text_field($data['name'] ?? '');
    //     $username = sanitize_text_field($data['username'] ?? '');
    //     $email = sanitize_email($data['email'] ?? '');
    //     $message = sanitize_textarea_field($data['message'] ?? '');

    //     if(empty($name) || empty($username) || empty($email)) {
    //         return new \WP_REST_Response(['message' => 'Required fields are missing'], 400);
    //     }

    //     $db = new FormTableCreator();
    //     $db->createGeneralDataTable();
    //     $inserted = $db->insertGeneralData($name, $username, $email, $message);

    //     if($inserted) {
    //         return new \WP_REST_Response(['message' => 'Form Submitted Successful']);
    //     }

    //     return new \WP_REST_Response(['message' => 'Submission Failed'], 500);

    // }
    public function handleForm($request) {
        try {
            $data = $request->get_json_params();
    
            $name = sanitize_text_field($data['name'] ?? '');
            $username = sanitize_text_field($data['username'] ?? '');
            $email = sanitize_email($data['email'] ?? '');
            $message = sanitize_text_field($data['message'] ?? '');
    
            if (empty($name) || empty($username) || empty($email)) {
                return new \WP_REST_Response(['message' => 'Required fields missing'], 400);
            }
    
            $db = new \MyReactPlugin\Database\FormTableCreator();
            $db->createGeneralDataTable();
            $inserted = $db->insertGeneralData($name, $username, $email, $message);
    
            if ($inserted) {
                return new \WP_REST_Response(['message' => 'Form submitted successfully']);
            }
    
            return new \WP_REST_Response(['message' => 'Database insert failed'], 500);
        } catch (\Throwable $e) {
            return new \WP_REST_Response([
                'message' => 'Caught exception: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ], 500);
        }
    }
    
}