<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    //

    public function check_email(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', '=', $request->email)->first();
        if (!$user) {
            return back()->with('notice', 'Email not match with any.');
        }

        // keep userid in session 
        session()->put('userID', $user->id);

        // generate token & check 
        $token = new CheckpostController();
        $token = $token->generate_tokens(300);
        if ($token == false) {
            return back()->with('error', 'Problem occured while generating token.');
        }

        // sending email with token & check 
        $email = new EmailController();
        $send = $email->send_token($token, $user->email, $user->name, 'Token for reset password.');
        if (!$send) {
            return back()->with('error', 'Problem occured while mailing token.');
        }


        session()->put('checkpost', true);
        session()->put('checkpostCaller', 'forgot_password');

        return redirect()->route('checkpost')->with('notice', 'We have send an otp to your email.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'password'          => 'required|min:6|max:32',
            'confirm_password'  => 'required|min:6|max:32|same:password',
        ]);

        try {

            $update = session()->get('reset_password');

            $user = User::find(session()->get('userID'));

            // case of reseting password 
            if (isset($request->type) && $request->type === 'update') {
                if (!password_verify($request->old_password, $user->password)) {
                    return back()->with('error', 'Current Password is wrong.');
                }
                $update = true;
            }

            $update ?: throw new Exception();

            $user->password = Hash::make($request->password);
            $save = $user->save();
            if (!$save) {
                return back()->with('error', 'Password not changed.');
            }
            session()->forget('password_update_type');

            return redirect()->route('landing')->with('notice', 'Password successfully updated.');
        } catch (Exception $e) {
            return back()->with('error', 'Problem occured while Password updating.');
        }
    }
}
