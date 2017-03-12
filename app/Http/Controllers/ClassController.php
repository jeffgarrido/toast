<?php

namespace App\Http\Controllers;

use App\_Class;
use App\Course;
use App\Professor;
use App\Section;
use App\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class ClassController extends Controller
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
        $classes = _Class::all();

        return view('admin.menu.manageClasses', compact('classes'));
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
        $students = Student::all();

        return view('admin.create.createClass', compact('courses', 'professors', 'sections', 'students'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $class = new _Class();

        $class->Course_Id = $request->input('course');
        $class->Professor_Id = $request->input('professor');
        $class->Section_Id = $request->input('section');
        $class->save();

        $class->students()->sync($request->input('studentsList', []));

        return redirect('/class/' . $class->Course_Id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function show($id)
    {
        $class = _Class::find($id);
        $section = $class->section;
        $students = $class->students()->get();
        $course = $class->baseClass->course;
        $professor = $class->baseClass->professor;

        return view('admin.show.showClass', compact('class', 'students', 'professor', 'section', 'course'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $class = _Class::find($id)->load('students');
        $course = $class->baseClass->course;
        $professor = $class->baseClass->professor;
        $section = $class->section()->first();
        $students = Student::all();

        return view('admin.edit.editClass', compact('class', 'course', 'professor', 'students', 'section'));
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
        $class = _Class::find($id);

        $class->students()->sync($request->input('studentList', []));

        return redirect('/class/' . $class->Class_Id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        _Class::find($id)->delete();

        return redirect('/classes');
    }
}
