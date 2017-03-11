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

        return redirect('/classes/' . $class->Course_Id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $class = _Class::find($id);
        $students = $class->students()->get();
        $professor = $class->professor;

        return view('admin.show.showClass', compact('class', 'students', 'professor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $class = _Class::find($id);
        $class->load('students');
        $courses = Course::all();
        $professors = Professor::all();
        $students = Student::all();
        $sections = Section::all();

        return view('admin.edit.editClass', compact('class', 'courses', 'professors', 'students', 'sections'));
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
        $class->Course_Id = $request->input('course');
        $class->Professor_Id = $request->input('professor');
        $class->Section = $request->input('section');
        $class->update();

        $class->students()->sync($request->input('studentList', []));

        return redirect('/classes/' . $class->Class_Id);
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
