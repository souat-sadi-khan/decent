<?php

// Home

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('home'));
});

// Home > Settings
Breadcrumbs::for('settings', function ($trail) {
    $trail->parent('home');
    $trail->push('Settings', route('admin.setting'));
});

// Home > System Configuration
Breadcrumbs::for('system-settings', function ($trail) {
    $trail->parent('home');
    $trail->push('System Configuration', route('admin.system.setting'));
});

// Home > mail Configuration
Breadcrumbs::for('mail-settings', function ($trail) {
    $trail->parent('home');
    $trail->push('Mail Configuration', route('admin.mail.setting'));
});

// Home > sms Configuration
Breadcrumbs::for('sms-settings', function ($trail) {
    $trail->parent('home');
    $trail->push('SMS Configuration', route('admin.sms.setting'));
});

// Home > Module Configuration
Breadcrumbs::for('module-settings', function ($trail) {
    $trail->parent('home');
    $trail->push('Module Configuration', route('admin.module.setting'));
});

// Home > Employee Id Card
Breadcrumbs::for('employee-id-card', function ($trail) {
    $trail->parent('home');
    $trail->push('Employee Id Card', route('admin.id-card-template'));
});


// Employee Section

// Home > Employee Department
Breadcrumbs::for('employee-department', function ($trail) {
    $trail->parent('home');
    $trail->push('Employee Department', route('admin.employee.department.index'));
});
// Home > Employee Document Type
Breadcrumbs::for('employee-document-type', function ($trail) {
    $trail->parent('home');
    $trail->push('Employee Document Type', route('admin.employee-document-type.index'));
});

// Home > Employee Category
Breadcrumbs::for('employee-category', function ($trail) {
    $trail->parent('home');
    $trail->push('Employee Category', route('admin.employee-category.index'));
});

// Home > eCommerce Order List
Breadcrumbs::for('ecommerce-ordeer-list', function ($trail) {
    $trail->parent('home');
    $trail->push('eCommerce-Order-List', route('admin.eCommerce.order.index'));
});

// Home > Employee Shift
Breadcrumbs::for('employee-shift', function ($trail) {
    $trail->parent('home');
    $trail->push('Employee Shift', route('admin.employee-shift.index'));
});

// Home > Employee Category
Breadcrumbs::for('employee-attendance-type', function ($trail) {
    $trail->parent('home');
    $trail->push('Employee Attendance Type', route('admin.attendance-attendance-type.index'));
});

// Home > Employee leave
Breadcrumbs::for('employee-leave', function ($trail) {
    $trail->parent('home');
    $trail->push('Employee Leave', route('admin.employee-leave.view'));
});

// Home > Employee payroll
Breadcrumbs::for('employee-payroll', function ($trail) {
    $trail->parent('home');
    $trail->push('Employee Payroll', route('admin.payroll.view'));
});

// Home > Employee payroll template
Breadcrumbs::for('employee-payroll-template', function ($trail) {
    $trail->parent('employee-payroll');
    $trail->push('Template', route('admin.payroll-template.index'));
});

// Home > Employee payroll Iniatitalization
Breadcrumbs::for('employee-payroll-init', function ($trail) {
    $trail->parent('employee-payroll');
    $trail->push('Init', route('admin.payroll-initialize.index'));
});

// Home > Employee payroll Transection
Breadcrumbs::for('employee-payroll-transection', function ($trail) {
    $trail->parent('employee-payroll');
    $trail->push('Transection', route('admin.payroll-transection.index'));
});

// Home > Calender > Holiday
Breadcrumbs::for('holiday', function ($trail) {
    $trail->parent('home');
    $trail->push('Holiday Information', route('admin.holiday.index'));
});

// Home > Employee payroll Salary Structure
Breadcrumbs::for('employee-payroll-salary-structure', function ($trail) {
    $trail->parent('employee-payroll');
    $trail->push('Salary Structure', route('admin.payroll-s-structure.index'));
});

// Home > Employee leave allocation
Breadcrumbs::for('employee-leave-allocation', function ($trail) {
    $trail->parent('employee-leave');
    $trail->push('Allocation', route('admin.employee-leave-allocation.index'));
});

// Home > Employee leave Request
Breadcrumbs::for('employee-leave-request', function ($trail) {
    $trail->parent('employee-leave');
    $trail->push('Request', route('admin.employee-leave-request.index'));
});

// Home > Employee leave type
Breadcrumbs::for('employee-leave-type', function ($trail) {
    $trail->parent('home');
    $trail->push('Employee Leave Type', route('admin.employee-leave-type.index'));
});

// Home > Employee Pay Head
Breadcrumbs::for('employee-pay-head', function ($trail) {
    $trail->parent('home');
    $trail->push('Employee Pay Head', route('admin.employee-pay-head.index'));
});

// Home > Designation
Breadcrumbs::for('designation', function ($trail) {
    $trail->parent('home');
    $trail->push('Designation', route('admin.designation.index'));
});
// Home > Employee list
Breadcrumbs::for('employee-list', function ($trail) {
    $trail->parent('home');
    $trail->push('Employee Designation', route('admin.employee-list.index'));
});

// Home > Language
Breadcrumbs::for('language', function ($trail) {
    $trail->parent('home');
    $trail->push('Language', route('admin.language'));
});

// Home > Language > Translate
Breadcrumbs::for('language/edit', function ($trail) {
    $trail->parent('home');
    $trail->push('Language', route('admin.language'));
    $trail->push('Translate', route('admin.language.edit'));
});

// Home > Roles & Permission
Breadcrumbs::for('role', function ($trail) {
    $trail->parent('home');
    $trail->push('Roles & Permission', route('admin.user.role'));
});

// Home > Roles & Permission > Create
Breadcrumbs::for('role/create', function ($trail) {
    $trail->parent('home');
    $trail->push('Roles & Permission', route('admin.user.role'));
    $trail->push('Create', route('admin.user.role.create'));
});

// Home > Roles & Permission > Edit
Breadcrumbs::for('role/edit', function ($trail, $id) {
    $trail->parent('home');
    $trail->push('Roles & Permission', route('admin.user.role'));
    $trail->push('Edit', route('admin.user.role.edit', $id));
});

// Home > User
Breadcrumbs::for('/', function ($trail) {
    $trail->parent('home');
    $trail->push('Users', route('admin.user.index'));
});

// Home > User > Create
Breadcrumbs::for('/create', function ($trail) {
    $trail->parent('home');
    $trail->push('Users', route('admin.user.index'));
    $trail->push('Create', route('admin.user.create'));
});

// Home > User > Edit
Breadcrumbs::for('/edit', function ($trail, $id) {
    $trail->parent('home');
    $trail->push('Users', route('admin.user.index'));
    $trail->push('Edit', route('admin.user.edit', $id));
});

// Home > Employee List > Employee Details
Breadcrumbs::for('/employee-details', function ($trail, $id) {
    $trail->parent('home');
    $trail->push('Employee List', route('admin.employee-list.index'));
    $trail->push('Employee Details Information', route('admin.employee-list.edit', $id));
});

// // Home > Blog
// Breadcrumbs::for('blog', function ($trail) {
//     $trail->parent('home');
//     $trail->push('Blog', route('blog'));
// });

// Recycle Bin Start

// Trash Home
Breadcrumbs::for('trash', function ($trail) {
    $trail->push('Recycle Bin Home', route('admin.trash.index'));
});

// Home > Trash Employee Catagory
Breadcrumbs::for('trash-employee-category', function($trail) {
    $trail->parent('trash');
    $trail->push('Trash Employee Category', route('admin.trash.employee-category'));
});

// Home > Trash Employee Department
Breadcrumbs::for('trash-employee-department', function($trail) {
    $trail->parent('trash');
    $trail->push('Trash Employee Department', route('admin.trash.employee.department'));
});

// Home > Trash Employee Document Type
Breadcrumbs::for('trash-employee-document-type', function($trail) {
    $trail->parent('trash');
    $trail->push('Trash Employee Document Type', route('admin.trash.employee.document.type'));
});

// Home > Trash Employee Leave Type
Breadcrumbs::for('trash-employee-leave-type', function($trail) {
    $trail->parent('trash');
    $trail->push('Trash Employee leave Type', route('admin.trash.employee.leave.type'));
});

// Home > Trash Employee Pay Head
Breadcrumbs::for('trash-employee-pay-head', function($trail) {
    $trail->parent('trash');
    $trail->push('Trash Employee Pay Head', route('admin.trash.employee.payhead'));
});

// Member Setting Home
Breadcrumbs::for('member_setting', function ($trail) {
    $trail->push('Member Setting Home', route('admin.member-setting'));
});

// Member Home > Nationality
Breadcrumbs::for('setting_member_nationality', function($trail) {
    $trail->parent('member_setting');
    $trail->push('Nationality', route('admin.setting.member-setting.nationality'));
});

// Member Home > Religious
Breadcrumbs::for('setting_member_religious', function($trail) {
    $trail->parent('member_setting');
    $trail->push('Religious', route('admin.setting.member-setting.religious'));
});

// Member Home > Occupation
Breadcrumbs::for('setting_member_occupation', function($trail) {
    $trail->parent('member_setting');
    $trail->push('Occupation', route('admin.setting.member-setting.occupation'));
});

// Home > Production Category
Breadcrumbs::for('production-category', function ($trail) {
    $trail->parent('home');
    $trail->push('Production Category', route('admin.production-category.index'));
});

// Home > Production Brands
Breadcrumbs::for('production-brands', function ($trail) {
    $trail->parent('home');
    $trail->push('Production Brands', route('admin.production-brands.index'));
});

// Home > Ingredients Category
Breadcrumbs::for('production-ingredients-category', function ($trail) {
    $trail->parent('home');
    $trail->push('Ingredients Category', route('admin.production-ingredients-category.index'));
});

// Home > Product
Breadcrumbs::for('production-product', function ($trail) {
    $trail->parent('home');
    $trail->push('Product', route('admin.production-product.index'));
});

// Home > Product
Breadcrumbs::for('product-create', function ($trail) {
    $trail->parent('production-product');
    $trail->push('Create', route('admin.production-product.create'));
});

// Home > Product
Breadcrumbs::for('product-edit', function ($trail) {
    $trail->parent('production-product');
    $trail->push('Edit', route('admin.production-product.index'));
});

// Home > Product
Breadcrumbs::for('product-details', function ($trail) {
    $trail->parent('production-product');
    $trail->push('Details', route('admin.production-product.index'));
});

// Home > Product
Breadcrumbs::for('product-view', function ($trail) {
    $trail->parent('production-product');
    $trail->push('View', route('admin.production-product.index'));
});

// Home > Product
Breadcrumbs::for('production-raw-materials', function ($trail) {
    $trail->parent('home');
    $trail->push('Raw Materials', route('admin.production-raw-materials.index'));
});
// Home > Production unit
Breadcrumbs::for('production-unit', function ($trail) {
    $trail->parent('home');
    $trail->push('Production Unit', route('admin.production-unit.index'));
});
// Home > Production work order
Breadcrumbs::for('production-work-order', function ($trail) {
    $trail->parent('home');
    $trail->push('Production Work Order', route('admin.production-work-order.index'));
});

// Home > Production Variation Template
Breadcrumbs::for('production-variation', function ($trail) {
    $trail->parent('home');
    $trail->push('Production Variation Template', route('admin.production-variation.index'));
});


// Home > Production WOP Materials
Breadcrumbs::for('wop-materials', function ($trail) {
    $trail->parent('home');
    $trail->push('WOP Materials', route('admin.production-wop-materials.index'));
});

// Home > Production WOP Materials Create
Breadcrumbs::for('wop-materials-create', function ($trail) {
    $trail->parent('wop-materials');
    $trail->push('Create', route('admin.production-wop-materials.create'));
});

// Home > Production WOP Materials Edit
Breadcrumbs::for('wop-materials-edit', function ($trail) {
    $trail->parent('wop-materials');
    $trail->push('Edit', route('admin.production-wop-materials.index'));
});
// Home > Production WOP Materials Show
Breadcrumbs::for('wop-materials-show', function ($trail) {
    $trail->parent('wop-materials');
    $trail->push('Show', route('admin.production-wop-materials.index'));
});

// Home > Work Order for production
Breadcrumbs::for('work-order-create', function ($trail) {
    $trail->parent('production-work-order');
    $trail->push('Create', route('admin.production-work-order.create'));
});
// Home > Work Order for production
Breadcrumbs::for('work-order-edit', function ($trail) {
    $trail->parent('production-work-order');
    $trail->push('Edit', route('admin.production-work-order.index'));
});
// Home > Work Order for production
Breadcrumbs::for('work-order-view', function ($trail) {
    $trail->parent('production-work-order');
    $trail->push('View', route('admin.production-work-order.index'));
});


// Home > Production Purchase
Breadcrumbs::for('purchase', function ($trail) {
    $trail->parent('home');
    $trail->push('Purchase', route('admin.production-purchase.index'));
});

// Home > Production Purchase Create
Breadcrumbs::for('purchase-create', function ($trail) {
    $trail->parent('purchase');
    $trail->push('Create', route('admin.production-purchase.create'));
});

// Home > Production Purchase Create
Breadcrumbs::for('purchase-details', function ($trail) {
    $trail->parent('purchase');
    $trail->push('Create', route('admin.production-purchase.index'));
});


// Home > eCommerce Our Team
Breadcrumbs::for('eCommerce.our-team', function ($trail) {
    $trail->parent('home');
    $trail->push('Our Team', route('admin.eCommerce.our-team.index'));
});

// Home > eCommerce Our Team
Breadcrumbs::for('our-team-create', function ($trail) {
    $trail->parent('eCommerce.our-team');
    $trail->push('Create', route('admin.eCommerce.our-team.index'));
});
// Home > eCommerce Our Team
Breadcrumbs::for('our-team-edit', function ($trail) {
    $trail->parent('eCommerce.our-team');
    $trail->push('Our Team Edit', route('admin.eCommerce.our-team.index'));
});
// Home > eCommerce Our workspace
Breadcrumbs::for('eCommerce.our-worksapce', function ($trail) {
    $trail->parent('home');
    $trail->push('Our Workspace', route('admin.eCommerce.our-workspace.index'));
});

// Home > eCommerce Our workspace
Breadcrumbs::for('our-workspace-create', function ($trail) {
    $trail->parent('eCommerce.our-worksapce');
    $trail->push('Workspace Create', route('admin.eCommerce.our-workspace.create'));
});

// Home > eCommerce Contact Message
Breadcrumbs::for('eCommerce.contact-msg', function ($trail) {
    $trail->parent('home');
    $trail->push('Contact Message', route('admin.eCommerce.contact-msg.index'));
});
// Home > Employee Attendance
Breadcrumbs::for('employee-attendance', function ($trail) {
    $trail->parent('home');
    $trail->push('Employee Attendance', route('admin.attendance-employee-attendance.index'));
});

// Home > Employee Attendance Create
Breadcrumbs::for('employee-attendance-create', function ($trail) {
    $trail->parent('employee-attendance');
    $trail->push('Create', route('admin.attendance-employee-attendance.create'));
});

// Home > Product Coupon Code
Breadcrumbs::for('product-coupons', function ($trail) {
    $trail->parent('home');
    $trail->push('Product Coupons', route('admin.eCommerce.coupons.index'));
});
// Home > Product shipping charge
Breadcrumbs::for('shipping-charge', function ($trail) {
    $trail->parent('home');
    $trail->push('shipping charge', route('admin.eCommerce.shipping-charge.index'));
});

// Home > Product shipping charge
Breadcrumbs::for('slider', function ($trail) {
    $trail->parent('home');
    $trail->push('Slider', route('admin.eCommerce.slider.index'));
});


// Home > Home Page Image
Breadcrumbs::for('eCommerce.home-page', function ($trail) {
    $trail->parent('home');
    $trail->push('Page Image', route('admin.eCommerce.home-page.index'));
});

// Home > Home Page Image Create
Breadcrumbs::for('home-page-create', function ($trail) {
    $trail->parent('eCommerce.home-page');
    $trail->push('Page Image', route('admin.eCommerce.home-page.create'));
});
// Home > Home Page Image Create
Breadcrumbs::for('home-page-edit', function ($trail) {
    $trail->parent('eCommerce.home-page');
    $trail->push('Page Image', route('admin.eCommerce.home-page.index'));
});