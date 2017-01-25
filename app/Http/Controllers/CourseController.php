<?php

namespace App\Http\Controllers;

use App\CourseRequirement;
use Illuminate\Http\Request;
use App\Course;
use App\AuditLog;

class CourseController extends Controller
{
    public function showCourses(){
        $courses = Course::all();
        return view('coursepages.courselist', compact('courses'));
    }

    public function addCourse(Request $request){
        $course = new Course();

        $course->Code = $request->input('Code');
        $course->Title = $request->input('Title');
        $course->Description = $request->input('Description', '');
        $course->Terms = $request->input('Terms', 2);
        $course->save();

        //Create Audit Log
        $this->createLog(
            'Add Course',
            'Code: '.$request->input('Code').                                           '\n'.
            'Title: '.$request->input('Title').                                         '\n'.
            'Description: '.$request->input('Description', 'No Description Provided').  '\n'.
            'Terms: '.$request->input('Terms').                                         '\n'
        );

        return back();
    }

    public function editCourse(Course $course, Request $request){
        //Create Audit Log
        $this->createLog(
            'Edit Course',
            'From:'.                                            '\n'.
            'Code: '.$course->Code.                             '\n'.
            'Title: '.$course->Title.                           '\n'.
            'Description: '.$course->Description.               '\n'.
            'Terms: '.$course->Terms.                           '\n\n'.

            'To:'.                                              '\n'.
            'Code: '.$request->input('Code').                   '\n'.
            'Title: '.$request->input('Title').                 '\n'.
            'Description: '.$request->input('Description', ''). '\n'.
            'Terms: '.$request->input('Terms').                 '\n'
        );

        $course->Code = $request->input('Code');
        $course->Title = $request->input('Title');
        $course->Description = $request->input('Description');
        $course->Terms = $request->input('Terms');
        $course->save();

        return back()->with('id', $course->id);
    }

    public function deleteCourse(Course $course){
        $course->delete();
    }

    public function getDetails(Course $course){
        switch ($course->Terms){
            case 2:
                $terms = ['Prelim', 'Final'];
                return view('coursepages.coursedetails', compact('course', 'terms'));
            case 3:
                $terms = ['Prelim', 'Midterm', 'Final'];
                return view('coursepages.coursedetails', compact('course', 'terms'));
            case 4:
                $terms = ['Prelim', 'Midterm', 'Pre-final', 'Final'];
                return view('coursepages.coursedetails', compact('course', 'terms'));
        }
    }

    public function addRequirement(Course $course, Request $request){
        $requirement = new CourseRequirement();
        $requirement->Term = $request->input('Term');
        $requirement->Type = $request->input('Type');
        $requirement->Description = $request->input('Description');
        $course->requirements()->save($requirement);

        $this->createLog(
            'Add Requirement',
            'Term: '.$request->input('Term').               '\n'.
            'Type: '.$request->input('Type').               '\n'.
            'Description: '.$request->input('Description'). '\n'
        );

        return back()->with('id', $course->id);
    }

    public function editRequirement(CourseRequirement $requirement, Request $request){
        $this->createLog(
            'Edit Requirement',
            'From: '.                                       '\n'.
            'Type: '.$requirement->Type.                    '\n'.
            'Description: '.$requirement->Description.      '\n\n'.

            'To: '.                                         '\n'.
            'Type: '.$request->input('Type').               '\n'.
            'Description: '.$request->input('Description'). '\n'
        );

        $requirement->Type = $request->input('Type');
        $requirement->Description = $request->input('Description');
        $requirement->save();

        return back()->with('id', $request->input('id'));
    }

    public function deleteRequirement(){

    }

    private function createLog($action, $description = ""){
        $log = new AuditLog();

        $log->AccountID = 1;
        $log->Action = $action;
        $log->Description = $description;

        $log->save();
    }
}
