<?php 

namespace MyReactPlugin\Core;

use MyReactPlugin\Database\FormTableCreator;
Use MyReactPlugin\Api\FormEndPoint;

class PluginInit{
    public static function register() {
        add_action('init', [self::class, 'onInit']);
        add_action('rest_api_init', [self::class, 'onApiInit']);
        register_activation_hook(MY_REACT_PLUGIN_FILE, [self::class, 'onActivate']);
    }

    public static function oninit(){

    }
    public static function onActivate(){
        $tableCreator = new FormTableCreator();
        $tableCreator->createTabsTable();
    }

    public static function onApiInit() {
        $formEndPoint = new FormEndPoint();
        $formEndPoint->registerRoutes();
    }
}