<?php

namespace App\Http\Controllers;

use App\PerformanceIndicator;
use App\SOEvaluation;
use App\StudentOutcome;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class StudentOutcomeController extends Controller
{
    private $nav = 'navManageStudentOutcomes';

    public function __construct()
    {
        $this->middleware('admin');

        View::share('nav', $this->nav);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $studentOutcomes = StudentOutcome::all()->load('performanceIndicators');

        return view('admin.menu.manageStudentOutcomes', compact('studentOutcomes'));
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
        $studentOutcome = new StudentOutcome();

        $studentOutcome->Outcome_Code = $request->input('Outcome_Code', '');
        $studentOutcome->Events_Minimum = $request->input('Events_Minimum', 0);
        $studentOutcome->Description = $request->input('Description', '');

        $studentOutcome->save();

        $p1 = new PerformanceIndicator();
        $p1->Code = 'P1';
        $p1->Description = $request->input('P1Description', '');

        $studentOutcome->performanceIndicators()->save($p1);

        $p2 = new PerformanceIndicator();
        $p2->Code = 'P2';
        $p2->Description = $request->input('P2Description', '');

        $studentOutcome->performanceIndicators()->save($p2);

        $p3 = new PerformanceIndicator();
        $p3->Code = 'P3';
        $p3->Description = $request->input('P3Description', '');

        $studentOutcome->performanceIndicators()->save($p3);

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
    public function update(Request $request, $id)
    {
        $studentOutcome = StudentOutcome::find($id)->load('performanceIndicators');

        $studentOutcome->Outcome_Code = $request->input('Outcome_Code', '');
        $studentOutcome->Events_Minimum = $request->input('Events_Minimum', 0);
        $studentOutcome->Description = $request->input('Description', '');

        $studentOutcome->update();

        $p1 = $studentOutcome->performanceIndicators[0];
        $p1->Description = $request->input('P1Description', '');

        $p1->update();

        $p2 = $studentOutcome->performanceIndicators[1];
        $p2->Description = $request->input('P2Description', '');

        $p2->update();

        $p3 = $studentOutcome->performanceIndicators[2];
        $p3->Description = $request->input('P3Description', '');

        $p3->update();

        return back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $studentOutcome = StudentOutcome::find($id);

        $studentOutcome->performanceIndicators()->delete();
        $studentOutcome->delete();

        return back();
    }
}