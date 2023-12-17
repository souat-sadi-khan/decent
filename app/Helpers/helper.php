<?php

use App\Models\Employee\EmployeeShift;
use App\User;
use App\models\Client;
use App\models\Production\Product;
use App\models\Production\Transaction;
use App\models\Production\VariationTemplateDetails;
use App\models\depertment\ApproveStoreItem;
use App\models\depertment\DepertmentEmployee;
use App\models\depertment\MaterialReport;
use App\models\depertment\ProductFlow;
use App\models\employee\Department;
use App\models\employee\Designation;
use App\models\employee\Employee;
use App\models\employee\EmployeeAttendance;
use App\models\employee\EmployeeDesignation;
use App\models\employee\EmployeeSalary;
use App\models\employee\IdGenerator;
use App\models\employee\PayrollTransaction;
// use Str;

if (!function_exists('_lang')) {
	function _lang($string = '') {

		//Get Target language
		$target_lang = get_option('language');

		if ($target_lang == "") {
			$target_lang = "language";
		}

		if (file_exists(resource_path() . "/language/$target_lang.php")) {
			include resource_path() . "/language/$target_lang.php";
		} else {
			include resource_path() . "/language/language.php";
		}

		if (array_key_exists($string, $language)) {
			return $language[$string];
		} else {
			return $string;
		}
	}
}

if (!function_exists('load_language')) {
	function load_language($active = '') {
		$path = resource_path() . "/language";
		$files = scandir($path);
		$options = "";

		foreach ($files as $file) {
			$name = pathinfo($file, PATHINFO_FILENAME);
			if ($name == "." || $name == "" || $name == "language") {
				continue;
			}

			$selected = "";
			if ($active == $name) {
				$selected = "selected";
			} else {
				$selected = "";
			}

			$options .= "<option value='$name' $selected>" . ucwords($name) . "</option>";

		}
		echo $options;
	}
}

if (!function_exists('get_language_list')) {
	function get_language_list() {
		$path = resource_path() . "/language";
		$files = scandir($path);
		$array = array();

		foreach ($files as $file) {
			$name = pathinfo($file, PATHINFO_FILENAME);
			if ($name == "." || $name == "" || $name == "language") {
				continue;
			}

			$array[] = $name;

		}
		return $array;
	}
}

function gv($params, $keys, $default = Null) {
	return (isset($params[$keys]) and $params[$keys]) ? $params[$keys] : $default;
}

function gbv($params, $keys) {
	return (isset($params[$keys]) and $params[$keys]) ? 1 : 0;
}

if (!function_exists('get_option')) {
    function get_option($name, $default = null)
    {

        if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
			$setting = DB::table('settings')->where('name', $name)->first();

            if ($setting and $setting->value) {
                return $setting->value;
            }
        }
        return $default;
    }
}
function toWord($word) {
	$word = str_replace('_', ' ', $word);
	$word = str_replace('-', ' ', $word);
	$word = ucwords($word);
	return $word;
}

function tounderscore($text) {
	$text = str_replace(' ', '_', $text);
	$text = str_replace(' ', '_', $text);
	return $text;
}

function tospane($data) {
	$per = explode('.', $data);
	return toWord($per[1]);
}
//permission
function split_name($name) {
	$data = [];
	foreach ($name as $value) {
		$per = explode('.', $value->name);
		$data[toWord($per[0])][] = $value->name;
	}
	return $data;

}

function getUserRoleName($user_id) {
	$user = User::findOrFail($user_id);
	$roles = $user->getRoleNames();

	$role_name = '';

	if (!empty($roles[0])) {
		$array = explode('#', $roles[0], 2);
		$role_name = !empty($array[0]) ? $array[0] : '';
	}
	return $role_name;
}


function tz_list() {
	$zones_array = array();
	$timestamp = time();
	foreach (timezone_identifiers_list() as $key => $zone) {
		date_default_timezone_set($zone);
		$zones_array[$key]['zone'] = $zone;
		$zones_array[$key]['diff_from_GMT'] = 'UTC/GMT ' . date('P', $timestamp);
	}
	return $zones_array;
}

// currency list
function curency() {
	return $currency = [
		'AED' => '&#1583;.&#1573;', // ?
		'AFN' => '&#65;&#102;',
		'ALL' => '&#76;&#101;&#107;',
		'AMD' => '',
		'ANG' => '&#402;',
		'AOA' => '&#75;&#122;', // ?
		'ARS' => '&#36;',
		'AUD' => '&#36;',
		'AWG' => '&#402;',
		'AZN' => '&#1084;&#1072;&#1085;',
		'BAM' => '&#75;&#77;',
		'BBD' => '&#36;',
		'BDT' => '&#2547;', // ?
		'BGN' => '&#1083;&#1074;',
		'BHD' => '.&#1583;.&#1576;', // ?
		'BIF' => '&#70;&#66;&#117;', // ?
		'BMD' => '&#36;',
		'BND' => '&#36;',
		'BOB' => '&#36;&#98;',
		'BRL' => '&#82;&#36;',
		'BSD' => '&#36;',
		'BTN' => '&#78;&#117;&#46;', // ?
		'BWP' => '&#80;',
		'BYR' => '&#112;&#46;',
		'BZD' => '&#66;&#90;&#36;',
		'CAD' => '&#36;',
		'CDF' => '&#70;&#67;',
		'CHF' => '&#67;&#72;&#70;',
		'CLF' => '', // ?
		'CLP' => '&#36;',
		'CNY' => '&#165;',
		'COP' => '&#36;',
		'CRC' => '&#8353;',
		'CUP' => '&#8396;',
		'CVE' => '&#36;', // ?
		'CZK' => '&#75;&#269;',
		'DJF' => '&#70;&#100;&#106;', // ?
		'DKK' => '&#107;&#114;',
		'DOP' => '&#82;&#68;&#36;',
		'DZD' => '&#1583;&#1580;', // ?
		'EGP' => '&#163;',
		'ETB' => '&#66;&#114;',
		'EUR' => '&#8364;',
		'FJD' => '&#36;',
		'FKP' => '&#163;',
		'GBP' => '&#163;',
		'GEL' => '&#4314;', // ?
		'GHS' => '&#162;',
		'GIP' => '&#163;',
		'GMD' => '&#68;', // ?
		'GNF' => '&#70;&#71;', // ?
		'GTQ' => '&#81;',
		'GYD' => '&#36;',
		'HKD' => '&#36;',
		'HNL' => '&#76;',
		'HRK' => '&#107;&#110;',
		'HTG' => '&#71;', // ?
		'HUF' => '&#70;&#116;',
		'IDR' => '&#82;&#112;',
		'ILS' => '&#8362;',
		'INR' => '&#8377;',
		'IQD' => '&#1593;.&#1583;', // ?
		'IRR' => '&#65020;',
		'ISK' => '&#107;&#114;',
		'JEP' => '&#163;',
		'JMD' => '&#74;&#36;',
		'JOD' => '&#74;&#68;', // ?
		'JPY' => '&#165;',
		'KES' => '&#75;&#83;&#104;', // ?
		'KGS' => '&#1083;&#1074;',
		'KHR' => '&#6107;',
		'KMF' => '&#67;&#70;', // ?
		'KPW' => '&#8361;',
		'KRW' => '&#8361;',
		'KWD' => '&#1583;.&#1603;', // ?
		'KYD' => '&#36;',
		'KZT' => '&#1083;&#1074;',
		'LAK' => '&#8365;',
		'LBP' => '&#163;',
		'LKR' => '&#8360;',
		'LRD' => '&#36;',
		'LSL' => '&#76;', // ?
		'LTL' => '&#76;&#116;',
		'LVL' => '&#76;&#115;',
		'LYD' => '&#1604;.&#1583;', // ?
		'MAD' => '&#1583;.&#1605;.', //?
		'MDL' => '&#76;',
		'MGA' => '&#65;&#114;', // ?
		'MKD' => '&#1076;&#1077;&#1085;',
		'MMK' => '&#75;',
		'MNT' => '&#8366;',
		'MOP' => '&#77;&#79;&#80;&#36;', // ?
		'MRO' => '&#85;&#77;', // ?
		'MUR' => '&#8360;', // ?
		'MVR' => '.&#1923;', // ?
		'MWK' => '&#77;&#75;',
		'MXN' => '&#36;',
		'MYR' => '&#82;&#77;',
		'MZN' => '&#77;&#84;',
		'NAD' => '&#36;',
		'NGN' => '&#8358;',
		'NIO' => '&#67;&#36;',
		'NOK' => '&#107;&#114;',
		'NPR' => '&#8360;',
		'NZD' => '&#36;',
		'OMR' => '&#65020;',
		'PAB' => '&#66;&#47;&#46;',
		'PEN' => '&#83;&#47;&#46;',
		'PGK' => '&#75;', // ?
		'PHP' => '&#8369;',
		'PKR' => '&#8360;',
		'PLN' => '&#122;&#322;',
		'PYG' => '&#71;&#115;',
		'QAR' => '&#65020;',
		'RON' => '&#108;&#101;&#105;',
		'RSD' => '&#1044;&#1080;&#1085;&#46;',
		'RUB' => '&#1088;&#1091;&#1073;',
		'RWF' => '&#1585;.&#1587;',
		'SAR' => '&#65020;',
		'SBD' => '&#36;',
		'SCR' => '&#8360;',
		'SDG' => '&#163;', // ?
		'SEK' => '&#107;&#114;',
		'SGD' => '&#36;',
		'SHP' => '&#163;',
		'SLL' => '&#76;&#101;', // ?
		'SOS' => '&#83;',
		'SRD' => '&#36;',
		'STD' => '&#68;&#98;', // ?
		'SVC' => '&#36;',
		'SYP' => '&#163;',
		'SZL' => '&#76;', // ?
		'THB' => '&#3647;',
		'TJS' => '&#84;&#74;&#83;', // ? TJS (guess)
		'TMT' => '&#109;',
		'TND' => '&#1583;.&#1578;',
		'TOP' => '&#84;&#36;',
		'TRY' => '&#8356;', // New Turkey Lira (old symbol used)
		'TTD' => '&#36;',
		'TWD' => '&#78;&#84;&#36;',
		'TZS' => '',
		'UAH' => '&#8372;',
		'UGX' => '&#85;&#83;&#104;',
		'USD' => '&#36;',
		'UYU' => '&#36;&#85;',
		'UZS' => '&#1083;&#1074;',
		'VEF' => '&#66;&#115;',
		'VND' => '&#8363;',
		'VUV' => '&#86;&#84;',
		'WST' => '&#87;&#83;&#36;',
		'XAF' => '&#70;&#67;&#70;&#65;',
		'XCD' => '&#36;',
		'XDR' => '',
		'XOF' => '',
		'XPF' => '&#70;',
		'YER' => '&#65020;',
		'ZAR' => '&#82;',
		'ZMK' => '&#90;&#75;', // ?
		'ZWL' => '&#90;&#36;',
	];
}

// format date
function carbonDate($date){
	$dtobj = Carbon\Carbon::parse($date);
	$dtformat = $dtobj->format(get_option('date_format'));
	return $dtformat;
}

// format time
function carbonTime($date){
	$dtobj = Carbon\Carbon::parse($date);
	return $dtformat = $dtobj->format(get_option('time_format'));
}

function generate_id($id_type, $update = false){
	$last_id = IdGenerator::firstOrCreate(['id_type' => $id_type], ['id_no' => 0]);
	$id = $last_id->id_no;
	$id += 1;
	if ($update) {
	  $last_id = IdGenerator::updateOrCreate(['id_type' => $id_type], ['id_no' => $id]);
	  $id = $last_id->id_no;
	}
      return $id;

}

function numer_padding($id = 1, $code_digits=3){
	// $id = $id + 1 ;
	return str_pad($id, $code_digits,0, STR_PAD_LEFT);
}

function current_designation($id){
	$emp_d = App\models\employee\EmployeeDesignation::where('employee_id',$id)->with('designation')->latest()->first();

	$designation = ($emp_d and $emp_d->designation->name)?$emp_d->designation->name:"";
	$dept_id = ($emp_d and $emp_d->designation->department_id)?$emp_d->designation->department_id:"";

	return $designation;
}

function current_dept($id){
	$emp_d =App\models\employee\EmployeeDesignation::where('employee_id',$id)->latest()->first();
	// $designation = ($emp_d AND $emp_d->designation->name)?$emp_d->designation->name:"";
	$dept_id = ($emp_d and $emp_d->department_id)?$emp_d->department_id:"";
	$dept = App\models\employee\Department::where('id',$dept_id)->first();
	return  $dept ? $dept->name: "";
}


function to_date($start_date , $end_date){
	$datetime1 = new DateTime($start_date);
	$datetime2 = new DateTime($end_date);
	$interval = $datetime1->diff($datetime2);
	$day = $interval->format('%a');
	$days = $day + 1;
		return  $days;
}

function formatMonth($date){
	$dtobj = Carbon\Carbon::parse($date);
	return $dtformat = $dtobj->format('F');
}
function formatDate2($date){
	$dtobj = Carbon\Carbon::parse($date);
	return $dtformat = $dtobj->format('j');
}

function limit($limit)
{
	return Str::words($limit, '100');
}

function formatDate($date)
{
	$dtobj = Carbon\Carbon::parse($date);
	// if (get_option('date_format') == 'y-m-d') {
		return $dtformat = $dtobj->format('F jS, Y');
	// }
	// if (get_option('date_format') == 'Y-m-d') {
	// 	return $dtformat = $dtobj->format('M jS, Y');
	// }
	// if (get_option('date_format') == 'h-i-s') {
	// 	return $dtformat = $dtobj->format('g:i A');
	// }
	// if (get_option('date_format') == 'time') {
	// 	return $dtformat = $dtobj->format('h:i A');
	// } else {
	// 	return $dtformat = $dtobj->format('F jS Y, g:i A');
	// }
}

function formatDate1($date)
{
	$dtobj = Carbon\Carbon::parse($date);
		return $dtformat = $dtobj->format('M jS, Y');
}

	function designation_category($id){
		$emp_d =App\models\employee\EmployeeDesignation::where('employee_id',$id)->latest()->first();
		$d_id = $emp_d->designation_id;
		$d = App\models\employee\Designation::findOrFail($d_id);
		$category = ($d and $d->category->name) ? $d->category->name : "";
		return $category;
	}

	function days_in_month($month, $year)
	{
		if (checkdate($month, 31, $year)) return 31;
		if (checkdate($month, 30, $year)) return 30;
		if (checkdate($month, 29, $year)) return 29;
		if (checkdate($month, 28, $year)) return 28;
		return 0; // error
	}

	function validEmail($garbaseEmail){
    function myfunction($email)
    {
        $a = trim($email);
        if (!filter_var($a, FILTER_VALIDATE_EMAIL)) {
            // invalid emailaddress
        } else {
            return $a;
        }
    }

    $validEmail=array_map("myfunction",$garbaseEmail);
    $validEmail =  array_unique($validEmail);

    if (array_search("",$validEmail)) {
        $position = array_search("",$validEmail);
        unset($validEmail[$position]);
    }
    return $validEmail;
}

function variation_value($id){

	$value =VariationTemplateDetails::find($id);
	return $value->name;
}

function report_product_flow($dept_id,$wrk_id,$v_id,$id)
{
  $value =ProductFlow::where('depertment_id',$dept_id)->where('variation_id',$v_id)->where('work_order_id',$wrk_id)->where('done_depertment_id',$id)->sum('qty');
  return $value;
}


function get_product($id)
{
	$name =Product::select('name','id')->find($id);
	return $name->name;
}

function rawMaterialUseQty($id){
	$value =MaterialReport::where('done_material_report_id',$id);

	return $value;
}

  function textShorten($text, $limit = 400)
  {
      $text = $text . " ";
      $text = substr($text, 0, $limit);
      $text = substr($text, 0, strrpos($text, ' '));
      $text = $text . ".....";
      return $text;
  }

function approve_rawmaterial_report($id,$sDate,$eDate)
{
	$value =ApproveStoreItem::where('store_request_id',$id)->whereBetween('approve_date',[$sDate,$eDate])->sum('qty');
	return $value;
}

function done_rawmaterial_report($id,$sDate,$eDate)
{
	$value =MaterialReport::where('store_request_id',$id)->whereBetween('date',[$sDate,$eDate]);
	return $value;

}


// Sadik Work Start
// find employee designation name useing employee id
function employee_designation($employee_id) {
	$designation_description = EmployeeDesignation::where('employee_id', $employee_id)->first();
	if($designation_description) {
		$designation_id = $designation_description->designation_id;
		$find_designation = Designation::where('id', $designation_id)->first();
		if($find_designation) {
			$designation = $find_designation->name;
		} else {
			$designation = '';
		}
	} else {
		$designation = '';
	}

	return $designation;
}

// find employee name using employee id

function find_employee_name_using_employee_id($employee_id) {
	$employee  = Employee::where('id', $employee_id)->first();

	if($employee) {

		$name = $employee->name;

	} else {

		$name = '';

	}

	return $name;
}

// find employee salary structure  earning total using employee id
function find_employee_earning_salary_using_employee_id($employee_id, $payroll_id){

	$emp_salary = EmployeeSalary::where('employee_id', $employee_id)->where('id', $payroll_id)->first();

	if($emp_salary) {

		$earning = $emp_salary->total_earning;

	} else {

		$earning = 0;

	}

	return $earning;
}

// find employee salary structure  deduction total using employee id
function find_employee_deduction_salary_using_employee_id($employee_id, $payroll_id){

	$emp_salary = EmployeeSalary::where('employee_id', $employee_id)->where('id', $payroll_id)->first();

	if($emp_salary) {

		$earning = $emp_salary->total_deduction;

	} else {

		$earning = 0;

	}

	return $earning;
}

// find employee total salary structure  deduction total using employee id
function find_employee_total_salary_using_employee_id($employee_id, $payroll_id){

	$emp_salary = EmployeeSalary::where('employee_id', $employee_id)->where('id', $payroll_id)->first();

	if($emp_salary) {

		$earning = $emp_salary->net_salary;

	} else {

		$earning = 0;

	}

	return $earning;
}

function checkatndance($employee, $date)
{
    $reslust = EmployeeAttendance::where('employee_id', $employee)->where('date_of_attendance', $date)->first();
    if ($reslust != null) {
        return $reslust->employee_attendance_type_id;
    } else {
        return false;
    }
}

// find employee department name using employee id
function employee_department($employee_id) {
	$designation_description = EmployeeDesignation::where('employee_id', $employee_id)->first();
	if($designation_description) {
		$department_id = $designation_description->department_id;
		$find_department = Department::where('id', $department_id)->first();
		if($find_department) {
			$department = $find_department->name;
		} else {
			$department = '';
		}
	} else {
		$department = '';
	}

	return $department;
}

// total_advance_payment using employee id
function total_advance_payment($employee_id) {
	$total = PayrollTransaction::where('employee_id', $employee_id)->where('tx_type', 'Advance Payment')->sum('amount');
	return $total;
}

// total_advance_return using employee id
function total_advance_return($employee_id) {
	$total = PayrollTransaction::where('employee_id', $employee_id)->where('tx_type', 'Advance Return')->sum('amount');
	return $total;
}

// current_shift
function current_shift($id) {
	$shift = EmployeeShift::where('id', $id)->first();
	if($shift) {
		$name = $shift->name;
	} else {
		$name = '';
	}

	return $name;
}

// find client name using client id
function get_client_name($id) {
	$client = Client::where('id', $id)->first();
	if($client) {
		$name = $client->name;
	} else {
		$name = 'No Name Found';
	}

	return $name;
}

// find client phone using client id
function get_client_phone($id) {
	$client = Client::where('id', $id)->first();
	if($client) {
		$name = $client->mobile;
	} else {
		$name = 'No Phone Found';
	}

	return $name;
}

// find client email using client id
function get_client_email($id) {
	$client = Client::where('id', $id)->first();
	if($client) {
		$name = $client->email;
	} else {
		$name = 'No Email Found';
	}

	return $name;
}

// find client address using client id
function get_client_address($id) {
	$client = Client::where('id', $id)->first();
	if($client) {

		if($client->address != '' ) {
			$address = $client->address ;
		} else {
			$address = ' ';
		}

		if($client->post_code != '' ) {
			$post_code = $client->post_code ;
		} else {
			$post_code = ' ';
		}

		if($client->city != '' ) {
			$city = $client->city ;
		} else {
			$city = ' ';
		}

		if($client->state != '' ) {
			$state = $client->state ;
		} else {
			$state = ' ';
		}

		if($client->country != '' ) {
			$country = $client->country ;
		} else {
			$country = ' ';
		}

		$name = $address . ', ' . $post_code . ', '. $city . ', '. $state . ', '. $country;

	} else {
		$name = 'No Address Found';
	}

	return $name;
}

// find client city using client id
function get_client_city($id) {
	$client = Client::where('id', $id)->first();
	if($client) {
		$name = $client->city;
	} else {
		$name = 'No Email Found';
	}

	return $name;
}

function getIp(){
    $ip = Request::ip();
	return $ip;
}

// Sadik Work Stop
	function ref($num){
		switch ($num) {
		    case $num < 10:
		        return "000".$num;
		        break;
		    case $num >= 10 && $num < 100:
		        return "00".$num;
		        break;
		    case $num >+ 10 && $num >= 100 && $num < 1000:
		        return "0".$num;
		        break;
		    default:
		        return $num;;
		}
	}

	//convert english date to bangla date emran
	function bangla_date()
	{
	$currentDate = date("l, F j, Y");

	$engDATE = array(1,2,3,4,5,6,7,8,9,0, 'January', 'February', 'March','April', 'May', 'June', 'July', 'August','September', 'October', 'November', 'December', 'Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday');

	$bangDATE = array('১','২','৩','৪','৫','৬','৭','৮','৯','০','জানুয়ারী','ফেব্রুয়ারী','মার্চ','এপ্রিল','মে','জুন','জুলাই','আগস্ট','সেপ্টেম্বর','অক্টোবর','নভেম্বর','ডিসেম্বর','শনিবার','রবিবার','সোমবার','মঙ্গলবার',' বুধবার','বৃহস্পতিবার','শুক্রবার' );

	$convertedDATE = str_replace($engDATE, $bangDATE, $currentDate);

	return $convertedDATE;
	}


    function ovarallreport($type, $start_date = null, $end_date = null,$date=null,$month=null, $year = null)
    {
        $query = Transaction::where('transaction_type', $type)
                        ->select(
                            'net_total',
                            DB::raw("(net_total - tax) as total_exc_tax"),
                            DB::raw("SUM((SELECT SUM(tp.amount) FROM transaction_payments as tp WHERE tp.transaction_id=transactions.id)) as total_paid"),
                            DB::raw('SUM(sub_total) as total_before_tax'),
                            'shipping_charges'
                        )

                        ->groupBy('transactions.id');

        if (!empty($start_date) && !empty($end_date)) {
            $query->whereBetween(DB::raw('date(date)'), [$start_date, $end_date]);
        }

        if (empty($start_date) && !empty($end_date)) {
            $query->whereDate('date', '<=', $end_date);
        }
        if (!empty($date)) {
            $query->whereDate('date', $date);
        }


        if (!empty($month)) {
            $query->whereMonth('date', $month);
        }
        if (!empty($year)) {
            $query->whereYear('date', $year);
        }

        if (!empty($year) && !empty($month)) {
            $query->whereMonth('date', $month)->whereYear('date', $year);
        }
        if (!auth()->user()->hasRole('Super Admin')) {
            $query->where('hidden',false);
        }


        $trans_details = $query->get();

        return $trans_details;

        // $output['total_trans_inc_tax'] = $trans_details->sum('net_total');
        // //$output['total_purchase_exc_tax'] = $trans_details->sum('total_exc_tax');
        // $output['total_trans_exc_tax'] = $trans_details->sum('total_before_tax');
        // $output['paid'] = $trans_details->sum('total_paid');
        // $output['trans_due'] = $trans_details->sum('net_total') -
        //                             $trans_details->sum('total_paid');
        // $output['total_shipping_charges'] = $trans_details->sum('shipping_charges');

        // return $output;
    }


    function empdeptExit($dept,$id)
    {
      $depert =DepertmentEmployee::where('depertment_id',$dept)->where('employee_id',$id)->exists();
      if ($depert !=null) {
      	return true;
      }

	}

	// Sadik Work Start
		// make_slug
		function make_slug($string){

			$string = remove_special_char($string);
			$string = text_shorten($string);
			$string = str_replace(' ', '-', $string);
			return $string;
		}

		function text_shorten($text, $limit = 200){
			$text = $text. " ";
			$text = substr($text, 0, $limit);
			$text = substr($text, 0, strrpos($text, ' '));
			return $text;
		}//textShorten

		function remove_special_char($string) {
			$string = html_entity_decode($string);
			$string = strip_tags($string);

			$string = htmlspecialchars($string);

			$string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
			$string = str_replace(array('[\', \', ]','(', ')', '{', '}', '[', ']', '|', '?', '-', '_', ',', '~', '`', '/', '\\', '"', "'", ':'), '', $string);
			$string = preg_replace('/\[.*\]/U', '', $string);

			$string = preg_replace('/!|@|#|%|&/', '', $string);

			$string = htmlentities($string, ENT_COMPAT, 'utf-8');
			$string = str_replace('&times;', 'x', $string);
			$string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string );

			$string = preg_replace('/\s+/u', ' ', trim($string)); // for multiple spaces
			$string = preg_replace('/-+/', ' ', $string); //for multiple -
			return strtolower(trim($string, ' '));
		}

	// Sadik Work Stop



    function convert_number_to_words($number)
	{

		$hyphen      = '-';
		$conjunction = '  ';
		$separator   = ' ';
		$negative    = 'negative ';
		$decimal     = ' point ';
		$dictionary  = array(
			0                   => 'Zero',
			1                   => 'One',
			2                   => 'Two',
			3                   => 'Three',
			4                   => 'Four',
			5                   => 'Five',
			6                   => 'Six',
			7                   => 'Seven',
			8                   => 'Eight',
			9                   => 'Nine',
			10                  => 'Ten',
			11                  => 'Eleven',
			12                  => 'Twelve',
			13                  => 'Thirteen',
			14                  => 'Fourteen',
			15                  => 'Fifteen',
			16                  => 'Sixteen',
			17                  => 'Seventeen',
			18                  => 'Eighteen',
			19                  => 'Nineteen',
			20                  => 'Twenty',
			30                  => 'Thirty',
			40                  => 'Fourty',
			50                  => 'Fifty',
			60                  => 'Sixty',
			70                  => 'Seventy',
			80                  => 'Eighty',
			90                  => 'Ninety',
			100                 => 'Hundred',
			1000                => 'Thousand',
			1000000             => 'Million',
			1000000000          => 'Billion',
			1000000000000       => 'Trillion',
			1000000000000000    => 'Quadrillion',
			1000000000000000000 => 'Quintillion'
		);

		if (!is_numeric($number)) {
			return false;
		}

		if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
			// overflow
			trigger_error(
				'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
				E_USER_WARNING
			);
			return false;
		}

		if ($number < 0) {
			return $negative . convert_number_to_words(abs($number));
		}

		$string = $fraction = null;

		if (strpos($number, '.') !== false) {
			list($number, $fraction) = explode('.', $number);
		}

		switch (true) {
			case $number < 21:
				$string = $dictionary[$number];
				break;
			case $number < 100:
				$tens   = ((int) ($number / 10)) * 10;
				$units  = $number % 10;
				$string = $dictionary[$tens];
				if ($units) {
					$string .= $hyphen . $dictionary[$units];
				}
				break;
			case $number < 1000:
				$hundreds  = $number / 100;
				$remainder = $number % 100;
				$string = $dictionary[$hundreds] . ' ' . $dictionary[100];
				if ($remainder) {
					$string .= $conjunction . convert_number_to_words($remainder);
				}
				break;
			default:
				$baseUnit = pow(1000, floor(log($number, 1000)));
				$numBaseUnits = (int) ($number / $baseUnit);
				$remainder = $number % $baseUnit;
				$string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
				if ($remainder) {
					$string .= $remainder < 100 ? $conjunction : $separator;
					$string .= convert_number_to_words($remainder);
				}
				break;
		}

		if (null !== $fraction && is_numeric($fraction)) {
			$string .= $decimal;
			$words = array();
			foreach (str_split((string) $fraction) as $number) {
				$words[] = $dictionary[$number];
			}
			$string .= implode(' ', $words);
		}

		return $string ;
	}
?>
