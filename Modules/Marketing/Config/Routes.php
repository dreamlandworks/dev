<?php

$routes->group("mkt", ["namespace" => "\Modules\Marketing\Controllers"], function ($routes) {

    //Routes pertaining to User Login/ Registration Functionality
    $routes->get("index", "Pages::index"); // User Login API   

});