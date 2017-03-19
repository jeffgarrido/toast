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
        $section = $class->section;
        $students = $class->students()->get()->sortBy('LastName');
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

        foreach ($class->baseClass->requirements()->get() as $requirement) {
            $requirement->students()->detach();
        }

        $baseClass = $class->baseClass;

        $class->delete();

        return redirect('/classes/' . $baseClass->BaseClass_Id);
    }

    public function updateScores(Request $request, _Class $class) {
        foreach ($request->input('Score', []) as $item) {
            $score = Score::find($item);
            $score->Score = $request->input($item, 0);
            $score->update();
        }

        $students = $class->students()->get();
        foreach ($students as $student) {
            $grade = $student->pivot;
            $grade->PrelimGrade = 0;
            $grade->FinalGrade = 0;
            $grade->SemestralGrade = 0;
            foreach ($student->requirements()->get() as $requirement) {
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
                    if ($evalScore < 40) {
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

        foreach ($students as $student) {
            foreach ($student->studentOutcomes()->get()->load('performanceIndicators') as $outcome) {
                $outcome->pivot->Evaluation = 0;
                $outcome->pivot->P1 = 0;
                $outcome->pivot->P2 = 0;
                $outcome->pivot->P3 = 0;
                $outcome->pivot->EventEval = 0;
                $p1ctr = 0;
                $p2ctr = 0;
                $p3ctr = 0;
                $eventCtr = 0;

                foreach ($student->SOEvaluations()->get() as $soEval) {
                    $index = $outcome->performanceIndicators->search($soEval->performanceIndicator);
                    switch ($index) {
                        case 0:
                            $outcome->pivot->P1 += $soEval->pivot->Evaluation;
                            $p1ctr++;
                            break;
                        case 1:
                            $outcome->pivot->P2 += $soEval->pivot->Evaluation;
                            $p2ctr++;
                            break;
                        case 2:
                            $outcome->pivot->P3 += $soEval->pivot->Evaluation;
                            $p3ctr++;
                            break;
                    }
                }

                $outcome->pivot->P1 = round($outcome->pivot->P1 / (($p1ctr == 0)? 1: $p1ctr), 2);
                $outcome->pivot->P2 = round($outcome->pivot->P2 / (($p2ctr == 0)? 1: $p2ctr), 2);
                $outcome->pivot->P3 = round($outcome->pivot->P3 / (($p3ctr == 0)? 1: $p3ctr), 2);

                foreach ($student->events()->where('event_student.Attendance', '<>', 0)->get() as $studentEvent) {
                    if($studentEvent->studentOutcomes()->get()->contains($outcome)) {
                        $eventCtr++;
                    }
                }
                $eventScore = $eventCtr / (($outcome->Event_Minimum == 0)? 1: $outcome->Event_Minimum) * 100;
                if($eventScore < 40) {
                    $outcome->pivot->EventEval = 1;
                } elseif ($eventScore < 60) {
                    $outcome->pivot->EventEval = 2;
                }elseif ($eventScore < 80) {
                    $outcome->pivot->EventEval = 3;
                }else {
                    $outcome->pivot->EventEval = 4;
                }

                $outcome->pivot->Evaluation = round(($outcome->pivot->P1 + $outcome->pivot->P2 + $outcome->pivot->P3 + $outcome->pivot->EventEval) /4, 2);

                $outcome->pivot->update();
            }
        }

        return redirect('/class/'. $class->Class_Id);
    }
}
