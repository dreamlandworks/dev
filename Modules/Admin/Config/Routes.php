<?php

$routes->group("admin", ["namespace" => "\Modules\Admin\Controllers\api"], function ($routes) {

    // Routes pertaining to Categories Module
    $routes->post("addcat","CategoryController::add_category"); // Create New
    $routes->get("cat/show","CategoryController::showCat"); // Show Category
    $routes->post("cat/update","CategoryController::updateCat"); // Update Category
    $routes->post("cat/delete","CategoryController::deleteCat"); // Delete Category

    //Routes Pertaining to Sub Category Module
    $routes->post("subcat/add","CategoryController::add_subcat"); // Create New
    $routes->post("subcat/update","CategoryController::updateSubCat"); // Update SubCategory
    $routes->get("subcat/show","CategoryController::showSubCat"); // show All Categories
    $routes->post("subcat/delete","CategoryController::deleteSubCat"); // Delete Sub Categories
    
    //Routes Pertaining to Keywords Module
    $routes->post("key/add","CategoryController::add_keyword"); // Create New
    $routes->post("key/update","CategoryController::updateKey"); // Update Keywords
    $routes->get("key/show","CategoryController::showKey"); // show All Keywords
    $routes->post("key/delete","CategoryController::deleteKey"); // Delete Keywords
	
	
	//Routes pertaining to User deletion
	$routes->post("user/delete","MiscController::delete_user"); // Delete user
   
    //Routes Pertaining to Cron Jobs
    $routes->get("hourly_cron","MiscController::hourly_cron"); // Hourly Cron Jobs
    $routes->get("daily_cron","MiscController::daily_cron"); // Daily Cron Jobs
    $routes->get("five_minute_cron","MiscController::five_minute_cron"); // Five Minutes Cron Jobs
    $routes->get("fifteen_minute_cron","MiscController::fifteen_minute_cron"); // Fifteen Minutes Cron Jobs

});

//Admin Panel Routes

$routes->group("ct",["namespace" => "\Modules\Admin\Controllers\web"],function($routes){
	$routes->add('login', 'Dashboard::login');

    $routes->add("dashboard", "Dashboard::index"); //Get Dashboard
    // X-> Seen By Aniket
    $routes->add("createNewUser", "Users::create_user"); // createNewUser Functionality  X
	$routes->add("listUsers", "Users::list_users"); //Get List of Users  X
    $routes->add("editUsers/(:any)", "Users::edit_users/$1");   // X
    $routes->delete("deleteUser/(:num)", "Users::delete_user/$1"); //Delete User  X
	$routes->add("create_user_submit", "Users::create_user_submit"); // X
	$routes->add("edit_user_submit", "Users::edit_user_submit"); // X
    	
	$routes->add("activateProvider", "Serviceproviders::get_provider_data"); //Get Service Providers which are not approved. -X
	$routes->add("providerdata/(:num)", "Serviceproviders::get_more_sp_data/$1"); // Ajax  HTML render -X Gone Not Clear With idea!!!!!
    $routes->add("approve", "Serviceproviders::approve_sp"); //Approve/ Reject SP X -Ajax Call

	$routes->add("list_providers", "Serviceproviders::list_providers");
	$routes->add("editServiceProviders/(:num)", "Serviceproviders::edit_serviceproviders/$1");
	$routes->post("updateSpDetails", "Serviceproviders::updateSpProvider");

	$routes->post('listOfStateAjax', "Serviceproviders::listOfStateAjax");
	$routes->post('listOfCity', "Serviceproviders::listOfCity");
	
	$routes->add("receipts", "Accounts::receipts"); 
	$routes->add("receiptsDue", "Accounts::receiptsDue");
	$routes->add("paymentRequests", "Accounts::paymentRequests"); 
	$routes->add("paymentDone", "Accounts::paymentDone");
	
	$routes->add("createNewBooking", "Bookings::create_booking"); 
	$routes->add("listBooking", "Bookings::list_booking");
	$routes->add("booking_inprogress", "Bookings::bookingsInProgress");
	$routes->add("booking_completed", "Bookings::bookingCompleted"); 
	$routes->add("singleMoveForm", "Bookings::single_move_form"); 
	$routes->add("multiMoveForm", "Bookings::multi_move_form");
	$routes->add("blueCollorForm", "Bookings::blue_collor_form"); 
	$routes->add("listBookingView", "Bookings::list_booking_view"); 
	
	$routes->add("newJobs", "Postjob::new_jobs"); 
	$routes->add("postJob", "Postjob::post_job");
	$routes->add("viewNewjobs", "Postjob::view_newjobs");
	
	$routes->add("createTickets", "Support::create_tickets"); 
	$routes->add("create_ticket_submit", "Support::create_ticket_submit");
	$routes->add("listAllTickets", "Support::list_tickets");
	$routes->add("viewTickets", "Support::view_tickets");
	$routes->add("editTickets/(:any)", "Support::edit_tickets/$1");
	$routes->add("edit_ticket_submit", "Support::edit_ticket_submit"); 
	$routes->add("deleteTicket", "Support::delete_tickets");
	
	
	$routes->add("categories", "General::categories"); 
	$routes->add("subcategories", "Generalus::subcategories");
	$routes->add("keywords", "General::keywords"); 
	$routes->add("languages", "General::languages");
	$routes->add("professions", "General::professions"); 
	$routes->add("qualifications", "General::qualifications");
	$routes->add("addCategory", "General::add_category");
	$routes->add("addSubCategory", "General::add_sub_category"); 
	$routes->add("editKeywords/(:any)", "General::edit_keywords/$1");
	$routes->add("editStatus", "General::edit_status");
	$routes->add("editSubcategoryStatus", "General::edit_subcategory_status");
	$routes->add("editKeywordStatus", "General::edit_keyword_status");
	$routes->add("editCategory/(:any)", "General::edit_category/$1");
	$routes->add("editSubCategory/(:any)", "General::edit_subcategory/$1");
	$routes->add("create_category_submit", "General::create_category_submit");
	$routes->add("edit_category_submit", "General::edit_category_submit");
	$routes->add("create_subcategory_submit", "General::create_subcategory_submit");
	$routes->add("edit_subcategory_submit", "General::edit_subcategory_submit");
	$routes->add("create_keyword_submit", "General::create_keyword_submit");
	$routes->add("edit_keyword_submit", "General::edit_keyword_submit");
	$routes->add("edit_language_submit", "General::edit_language_submit");
	$routes->add("deleteCategory", "General::delete_category");
	$routes->add("deleteSubCategory", "General::delete_subcategory");
	$routes->add("deleteKeyword", "General::delete_keyword");
	$routes->add("deleteLanguage", "General::delete_language");
	$routes->add("addKeywords", "General::add_keywords");
	$routes->add("create_language_submit", "General::create_language_submit");
	$routes->add("create_profession_submit", "General::create_profession_submit");
	$routes->add("edit_profession_submit", "General::edit_profession_submit");
	$routes->add("deleteProfession", "General::delete_profession");
	$routes->add("create_qualification_submit", "General::create_qualification_submit");
	$routes->add("edit_qualification_submit", "General::edit_qualification_submit");
	$routes->add("deleteQualification", "General::delete_qualification");
	
	$routes->add("viewPosts", "Blogs::view_posts"); 
	$routes->add("createNewPost", "Blogs::create_newpost");
	
	$routes->add("cancellationCharges", "Charges::cancellation_charges");
	$routes->add("userPlans", "Userplan::user_plans"); 
	$routes->add("addUserPlan", "Userplan::add_userplan");
	$routes->add("create_userplan_submit", "Userplan::create_userplan_submit");
	$routes->add("editUserplan/(:any)", "Userplan::edit_userplan/$1");
	$routes->add("edit_userplan_submit", "Userplan::edit_userplan_submit");
	$routes->add("deleteUserplan", "Userplan::userplan_delete");
	
	$routes->add("providerPlans", "Providerplan::provider_plans");
	$routes->add("addProviderPlan", "Providerplan::add_providerplan");
	//$routes->add("editProviderPlan", "Providerplan::edit_providerplan");
	$routes->add("create_providerplan_submit", "Providerplan::create_providerplan_submit");
	$routes->add("editProviderplan/(:any)", "Providerplan::edit_providerplan/$1");
	$routes->add("edit_providerplan_submit", "Providerplan::edit_providerplan_submit");
	$routes->add("deleteProviderplan", "Providerplan::providerplan_delete");
	
	$routes->add("addCancellationCharge", "Charges::add_cancellation_charge");
	//$routes->add("addUserPlan", "Charges::add_userplan");
	
	$routes->add("editCancellationCharge/(:any)", "Charges::edit_cancellation_charge/$1");
	//$routes->add("editUserPlan", "Charges::edit_userplan");
	
	$routes->add("deleteCancellationCharges", "Charges::delete_cancellationCharges");
    $routes->add("create_cancellationCharge_submit", "Charges::create_cancellationCharge_submit");
	$routes->add("edit_cancellationCharge_submit", "Charges::edit_cancellationCharge_submit");
	
	$routes->add("deleteBooking", "Bookings::delete_booking");
	$routes->add("listBookingView/(:any)", "Bookings::list_booking_view/$1");
	$routes->add("create_singleMoveForm_submit", "Bookings::create_singleMoveForm_submit");
	$routes->add("create_blueCollorForm_submit", "Bookings::create_blueCollorForm_submit");
	$routes->add("create_multiMoveForm_submit", "Bookings::create_multiMoveForm_submit");


});
