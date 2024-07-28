<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\Alert;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    use Alert;
    public function index()
    {

        return view('admin.profile.index');
    }
    public function update(Request $request, User $user)
    {
        // update pagination settings
        session()->put('pagination', intval($request->pagination));

        $request->validate([
            'username' => 'required',
        ]);

        $user->update([
            'name' => $request->username,
        ]);

        $this->successAlert(null, 'پروفایل شما با موفقیت ویراش شد');
        return back();
    }
}
