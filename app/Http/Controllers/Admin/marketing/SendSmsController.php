<?php

namespace App\Http\Controllers\admin\marketing;

use App\Http\Controllers\Controller;
use App\Utilities\Sendsms;
use App\models\Client;
use App\models\Production\Brand;
use App\models\sms\Smslog;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SendSmsController extends Controller
{
   

   protected $sendsms;
   public function __construct(Sendsms $Sendsms)
    {
        $this->sendsms = $Sendsms;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

   public function get_number($type)
    {
        if ($type =='wholesale') {
           $numbers = Client::orderBy("id",'desc')->get();            
        }
        else{
          $numbers = Brand::orderBy("id",'desc')->get();   
        }
          return json_encode($numbers);
    }

   public function get_number_list($type)
    {
        if ($type =='wholesale') {
           $numbers = Client::orderBy("id",'desc')->get();            
        }
        else{
          $numbers = Brand::orderBy("id",'desc')->get();   
        }
          return json_encode($numbers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('sms_marketing.create')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.marketing.sms.sendsms');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('sms_marketing.create')) {
            abort(403, 'Unauthorized action.');
        }
        $message =$request->message;
        if ($request->sms_identifier == 'sms_number') {
          $validator = $request->validate([
            'numbers'=>'required',
            'message'=>'required',
          ]);
           $numberLists = [];
            if ($request->has('numbers')) {
                 $commaAndNew = str_replace("\r\n", ',', $request->numbers);
                 $string = array_unique(explode(",", $commaAndNew));
                  if (array_search("", $string)) {
                    $position = array_search("", $string);
                    unset($string[$position]);
                }
                $numberLists = array_diff($string, array(NULL));

                if(count($numberLists) > 0){
                    $lists = [];
                    foreach($numberLists as $number){
                        $lists[] = [
                            'number' => $number,
                            'name' => ''
                        ];
                    }
                    $numberLists = $lists;
                }

                 foreach ($numberLists as $numberList) {
                    $this->sendsms->sendsms($numberList,$message);
                }
            }
           }
            else if ($request->sms_identifier == 'group') {
                if($request->input('client_id') != ""){
                  if($request->input('client_id') == "all"){
                    foreach( $request->input('client') as $receiver_number ){
                     $this->sendsms->sendsms($receiver_number,$message);
                    }
                  }
                   else{
                    $this->sendsms->sendsms($request->client_id,$message);
                   }
                }

              if($request->input('brand_id') != ""){
                if($request->input('brand_id') == "all"){
                    foreach( $request->input('brand') as $receiver_number ){
                        $this->sendsms->sendsms($receiver_number,$message);
                    }
                }
                else{
                    $this->sendsms->sendsms($request->brand_id,$message);
                }
              }
            }

     return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Sms Send'),'load'=>true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
    public function destroy($id)
    {
        //
    }

    public function history()
    {
        return view('admin.marketing.sms.history');
    }

    public function history_table(Request $request)
    {
        if (!auth()->user()->can('sms_marketing.view')) {
            abort(403, 'Unauthorized action.');
        }
        if ($request->ajax()) {
            $document = Smslog::orderBy('id','DESC')->get();
            return DataTables::of($document)
                ->addIndexColumn()
                ->editColumn('sender',function($model){
                   return $model->user->email;
                   })
                 ->editColumn('message',function($model){
                   return $model->message;
                   })
                 ->editColumn('time',function($model){
                   return $model->created_at;
                   })
                 ->rawColumns(['sender','message','time'])->make(true);
        }
    }

    public function client_send_sms(Request $request)
    {
        if (!auth()->user()->can('sms_marketing.create')) {
            abort(403, 'Unauthorized action.');
        }
        $validator = $request->validate([
            'mobile'=>'required',
            'message'=>'required',
          ]);
        $message =$request->message;
        $this->sendsms->sendsms($request->mobile,$message);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Sms Send'),'load'=>true]);
    }

    public function transaction_sms(Request $request)
    {
        if (!auth()->user()->can('sms_marketing.create')) {
            abort(403, 'Unauthorized action.');
        }
        $validator = $request->validate([
            'mobile'=>'required',
            'message'=>'required',
          ]);
        $message =$request->message;
        $this->sendsms->sendsms($request->mobile,$message);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Sms Send')]);
    }
}
