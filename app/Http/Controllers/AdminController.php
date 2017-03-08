<?php

namespace App\Http\Controllers;

use App\Course;
use App\_Class;
use App\Organization;
use Auth;
use App\AuditLog;
use App\Section;
use App\Student;
use App\User;
use App\Professor;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private $nav = 'navAdminDashboard';

    //<editor-fold desc="Constructor">
    /**
     * AdminController constructor.
     */
    public function __construct()
    {
        $this->middleware('admin');
    }
    //</editor-fold>

    //<editor-fold desc="Show Dashboard Method">
    /**
     * Show Dashboard
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showDashboard() {
        $nav = 'navAdminDashboard';
        return view('admin.menu.dashboard', compact('nav'));
    }
    //</editor-fold>

    //<editor-fold desc="Show Manage Professors Page Method">
    /**
     * Show Manage Professors Page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showManageProfessors() {
        $nav = 'navManageUsers';
        $professors = Professor::all();
        return view('admin.menu.manageProfessors', compact('nav', 'professors'));
    }
    //</editor-fold>

    //<editor-fold desc="Show Manage Students Page Method">
    /**
     * Show Manage Students Page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showManageStudents() {
        $nav = 'navManageUsers';
        $students = Student::all();
        return view('admin.menu.manageStudents', compact('nav', 'students'));
    }
    //</editor-fold>

    //<editor-fold desc="Show Manage Accounts Page Method">
    /**
     * Show Manage Accounts Page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showManageAccounts() {
        $nav = 'navManageUsers';
        $accounts = User::all();
        return view('admin.menu.manageAccounts', compact('nav', 'accounts'));
    }
    //</editor-fold>

    public function adminRedirect(){ //tmp
        $students = Student::all();
        return view('admin.studentpage', compact('students'));
    }

    public function showProfessorPage(){
        $professors = Professor::all();
        return view('admin.profpage', compact('professors'));
    }

    public function showCourses(){
        $courses = Course::all();
        return view('adminpages.coursepage', compact('courses'));
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

    public function getProfList(){
        $professors = Professor::all();
        return view('adminpages.proflistpage', compact('professors'));

    }

    public function getProfSubj(){
        $professors = Professor::all();
        $courses = Course::all();
        return view('adminpages.assignsubject', compact('professors','courses'));
    }

    public function addSection(Request $request){
//        dd($request);
        $section = new Section();

        $section->Code = $request->input('Code');
        $section->AcademicYearStart = $request->input('AcademicYearStart');
        $section->AcademicYearEnd = $request->input('AcademicYearEnd');

        $section->save();

        $this->createLog(
            'Add Section',
            'Code: '.$request->input('Code').                                           '\n'.
            'AcademicYearStart: '.$request->input('AcademicYearStart').  '\n'.
            'AcademicYearEnd: '.$request->input('AcademicYearEnd').  '\n'
        );

        return back();
    }

    public function addCourse(Request $request){
//        dd($request);
        $course = new Course();

        $course->Code = $request->input('Code');
        $course->Title = $request->input('Title');
        $course->Units = $request->input('Units');
        $course->Description = $request->input('Description');
        $course->Terms = $request->input('Terms');

        $course->save();

        $this->createLog(
            'Add Section',
            'Code: '.$request->input('Code').                                           '\n'.
            'Title: '.$request->input('Title').  '\n'.
            'Units: '.$request->input('Units').  '\n'.
            'Description: '.$request->input('Description').  '\n'.
            'Terms: '.$request->input('Terms').  '\n'
        );

        return back();
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
        $user->password = bcrypt($request->input('Birthday'));
        $user->Access_Level = 'Student';

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
            'api_token' => str_random(60),
            'Access_Level' => 'Student',
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
            'name: ' . $user->name . '\n' .
            'email: ' . $user->email . '\n' .
            'password: ' . $user->getAuthPassword() . '\n' .
            'api_token: ' . $user->api_token . '\n' .
            'Access_Level: ' . 'Student' . '\n'
        );

        return back();
    }

    private function createLog($action, $description = ""){
        $log = new AuditLog();

        $log->Account_Id = Auth::user()->id;
        $log->Action = $action;
        $log->Description = $description;

        $log->save();
    }

    public function deleteStudent(Student $student){
        $acc = $student->Account_Id;
        $student->delete();
        $user = new User();
        $user->deleteUser($acc);

        return redirect('/admin');
    }

    public function deleteProfessor(Professor $professor){
        $acc = $professor->Account_Id;
        $professor->delete();
        $user = new User();
        $user->deleteUser($acc);

        return redirect('/professor');
    }

    public function addProfessor(Request $request){
        $professors = new Professor();

        $professors->FirstName = $request->input('FirstName');
        $professors->MiddleName = $request->input('MiddleName');
        $professors->LastName = $request->input('LastName');
        $professors->Birthday = $request->input('Birthday');
        $professors->Phone = $request->input('Phone');
        $professors->Email = $request->input('Email');

        $user = User::create([
            'name' => $request->input('FirstName'),
            'email' => $request->input('Email'),
            'password' => bcrypt($request->input('Birthday')),
            'api_token' => str_random(60),
            'Access_Level' => 'Professor',
        ]);

        $user->professor()->save($professors);

//        $user->save();
//        $user->professor()->save($professors);

        $this->createLog(
            'Add Professor',
            'Name: '.$request->input('FirstName').' '.$request->input('MiddleName').' '.$request->input('LastName').                     '\n'.
            'Birthday: '.$request->input('Birthday').  '\n'.
            'Phone: '.$request->input('Phone').  '\n'.
            'PersonalEmail: '.$request->input('Email').  '\n'

        );
        return back();

    }

    public function editProfessor(Professor $professor){
        return view ('adminpages.editProfessor', compact('professor'));
    }

    public function saveEditProfessor(Request $request,Professor $professor){
        $user = User::all()->find($professor->Account_Id);
        //dd($user);
        //$user = User::query("select * from users where id='".$student->AccountID."'")->get();

        //dd($user);
        $this->createLog(
            'Edit Professor',
            'From'.
            'Name: '.$professor->FirstName.' '.$professor->MiddleName.' '.$professor->LastName.               '\n'.
            'Birthday: '.$professor->Birthday.  '\n'.
            'Phone: '.$professor->Phone.        '\n'.
            'PersonalEmail: '.$professor->Email.  '\n\n'.

            'To'.
            'Name: '.$request->input('FirstName').' '.$request->input('MiddleName').' '.$request->input('LastName').                     '\n'.
            'Birthday: '.$request->input('Birthday').  '\n'.
            'Phone: '.$request->input('Phone').  '\n'.
            'PersonalEmail: '.$request->input('PersonalEmail').  '\n'
        );

        $professor->FirstName = $request->input('FirstName');
        $professor->MiddleName = $request->input('MiddleName');
        $professor->LastName = $request->input('LastName');
        $professor->Birthday = $request->input('Birthday');
        $professor->Phone = $request->input('Phone');
        $professor->Email = $request->input('PersonalEmail');

        $professor->save();

        $user->name = $request->input('FirstName');
        $user->email = $request->input('PersonalEmail');
        $user->password = bcrypt($request->input('Birthday'));
        $user->Access_Level = 'Professor';

        $user->save();

        //return back()->with('Student_Id', $student->Student_Id);
        return redirect('/professor');
    }

    public function manageOrgMembers(Organization $organization){

        $members = $organization->students()->get();

        $students = Student::all();

        return view('admin.orgmembers',compact('members','students','organization'));
    }

    public function populateMemberList(Organization $organization, Request $request) {

        $organization->students()->sync($request->input('memberList', []));

        return back();
    }
}
