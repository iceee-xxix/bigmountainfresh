<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Organizations;


class OrganizationController extends Controller
{
    //
    public function OrganizationIndex(){
        $organization_show = Organizations::select('id','organization_name')->get();

        return view('super_admin.organization.admin_organization', compact('organization_show'));
    }

    public function CreateOrganization(Request $request)
    {

        $validator_name = Validator::make($request->all(), [
            'organization_name' =>'required|unique:organizations,organization_name',
        ]);
        if($validator_name ->fails()) {
            return redirect()->back()->with('error', 'ข้อมูลนี้มีอยู่ในระบบแล้ว');
        }

        else{
        $organizations = new Organizations();
        $organizations->organization_name = $request->organization_name ;
        $organizations->save();

        return redirect()->back()->with('success','บันทึกสำเร็จ');
        }
    }

    public function EditOrganization(Request $request, $id)
    {
        $request->validate([
            'organization_name' => 'required',
        ]);

        $organizations = Organizations::find($id);
        $organizations->organization_name = $request->organization_name;
        $organizations->save();

        return redirect()->back()->with('success','บันทึกสำเร็จ');
    }

    public function DeleteOrganization($id)
    {
        $organizations = Organizations::find($id);
        $organizations->delete();

        return redirect()->back()->with('success','ลบหน่วยงานหลักสำเร็จ');
    }
}
