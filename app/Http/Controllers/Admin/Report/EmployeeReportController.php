<?php

namespace App\Http\Controllers\Admin\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\employee\Employee;
use App\models\employee\PayrollTransaction;

class EmployeeReportController extends Controller
{
    // employee_salary_report
    public function employee_salary_report() {
        $employees = Employee::all();

        return view('admin.report.employee.salary.index', compact('employees'));
    }

    // employee_salary_report_ajax
    public function employee_salary_report_ajax(Request $request) {
        $employee_id = $request->employee_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if($employee_id == 'All') {
            $models = PayrollTransaction::where('head', 'Salary Payment')->where('date_of_transaction', '>=', $start_date)->where('date_of_transaction', '<=', $end_date)->get();
            $employee = 'All Employee';
        } else {
            $models = PayrollTransaction::where('head', 'Salary Payment')->where('employee_id', $employee_id)->where('date_of_transaction', '>=', $start_date)->where('date_of_transaction', '<=', $end_date)->get();
            $emp = Employee::where('id', $employee_id)->first();
            $employee = $emp->name;
        }

        return view('admin.report.employee.salary.data', compact('models', 'employee', 'start_date', 'end_date'));
    }

    // employee_advance_payment_report
    public function employee_advance_payment_report() {
        $employees = Employee::all();
        return view('admin.report.employee.advance.index', compact('employees'));
    }

    // employee_advance_payment_report_ajax
    public function employee_advance_payment_report_ajax(Request $request) {
        $employee_id = $request->employee_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if($employee_id == 'All') {
            $models = PayrollTransaction::where('head', 'Advance Payment')->where('date_of_transaction', '>=', $start_date)->where('date_of_transaction', '<=', $end_date)->get();
            $employee = 'All Employee';
        } else {
            $models = PayrollTransaction::where('head', 'Advance Payment')->where('employee_id', $employee_id)->where('date_of_transaction', '>=', $start_date)->where('date_of_transaction', '<=', $end_date)->get();
            $emp = Employee::where('id', $employee_id)->first();
            $employee = $emp->name;
        }

        return view('admin.report.employee.advance.data', compact('models', 'employee', 'start_date', 'end_date'));
    }

    // employee_advance_return_report
    public function employee_advance_return_report() {
        $employees = Employee::all();
        return view('admin.report.employee.return.index', compact('employees'));
    }

    // employee_advance_return_report_ajax
    public function employee_advance_return_report_ajax(Request $request) {
        $employee_id = $request->employee_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if($employee_id == 'All') {
            $models = PayrollTransaction::where('head', 'Advance Return')->where('date_of_transaction', '>=', $start_date)->where('date_of_transaction', '<=', $end_date)->get();
            $employee = 'All Employee';
        } else {
            $models = PayrollTransaction::where('head', 'Advance Return')->where('employee_id', $employee_id)->where('date_of_transaction', '>=', $start_date)->where('date_of_transaction', '<=', $end_date)->get();
            $emp = Employee::where('id', $employee_id)->first();
            $employee = $emp->name;
        }

        return view('admin.report.employee.return.data', compact('models', 'employee', 'start_date', 'end_date'));
    }

    // employee_other_payment_report
    public function employee_other_payment_report() {
        $employees = Employee::all();
        return view('admin.report.employee.other.index', compact('employees'));
    }

    // employee_other_payment_report_ajax
    public function employee_other_payment_report_ajax(Request $request) {
        $employee_id = $request->employee_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if($employee_id == 'All') {
            $models = PayrollTransaction::where('head', 'Other Payment')->where('date_of_transaction', '>=', $start_date)->where('date_of_transaction', '<=', $end_date)->get();
            $employee = 'All Employee';
        } else {
            $models = PayrollTransaction::where('head', 'Other Payment')->where('employee_id', $employee_id)->where('date_of_transaction', '>=', $start_date)->where('date_of_transaction', '<=', $end_date)->get();
            $emp = Employee::where('id', $employee_id)->first();
            $employee = $emp->name;
        }

        return view('admin.report.employee.other.data', compact('models', 'employee', 'start_date', 'end_date'));
    }

    // employy_report
    public function employy_report() {
        $employees = Employee::all();
        return view('admin.report.employee.employee.index', compact('employees'));
    }

    // employyee_report_ajax
    public function employyee_report_ajax(Request $request) {
        $employee_id = $request->employee_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if($employee_id == 'All') {
            $models = PayrollTransaction::where('date_of_transaction', '>=', $start_date)->where('date_of_transaction', '<=', $end_date)->get();
            $employee = 'All Employee';
        } else {
            $models = PayrollTransaction::where('employee_id', $employee_id)->where('date_of_transaction', '>=', $start_date)->where('date_of_transaction', '<=', $end_date)->get();
            $emp = Employee::where('id', $employee_id)->first();
            $employee = $emp->name;
        }

        return view('admin.report.employee.employee.data', compact('models', 'employee', 'start_date', 'end_date'));
    }
}
