<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\models\Client;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\Model;
use App\models\eCommerce\PageBanner;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller {
    /*
                |--------------------------------------------------------------------------
                | Login Controller
                |--------------------------------------------------------------------------
                |
                | This controller handles authenticating users for the application and
                | redirecting them to your home screen. The controller uses a trait
                | to conveniently provide its functionality to your applications.
                |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/member/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest:client')->except('logout');
    }

        /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm(Request $request){
        $banner = PageBanner::where('page_name', 'login')->first();
        return view('eCommerce.account',compact('banner'));
    }
    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request) {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/login');
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
     protected function validateLogin(Request $request) {
         $request->validate([
            $this->username() => 'required|exists:users,' . $this->username() . ',status,activated',
            'password' => 'required|string',
        ],
        [
        $this->username() . '.exists' => 'The selected email is invalid or the account has been disabled.'
    ]);
    }
    // public function login(Request $request)
    // {
    //    $this->validate($request, [
    //         'email' => 'required', 
    //         'password' => 'required',
    //     ]);

    //     $user_data = array(
    //         'email'  => $request->get('email'),
    //         'password' => $request->get('password'),
    //         'user_type'=>'Client'
    //     );

    //     if(!Auth::attempt($user_data)){
    //         return redirect('users');
    //     }

    //     if ( Auth::check() ) {
    //         return response()->json(['message' => 'Successfully Login', 'goto' => redirect()->intended($this->redirectPath())->getTargetUrl()]);
    //     }
    // }


    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request) {
        return $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request) {
        return $request->only($this->username(), 'password','user_type');
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request) {
        $request->session()->regenerate();
        
        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
        ?: redirect()->intended($this->redirectPath());
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user) {

        $goto = session()->get('goto') ? session()->get('goto') : redirect()->intended($this->redirectPath())->getTargetUrl();
        Session::put('goto', null);
        return response()->json(['message' => trans('auth.logged_in'), 'goto' => $goto]);


        // return response()->json(['message' => 'Successfully Login', 'goto' => redirect()->intended($this->redirectPath())->getTargetUrl()]);
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request) {
        
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username() {
        return 'email';
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request) {
        return response()->json(['message' => 'Successfully Logout', 'goto' => url('/')]);
    }

    protected function guard()
    {
        return Auth::guard('client');
    }

        /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($service)
    {
        return Socialite::driver($service)->redirect();
    }
    

    /**
     * Obtain the user information from google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($service)
    {
        // $user = Socialite::driver('google')->user();
        if($service == 'google') {
            $user = Socialite::driver($service)->stateless()->user();
        } else {
            $user = Socialite::driver($service)->stateless()->user();
        }
        if($user->name==null)
        {
            $arr =explode("@",$user->email);
            $name =$arr[0];
        }else{
           $name =$user->name; 
        }
 
        $findUser = User::where('email', $user->email)->first();
        
        if($findUser) {

            // Auth::login($findUser);
            $this->guard('client')->login($findUser);
        } else {
            $model = new Client();
            $model->type        =       'customer';
            $model->client_type =       'ecommerce';
            $model->sub_type =       'ecommerce';
            $model->name        =       $name;
            // $model->last_name   =       $data['last_name'];
            // $model->user_name   =       $data['username'];
            // $model->address     =       $data['address'];
            $model->email       =       $user->email;
            // $model->mobile      =       $data['phone'];
            $model->tek_marks   =       'Created Client from Frontend';
            $model->save();
            $id = $model->id;
    
            // $data['id'] = $id;
            $uuid =  Str::uuid()->toString();
    
    
            $user_login = new User;
            $user_login->clients_id = $id;
            $user_login->user_type = 'Client';
            $user_login->name = $name;
            // $user_login->surname = $data['last_name'];
            $user_login->first_name = $user->name;
            // $user_login->last_name = $data['last_name'];
            // $user_login->username = $data['username'];
            $user_login->email = $user->email;
            // $user_login->phone = $data['phone'];
            $user_login->status = 'activated';
            $user_login->uuid = $uuid;
            $user_login->password = Hash::make(123456);
            $user_login->save();

            // Auth::login($user);
            $this->guard('client')->login($user_login);

        }

        return Redirect::to('/member/dashboard');

    }

}
