<?php

namespace Modules\User\Controllers\api;

use CodeIgniter\RESTful\ResourceController;
use Modules\Admin\Models\CategoriesModel;
use Modules\Admin\Models\SubcategoriesModel;
use Modules\User\Models\keywordModel;
use Modules\User\Models\AddressModel;
use Modules\User\Models\ZipcodeModel;
use Modules\User\Models\CityModel;
use Modules\User\Models\StateModel;
use Modules\User\Models\CountryModel;
use Modules\User\Models\PaytmModel;
use Modules\Provider\Models\CommonModel;
use Modules\User\Models\MiscModel;
use Modules\User\Models\SmsTemplateModel;


helper('Modules\User\custom');

class MiscController extends ResourceController
{

    //------------------------------------------------------GET LIST OF SUB CATEGORIES HERE ---------------------------------------------
    //-------------------------------------------------------------**************** -----------------------------------------------------

    /**
     * Get the list of Categories
     * 
     * This function can be used to get the list of 
     * categories.
     * <code>
     * getCat();
     * </code>
     */
    public function get_sub_by_cat()
    {
        $json = $this->request->getJSON();
        if (!property_exists($json, 'id') || !property_exists($json, 'key')) {
            return $this->respond([
                'status' => 403,
                'message' => 'Invalid Parameters'
            ]);
        } else {
            $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
            $id = $json->id;
            $apiconfig = new \Config\ApiConfig();

            $api_key = $apiconfig->user_key;

            if ($key == $api_key) {
                $cat = new SubcategoriesModel();
                $res = $cat->get_by_cat($id);

                if ($res != null) {
                    return $this->respond([
                        "status" => 200,
                        "message" => "Success",
                        "data" => $res
                    ]);
                } else {
                    return $this->respond([
                        "status" => 200,
                        "message" => "No Data to Show"
                    ]);
                }
            } else {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Access Denied ! Authentication Failed'
                ]);
            }
        }
    }


    //-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------


    //---------------------------------------------------------GET LIST CATEGORIES HERE -------------------------------------------------
    //-------------------------------------------------------------**************** -----------------------------------------------------

    public function getCat()
    {
        $validate_key = $this->request->getVar('key');
        if ($validate_key == "") {
            return $this->respond([
                'status' => 403,
                'message' => 'Invalid Parameters'
            ]);
        } else {
            $key = md5($validate_key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL

            $apiconfig = new \Config\ApiConfig();

            $api_key = $apiconfig->user_key;

            if ($key == $api_key) {
                $cat = new CategoriesModel();
                $res = $cat->showAll();

                if ($res != null) {
                    return $this->respond([
                        "status" => 200,
                        "message" => "Success",
                        "data" => $res
                    ]);
                } else {
                    return $this->respond([
                        "status" => 200,
                        "message" => "No Data to Show"
                    ]);
                }
            } else {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Access Denied ! Authentication Failed'
                ]);
            }
        }
    }

    //-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------



    public function getSub()
    {
        $validate_key = $this->request->getVar('key');
        if ($validate_key == "") {
            return $this->respond([
                'status' => 403,
                'message' => 'Invalid Parameters'
            ]);
        } else {
            $key = md5($validate_key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL

            $apiconfig = new \Config\ApiConfig();

            $api_key = $apiconfig->user_key;

            if ($key == $api_key) {

                $cat = new SubcategoriesModel();
                $res = $cat->showAll();

                if ($res != null) {
                    return $this->respond([
                        "status" => 200,
                        "message" => "Success",
                        "data" => $res
                    ]);
                } else {
                    return $this->respond([
                        "status" => 200,
                        "message" => "No Data to Show"
                    ]);
                }
            } else {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Access Denied ! Authentication Failed'
                ]);
            }
        }
    }
    //-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
    public function get_keywords()
    {
        $validate_key = $this->request->getVar('key');
        $profession_id = $this->request->getVar('profession_id');
        if ($validate_key == "" || $profession_id == "") {
            return $this->respond([
                'status' => 403,
                'message' => 'Invalid Parameters'
            ]);
        } else {
            $key = md5($validate_key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL

            $apiconfig = new \Config\ApiConfig();

            $api_key = $apiconfig->user_key;

            if ($key == $api_key) {

                $keyword = new keywordModel();
               
               if($profession_id != 0){

                $res = $keyword->get_keywords_by_profession($profession_id);

               }else{

                $res = $keyword->get_keywords();

               }
               
                // $res = $keyword->showAll($profession_id);
                
                if ($res != null) {
                    return $this->respond([
                        "status" => 200,
                        "message" => "Success",
                        "data" => $res
                    ]);
                } else {
                    // $dat = $keyword->get_keywords();

                    return $this->respond([
                        "status" => 200,
                        "message" => "No Data to Show",
                        "data" => array()
                    ]);
                }
            } else {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Access Denied ! Authentication Failed'
                ]);
            }
        }
    }

    public function get_keywords_autocomplete()
    {
        $validate_key = $this->request->getVar('key');
        if ($validate_key == "") {
            return $this->respond([
                'status' => 403,
                'message' => 'Invalid Parameters'
            ]);
        } else {
            $key = md5($validate_key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL

            $apiconfig = new \Config\ApiConfig();

            $api_key = $apiconfig->user_key;

            if ($key == $api_key) {

                $keyword = new keywordModel();
                $res = $keyword->get_keywords();

                if ($res != null) {
                    return $this->respond([
                        "status" => 200,
                        "message" => "Success",
                        "data" => $res
                    ]);
                } else {
                    return $this->respond([
                        "status" => 200,
                        "message" => "No Data to Show"
                    ]);
                }
            } else {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Access Denied ! Authentication Failed'
                ]);
            }
        }
    }

    public function get_keywords_autocomplete_by_category()
    {
        $validate_key = $this->request->getVar('key');
        $category_id = $this->request->getVar('category_id');
        if ($validate_key == "" || $category_id == "") {
            return $this->respond([
                'status' => 403,
                'message' => 'Invalid Parameters'
            ]);
        } else {
            $key = md5($validate_key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL

            $apiconfig = new \Config\ApiConfig();

            $api_key = $apiconfig->user_key;

            if ($key == $api_key) {

                $keyword = new keywordModel();
                $res = $keyword->get_keywords($category_id);

                if ($res != null) {
                    return $this->respond([
                        "status" => 200,
                        "message" => "Success",
                        "data" => $res
                    ]);
                } else {
                    return $this->respond([
                        "status" => 200,
                        "message" => "No Data to Show"
                    ]);
                }
            } else {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Access Denied ! Authentication Failed'
                ]);
            }
        }
    }


    //---------------------------------------------------------GET LIST of Faq HERE -------------------------------------------------
    //-------------------------------------------------------------**************** -----------------------------------------------------

    public function user_faq()
    {
        $validate_key = $this->request->getVar('key');
        if ($validate_key == "") {
            return $this->respond([
                'status' => 403,
                'message' => 'Invalid Parameters'
            ]);
        } else {
            $key = md5($validate_key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL

            $apiconfig = new \Config\ApiConfig();

            $api_key = $apiconfig->user_key;

            if ($key == $api_key) {
                $common = new CommonModel();
                $res = $common->get_table_details_dynamically('faq_users', 'id', 'ASC');

                if ($res != 'failure') {
                    return $this->respond([
                        "status" => 200,
                        "message" => "Success",
                        "data" => $res
                    ]);
                } else {
                    return $this->respond([
                        "status" => 200,
                        "message" => "No Faq to Show"
                    ]);
                }
            } else {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Access Denied ! Authentication Failed'
                ]);
            }
        }
    }

    //-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
    //---------------------------------------------------------Change Address HERE -------------------------------------------------
    //-------------------------------------------------------------**************** -----------------------------------------------------

    public function change_address()
    {
        if ($this->request->getMethod() != 'post') {

            $this->respond([
                "status" => 405,
                "message" => "Method Not Allowed"
            ]);
        } else {
            //getting JSON data from API
            $json = $this->request->getJSON();

            if (
                !property_exists($json, 'name') || !property_exists($json, 'flat') || !property_exists($json, 'apartment') || !property_exists($json, 'landmark')
                || !property_exists($json, 'state') || !property_exists($json, 'country') || !property_exists($json, 'postal_code')
                || !property_exists($json, 'address') || !property_exists($json, 'user_lat') || !property_exists($json, 'user_long')
                || !property_exists($json, 'users_id') || !property_exists($json, 'keyword_id') || !property_exists($json, 'key')
            ) {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Invalid Parameters'
                ]);
            } else {
                $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
                $apiconfig = new \Config\ApiConfig();

                $api_key = $apiconfig->user_key;

                $zip_model = new ZipcodeModel();
                $city_model = new CityModel();
                $state_model = new StateModel();
                $country_model = new CountryModel();

                if ($key == $api_key) {
                    $country_id = $country_model->search_by_country($json->country);
                    $state_id = $state_model->search_by_state($json->state);
                    $city_id = $city_model->search_by_city($json->city);
                    $zip_id = $zip_model->search_by_zipcode($json->postal_code);

                    if ($country_id == 0) {
                        $country_id = $country_model->create_country($json->country);
                    }
                    if ($state_id == 0) {
                        $state_id = $state_model->create_state($json->state, $country_id);
                    }
                    if ($city_id == 0) {
                        $city_id = $city_model->create_city($json->city, $state_id);
                    }
                    if ($zip_id == 0) {
                        $zip_id = $zip_model->create_zip($json->postal_code, $city_id);
                    }
                    //JSON Objects declared into variables
                    $data = [
                        'locality' => $json->address,
                        'latitude' => $json->user_lat,
                        'longitude' => $json->user_long,
                        'city_id' => $city_id,
                        'state_id' => $state_id,
                        'country_id' => $country_id,
                        'zipcode_id' => $zip_id,
                        'users_id' => $json->users_id
                    ];
                    $common = new CommonModel();
                    $id = $common->insert_records_dynamically('user_temp_address', $data);

                    if ($id > 0) {
                        //JSON Objects declared into variables
                        $keyword_id = $json->keyword_id;
                        $city = $json->city;

                        $misc_model = new MiscModel();

                        //Check whether any SP is available, if yes process the details
                        $arr_search_result = $misc_model->get_search_results($keyword_id, $city, $json->user_lat, $json->user_long, $json->users_id);

                        //Save to search_results
                        //JSON Objects declared into variables

                        $data = [
                            'keywords_id' => ($keyword_id > 0) ? $keyword_id : 0,
                            'search_query' => ($keyword_id > 0) ? "" : $keyword_id,
                            'results_show' => ($arr_search_result != 'failure') ? count($arr_search_result) : 0,
                            'latitude' => $json->user_lat,
                            'longitude' => $json->user_long,
                            'users_id' => $json->users_id,
                            'city' => $city,
                            'state' => $json->state,
                            'country' => $json->country,
                            'postal_code' => $json->postal_code,
                            'address' => $json->address,
                        ];
                        $common = new CommonModel();
                        $common->insert_records_dynamically('search_results', $data);

                        if ($arr_search_result != 'failure') {
                            return $this->respond([
                                "status" => 200,
                                "message" => "Success",
                                "data" => $arr_search_result,
                                "temp_address_id" => $id
                            ]);
                        } else {
                            return $this->respond([
                                "status" => 200,
                                "message" => "No Data to Show",
                                "temp_address_id" => $id
                            ]);
                        }
                    }
                } else {
                    return $this->respond([
                        'status' => 403,
                        'message' => 'Access Denied ! Authentication Failed'
                    ]);
                }
            }
        }
    }
    //-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
    //---------------------------------------------------------GET LIST of Users Addresses HERE -------------------------------------------------
    //-------------------------------------------------------------**************** -----------------------------------------------------

    public function user_temp_address()
    {
        $validate_key = $this->request->getVar('key');
        $users_id = $this->request->getVar('users_id');

        if ($validate_key == "" || $users_id == "") {
            return $this->respond([
                'status' => 403,
                'message' => 'Invalid Parameters'
            ]);
        } else {
            $key = md5($validate_key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL

            $apiconfig = new \Config\ApiConfig();

            $api_key = $apiconfig->user_key;

            if ($key == $api_key) {
                $misc_model = new MiscModel();
                $res = $misc_model->get_temp_address_by_user_id($id);

                if ($res != 'failure') {
                    return $this->respond([
                        "status" => 200,
                        "message" => "Success",
                        "data" => $res
                    ]);
                } else {
                    return $this->respond([
                        "status" => 200,
                        "message" => "No Faq to Show"
                    ]);
                }
            } else {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Access Denied ! Authentication Failed'
                ]);
            }
        }
    }

    //-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
    //---------------------------------------------------------GET LIST of Users Addresses HERE -------------------------------------------------
    //-------------------------------------------------------------**************** -----------------------------------------------------

    /**
     * Function used to get list of search phrases
     * 
     * @param key
     * @return [mixed]
     */
    public function get_search_phrase()
    {
        $validate_key = $this->request->getVar('key');
        if ($validate_key == "") {
            return $this->respond([
                'status' => 403,
                'message' => 'Invalid Parameters'
            ]);
        } else {
            $key = md5($validate_key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL

            $apiconfig = new \Config\ApiConfig();

            $api_key = $apiconfig->user_key;

            if ($key == $api_key) {

                $misc_model = new MiscModel();
                $res = $misc_model->get_search_phrase();

                if ($res != null) {
                    return $this->respond([
                        "status" => 200,
                        "message" => "Success",
                        "data" => $res
                    ]);
                } else {
                    return $this->respond([
                        "status" => 200,
                        "message" => "No Data to Show"
                    ]);
                }
            } else {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Access Denied ! Authentication Failed'
                ]);
            }
        }
    }

    //-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
    //---------------------------------------------------------Add Address HERE -------------------------------------------------
    //-------------------------------------------------------------**************** -----------------------------------------------------

    public function add_address()
    {
        if ($this->request->getMethod() != 'post') {

            $this->respond([
                "status" => 405,
                "message" => "Method Not Allowed"
            ]);
        } else {
            //getting JSON data from API
            $json = $this->request->getJSON();

            if (
                !property_exists($json, 'name') || !property_exists($json,'flat') || !property_exists($json,'apartment') || !property_exists($json,'landmark')
                || !property_exists($json,'state') || !property_exists($json,'country') || !property_exists($json,'postal_code')
                || !property_exists($json,'address') || !property_exists($json,'user_lat') || !property_exists($json,'user_long')
                || !property_exists($json,'users_id') || !property_exists($json,'key')
            ) {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Invalid Parameters'
                ]);
            } else {
                $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
                $apiconfig = new \Config\ApiConfig();

                $api_key = $apiconfig->user_key;

                $zip_model = new ZipcodeModel();
                $city_model = new CityModel();
                $state_model = new StateModel();
                $country_model = new CountryModel();

                if ($key == $api_key) {
                    $country_id = $country_model->search_by_country($json->country);
                    $state_id = $state_model->search_by_state($json->state);
                    $city_id = $city_model->search_by_city($json->city);
                    $zip_id = $zip_model->search_by_zipcode($json->postal_code);

                    if ($country_id == 0) {
                        $country_id = $country_model->create_country($json->country);
                    }
                    if ($state_id == 0) {
                        $state_id = $state_model->create_state($json->state, $country_id);
                    }
                    if ($city_id == 0) {
                        $city_id = $city_model->create_city($json->city, $state_id);
                    }
                    if ($zip_id == 0) {
                        $zip_id = $zip_model->create_zip($json->postal_code, $city_id);
                    }

                    //Check if address already exists, if yes, update else insert
                    $misc_model = new MiscModel();
                    $common = new CommonModel();

                    $check_address_exists = $misc_model->get_address_by_user_id($json->users_id, $json->address, $json->user_lat, $json->user_long, $city_id, $state_id, $country_id, $zip_id);

                    if ($check_address_exists == 'failure') {
                        //JSON Objects declared into variables
                        $data = [
                            'name' => $json->name,
                            'flat_no' => $json->flat,
                            'apartment_name' => $json->apartment,
                            'landmark' => $json->landmark,
                            'locality' => $json->address,
                            'latitude' => $json->user_lat,
                            'longitude' => $json->user_long,
                            'city_id' => $city_id,
                            'state_id' => $state_id,
                            'country_id' => $country_id,
                            'zipcode_id' => $zip_id,
                            'users_id' => $json->users_id
                        ];

                        $id = $common->insert_records_dynamically('address', $data);
                    } else {
                        $id = $check_address_exists[0]['id'];
                    }

                    if ($id > 0) {

                        //Insert into alerts_regular_user table

                        $date = date('Y-m-d H:i:s');

                        $arr_alerts = array(
                            'type_id' => 4,
                            'description' => "You have successfully added a new address",
                            'user_id' => $json->users_id,
                            'profile_pic_id' => $json->users_id,
                            'status' => 2,
                            'created_on' => $date,
                            'updated_on' => $date
                        );

                        $common->insert_records_dynamically('alert_regular_user', $arr_alerts);


                        return $this->respond([
                            "status" => 200,
                            "message" => "Success",
                            "address_id" => $id
                        ]);
                    }
                } else {
                    return $this->respond([
                        'status' => 403,
                        'message' => 'Access Denied ! Authentication Failed'
                    ]);
                }
            }
        }
    }
    //-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
    //--------------------------------------------------UPDATE FCM TOKEN STARTS------------------------------------------------------------
    //-----------------------------------------------****************************----------------------------------------------------------

    /**
     * Function to update Fcm Token
     * 
     * JSON data is passed into this function to update user profile using
     * @method POST with 
     * @param mixed $user_id, @param string $fname, @param string $lname,
     * @param mixed $email, @param mixed $dob, @param string $image [Base64 encoded]  
     * @return [JSON] Success|Fail
     */
    public function update_token()
    {

        $json = $this->request->getJSON();
        if (!property_exists($json, 'user_id') || !property_exists($json,'fcm_token') || !property_exists($json,'key')) {
            return $this->respond([
                'status' => 403,
                'message' => 'Invalid Parameters'
            ]);
        } else {
            $common = new CommonModel();

            $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL

            $apiconfig = new \Config\ApiConfig();

            $api_key = $apiconfig->user_key;

            if ($key == $api_key) {

                $id = $json->user_id;
                $fcm_token = $json->fcm_token;

                $upd_fcm_token = [
                    "fcm_token" =>  $fcm_token,
                ];

                $common->update_records_dynamically('users', $upd_fcm_token, 'users_id', $id);

                return $this->respond([
                    "status" => 200,
                    "message" =>  "Successfully Updated"
                ]);
            } else {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Access Denied ! Authentication Failed'
                ]);
            }
        }
    }


    //--------------------------------------------------UPDATE FCM ENDS------------------------------------------------------------
    //---------------------------------------------------------GET LIST of Addresses for autocomplete HERE -------------------------------------------------
    //-------------------------------------------------------------**************** -----------------------------------------------------

    public function autocomplete_address()
    {
        $validate_key = $this->request->getVar('key');

        if ($validate_key == "") {
            return $this->respond([
                'status' => 403,
                'message' => 'Invalid Parameters'
            ]);
        } else {
            $key = md5($validate_key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL

            $apiconfig = new \Config\ApiConfig();

            $api_key = $apiconfig->user_key;

            if ($key == $api_key) {
                $misc_model = new MiscModel();
                $res = $misc_model->get_all_addresses();

                if ($res != 'failure') {
                    return $this->respond([
                        "status" => 200,
                        "message" => "Success",
                        "data" => $res
                    ]);
                } else {
                    return $this->respond([
                        "status" => 200,
                        "message" => "No Addresses to Show"
                    ]);
                }
            } else {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Access Denied ! Authentication Failed'
                ]);
            }
        }
    }
    //-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
    //---------------------------------------------------------GET LIST of User plans HERE -------------------------------------------------
    //-------------------------------------------------------------**************** -----------------------------------------------------

    public function user_plans()
    {
        $validate_key = $this->request->getVar('key');
        $validate_user_id = $this->request->getVar('users_id');
        if ($validate_key == "" && $validate_user_id == "") {
            return $this->respond([
                'status' => 403,
                'message' => 'Invalid Parameters'
            ]);
        } else {
            $key = md5($validate_key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL

            $apiconfig = new \Config\ApiConfig();

            $api_key = $apiconfig->user_key;

            if ($key == $api_key) {
                $common = new CommonModel();
                $misc_model = new MiscModel();
                $resu = $common->get_table_details_dynamically('user_plans', 'id', 'ASC');

                foreach ($resu as $key => $r) {
                    $res[$key]['id'] = $r['id'];
                    $res[$key]['name'] = $r['name'];
                    $res[$key]['description'] = $r['description'];
                    $res[$key]['amount'] = intval($r['amount']) . "";
                    $res[$key]['premium_tag'] = $r['premium_tag'];
                    $res[$key]['period'] = $r['period'];
                    $res[$key]['posts_per_month'] = $r['posts_per_month'];
                    $res[$key]['proposals_per_post'] = $r['proposals_per_post'];
                    $res[$key]['customer_support'] = $r['customer_support'];
                }

                $res_plan = $misc_model->get_user_plan_details($validate_user_id);

                if ($res != 'failure') {
                    return $this->respond([
                        "activated_plan" => ($res_plan != 'failure') ? $res_plan['plans_id'] : 0,
                        "valid_from_date" => ($res_plan != 'failure') ? $res_plan['start_date'] : "",
                        "valid_till_date" => ($res_plan != 'failure') ? $res_plan['end_date'] : "",
                        "status" => 200,
                        "message" => "Success",
                        "data" => $res
                    ]);
                } else {
                    return $this->respond([
                        "status" => 200,
                        "message" => "No Plans to Show"
                    ]);
                }
            } else {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Access Denied ! Authentication Failed'
                ]);
            }
        }
    }

    //-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
    //---------------------------------------------------------GET LIST of Bid Ranges HERE -------------------------------------------------
    //-------------------------------------------------------------**************** -----------------------------------------------------

    public function bid_range()
    {
        $validate_key = $this->request->getVar('key');
        if ($validate_key == "") {
            return $this->respond([
                'status' => 403,
                'message' => 'Invalid Parameters'
            ]);
        } else {
            $key = md5($validate_key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL

            $apiconfig = new \Config\ApiConfig();

            $api_key = $apiconfig->user_key;

            if ($key == $api_key) {
                $common = new CommonModel();
                $res = $common->get_table_details_dynamically('bid_range', 'bid_range_id', 'ASC');

                if ($res != 'failure') {
                    return $this->respond([
                        "status" => 200,
                        "message" => "Success",
                        "data" => $res
                    ]);
                } else {
                    return $this->respond([
                        "status" => 200,
                        "message" => "No Plans to Show"
                    ]);
                }
            } else {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Access Denied ! Authentication Failed'
                ]);
            }
        }
    }
    //-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
    //---------------------------------------------------------GET LIST of Goals HERE -------------------------------------------------
    //-------------------------------------------------------------**************** -----------------------------------------------------

    public function goals_list()
    {
        $validate_key = $this->request->getVar('key');
        if ($validate_key == "") {
            return $this->respond([
                'status' => 403,
                'message' => 'Invalid Parameters'
            ]);
        } else {
            $key = md5($validate_key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL

            $apiconfig = new \Config\ApiConfig();

            $api_key = $apiconfig->user_key;

            if ($key == $api_key) {
                $common = new CommonModel();
                $res = $common->get_table_details_dynamically('goals', 'goal_id', 'ASC');

                if ($res != 'failure') {
                    return $this->respond([
                        "status" => 200,
                        "message" => "Success",
                        "data" => $res
                    ]);
                } else {
                    return $this->respond([
                        "status" => 200,
                        "message" => "No Goals to Show"
                    ]);
                }
            } else {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Access Denied ! Authentication Failed'
                ]);
            }
        }
    }
    //-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
    //---------------------------------------------------------GET LIST of Complaint modules HERE -------------------------------------------------
    //-------------------------------------------------------------**************** -----------------------------------------------------

    public function complaint_modules_list()
    {
        $validate_key = $this->request->getVar('key');
        if ($validate_key == "") {
            return $this->respond([
                'status' => 403,
                'message' => 'Invalid Parameters'
            ]);
        } else {
            $key = md5($validate_key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL

            $apiconfig = new \Config\ApiConfig();

            $api_key = $apiconfig->user_key;

            if ($key == $api_key) {
                $common = new CommonModel();
                $res = $common->get_table_details_dynamically('complaint_module', 'id', 'ASC');

                if ($res != 'failure') {
                    return $this->respond([
                        "status" => 200,
                        "message" => "Success",
                        "data" => $res
                    ]);
                } else {
                    return $this->respond([
                        "status" => 200,
                        "message" => "No Modules to Show"
                    ]);
                }
            } else {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Access Denied ! Authentication Failed'
                ]);
            }
        }
    }
    //-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
    //---------------------------------------------------------Add Complaints HERE -------------------------------------------------
    //-------------------------------------------------------------**************** -----------------------------------------------------

    public function post_complaints()
    {
        if ($this->request->getMethod() != 'post') {

            $this->respond([
                "status" => 405,
                "message" => "Method Not Allowed"
            ]);
        } else {
            //getting JSON data from API
            $json = $this->request->getJSON();

            if (
                !property_exists($json, 'module_id') || !property_exists($json,'booking_id') || !property_exists($json,'description') || !property_exists($json,'created_on')
                || !property_exists($json,'users_id') || !property_exists($json,'user_type') || !property_exists($json,'key')
            ) {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Invalid Parameters'
                ]);
            } else {
                $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
                $apiconfig = new \Config\ApiConfig();

                $api_key = $apiconfig->user_key;
                $date = date('Y-m-d H:i:s');

                if ($key == $api_key) {
                    $common = new CommonModel();
                    $misc_model = new MiscModel();

                    switch ($json->module_id) {
                        case 1:
                            $priority = 'Urgent';
                            break;

                        case 2:
                            $priority = 'High priority';
                            break;

                        case 3:
                            $priority = 'Urgent';
                            break;

                        case 4:
                            $priority = 'Medium priority';
                            break;

                        case 5:
                            $priority = 'Medium priority';
                            break;

                        case 6:
                            $priority = 'Low priority';
                            break;
                        case 7:
                            $priority = 'Medium priority';
                            break;

                        default:
                            $priority = 'Low priority';
                    }

                    //Insert into complaints table
                    $arr_complaints = array(
                        'module_id' => $json->module_id,
                        'booking_id' => $json->booking_id,
                        'description' => $json->description,
                        'priority' => $priority,
                        'created_on' => $date,
                        ($json->user_type == 1 ? 'users_id'  : 'sp_id') => $json->users_id
                    );
                    $complaint_id = $common->insert_records_dynamically('complaints', $arr_complaints);

                    //Insert into complaint_status
                    $arr_complaint_status = array(
                        'complaints_id' => $complaint_id,
                        'assigned_to' => 0,
                        'action_taken' => "",
                        'status' => "Pending",
                        'created_on' => $date
                    );

                    $common->insert_records_dynamically('complaint_status', $arr_complaint_status);

                    if ($complaint_id > 0) {
                        $booking_ref_id = str_pad($json->booking_id, 6, "0", STR_PAD_LEFT);
                        $ticket_ref_id = str_pad($complaint_id, 6, "0", STR_PAD_LEFT);

                        //Alerts Creation Part

                        $user_profile = $misc_model->user_info($json->users_id);
                        
                        if ($json->user_type == 1) {

                            //Insert into alerts_regular_user table
                            $arr_alerts = array(
                                'type_id' => 5,
                                'description' => "You have succesfully raised a support ticket with ID: " . $ticket_ref_id . ". Our Team will assist you soon",
                                'user_id' => $json->users_id,
                                'profile_pic_id' => $json->users_id,
                                'status' => 2,
                                'created_on' => $date,
                                'updated_on' => $date
                            );

                            $common->insert_records_dynamically('alert_regular_user', $arr_alerts);
                        } elseif ($json->user_type == 2) {

                            //Insert into alerts_regular_sp table
                            $arr_alerts = array(
                                'type_id' => 5,
                                'description' => "You have succesfully raised a support ticket with ID: " . $ticket_ref_id . ". Our Team will assist you soon",
                                'user_id' => $json->users_id,
                                'profile_pic_id' => $json->users_id,
                                'status' => 2,
                                'created_on' => $date,
                                'updated_on' => $date
                            );

                            $common->insert_records_dynamically('alert_regular_sp', $arr_alerts);
                        }

                        return $this->respond([
                            "complaint_id" => $complaint_id,
                            "ticket_ref_id" => $ticket_ref_id,
                            "status" => 200,
                            "message" => "Success",
                        ]);
                    } else {
                        return $this->respond([
                            "complaint_id" => 0,
                            "ticket_ref_id" => 0,
                            "status" => 404,
                            "message" => "Failed to create Complaint"
                        ]);
                    }
                } else {
                    return $this->respond([
                        'status' => 403,
                        'message' => 'Access Denied ! Authentication Failed'
                    ]);
                }
            }
        }
    }
    //-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
    //---------------------------------------------------------Add Feedback HERE -------------------------------------------------
    //-------------------------------------------------------------**************** -----------------------------------------------------

    public function post_feedback()
    {
        if ($this->request->getMethod() != 'post') {

            $this->respond([
                "status" => 405,
                "message" => "Method Not Allowed"
            ]);
        } else {
            //getting JSON data from API
            $json = $this->request->getJSON();

            if (
                !property_exists($json, 'description') || !property_exists($json,'created_on')
                || !property_exists($json,'users_id') || !property_exists($json,'user_type') || !property_exists($json,'key')
            ) {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Invalid Parameters'
                ]);
            } else {
                $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
                $apiconfig = new \Config\ApiConfig();

                $api_key = $apiconfig->user_key;
                $date = $json->created_on;

                if ($key == $api_key) {
                    $common = new CommonModel();
                    $sms_model = new SmsTemplateModel();

                    //Insert into feedback table
                    $arr_feedback = array(
                        'description' => $json->description,
                        'created_on' => $json->created_on,
                        ($json->user_type == 1 ? 'users_id' : 'sp_id') => $json->users_id,
                    );

                    $feedback_id = $common->insert_records_dynamically('feedback', $arr_feedback);

                    if ($feedback_id > 0) {

                        //Inserts into Alerts 
                        $arr_alerts = array(
                            'type_id' => 4,
                            'description' => "You have successfully submitted a review/Suggestion. It really matter to serve you better. Thanks",
                            'user_id' => $json->users_id,
                            'profile_pic_id' => $json->users_id,
                            'status' => 2,
                            'created_on' => $date,
                            'updated_on' => $date
                        );

                        $table_name = ($json->user_type == 1 ? 'alert_regular_user' : 'alert_regular_sp');
                        $common->insert_records_dynamically($table_name, $arr_alerts);


                        $arr_user_details = $common->get_details_dynamically('user_details', 'id', $json->users_id);
                        if ($arr_user_details != 'failure') {
                            $user_name = $arr_user_details[0]['fname'] . " " . $arr_user_details[0]['lname'];
                            $user_mobile = $arr_user_details[0]['mobile'];
                        }

                        $data = [
                            "name" => "sugg_feed",
                            "mobile" => $user_mobile,
                            "dat" => [
                                "var" => $user_name,
                                "var1" => "",
                            ]
                        ];

                        $sms_model->sms_api_url($data['name'], $data['mobile'], $data['dat']);

                        return $this->respond([
                            "feedback_id" => $feedback_id,
                            "status" => 200,
                            "message" => "Success",
                        ]);
                    } else {
                        return $this->respond([
                            "status" => 404,
                            "message" => "Failed to create Feedback"
                        ]);
                    }
                } else {
                    return $this->respond([
                        'status' => 403,
                        'message' => 'Access Denied ! Authentication Failed'
                    ]);
                }
            }
        }
    }
    //-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
    //--------------------------------------------------DELETE Attachments START------------------------------------------------------------

    public function delete_attachment()
    {

        $json = $this->request->getJSON();
        if (!property_exists($json, 'id') || !property_exists($json, 'key')) {
            return $this->respond([
                'status' => 403,
                'message' => 'Invalid Parameters'
            ]);
        } else {
            $id = $this->request->getJsonVar('id');
            $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL

            $apiconfig = new \Config\ApiConfig();

            $api_key = $apiconfig->user_key;
            $common = new CommonModel();

            if ($key == $api_key) {
                $id = $json->id;

                $data = $common->get_details_dynamically('attachments', 'id', $id);

                if($data != 'failure'){
                    $file_name = $data[0]['file_name'];

                    $deleteObject = deleteS3Object($file_name);

                    if($deleteObject != '1'){

                        return $this->respond([
                            'status' => 401,
                            'message' => $deleteObject
                        ]);
                    }else{

                        $common->delete_records_dynamically('attachments', 'id', $id);

                        return $this->respond([
                            "status" => 200,
                            "message" =>  "Successfully Deleted"
                        ]);

                    }
                }else{
                   
                        return $this->respond([
                            "status" => 404,
                            "message" =>  "Attachment Not Found"
                        ]);
                }
                
            } else {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Access Denied ! Authentication Failed'
                ]);
            }
        }
    }

    //--------------------------------------------------DELETE USER ADDRESS END------------------------------------------------------------
    //---------------------------------------------------------GET LIST of Offers HERE -------------------------------------------------
    //-------------------------------------------------------------**************** -----------------------------------------------------

    public function offers_list()
    {
        $json = $this->request->getJSON();

        $validate_key = $json->key;
        $validate_offer_type_id = $json->offer_type_id;
        $users_id = $json->users_id;
        $sort_type = $json->sort_type;

        if ($validate_key == "" && $validate_offer_type_id == "") {
            return $this->respond([
                'status' => 403,
                'message' => 'Invalid Parameters'
            ]);
        } else {
            $key = md5($validate_key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL

            $apiconfig = new \Config\ApiConfig();

            $api_key = $apiconfig->user_key;

            if ($key == $api_key) {
                $misc_model = new MiscModel();
                $zip_model = new ZipcodeModel();
                $city_model = new CityModel();
                $state_model = new StateModel();
                $country_model = new CountryModel();

                $country_id = $country_model->search_by_country($json->country);
                $state_id = $state_model->search_by_state($json->state);
                $city_id = $city_model->search_by_city($json->city);
                $zip_id = $zip_model->search_by_zipcode($json->postal_code);

                if ($country_id == 0) {
                    $country_id = $country_model->create_country($json->country);
                }
                if ($state_id == 0) {
                    $state_id = $state_model->create_state($json->state, $country_id);
                }
                if ($city_id == 0) {
                    $city_id = $city_model->create_city($json->city, $state_id);
                }
                if ($zip_id == 0) {
                    $zip_id = $zip_model->create_zip($json->postal_code, $city_id);
                }

                $data = array();

                $res = $misc_model->get_offers_list($validate_offer_type_id, $sort_type);
                if ($res != 'failure') {
                    foreach ($res as $key => $res_data) {
                        $data[$key]["id"] = $res_data["id"];
                        $data[$key]["name"] = $res_data["name"];
                        $data[$key]["coupon_code"] = $res_data["coupon_code"];
                        $data[$key]["valid_till"] = $res_data["valid_till"];
                        $data[$key]["value_type_id"] = $res_data["value_type_id"];
                        $data[$key]["value"] = $res_data["value"];
                        $data[$key]["offer_type_id"] = $res_data["offer_type_id"];
                        $data[$key]["offer_image"] = $res_data["offer_image"];
                        $data[$key]["offer_type_name"] = $res_data["offer_type_name"];
                        $data[$key]["value_type_name"] = $res_data["value_type_name"];
                        $data[$key]["created_dts"] = $res_data["created_dts"];
                    }
                }

                $offers_count = (count($data) > 0) ?  count($data) : 0; //Increment the key

                if ($users_id > 0) {
                    $res_select_list = $misc_model->get_offers_selection_list($users_id, $sort_type);
                    if ($res_select_list != 'failure') {
                        foreach ($res_select_list as $res_data) {
                            $data[$offers_count]["id"] = $res_data["id"];
                            $data[$offers_count]["name"] = $res_data["name"];
                            $data[$offers_count]["coupon_code"] = $res_data["coupon_code"];
                            $data[$offers_count]["valid_till"] = $res_data["valid_till"];
                            $data[$offers_count]["value_type_id"] = $res_data["value_type_id"];
                            $data[$offers_count]["value"] = $res_data["value"];
                            $data[$offers_count]["offer_type_id"] = $res_data["offer_type_id"];
                            $data[$offers_count]["offer_image"] = $res_data["offer_image"];
                            $data[$offers_count]["offer_type_name"] = $res_data["offer_type_name"];
                            $data[$offers_count]["value_type_name"] = $res_data["value_type_name"];
                            $data[$key]["created_dts"] = $res_data["created_dts"];
                            $offers_count++;
                        }
                    }
                }

                $res_location_country = $misc_model->get_offers_location_list(1, $country_id, $sort_type);
                if ($res_location_country != 'failure') {
                    foreach ($res_location_country as $res_data) {
                        $data[$offers_count]["id"] = $res_data["id"];
                        $data[$offers_count]["name"] = $res_data["name"];
                        $data[$offers_count]["coupon_code"] = $res_data["coupon_code"];
                        $data[$offers_count]["valid_till"] = $res_data["valid_till"];
                        $data[$offers_count]["value_type_id"] = $res_data["value_type_id"];
                        $data[$offers_count]["value"] = $res_data["value"];
                        $data[$offers_count]["offer_type_id"] = $res_data["offer_type_id"];
                        $data[$offers_count]["offer_image"] = $res_data["offer_image"];
                        $data[$offers_count]["offer_type_name"] = $res_data["offer_type_name"];
                        $data[$offers_count]["value_type_name"] = $res_data["value_type_name"];
                        $data[$key]["created_dts"] = $res_data["created_dts"];
                        $offers_count++;
                    }
                }

                $res_location_state = $misc_model->get_offers_location_list(2, $state_id, $sort_type);
                if ($res_location_state != 'failure') {
                    foreach ($res_location_state as $res_data) {
                        $data[$offers_count]["id"] = $res_data["id"];
                        $data[$offers_count]["name"] = $res_data["name"];
                        $data[$offers_count]["coupon_code"] = $res_data["coupon_code"];
                        $data[$offers_count]["valid_till"] = $res_data["valid_till"];
                        $data[$offers_count]["value_type_id"] = $res_data["value_type_id"];
                        $data[$offers_count]["value"] = $res_data["value"];
                        $data[$offers_count]["offer_type_id"] = $res_data["offer_type_id"];
                        $data[$offers_count]["offer_image"] = $res_data["offer_image"];
                        $data[$offers_count]["offer_type_name"] = $res_data["offer_type_name"];
                        $data[$offers_count]["value_type_name"] = $res_data["value_type_name"];
                        $data[$key]["created_dts"] = $res_data["created_dts"];
                        $offers_count++;
                    }
                }

                $res_location_city = $misc_model->get_offers_location_list(3, $city_id, $sort_type);
                if ($res_location_city != 'failure') {
                    foreach ($res_location_city as $res_data) {
                        $data[$offers_count]["id"] = $res_data["id"];
                        $data[$offers_count]["name"] = $res_data["name"];
                        $data[$offers_count]["coupon_code"] = $res_data["coupon_code"];
                        $data[$offers_count]["valid_till"] = $res_data["valid_till"];
                        $data[$offers_count]["value_type_id"] = $res_data["value_type_id"];
                        $data[$offers_count]["value"] = $res_data["value"];
                        $data[$offers_count]["offer_type_id"] = $res_data["offer_type_id"];
                        $data[$offers_count]["offer_image"] = $res_data["offer_image"];
                        $data[$offers_count]["offer_type_name"] = $res_data["offer_type_name"];
                        $data[$offers_count]["value_type_name"] = $res_data["value_type_name"];
                        $data[$key]["created_dts"] = $res_data["created_dts"];
                        $offers_count++;
                    }
                }

                $res_location_zipcode = $misc_model->get_offers_location_list(4, $zip_id, $sort_type);
                if ($res_location_zipcode != 'failure') {
                    foreach ($res_location_zipcode as $res_data) {
                        $data[$offers_count]["id"] = $res_data["id"];
                        $data[$offers_count]["name"] = $res_data["name"];
                        $data[$offers_count]["coupon_code"] = $res_data["coupon_code"];
                        $data[$offers_count]["valid_till"] = $res_data["valid_till"];
                        $data[$offers_count]["value_type_id"] = $res_data["value_type_id"];
                        $data[$offers_count]["value"] = $res_data["value"];
                        $data[$offers_count]["offer_type_id"] = $res_data["offer_type_id"];
                        $data[$offers_count]["offer_image"] = $res_data["offer_image"];
                        $data[$offers_count]["offer_type_name"] = $res_data["offer_type_name"];
                        $data[$offers_count]["value_type_name"] = $res_data["value_type_name"];
                        $data[$key]["created_dts"] = $res_data["created_dts"];
                        $offers_count++;
                    }
                }

                if (count($data) > 0) {
                    return $this->respond([
                        "status" => 200,
                        "message" => "Success",
                        "data" => $data
                    ]);
                } else {
                    return $this->respond([
                        "status" => 200,
                        "message" => "No Offers to Show"
                    ]);
                }
            } else {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Access Denied ! Authentication Failed'
                ]);
            }
        }
    }
    //-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
    //---------------------------------------------------------Add SP reviews HERE -------------------------------------------------
    //-------------------------------------------------------------**************** -----------------------------------------------------

    public function post_sp_review()
    {
        if ($this->request->getMethod() != 'post') {

            $this->respond([
                "status" => 405,
                "message" => "Method Not Allowed"
            ]);
        } else {
            //getting JSON data from API
            $json = $this->request->getJSON();

            if (
                !property_exists($json, 'overall_rating') || !property_exists($json, 'professionalism') || !property_exists($json, 'skill')
                || !property_exists($json, 'behaviour')  || !property_exists($json, 'satisfaction') || !property_exists($json, 'feedback')
                || !property_exists($json, 'booking_id') || !property_exists($json, 'sp_id') || !property_exists($json, 'key')
            ) {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Invalid Parameters'
                ]);
            } else {
                $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
                $apiconfig = new \Config\ApiConfig();

                $api_key = $apiconfig->user_key;

                if ($key == $api_key) {
                    $common = new CommonModel();
                    $misc_model = new MiscModel();
                    $date = date('Y-m-d H:i:s');

                    $booking_ref_id = str_pad($json->booking_id, 6, "0", STR_PAD_LEFT);

                    $average_review = ($json->overall_rating + $json->professionalism + $json->skill + $json->behaviour + $json->satisfaction) / 5;

                    $arr_user_details = $misc_model->get_user_name_by_booking($json->booking_id);
                    if ($arr_user_details != "failure") {
                        $user_name = $arr_user_details['fname'] . " " . $arr_user_details['lname'];
                        $user_id = $arr_user_details['users_id'];
                        $points_count = $arr_user_details['points_count'];
                        $profile_pic = $arr_user_details['profile_pic'];
                    }

                    //Insert into user_review table
                    $arr_user_review = array(

                        'overall_rating' => $json->overall_rating,
                        'professionalism' => $json->professionalism,
                        'skill' => $json->skill,
                        'behaviour' => $json->behaviour,
                        'satisfaction' => $json->satisfaction,
                        'feedback' => $json->feedback,
                        'average_review' => $average_review,
                        'booking_id' => $json->booking_id,
                        'sp_id' => $json->sp_id,
                        'posted_by_user_id' => $user_id,
                        'created_dts' => $date
                    );

                    $review_id = $common->insert_records_dynamically('user_review', $arr_user_review);

                    //Calculate points
                    $sp_points = 0;

                    if ($average_review >= 4) { //Positive rating :: 4 star and 5 star reviews will get positives/Rating 1, 2 will be sorted in ascending order and shown as negative reviews 
                        $sp_points += 5;
                    }
                    if ($json->overall_rating >= 3.5 && $json->overall_rating <= 4.5) { //> 3.5 and < 4.5 => 1 points
                        $sp_points += 1;
                    }
                    if ($json->overall_rating >= 4.5) { //> 4.5 => 2 points
                        $sp_points += 2;
                    }
                    if ($json->professionalism == 5) { //professionalism == 5 => 3 points
                        $sp_points += 3;
                    }

                    if ($sp_points > 0) {
                        $arr_user_det = $common->get_details_dynamically('user_details', 'id', $json->sp_id);
                        if ($arr_user_det != 'failure') {
                            $points_count = $arr_user_det[0]['points_count'];

                            $total_points = $points_count + $sp_points;

                            $arr_update_user_data = array(
                                'points_count' => $total_points,
                            );
                            $common->update_records_dynamically('user_details', $arr_update_user_data, 'id', $json->sp_id);
                        }
                    }

                    if ($review_id > 0) {

                        //Insert into alerts_regular_sp table

                        $arr_alerts = array(
                            'type_id' => 1,
                            'description' => $user_name . " has posted a review for booking $booking_ref_id on $date",
                            'user_id' => $json->sp_id,
                            'profile_pic_id' => $user_id,
                            'status' => 2,
                            'created_on' => $date,
                            'updated_on' => $date
                        );

                        $common->insert_records_dynamically('alert_regular_sp', $arr_alerts);

                        return $this->respond([
                            "review_id" => $review_id,
                            "status" => 200,
                            "message" => "Success",
                        ]);
                    } else {
                        return $this->respond([
                            "status" => 404,
                            "message" => "Failed to create Review"
                        ]);
                    }
                } else {
                    return $this->respond([
                        'status' => 403,
                        'message' => 'Access Denied ! Authentication Failed'
                    ]);
                }
            }
        }
    }
    //-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
    //---------------------------------------------------------GET LIST of Complaints HERE -------------------------------------------------
    //-------------------------------------------------------------**************** -----------------------------------------------------

    public function complaints_requests_list()
    {
        $json = $this->request->getJSON();

        $validate_key = $json->key;
        $users_id = $json->users_id;

        if ($validate_key == "" && $users_id == "") {
            return $this->respond([
                'status' => 403,
                'message' => 'Invalid Parameters'
            ]);
        } else {
            $key = md5($validate_key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL

            $apiconfig = new \Config\ApiConfig();

            $api_key = $apiconfig->user_key;

            if ($key == $api_key) {
                $misc_model = new MiscModel();
                $data = array();
                $temp_data = array();
                $temp_replies_data = array();
                $arr_main_data = array();

                $res = $misc_model->get_complaints_details($users_id);
                if ($res != 'failure') {
                    foreach ($res as $key => $res_data) {
                        if (!property_exists($res_data["id"], $arr_main_data)) {
                            $cnt = 0;

                            $arr_main_data[$res_data["id"]] = $res_data["id"];
                            $temp_data[$res_data["id"]]["id"] = $res_data["id"];
                            $temp_data[$res_data["id"]]["description"] = $res_data["description"];
                            $temp_data[$res_data["id"]]["status"] = ($res_data["status"] != "") ? $res_data["status"] : "Pending";
                            $temp_data[$res_data["id"]]['replies'] = array();

                            if ($res_data["complaint_status_id"] > 0 && $res_data["assigned_to"] > 0) {
                                $temp_data[$res_data["id"]]['replies'][$cnt]['action_taken'] = ($res_data["action_taken"] != "") ? $res_data["action_taken"] : "";
                                $temp_data[$res_data["id"]]['replies'][$cnt]['status'] = ($res_data["status"] != "") ? $res_data["status"] : "";
                                $temp_data[$res_data["id"]]['replies'][$cnt]["created_on"] = ($res_data["complaint_status_date"] != "") ? $res_data["complaint_status_date"] : "";
                            }
                        } else {
                            $temp_data[$res_data["id"]]["status"] = $res_data["status"];
                            if ($res_data["complaint_status_id"] > 0) {
                                $temp_replies_data[$res_data["id"]]['replies']['action_taken'] = ($res_data["action_taken"] != "") ? $res_data["action_taken"] : "";
                                $temp_replies_data[$res_data["id"]]['replies']['status'] = ($res_data["status"] != "") ? $res_data["status"] : "Pending";
                                $temp_replies_data[$res_data["id"]]['replies']["created_on"] = ($res_data["complaint_status_date"] != "") ? $res_data["complaint_status_date"] : "";
                                array_push($temp_data[$res_data["id"]]['replies'], $temp_replies_data[$res_data["id"]]['replies']);
                            }
                        }
                    }
                    array_push($data, $temp_data);
                }

                $arr_requests = $misc_model->get_request_details($users_id);

                //echo "<pre>";
                //print_r($temp_data);
                //print_r($data[0]);
                //print_r(array_values($data[0]));
                //echo "</pre>";
                //exit;
                return $this->respond([
                    "status" => 200,
                    "message" => "Success",
                    "complaints" => (count($data) > 0) ? array_values($data[0]) : array(),
                    "requests" => ($arr_requests != 'failure') ? $arr_requests : array(),
                ]);
            } else {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Access Denied ! Authentication Failed'
                ]);
            }
        }
    }
    //-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
    

    //------------------------------------------------------------API to get TXN No. for adding funds to wallet -----------------------------------
    //-------------------------------------------------------------**************** -------------------------------------------------------------------------------------
    public function add_funds(){

        if ($this->request->getMethod() != 'post') {

            $this->respond([
                "status" => 405,
                "message" => "Method Not Allowed"
            ]);
        } else {

            $json = $this->request->getJson();

            if(!property_exists($json,'key') || !property_exists($json,'users_id') || !property_exists($json,'amount') ){

                return $this->respond([
                    'status' => 403,
                    'message' => 'Invalid Parameters'
                ]);
            } else {
                $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
                $apiconfig = new \Config\ApiConfig();

                $api_key = $apiconfig->user_key;

                if ($key == $api_key) {
                    $common = new CommonModel();
                    $paytm = new PaytmModel();
                    $date = date('Y-m-d H:i:s');

                    $order_id = "WAL_" . date('Ymd_his_U');

                     //Get Paytm TXNNo for the Booking
                     $result = $paytm->gettxn($order_id, $json->amount, $json->users_id);
                     $result = json_decode($result, true);

                     return $this->respond([
                        "order_id" => $order_id,
                        "txn_id" => (!isset($result['body']['txnToken']) ? "" : $result['body']['txnToken']),
                        "status" => 200,
                        "message" => "Success",
                    ]);   

            } else{

                return $this->respond([
                    'status' => 403,
                    'message' => 'Access Denied ! Authentication Failed'
                ]);
                
                }

            }
        }

    }
    
    //-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
    
    
    
    //---------------------------------------------------------API to call for Status of Funds added to Wallet on success from Gateway-----------------------------------
    //-------------------------------------------------------------**************** -------------------------------------------------------------------------------------

    public function transfer_funds()
    {
        if ($this->request->getMethod() != 'post') {

            $this->respond([
                "status" => 405,
                "message" => "Method Not Allowed"
            ]);

        } else {
            //getting JSON data from API
            $json = $this->request->getJSON();
            
            if (
                !property_exists($json, 'amount') || !property_exists($json, 'order_id') || !property_exists($json, 'key') || !property_exists($json, 'users_id')
            ) {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Invalid Parameters'
                ]);
            } else {
                $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
                $apiconfig = new \Config\ApiConfig();

                $api_key = $apiconfig->user_key;

                if ($key == $api_key) {
                    $common = new CommonModel();
                    $paytm = new PaytmModel();

                    $date = date('Y-m-d H:i:s');

                    $check = $common->get_details_dynamically('transaction', 'order_id', $json->order_id);
                    if ($check != 'failure' && $check[0]['payment_status'] != "TXN_FAILURE") {
                        return $this->respond([
                            'status' => 404,
                            'message' => 'Order ID already Used'
                        ]);
                    } else {


                        $result = $paytm->verify_txn($json->order_id);
                        $result = json_decode($result, true);

                        $payment_status = $result['body']['resultInfo']['resultStatus'];
                        
                        $arr_transaction = array();

                        // print_r($result);
                        // exit;
                            
                        if ($json->amount != 0 && $result['body']['resultInfo']['resultStatus'] == 'TXN_FAILURE') {

                            $arr_transaction['payment_status'] = $result['body']['resultInfo']['resultStatus'];
                            $arr_transaction['txnId'] = $result['body']['txnId'];

                        } elseif ($json->amount != 0 && $result['body']['resultInfo']['resultStatus'] == 'TXN_SUCCESS') {

                            $arr_transaction['payment_status'] = $result['body']['resultInfo']['resultStatus'];
                            $arr_transaction['txnId'] = $result['body']['txnId'];
                            $arr_transaction["bankTxnId"] =  $result['body']['bankTxnId'];
                            $arr_transaction["txnType"] = $result['body']['txnType'];
                            $arr_transaction["gatewayName"] =  $result['body']['gatewayName'];
                            $arr_transaction["bankName"] = (isset($result['body']['bankName']) ? $result['body']['bankName'] : "");
                            $arr_transaction["paymentMode"] = $result['body']['paymentMode'];
                            $arr_transaction["refundAmt"] = $result['body']['refundAmt'];
                        }

                            $arr_transaction['name_id'] = 10; //Add to Wallet
                            $arr_transaction['date'] = $date;
                            $arr_transaction['amount'] = $json->amount;
                            $arr_transaction['type_id'] = 1; //Receipt/Credit
                            $arr_transaction['users_id'] = $json->users_id;
                            $arr_transaction['method_id'] = 1; //Online Payment
                            $arr_transaction['booking_id'] = 0;
                            $arr_transaction['order_id'] = $json->order_id;

                            $transaction_id = $common->insert_records_dynamically('transaction', $arr_transaction);

                    }

                    
                    if ($payment_status == 'TXN_SUCCESS') { //Insert into wallet_balance
                        
                            //Make entry in to wallet for users payment
                            //Check if the wallet is created
                            $arr_wallet_details = $common->get_details_dynamically('wallet_balance', 'users_id', $json->users_id);
                            if ($arr_wallet_details != 'failure') {
                                //Get total amount 
                                $wallet_amount = $arr_wallet_details[0]['amount'] + $json->amount;

                                $arr_update_wallet_data = array(
                                    'amount' => $wallet_amount,
                                );
                                $common->update_records_dynamically('wallet_balance', $arr_update_wallet_data, 'users_id', $json->users_id);
                            } else {
                                $arr_wallet_data = array(
                                    'users_id' => $json->users_id,
                                    'amount' => $json->amount,
                                );
                                $common->insert_records_dynamically('wallet_balance', $arr_wallet_data);
                            }
                        
                        return $this->respond([
                            "status" => 200,
                            "message" => "Successfully Updated",
                        ]);
                    } else {
                        return $this->respond([
                            "status" => 404,
                            "message" => "Payment Failure"
                        ]);
                    }
                } else {
                    return $this->respond([
                        'status' => 403,
                        'message' => 'Access Denied ! Authentication Failed'
                    ]);
                }
            }
        }
    }
    //-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
    //---------------------------------------------------------Withdraw Funds-------------------------------------------------
    //-------------------------------------------------------------**************** -----------------------------------------------------

    public function withdraw_funds()
    {
        if ($this->request->getMethod() != 'post') {

            $this->respond([
                "status" => 405,
                "message" => "Method Not Allowed"
            ]);
        } else {
            //getting JSON data from API
            $json = $this->request->getJSON();
            /*echo "<pre>";
            print_r($json);
            echo "</pre>";
            exit;*/

            if (
                !property_exists($json, 'date') || !property_exists($json, 'amount') || !property_exists($json, 'ubd_id')
                || !property_exists($json, 'users_id') || !property_exists($json, 'key')
            ) {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Invalid Parameters'
                ]);
            } else {
                $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
                $apiconfig = new \Config\ApiConfig();

                $api_key = $apiconfig->user_key;

                if ($key == $api_key) {
                    $common = new CommonModel();

                    //Make entry in to wallet for users payment
                    //Check if the wallet is created
                    $arr_wallet_details = $common->get_details_dynamically('wallet_balance', 'users_id', $json->users_id);
                    if ($arr_wallet_details != 'failure') {
                        //Get total amount 
                        $available_amount = $arr_wallet_details[0]['amount'] - $arr_wallet_details[0]['amount_blocked'];
                        if ($available_amount >= $json->amount) {
                            $amount_blocked = $arr_wallet_details[0]['amount_blocked'] + $json->amount;

                            $arr_update_wallet_data = array(
                                'amount_blocked' => $amount_blocked,
                            );
                            $common->update_records_dynamically('wallet_balance', $arr_update_wallet_data, 'users_id', $json->users_id);
                            $date = $json->date;

                            //Insert into withdraw_request
                            $arr_withdraw_request = array(
                                'created_on' => $date,
                                'users_id' => $json->users_id,
                                'amount' => $json->amount,
                                'ubd_id' => $json->ubd_id,
                            );
                            $withdraw_request_id = $common->insert_records_dynamically('withdraw_request', $arr_withdraw_request);

                            if ($withdraw_request_id > 0) {

                                $arr_alerts = array(
                                    'type_id' => 5,
                                    'description' => "Your withdrawl request is succesfully raised with ID: " . $withdraw_request_id . ". Payment will be processed soon",
                                    'user_id' => $json->users_id,
                                    'profile_pic_id' => $json->users_id,
                                    'status' => 2,
                                    'created_on' => $date,
                                    'updated_on' => $date
                                );

                                $common->insert_records_dynamically('alert_regular_sp', $arr_alerts);

                                return $this->respond([
                                    "withdraw_request_id" => $withdraw_request_id,
                                    "status" => 200,
                                    "message" => "Success",
                                ]);
                            } else {
                                return $this->respond([
                                    "status" => 404,
                                    "message" => "Error while processing your request"
                                ]);
                            }
                        } else {
                            return $this->respond([
                                "status" => 404,
                                "message" => "No enough funds to transfer"
                            ]);
                        }
                    }
                    return $this->respond([
                        "status" => 404,
                        "message" => "Your request cannot be processed"
                    ]);
                } else {
                    return $this->respond([
                        'status' => 403,
                        'message' => 'Access Denied ! Authentication Failed'
                    ]);
                }
            }
        }
    }
    //-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
    //---------------------------------------------------------Add Bank Account-------------------------------------------------
    //-------------------------------------------------------------**************** -----------------------------------------------------

    public function add_bank_account()
    {
        if ($this->request->getMethod() != 'post') {

            $this->respond([
                "status" => 405,
                "message" => "Method Not Allowed"
            ]);
        } else {
            //getting JSON data from API
            $json = $this->request->getJSON();
            /*echo "<pre>";
            print_r($json);
            echo "</pre>";
            exit;*/

            if (
                !property_exists($json, 'account_name') || !property_exists($json, 'account_no') || !property_exists($json, 'ifsc_code')
                || !property_exists($json, 'users_id') || !property_exists($json, 'key')
            ) {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Invalid Parameters'
                ]);
            } else {
                $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
                $apiconfig = new \Config\ApiConfig();

                $api_key = $apiconfig->user_key;

                if ($key == $api_key) {
                    $common = new CommonModel();

                    //Check whether the details exists
                    $misc_model = new MiscModel();

                    $validate_bank_details = $misc_model->get_bank_details($json->users_id, $json->account_no);

                    if ($validate_bank_details == 'failure') {
                        //Insert into user_bank_details table
                        $arr_user_bank_details = array(
                            'users_id' => $json->users_id,
                            'account_name' => $json->account_name,
                            'account_no' => $json->account_no,
                            'ifsc_code' => $json->ifsc_code,
                        );
                        $ubd_id = $common->insert_records_dynamically('user_bank_details', $arr_user_bank_details);
                    } else {
                        $ubd_id = $validate_bank_details[0]['ubd_id'];
                    }

                    if ($ubd_id > 0) {
                        return $this->respond([
                            "ubd_id" => $ubd_id,
                            "status" => 200,
                            "message" => ($validate_bank_details == 'failure') ? "Success" : "Account already exist",
                        ]);
                    } else {
                        return $this->respond([
                            "status" => 404,
                            "message" => "Failed to create bank acount"
                        ]);
                    }
                } else {
                    return $this->respond([
                        'status' => 403,
                        'message' => 'Access Denied ! Authentication Failed'
                    ]);
                }
            }
        }
    }
    //-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
    //---------------------------------------------------------Get Bank Account-------------------------------------------------
    //-------------------------------------------------------------**************** -----------------------------------------------------

    public function get_user_bank_account_details()
    {
        if ($this->request->getMethod() != 'post') {

            return $this->respond([
                "status" => 405,
                "message" => "Method Not Allowed"
            ]);
        } else {
            //getting JSON data from API
            $json = $this->request->getJSON();
            /*echo "<pre>";
            print_r($json);
            echo "</pre>";
            exit;*/

            if (
                !property_exists($json, 'users_id') || !property_exists($json, 'key')
            ) {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Invalid Parameters'
                ]);
            } else {
                $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
                $apiconfig = new \Config\ApiConfig();

                $api_key = $apiconfig->user_key;

                if ($key == $api_key) {
                    $common = new CommonModel();

                    $arr_user_bank_details = $common->get_details_dynamically('user_bank_details', 'users_id', $json->users_id);
                    return $this->respond([
                        "user_bank_accounts" => ($arr_user_bank_details != 'failure') ? $arr_user_bank_details : array(),
                        "status" => 200,
                        "message" => "Success",
                    ]);
                } else {
                    return $this->respond([
                        'status' => 403,
                        'message' => 'Access Denied ! Authentication Failed'
                    ]);
                }
            }
        }
    }
    //-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
    //-------------------------------------------------------------**************** -----------------------------------------------------

    public function get_cities()
    {
        $validate_key = $this->request->getVar('key');
        if ($validate_key == "") {
            return $this->respond([
                'status' => 403,
                'message' => 'Invalid Parameters'
            ]);
        } else {
            $key = md5($validate_key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL

            $apiconfig = new \Config\ApiConfig();

            $api_key = $apiconfig->user_key;

            if ($key == $api_key) {
                $common = new CommonModel();
                $res = $common->get_table_details_dynamically('city', 'id', 'ASC');

                if ($res != 'failure') {
                    return $this->respond([
                        "status" => 200,
                        "message" => "Success",
                        "data" => $res
                    ]);
                } else {
                    return $this->respond([
                        "status" => 200,
                        "message" => "No Faq to Show"
                    ]);
                }
            } else {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Access Denied ! Authentication Failed'
                ]);
            }
        }
    }

    //-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------


    //-------------------------------------------------------------UPLOAD FILES-----------------------------------------------------------

    public function convertFiles()
    {

        $common = new CommonModel();
        $json = $this->request->getJSON();
        $booking_id = $json->booking_id;
        $users_id = $json->users_id;
        $description = $json->description;

        $attachments = $this->request->getJsonVar('attachments', true);
        
        //Create and save atatchments
        if (count($attachments) > 0) {

            foreach ($attachments as $attach_key => $data) {
                                
                
                $pos = strpos($data['file'], 'firebasestorage');

                if ($pos !== false) { //URL
                    $url = $data['file'];

                    list($path, $token) = explode('?', $url);

                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    $data = file_get_contents($url);
                    $base64_file = base64_encode($data);

                    $file = $base64_file;
                    
                } else {
                    $type = $data['type'];
                   
                }
                //---------Code for S3 Object Create Starts
                $images = ['png','jpeg','jpg','gif','tiff'];
                $video = ['mp4','mp3','mpeg','mpeg4','3gp','wav','mov'];

                if(in_array($data['type'],$images)){
                    $folder = "images";
                }elseif(in_array($data['type'],$video)){
                    $folder = 'videos';
                }else{
                    $folder = 'documents';
                }

                $file = generateS3Object($folder,$data['file'],$data['type']); 

                // $filename_path = md5(time().uniqid()).".".$type;
                
                // $decoded=base64_decode($data['file']); 
                // file_put_contents("uploads/".$filename_path,$decoded);

                
                // $file = generateDynamicImage("images/attachments", $data, $type);

                    $arr_attach = array(
                        'booking_id' => $booking_id,
                        'file_name' => $file,
                        'file_location' => $folder,
                        'created_by' => $users_id,
                        'status_id' => 44,
                        'description' => $description,
                        'created_on' => date('Y-m-d H:i:s') 
                    );
                    $common->insert_records_dynamically('attachments', $arr_attach);

                    $file_path[$attach_key] = $file;
                    
                               
            }

            return $this->respond([
                "status" => 200,
                "message" => "Success",
                "file_name" => $file_path
            ]);
        }
    }


    //-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------


    //-------------------------------------------------------------VIEW FILES FOR BLUE COLLAR-----------------------------------------------------------

    public function view_files_user(){

        if ($this->request->getMethod() != 'get') {

            return $this->respond([
                "status" => 405,
                "message" => "Method Not Allowed"
            ]);

        } else {
            
            $json = $this->request->getJSON();
            
            if (
                !property_exists($json, 'booking_id') || !property_exists($json, 'key') 
            ) {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Invalid Parameters'
                ]);
            } else {
            
                $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
                $apiconfig = new \Config\ApiConfig();

                $api_key = $apiconfig->user_key;

                if ($key == $api_key) {
                    $common = new CommonModel();
                    $misc = new MiscModel();

                    $user_details = $misc->get_user_details_by_booking_id($json->booking_id);
                    $sp_details = $misc->get_sp_details_by_booking_id($json->booking_id);

                    //Get Attachments list
                    $result = $misc->get_attachments($json->booking_id,$user_details[0]['id'],$sp_details[0]['id']);

                    $att = [];

                    if($result !='failure'){

                        foreach ($result as $key => $dat){
                             
                               if($dat['created_by'] == $user_details[0]['id']){

                                    $att[$key]['id'] = $dat['id'];
                                    $att[$key]['file'] = $dat['file_name'];
                                    $att[$key]['created_on'] = $dat['created_on'];
                                    $att[$key]['description'] = $dat['description'];
                                    $att[$key]['reason'] = $dat['file_status'];
                                    $att[$key]['created_by'] = 'user';
                                    $att[$key]['fname'] = $user_details[0]['fname'];
                                    $att[$key]['lname'] = $user_details[0]['lname'];
                                    $att[$key]['profile_pic'] = $user_details[0]['profile_pic'];


                               } elseif($dat['created_by'] == $sp_details[0]['id']){

                                    $att[$key]['id'] = $dat['id'];
                                    $att[$key]['file'] = $dat['file_name'];
                                    $att[$key]['created_on'] = $dat['created_on'];
                                    $att[$key]['description'] = $dat['description'];
                                    $att[$key]['reason'] = $dat['file_status'];
                                    $att[$key]['created_by'] = 'sp';
                                    $att[$key]['fname'] = $sp_details[0]['fname'];
                                    $att[$key]['lname'] = $sp_details[0]['lname'];
                                    $att[$key]['profile_pic'] = $sp_details[0]['profile_pic'];

                               }
                        }

                    }

                    return $this->respond([
                        'status' => 200,
                        'message' => $att
                    ]);                   

                    }
                }
            }
    }


     //-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------


    //-------------------------------------------------------------SEND FCM MESSAGE TO SERVER-----------------------------------------------------------


    public function send_fcm(){

        $json = $this->request->getJSON();
    
        //Url to send FCM Message
        $url = "https://fcm.googleapis.com/fcm/send";
    
        $post_data = json_encode($json);

        $server_key = 'AAAAKN1BReU:APA91bGKiUADwwYmrfdxBEKhxle_k7axC4nGQYMDVAU-w3fJ09vDaWNoUfum3KCXr5bJKNcUE2bxtt30_ID6DF1vWHUfBu7grfoc_ncZi13HrKM73Np4POKUrT1ng-FAlK_T7ZQf-kPc';    
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$server_key
            );
    
           
        $ch = curl_init($url);
    
        curl_setopt($ch, CURLOPT_POST, true);
    
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
        $response = curl_exec($ch);

        if ($response === FALSE) {
            die('Oops! FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);

        $res = json_decode($response, true);
            
        return $this->respond([
            'status' => 200,
            'message' => $res
            ]);
    
    }
    

}