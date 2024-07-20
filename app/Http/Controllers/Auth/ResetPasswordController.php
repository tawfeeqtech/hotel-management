<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
// use Brian2694\Toastr\Facades\Toastr;

class ResetPasswordController extends Controller
{
    public function getPassword($token)
    {

       return view('auth.passwords.reset', ['token' => $token]);
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);

        $updatePassword = DB::table('password_resets')->where(['email' => $request->email, 'token' => $request->token])->first();
        if (!$updatePassword) {
            toastr()->error('Invalid token! :');
            return back();
        } else {
            $user = User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);
            DB::table('password_resets')->where(['email'=> $request->email])->delete();
            toastr()->success('Your password has been changed! :');
            return redirect('/login');
        }
       
    }
}
