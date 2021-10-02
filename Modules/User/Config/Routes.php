<?php

$routes->group("user", ["namespace" => "\Modules\User\Controllers\api"], function ($routes) {

    //Routes pertaining to User Login/ Registration Functionality
    $routes->post("login", "LoginController::login"); // User Login API   
    $routes->post("newuser", "UsersController::new_user"); //For New User Registration API
    $routes->post("changepwd", "UsersController::update_pass"); //For Change Password API
    $routes->post("verify", "LoginController::verify"); // User Verification API   
    
    //Routes pertaining to User Profile, Updation and Address Deletion
    $routes->post("show", "UserProfileController::show_user"); //Get User Data by ID
    $routes->post("update", "UserProfileController::update_profile"); //For Change Password API
    $routes->post("delete/address", "UserProfileController::delete_address"); //For Delete Address API
   
       //Routes pertaining to SMS Functionality
    $routes->get("sms/show/(:any)", "SmsController::show/$1"); //Get SMS Template details by ID/Name
    $routes->get("sms", "SmsController::index"); //Get all SMS Template details
    $routes->post("regsms", "SmsController::reg_sms"); // Send Registration OTP with SMS
    $routes->post("forgot", "SmsController::forgot_sms"); // Send Forgot Password OTP with SMS
    $routes->post("sms/new", "SmsController::create"); //Get SMS Template details by ID/Name

    //Routes pertaining to Categories & Sub Categories
    $routes->get("cat", "MiscController::getCat"); //Get all the Categories
    $routes->get("subcat", "MiscController::getSub"); //Get all the Sub-Categories
    $routes->post("subcat/id", "MiscController::get_sub_by_cat"); //Get Sub-Categories by Category ID
    $routes->get("keywords", "MiscController::get_keywords"); //Get Sub-Categories by Category ID
    $routes->get("autocomplete", "MiscController::get_keywords_autocomplete"); //Get keyword and Sub-Categories
    $routes->get("phrase", "MiscController::get_search_phrase"); //Get Search Phrases to use for user search queries
    $routes->get("autocomplete_address", "MiscController::autocomplete_address"); //Get keyword and Sub-Categories
    $routes->post("offers_list", "MiscController::offers_list"); //Get keyword and Sub-Categories 
    

    //Routes pertaining to Alerts
    $routes->post("alerts/get","UsersController::get_alerts");// Get Unread Alerts by ID
    $routes->post("alerts/update","UsersController::update_alert");// Update Alerts Status to read by ID
    
    //Routes pertaining to Search
    $routes->post("search_result","SearchProvider::search_result");// Get List of SP matching the keyword and city
    
    //Routes pertaining to FAQ
    $routes->get("user_faq", "MiscController::user_faq"); //Get all the User related Faq
    
    //Routes pertaining to user plans
    $routes->get("user_plans", "MiscController::user_plans"); //Get all the User plans
    $routes->get("bid_range", "MiscController::bid_range"); //Get all the Bids Range
    $routes->get("goals_list", "MiscController::goals_list"); //Get all the Goals List 
    $routes->get("complaint_modules_list", "MiscController::complaint_modules_list"); //Get all the complaints List 
    
    $routes->post("post_complaints", "MiscController::post_complaints"); //Post complaints
    $routes->post("post_feedback", "MiscController::post_feedback"); //Post feedback 
    $routes->post("post_sp_review", "MiscController::post_sp_review"); //Post SP Review 
    $routes->post("post_complaints", "MiscController::post_complaints"); //Post complaints 
    
    //Routes pertaining to User changing address
    $routes->post("change_address", "MiscController::change_address"); //Change temporary address for search location
    $routes->post("user_temp_address", "MiscController::user_temp_address"); //Get List of users temp address
    $routes->post("add_address", "MiscController::add_address"); //Add multiple address
    $routes->post("delete_attachment", "MiscController::delete_attachment"); //Add attachment
    
    //Routes pertaining to User Booking/Payments
    $routes->post("single_move_booking", "BookingController::single_move_booking"); //Single Move booking
    $routes->post("blue_collar_booking", "BookingController::blue_collar_booking"); //Blue Collar booking
    $routes->post("multi_move_booking", "BookingController::multi_move_booking"); //Multi Move booking
    $routes->post("booking_payments", "BookingController::booking_payments"); //booking payments
    $routes->post("booking_details", "BookingController::get_booking_details"); //Get booking details
    $routes->post("user_booking_details", "BookingController::get_user_booking_details"); //Get User booking details
    $routes->post("sp_booking_response", "BookingController::sp_booking_response"); //Update SP response whether booking is accepted/rejected
    $routes->get("generate_otp", "BookingController::generate_otp"); //generate_otp 
    $routes->get("validate_otp", "BookingController::validate_otp"); //validate_otp
    $routes->post("cancel_booking", "BookingController::cancel_booking"); //Cancel Booking
    $routes->get("get_sp_slots", "BookingController::get_sp_slots"); //Get all the Sp Slots List 
    $routes->post("update_extra_demand_status", "BookingController::update_extra_demand_status");  //Update Extra demand details status 
    $routes->get("get_goals_installments_requested_list", "BookingController::get_goals_installments_requested_list"); //Get all the Goals List 
    $routes->get("get_booking_status_list", "BookingController::get_booking_status_list"); //Booking Status/History list 

    //Routes pertaining to User Reschedule Booking
    $routes->post("reschedule_booking", "BookingController::reschedule_booking");  //User end request to reschedule the booking
    $routes->post("update_reschedule_status_by_sp", "BookingController::update_reschedule_status_by_sp");   //User end request to accept/reject reschedule
    
    $routes->post("membership_payments", "MembershipController::membership_payments"); //Membership payments
    
    //Routes pertaining to User Job Post
    $routes->post("single_move_job_post", "PostjobController::single_move_job_post"); //Single Move Job Post
    $routes->post("blue_collar_job_post", "PostjobController::blue_collar_job_post"); //Blue Collar Job Post 
    $routes->post("multi_move_job_post", "PostjobController::multi_move_job_post"); //Multi Move Job Post 
    $routes->post("user_job_post_details", "PostjobController::get_user_job_post_details"); //Get Job Post details 
    $routes->post("job_post_details", "PostjobController::get_job_post_details"); //Get Job Post details 
    $routes->post("job_post_bids_list", "PostjobController::get_job_post_bids_list"); //Get Job Post Bids List
    $routes->post("job_post_bids_details", "PostjobController::get_job_post_bid_details"); //Get Job Post Bids Details 
    $routes->post("job_post_installments", "PostjobController::job_post_installments"); //Create Job Post installments 
    $routes->post("job_post_installments_payments", "PostjobController::job_post_installments_payments"); //Payment for Job Post installments 
    $routes->post("update_post_job_status", "PostjobController::update_post_job_status"); //Update Job Post status - Awarded/Rejected
    
    $routes->post("update_single_move_job_post", "PostjobController::update_single_move_job_post"); //Update Job Post Single Move
    $routes->post("update_blue_collar_job_post", "PostjobController::update_blue_collar_job_post"); //Update Job Post Blue Collar 
    $routes->post("update_multi_move_job_post", "PostjobController::update_multi_move_job_post"); //Update Job Post Multi Move 
    $routes->post("job_post_approve_reject_installment", "PostjobController::job_post_approve_reject_installment"); //Approve/Reject installment request 
    
    //Routes pertaining to FCM Token
    $routes->post("update_token", "MiscController::update_token"); //Update FCM Token
    
    //Routes pertaining to Transactions
    $routes->get("get_transaction_history", "TransactionsController::get_transaction_history"); //Get user transaction history
    
    //Routes pertaining to User Job Post Discussion
    $routes->post("post_discussion", "PostDiscussion::post_discussion"); //post discussion
    $routes->post("like_post_discussion", "PostDiscussion::like_post_discussion"); //post discussion 
    $routes->post("job_post_discussion_list", "PostDiscussion::get_job_post_discussion_list"); //post discussion list
    
    //Routes pertaining to User Account
    $routes->get("get_account_details", "MyAccount::get_account_details"); //Get User account details
});

$routes->group("",["namespace" => "\Modules\User\Controllers\web"],function($routes){

    $routes->get("/", "Home::index"); //Get Home Page
    $routes->get("/categories", "Category::index"); //Get Categories Page
    $routes->post("login","Login::login"); //Login User
    $routes->get("logout","Login::logout"); //Logout Functionality

});
