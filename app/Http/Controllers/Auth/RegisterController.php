<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use App\models\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    // eCommerce.account

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:client');
    }

        /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('eCommerce.register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            // 'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            // 'username' => ['required', 'string', 'max:255', 'unique:users'],
            'phone' => ['required', 'numeric', 'min:10', 'unique:users,id,deleted_at'],
            // 'address' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $model = new Client;
        $model->type        =       'customer';
        $model->client_type =       'ecommerce';
        $model->sub_type =       'ecommerce';
        $model->name        =       $data['name'];
        // $model->last_name   =       $data['last_name'];
        // $model->user_name   =       $data['username'];
        // $model->address     =       $data['address'];
        $model->email       =       $data['email'];
        $model->mobile      =       $data['phone'];
        $model->tek_marks   =       'Created Client from Frontend';
        $model->save();
        $id = $model->id;

        // $data['id'] = $id;
        $uuid =  Str::uuid()->toString();


        $item = new User;
        $item->clients_id = $id;
        $item->user_type = 'Client';
        $item->name = $data['name'];
        // $item->surname = $data['last_name'];
        $item->first_name = $data['name'];
        // $item->last_name = $data['last_name'];
        // $item->username = $data['username'];
        $item->email = $data['email'];
        $item->phone = $data['phone'];
        $item->status = 'activated';
        $item->uuid = $uuid;
        $item->password = Hash::make($data['password']);
        $item->save();

        return $item;
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);


        $goto = session()->get('goto') ? session()->get('goto') : redirect()->intended($this->redirectPath())->getTargetUrl();
        Session::put('goto', null);

        return response()->json(['message' => trans('auth.logged_in'), 'goto' => $goto]);

        // return response()->json(['message' => trans('auth.logged_in'), 'goto' => redirect()->intended($this->redirectPath())->getTargetUrl()]);

        // return $this->registered($request, $user)
        //                 ?: redirect($this->redirectPath());
    }

        /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        //
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('client');
    }
}
