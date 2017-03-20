<?php

namespace App\Http\Controllers;

use App\AuditLog;
use App\Event;
use App\Organization;
use App\Section;
use App\Student;
use App\StudentOutcome;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class StudentController extends Controller
{
    private $nav = 'navManageUsers';

    public function __construct()
    {
        $this->middleware('student');

        View::share('nav', $this->nav);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::all();
        $sections = Section::all();
        return view('admin.menu.manageStudents', compact('students','sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $student = new Student();
        $student->StudentNumber = $request->input('StudentNumber');
        $student->FirstName = $request->input('FirstName');
        $student->MiddleName = $request->input('MiddleName', '');
        $student->LastName = $request->input('LastName');
        $student->Phone = $request->input('Phone');
        $student->PersonalEmail = $request->input('PersonalEmail');
        $student->Birthday = $request->input('Birthday');
        $student->AcademicStatus = $request->input('AcademicStatus');
        $student->Section = $request->input('Section');
//        dd($student);
//        dd($request->input('Email'));

        $user = new User();
        $user->name = $student->LastName . ', ' . $student->FirstName . ' ' . $student->MiddleName;
        $user->email = $student->PersonalEmail;
        $user->password = bcrypt($student->Birthday);
        $user->Access_Level = 'Student';
        $user->api_token = str_random(60);

        $user->save();

        $user->student()->save($student);

        $student->studentOutcomes()->attach(StudentOutcome::all());

        $this->createLog(
            'Add Student',
            'Student Number: '.$request->input('StudentNumber').  '\n'.
            'Academic Status: '.$request->input('AcademicStatus').  '\n'.
            'Name: '.$request->input('FirstName').' '.$request->input('MiddleName').' '.$request->input('LastName').                     '\n'.
            'Birthday: '.$request->input('Birthday').  '\n'.
            'Phone: '.$request->input('Phone').  '\n'.
            'Email: '.$request->input('PersonalEmail').  '\n'
        );

        $this->createLog(
            'Add User',
            'name: ' . $user->name . '\n' .
            'email: ' . $user->email . '\n' .
            'password: ' . $user->getAuthPassword() . '\n' .
            'access level: ' . $user->Access_Level . '\n' .
            'api_token: ' . $user->api_token . '\n' .
            'Access_Level: ' . 'Student' . '\n'
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
        $student = Student::find($id)->load('studentOutcomes');
        foreach ($student->studentOutcomes as $evaluation) {
            $evaluation->load('performanceIndicators');
            $evaluation->pivot->Evaluation = 0;
            $p1 = $evaluation->pivot->P1 = 0;
            $p2 = $evaluation->pivot->P2 = 0;
            $p3 = $evaluation->pivot->P3 = 0;
            $p1_ave_ctr = 0;
            $p2_ave_ctr = 0;
            $p3_ave_ctr = 0;
            echo 'Outcome: ' . $evaluation->Outcome_Code . '<br/>';
            foreach ($student->SOEvaluations()->get() as $SOEvaluation) {
                $index = $evaluation->performanceIndicators->search($SOEvaluation->performanceIndicator);
                if (is_integer($index)) {
                    switch ($index) {
                        case 0:
                            $p1_ave_ctr++;
                            $p1 += $SOEvaluation->pivot->Evaluation;
                            break;
                        case 1:
                            $p2_ave_ctr++;
                            $p2 += $SOEvaluation->pivot->Evaluation;
                            break;
                        case 2:
                            $p3_ave_ctr++;
                            $p3 += $SOEvaluation->pivot->Evaluation;
                            break;
                    }
                }
            }

            if ($p1_ave_ctr) {
                $evaluation->pivot->P1 = $p1 / $p1_ave_ctr;
            }
            if ($p2_ave_ctr) {
                $evaluation->pivot->P2 = $p2 / $p2_ave_ctr;
            }
            if ($p3_ave_ctr) {
                $evaluation->pivot->P3 = $p3 / $p3_ave_ctr;
            }
            $evaluation->pivot->Evaluation = ($p1 + $p2 + $p3) /3;
            $evaluation->pivot->update();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $student = Student::find($id);
        return view('admin.edit.editStudent', compact('student'));
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
//        dd($request->AcademicStatus);

        $student = Student::find($id);

//        dd($student->AcademicStatus);
        $student->AcademicStatus = $request->input('AcademicStatus');
        $student->update($request->all());
        $user = $student->user()->first();
        $user->update(['name' => $student->LastName . ', ' . $student->FirstName . ' ' . $student->MiddleName]);

        $this->createLog(
            'Edit Student',
            'Student Number: '.$request->input('StudentNumber').  '\n'.
            'Academic Status: '.$request->input('AcademicStatus').  '\n'.
            'Name: '.$request->input('FirstName').' '.$request->input('MiddleName').' '.$request->input('LastName').                     '\n'.
            'Birthday: '.$request->input('Birthday').  '\n'.
            'Phone: '.$request->input('Phone').  '\n'.
            'Email: '.$request->input('PersonalEmail').  '\n'
        );

        return redirect('/students');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = Student::find($id);
        $student->studentOutcomes()->sync([]);
        $acc = $student->Account_Id;
        $user = User::find($acc);


        $this->createLog(
            'Add Student',
            'Student Number: '.$student->StudentNumber.  '\n'.
            'Academic Status: '.$student->AcademicStatus.  '\n'.
            'Name: '.$student->FirstName.' '.$student->MiddleName.' '.$student->LastName.                  '\n'.
            'Birthday: '.$student->Birthday.  '\n'.
            'Phone: '.$student->Phone.  '\n'.
            'Email: '.$student->PersonalEmail.  '\n'
        );

        $student->delete();
        $user->delete();

        return back();
    }

    public function showStudentPage(){
        $students = Student::where('Account_Id', Auth::user()->id)->first();
        $organizations = $students->organizations()->get();

        return view('studentpages.dashboard', compact('organizations'));
    }

    public function showOrganization(Organization $organization){
        $orgs = $organization;

        $students = $orgs->students()->get();
//        dd($students);

        $events = Event::where('Organization_Id', $orgs->Organization_Id)->get();

        $lists = Student::where('Account_Id', Auth::user()->id)->first();
        $organizations = $lists->organizations()->get();




        return view('studentpages.orgpage', compact('organizations', 'events', 'orgs','students'));
    }

    private function createLog($action, $description = ""){
        $log = new AuditLog();

        $log->Account_Id = Auth::user()->id;
        $log->Action = $action;
        $log->Description = $description;

        $log->save();
    }
}
