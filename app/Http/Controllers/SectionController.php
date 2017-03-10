<?php

namespace App\Http\Controllers;

use App\AuditLog;
use App\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class SectionController extends Controller
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
        $sections = Section::all()->sortByDesc('Code');

        return view('admin.menu.manageSections', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $section = new Section();
        $section->fill($request->all());
        $section->save();

        $this->createLog(
            'Add Section',
            'Code: ' . $section->Code . '\n' .
            'AcademicYearStart: ' . $section->AcademicYearStart . '\n' .
            'AcademicYearEnd: ' . $section->AcademicYearEnd . '\n'
        );

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
        $section = Section::find($id);
        return view('admin.edit.editSection', compact('section'));
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
        $section = Section::find($id);
        $section->update($request->all());

        $this->createLog(
            'Edit Section',
            'Code: ' . $section->Code . '\n' .
            'AcademicYearStart: ' . $section->AcademicYearStart . '\n' .
            'AcademicYearEnd: ' . $section->AcademicYearEnd . '\n'
        );

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
        $section = Section::find($id);

        $this->createLog(
            'Delete Section',
            'Code: ' . $section->Code . '\n' .
            'AcademicYearStart: ' . $section->AcademicYearStart . '\n' .
            'AcademicYearEnd: ' . $section->AcademicYearEnd . '\n'
        );

        $section->delete();

        return back();
    }

    private function createLog($action, $description = ""){
        $log = new AuditLog();

        $log->Account_Id = Auth::user()->id;
        $log->Action = $action;
        $log->Description = $description;

        $log->save();
    }
}
