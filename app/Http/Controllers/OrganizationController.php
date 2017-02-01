<?php

namespace App\Http\Controllers;

use App\Organization;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function showOrganization(){
        $organization = Organization::all();
        return view('organizationpages.orglist', compact('organization'));
    }
}