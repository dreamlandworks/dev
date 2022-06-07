<?php

namespace Modules\User\Controllers\web;

use App\Controllers\BaseController;
use Modules\Provider\Models\CommonModel;

class Home extends BaseController
{
	public function index()
	{
		
		return view('Modules\User\Views\index');
				
	}

    public function terms()
	{
		
		return view('Modules\User\Views\terms');
				
	}

    public function privacy()
	{
		
		return view('Modules\User\Views\privacy');
				
	}

    public function disclaimer()
	{
		
		return view('Modules\User\Views\disclaimer');
				
	}

    public function ufaq()
	{
		$common = new CommonModel();
        $res = $common->get_table_details_dynamically('faq_users', 'id', 'ASC');

		return view('Modules\User\Views\userfaq',["res" => $res]);
				
	}

    public function spfaq()
	{
		$common = new CommonModel();
        $res = $common->get_table_details_dynamically('faq_sp', 'id', 'ASC');

		return view('Modules\User\Views\spfaq',["res" => $res]);
				
	}

    public function contact(){

        //Getting Variables from Post Data

        $name = $this->request->getVar('name');
        $email = $this->request->getVar('email');
        $subject = $this->request->getVar('subject');
        $message = $this->request->getVar('message');
        $sent_on = date('Y-m-d H:i:s');

        $arr = [
            'name'=> $name,
            'email'=> $email,
            'subject'=> $subject,
            'message'=> $message,
            'sent_on'=> $sent_on
        ];


        $common = new CommonModel();
        $common->insert_records_dynamically('contact_us',$arr);
                
    }
    
    public function subs(){

        // $mobile = $this->request->getVar('mobile');
        // $json = $this->request->getJSON();
        
        $mobile = $this->request->getVar('mobile');
        $sent_on = date('Y-m-d H:i:s');

        $arr = [
            'mobile'=> $mobile,
            'sent_on'=> $sent_on
        ];


        $common = new CommonModel();
        $common->insert_records_dynamically('contact_us',$arr);
        
        // return view('Modules\User\Views\index');

    }


}
