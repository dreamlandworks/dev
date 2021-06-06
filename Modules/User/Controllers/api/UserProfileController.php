<?php

namespace Modules\User\Controllers\api;

use CodeIgniter\RESTful\ResourceController;
use Modules\User\Models\UsersModel;
use Modules\User\Models\UserDetailsModel;
use Modules\User\Models\AddressModel;
use Modules\User\Models\ReferralModel;


helper('Modules\User\custom');

class UserProfileController extends ResourceController
{


    //--------------------------------------------------GET USER DETAILS STARTS------------------------------------------------------------
    //-----------------------------------------------****************************----------------------------------------------------------

    /**
     * Function to show user profile details
     * 
     * Call to this function outputs user details
     * @param int $id
     * @return [JSON]
     */
    public function show_user()
    {
        $id = $this->request->getJsonVar('id');
        $con = new UsersModel();
        $con1 = new UserDetailsModel();
        $con2 = new AddressModel();
        $con3 = new ReferralModel();

        //Check whether User Exists or Not
        if (($user = $con->search_user($id)) != null) {

            $email = $user['email'];

            //Get User Details
            if (($res = $con1->user_details_by_id($id)) != 0) {
                $fname = $res['fname'];
                $lname = $res['lname'];
                $mobile = $res['mobile'];
                $dob = $res['dob'];
                $profile_pic = $res['profile_pic'];
                $ref_id = $res['referral_id'];
            } else {
                return $this->respond([
                    "status" => 400,
                    "message" => "Failed to Retrieve User Details"
                ]);
            }

            //Get Address Details

            if (($add = $con2->get_by_user_id($id)) != null) {
                $address = $add;
            } else {
                $address = null;
            }

            //Get Referral ID

            if (($ref = $con3->get_details($ref_id)) != null) {
                $referral_id = $ref['referral_id'];
            } else {
                $referral_id = null;
            }

            $array = [
                "fname" => $fname,
                "lname" => $lname,
                "mobile" => $mobile,
                "email_id" => $email,
                "dob" => $dob,
                "profile_pic" => $profile_pic,
                "referral_id" => $referral_id,
                "address" => $address
            ];

            return $this->respond([
                "status" => 200,
                "message" => "Success",
                "data" => $array
            ]);
        }
    }

    //--------------------------------------------------GET USER DETAILS ENDS------------------------------------------------------------




    //--------------------------------------------------UPDATE USER PROFILE STARTS------------------------------------------------------------
    //-----------------------------------------------****************************----------------------------------------------------------

    /**
     * Function to update User Profile
     * 
     * JSON data is passed into this function to update user profile using
     * @method POST with 
     * @param mixed $user_id, @param string $fname, @param string $lname,
     * @param mixed $email, @param mixed $dob, @param string $image [Base64 encoded]  
     * @return [JSON] Success|Fail
     */
    public function update_profile()
    {


        $con = new UsersModel();
        $con1 = new UserDetailsModel();

        $data = $this->request->getJSON();
        $id = $data->user_id;
        $fname = $data->fname;
        $lname = $data->lname;
        $email = $data->email;
        $dob = $data->dob;

        $file = $data->image;
        $image = '';
        if ($file != null) {

            $image = generateImage($file);
            
            $array = [
                "fname" =>  $fname,
                "lname" =>  $lname,
                "dob" =>  $dob,
                "profile_pic" =>  $image
            ];

        }else{

            $array = [
                "fname" =>  $fname,
                "lname" =>  $lname,
                "dob" =>  $dob              
            ];
        }

        if (($res = $con->update_email($id, $email)) != 0) {

            $users_id = $res;

            
            if ($con1->update_user_details($users_id, $array) != null) {

                return $this->respond([
                    "status" => 200,
                    "message" =>  "Successfully Updated"
                ]);
            } else {

                return $this->respond([
                    "status" => 400,
                    "message" =>  "Failed to Update"
                ]);
            }
        }
    }



//--------------------------------------------------UPDATE USER PROFILE ENDS------------------------------------------------------------


//--------------------------------------------------DELETE USER ADDRESS START------------------------------------------------------------

public function delete_address(){
    
    $con = new AddressModel();

    $id = $this->request->getJsonVar('id');

    if($con->delete_address($id) != 0){
        return $this->respond([
            "status" => 200,
            "message" =>  "Successfully Deleted"
        ]);
    }
}

//--------------------------------------------------DELETE USER ADDRESS END------------------------------------------------------------


}
