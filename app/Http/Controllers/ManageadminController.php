<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ManageadminController extends Controller
{
    //
    public function manageadminIndex(){

        $users = User::all();

        return view('super_admin.Manageusers.admin_manage_admin', compact('users'));
    }

    public function manageadminUpdate(Request $request, $id)
    {
        $user = User::find($id);

        $user->user_level = $request->user_level;
        $user->save();

        return redirect()->back()->with('success', 'แก้ไข User Lavel สำเร็จแล้ว');
    }
}
