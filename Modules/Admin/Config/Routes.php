<?php

$routes->group("admin", ["namespace" => "\Modules\Admin\Controllers"], function ($routes) {

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
