<?php 

namespace MyReactPlugin\Core;

use MyReactPlugin\Database\FormTableCreator;
Use MyReactPlugin\Ajax\FormSubmissionHandler;

class PluginInit{
    public static function register() {
        (new FormTableCreator())->register();
        (new FormSubmissionHandler())->register();
    }
}