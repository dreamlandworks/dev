<?php

namespace Modules\User\Models;

use CodeIgniter\Model;

class SmsTemplateModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'sms_templ';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = [
		"id", "pe_id", "header_id","sender", "template_id", "name", "content", "var"
	];

	// Dates
	protected $useTimestamps        = false;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';

	// Validation
	protected $validationRules      = [];
	protected $validationMessages   = [];
	protected $skipValidation       = false;
	protected $cleanValidationRules = true;

	// Callbacks
	protected $allowCallbacks       = true;
	protected $beforeInsert         = [];
	protected $afterInsert          = [];
	protected $beforeUpdate         = [];
	protected $afterUpdate          = [];
	protected $beforeFind           = [];
	protected $afterFind            = [];
	protected $beforeDelete         = [];
	protected $afterDelete          = [];


	//Required fields--'name' field

	public function show_by_name($name)
	{
		return $this->where("name", $name)->first();
	}

	//Required fields--'id' field

	public function show_by_id($id)
	{
		return $this->where("id", $id)->first();
	}


	//Model to create New SMS Template
	public function add_sms($array)
	{

		if (($this->insert($array)) != null) {
			return $this->getInsertID();
		} else {
			return null;
		}
	}

	//Required for creating SMS URL
	//Example:
	// $name = Name of the SMS Template i.e., sms_reg
	// $array = (['{#var#}'=>'user','{#var1#}'=>'search term','{#var3#}'=>'8008218399'])

	public function sms_api_url($name, $mobile, $array)
	{

		$count = count($array);

		$res = $this->show_by_name($name);
		//print_r($res);exit;
		//print_r($array);
		//exit;

		if ($res['var'] == $count) {

			if($count == 1){
				$search = ['{#var#}'];
				$replace = [$array['var']];
			}
			elseif($count == 2){
			    $search = ['{#var#}','{#var1#}'];
				$replace = [$array['var'],$array['var1']];
			}
			elseif($count == 3){
				$search = ['{#var#}','{#var1#}','{#var2#}'];
				$replace = [$array['var'],$array['var1'],$array['var2']];
			}
			elseif($count == 4){
				$search = ['{#var#}','{#var1#}','{#var2#}','{#var3#}'];
				$replace = [$array['var'],$array['var1'],$array['var2'],$array['var3']];
			}
			elseif($count == 5){
				$search = ['{#var#}','{#var1#}','{#var2#}','{#var3#}','{#var4#}'];
				$replace = [$array['var'],$array['var1'],$array['var2'],$array['var3'],$array['var4']];
			}

				$message = str_replace($search,$replace,$res['content']);
				//echo "<br> content ".$res['content'];exit;
				
				$data = [
					"username" => "Satrango",
					"password" => "Rango123",
					"type" => "TEXT",
					"sender"=> $res['sender'],
					"mobile" => $mobile,
					"message" => $message,
					"PEID" => $res['pe_id'],
					"HeaderId" => $res['header_id'],
					"TemplateId" =>$res['template_id']
				];
				
				$data = http_build_query($data);
				$data = str_replace("+","%20",$data);
				
				//echo "<br> data ".$data;exit;

			$url = "http://sms.prowtext.com/sendsms/sendsms.php?".$data;
			// echo $url;exit;

			// $ch = curl_init( );
			// curl_setopt ( $ch, CURLOPT_URL, $url);
			// // curl_setopt ( $ch, CURLOPT_PORT, $port );
			// curl_setopt ( $ch, CURLOPT_POST, 1 );
			// curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
			// // Allowing cUrl funtions 20 second to execute
			// curl_setopt ( $ch, CURLOPT_TIMEOUT, 5 );
			// // Waiting 20 seconds while trying to connect
			// curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 5 );                                 
			// $resp = curl_exec( $ch );
			// // echo $resp;exit;

			$resp = file_get_contents($url);
			$result = explode("|",$resp);
			
			return $result;
		}

		if ($res['var'] != $count) {

			return "This function accepts only " . $res['var'] . " fields in the array";
		}
	}
}
