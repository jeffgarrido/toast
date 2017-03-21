<?php

namespace App\Http\Controllers;

use App\BaseClass;
use App\CourseRequirement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RequirementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BaseClass $baseClass)
    {
        dd($baseClass);
        $course = $baseClass->course;
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

        return view('admin.menu.manageRequirements', compact('baseClass', 'course', 'professor', 'terms'));
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
    public function store(Request $request, BaseClass $baseClass)
    {
        $requirement = new CourseRequirement();

        $requirement->Name = $request->input('Name');
        $requirement->HPS = $request->input('HPS', 0);
        $requirement->Weight = $request->input('Weight', 0);
        $requirement->Description = $request->input('Description', '');
        $requirement->Term = $request->input('Term');

        $baseClass->requirements()->save($requirement);



        return redirect('/requirements/' . $baseClass->BaseClass_Id);
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

        return redirect('/requirements/' . $requirement->BaseClass_Id);
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
}
