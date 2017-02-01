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

Route::get('/', function () {
    return view('layouts.master');
});

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

Route::get('log_attendance', function(){
   dd('Hello world');
});