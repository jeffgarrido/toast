<?php

namespace App\Http\Controllers;

use App\AuditLog;
use App\Student;
use App\StudentOutcome;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Writers\LaravelExcelWriter;

class ExcelController extends Controller
{
    public function getImport(){

        try{
            Excel::load(Input::file('file'),function($reader){
                $resultss = $reader->get();

                foreach ($resultss as $results)
                {
                    if(!empty($results->studentnumber))
                    {
                        $student = new Student();
                        $student->StudentNumber = (int)$results->studentnumber;
                        $student->FirstName = $results->firstname;
                        $student->MiddleName = $results->middlename;
                        $student->LastName = $results->lastname;
                        $student->Phone = $results->phone;
                        $student->PersonalEmail = $results->personalemail;
                        !empty($results->birthday) ? $student->Birthday = $results->birthday->format('Y-m-d') : $student->Birthday = '1900-01-01';
                        $student->AcademicStatus = "Regular";

                        $user = new User();
                        $user->name = $student->LastName . ', ' . $student->FirstName . ' ' . $student->MiddleName;
                        $user->email = $student->StudentNumber . '@ust.edu.ph';
                        $user->password = bcrypt($student->Birthday);
                        $user->Access_Level = 'Student';
                        $user->api_token = str_random(60);

                        $user->save();

                        $user->student()->save($student);

                        $student->studentOutcomes()->attach(StudentOutcome::all());

                        $this->createLog(
                            'Add Student',
                            'Student Number: '.$student->StudentNumber.  '\n'.
                            'Academic Status: '.$student->AcademicStatus.  '\n'.
                            'Name: '.$user->name.                    '\n'.
                            'Birthday: '.$student->Birthday.  '\n'.
                            'Phone: '.$student->Phone.  '\n'.
                            'Email: '.$student->PersonalEmail
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
                    }
                }
            });
        }catch (\Exception $ex){
            return view('errors.503',compact('ex'));
        }

        return back();
    }

    public function exportFile(){
        Excel::create('Filename', function($excel) {

            // Set the title
            $excel->setTitle('Our new awesome title');

            // Chain the setters
            $excel->setCreator('Maatwebsite')
                ->setCompany('Maatwebsite');

            // Call them separately
            $excel->setDescription('A demonstration to change the file properties');

            $excel->sheet('Sheetname');

        })->export('xlsx');

//        Excel::create('TableTemplate', function($excel) {
//            $excel->sheet('Students', function($sheet) {
//            });
//
//        })->export('xlsx');


//        Excel::create('Filename', function($excel) {
//
//            $excel->sheet('Sheetname', function($sheet) {
//
//                $sheet->fromArray(array(
//                    array('data1', 'data2'),
//                    array('data3', 'data4')
//                ));
//
//            });
//
//        })->export('xls');
    }

    private function createLog($action, $description = ""){
        $log = new AuditLog();

        $log->Account_Id = Auth::user()->id;
        $log->Action = $action;
        $log->Description = $description;

        $log->save();
    }

}
