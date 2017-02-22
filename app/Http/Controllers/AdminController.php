<?php

namespace App\Http\Controllers;

use App\AuditLog;
use App\Section;
use App\Student;
use App\User;
use App\Professor;
use Illuminate\Http\Request;

class AdminController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    public function adminRedirect(){
        $students = Student::all();
        return view('adminpages.studentpage', compact('students'));
    }

    public function showProfessorPage(){
        $professors = Professor::all();
        return view('adminpages.profpage', compact('professors'));
    }

    public function showStudentPage(){
        $students = Student::all();

        return view('adminpages.studentpage', compact('students'));
    }

    public function showSectionsPage(){
        $sections = Section::all();
        return view('adminpages.sectionpage', compact('sections'));
    }

    public function editStudent(Student $student){
        return view('adminpages.editStudent', compact('student'));
    }

    public function saveEditStudent( Request $request,Student $student ){
        $user = User::all()->find($student->Account_Id);
        //dd($user);
        //$user = User::query("select * from users where id='".$student->AccountID."'")->get();

        //dd($user);
         $this->createLog(
            'Edit Student',
            'From'.
            'Student Number: '.$student->StudentNumber.                                                 '\n'.
            'Name: '.$student->FirstName.' '.$student->MiddleName.' '.$student->LastName.               '\n'.
            'Birthday: '.$student->Birthday.  '\n'.
            'Phone: '.$student->Phone.        '\n'.
            'PersonalEmail: '.$student->PersonalEmail.  '\n\n'.

            'To'.
            'Student Number: '.$request->input('StudentNumber').                                        '\n'.
            'Name: '.$request->input('FirstName').' '.$request->input('MiddleName').' '.$request->input('LastName').                     '\n'.
            'Birthday: '.$request->input('Birthday').  '\n'.
            'Phone: '.$request->input('Phone').  '\n'.
            'PersonalEmail: '.$request->input('PersonalEmail').  '\n'
        );

        $student->StudentNumber = $request->input('StudentNumber');
        $student->AcademicStatus = $request->input('AcademicStatus');
        $student->FirstName = $request->input('FirstName');
        $student->MiddleName = $request->input('MiddleName');
        $student->LastName = $request->input('LastName');
        $student->Birthday = $request->input('Birthday');
        $student->Phone = $request->input('Phone');
        $student->PersonalEmail = $request->input('PersonalEmail');
        $student->Nickname = $request->input('Nickname');

       $student->save();

        $user->name = strlen($request->input('Nickname', ''))==0 ? $request->input('FirstName') : $request->input('Nickname');
        $user->email = $request->input('StudentNumber').'@ust.edu.ph';
        $user->password = $request->input('Birthday');
        $user->access_level = 'Student';

        $user->save();

        //return back()->with('Student_Id', $student->Student_Id);
        return redirect('/admin');
    }

    public function addStudent(Request $request){
        $students = new Student();
//        $user = new User();

        $students->StudentNumber = $request->input('StudentNumber');
        $students->AcademicStatus = $request->input('AcademicStatus');
        $students->FirstName = $request->input('FirstName');
        $students->MiddleName = $request->input('MiddleName');
        $students->LastName = $request->input('LastName');
        $students->Birthday = $request->input('Birthday');
        $students->Phone = $request->input('Phone');
        $students->PersonalEmail = $request->input('PersonalEmail');
        $students->Nickname = strlen($request->input('Nickname'))==0 ? $request->input('FirstName') : $request->input('Nickname');

        $user = User::create([
            'name' => strlen($request->input('Nickname'))==0 ? $request->input('FirstName') : $request->input('Nickname'),
            'email' => $request->input('StudentNumber').'@ust.edu.ph',
            'password' => bcrypt($request->input('Birthday')),
            'access_level' => ,
            'api_token' => str_random(60),
        ]);

        $user->student()->save($students);
        //Create Audit Log
        $this->createLog(
            'Add Student',
            'Student Number: '.$request->input('StudentNumber').                                           '\n'.
            'Name: '.$request->input('FirstName').' '.$request->input('MiddleName').' '.$request->input('LastName').                     '\n'.
            'Birthday: '.$request->input('Birthday').  '\n'.
            'Phone: '.$request->input('Phone').  '\n'.
            'PersonalEmail: '.$request->input('PersonalEmail').  '\n'
        );

        $this->createLog(
            'Add User',
            $user
        );

        return back();
    }

    public function addProfessor(Request $request){
        $professors = new Professor();
        $user = new User();

        $professors->FirstName = $request->input('FirstName');
        $professors->MiddleName = $request->input('MiddleName');
        $professors->LastName = $request->input('LastName');
        $professors->Birthday = $request->input('Birthday');
        $professors->Phone = $request->input('Phone');
        $professors->Email = $request->input('Email');

        $user->name = $request->input('FirstName');
        $user->email = $request->input('Email');
        $user->password = $request->input('Birthday');
        $user->access_level = 'Professor';

        $user->save();
        $user->professor()->save($professors);

        $this->createLog(
            'Add Professor',
            'Name: '.$request->input('FirstName').' '.$request->input('MiddleName').' '.$request->input('LastName').                     '\n'.
            'Birthday: '.$request->input('Birthday').  '\n'.
            'Phone: '.$request->input('Phone').  '\n'.
            'PersonalEmail: '.$request->input('Email').  '\n'

        );
        return back();

    }

    private function createLog($action, $description = ""){
        $log = new AuditLog();

        $log->AccountID = 1;
        $log->Action = $action;
        $log->Description = $description;

        $log->save();
    }

    public function deleteStudent(Student $student){
        $acc = $student->AccountID;
        $student->delete();
        $user = new User();
        $user->deleteUser($acc);
    }

}
