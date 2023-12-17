<?php

namespace App\Http\Controllers\Admin\Configuration\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberSettingDashboardController extends Controller
{
    // return to the member setting dashboard
    public function index() {
        return view('admin.setting.member.dashboard');
    }
}
