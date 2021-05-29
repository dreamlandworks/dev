<?php

$routes->group("user", ["namespace" => "\Modules\User\Controllers\api"], function ($routes) {

    //Routes pertaining to User Functionality
    $routes->post("login", "LoginController::login"); // User Login API   
    $routes->get("show/(:num)", "UsersController::show/$1"); //Get User Data by ID
    $routes->post("newuser", "UsersController::new_user"); //For New User Registration API
    $routes->post("changepwd", "UsersController::update_pass"); //For Change Password API
   
   //Routes pertaining to SMS Functionality
    $routes->get("sms/show/(:any)", "SmsController::show/$1"); //Get SMS Template details by ID/Name
    $routes->get("sms", "SmsController::index"); //Get all SMS Template details
    $routes->post("regsms", "SmsController::reg_sms"); // Send Registration OTP with SMS
    $routes->post("forgot", "SmsController::forgot_sms"); // Send Forgot Password OTP with SMS
    $routes->post("sms/new", "SmsController::create"); //Get SMS Template details by ID/Name

    //Routes pertaining to Temporary User
    $routes->get("del_temp/(:num)","UsersController::delete_temp/$1");

});
