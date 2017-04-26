<?php

namespace App\Http\Controllers;

use App\_Class;
use App\Course;
use App\Professor;
use App\Section;
use App\StudentOutcome;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class CourseController extends Controller
{
    private $nav = 'navManageCourses';

    //<editor-fold desc="Construct">
    function __construct()
    {
        $this->middleware('admin');

        View::share('nav', $this->nav);
    }
    //</editor-fold>

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::all();
        return view('admin.menu.manageCourses', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $professors = Professor::all();
        $outcomes = StudentOutcome::all();
        $sections = Section::all();

        return view('admin.create.createCourse', compact('professors', 'outcomes', 'sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $course = new Course();
//        dd($request->input('Terms', 2));

        $course->Code = $request->input('Code');
        $course->Title = $request->input('Title');
        $course->Units = $request->input('Units');
        $course->Description = $request->input('Description');
        $course->Terms = $request->input('Terms', 2) - 1;

        $course->save();

        $course->professors()->sync($request->input('professorsList', []));

        $course->outcomes()->sync($request->input('outcomesList', []));

        return redirect('/courses/' . $course->Course_Id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = Course::find($id);
        $professors = $course->professors()->get();

        return view('admin.show.showCourse', compact('course', 'professors'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $course = Course::find($id)->load('outcomes')->load('professors');
        $outcomes = StudentOutcome::all();
        $professors = Professor::all();

        return view('admin.edit.editCourse', compact('course', 'outcomes', 'professors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $course = Course::find($id);
        $course->Code = $request->input('Code', '');
        $course->Title = $request->input('Title', '');
        $course->Units = $request->input('Units', 0);
        $course->Description = $request->input('Description', '');
        $course->update();

        $course->outcomes()->sync($request->input('outcomesList', []));
        $course->professors()->sync($request->input('professorsList', []));

        return redirect('/courses/' . $course->Course_Id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course = Course::find($id);
        $course->delete();

        return back();
    }

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

    public function getDetails(Course $course){
        $course = $course->load('professors');
        $professors = Professor::all();
        switch ($course->Terms){
            case 2:
                $terms = ['Prelim', 'Final'];
                return view('coursepages.coursedetails', compact('course', 'terms', 'professors'));
            case 3:
                $terms = ['Prelim', 'Midterm', 'Final'];
                return view('coursepages.coursedetails', compact('course', 'terms', 'professors'));
            case 4:
                $terms = ['Prelim', 'Midterm', 'Pre-final', 'Final'];
                return view('coursepages.coursedetails', compact('course', 'terms', 'professors'));
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

        return back()->with('id', $course->Course_Id);
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

    public function tagProfessor(Course $course, Request $request) {
        $course->professors()->sync($request->input('professorList', []));
        return back();
    }

    public function deleteRequirement(){

    }

    private function createLog($action, $description = ""){
        $log = new AuditLog();

        $log->Account_Id = Auth::user()->id;
        $log->Action = $action;
        $log->Description = $description;

        $log->save();
    }
}
