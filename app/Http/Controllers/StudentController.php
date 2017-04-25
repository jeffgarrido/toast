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
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;

class StudentController extends Controller
{
    private $nav = 'navManageUsers';

    public function __construct()
    {
        $this->middleware('auth');

        View::share('nav', $this->nav);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::all()->sortBy('LastName');
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

        $user = new User();
        $user->name = $student->LastName . ', ' . $student->FirstName . ' ' . $student->MiddleName;
        $user->email = $student->StudentNumber .'@ust.edu.ph';
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

        return Redirect::back()->withErrors(['msg', 'The Message']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = Student::find($id);

        foreach ($student->studentOutcomes()->with('performanceIndicators')->get() as $outcome) {
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
                if($soEval->pivot->Evaluation == 0){
                    continue;
                }
                $index = $outcome->performanceIndicators->search($soEval->performanceIndicator);
                if($index === false){
                    continue;
                } else {
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
            }

            $outcome->pivot->P1 = round($outcome->pivot->P1 / (($p1ctr == 0) ? 1 : $p1ctr), 2);
            $outcome->pivot->P2 = round($outcome->pivot->P2 / (($p2ctr == 0) ? 1 : $p2ctr), 2);
            $outcome->pivot->P3 = round($outcome->pivot->P3 / (($p3ctr == 0) ? 1 : $p3ctr), 2);

            foreach ($student->events()->where('event_student.Attendance', '<>', 0)->get() as $studentEvent) {
                if ($studentEvent->studentOutcomes()->get()->contains($outcome)) {
                    $eventCtr++;
                }
            }

            $eventScore = $eventCtr / (($outcome->Events_Minimum == 0) ? 1 : $outcome->Events_Minimum) * 100;

            if($eventCtr <= 0){
                $outcome->pivot->EventEval = 0;
            }elseif($eventScore < 40) {
                $outcome->pivot->EventEval = 1;
            } elseif ($eventScore < 60) {
                $outcome->pivot->EventEval = 2;
            }elseif ($eventScore < 80) {
                $outcome->pivot->EventEval = 3;
            }else {
                $outcome->pivot->EventEval = 4;
            }

            $outcome->pivot->Evaluation = round(
                (($outcome->pivot->P1 * $outcome->performanceIndicators[0]->Weight / 100) +
                ($outcome->pivot->P2 * $outcome->performanceIndicators[1]->Weight / 100) +
                ($outcome->pivot->P3 * $outcome->performanceIndicators[2]->Weight / 100) +
                    $outcome->pivot->EventEval) /4, 2);

            $outcome->pivot->update();
        }
        return view('admin.show.showStudent', compact('student'));
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



}
