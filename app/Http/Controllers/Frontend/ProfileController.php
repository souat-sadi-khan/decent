<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\models\Client;
use App\models\eCommerce\PageBanner;
use App\models\Production\Transaction;
use App\User;

class ProfileController extends Controller
{

    public function __construct()
    {
        if(!auth('client')->check()) {
            return redirect()->route('login');
        }
    }

    public function login()
    {
        return view('eCommerce.register');
    }

    public function register()
    {
        return view('eCommerce.register');
    }

    public function register_store(Request $request)
    {
        $url = $request->url;
        $request->validate([
            'username' => 'required|unique:users',
            'email' => 'required|unique:users',
            'phone' => 'required|unique:users',
            'name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'password'       => 'required|min:6|same:re_password',
            're_password' => 'required'
        ]);

        $model = new Client();
        $model->name = $request->name;
        $model->type = $request->customer;
        $model->last_name = $request->last_name;
        $model->user_name = $request->username;
        $model->email = $request->email;
        $model->mobile = $request->phone;
        $model->address = $request->address;
        $model->password = Hash::make($request->password);
        $model->save();

        $id = $model->id;

        $user = new User();
        $user->clients_id = $id;
        $user->first_name = $request->name;
        $user->last_name = $request->last_name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->save();

        $user->assignRole('Clients');



        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Thamks for product rating'), 'goto' => url($url)]);
    }

    // get access for member Dashboard
    public function dashboard() {
        if(auth('client')->check() == true) {
            $banner = PageBanner::where('page_name','dashboard')->first();
            return view('eCommerce.dashboard',compact('banner'));
        }
    }

    // check_user_name_is_exist_or_not
    public function check_user_name_is_exist_or_not(Request $request) {
        $username = $request->val;
        $model = User::where('username', $username)->first();
        if($model) {
            echo 'Sorry. Username is Already Exist.';
        } else {
            echo '';
        }
    }

    // check_email_is_exist_or_not
    public function check_email_is_exist_or_not(Request $request) {
        $email = $request->val;
        $model = User::where('email', $email)->first();
        if($model) {
            echo 'Sorry. Email is Already Exist.';
        } else {
            echo '';
        }
    }

    // change_personal_info
    public function change_personal_info(Request $request) {

        $id = $request->id;
        $name = $request->name;
        $last_name = $request->last_name;
        $mobile = $request->mobile;
        $alternate_number = $request->alternate_number;
        $user_name = $request->user_name;
        $email = $request->email;

        if($name == '' && $last_name == '' && $mobile == '' && $user_name == '' && $email == '' ) {
            return response()->json(['success' => true, 'status' => 'error', 'message' => _lang('* fields are required.')]);
        }

        $user = User::where('clients_id', $id)->first();
        if(!$user) {
            return response()->json(['success' => true, 'status' => 'error', 'message' => _lang('Sorry. User Not Found')]);
        }

        $check_username = User::where('username', $user_name)->get();
        if(count($check_username) > 1 ) {
            return response()->json(['success' => true, 'status' => 'error', 'message' => _lang('Sorry. Username is already Exist')]);
        }

        $check_email = User::where('email', $email)->get();
        if(count($check_email) > 1 ) {
            return response()->json(['success' => true, 'status' => 'error', 'message' => _lang('Sorry. Email is already Exist')]);
        }


        $model = Client::findOrFail($request->id);
        $model->name = $request->name;
        $model->last_name = $request->last_name;
        $model->mobile = $request->mobile;
        $model->user_name = $request->user_name;
        $model->email = $request->email;
        $model->alternate_number = $request->alternate_number;
        $model->save();

        $user->username = $user_name;
        $user->email = $email;
        $user->save();

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Your Personal Information is Successfully Updated'), 'load' => true]);
    }

    // change_address_book
    public function change_address_book(Request $request) {
        $request->validate([
            'id' => 'required',
            'address' => 'required',
            'post_code' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
        ]);

        $model = Client::findOrFail($request->id);
        $model->address = $request->address;
        $model->post_code = $request->post_code;
        $model->city = $request->city;
        $model->state = $request->state;
        $model->country = $request->country;
        $model->landmark = $request->landmark;
        $model->save();

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Your Address Book is Successfully Updated'), 'load' => true]);

    }


    // client_track
    public function client_track(Request $request) {

        $banner = PageBanner::where('page_name', 'Track Order')->first();
        return view('eCommerce.track', compact('banner'));

    }

    // client_track_code
    public function client_track_code(Request $request) {
        $code = $request->code;
        $output = '';

        $query = Transaction::where('reference_no', $code)->first();
        if($query) {
            if ($query->ecommerce_status == 'pending') {
                $data = 'Pending';
            } elseif ($query->ecommerce_status == 'confirm') {
                $data = 'Confirm';
            } elseif ($query->ecommerce_status == 'progressing') {
                $data = 'In Progressing';
            } elseif ($query->ecommerce_status == 'shipment') {
                $data = 'In Shipment';
            } elseif ($query->ecommerce_status == 'success') {
                $data = 'Success';
            } else {
                $data = 'Cancel';
            }

            $output .= '
            <div class="card">
                <div class="container">
                    <h4><b>Order Tracking Successtull !!!</b></h4>
                    <p>
                        Your Order Code <b> '.$code.' </b> is in <b> '.$data.' </b>  Condition
                    </p>
                </div>
            </div>
            ';

            return response()->json(['success' => true, 'status' => 'success', 'html' => $output]);
        } else {

            $output .= '
            <div class="card" style="background:#F2DEDE">
                <div class="container">
                    <h4><b>Order Tracking Unsuccessfull !!!</b></h4>
                    <p>
                        Your Order Code <b> '.$code.' </b> is not a valid Track Code. <br>Please Enter Correct Tracking Code.
                    </p>
                </div>
            </div>
            ';
            return response()->json(['success' => true, 'status' => 'error', 'html' => $output]);
        }
    }

    // chage_password
    public function chage_password(Request $request) {
        $email_or_username = $request->email_or_username;

        if($email_or_username == '') {

            return response()->json(['success' => true, 'status' => 'danger', 'message' => 'Email Or Username Field is Required']);

        } else {

            $user = User::where('username', $email_or_username)->first();
            if(!$user) {
                $user = User::where('email', $email_or_username)->first();
                if(!$user) {
                    return response()->json(['success' => true, 'status' => 'danger', 'message' => 'Email Or Username is Wrong. Please Provide Correct']);
                }
            }

        }

        $new_password = $request->new_password;
        $password_confirmation = $request->password_confirmation;

        if($new_password != $password_confirmation) {
            return response()->json(['success' => true, 'status' => 'danger', 'message' => 'Password does not match']);
        }

        $users = User::findOrFail(auth('client')->user()->id);
        $users->password = bcrypt($new_password);
        $users->save();

        return response()->json(['success' => true, 'status' => 'success', 'message' => 'Password is Successfully Changed']);
    }
}
