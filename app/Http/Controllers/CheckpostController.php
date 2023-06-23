<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckpostController extends Controller
{
    //

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password'  =>  'required|min:6|max:32'
        ]);
        try {
            $result = User::where('email', '=', $request->email)->first();
            if (!$result) {
                return back()->with('error', 'Credintial not match.');
            }
            if (!password_verify($request->password, $result->password)) {
                return back()->with('error', 'Credintials are not match.');
            }

            // keep user id in session as email & password are for next process 
            session()->put('userID', $result->id);

            if ($result->twoFA != true) {
                session()->put('login', true);
                return redirect()->route('landing')->with('notice', 'Login successfull');
            }

            $token = $this->generate_tokens(120);
            $email = new EmailController();
            $send = $email->send_token($token, $result->email, $result->name, 'Login OTP');
            $send ?: throw new Exception('OTP sending to Email is failed.');

            session()->put('checkpost', 'login');
            session()->put('checkpostCaller', 'login');

            return redirect()->route('checkpost')->with('notice', 'We have send an otp to your email.');




            //try end
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function generate_tokens($time_in_seconds = 1200, $otp = null, $generate_new = true)
    {
        try {

            $data = [
                'uid'        => session()->get('userID') ?: throw new Exception('Session expired.'),
                'token'      => $otp ?: rand(100000, 999999),
                'expiryTime' => time() + $time_in_seconds,
                'validity'   => true
            ];

            $results = DB::table('twofatokens')->where('uid', '=', $data['uid'])->first();

            if (!$results) {
                $save = DB::table('twofatokens')->insert($data);
                $save ?: throw new Exception('Token not generated.');
                return $data['token'];
            }

            $save = DB::table('twofatokens')->where('uid', '=', $data['uid'])->update($data);
            $save ?: throw new Exception('Token not generated.');
            return $data['token'];

            //end of try
        } catch (Exception $e) {
            return false;
        }
    }

    private function validate_token($token)
    {
        try {

            $uid = session()->get('userID');

            $data = DB::table('twofatokens')->where('id', '=', $uid)->where('token', '=', $token)->where('expiryTime', '>', time())->where('validity', '=', true)->first();
            if (!$data) {
                return 'Invalid Token.';
            }

            $update = DB::table('twofatokens')->update(['validity' => '0']);
            $update ?: throw new Exception('update failed.');

            return true;

            //try end
        } catch (Exception $e) {
            return false;
        }
    }

    public function checkpost(Request $request)
    {
        $request->validate(['token' => 'required|min:6']);

        try {

            $ck_token = $this->validate_token($request->token);
            if ($ck_token !== true) {
                return back()->with('error', 'Invalid token.');
            }

            session()->forget('checkpost');

            $checkpostCaller = session()->get('checkpostCaller');

            if ($checkpostCaller === 'login' or $checkpostCaller === 'registration') {
                session()->put('login', true);
                // session()->put('checkpost', true);
                return redirect()->route('landing')->with('notice', 'You have successfully login.');
            }

            if ($checkpostCaller === 'resetTwoFA') {
                $user = User::find(session()->get('userID'));
                $user->twoFA = true;
                $user->save();

                return redirect()->route('landing')->with('notice', 'Two FA turn ON');
            }
            if ($checkpostCaller === 'forgot_password') {
                session()->forget('login');
                session()->forget('checkpostCaller');
                session()->put('reset_password', true);
                return redirect()->route('password.reset');
            }
            //try end 
        } catch (Exception $e) {
        }
    }

    public function reset_two_fa()
    {
        try {
            $user = User::find(session()->get('userID'));

            if ($user->twoFA == true) {
                $user->twoFA = false;
                $user->save();
                return back()->with('notice', 'Two FA turn OFF.');
            }

            $token = $this->generate_tokens();
            $token !== false ?: throw new Exception('Token not generated.');

            $email = new EmailController();
            $email->send_token($token, $user->email, $user->name);

            $notice = "We have sent a token to your email. Please check your email : {$user->email}  .";

            // keep next route name in session to use checkpost view dynamically
            session()->put('checkpostCaller', 'resetTwoFA');
            session()->put('checkpost', 'resetTwoFA');
            // redirect to checkpost page 
            return redirect()->route('checkpost')->with('notice', $notice);
        } catch (Exception $e) {
        }
    }
}
