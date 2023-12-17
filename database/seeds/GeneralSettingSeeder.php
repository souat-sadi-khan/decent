<?php

use App\models\Client;
use App\models\employee\EmployeeAttendanceType;
use App\models\employee\EmployeeCategory;
use App\models\employee\PayHead;
use App\models\Production\Brand;
use App\models\Production\VariationTemplate;
use Illuminate\Database\Seeder;
use App\Setting;

class GeneralSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //  Create default sidebar mini
        Setting::create([
            'name'      =>  'default_sidebar',
            'value'     =>  '0',
        ]);

        // Creaet default holiday
        Setting::create([
            'name'      =>  'holiday',
            'value'     =>  'Friday',
        ]);

        //  Create default Date Format
        Setting::create([
            'name'      =>  'date_format',
            'value'     =>  'd-m-Y',
        ]);

        //  Create default Time Format
        Setting::create([
            'name'      =>  'time_format',
            'value'     =>  'h:i A',
        ]);

        //  Create default notification_format
        Setting::create([
            'name'      =>  'notification_format',
            'value'     =>  'toast-top-right',
        ]);

        //  Create default timezone
        Setting::create([
            'name'      =>  'timezone',
            'value'     =>  'Asia/Dhaka',
        ]);

        // Create Super Admin For Employee Category
        EmployeeCategory::create([
            'name'      =>  'System Admin',
            'description' =>    'This is System Admin. It is not editable or deletable',
        ]);

        // Create a present attendance type default
        EmployeeAttendanceType::create([
            'name'      =>      'Present',
            'alias'     =>      'P',
            'type'      =>      'Present',
            'is_active'  =>         1, 
            'description' => '',
        ]);

        // Create a absent attendance type default
        EmployeeAttendanceType::create([
            'name'      =>      'Absent',
            'alias'     =>      'A',
            'type'      =>      'On_leave',
            'is_active'  =>         1, 
            'description' => '',
        ]);

        // Create a present attendance type default
        EmployeeAttendanceType::create([
            'name'      =>      'Holiday',
            'alias'     =>      'H',
            'type'      =>      'Holiday',
            'is_active'  =>         1, 
        ]);

        // Create a Walking Customer
        Client::create([
            'type' => 'customer',
            'name' => 'Walking Customer',
            'mobile' => '017XXXXXXXX',
            'client_type' => 'client',
        ]);

        // Create a default brand : Decent Footwear
        Brand::create([
            'name' => 'Decent Footwear',
            'owner_name' => 'Decent Footwear',
            'email' => 'decentfootwearbd@gmail.com',
            'phone' => '01700000000'
        ]);

        //  Create ecommerce default brand
        Setting::create([
            'name'      =>  'default_brand',
            'value'     =>  '1',
        ]);

        // Create a Basic Payhead
        PayHead::create([
            'name'     =>   'Basic',
            'alias'    =>   'BASIC',
            'type'     =>   'Earning',
            'is_active'=>   '1',
        ]);
    }
}
