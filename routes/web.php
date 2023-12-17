<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* ====================================================
		Frontend Route
==========================================================*/

/*Route::get('/s', function(){
    \Artisan::call('storage:link');
});*/

Route::group(['middleware' => ['install']], function () {

	Route::get('/', 'Frontend\Front_End_Controller@index');

	Route::get('login/{service}', 'Auth\LoginController@redirectToProvider');
    Route::get('login/{service}/callback', 'Auth\LoginController@handleProviderCallback');

	Route::group(['as' => 'member.', 'prefix' => 'member', 'namespace' => 'Frontend'], function () {
		Route::get('dashboard', 'ProfileController@dashboard')->name('dashboard');
		Route::post('change-personal-information', 'ProfileController@change_personal_info')->name('change_personal_info');
		Route::post('change-address-book', 'ProfileController@change_address_book')->name('change_address_book');
		Route::get('client-track', 'ProfileController@client_track')->name('track');
		Route::get('client-track-code', 'ProfileController@client_track_code')->name('client_track_code');
		Route::get('change-password', 'ProfileController@chage_password')->name('chage_password');

		// check_user_name_is_exist_or_not
		Route::get('/check_user_name_is_exist_or_not', 'ProfileController@check_user_name_is_exist_or_not')->name('check_user_name_is_exist_or_not');
		// check_email_is_exist_or_not
		Route::get('/check_email_is_exist_or_not', 'ProfileController@check_email_is_exist_or_not')->name('check_email_is_exist_or_not');
		Route::post('logout', 'Auth\LoginController@logout')->name('logout');


	});


	// Blog Section
	Route::get('blog','Frontend\BlogController@index')->name('blog');
	Route::get('post-details/{id}', 'Frontend\BlogController@post_details')->name('post-details');
	Route::get('category-details/{id}', 'Frontend\BlogController@category_details')->name('category-details');
	Route::post('submit-blog-comment', 'Frontend\BlogController@submit_blog_comment')->name('submit-blog-comment');

	Route::get('view-special-offer-product', 'Frontend\Front_End_Controller@view_special_offer_product')->name('view-special-offer-product');
	Route::get('whole-sale', 'Frontend\Front_End_Controller@whole_sale')->name('whole-sale');
	Route::get('contact','Frontend\Front_End_Controller@contactUs')->name('contact');
	Route::post('contactus','Frontend\Front_End_Controller@contact')->name('contactus');
	Route::get('offer/{uuid}','Frontend\Front_End_Controller@offer_details')->name('offer');
	Route::get('account', 'Frontend\Front_End_Controller@account')->name('account');
	Route::get('about','Frontend\Front_End_Controller@aboutUs')->name('about');
	Route::get('terms-condition','Frontend\Front_End_Controller@termsCondition')->name('terms-condition');
	Route::post('product-rating','Frontend\Front_End_Controller@productRating')->name('product-rating');
	Route::get('eCommerce/invoice-create/{id}','Frontend\Front_End_Controller@invoice')->name('eCommerce.invoice.create');
	Route::get('category-offer/{slug}','Frontend\Front_End_Controller@category_offer')->name('category-offer');
	Route::get('search-product', 'Frontend\Front_End_Controller@search_product')->name('search_product');

	Route::get('wishlist', 'Frontend\Front_End_Controller@wishlist')->name('wishlist');


	Route::get('product', 'Frontend\Front_End_Controller@product')->name('product');
	Route::get('category-product/{id}', 'Frontend\Front_End_Controller@category_product')->name('category-product');



	Route::get('privacy-policy','Frontend\Front_End_Controller@privacyPolicy')->name('privacy-policy');

	Route::get('product-list',function(){
		return view('eCommerce.product_list_view');
	})->name('product-list');

	Route::post('submit-news-letter-email', 'Frontend\Front_End_Controller@submit_news_letter_email')->name('submit-news-letter-email');
	Route::get('offer-product/{slug}', 'Frontend\Front_End_Controller@offer_product')->name('offer-product');
	Route::get('special-offer/{slug}', 'Frontend\Front_End_Controller@special_offer')->name('special-offer');
	Route::get('product-details/{id}', 'Frontend\Front_End_Controller@product_details')->name('product-details');
	Route::get('get-price', 'Frontend\Front_End_Controller@get_price')->name('get-price');
	Route::post('shopping-cart-add', 'Frontend\CartController@add_cart')->name('shopping-cart-add');
	Route::get('wishlist-add', 'Frontend\Front_End_Controller@add_into_wishlist')->name('add_into_wishlist');
	Route::get('wishlist-delete', 'Frontend\Front_End_Controller@delete_into_wishlist')->name('delete_into_wishlist');
	Route::get('shopping-cart-show', 'Frontend\CartController@show_cart')->name('shopping-cart-show');
	Route::get('shopping-cart-qty', 'Frontend\CartController@qty_cart')->name('shopping-cart-qty');
	Route::get('shopping-cart-remove', 'Frontend\CartController@remove_cart')->name('shopping-cart-remove');
	Route::get('coupon-check', 'Frontend\CartController@coupon_check')->name('coupon-check');
	Route::post('shopping-cart-store', 'Frontend\CartController@store_cart')->name('shopping-cart-store');
	Route::post('shopping-checkout-store', 'Frontend\CartController@store_checkout')->name('shopping-checkout-store');
	Route::get('shopping-checkout', 'Frontend\CartController@checkout')->name('shopping-checkout');
	Route::get('welcome', 'Frontend\CartController@welcome')->name('welcome');
	Route::get('invoice/{id}', 'Frontend\CartController@invoice')->name('invoice');
	/* ====================================================
			End Frontend Route
	==========================================================*/

Route::get('admin/login', 'Admin\Auth\LoginController@showLoginForm')->name('admin.login');
Route::post('admin/login', 'Admin\Auth\LoginController@login')->name('admin.login');
Route::post('admin/logout', 'Admin\Auth\LoginController@logout')->name('admin.logout');

Auth::routes();
Route::group(['as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
	//ui:::::::::::::::::::
		 Route::get('/profile', 'UiController@index')->name('profile');
		 Route::post('/profile', 'UiController@postprofile')->name('postprofile');
		 Route::post('/password', 'UiController@password_change')->name('password');

		/*::::::::::::::Employee Section:::::::::*/
		Route::get('employee/department', 'Configuration\Employee\EmployeeController@Department_index')->name('employee.department.index');
		Route::get('employee/department/datatable', 'Configuration\Employee\EmployeeController@Department_datatable')->name('employee.department.datatable');
		Route::get('employee/department/create', 'Configuration\Employee\EmployeeController@Department_create')->name('employee.department.create');
		Route::any('employee/department/store', 'Configuration\Employee\EmployeeController@Department_store')->name('employee.department.store');
		Route::get('employee/department/edit/{id?}', 'Configuration\Employee\EmployeeController@Department_edit')->name('employee.department.edit');
		Route::any('employee/department/update/{id}', 'Configuration\Employee\EmployeeController@Department_update')->name('employee.department.update');
		Route::delete('/employee/department/delete/{id}', 'Configuration\Employee\EmployeeController@Department_delete')->name('employee.department.delete');
		//:::::::::::::::::::::::::::::Employee Document Type::::::::::::::::::::::::::::::::::::
		Route::get('employee/document/datatable', 'Configuration\Employee\EmployeeDocumentTypeController@datatable')->name('document.datatable');
		Route::resource('employee-document-type', 'Configuration\Employee\EmployeeDocumentTypeController');

		//:::::::::::::::::::::::::::::Employee Category::::::::::::::::::::::::::::::::::::
		Route::get('employee-category-datatable', 'Configuration\Employee\EmployeeCategoryController@datatable')->name('category.datatable');
		Route::resource('employee-category', 'Configuration\Employee\EmployeeCategoryController');

		// ::::::::::::::::::::::::::::::  Employee Shift ::::::::::::::::::::::::::::::::::::::
		Route::get('employee-shift-datatable', 'Configuration\Employee\EmployeeShiftController@datatable')->name('shift.datatable');
		Route::resource('employee-shift', 'Configuration\Employee\EmployeeShiftController');

		//:::::::::::::::::::::::::::::Employee leave type:::::::::::::::::::::::::::::::
		Route::group(['prefix' => 'emp-leave'],function(){
			Route::get('employee-leave-type-datatable', 'Configuration\Employee\EmployeeLeaveTypeController@datatable')->name('leave_type.datatable');
			Route::resource('employee-leave-type', 'Configuration\Employee\EmployeeLeaveTypeController');
		});


		//:::::::::::::::::::::::::::::Employee leave Allocation:::::::::::::::::::::::::::::::
		Route::get('employee-leave', 'Configuration\Employee\EmployeeLeaveTypeController@view')->name('employee-leave.view');
		Route::get('employee-leave-allocation-datatable', 'Configuration\Employee\EmployeeLeaveAllocationController@datatable')->name('leave_allocation.datatable');
		Route::resource('employee-leave-allocation', 'Configuration\Employee\EmployeeLeaveAllocationController');

		//:::::::::::::::::::::::::::::Employee leave Request:::::::::::::::::::::::::::::::
		Route::get('employee-leave-request-datatable', 'Configuration\Employee\EmployeeLeaveRequestController@datatable')->name('leave_request.datatable');
		Route::post('employee-leave-request-details', 'Configuration\Employee\EmployeeLeaveRequestController@details')->name('employee-leave-request.details');
		Route::resource('employee-leave-request', 'Configuration\Employee\EmployeeLeaveRequestController');

		//:::::::::::::::::::::: Employee Pay Head ::::::::::::::::::::::::::::::
		Route::get('employee-pay-head-datatable', 'Configuration\Employee\EmployeePayHeadController@datatable')->name('pay_head.datatable');
		Route::resource('employee-pay-head', 'Configuration\Employee\EmployeePayHeadController');

		//:::::::::::::::::::::: Employee Pay Roll ::::::::::::::::::::::::::::::
		Route::get('payroll', 'Configuration\Employee\EmployeePayRollTemplateController@view')->name('payroll.view');
		Route::get('payroll-template-datatable', 'Configuration\Employee\EmployeePayRollTemplateController@datatable')->name('payroll-template.datatable');
		Route::resource('payroll-template', 'Configuration\Employee\EmployeePayRollTemplateController');
			// employee_salary_structure
			Route::resource('payroll-s-structure', 'Configuration\Employee\EmployeeSalaryStructureController');
			Route::post('employee-s-structure.ajax', 'Configuration\Employee\EmployeeSalaryStructureController@ajaxcall')->name('employee-s-structure.ajax');
			Route::get('employee-s-structure-datatable', 'Configuration\Employee\EmployeeSalaryStructureController@datatable')->name('employee-s-structure.datatable');

		// ::::::::::::::::::::::::::::::::::::::::::::::::::   Payroll ::::::::::::::::::::::::::::::::::::::::::::;;;;
		Route::get('payroll-initialize-datatable', 'Employee\PayrollController@datatable')->name('payroll-initialize.datatable');
		Route::get('payroll-initialize/print/{id}', 'Employee\PayrollController@print')->name('payroll-initialize.print');
		Route::post('payroll-initialize-step_one', 'Employee\PayrollController@step_one')->name('payroll-initialize.step_one');
		Route::resource('payroll-initialize', 'Employee\PayrollController');

		// ::::::::::::::::::::::::::::::::::::::::::::::::  Payroll Transection :::::::::::::::::::::::::::::::::::::::::::::::
		Route::get('payroll-transection-datatable', 'Employee\PayrollTransectionController@datatable')->name('payroll-transection.datatable');
		Route::get('transaction-print/{id}', 'Employee\PayrollTransectionController@print')->name('transaction_print');
		Route::post('check_payment_method', 'Employee\PayrollTransectionController@ajax')->name('check_payment_method');
		Route::post('/check_advane_return', 'Employee\PayrollTransectionController@check_advane_return')->name('check_advane_return');
		Route::post('/check_employee_payroll', 'Employee\PayrollTransectionController@check_employee_payroll')->name('check_employee_payroll');
		Route::resource('payroll-transection', 'Employee\PayrollTransectionController');

			//:::::::::::::::::::::::::::::Designation::::::::::::::::::::::::::
		Route::get('designation-datatable', 'Configuration\Employee\DesignationController@datatable')->name('designation.datatable');
		Route::resource('employee/designation', 'Configuration\Employee\DesignationController');

		// holiday section
	    Route::get('datable', 'Calender\HolidayController@datatable')->name('holiday.datatable');
		Route::resource('holiday', 'Calender\HolidayController');


		//::::::::::::::::::::::::::::: Attendance Type:::::::::::::::::::::::::::::::::
		Route::post('/date_check_for_holiday', 'Configuration\Employee\EmployeeAttendanceController@checkholiday')->name('date_check_for_holiday');

		Route::get('attendance-attendance-type-datatable', 'Configuration\Employee\EmployeeAttendanceTypeController@datatable')->name('attendance-type.datatable');
		Route::resource('attendance-attendance-type', 'Configuration\Employee\EmployeeAttendanceTypeController');
		// ::::::::::::::::::::::::::::::: Attendance:::::::::::::::::::::::::::::::::::::::
		Route::any('attendance-attendance-department', 'Configuration\Employee\EmployeeAttendanceController@department')->name('attendance-attendance.department');
		Route::any('attendance-attendance-designation', 'Configuration\Employee\EmployeeAttendanceController@designation')->name('attendance-attendance.designation');
		Route::any('attendance-attendance-date', 'Configuration\Employee\EmployeeAttendanceController@date')->name('attendance-attendance.date');
		Route::any('attendance-attendance-fetch', 'Configuration\Employee\EmployeeAttendanceController@fetch')->name('attendance-attendance.fetch');
		Route::resource('attendance-employee-attendance', 'Configuration\Employee\EmployeeAttendanceController');

		//:::::::::::::::::::::::::::::Employee List::::::::::::::::::::::::::::::::::::
		Route::get('employee-list-datatable', 'Configuration\Employee\EmployeeListController@datatable')->name('list.datatable');
		Route::resource('employee-list', 'Configuration\Employee\EmployeeListController');
		Route::post('admin/employee-list/basic_info', 'Configuration\Employee\EmployeeListController@Store_Basic_Info')->name('employee-list.basic_info');
		Route::post('admin/employee-list/contact_info', 'Configuration\Employee\EmployeeListController@Store_Contact_Info')->name('employee-list.contact_info');
		Route::any('employee-list/Image_Upload/{id}', 'Configuration\Employee\EmployeeListController@Image_Upload')->name('employee-list.Image_Upload');

		// Route for Employee Basic Info
			Route::get('/ajax/basic_info', 'Configuration\Employee\EmployeeListController@basic_info')->name('ajax.basic_info');
			Route::post('/employee/basic_info/update', 'Configuration\Employee\EmployeeListController@update_basic_info')->name('employee.basic_info.update');

		// Route for Employee Contact Info
			Route::get('/ajax/contact_info', 'Configuration\Employee\EmployeeListController@contact_info')->name('ajax.contact_info');
			Route::post('/employee/contact_info/update', 'Configuration\Employee\EmployeeListController@update_contact_info')->name('employee.contact_info.update');

		//  Route for Employee Document Info
			Route::get('/ajax/document_info', 'Employee\DocumentController@document_info')->name('ajax.document_info');
			// Route::resource('/employee-document/{id}', 'Employee\DocumentController');
			Route::get('/employee-document/create/{id}', 'Employee\DocumentController@create')->name('employee-document.create');
			Route::post('/employee-document/store', 'Employee\DocumentController@store')->name('employee-document.store');
			Route::get('/employee-document/show/{id}', 'Employee\DocumentController@show')->name('employee-document.show');
			Route::get('/employee-document/edit/{id}', 'Employee\DocumentController@edit')->name('employee-document.edit');
			Route::patch('/employee-document/update/{id}', 'Employee\DocumentController@update')->name('employee-document.update');
			Route::delete('/employee-document/destroy/{id}', 'Employee\DocumentController@destroy')->name('employee-document.destroy');
		// Route for Employee Account Info
			Route::get('/ajax/qua_info', 'Employee\QualificationController@qua_info')->name('ajax.qua_info');
			Route::get('/employee-qua/create/{id}', 'Employee\QualificationController@create')->name('employee-qua.create');
			Route::post('/employee-qua/store', 'Employee\QualificationController@store')->name('employee-qua.store');
			Route::get('/employee-qua/show/{id}', 'Employee\QualificationController@show')->name('employee-qua.show');
			Route::get('/employee-qua/edit/{id}', 'Employee\QualificationController@edit')->name('employee-qua.edit');
			Route::patch('/employee-qua/update/{id}', 'Employee\QualificationController@update')->name('employee-qua.update');
			Route::delete('/employee-qua/destroy/{id}', 'Employee\QualificationController@destroy')->name('employee-qua.destroy');

		// Route for Employee Account Info
			Route::get('/ajax/account_info', 'Employee\AccountController@account_info')->name('ajax.account_info');
			Route::get('/ajax/account/info/{id}', 'Employee\AccountController@create')->name('account.create');
			Route::post('/ajax/account/info/store/{id}', 'Employee\AccountController@store')->name('account.store');
			Route::delete('/ajax/account/info/destroy/{id}', 'Employee\AccountController@destroy')->name('account.destroy');
			Route::get('/ajax/account/info/edit/{id}', 'Employee\AccountController@edit')->name('account.edit');
			Route::get('/ajax/account/info/show/{id}', 'Employee\AccountController@show')->name('account.show');
			Route::patch('/ajax/account/info/update/{id}', 'Employee\AccountController@update')->name('account.update');

		// Route for Employee Designation Info
			Route::get('/ajax/desig_info', 'Employee\DesignationController@desig_info')->name('ajax.desig_info');

			// Route for Employee Designation add for
				Route::get('/designation_history/add', 'Employee\DesignationController@add_desig')->name('designation.add');
			Route::get('/designation_history/desig_info', 'Employee\DesignationController@desig_info')->name('ajax.desig_info');

		// Route for Employee Designation add for
			Route::get('/designation_history/add/{id}', 'Employee\DesignationController@add_desig')->name('designation.add');

		// Route for Employee  Designation Insert
			Route::post('/designation_history/store/', 'Employee\DesignationController@store')->name('designation.store_designation');

		// Route for Employee  Designation show
			Route::get('/designation_history/show/{id}', 'Employee\DesignationController@show')->name('designation.show_designation');

		// Route for Employee  Designation edit
			Route::get('/designation_history/edit/{id}', 'Employee\DesignationController@edit')->name('designation.edit_designation');

		// Route for Employee  Designation delete
			Route::delete('/designation_history/{id}', 'Employee\DesignationController@destroy')->name('designation.delete_designation');

		// Route for Employee  Designation update
			Route::patch('/designation_history/update/{id}', 'Employee\DesignationController@update')->name('designation.update_designation');

		// Route for Employee Term History
			Route::get('/term_history/term_info', 'Employee\TermController@term_info')->name('term_info');


		// Route for Employee  term show
			Route::get('/term_history/show/{id}', 'Employee\TermController@show')->name('term.show_term');

		// Route for Employee  term edit
			Route::get('/term_history/edit/{id}', 'Employee\TermController@edit')->name('term.edit_term');
			Route::patch('/term_history/update_term/{id}', 'Employee\TermController@update')->name('term.update_term');

		// Route for Employee  term edit
			Route::delete('/term_history/{id}', 'Employee\TermController@destroy')->name('term.delete_term');

		// Route for Employee  term update
			Route::patch('/term_history/update/{id}', 'Employee\TermController@update')->name('term.update_term');


		// Route for Employee Login Info
			Route::get('/ajax/login_info', 'UserController@login_info')->name('ajax.login_info');
			Route::any('/employee-details/login_info/{id}', 'UserController@set_login_info')->name('employee-details.login_info');




		// Production Route Start

		// Production Category Route
			// Route::get('production-category-datatable', 'Production\CategoryController@datatable')->name('category.datatable');
			// select2 ajax
			Route::get('people/get_people', 'Production\CategoryController@getCatagory')->name('people/get_people');
			Route::get('remort/production/category','Production\CategoryController@remort_add')->name('remort_production_category');
			Route::post('remort/production/category','Production\CategoryController@remort_addCategory')->name('remort_production_category_post');
			Route::resource('production-category', 'Production\CategoryController');

			// Production Brand Route
			Route::get('production-brands/datatable', 'Production\BrandsController@datatable')->name('brands.datatable');
			Route::get('remort/brandmodal','Production\BrandsController@remort_modal')->name('remort_brand_modal');
			Route::post('remort/brandmodal','Production\BrandsController@addremort_modal')->name('addremort_brand_modal');
			Route::get('brand/mail/{id}','Production\BrandsController@email')->name('brand.mail');
			Route::get('brand/sms/{id}','Production\BrandsController@sms')->name('brand.sms');
			Route::resource('production-brands', 'Production\BrandsController');

			//Production Unit Route
			Route::get('production-unit/datatable', 'Production\UnitController@datatable')->name('unit.datatable');
			Route::get('remort/unitmodal','Production\UnitController@remort_modal')->name('remort_unit_modal');
			Route::post('remort/unitmodal','Production\UnitController@addremort_modal')->name('addremort_unit_modal');
			Route::resource('production-unit', 'Production\UnitController');

			// Production Ingredients Category Route
			Route::get('production-ingredients-category/datatable', 'Production\IngredientsController@datatable')->name('ingredients-category.datatable');
			Route::resource('production-ingredients-category', 'Production\IngredientsController');

			//production-raw-materials
			Route::get('production-raw-materials/datatable', 'Production\RawMaterialsController@datatable')->name('raw-materials.datatable');
			Route::get('remort/row-material','Production\RawMaterialsController@remort_material')->name('remort_material');
			Route::post('remort/row-material','Production\RawMaterialsController@addremort_material')->name('addremort_material');
			Route::resource('production-raw-materials', 'Production\RawMaterialsController');

			//production-work-order
			Route::get('production-work-order/list', 'Production\WorkOrderController@transaction_list')->name('production-work-order.list');
			Route::get('work-order-transaction/datatable', 'Production\WorkOrderController@transaction_datatable')->name('work-order-transaction.datatable');
			Route::get('production-work-order/datatable', 'Production\WorkOrderController@datatable')->name('work-order.datatable');
			Route::get('production-work-order/item', 'Production\WorkOrderController@item')->name('production-work-order.item');
			Route::get('product/get_product', 'Production\WorkOrderController@getProduct');
			Route::post('production-work-order/append', 'Production\WorkOrderController@append');
			Route::get('production-work-order/pay/{id}', 'Production\WorkOrderController@pay_form')->name('production-work-order.pay');
			Route::post('production-work-order/pay-work-order-bill', 'Production\WorkOrderController@pay_bill')->name('production-work-order.pay_store');
			Route::get('production-work-order/delivery/{id}', 'Production\WorkOrderController@delivery')->name('production-work-order.delivery');
			Route::patch('production-work-order/send-delivery/{id}', 'Production\WorkOrderController@send_delivery')->name('production-work-order.send-delivery');
			Route::resource('production-work-order', 'Production\WorkOrderController');
			Route::get('print-work-order-transaction-list/{id}', 'Production\WorkOrderController@print')->name('print.work-order-transaction');
			// Production Variation Route
			Route::get('ajax_get_before_data', function() {
				$row = request()->i;
				$id = request()->data_load_template_id;
				dd($id);
				return view('admin.production.variation.show', compact('row'));
			})->name('ajax_get_before_data');
			Route::get('production-variation/addmore',function(){
				$row = request()->row;
				return view('admin.production.variation.add', compact('row'));
			})->name('production-variation.addmore');
			Route::get('production-variation-datatable', 'Production\VariationController@datatable')->name('production-variation.datatable');
			Route::resource('production-variation', 'Production\VariationController');

		// Production Product Route
			Route::get('get-unit-of-product/{id}', 'Production\ProductController@get_product');
			Route::get('production-product/product-add', 'Production\ProductController@product_add')->name('production-product.product_add');
			Route::get('production-product-datatable', 'Production\ProductController@datatable')->name('product.datatable');
			Route::get('production-product/category', 'Production\ProductController@category')->name('production-product.category');
			Route::get('production-product/variations/{id}', 'Production\ProductController@show_variation_form')->name('production-product.variation');
			Route::get('production-product/variations/add/{id}', 'Production\ProductController@variation_add')->name('production-product.variation_add');
			Route::post('production-product/variations/store', 'Production\ProductController@variation_store')->name('production-product.variation-store');
			Route::get('production-product/variations/show/{id}', 'Production\ProductController@variation_show')->name('production-product.variation-show');
			Route::get('production-product/variations/add-more/{id}', 'Production\ProductController@variation_add_more')->name('production-product.variation-add-more');
			Route::post('production-product/variations/store-more', 'Production\ProductController@variation_store_more')->name('production-product.variation-store-more');

			Route::get('production-product/details/add/{id}', 'Production\ProductController@details_add')->name('production-product.details-add');

			Route::post('production-product/details/store/{id}', 'Production\ProductController@details_store')->name('production-product.details-store');

			Route::get('products/list','Production\ProductController@product_list');
			Route::get('product/status/{id}','Production\ProductController@get_product_status')->name('get_product.status');
			Route::post('product/status','Production\ProductController@post_product_status')->name('post_product_status');
			Route::resource('production-product', 'Production\ProductController');



		// Production wop-materials Route
			Route::get('production-wop-materials/datatable', 'Production\WopMaterialController@datatable')->name('wop-materials.datatable');
			Route::get('production-wop-materials/product', 'Production\WopMaterialController@product')->name('wop-materials.product');
			Route::resource('production-wop-materials', 'Production\WopMaterialController');

		// Production Purchase Route
			Route::get('production-purchase/datatable', 'Production\PurchaseController@datatable')->name('purchase.datatable');
			Route::get('production-purchase/product', 'Production\PurchaseController@product')->name('purchase.product');
			Route::get('production-purchase/material', 'Production\PurchaseController@material')->name('purchase.material');
			Route::get('production-purchase/raw_material', 'Production\PurchaseController@rawMaterial')->name('purchase.raw_material');
			Route::get('get_raw_material', 'Production\PurchaseController@get_raw_material')->name('get_raw_material');
			Route::get('get_product', 'Production\PurchaseController@getProduct')->name('get_product');
			Route::get('get_employee', 'Production\PurchaseController@getEmployee')->name('get_employee');
			Route::get('get_work_order', 'Production\PurchaseController@WorkOrder')->name('get_work_order');
			Route::get('production-purchase/request', 'Production\PurchaseController@request')->name('production-purchase.request');
			Route::get('production-purchase/details/{id}', 'Production\PurchaseController@details')->name('production-purchase.details');
			Route::get('production-purchase/payment/{id}', 'Production\PurchaseController@payment')->name('production-purchase.payment');
			Route::patch('production-purchase/add_payment/{id}', 'Production\PurchaseController@add_payment')->name('production-purchase.add_payment');
			Route::get('production-purchase/view/{id}','Production\PurchaseController@view')->name('purchase_view');
			//new PurChase Route
			Route::get('production-purchase/new-purchase','Production\PurchaseController@new_purchase')->name('new_purchase');
			Route::get('supplier/material','Production\PurchaseController@supplier_material');
			Route::any('production-purchase/received/{id}','Production\PurchaseController@received')->name('purchase.received');
			Route::resource('production-purchase', 'Production\PurchaseController');

			// Client:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
			Route::get('client-datatable', 'ClientController@datatable')->name('client.datatable');
			Route::get('client/mail/{id}','ClientController@email')->name('client.mail');
			Route::get('client/sms/{id}','ClientController@sms')->name('client.sms');

			Route::get('client/customers','ClientController@customers');
			Route::post('client/customers','ClientController@quick_add')->name('client.quick_add');
		    Route::resource('client', 'ClientController');
		    Route::get('client-payment-due/{id}','TransactionPaymentController@getPayClientDue')->name('client_pay_due');
		    Route::post('/payments/pay-client-due', 'TransactionPaymentController@postPayClientDue')->name('client_pay_due_post');
			Route::get('client/payment-list/{id}','ClientController@getCustomerPayment')->name('getCustomerPayment');

			//Supplier
			Route::get('supplier','ClientController@get_supplier_index')->name('get_supplier_index');
			Route::get('supplier/view/{id}','ClientController@supplier_show')->name('supplier_show');

		// Production Route End

		//:::::::::::::::::::::::::::::Employee Payhead::::::::::::::::::::::::::::::::::::
		// Route::resource('employee-payhead', 'Configuration\Employee\EmployeePayHeadController');

		//::::::::Product list
		Route::get('final/product-list','Production\ProductController@finalproduct_list')->name('product_list');
		Route::get('retail_stock','ProductStockController@retail_stock');
		Route::get('product_stock/wholesale','ProductStockController@whole_stock')->name('whole_stock');
		Route::get('wholsale_stock','ProductStockController@wholsale_stock');
		Route::post('wholsale_stock_post','ProductStockController@wholsale_stock_post')->name('wholsale_stock_post');
		Route::resource('product_stock','ProductStockController');

		//  ::::::::::::::::::::::::::::: Member Setting :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
		Route::get('setting/member-setting', 'Configuration\Member\MemberSettingDashboardController@index')->name('member-setting');

			// Member Setting Nationality :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
			Route::get('setting/member-setting/nationality', 'Configuration\Member\Member_Nationality_Setting_Controller@index')->name('setting.member-setting.nationality');
			Route::get('setting/member-setting/nationality-datatable', 'Configuration\Member\Member_Nationality_Setting_Controller@datatable')->name('setting.member-setting.nationality.datatable');
			Route::get('setting/member-setting/nationality/create', 'Configuration\Member\Member_Nationality_Setting_Controller@create')->name('setting.member-setting.nationality.create');
			Route::post('setting/member-setting/nationality/store', 'Configuration\Member\Member_Nationality_Setting_Controller@store')->name('setting.member-setting.nationality.store');
			Route::get('setting/member-setting/nationality/edit/{id}', 'Configuration\Member\Member_Nationality_Setting_Controller@edit')->name('setting.member-setting.nationality.edit');
			Route::patch('setting/member-setting/nationality/update/{id}', 'Configuration\Member\Member_Nationality_Setting_Controller@update')->name('setting.member-setting.nationality.update');
			Route::delete('setting/member-setting/nationality/destroy/{id}', 'Configuration\Member\Member_Nationality_Setting_Controller@destroy')->name('setting.member-setting.nationality.destroy');

			// Member Setting Religious :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
			Route::get('setting/member-setting/religious', 'Configuration\Member\Member_Religious_Setting_Controller@index')->name('setting.member-setting.religious');
			Route::get('setting/member-setting/religious-datatable', 'Configuration\Member\Member_Religious_Setting_Controller@datatable')->name('setting.member-setting.religious.datatable');
			Route::get('setting/member-setting/religious/create', 'Configuration\Member\Member_Religious_Setting_Controller@create')->name('setting.member-setting.religious.create');
			Route::post('setting/member-setting/religious/store', 'Configuration\Member\Member_Religious_Setting_Controller@store')->name('setting.member-setting.religious.store');
			Route::get('setting/member-setting/religious/edit/{id}', 'Configuration\Member\Member_Religious_Setting_Controller@edit')->name('setting.member-setting.religious.edit');
			Route::patch('setting/member-setting/religious/update/{id}', 'Configuration\Member\Member_Religious_Setting_Controller@update')->name('setting.member-setting.religious.update');
			Route::delete('setting/member-setting/religious/destroy/{id}', 'Configuration\Member\Member_Religious_Setting_Controller@destroy')->name('setting.member-setting.religious.destroy');

			// Member Setting Occupation :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
			Route::get('setting/member-setting/occupation', 'Configuration\Member\Member_Occupation_Setting_Controller@index')->name('setting.member-setting.occupation');
			Route::get('setting/member-setting/occupation-datatable', 'Configuration\Member\Member_Occupation_Setting_Controller@datatable')->name('setting.member-setting.occupation.datatable');
			Route::get('setting/member-setting/occupation/create', 'Configuration\Member\Member_Occupation_Setting_Controller@create')->name('setting.member-setting.occupation.create');
			Route::post('setting/member-setting/occupation/store', 'Configuration\Member\Member_Occupation_Setting_Controller@store')->name('setting.member-setting.occupation.store');
			Route::get('setting/member-setting/occupation/edit/{id}', 'Configuration\Member\Member_Occupation_Setting_Controller@edit')->name('setting.member-setting.occupation.edit');
			Route::patch('setting/member-setting/occupation/update/{id}', 'Configuration\Member\Member_Occupation_Setting_Controller@update')->name('setting.member-setting.occupation.update');
			Route::delete('setting/member-setting/occupation/destroy/{id}', 'Configuration\Member\Member_Occupation_Setting_Controller@destroy')->name('setting.member-setting.occupation.destroy');

		/*::::::::::::::Member List Section:::::::::*/
		Route::resource('member-list', 'Configuration\Member\MemberController');



		// Employee Section End


		// Employee Id Card Section

		Route::get('setting/id-card-template', 'IdCardController@index')->name('id-card-template');
		Route::get('/employee-id-card/', 'IdCardController@id_card')->name('employee-id-card.id_card');
		Route::post('/employee-id-card/show', 'IdCardController@show')->name('employee-id-card.show');

		Route::get('setting/id-card-template/create', 'IdCardController@create')->name('id-card-template.create');
		Route::post('setting/id-card-template/store', 'IdCardController@store')->name('id-card-template.store');
		Route::any('setting/id-card-template/datatable', 'IdCardController@datatable')->name('id-card-template.datatable');
		Route::get('setting/id-card-template/edit/{id}', 'IdCardController@edit')->name('id-card-template.edit');
		Route::patch('setting/id-card-template/update/{id}', 'IdCardController@update')->name('id-card-template.update');
		Route::delete('setting/id-card-template/destroy/{id}', 'IdCardController@destroy')->name('id-card-template.destroy');


		 Route::any('setting/general-setting','SettingController@index')->name('setting');
		 Route::any('setting/system-setting','SettingController@SystemConfiguration')->name('system.setting');
		 Route::any('setting/mail-setting','SettingController@MainConfiguration')->name('mail.setting');
		 Route::any('setting/sms-setting','SettingController@SmsConfiguration')->name('sms.setting');
		 Route::any('setting/module-setting','SettingController@ModudelConfiguraion')->name('module.setting');
		 Route::get('backup','SettingController@getBackup')->name('backup');
		 Route::get('language','LanguageController@index')->name('language');
		 Route::match(['get', 'post'], 'create', 'LanguageController@create')->name('language.create');

		 Route::get('language/edit/{id?}', 'LanguageController@edit')->name('language.edit');
		 Route::patch('language/update/{id}', 'LanguageController@update')->name('language.update');
		 Route::delete('/language/delete/{id}', 'LanguageController@delete')->name('language.delete');

    Route::group(['as' => 'expense.','prefix' => 'expense','namespace' => 'Expense'], function () {

    	Route::get('category/datatable','ExpenseCategoryController@datatable')->name('category.datatable');
    	Route::resource('category', 'ExpenseCategoryController');
    	Route::get('datatable','ExpenseController@datatable')->name('datatable');
    	Route::resource('ex', 'ExpenseController');
	});
  //Email Marketing::::::::::::::::
	Route::group(['as' => 'emailmarketing.','prefix' => 'emailmarketing','namespace' => 'marketing'], function () {

    	Route::get('template/datatable','EmailTemplateController@datatable')->name('template.datatable');
    	Route::resource('template', 'EmailTemplateController');
    	Route::get('media/datatable','EmailMediaController@datatable')->name('media.datatable');
    	Route::get('media/import','EmailMediaController@import_media');
    	Route::resource('media', 'EmailMediaController');
    	Route::get('get_emails/{type}','SendMailController@get_emails');
    	Route::get('get_emails_list/{type}','SendMailController@get_emails_list');
    	Route::get('email-history/datatable','SendMailController@history_table')->name('email_history_datable');
    	Route::get('email-history','SendMailController@history')->name('email_history');
    	Route::get('email-history/{id}','SendMailController@history_view')->name('email_history_view');
    	Route::post('client-send-mail','SendMailController@client_send_mail')->name('client_send_mail');
    	Route::post('transaction/email','SendMailController@transaction_email')->name('transaction_email');
    	Route::resource('sendmail', 'SendMailController');
	});



	//eCommerce Marketing::::::::::::::::
	Route::group(['as' => 'eCommerce.','prefix' => 'eCommerce','namespace' => 'eCommerce'], function () {

				// Blog Section::::::::::::::::
				Route::get('blog-category/datatable', 'BlogCategoryController@datatable')->name('blog-category.datatable');
				Route::resource('blog-category', 'BlogCategoryController');
		
		
				Route::get('blog-post/datatable', 'BlogPostController@datatable')->name('blog-post.datatable');
				Route::get('blog-post.comment/datatable', 'BlogPostController@comment_datatable')->name('blog-post.comment.datatable');
				Route::get('blog-post/comment', 'BlogPostController@comment')->name('blog-post.comment');
				Route::get('blog-post/comment/show/{id}', 'BlogPostController@comment_show')->name('blog-post.comment.show');
				Route::patch('blog-post/comment/update/{id}', 'BlogPostController@comment_update')->name('blog-post.comment.update');
				Route::delete('blog-post/comment/destroy/{id}', 'BlogPostController@comment_delete')->name('blog-post.comment.destroy');
				Route::resource('blog-post', 'BlogPostController');
		

		Route::get('/', 'eCommerceController@index')->name('index');

		Route::get('qurier/datatable', 'QurierController@datatable')->name('qurier.datatable');
		Route::resource('qurier', 'QurierController');

		// subscribers
		Route::get('subscribers', 'SubscriberController@index')->name('subscribers.index');
		Route::get('subscribers/datatable', 'SubscriberController@datatable')->name('subscribers.datatable');
		Route::get('subscribers/edit/{id}', 'SubscriberController@edit')->name('subscribers.edit');
		Route::patch('subscribers/update/{id}', 'SubscriberController@update')->name('subscribers.update');
		Route::delete('subscribers/destroy/{id}', 'SubscriberController@destroy')->name('subscribers.destroy');
		// eCommerce-offer
		Route::get('eCommerce-offer/datatable','eCommerceOfferController@datatable')->name('eCommerce-offer.datatable');
		Route::get('eCommerce-offer/check_price','eCommerceOfferController@check_price')->name('eCommerce-offer.check_price');
		Route::resource('eCommerce-offer', 'eCommerceOfferController');

		// Production to ecommerce
		Route::get('production-to-ecommerce/insert', 'ProductionToEcommerceController@scannerappend1');
		Route::post('production-to-ecommerce/store_reverse', 'ProductionToEcommerceController@store_reverse')->name('production-to-ecommerce.store_reverse');
		Route::get('production-to-ecommerce/search-product', 'ProductionToEcommerceController@product_list')->name('production-to-ecommerce.product_list');
		Route::get('production-to-ecommerce/reverse', 'ProductionToEcommerceController@reverse_show')->name('production-to-ecommerce.reverse');
		Route::get('producion-to-ecommerce/datatable', 'ProductionToEcommerceController@datatable')->name('producion-to-ecommerce.datatable');
		Route::resource('production-to-ecommerce', 'ProductionToEcommerceController');

		Route::get('curier-print', 'OrderController@get_curier_print')->name('curier-print');

		// special_offer
		Route::get('add_to_special_offer_row', 'SpecialOfferController@add_to_special_offer_row')->name('add_to_special_offer_row');
		Route::get('special-offer.datatable', 'SpecialOfferController@datatable')->name('special-offer.datatable');
		Route::resource('special-offer', 'SpecialOfferController');

		// Special Category
		Route::get('special-category.datatable', 'SpecialCategoryController@datatable')->name('special-category.datatable');
		Route::resource('special-category', 'SpecialCategoryController');

		// feature-product
		Route::get('feature-product/datatable','FeatureProductController@datatable')->name('feature-product.datatable');
		Route::get('feature-product/status', 'FeatureProductController@status')->name('feature-product.change_status');
		Route::resource('feature-product', 'FeatureProductController');

		// hotsale-product
		Route::get('hotsale-product/datatable','HotSaleProductController@datatable')->name('hotsale-product.datatable');
		Route::get('hotsale-product/status', 'HotSaleProductController@status')->name('hotsale-product.change_status');
		Route::resource('hotsale-product', 'HotSaleProductController');

		// All home page image route
		Route::get('home-page/datatable','HomePageController@datatable')->name('home-page.datatable');
		Route::resource('home-page','HomePageController');
		// All slider route
		Route::get('slider/datatable','SliderController@datatable')->name('slider.datatable');
		Route::resource('slider','SliderController');
		// All Coupons route
		Route::get('coupons/datatable','CouponsController@datatable')->name('coupons.datatable');
		Route::resource('coupons','CouponsController');
		// All shipping charge route
		Route::get('shipping-charge/datatable','ShippingChargeController@datatable')->name('shipping-charge.datatable');
    	Route::resource('shipping-charge','ShippingChargeController');
		//Privacy and Policy route

		Route::get('whole-sale','PrivacyPolicyController@whole_sale_index')->name('whole-sale');
		Route::post('whole_sale_store','PrivacyPolicyController@whole_sale_store')->name('whole_sale_store');
    	Route::get('privacy-policy/index','PrivacyPolicyController@index')->name('privacy-policy.index');
		Route::post('privacy-policy/store','PrivacyPolicyController@store')->name('privacy-policy.store');

		//about us route
		Route::get('about-us/index','AboutUsController@index')->name('about-us.index');
		Route::post('about-us/store','AboutUsController@store')->name('about-us.store');

		//about us route
		Route::get('seo/index','SeoController@index')->name('seo.index');
		Route::post('seo/store','SeoController@store')->name('seo.store');

		//Our Team route
		Route::get('our-team/datatable', 'OurTeamController@datatable')->name('our-team.datatable');
		Route::resource('our-team','OurTeamController');

		//Our workspace route
		Route::get('our-workspace/datatable', 'OurWorkspaceControler@datatable')->name('our-workspace.datatable');
		Route::resource('our-workspace','OurWorkspaceControler');

		//Contact message route
		Route::get('contact-msg/datatable', 'ContactMessageController@datatable')->name('contact-msg.datatable');
		Route::resource('contact-msg','ContactMessageController');


		//Contact message route
		Route::get('product-rating/index', 'ProductRatingController@rating_index')->name('product-rating.index');
		Route::get('product-rating/datatable', 'ProductRatingController@datatable')->name('product-rating.datatable');
		Route::get('product-rating/status/{id}', 'ProductRatingController@status')->name('product-rating.status');
		Route::any('product-rating/status_change/{id}', 'ProductRatingController@status_change')->name('product-rating.status_change');
		Route::delete('product-rating/destroy/{id}', 'ProductRatingController@destroy')->name('product-rating.destroy');

		//Terams and Condition route
    	Route::get('terams-conditions/index','TeramsConditionsController@index')->name('terams-conditions.index');
		Route::post('terams-conditions/store','TeramsConditionsController@store')->name('terams-conditions.store');

		// eCommerce Order
		Route::get('orders/index', 'OrderController@index')->name('order.index');
		Route::post('orders/change_ship_address', 'OrderController@change_ship_address')->name('order.change_ship_address');
		Route::get('orders/pdf/{id}', 'OrderController@pdf')->name('order.pdf');
		Route::get('orders/change-status', 'OrderController@change_status')->name('order.change_status');
		Route::get('orders/sort-order', 'OrderController@sort_order')->name('order.sort_order');
		Route::get('orders/sort-order-date-wise', 'OrderController@sort_order_date_wise')->name('order.sort_order_date_wise');
		Route::get('orders/show/{id}', 'OrderController@show')->name('order.show');
		Route::get('order/update/{id}', 'OrderController@show_update_page')->name('update_invoice');
		Route::patch('order/edit/{id}', 'OrderController@edit_the_transaction')->name('update_report');

		// page-banner
		Route::get('page-banner/datatable', 'PageBannerController@datatable')->name('page-banner.datatable');
		Route::resource('page-banner', 'PageBannerController');

		Route::get('customer','ClientController@ecustomer')->name('e_customer');

	});

     Route::get('eCommerce/customer','ClientController@ecustomer')->name('eCommerce.e_customer');
     Route::get('eCommerce/customer/view/{id}','ClientController@ecustomer_view')->name('e_customer.view');
     Route::delete('eCommerce/customer/delete/{id}','ClientController@delete')->name('e_customer.delete');

	//Sms Marketing:::::::::::::::::::
	Route::group(['as' => 'smsmerketing.','prefix' => 'smsmerketing','namespace' => 'marketing'], function () {
		Route::get('get_number/{type}','SendSmsController@get_number');
    	Route::get('get_number_list/{type}','SendSmsController@get_number_list');
    	Route::get('sms-history/datatable','SendSmsController@history_table')->name('sms_history_datatable');
    	Route::get('sms-history','SendSmsController@history')->name('sms_history');
    	Route::post('client-send-sms','SendSmsController@client_send_sms')->name('client_send_sms');
    	Route::post('transaction/sms','SendSmsController@transaction_sms')->name('transaction_sms');
		Route::resource('sendsms', 'SendSmsController');

	});

		/*::::::::::::::Depertment:::::::::*/
		Route::get('department/datatable', 'DepertmentController@datatable')->name('department.datatable');
		Route::get('department/employee/{id}','DepertmentController@new_employee')->name('depertment_new_employee');
		Route::post('department/newemployee','DepertmentController@new_employee_add')->name('depertment_new_employee_add');
		Route::delete('department/employee/delete/{id}', 'DepertmentController@employee_destroy')->name('depertment.employee.delete');
		Route::get('department/category/{id}','DepertmentController@new_category')->name('depertment_new_category');
		Route::post('depertment/newcategory','DepertmentController@new_category_add')->name('depertment_new_category_add');

		Route::delete('department/category/delete/{id}', 'DepertmentController@category_destroy')->name('depertment.category.delete');

		Route::get('depertment/approve/request/{id}','DepertmentController@approve_request')->name('department.approve_request');

		Route::resource('department', 'DepertmentController');
		//Store Request:::::::::::::::::::::::::::::::
		Route::get('request/department/{id}','StoreRequestController@request')->name('request.department');
		Route::get('request/department/store/{type}/{id}','StoreRequestController@request_form')->name('store_request.department');
		Route::get('get_product_request', 'StoreRequestController@get_requestProduct')->name('get_product_request');
	    Route::get('get_work_order_request', 'StoreRequestController@WorkOrder_request')->name('get_work_order_request');
	    Route::get('get_row_material_request', 'StoreRequestController@get_row_material_request')->name('get_row_material_request');
	    Route::get('request/product/append', 'StoreRequestController@product_append')->name('request.product_append');
		Route::get('request/material/append', 'StoreRequestController@material_append')->name('request.material_append');
		Route::get('request/row/material/append', 'StoreRequestController@row_material_append')->name('request.row_material_append');
		Route::get('request/datatable', 'StoreRequestController@datatable')->name('request.datatable');
		Route::get('request/get_prev_request','StoreRequestController@get_prev_request')->name('request.get_reques_prev');
		Route::get('depertment/flow/{id}','StoreRequestController@depertmentflow')->name('department.flow');
		Route::delete('mainrequest/destroy/{id}','StoreRequestController@request_destroy')->name('mainrequest.destroy');
		Route::get('store_request_print/{id}','StoreRequestController@store_request_print')->name('store_request_print');
		Route::match(array('GET','PUT'),'approve-all-request/{id}', 'StoreRequestController@approve_all_request')->name('approve_all_request');
		Route::resource('request', 'StoreRequestController');
		//depertment report
		Route::get('report/get-product','DepertmentReportController@get_variation_product')->name('report.get_variation_product');
		Route::get('department/report/material','DepertmentReportController@material')->name('department.material.report');
		Route::get('department/report/get-material','DepertmentReportController@get_depertment_material')->name('report.get_depertment_material');
		Route::get('get_dstore_id','DepertmentReportController@get_dstore_id');
		Route::get('every_matrial_report_print/{id}/{date?}','DepertmentReportController@every_matrial_report_print')->name('every_matrial_report_print');
		Route::get('total_matrial_report_print/{id}','DepertmentReportController@total_matrial_report_print')->name('total_matrial_report_print');
		Route::get('depertment/report/material/approve/{id}','DepertmentReportController@approve_request')->name('report.approve_request');
		Route::post('report/store-material','DepertmentReportController@material_store')->name('report.material_store');
		Route::resource('department/report', 'DepertmentReportController');
		Route::get('submit_product_report_print/{dept}/{wo}{sdate?}{edate?}','DepertmentReportController@submit_product_report_print')->name('submit_product_report_print');



	 		/*::::::::::::::user role Permission:::::::::*/
	 Route::group(['as' => 'user.', 'prefix' => 'user'], function () {
			Route::get('/role', 'RoleController@index')->name('role');
			Route::get('/role/datatable', 'RoleController@datatable')->name('role.datatable');
			Route::any('/role/create', 'RoleController@create')->name('role.create');
			Route::get('/role/edit/{id}', 'RoleController@edit')->name('role.edit');
			Route::post('/role/edit', 'RoleController@update')->name('role.update');
			Route::delete('/role/delete/{id}', 'RoleController@distroy')->name('role.delete');
			//user:::::::::::::::::::::::::::::::::
			Route::get('/', 'UserController@index')->name('index');
			Route::get('/datatable', 'UserController@datatable')->name('datatable');
			Route::any('/create', 'UserController@create')->name('create');
			Route::put('/change/{value}/{id}', 'UserController@status')->name('change');
			Route::get('/edit/{id}', 'UserController@edit')->name('edit');
			Route::put('/edit', 'UserController@update')->name('update');
			Route::delete('/delete/{id}', 'UserController@destroy')->name('delete');
		});

	 Route::group(['as' => 'sale.', 'prefix' => 'sale','namespace' => 'Sale'], function () {
	 	    Route::get('/pos/get-product-suggestion', 'SalePOsController@getProductSuggestion');
	 	    Route::get('pos/get_variation_product','SalePOsController@get_variation_product')->name('get_variation_product');
	 	    Route::get('pos/scannerappend1','SalePOsController@scannerappend1');
	 	    Route::get('pos/view/{id}','SalePOsController@view')->name('pos.view');
	 	    Route::get('pos/printpayment/{id}','SalePOsController@printpayment')->name('pos.printpayment');
	 	    Route::get('pos/print/{id}','SalePOsController@pos_print')->name('pos.print');
	 	    Route::get('pos/get-notification/{id}','SalePOsController@notification')->name('get_notification');
	 	    Route::get('pos/payment/{id}','SalePOsController@payment')->name('pos.payment');
	 	    Route::get('add','SalePOsController@sale_add')->name('add');
	 		Route::resource('pos','SalePOsController');
	 		Route::get('return/pos/{id}','SaleReturnController@return_sale')->name('return_sale');
	 		Route::get('return/printpage/{id}','SaleReturnController@printpage')->name('return.printpage');
	 		Route::resource('return','SaleReturnController');
	 		Route::get('return-check','SaleReturnController@return_check');
	 });
    //Payment
	 Route::post('sales/payment','TransactionPaymentController@sales_payment')->name('sales.payment');

	 Route::group(['as' => 'report.', 'prefix' => 'report'], function () {


          Route::get('/',function(){
          	return view('admin.report.index');
          })->name('index');

        Route::get('/',function(){
          	return view('admin.report.index');
		})->name('index');

		// Employee Report Route Start From Here
		Route::get('employee-salary-report', 'Report\EmployeeReportController@employee_salary_report')->name('employee-salary-report');
		Route::post('employee-salary-report-ajax', 'Report\EmployeeReportController@employee_salary_report_ajax')->name('employee-salary-report-ajax');
		Route::get('employee-advance-payment-report', 'Report\EmployeeReportController@employee_advance_payment_report')->name('employee-advance-payment-report');
		Route::post('employee-advance-payment-report-ajax', 'Report\EmployeeReportController@employee_advance_payment_report_ajax')->name('employee-advance-payment-report-ajax');
		Route::get('employee-advance-return-report', 'Report\EmployeeReportController@employee_advance_return_report')->name('employee-advance-return-report');
		Route::post('employee-advance-return-report-ajax', 'Report\EmployeeReportController@employee_advance_return_report_ajax')->name('employee-advance-return-report-ajax');
		Route::get('employee-other-payment-report', 'Report\EmployeeReportController@employee_other_payment_report')->name('employee-other-payment-report');
		Route::post('employee-other-payment-report-ajax', 'Report\EmployeeReportController@employee_other_payment_report_ajax')->name('employee-other-payment-report-ajax');
		Route::get('employee-report', 'Report\EmployeeReportController@employy_report')->name('employee-report');
		Route::post('employee-report-ajax', 'Report\EmployeeReportController@employyee_report_ajax')->name('employee-report-ajax');

		// Employee Report Route End Here


        Route::group(['as' => 'depertment.', 'prefix' => 'depertment','namespace' => 'Report'], function () {

           Route::get('product/report','DepertmentReportController@product_report')->name('product_report');
           Route::post('product/report','DepertmentReportController@get_product_report')->name('get_product_report');

           Route::get('raw-material/report','DepertmentReportController@raw_material_report')->name('raw_material_report');
           Route::get('get_dept_store_request','DepertmentReportController@get_dept_store_request');
           Route::post('raw-material/report','DepertmentReportController@get_rawmaterial_report')->name('get_rawmaterial_report');

           Route::get('store-material/report','DepertmentReportController@store_material_report')->name('store_material_report');
           Route::post('store-material/report','DepertmentReportController@get_storematerial_report')->name('get_storematerial_report');

           Route::get('product/report-details','DepertmentReportController@product_report_details')->name('product_report_details');
           Route::post('product/report-details','DepertmentReportController@get_product_report_details')->name('get_product_report_details');

           Route::get('raw-material/report-details','DepertmentReportController@raw_material_report_details')->name('raw_material_report_details');
           Route::post('raw-material/report-details','DepertmentReportController@get_rawmaterial_report_details')->name('get_rawmaterial_report_details');

		});

		Route::get('eCommerce-report','DepertmentReportController@ecommerce_report')->name('eCommerce-report.index');
		Route::post('eCommerce-report-date-wise','DepertmentReportController@ecommerce_report_date_wise')->name('ecommerce_report_date_wise');
	 	Route::get('eCommerce-report/pdf/{id}', 'DepertmentReportController@ecommerce_report_pdf')->name('ecommerce_report.pdf');

	 	Route::group(['as' => 'expense.', 'prefix' => 'expense','namespace' => 'Report'], function () {
           Route::get('/','ExpenseReportController@index')->name('index');
           Route::post('/','ExpenseReportController@get_expense_report')->name('get_expense_report');
           Route::get('account','ExpenseReportController@account')->name('account');
           Route::post('account','ExpenseReportController@get_expense_account_report')->name('get_expense_account_report');
	 	});

	 	Route::group(['as' => 'selling.', 'prefix' => 'selling','namespace' => 'Report'], function () {
	 		Route::get('sales','SalesReportController@index')->name('sales');
	 		Route::post('sales','SalesReportController@get_sales_report')->name('get_sales_report');
	 		Route::get('sales-payment','SalesReportController@sales_payment')->name('sales_payment');
	 		Route::post('sales-payment','SalesReportController@sales_payment_report')->name('sales_payment_report');
	 		Route::get('sales-due','SalesReportController@sales_due')->name('sales_due');
	 		Route::post('sales-due','SalesReportController@sales_due_report')->name('sales_due_report');
	 		Route::get('sale-return','SalesReportController@sale_return')->name('sale_return');
	 		Route::post('sale-return','SalesReportController@sale_return_report')->name('sale_return_report');
	 	});

	 	Route::group(['as' => 'purchasing.', 'prefix' => 'purchasing','namespace' => 'Report'], function () {
	 		Route::get('purchase','PurchaseReportController@index')->name('purchase');
	 		Route::post('purchase','PurchaseReportController@get_purchase_report')->name('get_purchase_report');
	 		Route::get('purchase-payment','PurchaseReportController@purchase_payment')->name('purchase_payment');
	 		Route::post('purchase-payment','PurchaseReportController@purchase_payment_report')->name('purchase_payment_report');
	 		Route::get('purchase-due','PurchaseReportController@purchase_due')->name('purchase_due');
	 		Route::post('purchase-due','PurchaseReportController@purchase_due_report')->name('purchase_due_report');
	 	});

	 	//product-report
	 	Route::get('product-report','Production\ProductController@product_report')->name('product_report');
	 	Route::post('product-report','Production\ProductController@product_report_print')->name('product_report_print');
	 	Route::get('purchase-sale','Report\SalesReportController@purchase_sale')->name('purchase_sale');
	 	Route::get('trail-balance','Report\SalesReportController@trail_balance')->name('trail_balance');
	 	Route::get('customer','Report\ReportController@getCustomerSuppliers')->name('getCustomerSuppliers');
	 	Route::get('monthly','Report\ReportController@monthly_report')->name('monthly_report');
	 	Route::get('yearly','Report\ReportController@yearly_report')->name('yearly_report');
	});


	  Route::group(['as' => 'accounting.', 'prefix' => 'accounting','namespace' => 'Account'], function () {
        Route::get('getAccountBalance/{id}','AccountController@getAccountBalance')->name('getAccountBalance');
        Route::get('account/getDeposit/{id}','AccountController@getDeposit')->name('account.getDeposit');
        Route::post('account/getDeposit','AccountController@postDeposit')->name('account.postDeposit');

        Route::get('account/getFundTransfer/{id}','AccountController@getFundTransfer')->name('account.getFundTransfer');
        Route::post('account/getFundtransfer','AccountController@postFundTransfer')->name('account.postFundtransfer');

        Route::delete('account/closed/{id}','AccountController@close')->name('account_closed');
        Route::get('payment/account','AccountController@payment_account')->name('payment_account');
        Route::get('getLinkAccount/{id}','AccountController@getLinkAccount')->name('getLinkAccount');
        Route::post('getLinkAccount','AccountController@postLinkAccount')->name('postLinkAccount');
        Route::get('cashflow','AccountController@cashflow')->name('cashflow');
	  	Route::resource('account','AccountController');

	  	Route::get('investment/get/{id}','InvestmentController@getInvest')->name('investment.getInvest');
	  	Route::post('investment/get','InvestmentController@postInvest')->name('investment.postInvest');
	  	Route::resource('investment','InvestmentController');
	  });

	  //Job Work:::::::::::::
	  Route::get('job-work','JobworkController@index')->name('job_work.index');
	  Route::get('job-work/create','JobworkController@create')->name('job_work');
	  Route::get('job-work/product','JobworkController@get_job_product')->name('get_job_product');
	  Route::post('job-work/product','JobworkController@job_work_post')->name('job_work_post');
	  Route::get('job-work/accept/{id}','JobworkController@edit')->name('job_work.edit');
	  Route::post('job-work/accept','JobworkController@update')->name('job_work_accept');
	  Route::get('job-work/payment/{id}','JobworkController@payment')->name('job_work.payment');
	  Route::post('job-work/payment','TransactionPaymentController@jobwork_payment')->name('job_work.post_payment');
	  Route::get('job-work/printpayment/{id}','JobworkController@printpayment')->name('job_work.printpayment');
	  Route::delete('job_work/destroy/{id}','JobworkController@destroy')->name('job_work.destroy');

	  //Paircosting:::::::::::
      Route::get('paircosting/unit','PairCostingController@material_unit');
	  Route::resource('paircosting','PairCostingController');

	});

  Route::group(['as' => 'super_admin.', 'prefix' => 'super-admin','namespace' => 'Admin'], function () {
  		Route::get('product','SuperAdminController@product')->name('product');
  		Route::get('client','SuperAdminController@client')->name('client');
  		Route::get('sells','SuperAdminController@sells')->name('sells');
  		Route::get('sell-return','SuperAdminController@sell_return')->name('sell_return');
  		Route::get('sell-return-hide/{id}','SuperAdminController@sell_return_hide')->name('sell_return_hide');
  		Route::get('purchase','SuperAdminController@purchase')->name('purchase');
  		Route::get('expense','SuperAdminController@expense')->name('expense');
  		Route::get('account','SuperAdminController@account')->name('account');
  		Route::put('hidden/{value}/{id}','SuperAdminController@hidden')->name('hidden');
  });

Route::get('/home', 'HomeController@index')->name('home');

//Tariqul Islam


});


Route::get('/contact_form_submit', 'Frontend\Front_End_Controller@contact_form_submit')->name('contact_form_submit');

Route::get('/installs', 'Install\InstallController@index');
Route::get('install/database', 'Install\InstallController@database');
Route::post('install/process_install', 'Install\InstallController@process_install');
Route::get('install/create_user', 'Install\InstallController@create_user');
Route::post('install/store_user', 'Install\InstallController@store_user');
Route::get('install/system_settings', 'Install\InstallController@system_settings');
Route::post('install/finish', 'Install\InstallController@final_touch');
