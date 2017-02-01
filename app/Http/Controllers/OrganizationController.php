<?php

namespace App\Http\Controllers;

use App\Organization;
use App\AuditLog;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function showOrganization(){
        $organization = Organization::all();
        return view('organizationpages.orglist', compact('organization'));
    }

    public function getOrgDetails(Organization $organization){
        return view('organizationpages.orgdetails', compact('organization'));
    }

    public function addOrg(Request $request){
        $org = new Organization();

        $org->Organization_Name = $request->input('Organization_Name');
        $org->Description = $request->input('Description');
        $org->Adviser_Id = $request->input('Adviser_Id');
        $org->save();

        //Create Audit Log
        $this->createLog(
            'Add Org',
            'Org Name: '.$request->input('Code').                                           '\n'.
            'Description: '.$request->input('Title').                                         '\n'.
            'Adviser ID: '.$request->input('Description', 'No Description Provided').  '\n'
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
}