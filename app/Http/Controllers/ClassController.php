<?php

namespace App\Http\Controllers;

use App\_Class;
use App\BaseClass;
use App\Course;
use App\Professor;
use App\Score;
use App\Section;
use App\SOEvaluation;
use App\Student;
use App\StudentOutcome;
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

        $studentIds = $class->students()->sync($request->input('studentsList', []));

        foreach ($studentIds['attached'] as $studentId) {
            $student = Student::find($studentId);
            $student->requirements()->attach($class->baseClass->requirements()->get());
        }

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
        $outcomes = $class->baseClass->course()->first()->outcomes()->get();
        $section = $class->section;
        $students = $class->students()->with(array(
            'requirements' => function ($query) use ($class) {
                $query->where('course_requirements.BaseClass_Id', '=', $class->BaseClass_Id);
            },
        ))->get()->sortBy('LastName');
        $course = $class->baseClass->course;
        $professor = $class->baseClass->professor;

        return view('admin.show.showClass', compact('class', 'students', 'professor', 'section', 'course', 'outcomes'));
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
        $students = Student::all()->sortBy('LastName');

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

//        dd($class->baseClass->requirements()->get()->load('students'));

//        foreach ($class->baseClass->requirements()->get() as $requirement) {
//
//        }
        $detachedStudents = $class->students()->whereNotIn('students.Student_Id', $request->input('studentList', []))->get();

        if($detachedStudents->count()){
            foreach ($class->baseClass->requirements()->get() as $requirement) {
                $requirement->students()->detach($detachedStudents);
                foreach ($requirement->outcomes()->get() as $outcome){
                    $eval = SOEvaluation::find($outcome->pivot->SOEval_Id);
                    $eval->students()->detach();
                }
            }
        }

        $studentIds = $class->students()->sync($request->input('studentList', []));
        foreach ($studentIds['attached'] as $studentId) {
            $student = Student::find($studentId);
            $student->requirements()->attach($class->baseClass->requirements()->get());
            foreach ($class->baseClass->requirements()->get() as $requirement){
                foreach ($requirement->outcomes()->get() as $outcome) {
                    $eval = SOEvaluation::find($outcome->pivot->SOEval_Id);
                    $eval->students()->attach($class->students()->get());
                }
            }
        }

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
        $class = _Class::find($id);

        foreach ($class->students()->get() as $student) {
            $student->requirements()->detach($class->baseClass-> requirements()->get());
        }

        $class->students()->detach();

        $baseClass = $class->baseClass;

        $class->delete();

        return redirect('/classes/' . $baseClass->BaseClass_Id);
    }

    public function updateScores(Request $request, _Class $class)
    {
        foreach ($request->input('Score', []) as $item) {
            $score = Score::find($item);
            $score->Score = $request->input($item, 0);
            $score->update();
        }

        $students = $class->students()->with(array(
            'requirements' => function ($query) use ($class) {
                $query->where('course_requirements.BaseClass_Id', '=', $class->BaseClass_Id);
            },
        ))->get();

        foreach ($students as $student) {
            $grade = $student->pivot;
            $grade->PrelimGrade = 0;
            $grade->FinalGrade = 0;
            $grade->SemestralGrade = 0;
            foreach ($student->requirements as $requirement) {
                if ($requirement->Term == 1) {
                    $grade->PrelimGrade += round(($requirement->pivot->Score / (($requirement->HPS > 0)? $requirement->HPS : 1))  * $requirement->Weight, 2);
                } elseif ($requirement->Term == 2) {
                    $grade->FinalGrade += round(($requirement->pivot->Score / (($requirement->HPS > 0)? $requirement->HPS : 1))  * $requirement->Weight, 2);
                }
                $grade->SemestralGrade = round($grade->PrelimGrade * 0.5 + $grade->FinalGrade * 0.5, 2);

                foreach ($requirement->outcomes()->get() as $outcome){
                    $eval = SOEvaluation::find($outcome->pivot->SOEval_Id);
                    $evalPivot = $eval->students()->find($student->Student_Id)->pivot;
                    $evalScore = $requirement->pivot->Score / (($requirement->HPS > 0)? $requirement->HPS : 1) * 100 ;
                    if ($evalScore <= 0) {
                        $evalPivot->Evaluation = 0;
                    } elseif ($evalScore < 40) {
                        $evalPivot->Evaluation = 1;
                    } elseif ($evalScore < 60) {
                        $evalPivot->Evaluation = 2;
                    } elseif ($evalScore < 80) {
                        $evalPivot->Evaluation = 3;
                    } else {
                        $evalPivot->Evaluation = 4;
                    }
                    $evalPivot->update();

                }
            }

            $semGrade = $grade->SemestralGrade;
            if ($semGrade < 60) {
                $grade->TransmutedGrade = 5.00;
            }elseif ($semGrade >= 93) {
                $grade->TransmutedGrade = 1.00;
            } elseif ($semGrade >= 90) {
                $grade->TransmutedGrade = 1.25;
            } elseif ($semGrade >= 87) {
                $grade->TransmutedGrade = 1.50;
            } elseif ($semGrade >= 82) {
                $grade->TransmutedGrade = 1.75;
            } elseif ($semGrade >= 79) {
                $grade->TransmutedGrade = 2.00;
            } elseif ($semGrade >= 74) {
                $grade->TransmutedGrade = 2.25;
            } elseif ($semGrade >= 71) {
                $grade->TransmutedGrade = 2.50;
            } elseif ($semGrade >= 66) {
                $grade->TransmutedGrade = 2.75;
            } elseif ($semGrade >= 60) {
                $grade->TransmutedGrade = 3.00;
            }

            $grade->update();
        }

        return redirect('/class/'. $class->Class_Id);
    }
}
