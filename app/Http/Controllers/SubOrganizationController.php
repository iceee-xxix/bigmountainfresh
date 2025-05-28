<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Organizations;

class SubOrganizationController extends Controller
{
    //
    public function SubOrganizationIndex(){
        $option = Organizations::select('id','organization_name')->get();

        return view('super_admin.organization.admin_sub_organization', compact('option'));
    }


    public function CreateSubOrganization(Request $request){

        $validator = Validator::make($request->all(), [
            'organization_name' => 'required',
            'organization_parent_id' => 'required',
        ]);
            if($validator ->fails()) {
                return redirect()->back()->with('error', 'ข้อมูลนี้มีอยู่ในระบบแล้ว');
        }

        $organizations = new Organizations();
        $organizations->organization_name = $request->organization_name;
        $organizations->organization_parent_id = $request->organization_parent_id;
        $organizations->save();

        return redirect()->back()->with('success','บันทึกสำเร็จ');
    }

    public function EditSubOrganization(Request $request,$id)
    {
        $request->validate([
            'organization_name' =>'required',
        ]);
        $organizations = Organizations::find($id);
        $organizations->organization_name = $request->organization_name;
        $organizations->save();

        return redirect()->back()->with('success','บันทึกสำเร็จ');
    }

    public function SubOrganization_Select(Request $request)
    {
        $parent_id = $request->input('id');

        $organization = Organizations::select('id','organization_name as name')
        ->where('id', '=' ,$parent_id)
        ->get();

        $sub_organization = Organizations::select(
            'organizations.*',
            'parents.organization_name as parent_name',
            )
        ->leftJoin('organizations as parents', 'organizations.organization_parent_id', '=', 'parents.id')
        ->where('organizations.organization_parent_id', '=' , $parent_id)
        ->get();

        $option = Organizations::select('id','organization_name')
        ->whereNull('organization_parent_id')
        ->get();

        return view('super_admin.organization.admin_sub_organization_select',compact('sub_organization','parent_id','organization','option'));
    }

    public function CreateSelectSubOrganization(Request $request){

        $validator = Validator::make($request->all(), [
            'organization_name' =>'required',
            'organization_parent_id' =>'required',
        ]);
            if($validator ->fails()) {
                return redirect()->back()->with('error', 'ข้อมูลนี้มีอยู่ในระบบแล้ว');
        }
        $organizations = new Organizations();
        $organizations->organization_name = $request->organization_name;
        $organizations->organization_parent_id = $request->organization_parent_id;
        $organizations->save();

        return redirect()->back()->with('success','บันทึกสำเร็จ');
    }

    public function EditSelectSubOrganization(Request $request,$id)
    {
        $request->validate([
            'organization_name' =>'required',
        ]);
        $organizations = Organizations::find($id);
        $organizations->organization_name = $request->organization_name;
        $organizations->save();

        return redirect()->back()->with('success','บันทึกสำเร็จ');
    }
}
