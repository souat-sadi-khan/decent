<?php

namespace App\Http\Controllers\Admin\eCommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Qurier;
use Yajra\DataTables\DataTables;

class QurierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('ecommerce_qurier.view')) {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.eCommerce.qurier.index');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $document = Qurier::where('name', '!=', config('system.default_role.admin'))->get();

            return DataTables::of($document)
                ->addIndexColumn()
                ->editColumn('status', function ($document) {
                    return $document->status == 1 ? '<span class="badge badge-primary">Active</span>' : '<span class="badge badge-warning">Inactive</span>';
                })
                ->addColumn('action', function ($model) {
                    return view('admin.eCommerce.qurier.action', compact('model'));
            })->rawColumns(['action', 'status'])->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('ecommerce_qurier.create')) {
            abort(403, 'Unauthorized action.');
        }

        $model = new Qurier;
        return view('admin.eCommerce.qurier.create', compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('ecommerce_qurier.create')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name'          =>      'required|min:3|max:50',
            'status'        =>      'required|max:255',
            'phone'    =>      'required',
            'address'      =>      'required',
        ]);

        $model = new Qurier();
        $model->name = $request->name;
        $model->status = $request->status;
        $model->phone = $request->phone;
        $model->address = $request->address;
        $model->save();

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Created')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!auth()->user()->can('ecommerce_qurier.update')) {
            abort(403, 'Unauthorized action.');
        }
        $model = Qurier::findOrFail($id);
        return view('admin.eCommerce.qurier.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!auth()->user()->can('ecommerce_qurier.update')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name'          =>      'required|min:3|max:50',
            'status'        =>      'required|max:255',
            'phone'    =>      'required',
            'address'      =>      'required',
        ]);

        $model = Qurier::findOrFail($id);
        $model->name = $request->name;
        $model->status = $request->status;
        $model->phone = $request->phone;
        $model->address = $request->address;
        $model->save();

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('ecommerce_qurier.delete')) {
            abort(403, 'Unauthorized action.');
        }

        $model = Qurier::findOrFail($id);
        $model->delete();

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Deleted')]);
    }
}
