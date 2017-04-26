<?php

namespace App\Http\Controllers;

use App\_Class;
use App\BaseClass;
use App\CILO;
use App\Course;
use App\CourseRequirement;
use App\Professor;
use App\Score;
use App\SOEvaluation;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $section = $class->section;
        $students = $class->students()->with(array(
            'requirements' => function ($query) use ($class) {
                $query->where('course_requirements.Course_Id', '=', $class->baseClass->Course_Id);
            },
        ))->get()->sortBy('LastName');
        $course = $class->baseClass->course;
        $professor = $class->baseClass->professor;

        return view('professor.show.viewclass', compact('class', 'students', 'professor', 'section', 'course'));
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
        $section = $class->section;
        $students = $class->students()->with(array(
            'requirements' => function ($query) use ($class) {
                $query->where('course_requirements.BaseClass_Id', '=', $class->BaseClass_Id);
            },
        ))->get()->sortBy('LastName');
        $course = $class->baseClass->course;
        $professor = $class->baseClass->professor;

        return view('professor.show.viewclass', compact('class', 'students', 'professor', 'section', 'course'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateScores(Request $request, _Class $class)
    {
        foreach ($request->input('Score', []) as $item) {
            $score = Score::find($item);
            $score->Score = $request->input($item, 0);
            $score->update();
        }

        $students = $class->students()->with(array(
            'requirements' => function ($query) use ($class) {
                $query->where('course_requirements.Course_Id', '=', $class->baseClass->Course_Id);
            },
        ))->get();

        foreach ($students as $student) {
            $grade = $student->pivot;
            $grade->PrelimGrade = 0;
            $grade->FinalGrade = 0;
            $grade->SemestralGrade = 0;
            foreach ($student->requirements as $requirement) {
                if($requirement->pivot->Score < 0) {
                    continue;
                } elseif ($requirement->Term == 1 ) {
                    $grade->PrelimGrade += round(($requirement->pivot->Score / (($requirement->HPS > 0)? $requirement->HPS : 1))  * $requirement->Weight, 2);
                } elseif ($requirement->Term == 2) {
                    $grade->FinalGrade += round(($requirement->pivot->Score / (($requirement->HPS > 0)? $requirement->HPS : 1))  * $requirement->Weight, 2);
                }
                $grade->SemestralGrade = round($grade->PrelimGrade * 0.5 + $grade->FinalGrade * 0.5, 2);

                foreach ($requirement->outcomes()->get() as $outcome){
                    $eval = SOEvaluation::find($outcome->pivot->SOEval_Id);
                    $evalPivot = $eval->students()->find($student->Student_Id)->pivot;
                    $evalScore = $requirement->pivot->Score / (($requirement->HPS > 0)? $requirement->HPS : 1) * 100 ;
                    if ($evalScore < 0) {
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

        return redirect('/pclasses/'. $class->Class_Id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function showRequirements($id){
        $baseClass = BaseClass::find($id);

        $course = $baseClass->course;
        $outcomes = $course->outcomes()->get();
        $professor = $baseClass->professor;

        switch ($course->Terms){
            case 2:
                $terms = ['Prelim', 'Final'];
                break;
            case 3:
                $terms = ['Prelim', 'Midterm', 'Final'];
                break;
            case 4:
                $terms = ['Prelim', 'Midterm', 'Pre-final', 'Final'];
                break;
        }

        return view('professor.edit.managerequirements', compact('baseClass', 'course', 'professor', 'terms', 'outcomes'));
    }

    public function updateRequirements(Request $request, CourseRequirement $requirement){

        $requirement->Name = $request->input('Name', '');
        $requirement->HPS = $request->input('HPS', 0);
        $requirement->Weight = $request->input('Weight', 0);
        $requirement->Description = $request->input('Description', '');
        $requirement->update();

        $requirement->outcomes()->sync($request->input('outcomes', []));

        return redirect('/pclasses/edit_requirements/' . $requirement->BaseClass_Id);
    }

    public function addRequirements(Request $request, BaseClass $baseClass){
        $requirement = new CourseRequirement();

        $requirement->Name = $request->input('Name');
        $requirement->HPS = $request->input('HPS', 0);
        $requirement->Weight = $request->input('Weight', 0);
        $requirement->Description = $request->input('Description', '');
        $requirement->Term = $request->input('Term');

        $baseClass->requirements()->save($requirement);
        
        return redirect('/pclasses/edit_requirements/' . $requirement->BaseClass_Id);
    }

    public function addCILO(BaseClass $baseClass,Request $request) {
        $CILO = new CILO();

        $CILO->Code = $request->input('Code');
        $CILO->Description = $request->Description;
        $baseClass->cilos()->save($CILO);

        $CILO->studentOutcomes()->sync($request->input('outcomesList'));

        return back();
    }
}
