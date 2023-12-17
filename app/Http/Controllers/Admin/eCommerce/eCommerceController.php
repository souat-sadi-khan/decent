<?php

namespace App\Http\Controllers\admin\eCommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class eCommerceController extends Controller
{
    // index
    public function index() {
        return view('admin.eCommerce.index');
    }
}
