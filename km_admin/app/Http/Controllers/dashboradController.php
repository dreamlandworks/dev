<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class dashboradController extends Controller
{
    public function __construct() 
    {
      $this->middleware('auth');
    }
    
    public function index()
    {
        
        return redirect()->back();
    }
}
