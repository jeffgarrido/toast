<?php

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

Route::group(['middleware' => ['web']], function(){

    //<editor-fold desc="<!-- AdminController Routes -->">
    Route::get('/admin', 'AdminController@adminRedirect'); //tmp

    Route::get('/managestudents', 'AdminController@showManageStudents');

    Route::get('/manageaccounts', 'AdminController@showManageAccounts');

    Route::get('/organization/manage_members/{organization}', 'AdminController@manageOrgMembers');

    Route::post('populate_members/{organization}', 'AdminController@populateMemberList');
    //</editor-fold> -->

    //<editor-fold desc="<!-- Authentication Routes -->">
    Auth::routes();
    //</editor-fold>

    //<editor-fold desc="<!-- BaseClassController Routes -->">
    Route::resource('classes', 'BaseClassController');
    //</editor-fold>

    //<editor-fold desc="<!-- ClassController Routes -->">
    Route::resource('class', 'ClassController');
    //</editor-fold>

    //<editor-fold desc="<!-- CourseController Routes -->">
    Route::resource('courses', 'CourseController');
    //</editor-fold>

    //<editor-fold desc="EventController Routes">
    Route::resource('events', 'EventController', ['except' => ['create']]);
    //</editor-fold>

    //<editor-fold desc="<!-- HomeController Routes -->">
    Route::get('/', 'HomeController@index');

    Route::get('/home', 'HomeController@index');

    Route::get('/dashboard', 'HomeController@index');
    //</editor-fold>

    //<editor-fold desc="<!-- OrganizationController Routes for Student-->">
    Route::resource('organizations', 'OrganizationController', ['except' => ['create']]);

    Route::get('organizations/add_member/{organization}', 'OrganizationController@studentList');

    Route::post('populate_members/{organization}', 'OrganizationController@populateMemberList');
    //</editor-fold>

    //<editor-fold desc="<!-- OrganizationController Routes for Admin-->">
    Route::resource('organizations_admin', 'AdminOrgController', ['except' => ['create']]);

    Route::get('organizations_admin/{organization}/home', 'AdminOrgController@showOrganization');

    Route::get('add_member/{organization}', 'AdminOrgController@studentList');

    Route::post('populate_members/{organization}', 'AdminOrgController@populateMemberList');

    Route::post('add_org', 'AdminOrgController@addOrg');
    //</editor-fold>

    //<editor-fold desc="<!-- ProfessorController Routes -->">
    Route::resource('professors', 'ProfessorController', ['except' => ['create']]);
    //</editor-fold>

    //<editor-fold desc="<!-- RequirementController Routes -->">

    Route::get('/requirements/{class}/list', 'RequirementController@index');

    Route::get('/requirements/{class}/create', 'RequirementController@create');
    Route::post('/requirements/{class}', 'RequirementController@store');
    //</editor-fold>

    //<editor-fold desc="<!-- SectionController Routes -->">
    Route::resource('sections', 'SectionController');
    //</editor-fold>

    //<editor-fold desc="<!-- StudentController Routes -->">
    Route::resource('students', 'StudentController', ['except' => ['create']]);
    //</editor-fold>

    //<editor-fold desc="<!-- UserContoller Routes -->">
    Route::resource('users', 'UserController', ['except' => ['create']]);
    Route::get('/users/{user}/resetpassword', 'UserController@resetPass');
    Route::post('/users/{user}/reset', 'UserController@reset');
    //</editor-fold>

    //<editor-fold desc="<!-- EventController Routes -->">
    Route::resource('events', 'EventController', ['except' => ['create']]);

    Route::post('events/{event}','EventController@updateEvent');
    //</editor-fold>

    Route::get('course_details/{course}', 'CourseController@getDetails');

    Route::post('add_course', 'CourseController@addCourse');

    Route::put('edit_course/{course}', 'CourseController@editCourse');

    Route::get('delete_course/{course}', 'CourseController@deleteCourse');

    Route::post('add_requirement/{course}', 'CourseController@addRequirement');

    Route::put('edit_requirement/{requirement}', 'CourseController@editRequirement');

    Route::post('delete_requiremenet/{requirement}', 'CourseController@deleteRequirement');

    //Route::get('professor', 'ProfessorController@showDashboard');

    Route::get('admin', 'AdminController@adminRedirect');

//    Route::get('students', 'AdminController@showStudentPage');

//    Route::get('sections', 'AdminController@showSectionsPage');

    Route::post('add_section', 'AdminController@addSection');

    Route::post('admin_add_course', 'AdminController@addCourse');

    Route::get('admincourses', 'AdminController@showCourses');

    Route::get('organization', 'OrganizationController@showOrganization');

    Route::get('org_details/{organization}', 'OrganizationController@getOrgDetails');

    Route::get('prof_list', 'AdminController@getProfList');

    Route::get('get_prof_subj', 'AdminController@getProfSubj');

    Route::post('add_org', 'OrganizationController@addOrg');

    Route::get('attendance_list/{event}', 'OrganizationController@getAttendanceList');

    Route::get('/guest_list/{event}', 'EventController@eventGuest');

    Route::post('populate_list/{event}', 'EventController@populateGuestList');

    Route::get('download_attendance/{event}', 'OrganizationController@downloadAttendanceList');

    Route::post('add_student', 'AdminController@addStudent');

    Route::get('delete_student/{student}', 'AdminController@deleteStudent');

    Route::get('delete_professor/{professor}', 'AdminController@');

    Route::get('edit_student/{student}', 'AdminController@editStudent');

    Route::post('edit_complete/{student}', 'AdminController@saveEditStudent');

    Route::get('log_attendance/event={event}&token={studentToken}', 'EventController@logAttendance');

    //Route::get('/professor', 'AdminController@showProfessorPage');

    //Route::post('add_professor', 'AdminController@addProfessor');

    Route::post('tag_professor/{course}', 'CourseController@tagProfessor');


    //<editor-fold desc="<!-- Student Pages -->">
    Route::get('my_organization', 'StudentController@showOrganization');
    Route::get('my_organization/{organization}', 'StudentController@showOrganization');
    //</editor-fold>

});

//<editor-fold desc="<!-- Mobile Routes -->">
Route::post('mlogin', 'MobileController@login');

Route::group(['prefix' => 'toast_api', 'middleware' => 'auth:api'], function() {
    Route::get('fetch_events', 'MobileController@getEvents');

    Route::get('fetch_organizations', 'MobileController@getOrganizations');

    Route::post('log_attendance/event={event}&token={studentToken}', 'MobileController@logAttendance');
});
//</editor-fold>