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
 

});

$routes->group("ct",["namespace" => "\Modules\Admin\Controllers\web"],function($routes){

    $routes->add("dashboard", "Dashboard::index"); //Get Dashboard
    //$routes->get("/categories", "Category::index"); //Get Categories Page
    //$routes->post("login","Login::login"); //Login User
    //$routes->get("logout","Login::logout"); //Logout Functionality
	
	$routes->add("createNewUser", "Users::create_user"); // createNewUser Functionality
	$routes->add("listUsers", "Users::list_users"); 
	$routes->add("editUsers", "Users::edit_users"); 
	
	$routes->add("activateProvider", "Serviceproviders::activate_provider"); 
	$routes->add("list_providers", "Serviceproviders::list_providers");
	$routes->add("editServiceProviders", "Serviceproviders::edit_serviceproviders");
	
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
	
	$routes->add("newJobs", "Postjob::new_jobs"); 
	$routes->add("postJob", "Postjob::post_job");
	
	$routes->add("createTickets", "Support::create_tickets"); 
	$routes->add("listAllTickets", "Support::list_tickets");
	
	$routes->add("categories", "General::categories"); 
	$routes->add("subcategories", "General::subcategories");
	$routes->add("keywords", "General::keywords"); 
	$routes->add("languages", "General::languages");
	$routes->add("professions", "General::professions"); 
	$routes->add("qualifications", "General::qualifications");
	$routes->add("addCategory", "General::add_category");
	$routes->add("addSubCategory", "General::add_sub_category"); 
	$routes->add("editSubCategory", "General::edit_subcategory");
	$routes->add("editKeywords", "General::edit_keywords");
	
	
	$routes->add("viewPosts", "Blogs::view_posts"); 
	$routes->add("createNewPost", "Blogs::create_newpost");
	
	$routes->add("cancellationCharges", "Charges::cancellation_charges");
	$routes->add("userPlans", "Charges::user_plans"); 
	$routes->add("providerPlans", "Charges::provider_plans");
	$routes->add("addCancellationCharge", "Charges::add_cancellation_charge");
	$routes->add("addUserPlan", "Charges::add_userplan");
	$routes->add("addProviderPlan", "Charges::add_providerplan"); 
	$routes->add("editCancellationCharge", "Charges::edit_cancellation_charge");
	$routes->add("editUserPlan", "Charges::edit_userplan");
	$routes->add("editProviderPlan", "Charges::edit_providerplan");


});
