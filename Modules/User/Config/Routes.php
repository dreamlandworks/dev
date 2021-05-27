<?php

$routes->group("api", ["namespace" => "\Modules\User\Controllers"], function ($routes) {

    $routes->post("login", "LoginController::login"); // User Login API   

    $routes->get("show/(:num)", "UsersController::show/$1"); //Get User Data by ID
    $routes->post("newuser", "UsersController::new_user"); //For New User Registration API

    $routes->get("sms/show/(:any)", "SmsController::show/$1"); //Get SMS Template details by ID/Name
    $routes->get("sms", "SmsController::index"); //Get all SMS Template details
    $routes->post("regsms", "SmsController::reg_sms"); // Send Registration OTP with SMS
    $routes->post("sms/new", "SmsController::create"); //Get SMS Template details by ID/Name




});
