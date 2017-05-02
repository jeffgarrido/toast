<?php

namespace App\Http\Controllers;

use App\_Class;
use App\BaseClass;
use App\Course;
use App\Professor;
use App\Section;
use App\SOEvaluation;
use App\Student;
use App\StudentOutcome;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class BaseClassController extends Controller
{
    private $nav = 'navManageClasses';

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
        $baseClasses = BaseClass::all();
        return view('admin.menu.manageBaseClasses', compact('baseClasses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = Course::all();
        $professors = Professor::all();
        $sections = Section::all();
        return view('admin.create.createBaseClass', compact('courses', 'professors', 'sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $baseClass = new BaseClass();

        $baseClass->Course_Id = $request->input('CoursesList');
        $baseClass->Professor_Id = $request->input('ProfessorsList');
        $baseClass->save();

        $syncData = $baseClass->classes()->sync($request->input('sectionsList', []));

        foreach ($syncData['attached'] as $sectionId) {
            $students = Section::find($sectionId)->students()->where('AcademicStatus' , '=', 'Regular')->get();
            $class = _Class::find($baseClass->classes()->where('sections.Section_Id', '=', $sectionId)->first()->pivot->Class_Id);
            $class->students()->sync($students);
            foreach($class->baseClass->course->requirements()->get() as $requirement){
                $requirement->students()->attach($class->students()->get());
                foreach ($requirement->outcomes()->get() as $outcome){
                    $eval = SOEvaluation::find($outcome->pivot->SOEval_Id);
                    $eval->students()->attach($class->students()->get());
                }
            }
        }

        $classes = $baseClass->classes()->get();

        return view('admin.show.showBaseClass', compact('baseClass','classes'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $baseClass = BaseClass::find($id);
        $classes = $baseClass->classes()->get()->load('Students');

        return view('admin.show.showBaseClass', compact('baseClass', 'classes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $baseClass = BaseClass::find($id)->load('classes');
        $sections = Section::all();

        return view('admin.edit.editBaseClass', compact('baseClass', 'sections'));
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
        $baseClass = BaseClass::find($id);

        $sections = $baseClass->classes()->whereNotIn('sections.Section_Id', $request->input('sectionsList', []))->get();

        if($sections->count()) {
            foreach ($sections as $section) {
                $class = _Class::find($section->pivot->Class_Id);
                $class->students()->detach();
                foreach($class->baseClass->course->requirements()->get() as $requirement){
                    $requirement->students()->detach();
                    foreach ($requirement->outcomes()->get() as $outcome){
                        $eval = SOEvaluation::find($outcome->pivot->SOEval_Id);
                        $eval->students()->detach();
                    }
                }
            }
        }

        $syncData = $baseClass->classes()->sync($request->input('sectionsList', []));

        foreach ($syncData['attached'] as $sectionId) {
            $students = Section::find($sectionId)->students()->where('AcademicStatus' , '=', 'Regular')->get();
            $class = _Class::find($baseClass->classes()->where('sections.Section_Id', '=', $sectionId)->first()->pivot->Class_Id);
            $class->students()->sync($students);
            foreach($class->baseClass->course->requirements()->get() as $requirement){
                $requirement->students()->attach($class->students()->get());
                foreach ($requirement->outcomes()->get() as $outcome){
                    $eval = SOEvaluation::find($outcome->pivot->SOEval_Id);
                    $eval->students()->attach($class->students()->get());
                }
            }
        }

        return redirect('/classes/' . $baseClass->BaseClass_Id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $baseClass = BaseClass::find($id);
        $baseClass->delete();

        return redirect('/classes');
    }
}
