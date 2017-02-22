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

//Route::get('/', function () {
////    return redirect('organization');
//    return view('layouts.master');
//});

Route::group(['middleware' => ['web']], function(){



Route::get('/', 'HomeController@index');

Route::get('courses', 'CourseController@showCourses');

Route::get('course_details/{course}', 'CourseController@getDetails');

Route::post('add_course', 'CourseController@addCourse');

Route::put('edit_course/{course}', 'CourseController@editCourse');

Route::get('delete_course/{course}', 'CourseController@deleteCourse');

Route::post('add_requirement/{course}', 'CourseController@addRequirement');

Route::put('edit_requirement/{requirement}', 'CourseController@editRequirement');

Route::post('delete_requiremenet/{requirement}', 'CourseController@deleteRequirement');

Route::get('professor', 'ProfessorController@showDashboard');

Route::get('admin', 'AdminController@adminRedirect');

Route::get('students', 'AdminController@showStudentPage');

Route::get('sections', 'AdminController@showSectionsPage');

Route::get('organization', 'OrganizationController@showOrganization');

Route::get('org_details/{organization}', 'OrganizationController@getOrgDetails');

Route::post('add_org', 'OrganizationController@addOrg');

Route::get('attendance_list/{event}', 'OrganizationController@getAttendanceList');

Route::get('guest_list/{event}', 'EventController@eventGuest');

Route::post('populate_list/{event}', 'EventController@populateGuestList');

Route::get('download_attendance/{event}', 'OrganizationController@downloadAttendanceList');

Route::post('add_student', 'AdminController@addStudent');

Route::get('delete_student/{student}', 'AdminController@deleteStudent');

Route::get('edit_student/{student}', 'AdminController@editStudent');

Route::post('edit_complete/{student}', 'AdminController@saveEditStudent');

Auth::routes();

Route::get('log_attendance/event={event}&token={studentToken}', 'EventController@logAttendance');

Route::get('/home', 'HomeController@index');

Route::get('/professor', 'AdminController@showProfessorPage');

Route::post('add_professor', 'AdminController@addProfessor');

});

//Mobile Routes
Route::get('login/{email}/{password}', 'MobileController@login');

Route::get('fetch_events', 'MobileController@getEvents');

Route::get('log_attendance/event={event}&token={studentToken}', 'MobileController@logAttendance');
