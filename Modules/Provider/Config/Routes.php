<?php

$routes->group("provider", ["namespace" => "\Modules\Provider\Controllers\api"], function ($routes) {

    $routes->get("get_profession_list", "MiscController::get_profession_list"); //Get Professionals List
    $routes->get("get_qualification_list", "MiscController::get_qualification_list"); //Get Qualification List
    $routes->get("get_experience_list", "MiscController::get_experience_list"); //Get Experience List
    $routes->get("get_language_list", "MiscController::get_language_list"); //Get Experience List
    $routes->get("get_day_slot_list", "MiscController::get_day_slot_list"); //Get Day Slot List 
    $routes->get("get_initialization_list", "MiscController::get_initialization_list"); //Get List of all necessary data 
    $routes->post("post_user_review", "MiscController::post_user_review"); //Post User Review 
    
    $routes->post("confirm_activation", "Activation::confirm_activation"); //For SP Registration API
    $routes->post("id_proof", "Activation::id_proof"); //For SP Registration API
    $routes->post("video_verification", "Activation::video_verification"); //For SP Registration video verificationAPI 
    $routes->post("get_sp_professional_details", "Activation::get_sp_professional_details"); 
    $routes->post("update_sp_prof_details", "Activation::update_sp_prof_details"); 
    $routes->post("update_sp_tariff_time_slot", "Activation::update_sp_tariff_time_slot"); 
    
    $routes->post("update_location", "Location::update_location"); //For SP Location Update API
    $routes->post("update_sp_online_status", "Location::update_sp_online_status"); //For SP Online status Update API
    
    //Routes pertaining to FAQ
    $routes->get("sp_faq", "MiscController::sp_faq"); //Get all the SP related Faq
    
    //Routes pertaining to sp plans
    $routes->get("sp_plans", "MiscController::sp_plans"); //Get all the SP plans
    
    //Routes pertaining to sp dashboard
    $routes->get("sp_dashboard", "DashboardController::get_sp_dasboard_list"); //Get SP dashboard
    
    //Routes pertaining to Booking
    $routes->post("post_sp_extra_demand", "SPBookingController::post_sp_extra_demand"); //For SP Post Extra demand
    $routes->post("get_sp_booking_details", "SPBookingController::get_sp_booking_details"); //For SP Post Extra demand 
    $routes->post("update_final_expenditure", "SPBookingController::update_final_expenditure"); //Update Extra demand expenditure incurred 
    $routes->post("get_booking_work_summary", "SPBookingController::get_booking_work_summary");  //Booking Work Summary
    $routes->get("get_goals_installments_list", "SPBookingController::get_goals_installments_list");  //Goals/Installments
    $routes->post("job_post_request_installment", "SPBookingController::job_post_request_installment");  //Request Installment 
    $routes->post("pause_booking", "SPBookingController::pause_booking");  //Pause Booking 
    $routes->post("resume_booking", "SPBookingController::resume_booking");  //Resume Booking 
    $routes->post("sp_job_post_bids_list", "SPBookingController::get_sp_job_post_bids_list"); //Get SP Job Post Bids List 
    $routes->post("sp_job_post_list", "SPBookingController::get_sp_job_post_list"); //Get SP Job Post Bids List 
    $routes->post("sp_post_bid", "SPBookingController::sp_post_bid"); //SP Post Bids 
    $routes->post("sp_edit_bid", "SPBookingController::sp_edit_bid"); //SP Edit Bids 
    $routes->post("delete_bid_attachment", "SPBookingController::delete_bid_attachment"); //Delete attachment
    $routes->post("sp_new_job_post_list", "SPBookingController::get_sp_new_job_post_list"); //New jobs
    
    $routes->post("get_sp_upcoming_booking_details", "SPBookingController::get_sp_upcoming_booking_details"); //SP Upcoming Booking
    
    //Routes pertaining to Alerts
    $routes->post("get_sp_alerts","MiscController::get_sp_alerts");// Get Unread Alerts by ID
    $routes->post("update_sp_alert","MiscController::update_sp_alert");// Update Alerts Status to read by ID
    
    //Routes pertaining to SP Account
    $routes->get("get_sp_account_details", "MyAccount::get_sp_account_details"); //Get SP account details
    $routes->get("get_sp_review_details", "MyAccount::get_sp_review_details"); //Get SP account details 
    
    $routes->post("membership_payments", "MembershipController::membership_payments"); //Membership payments
    
    $routes->get("get_leaderboard_list", "LeaderboardController::get_leaderboard_list"); //Get Leaderboard List
    $routes->get("get_training_list", "MiscController::get_training_list"); //Get Training Videos List
    $routes->get("update_sp_watched_video", "MiscController::update_sp_watched_video"); //Update watched video
});
