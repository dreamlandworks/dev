<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SPController;
use App\Http\Controllers\ProfessionController;
use App\Http\Controllers\SMBookingController;
use App\Http\Controllers\CBBookingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\QualificationController;
use App\Http\Controllers\KeywordController;
use App\Http\Controllers\CbPostJobController;
use App\Http\Controllers\UserPlanController;
use App\Http\Controllers\SpPlanController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\CBJobController;
use App\Http\Controllers\HrController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendenceController;
use App\Http\Controllers\MarketPlanController;
use App\Http\Controllers\ModuleListController;
use App\Http\Controllers\LeadsController;
use App\Http\Controllers\BidsController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\WithdrawlRequest;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\DashboardController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // dd(\Hash::make('12345678'));
    return view('auth.login');
});

Route::get('/logout', [LogoutController::class,'perform'])->name('logout.perform');


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

Route::get('/dashboard',[DashboardController::class,'dashboard'])->middleware(['auth'])->name('dashboard');

Route::group(['middleware' => ['auth']], function() {

    Route::get('get-keyword', [SPController::class, 'get_keyword'])->name('get-keyword');

//User

Route::get('/users',[UserController::class,'index']);
Route::get('user/create',[UserController::class,'create']);
Route::post('user/create',[UserController::class,'store'])->name('create-user');
Route::get('user/{id}',[UserController::class,'edit']);
Route::post('user/update',[UserController::class,'update']);
Route::get('user/delete/{id}',[UserController::class,'delete']);

//Service Provider

Route::get('/sp/user-detail',[SPController::class,'get_user']);
Route::post('/sp/user-approve',[SPController::class,'user_approve']);

Route::get('/sps',[SPController::class,'index']);
Route::get('sp/create',[SPController::class,'create']);
Route::post('sp/create',[SPController::class,'store'])->name('create-sp');
Route::get('sp/{users_id}',[SPController::class,'edit']);
Route::post('sp/update',[SPController::class,'update']);
Route::get('sp/delete/{id}',[SPController::class,'delete']);
Route::get('sp/profile/{users_id}',[SPController::class,'profile']);

Route::get('/Approve-sps',[SPController::class,'Approve_sp']);
Route::get('/sp-userinfo/{users_id}',[SPController::class,'sp_modal']);
Route::get('/sp-approve',[SPController::class,'sp_approve']);
Route::get('/sp-reject',[SPController::class,'sp_reject']);


//Profession
Route::post('sp/profession/create',[ProfessionController::class,'store_pro'])->name('create-profession');
Route::post('sp/qualification/create',[ProfessionController::class,'store_qua'])->name('create-qualification');
Route::post('sp/skill/create',[ProfessionController::class,'store_skill'])->name('create-skill');
Route::post('sp/language/create',[ProfessionController::class,'store_lang'])->name('create-language');
Route::post('sp/slot/create',[ProfessionController::class,'store_slot'])->name('create-slot');

Route::get('sp/sub/scategory',[SubCategoryController::class,'modal_sub_cat']);

//SM Booking
Route::get('/booking-sm',[SMBookingController::class,'index']);
Route::get('/booking-sm/qd/{msg?}',[SMBookingController::class,'indexMsg']);
Route::get('booking-sm/create',[SMBookingController::class,'create']);
Route::post('booking-sm/create',[SMBookingController::class,'store'])->name('create-booking-sm');
Route::get('/booking-sm/user-detail',[SPController::class,'get_user']);
Route::get('/booking-sm/sp-detail',[SPController::class,'get_sp']);
Route::get('/booking-sm/getSPInfo',[SMBookingController::class,'getspinfo']);
Route::post('booking-sm/transaction',[SMBookingController::class,'store_txn']);
Route::post('/sm/re-schedule',[SMBookingController::class,'re_schedule']);
Route::post('/sm-bookingRecshedule',[SMBookingController::class,'bookingschedule']);

// job post
Route::get('/job-post-sm',[JobController::class,'index']);
Route::get('/job-post-sm/view-sm-post/{booking_id}',[JobController::class,'view_sm_post']);
Route::get('/job-post-sm/view-sm-post/award/{bid_id}',[JobController::class,'award_bid']);
Route::get('/job-post-sm/view-sm-post/reject/{bid_id}',[JobController::class,'reject_bid']);
Route::get('/job-post-sm/qd/{msg?}',[JobController::class,'indexMsg']);
Route::get('job-post-sm/create',[JobController::class,'create']);
Route::post('job-post-sm/create',[JobController::class,'store'])->name('create-job');
Route::get('/job-post-sm/user-detail',[SPController::class,'get_user']);
Route::get('/job-post-sm/getSPInfo',[JobController::class,'getspinfo']);
Route::post('job-post-sm/transaction',[JobController::class,'store_txn']);


//CB Booking
Route::get('/booking-cb',[CBBookingController::class,'index']);
Route::get('/booking-cb/qd/{msg?}',[CBBookingController::class,'indexMsg']);
Route::get('booking-cb/create',[CBBookingController::class,'create']);
Route::post('booking-cb/create',[CBBookingController::class,'store'])->name('create-booking-cb');
Route::get('/booking-cb/getSPInfo',[CBBookingController::class,'getspinfo']);
Route::get('/booking-cb/user-detail',[SPController::class,'get_user']);
Route::post('booking-cb/transaction',[CBBookingController::class,'store_txn']);
Route::post('/cb/re-schedule',[CBBookingController::class,'re_schedule']);
Route::post('/cb-bookingRecshedule',[CBBookingController::class,'bookingschedule']);

// CB job post
Route::get('/job-post-cb',[CBJobController::class,'index']);
Route::get('/job-post-cb/view-cb-post/{booking_id}',[CBJobController::class,'view_cb_post']);
Route::get('/job-post-cb/view-cb-post/award/{bid_id}',[CBJobController::class,'award_bid']);
Route::get('/job-post-cb/view-cb-post/reject/{bid_id}',[CBJobController::class,'reject_bid']);
Route::get('/job-post-cb/qd/{msg?}',[CBJobController::class,'indexMsg']);
Route::get('job-post-cb/create',[CBJobController::class,'create']);
Route::post('job-post-cb/create',[CBJobController::class,'store'])->name('create-cb-job');
Route::get('/job-post-cb/user-detail',[SPController::class,'get_user']);
Route::get('/job-post-cb/getSPInfo',[CBJobController::class,'getspinfo']);
Route::post('job-post-cb/transaction',[CBJobController::class,'store_txn']);

//category
Route::get('/categories',[CategoryController::class,'index']);
Route::get('/category/create',[CategoryController::class,'create']);
Route::post('/category/create',[CategoryController::class,'store'])->name('create-category');
Route::get('category/{id}',[CategoryController::class,'edit']);
Route::post('category/update',[CategoryController::class,'update']);
Route::get('category/delete/{id}',[CategoryController::class,'delete']);

// Employee Management
Route::get('/employee/list',[EmployeeController::class,'index']);
Route::get('/employee/create',[EmployeeController::class,'create_employee']);
Route::post('/employee/create',[EmployeeController::class,'store_employee'])->name('create-employee');
Route::get('/employee/{emp_id}',[EmployeeController::class,'edit_employee']);
Route::post('/employee/update',[EmployeeController::class,'update_employee'])->name('edit-employee');
Route::get('employee/delete/{id}',[EmployeeController::class,'delete']);
Route::post('/employee/filterDesignation',[EmployeeController::class,'filter']);

Route::get('/attendence/list',[AttendenceController::class,'view_attendence']);
Route::get('/attendence/each-attendence',[AttendenceController::class,'view_each_attendence']);
Route::get('/attendence/each-attendence/filter',[AttendenceController::class,'each_date_attendence']);
Route::get('/attendence/create',[AttendenceController::class,'create_attendence']);
Route::post('/attendence/create',[AttendenceController::class,'store_attendence'])->name('create-attendence');
Route::get('/attendence/each-list/{emp_id}',[AttendenceController::class,'each_attendence']);
Route::get('/attendence/each-list/{emp_id}/filter-list',[AttendenceController::class,'filter_attendence']);

//performance
Route::get('/performance/list',[AttendenceController::class,'view_performance']);
Route::get('/performance/edit/{performance_id}',[AttendenceController::class,'edit_performance']);
Route::post('/performance/edit',[AttendenceController::class,'update_performance'])->name('edit-performance');
Route::get('/performance/create',[AttendenceController::class,'create_performance']);
Route::post('/performance/create',[AttendenceController::class,'storePreformanceReport'])->name('performance-report');
Route::get('/performance/getEmployeeDetail',[AttendenceController::class,'fetchEmpDet']);
Route::get('/performance/edit/{performance_id}/getEmployeeDetail',[AttendenceController::class,'fetchEmpDet']);
Route::get('/performance/delete/{performance_id}',[AttendenceController::class,'delete_performance']);

//relieve letter
Route::get('/relieve/list',[AttendenceController::class,'view_relieve']);
Route::get('/relieve/create',[AttendenceController::class,'create_relieve']);
Route::post('/relieve/create',[AttendenceController::class,'store_relieve'])->name('create-relieve');
Route::get('/relieve/edit/{relieve_id}',[AttendenceController::class,'edit_relieve']);
Route::post('/relieve/edit',[AttendenceController::class,'update_relieve'])->name('update-relieve');
Route::get('/relieve/delete/{relieve_id}',[AttendenceController::class,'delete_relieve']);
Route::get('/relieve/getEmployeeDetail',[AttendenceController::class,'fetchEmpDet']);

//HR Management
Route::get('/hr',[HrController::class,'index']);
Route::get('/hr/create-designation',[HrController::class,'create_designation']);
Route::post('/hr/create-designation',[HrController::class,'store_designation'])->name('create-designation');
Route::get('hr/{designation}',[HrController::class,'edit_designation']);
Route::get('hr/delete/{designation}',[HrController::class,'delete_designation']);

/// support management

Route::get('/support/list',[SupportController::class,'index']);
Route::get('/support/create',[SupportController::class,'create']);
Route::post('/support/create',[SupportController::class,'store'])->name('create-ticket');
Route::get('/support/edit-ticket/{id}',[SupportController::class,'edit']);
Route::post('/support/edit-ticket',[SupportController::class,'update'])->name('edit-ticket');
Route::get('/support/delete/{id}',[SupportController::class,'delete']);


//Market Management
Route::get('/marketing-plans',[MarketPlanController::class,'index']);
Route::get('/marketing-plan/create',[MarketPlanController::class,'create']);
Route::post('/marketing-plan/create',[MarketPlanController::class,'store'])->name('create-marketing-plan');
Route::get('/marketing-plan/{id}',[MarketPlanController::class,'edit']);
Route::post('/marketing-plan/update',[MarketPlanController::class,'update']);
Route::get('/marketing-plan/delete/{id}',[MarketPlanController::class,'delete']);

///Marketing statistics
Route::get('/marketing-statistics',[MarketPlanController::class,'statistics_index']);
Route::get('/marketing-statistics/create',[MarketPlanController::class,'statistics_create']);
Route::post('/marketing-statistics/create',[MarketPlanController::class,'store_statistics'])->name('create-market-statistics');
Route::get('/marketing-statistics/edit/{id}',[MarketPlanController::class,'statistics_edit']);
Route::post('/marketing-statistics/edit',[MarketPlanController::class,'update_statistics'])->name('update-market-statistics');
Route::get('/marketing-statistics/delete/{id}',[MarketPlanController::class,'delete_statistics']);


//Leads
Route::get('/leads-list',[LeadsController::class,'index']);
Route::get('/lead/create',[LeadsController::class,'create']);
Route::post('/lead/create',[LeadsController::class,'store'])->name('create-lead');
Route::get('/lead/{id}',[LeadsController::class,'edit']);
Route::post('/lead/update',[LeadsController::class,'update']);
Route::get('/lead/delete/{id}',[LeadsController::class,'delete']);

/// Account Management
Route::get('/account/list',[BidsController::class,'index']);
Route::get('/account/create-bid',[BidsController::class,'create']);
Route::post('/account/create-bid',[BidsController::class,'store'])->name('create-bid');
Route::get('account/edit-bid/{id}',[BidsController::class,'edit']);
Route::post('/account/edit-bid',[BidsController::class,'update'])->name('update-bid');
Route::get('/account/delete/{id}',[BidsController::class,'delete']);


// view Receipts

Route::get('account/receipts',[ReceiptController::class,'view_receipt']);
Route::post('account/receipts',[ReceiptController::class,'get_receipt'])->name('view-receipt');
Route::get('account/receipt-info/{txn_id}',[ReceiptController::class,'receipt_modal']);
Route::get('account/bookingid-receipts',[ReceiptController::class,'bookingid_receipt']);
Route::post('account/bookingid-receipts',[ReceiptController::class,'bookingid_receipt_filter'])->name('check-booking_id');
Route::get('account/transaction-info/{txn_id}',[ReceiptController::class,'transaction_modal']);
Route::get('account/payments',[ReceiptController::class,'payments']);
Route::post('account/payments',[ReceiptController::class,'get_payment'])->name('view-payment');
Route::get('account/payment-info/{txn_id}',[ReceiptController::class,'payment_modal']);

// withdrawl request 
Route::get('account/approved-withdrawl',[WithdrawlRequest::class,'index']);
Route::get('account/approve-withdrawl',[WithdrawlRequest::class,'approve_withdrawl']);
Route::get('account/create-withdrawl',[WithdrawlRequest::class,'create']);
Route::post('account/create-withdrawl',[WithdrawlRequest::class,'store'])->name('create-withdrawl');
Route::post('account/create-bank',[WithdrawlRequest::class,'store_bank'])->name('create-bank');
Route::get('account/wallet-balance',[WithdrawlRequest::class,'wallet_balance']);
Route::get('account/approverequest/{id}',[WithdrawlRequest::class,'approverequest']);
Route::get('account/rejectrequest/{id}',[WithdrawlRequest::class,'rejectrequest']);
Route::get('account/edit-request/{id}',[WithdrawlRequest::class,'edit_request']);
Route::post('account/edit-request',[WithdrawlRequest::class,'update_request'])->name('edit-withdrawl');
Route::get('account/gettxnDetails',[WithdrawlRequest::class,'get_txn_detail']);

//Module List
Route::get('/module-lists',[ModuleListController::class,'index']);
Route::get('/module-list/create',[ModuleListController::class,'create']);
Route::post('/module-list/create',[ModuleListController::class,'store'])->name('create-module-list');
Route::get('/module-list/{id}',[ModuleListController::class,'edit']);
Route::post('/module-list/update',[ModuleListController::class,'update']);
Route::get('/module-list/delete/{id}',[ModuleListController::class,'delete']);


//SubCategory
Route::get('/sub-categories',[SubCategoryController::class,'index']);
Route::get('/sub-cat',[SubCategoryController::class,'get_sub_cat']);
Route::get('/sub-category/create',[SubCategoryController::class,'create']);
Route::post('/sub-category/create',[SubCategoryController::class,'store'])->name('create-sub-category');
Route::get('sub-category/{id}',[SubCategoryController::class,'edit']);
Route::post('sub-category/update',[SubCategoryController::class,'update']);
Route::get('sub-category/delete/{id}',[SubCategoryController::class,'delete']);

Route::get('prof/sub-cat',[SubCategoryController::class,'sub_cat']);

//Profession
Route::get('/professions',[ProfessionController::class,'index']);
Route::get('/get-prof',[ProfessionController::class,'get_prof']);
Route::get('/prof/create',[ProfessionController::class,'create_profession']);
Route::post('/prof/create',[ProfessionController::class,'store'])->name('create-prof');
Route::get('prof/{id}',[ProfessionController::class,'edit']);
Route::post('prof/update',[ProfessionController::class,'update']);
Route::get('prof/delete/{id}',[ProfessionController::class,'delete']);


//Qualification
Route::get('/qualifications',[QualificationController::class,'index']);
Route::get('/qual/create',[QualificationController::class,'create']);
Route::post('/qual/create',[QualificationController::class,'store'])->name('create-qual');
Route::get('qual/{id}',[QualificationController::class,'edit']);
Route::post('qual/update',[QualificationController::class,'update']);
Route::get('qual/delete/{id}',[QualificationController::class,'delete']);

//Keyword
Route::get('/keywords',[KeywordController::class,'index']);
Route::get('/assign-permisson',[KeywordController::class,'assign_permission']);
Route::get('/keyword/create',[KeywordController::class,'create']);
Route::post('/keyword/create',[KeywordController::class,'store'])->name('create-keyword');
Route::get('keyword/{id}',[KeywordController::class,'edit']);
Route::post('keyword/update',[KeywordController::class,'update']);
Route::get('keyword/delete/{id}',[KeywordController::class,'delete']);


//UserPlans
Route::get('/user-plans',[UserPlanController::class,'index']);
Route::get('/user-plan/create',[UserPlanController::class,'create']);
Route::post('/user-plan/create',[UserPlanController::class,'store'])->name('create-user-plan');
Route::get('user-plan/{id}',[UserPlanController::class,'edit']);
Route::post('user-plan/update',[UserPlanController::class,'update']);
Route::get('user-plan/delete/{id}',[UserPlanController::class,'delete']);

//SpPlans
Route::get('/sp-plans',[SpPlanController::class,'index']);
Route::get('/sp-plan/create',[SpPlanController::class,'create']);
Route::post('/sp-plan/create',[SpPlanController::class,'store'])->name('create-sp-plan');
Route::get('sp-plan/{id}',[SpPlanController::class,'edit']);
Route::post('sp-plan/update',[SpPlanController::class,'update']);
Route::get('sp-plan/delete/{id}',[SpPlanController::class,'delete']);


//Role
Route::get('/roles',[RoleController::class,'index']);
Route::get('role/create',[RoleController::class,'create']);
Route::post('role/create',[RoleController::class,'store'])->name('create-role');
Route::get('role/{id}',[RoleController::class,'edit']);
Route::post('role/update',[RoleController::class,'update']);
Route::post('/role/delete/{id}', [RoleController::class,'delete']);

//Permission

Route::get('/permissions', [PermissionController::class,'index']);
Route::get('/permission/create', [PermissionController::class,'create']);
Route::post('/permission/create', [PermissionController::class,'store'])->name('create-permission');

// Route::post('/permission/update', [PermissionController::class,'update']);
Route::post('/permission/delete/{id}', [PermissionController::class,'delete']);

Route::get('/profile',[ProfileController::class,'create']);
Route::post('edit-profile',[ProfileController::class,'edit_profile'])->name('edit-profile');

});

require __DIR__.'/auth.php';
