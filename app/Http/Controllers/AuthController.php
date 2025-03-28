<?php

namespace App\Http\Controllers;

use App\Http\Requests\generateTokenRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\LoginRequest;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use App\Models\Twoauth;
use App\Models\Client;
use App\Mail\SendOtp;
use App\Models\User;

class AuthController extends Controller
{
    use HttpResponses;

    public function __construct()
    {
        $this->otp = rand(111111, 999999);
    }


    public function index()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $payload    =   $request->all();
        $user       =   User::where(['email' => $payload['email']])->first();

        if (!empty($user)) {
            if (Hash::check($payload['password'], $user->password)) {
                $credentials = ['email' => $user->email, 'password' => $payload['password']];
                if (Auth::attempt($credentials)) {
                    // if ($user->hasRole('CMOT-ADMIN')) {
                    //     return redirect('cmot-dashboard')->with('success', 'Login successfully!!');
                    // } else if ($user->hasRole('JURY')) {
                    //     return redirect('level-dashboard')->with('success', 'Login successfully!!');
                    // } else {
                    //     return redirect('/')->with('success', 'Login successfully!!');
                    // }
                    return redirect('/')->with('success', 'Login successfully!!');
                } else {
                    return redirect('login')->with('danger', 'Login details are not valid.!!');
                }
            } else {
                return redirect('login')->with('danger', 'Invalid password entered.!!');
            }
        } else {
            return redirect('login')->with('danger', 'You are not registered with us.!!');
        }
    }

    public function registerView()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $payload    =   $request->all();
        $request->validated($request->all());
        $data = [
            'name'      =>  $payload['name'],
            'email'     =>  $payload['email'],
            'mobile'    =>  $payload['mobile'],
            'password'  =>  Hash::make($payload['password'])
        ];

        $user = User::create($data);

        if ($user) {
            return redirect('register')->with('success', 'User Registered Successfully!!');
        } else {
            return redirect('register')->withError('error', 'Something Went Wrong!!');
        }
    }

    public function home()
    {
        return view('home');
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect('/');
    }

    public function generateToken(GenerateTokenRequest $request)
    {
        $payload = $request->all();
        $request->validated($request->all());

        try {

            $user   =   User::where(function ($q) use ($payload) {
                $q->orWhere('username', $payload['username']);
                $q->orWhere('email', $payload['username']);
                $q->orWhere('mobile', $payload['username']);
            })->first();

            if (!is_null($user)) {

                if (Hash::check($payload['password'], $user->password)) {

                    $credentials = ['email' => $user->email, 'password' => $payload['password']];

                    if (!Auth::attempt($credentials)) {
                        return $this->error([], 'Credential do not match', 401);
                    }
                    return $this->success([
                        // 'user'  =>  $user,
                        'token' =>  $user->createToken('API Token of', [$user->name])->plainTextToken,
                    ], 'Token generated successfully.!!');
                } else {
                    return $this->error([], 'Login details are not valid!!', 401);
                }
            } else {
                return $this->error([], 'Login details are not valid!!', 401);
            }
        } catch (\Exception $e) {
            $this->error([], $e->getMessage(), 422);
        }
    }

    public function destroyToken()
    {
        $user = Auth::user();
        $user->currentAccessToken()->delete();
        return $this->success([], 'You have successfully logged out and your token has been deleted.!!');
    }

    public function verifyEmail(Request $request)
    {
        $payload = $request->all();
        $email = isset($payload['email']) ? $payload['email'] : '';
        $client = Client::where('email',  $email)->first();

        if ($client) {
            $response = [
                'message'   =>  'Success',
                'data'      =>  1,
            ];
        } else {
            $response = [
                'message'   =>  'Success',
                'data'      =>  0,
            ];
        }

        return $this->response('success', $response);
    }

    public function resetPwdView()
    {
        return view('auth.resetPassword');
    }

    public function resetPassword(Request $request)
    {
        $payload = $request->all();
        $request->validate([
            'email'             =>  ['required'],
        ]);
        $findUserByEmail = User::where(['email' => $payload['email']])->first();
        if (!is_null($findUserByEmail)) {
            $mail_details = [
                'to'        =>  $findUserByEmail->email,
                'subject'   =>  'OTP for Dashboard Password Reset',
                'data'      =>  [
                    'client_name'   =>  $findUserByEmail->name,
                    'otp'           =>  $this->otp
                ],
            ];
            Mail::to($mail_details['to'])->send(new SendOtp($mail_details));
            return view('auth.verifyOtp')->with('success', 'OTP sent successfully by mail.!');
        } else {
            return redirect()->back()->with('danger', 'Unable to find your record.!!');
        }
    }

    public function sendOtpView()
    {
        return view('auth.sendOtp');
    }

    public function sendOtp(Request $request)
    {
        $payload = $request->all();
        $request->validate([
            'email' =>  'required|email',
        ]);
        $findUserByEmail = User::where(['email' => $payload['email']])->first();
        if (!is_null($findUserByEmail)) {
            $authData = Twoauth::where([
                'user_id'       =>  $findUserByEmail->id,
                'email'         =>  $findUserByEmail->email,
                'is_verifed'    =>  '0',
            ])->latest()->first();
            if (is_null($authData)) {
                $twoauth    =   new Twoauth();
                $twoauth->user_id     =     $findUserByEmail->id;
                $twoauth->authcode      =   $this->otp;
                $twoauth->mobile        =   $findUserByEmail->mobile;
                $twoauth->email         =   $findUserByEmail->email;
                $twoauth->is_verifed    =   '0';
                $twoauth->ipaddress     =   $request->ip();
                $twoauth->date          =   date('Y-m-d H:i:s');

                if ($twoauth->save()) {
                    $mail_details = [
                        'to'        =>  $findUserByEmail->email,
                        'subject'   =>  'OTP for Dashboard Password Reset',
                        'data'      =>  [
                            'client_name'   =>  $findUserByEmail->name,
                            'otp'           =>  $this->otp
                        ],
                    ];
                    Mail::to($mail_details['to'])->send(new SendOtp($mail_details));
                    session()->put('session', [
                        'email' =>  $payload['email'],
                    ]);
                    return redirect()->route('verifyOtp')->with([
                        'success' => 'OTP sent successfully.!!',
                    ]);
                } else {
                    return redirect()->back()->with('danger', 'Unable to send OTP.!');
                }
            } else {
                $authData->authcode = $this->otp;
                $authData->save();
                $mail_details = [
                    'to'        =>  $findUserByEmail->email,
                    'subject'   =>  'OTP for Dashboard Password Reset',
                    'data'      =>  [
                        'client_name'   =>  $findUserByEmail->name,
                        'otp'           =>  $this->otp
                    ],
                ];
                Mail::to($mail_details['to'])->send(new SendOtp($mail_details));
                session()->put('session', [
                    'email' =>  $payload['email'],
                ]);
                return redirect()->route('verifyOtp')->with([
                    'success' => 'OTP sent successfully.!!',
                ]);
            }
        } else {
            return redirect()->back()->with('danger', 'Unable to find your record.!!');
        }
    }

    public function verifyOtpView()
    {
        return view('auth.verifyOtp');
    }

    public function verifyOtp(Request $request)
    {
        $payload = $request->all();

        $request->validate([
            'otp'       =>  'required|min:6|numeric',
        ]);

        if (session()->has('session')) {

            $session = session()->get('session');
            $user = User::where('email', $session['email'])->first();

            if (!is_null($user)) {

                $where = [
                    'user_id'       =>  $user->id,
                    'email'         =>  $user->email,
                    'is_verifed'    =>  '0',
                ];

                $authData = Twoauth::where($where)->latest()->first();

                if (!is_null($authData)) {

                    if ($authData->authcode == $payload['otp']) {

                        $verifyOtp = Twoauth::where('id', $authData->id)->update(['is_verifed' => '1']);

                        if ($verifyOtp) {

                            return redirect()->route('changePassword')->with([
                                'success' => 'OTP verify successfully.!!',
                            ]);
                        } else {
                            return redirect()->back()->with('danger', 'Something went wrong!!, Please contact with tech!!.!!');
                        }
                    } else {
                        return redirect()->back()->with('danger', 'Invalid OTP entered.!!');
                    }
                } else {
                    return redirect()->back()->with('danger', 'Unable to find auth record, please send otp again.!!');
                }
            } else {
                return redirect()->back()->with('danger', 'Unable to find user with this email.!!');
            }
        } else {
            return redirect()->back()->with('danger', 'Unable to find user with this email.!!');
        }
    }

    public function changePasswordView()
    {
        return view('auth.changePassword');
    }

    public function changePassword(Request $request)
    {
        $payload = $request->all();
        $request->validate([
            'password'              =>  'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' =>  'min:6',
        ]);

        if (session()->has('session')) {

            $session = session()->get('session');

            $user = User::where('email', $session['email'])->first();

            if (!is_null($user)) {

                $checkOtpVerified = Twoauth::where([
                    'email' => $session['email'],
                    'is_verifed' => 1,
                ])->latest('created_at')->first();

                if ($checkOtpVerified) {

                    $user->password = Hash::make($payload['password']);

                    if ($user->save()) {
                        return redirect()->route('login')->with([
                            'success' => 'Password change successfully.!!'
                        ]);
                    } else {
                        return redirect()->back()->with('danger', 'Password not updated.! Please go from start.!!');
                    }
                } else {
                    return redirect()->back()->with('danger', 'Your otp not verified.! Please go from start.!!');
                }
            } else {
                return redirect()->back()->with('danger', 'Unable to change password.!!');
            }
        } else {
            return redirect()->back()->with('danger', 'Unable to find user with this email.!!');
        }
    }
}
