<?php

namespace App\Http\Controllers;

use App\_Class;
use App\BaseClass;
use App\Course;
use App\CourseRequirement;
use App\SOEvaluation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RequirementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Course $course)
    {
        $outcomes = $course->outcomes()->get();

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

        return view('admin.menu.manageRequirements', compact('course', 'terms', 'outcomes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(_Class $class)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Course $course)
    {
        $requirement = new CourseRequirement();

        $requirement->Name = $request->input('Name');
        $requirement->HPS = $request->input('HPS', 0);
        $requirement->Weight = $request->input('Weight', 0);
        $requirement->Description = $request->input('Description', '');
        $requirement->Term = $request->input('Term');

        $course->requirements()->save($requirement);

        $requirement->outcomes()->sync($request->input('outcomes', []));

        $classes = _Class::where('Status', 1)
            ->whereIn('BaseClass_Id', BaseClass::where('Course_Id', $course->Course_Id)->get())
            ->with('students')->get();

        foreach ($classes as $class) {
            $students = $class->students;
            foreach ($students as $student) {
                $student->requirements()->attach($requirement);
                foreach ($requirement->outcomes()->get() as $pi) {
                    $student->SOEvaluations()->attach(SOEvaluation::find($pi->pivot->id));
                }
                foreach ($requirement->outcomes()->get() as $outcome) {
                    $eval = SOEvaluation::find($outcome->pivot->SOEval_Id);
                    $student->SOEvaluations()->attach($eval);
                }
            }
        }

        return redirect('/requirements/' . $course->Course_Id)->with('messsage', 'Requirements Updated');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CourseRequirement $requirement)
    {
        $requirement->Name = $request->input('Name', '');
        $requirement->HPS = $request->input('HPS', 0);
        $requirement->Weight = $request->input('Weight', 0);
        $requirement->Description = $request->input('Description', '');
        $requirement->update();

        $requirement->outcomes()->sync($request->input('outcomes', []));
        $classes = _Class::where('BaseClass_Id', $requirement->course()->first()->Course_Id)->with('students')->get();

        foreach ($classes as $class) {
            foreach ($class->students as $student) {
                foreach ($requirement->outcomes()->get() as $outcome) {
                    $eval = SOEvaluation::find($outcome->pivot->SOEval_Id);
                    $student->SOEvaluations()->attach($eval);
                }
            }
        }

        return redirect('/requirements/' . $requirement->Course_Id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $requirement = CourseRequirement::find($id);

        foreach ($requirement->students()->get() as $student) {
            foreach ($student->SOEvaluations()->where('Requirement_Id', $requirement->Requirement_Id)->get() as $SOEvals) {
                $SOEvals->delete();
            }
        }

        $requirement->outcomes()->detach();

        $requirement->students()->detach();

        $requirement->delete();

        return back();
    }
}
