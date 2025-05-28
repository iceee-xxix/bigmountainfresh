<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TimestampController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\WorkhistoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AddholidayController;
use App\Http\Controllers\ManageusersController;
use App\Http\Controllers\ManageadminController;
use App\Http\Controllers\WorktimerecordingController;
use App\Http\Controllers\AdminUserHistory;
use App\Http\Controllers\ManagetimeworkController;
use App\Http\Controllers\WorknotecheckController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\SubOrganizationController;
use App\Http\Controllers\OrganizationUsersController;
use App\Http\Controllers\WorkReportController;
use App\Http\Controllers\Org_AdminReportController;
use App\Http\Controllers\workleaveController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Test2Controller;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


//Auth login-logout
// Route::get('/', function(){
//     return Auth::user()->name ?? 'no login';
// });

Route::get('/', [AuthController::class, 'signin'])->name('user.signin');
Route::post('user/signin', [AuthController::class, 'signinCallback'])->name('user.signinCallback');
Route::get('user/signout', [AuthController::class, 'signout'])->name('user.signout');
Route::get('user/signout', [AuthController::class, 'signoutCallback'])->name('user.signoutCallback');

//user index
// Route::prefix('user/index')->group(function () {
//     Route::get('', [App\Http\Controllers\UserController::class, 'userIndex'])->name('userIndex');
// });

Route::prefix('user/index')->middleware('checkAdmin')->group(function () {
    Route::get('', [App\Http\Controllers\UserController::class, 'userIndex'])->name('userIndex');
});

//user information
Route::prefix('user/information')->group(function () {
    Route::get('', [App\Http\Controllers\InformationController::class, 'userInformation'])->name('userInformation');
});

//user timestamp
Route::prefix('user/timestamp')->group(function () {
    Route::get('', [App\Http\Controllers\TimestampController::class, 'userTimestampIndex'])->name('userTimestampIndex');
    Route::post('/insert', [App\Http\Controllers\TimestampController::class, 'insert'])->name('insert');
});

//user holiday
Route::prefix('user/holiday')->group(function () {
    Route::get('', [App\Http\Controllers\HolidayController::class, 'userHoliday'])->name('userHoliday');
});

//user work_history
Route::prefix('user/workhistory')->group(function () {
    Route::get('', [App\Http\Controllers\WorkhistoryController::class, 'userWorkhistory'])->name('userWorkhistory');
});

//admin dashbord
Route::prefix('/admin')->group(function () {
    Route::get('/', [App\Http\Controllers\AdminController::class, 'adminIndex'])->name('adminIndex');
});

//admin dashbord addholiday
Route::prefix('/admin/holiday')->group(function () {
    Route::get('/', [App\Http\Controllers\AddholidayController::class, 'addholidayIndex'])->name('addholidayIndex');
    Route::post('/create', [App\Http\Controllers\AddholidayController::class, 'holidayCreate'])->name('holidayCreate');
    Route::put('/edit/{id}', [App\Http\Controllers\AddholidayController::class, 'holidayUpdate'])->name('holidayUpdate');
    Route::delete('/delete/{id}', [App\Http\Controllers\AddholidayController::class, 'deleteHoliday'])->name('deleteHoliday');
    Route::get('/api_update', [App\Http\Controllers\AddholidayController::class, 'api_holiday_update'])->name('api_holiday_update');
});

//admin dashbord manageusers
Route::prefix('/admin/manageadmin')->group(function () {
    Route::get('/', [App\Http\Controllers\ManageadminController::class, 'manageadminIndex'])->name('manageadminIndex');
    Route::put('edit/{id}', [App\Http\Controllers\ManageadminController::class, 'manageadminUpdate'])->name('manageadminUpdate');
});

Route::prefix('/admin/manageuser')->group(function () {
    Route::get('/', [App\Http\Controllers\ManageusersController::class, 'manageuserIndex'])->name('manageuserIndex');
    Route::put('edit/{id}', [App\Http\Controllers\ManageusersController::class, 'manageuserEdit'])->name('manageuserEdit');
    Route::delete('/delete/{id}', [App\Http\Controllers\ManageusersController::class, 'manageuserDelete'])->name('manageuserDelete');
    Route::get('/manageuser/select', [App\Http\Controllers\ManageusersController::class, 'manageuserSelect'])->name('manageuserSelect');
});

//admin dashbord worktimerecording
Route::prefix('/admin/worktimerecording')->group(function () {
    Route::get('/', [App\Http\Controllers\WorktimerecordingController::class, 'worktimerecordingIndex'])->name('worktimerecordingIndex');
    Route::get('/user_history/{id}', [AdminUserHistory::class, 'admin_user_work_history'])->name('admin_user_work_history');
});

Route::prefix('/admin/managetime')->group(function () {
    Route::get('/', [App\Http\Controllers\ManagetimeworkController::class, 'managetimeIndex'])->name('managetimeIndex');
    Route::post('/create', [App\Http\Controllers\ManagetimeworkController::class, 'managetimeCreate'])->name('managetimeCreate');
    Route::put('/update/{id}', [App\Http\Controllers\ManagetimeworkController::class, 'managetimeUpdate'])->name('managetimeUpdate');
    Route::delete('/delete/{id}', [App\Http\Controllers\ManagetimeworkController::class, 'managetimeDelete'])->name('managetimeDelete');
});

Route::prefix('/admin/organization')->group(function () {
    Route::get('/', [App\Http\Controllers\OrganizationController::class, 'OrganizationIndex'])->name('OrganizationIndex');
    Route::post('/create', [App\Http\Controllers\OrganizationController::class, 'CreateOrganization'])->name('CreateOrganization');
    Route::put('/edit/{id}', [App\Http\Controllers\OrganizationController::class, 'EditOrganization'])->name('EditOrganization');
    Route::delete('/delete/{id}', [App\Http\Controllers\OrganizationController::class, 'DeleteOrganization'])->name('DeleteOrganization');
});

Route::prefix('/admin/sub_organization')->group(function () {
    Route::get('/', [App\Http\Controllers\SubOrganizationController::class, 'SubOrganizationIndex'])->name('SubOrganizationIndex');
    Route::post('/create', [App\Http\Controllers\SubOrganizationController::class, 'CreateSubOrganization'])->name('CreateSubOrganization');
    Route::put('/edit/{id}', [App\Http\Controllers\SubOrganizationController::class, 'EditSubOrganization'])->name('EditSubOrganization');
    Route::get('/sub_organization_select', [App\Http\Controllers\SubOrganizationController::class, 'SubOrganization_Select'])->name('SubOrganization_Select');
    Route::post('/sub_organization_select/create', [App\Http\Controllers\SubOrganizationController::class, 'CreateSelectSubOrganization'])->name('CreateSelectSubOrganization');
    Route::put('/sub_organization_select/edit/{id}', [App\Http\Controllers\SubOrganizationController::class, 'EditSelectSubOrganization'])->name('EditSelectSubOrganization');
});

Route::prefix('/admin/workReport')->group(function () {
    Route::get('/', [App\Http\Controllers\WorkReportController::class, 'reportIndex'])->name('reportIndex');
    Route::post('/workReport/reportSelectPDF', [WorkReportController::class, 'reportSelectPDF'])->name('reportSelectPDF');
});

Route::prefix('/organization_admin/workReport')->group(function () {
    Route::get('/', [App\Http\Controllers\Org_AdminReportController::class, 'Org_reportIndex'])->name('Org_reportIndex');
    Route::post('organization_admin/workReport/Org_reportSelectPDF', [Org_AdminReportController::class, 'Org_reportSelectPDF'])->name('Org_reportSelectPDF');
});

Route::prefix('/admin/work_leave')->group(function () {
    Route::get('/', [workleaveController::class, 'work_leave_index'])->name('work_leave_index');
    Route::post('/submit', [workleaveController::class, 'work_leave_submit'])->name('work_leave_submit');
    Route::post('/edit/{id}', [workleaveController::class, 'work_leave_edit'])->name('work_leave_edit');
    Route::post('/delete/{id}', [workleaveController::class, 'work_leave_delete'])->name('work_leave_delete');
});

//test1
Route::get('/test_report', [App\Http\Controllers\TestController::class, 'test_report'])->name('test_report');
Route::get('/test_report_organization_select', [App\Http\Controllers\TestController::class, 'test_report_select'])->name('test_report_select');
Route::post('/generatePDF', [TestController::class, 'generatePDF'])->name('generatePDF');

//test2
Route::get('/test', [App\Http\Controllers\Test2Controller::class, 'test'])->name('test');
Route::post('/test/location', [Test2Controller::class, 'location_test'])->name('location_test');

Route::get('/test_history', [App\Http\Controllers\Test2Controller::class, 'test_report_history'])->name('test_report_history');

Route::get('/api/holiday_api', [ApiController::class, 'fetchData']);














