<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    //

    public function create(Request $request)
    {
        $request->validate([
            'name'      => 'required|min:3|max:30|',
            'email'     => 'required|email|max:100|unique:users,email',
            'password'  => 'required|min:6|max:32',
            'terms'     => 'required'
        ]);

        try {
            // array of data for save in table 
            $user = [
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => password_hash($request->password, PASSWORD_DEFAULT), // use of php default
                'twoFA'     => 0,
                'isActive'  => 0
            ];

            DB::beginTransaction();

            // save user 
            $uid = DB::table('users')->insertGetId($user);

            // hold session to email verification 
            session()->put('userID', $uid);

            $checkpost  = new CheckpostController();
            $token      = $checkpost->generate_tokens();
            // check token status 
            $token !== false ?: throw new Exception('Token not generated.');

            // sending token to email 
            $subject = 'Confirmation code for your account.';

            $email = new EmailController();
            $send_token = $email->send_token($token, $user['email'], $user['name'], $subject);
            // check email sended 
            $send_token ?: throw new Exception('Email not sent.');

            // saving data in DB 
            DB::commit();


            // redirect to login checkpost page 

            $notice = "We have sent a token to verify your email. Please check your email : {$user['email']}  .";

            // keep next route name in session to use checkpost view dynamically 

            session()->put('checkpost', true);
            session()->put('checkpostCaller', 'registration');

            return redirect()->route('checkpost')->with('notice', $notice);

            //end
        } catch (Exception $e) {
            return back()->with('error', 'Signup process failed. plese try again.');
        }
    }

    public function home()
    {
        try {

            $uid = session()->get('userID');

            $data = User::findOrFail($uid);

            return view('welcome', compact('data'));
            //end try
        } catch (Exception $e) {
        }
    }

    public function update()
    {
        try {
            $user = User::findOrFail(session()->get('userID'));
            return view('update', compact('user'));
        } catch (Exception $e) {
        }
    }
    public function update_data(Request $request)
    {
        $request->validate([
            'uid'   => 'required|exists:users,id',
            'name'  => 'required|min:3|max:20',
            'email' => 'required|email|max:100'
        ]);
        try {

            $user = User::find($request->uid);

            $user->name = $request->name;
            $user->email = $request->email;
            $save = $user->save();
            $save ?: throw new Exception('Data not updated.');

            return redirect()->route('landing')->with('notice', 'Data update successfull.');

            //end try
        } catch (Exception $e) {
            return back()->with('notice', $e->getMessage());
        }
    }
}
