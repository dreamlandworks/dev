<?php

namespace Modules\User\Models;

use CodeIgniter\Model;

class AddressModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'address';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = [
		'id', 'name', 'flat_no', 'apartment_name', 'landmark', 'locality', 'latitude', 'longitude', 'zipcode_id', 'users_id'
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

	//Function to search ID by name
	//Returns Address ID if available or else '0' if not available
	public function search_by_name($name)
	{
		$res = $this->where("name", $name)->first();
		if ($res) {
			return $res['id'];
		} else {
			return 0;
		}
	}

	//Function to search Address by ID
	//Returns address if available or else '0' if not available
	public function search_by_address_id($id)
	{
		$res = $this->where("id", $id)->first();
		if ($res != null) {
			return $res;
		} else {
			return 0;
		}
	}


	//Function to search Address by user ID
	//Returns address if available or else '0' if not available
	public function get_by_user_id($id)
	{

		$res = $this->select('address.id,address.name,address.flat_no,address.apartment_name,
							address.landmark,address.locality,address.city_id,address.state_id,address.country_id,address.zipcode_id,
							zipcode.zipcode,city.city,
							state.state,country.country')
			->join('zipcode', 'address.zipcode_id=zipcode.id')
			->join('city', 'zipcode.city_id=city.id')
			->join('state', 'city.state_id=state.id')
			->join('country', 'state.country_id=country.id')
			->where('users_id', $id)->findAll();

		if ($res) {
			return $res;
		} else {
			return null;
		}
	}

	
	//Function to create address
	//Creates Address required name,flat,apartment,landmark,locality,latitude,longitude,pin_code
	public function create_address($array)
	{
		$data = [
			'name' => $array['name'],
			'flat_no' => $array['flat'],
			'apartment_name' => $array['apartment'],
			'landmark' => $array['landmark'],
			'locality' => $array['locality'],
			'latitude' => $array['latitude'],
			'longitude' => $array['longitude'],
			'zipcode_id' => $array['zipcode_id']
		];

		$res = $this->insert($data);
		$insertID = $this->getInsertID();

		if ($res) {
			return $insertID;
		} else {
			return 0;
		}
	}

	public function update_address_by_id($id, $array)
	{

		$res = $this->update($id, $array);
		if ($res != null) {
			return 1;
		} else {
			return 0;
		}
	}

	public function delete_address($id){

		if($this->delete($id)){
			return 1;
		}else{
			return 0;
		}


	}
}
