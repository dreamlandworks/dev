<?php

namespace Modules\Admin\Controllers\web;

use App\Controllers\BaseController;
use Modules\Admin\Models\MiscModel;
use Modules\Provider\Models\CommonModel;

class Serviceproviders extends BaseController
{
    //---------------------------------------------------------Dashboard-------------------------------------------------
    //-------------------------------------------------------------**************** -----------------------------------------------------

    public function get_provider_data()
    {
        $misc = new MiscModel();

        $data = $misc->get_sp_not_approved();


        if ($data != 'failure') {

            foreach ($data as $key => $d) {

                $dat[$key]['fname'] = $d['fname'];
                $dat[$key]['lname'] = $d['lname'];
                $dat[$key]['mobile'] = $d['mobile'];
                $dat[$key]['email'] = $d['email'];
                $dat[$key]['city'] = ($d['city'] != "" ? $d['city'] : 'Null');
                $dat[$key]['state'] = ($d['state'] != "" ? $d['state'] : 'Null');
                $dat[$key]['country'] = ($d['country'] != "" ? $d['country'] : 'Null');
                $dat[$key]['id'] = $d['id'];

                // echo "<tr id='data". $dat[$key]['id'] ."'><td class='text-center'>" . $dat[$key]['id'] . "</td><td>"
                //     . $dat[$key]['fname'] . "</td><td>"
                //     . $dat[$key]['lname'] . "</td><td>"
                //     . $dat[$key]['mobile'] . "</td><td>"
                //     . $dat[$key]['email'] . "</td><td>"
                //     . $dat[$key]['city'] . "</td><td>"
                //     . $dat[$key]['state'] . "</td><td>"
                //     . $dat[$key]['country'] . "</td><td>
                //     <div class='form-group'>    
                //       <button id='approve' type='submit' class='btn btn-fill btn-success btn-sm' onclick='accept(".$dat[$key]['id'].")'>Approve</button>
                //       <button id='reject' type='submit' class='btn btn-fill btn-danger btn-sm' onclick='reject(".$dat[$key]['id'].")'>Reject</button>
                //     </div>
                //                 </td>
                //             </tr>";

            }

            $sp['spdata'] = $dat;

            // echo "<pre>";
            // print_r($sp['spdata']);
            // echo "</pre>";
            // exit;
            return view('\Modules\Admin\Views\serviceproviders\activateProvider', $sp);
        }
    }

    public function approve_sp()
    {
        $id = $this->request->getVar('id');
        $status = $this->request->getVar('status');

        $common = new CommonModel();

        $data = [
            "sp_activated" => $status
        ];

        $common = new CommonModel();
        $common->update_records_dynamically('users', $data, 'id', $id);
    }


    public function get_more_sp_data($id)
    {

        $misc = new MiscModel();

        $bookings_pending = 0;
        $bookings_in_progress = 0;
        $bookings_completed = 0;
        $bookings_rejected = 0;
        $bookings_cancelled = 0;
        $bookings_not_responded = 0;
        $bookings_not_identified = 0;

        $bids_submitted = 0;
        $bids_awarded = 0;
        $bids_rejected = 0;
        $bids_expired = 0;
        $bids_not_identified = 0;

        //Gettings Bookings Data
        $bookings_data = $misc->get_sp_booking_count($id);

        if ($bookings_data != 'failure') {
            foreach ($bookings_data as $key => $val) {
                $dat[$key]['status_id'] = $val['status_id'];
                $dat[$key]['count'] = $val['bookings_count'];

                switch (true) {
                    case in_array($dat[$key]['status_id'], range(4, 4)):
                        $bookings_rejected = $bookings_rejected +  $dat[$key]['count'];
                        break;
                    case in_array($dat[$key]['status_id'], range(6, 6)):
                        $bookings_not_responded = $bookings_not_responded +  $dat[$key]['count'];
                        break;
                    case in_array($dat[$key]['status_id'], range(9, 12)):
                        $bookings_pending = $bookings_pending +  $dat[$key]['count'];
                        break;
                    case in_array($dat[$key]['status_id'], range(13, 21)):
                        $bookings_in_progress = $bookings_in_progress +  $dat[$key]['count'];
                        break;
                    case in_array($dat[$key]['status_id'], range(23, 23)):
                        $bookings_completed = $bookings_completed +  $dat[$key]['count'];
                        break;
                    case in_array($dat[$key]['status_id'], range(25, 25)):
                        $bookings_cancelled = $bookings_cancelled +  $dat[$key]['count'];
                        break;
                    default:
                        $bookings_not_identified = $bookings_not_identified + $dat[$key]['count'];
                }
            }
        }


        //Getting SP Data
        $bid_details = $misc->get_sp_bids_count($id);

        if ($bid_details != 'failure') {
            foreach ($bid_details as $key => $val) {
                $bid[$key]['status_id'] = $val['status_id'];
                $bid[$key]['count'] = $val['bids_count'];

                switch ($bid[$key]['status_id']) {
                    case 40:
                        $bids_submitted = $bids_submitted + $bid[$key]['count'];
                        break;

                    case 27:
                        $bids_awarded = $bids_awarded + $bid[$key]['count'];
                        break;

                    case 28:
                        $bids_expired = $bids_expired + $bid[$key]['count'];
                        break;

                    case 29:
                        $bids_rejected = $bids_rejected + $bid[$key]['count'];
                        break;

                    default:
                        $bids_not_identified = $bids_not_identified + $bid[$key]['count'];
                }
            }
        }

        

        echo    "        
        <h4>Bookings Details</h4>
        <div class='d-flex justify-content-center text-center'>
        
        <div class='card' style='width:150px; margin-right:10px'>
        <div class = 'card-header bg-primary text-white'>
        <h6 class='modal-title font-weight-normal' id='modal-title-default'>Pending Bookings</h6>
        </div>
           <div class='card-body'>
               <h6 class='card-title'>" . $bookings_pending . "</h6>
            </div>
    </div>

    <div class='card' style='width:150px; margin-right:10px'>
        <div class = 'card-header bg-primary text-white'>
        <h6 class='modal-title font-weight-normal' id='modal-title-default'>Bookings In-Progress</h6>
        </div>
           <div class='card-body'>
               <h5 class='card-title'>" . $bookings_in_progress . "</h5>
            </div>
    </div>

    <div class='card' style='width:150px; margin-right:10px'>
        <div class = 'card-header bg-primary text-white'>
        <h6 class='modal-title font-weight-normal' id='modal-title-default'>Bookings Completed</h6>
        </div>
           <div class='card-body'>
               <h5 class='card-title'>" . $bookings_completed . "</h5>
            </div>
    </div>

    <div class='card' style='width:150px; margin-right:10px'>
        <div class = 'card-header bg-primary text-white'>
        <h6 class='modal-title font-weight-normal' id='modal-title-default'>Bookings Rejected</h6>
        </div>
           <div class='card-body'>
               <h5 class='card-title'>" . $bookings_rejected . "</h5>
            </div>
    </div>

    <div class='card' style='width:150px; margin-right:10px'>
        <div class = 'card-header bg-primary text-white'>
        <h6 class='modal-title font-weight-normal' id='modal-title-default'>Bookings Cancelled</h6>
        </div>
           <div class='card-body'>
               <h5 class='card-title'>" . $bookings_cancelled . "</h5>
            </div>
    </div>

    <div class='card' style='width:150px; margin-right:10px'>
        <div class = 'card-header bg-primary text-white'>
        <h6 class='modal-title font-weight-normal' id='modal-title-default'>Bookings Not Responded</h6>
        </div>
           <div class='card-body'>
               <h5 class='card-title'>" . $bookings_not_responded . "</h5>
            </div>
    </div>
                    
         </div>
         <h4>Bids Details</h4>
         <div class='d-flex justify-content-center text-center'>
         
         <div class='card' style='width:150px; margin-right:10px'>
        <div class = 'card-header bg-primary text-white'>
        <h6 class='modal-title font-weight-normal' id='modal-title-default'>Bids Submitted</h6>
        </div>
           <div class='card-body'>
               <h5 class='card-title'>" . $bids_submitted . "</h5>
            </div>
    </div>

    <div class='card' style='width:150px; margin-right:10px'>
        <div class = 'card-header bg-primary text-white'>
        <h6 class='modal-title font-weight-normal' id='modal-title-default'>Bids Awarded</h6>
        </div>
           <div class='card-body'>
               <h5 class='card-title'>" . $bids_awarded . "</h5>
            </div>
    </div>


    <div class='card' style='width:150px; margin-right:10px'>
        <div class = 'card-header bg-primary text-white'>
        <h6 class='modal-title font-weight-normal' id='modal-title-default'>Bids Rejected</h6>
        </div>
           <div class='card-body'>
               <h5 class='card-title'>" . $bids_rejected . "</h5>
            </div>
    </div>

    <div class='card' style='width:150px; margin-right:10px'>
        <div class = 'card-header bg-primary text-white'>
        <h6 class='modal-title font-weight-normal' id='modal-title-default'>Bids Expired</h6>
        </div>
           <div class='card-body'>
               <h5 class='card-title'>" . $bids_expired . "</h5>
            </div>
    </div>


         </div>
        
        
        
                    ";
    }


    public function list_providers()
    {
        $misc = new MiscModel();
        $sp_dt['data']= $misc->get_sp_list();
        return view('\Modules\Admin\Views\serviceproviders\listServiceProviders', $sp_dt);
    }

    public function edit_serviceproviders($id)
    {
        $misc = new MiscModel();
        $data['SpDetails']=$misc->get_sp_details($id);
        $data['countryList'] = $misc->getCountryList();
        print_r($data);
        echo view('\Modules\Admin\Views\serviceproviders\editServiceProviders',$data);        
    }
    public function updateSpProvider(){

        echo $id = $this->request->getPost('id');
        echo $fname = $this->request->getPost('fname');
        echo $lname = $this->request->getPost('lname');
        echo $mob = $this->request->getPost('mob');
        echo $email = $this->request->getPost('email');
        echo $city = $this->request->getPost('city');
        echo $state = $this->request->getPost('state');
        echo $country = $this->request->getPost('country');
        // update data
        $misc = new MiscModel();
        $data['SpDetails'] = $misc->update_sp_details($id,$fname,$lname,$mob,$email,$city,$state,$country); 
    }
    //-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
    //  List of Coutnry Ajax
    function listOfCountry(){
        $misc = new MiscModel();
        $data = $misc->getCountryList();
        echo json_encode($data);
    }
    // List State Specific to Country
    function listOfStateAjax(){
        $countryId = $this->request->getPost('countryId');
        $misc = new MiscModel();
        $data = $misc->getStateList($countryId);
        echo json_encode($data);

    }
    // List of City Specific to State
    function listOfCity(){
        $stateId = $this->request->getPost('stateId');
        $misc = new MiscModel();
        $data = $misc->getCityList($stateId);
        echo json_encode($data);
    }

}
