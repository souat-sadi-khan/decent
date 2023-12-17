<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      Schema::defaultStringLength(191);
      
        $timexone = get_option('timezone', 'Asia/Dhaka');
       
        date_default_timezone_set($timexone);
     

      // default timezone
      

      if(Schema::hasTable('settings')) {
        $holiday = get_option('holiday');
        if($holiday == '') {
          Carbon::setWeekendDays([Carbon::FRIDAY]);
        } elseif ($holiday == 'Friday') {
          Carbon::setWeekendDays([Carbon::FRIDAY]);
        }  elseif ($holiday == 'Saturday') {
          Carbon::setWeekendDays([Carbon::SATURDAY]);
        }  elseif ($holiday == 'Sunday') {
          Carbon::setWeekendDays([Carbon::SUNDAY]);
        }  elseif ($holiday == 'Monday') {
          Carbon::setWeekendDays([Carbon::MONDAY]);
        }  elseif ($holiday == 'Tuesday') {
          Carbon::setWeekendDays([Carbon::TUESDAY]);
        }  elseif ($holiday == 'Wednesday') {
          Carbon::setWeekendDays([Carbon::WEDNESDAY]);
        }  elseif ($holiday == 'Thrusday') {
          Carbon::setWeekendDays([Carbon::THURSDAY]);
        }
      }

    }
}
