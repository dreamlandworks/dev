<?php

$routes->group("provider", ["namespace" => "\Modules\Provider\Controllers\api"], function ($routes) {

    $routes->get("get_profession_list", "MiscController::get_profession_list"); //Get Professionals List
    $routes->get("get_qualification_list", "MiscController::get_qualification_list"); //Get Qualification List
    $routes->get("get_experience_list", "MiscController::get_experience_list"); //Get Experience List
    $routes->get("get_language_list", "MiscController::get_language_list"); //Get Experience List
    $routes->get("get_day_slot_list", "MiscController::get_day_slot_list"); //Get Day Slot List 
    $routes->get("get_initialization_list", "MiscController::get_initialization_list"); //Get List of all necessary data 
    
    $routes->post("confirm_activation", "Activation::confirm_activation"); //For SP Registration API
    $routes->post("video_verification", "Activation::video_verification"); //For SP Registration video verificationAPI

});
