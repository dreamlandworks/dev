<?php

namespace Modules\User\Controllers\web;

use App\Controllers\BaseController;
use Modules\User\Models\UserDetailsModel;

class Home extends BaseController
{
	public function index()
	{
		
		return view('Modules\User\Views\index');
				
	}
}
