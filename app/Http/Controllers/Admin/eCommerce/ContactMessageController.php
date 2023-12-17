<?php

namespace App\Http\Controllers\admin\eCommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\eCommerce\ContactUs;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;
use Auth;

class ContactMessageController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        if (!auth()->user()->can('ecommercce_contact_message.view')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.eCommerce.contact_message.index');
    }
    public function datatable(Request $request){
       if ($request->ajax()) {
            $document = ContactUs::where('msg_status',1)->where('name', '!=', config('system.default_role.admin'))->get();
            return DataTables::of($document)
                ->addIndexColumn()
                 ->editColumn('status', function ($model) {
                    if ($model->level_status == 'unseen') {
                        return '<span class="badge badge-danger">Not Replay</span>';
                    }else{
                        return '<span class="badge badge-success">Replay Suuccess</span>';
                    }
                })
                ->addColumn('action', function ($model) {
                    return view('admin.eCommerce.contact_message.action', compact('model'));
                })
                ->rawColumns(['action','status'])->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        if (!auth()->user()->can('ecommercce_contact_message.view')) {
            abort(403, 'Unauthorized action.');
        }
       return view('admin.eCommerce.contact_message.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        if (!auth()->user()->can('ecommercce_contact_message.view')) {
            abort(403, 'Unauthorized action.');
        }
        $data = $request->validate([
            'email' => 'required',
            'subject' => '',
            'description' => 'required',
        ]);
        $model = new ContactUs;
        $model->name = Auth::user()->name;
        $model->email = Auth::user()->email;
        $model->subject = $request->subject;
        $model->descsription = $request->descsription;
        $model->level_status ='unseen';
        $model->replay_by =Auth::user()->id;
        $model->msg_status = 0;
        $model->save();

        if ($request->row_id) {
           $success = ContactUs::findOrFail($request->row_id);
           $success->level_status = 'seen';
           $success->save();
        }
        
        Mail::to($request->email)->send(new ContactFormMail($data));
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Message Send  Successfully'), 'load'=>true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        if (!auth()->user()->can('ecommercce_contact_message.view')) {
            abort(403, 'Unauthorized action.');
        }
        $model = ContactUs::findOrFail($id);
        return view('admin.eCommerce.contact_message.show',compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        if (!auth()->user()->can('ecommercce_contact_message.view')) {
            abort(403, 'Unauthorized action.');
        }
        $model = ContactUs::findOrFail($id);
        return view('admin.eCommerce.contact_message.replay',compact('model'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        if (!auth()->user()->can('ecommercce_contact_message.view')) {
            abort(403, 'Unauthorized action.');
        }
        $type = ContactUs::findOrFail($id);
        $name = $type->name;
        $type->delete();
        activity()->log('Delete a contact Message - ' . $name);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Message Deleted Successfully'), 'load'=>true]);
    }
}
