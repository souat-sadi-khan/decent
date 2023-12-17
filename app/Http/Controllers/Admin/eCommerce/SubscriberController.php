<?php

namespace App\Http\Controllers\admin\eCommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\eCommerce\Subscriber;
use Yajra\DataTables\DataTables;

class SubscriberController extends Controller
{
    public function index() {
        if (!auth()->user()->can('ecommerce_subscribers.view')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.eCommerce.subscriber.index');
    }

    //datatable
    public function datatable(Request $request){
        if ($request->ajax()) {
            $document = Subscriber::orderBy('id', 'desc')->get();
            return DataTables::of($document)
                ->addIndexColumn()
                ->editColumn('email', function ($model) {
                    return $model->news_letter_email;
                })
                ->editColumn('status', function ($model) {
                    return $model->status == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">InActive</span>';
                })
                ->editColumn('action', function ($model) {
                    return view('admin.eCommerce.subscriber.action', compact('model'));
                })
                ->rawColumns(['email', 'status', 'action'])->make(true);
        }
    }

    // edit
    public function edit($id) {
        if (!auth()->user()->can('ecommerce_subscribers.update')) {
            abort(403, 'Unauthorized action.');
        }
        $model = Subscriber::findOrFail($id);
        return view('admin.eCommerce.subscriber.edit', compact('model'));
    }

    // update
    public function update(Request $request, $id) {

        if (!auth()->user()->can('ecommerce_subscribers.update')) {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'news_letter_email' => 'required|email',
            'status' => 'required'
        ]);
        $model = Subscriber::findOrFail($id);
        $model->news_letter_email = $request->news_letter_email;
        $model->status = $request->status;
        $model->save();

        return response()->json(['success' => true, 'status' => 'success', 'message' => 'Data Updated Successfully']);

    }

    // destroy
    public function destroy($id) {
        if (!auth()->user()->can('ecommerce_subscribers.delete')) {
            abort(403, 'Unauthorized action.');
        }
        $model = Subscriber::findOrFail($id);
        $model->delete();

        return response()->json(['success' => true, 'status' => 'success', 'message' => 'Data Deleted Successfully']);
    }
}
