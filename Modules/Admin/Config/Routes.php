<?php

$routes->group("admin", ["namespace" => "\Modules\Admin\Controllers"], function ($routes) {

    $routes->post("addcat","CategoryController::add_category"); // Create New Category
    $routes->post("add_subcat","CategoryController::add_subcat"); // Create New Sub Category
    $routes->post("add_keyword","CategoryController::add_keyword"); // Create New Keyword

    

});
