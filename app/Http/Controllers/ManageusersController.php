<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attemp;
use App\Models\Organizations;

class ManageusersController extends Controller
{
    //
    public function manageuserIndex(){
        $organizations = Organizations::all();

        $users = User::with('organization')->get();

        return view('super_admin.Manageusers.admin_manage_users', compact('users', 'organizations'));
    }


    public function manageuserEdit(Request $request, $id)
    {
        $request->validate([
            'edit_name' => 'required',
            // 'edit_ldap_username' => 'required',
            'organization_id' => 'required',
            'edit_user_department' => 'required',
        ]);

        $user_edit = User::find($id);
        $user_edit -> name = $request->edit_name;
        // $user_edit -> ldap_username = $request->edit_ldap_username;
        $user_edit -> organization_id = $request->organization_id;
        $user_edit -> user_department = $request->edit_user_department;
        $user_edit -> save();

        return redirect()->back()->with('success', 'ข้อมูลของผู้ใช้งานถูกแก้ไขเรียบร้อยแล้ว');
    }

    public function manageuserDelete($id)
    {
        $attemp_user_delete = Attemp::where('users_id', '=', $id);
        $attemp_user_delete->delete();

        $user_delete = User::find($id);
        $user_delete->delete();

        return redirect()->back()->with('success','ลบข้อมูลของผู้ใช้งานสำเร็จแล้ว');
    }

}
