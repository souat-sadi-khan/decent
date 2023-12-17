<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
public function run() {
		$data = [
			// user permission
			['name' => 'employee.view'],

			// employee_attendance
			['name' => 'employee_attendance.view'],
			['name' => 'employee_attendance.create'],
			['name' => 'employee_attendance.update'],
			['name' => 'employee_attendance.delete'],

			// employee_payroll
			['name' => 'employee_payroll.view'],

			// employee_payroll_transection
			['name' => 'employee_payroll_transection.view'],
			['name' => 'employee_payroll_transection.create'],
			['name' => 'employee_payroll_transection.update'],
			['name' => 'employee_payroll_transection.delete'],

			// employee_payroll_init
			['name' => 'employee_payroll_init.view'],
			['name' => 'employee_payroll_init.create'],
			['name' => 'employee_payroll_init.update'],
			['name' => 'employee_payroll_init.delete'],
			['name' => 'employee_payroll_init.print'],

			// employee_payroll_salary_structure
			['name' => 'employee_payroll_salary_structure.view'],
			['name' => 'employee_payroll_salary_structure.create'],
			['name' => 'employee_payroll_salary_structure.update'],
			['name' => 'employee_payroll_salary_structure.delete'],

			// employee_payroll_template
			['name' => 'employee_payroll_template.view'],
			['name' => 'employee_payroll_template.create'],
			['name' => 'employee_payroll_template.update'],
			['name' => 'employee_payroll_template.delete'],

			// holiday
			['name' => 'holiday.view'],
			['name' => 'holiday.create'],
			['name' => 'holiday.update'],
			['name' => 'holiday.delete'],

			// user permission
			['name' => 'user.view'],
			['name' => 'user.create'],
			['name' => 'user.update'],
			['name' => 'user.delete'],

			// Language Permission
			['name' => 'language.view'],
			['name' => 'language.create'],
			['name' => 'language.update'],
			['name' => 'language.delete'],

			// Role Permission
			['name' => 'role.view'],
			['name' => 'role.create'],
			['name' => 'role.update'],
			['name' => 'role.delete'],

			// Employee Department Permission
			['name' => 'employee_departmeent.view'],
			['name' => 'employee_departmeent.create'],
			['name' => 'employee_departmeent.update'],
			['name' => 'employee_departmeent.delete'],

			// Emplooyee Document Permission
			['name' => 'employee_document.view'],
			['name' => 'employee_document.create'],
			['name' => 'employee_document.update'],
			['name' => 'employee_document.delete'],

			// Setting Permission
			['name' => 'setting.view'],
			['name' => 'setting.update'],

			// System Configuration Permission
			['name' => 'system_configuration.view'],
			['name' => 'system_configuration.update'],

			// Mail Configuration Permission
			['name' => 'mail_configuration.view'],
			['name' => 'mail_configuration.update'],

			// SMS Configuration Permission
			['name' => 'sms_configuration.view'],
			['name' => 'sms_configuration.update'],

			// Module Configuration Permission
			['name' => 'module_configuration.view'],
			['name' => 'module_configuration.update'],

			// Database Backup Permission
			['name' => 'backup.view'],

			// Employee Catagory 
			['name' => 'employee_category.view'],
			['name' => 'employee_category.create'],
			['name' => 'employee_category.update'],
			['name' => 'employee_category.delete'],

			// Employee Shift 
			['name' => 'employee_shift.view'],
			['name' => 'employee_shift.create'],
			['name' => 'employee_shift.update'],
			['name' => 'employee_shift.delete'],

			// Employee Designation
			['name' => 'employee-designation.view'],
			['name' => 'employee-designation.create'],
			['name' => 'employee-designation.update'],
			['name' => 'employee-designation.delete'],

			// Employee Document Type
			['name' => 'employee_document_type.view'],
			['name' => 'employee_document_type.create'],
			['name' => 'employee_document_type.update'],
			['name' => 'employee_document_type.delete'],

			// Employee Leave Type
			['name' => 'employee_leave_type.view'],
			['name' => 'employee_leave_type.create'],
			['name' => 'employee_leave_type.update'],
			['name' => 'employee_leave_type.delete'],

			// Employee Leave
			['name' => 'employee_leave.view'],
			['name' => 'employee_leave.create'],
			['name' => 'employee_leave.update'],
			['name' => 'employee_leave.delete'],

			// Employee Leave Allocation
			['name' => 'employee_leave_allocation.view'],
			['name' => 'employee_leave_allocation.create'],
			['name' => 'employee_leave_allocation.update'],
			['name' => 'employee_leave_allocation.delete'],

			// Employee Leave Request
			['name' => 'employee_leave_request.view'],
			['name' => 'employee_leave_request.create'],
			['name' => 'employee_leave_request.update'],
			['name' => 'employee_leave_request.delete'],

			// Employee Attendance Type
			['name' => 'employee_attendance_type.view'],
			['name' => 'employee_attendance_type.create'],
			['name' => 'employee_attendance_type.update'],
			['name' => 'employee_attendance_type.delete'],

			// Employee ID Card 
			['name' => 'employee_id_card.view'],
			['name' => 'employee_id_card.create'],
			['name' => 'employee_id_card.update'],
			['name' => 'employee_id_card.delete'],


			//  Employee Payhead	
			['name' => 'employee_payhead.view'],
			['name' => 'employee_payhead.create'],
			['name' => 'employee_payhead.update'],
			['name' => 'employee_payhead.delete'],

			//  Employee List
			['name' => 'employee_list.view'],
			['name' => 'employee_list.create'],
			['name' => 'employee_list.update'],
			['name' => 'employee_list.delete'],
			['name' => 'employee_list.access'],

			// Document
			['name' => 'document.view'],
			['name' => 'document.create'],
			['name' => 'document.update'],
			['name' => 'document.delete'],

			// Qualification
			['name' => 'qualification.view'],
			['name' => 'qualification.create'],
			['name' => 'qualification.update'],
			['name' => 'qualification.delete'],

			// Employee Account
			['name' => 'employee_account.view'],
			['name' => 'employee_account.create'],
			['name' => 'employee_account.update'],
			['name' => 'employee_account.delete'],

			// Employee Designation
			['name' => 'designation.view'],
			['name' => 'designation.create'],
			['name' => 'designation.update'],
			['name' => 'designation.delete'],

			// Production
			['name' => 'production.view'],

			['name' => 'production_category.view'],
			['name' => 'production_category.create'],
			['name' => 'production_category.update'],
			['name' => 'production_category.delete'],

			['name' => 'production_brands.view'],
			['name' => 'production_brands.create'],
			['name' => 'production_brands.update'],
			['name' => 'production_brands.delete'],

			['name' => 'production_variation.view'],
			['name' => 'production_variation.create'],
			['name' => 'production_variation.update'],
			['name' => 'production_variation.delete'],

			['name' => 'production_ingredients.view'],
			['name' => 'production_ingredients.create'],
			['name' => 'production_ingredients.update'],
			['name' => 'production_ingredients.delete'],

			['name' => 'unit.view'],
			['name' => 'unit.create'],
			['name' => 'unit.update'],
			['name' => 'unit.delete'],

			['name' => 'raw_material.view'],
			['name' => 'raw_material.create'],
			['name' => 'raw_material.update'],
			['name' => 'raw_material.delete'],

			['name' => 'production_product.view'],
			['name' => 'production_product.create'],
			['name' => 'production_product.update'],
			['name' => 'production_product.delete'],

			['name' => 'workorder.view'],
			['name' => 'workorder.create'],
			['name' => 'workorder.update'],
			['name' => 'workorder.delete'],

			['name' => 'production_wop_materials.view'],
			['name' => 'production_wop_materials.create'],
			['name' => 'production_wop_materials.update'],
			['name' => 'production_wop_materials.delete'],

			['name' => 'purchase.view'],
			['name' => 'purchase.create'],
			['name' => 'purchase.update'],
			['name' => 'purchase.delete'],

			['name' => 'production_department.view'],
			['name' => 'production_department.create'],
			['name' => 'production_department.update'],
			['name' => 'production_department.delete'],

			['name' => 'submit_product_to_department.view'],
			['name' => 'submit_product_to_department.create'],
			['name' => 'submit_product_to_department.update'],
			['name' => 'submit_product_to_department.delete'],

			['name' => 'submit_material_to_department.view'],
			['name' => 'submit_material_to_department.create'],
			['name' => 'submit_material_to_department.update'],
			['name' => 'submit_material_to_department.delete'],

			['name' => 'job_work.view'],
			['name' => 'job_work.create'],
			['name' => 'job_work.update'],
			['name' => 'job_work.delete'],

			['name' => 'paircosting.view'],
			['name' => 'paircosting.create'],

			['name' => 'store_request.view'],
			['name' => 'store_request.create'],
			['name' => 'store_request.update'],
			['name' => 'store_request.delete'],

			['name' => 'client.view'],
			['name' => 'client.create'],
			['name' => 'client.update'],
			['name' => 'client.delete'],

			['name' => 'sale_pos.view'],
			['name' => 'sale_pos.create'],
			['name' => 'sale_pos.update'],
			['name' => 'sale_pos.delete'],

			['name' => 'transaction_payment.view'],
			['name' => 'transaction_payment.create'],
			['name' => 'transaction_payment.update'],
			['name' => 'transaction_payment.delete'],

			['name' => 'email_marketing.view'],
			['name' => 'email_marketing.create'],
			['name' => 'email_marketing.update'],
			['name' => 'email_marketing.delete'],

			['name' => 'sms_marketing.view'],
			['name' => 'sms_marketing.create'],
			['name' => 'sms_marketing.update'],
			['name' => 'sms_marketing.delete'],

			['name' => 'expense.view'],
			['name' => 'expense.create'],
			['name' => 'expense.update'],
			['name' => 'expense.delete'],

			['name' => 'report.store_department'],
			['name' => 'report.ecommerce'],
			['name' => 'report.employee'],
			['name' => 'report.expense'],
			['name' => 'report.selling'],
			['name' => 'report.purchase'],
			['name' => 'report.product'],
			['name' => 'report.purchase_sale'],
			['name' => 'report.customer'],
			['name' => 'report.trail_balance'],
			['name' => 'report.monthly'],
			['name' => 'report.yearly'],

			['name' => 'accounting.view'],
			['name' => 'accounting.create'],
			['name' => 'accounting.update'],
			['name' => 'accounting.delete'],

			//hide show

            ['name' => 'view_product.qty'],
			['name' => 'view_product.sale_price'],
			['name' => 'view_product.cost_price'],


            ['name' => 'view_sale.qty'],
			['name' => 'view_sale.sale_price'],
			['name' => 'view_sale.sale_discount'],
			['name' => 'view_sale.sale_tax'],
			['name' => 'view_sale.shipping_charge'],
			['name' => 'view_sale.sale_paid'],
			['name' => 'view_sale.sale_due'],
			['name' => 'view_sale.return_amt'],

			['name' => 'view_purchase.qty'],
			['name' => 'view_purchase.price'],
			['name' => 'view_purchase.discount'],
			['name' => 'view_purchase.tax'],
			['name' => 'view_purchase.shipping-charge'],
			['name' => 'view_purchase.paid'],
			['name' => 'view_purchase.due'],

			['name' => 'view_raw_material.price'],

			['name' => 'view_client.sale_due'],
			['name' => 'view_client.sale_return_due'],
			['name' => 'view_client.purchase_due'],

			['name' => 'view_account.credit'],
			['name' => 'view_account.debit'],
			['name' => 'view_account.balance'],

			['name' => 'view_expense.amount'],

			// Ecommerce Section Start

			['name' => 'ecommerce.view'],

			['name' => 'ecommerce_about_us.view'],

			['name' => 'ecommerce_page_banner.view'],
			['name' => 'ecommerce_page_banner.create'],
			['name' => 'ecommerce_page_banner.update'],
			['name' => 'ecommerce_page_banner.delete'],

			['name' => 'ecommercce_contact_message.view'],

			['name' => 'ecommerce_coupon.view'],
			['name' => 'ecommerce_coupon.create'],
			['name' => 'ecommerce_coupon.update'],
			['name' => 'ecommerce_coupon.delete'],

			['name' => 'ecommerce_customer.view'],
			['name' => 'ecommerce_customer.delete'],

			['name' => 'ecommerce_featured_product.view'],
			['name' => 'ecommerce_featured_product.create'],

			['name' => 'ecommerce_hot_sale_product.view'],
			['name' => 'ecommerce_hot_sale_product.create'],

			['name' => 'ecommerce_offer.view'],
			['name' => 'ecommerce_offer.create'],
			['name' => 'ecommerce_offer.update'],
			['name' => 'ecommerce_offer.delete'],

			['name' => 'ecommerce_order.view'],
			['name' => 'ecommerce_order.update'],

			['name' => 'ecommerce_our_team.view'],
			['name' => 'ecommerce_our_team.create'],
			['name' => 'ecommerce_our_team.update'],
			['name' => 'ecommerce_our_team.delete'],

			['name' => 'ecommerce_our_workspace.view'],
			['name' => 'ecommerce_our_workspace.create'],
			['name' => 'ecommerce_our_workspace.update'],
			['name' => 'ecommerce_our_workspace.delete'],

			['name' => 'ecommerce_product_rating.view'],
			['name' => 'ecommerce_product_rating.update'],
			['name' => 'ecommerce_product_rating.delete'],

			['name' => 'ecommerce_privecy_policy.view'],

			['name' => 'ecommerce_qurier.view'],
			['name' => 'ecommerce_qurier.create'],
			['name' => 'ecommerce_qurier.update'],
			['name' => 'ecommerce_qurier.delete'],

			['name' => 'ecommerce_seo.view'],

			['name' => 'ecommerce_shiping_charge.view'],
			['name' => 'ecommerce_shiping_charge.create'],
			['name' => 'ecommerce_shiping_charge.update'],
			['name' => 'ecommerce_shiping_charge.delete'],

			['name' => 'ecommerce_special_category.view'],
			['name' => 'ecommerce_special_category.create'],
			['name' => 'ecommerce_special_category.update'],
			['name' => 'ecommerce_special_category.delete'],

			['name' => 'ecommerce_special_offer.view'],
			['name' => 'ecommerce_special_offer.create'],
			['name' => 'ecommerce_special_offer.delete'],

			['name' => 'ecommerce_stock.view'],

			['name' => 'ecommerce_subscribers.view'],
			['name' => 'ecommerce_subscribers.update'],
			['name' => 'ecommerce_subscribers.delete'],

			['bane' => 'ecommerce_subscribers.view'],

			['name' => 'ecommerce_terms_and_condition.view'],

			['name' => 'ecommerce_whole_sale.view'],

		];

		$insert_data = [];
		$time_stamp = Carbon::now();
		foreach ($data as $d) {
			$d['guard_name'] = 'web';
			$d['created_at'] = $time_stamp;
			$insert_data[] = $d;
		}
		Permission::insert($insert_data);
	}
}
