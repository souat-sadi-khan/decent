<?php

namespace App\Http\Controllers\admin\marketing;

use App\Http\Controllers\Controller;
use App\Jobs\EmailQueueJob;
use App\Mail\SendEmailTest;
use App\models\Client;
use App\models\Production\Brand;
use App\models\email\EmailHistory;
use App\models\email\EmailTemolate;
use Illuminate\Http\Request;
use Mail;
use Yajra\DataTables\DataTables;
use App\Utilities\Overrider;

class SendMailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function get_emails($type)
    {
        if ($type =='wholesale') {
           $emails = Client::orderBy("id",'desc')->get();            
        }
        else{
          $emails = Brand::orderBy("id",'desc')->get();   
        }
          return json_encode($emails);
    }

   public function get_emails_list($type)
    {
        if ($type =='wholesale') {
           $emails = Client::orderBy("id",'desc')->get();            
        }
        else{
          $emails = Brand::orderBy("id",'desc')->get();   
        }
          return json_encode($emails);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      if (!auth()->user()->can('email_marketing.create')) {
            abort(403, 'Unauthorized action.');
        }
        $templates = EmailTemolate::pluck('name','id');
        return view('admin.marketing.email.sendmail',compact('templates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         if (!auth()->user()->can('email_marketing.create')) {
            abort(403, 'Unauthorized action.');
        }
         if ($request->email_identifier == 'emails') {
          $validator = $request->validate([
            'template'=>'required',
            'emails'=>'required',
            'subject'=>'required',
          ]);
          Overrider::load("Settings");
            $emailLists = [];
            if ($request->has('emails')) {
                $commaAndNew = str_replace("\r\n", ',', $request->emails);

                $string = array_unique(explode(",", $commaAndNew));
                if (array_search("", $string)) {
                    $position = array_search("", $string);
                    unset($string[$position]);
                }
                $emailLists = array_diff(validEmail($string), array(NULL));
                if(count($emailLists) > 0){
                    $lists = [];
                    foreach($emailLists as $email){
                        $lists[] = [
                            'email' => $email,
                            'name' => ''
                        ];
                    }
                    $emailLists = $lists;
                }

            } else {
                Session::flash('error_msg', 'Email field is required.');
                return redirect()->back()->withInput($request->only(['email_identifier']));
            }

           $emailTemplate = EmailTemolate::find($request->template)->template;
           $subject = $request->subject;

           $count_email = count($emailLists);
           foreach ($emailLists as $emailList) {
              $jobs = (new EmailQueueJob(str_replace('{USERNAME}', $emailList['name'], $emailTemplate), $emailList['email'], $subject));
                $this->dispatch($jobs);
           }

           $emailHistory = [
                'sender_id' => auth()->user()->id,
                'email_list' => json_encode($emailLists),
                'template_id' => $request->template,
                'subject' => $subject
            ];

            EmailHistory::create($emailHistory);

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Email Send'),'load'=>true]);

        }
        else if ($request->email_identifier == 'group') {
              $emailTemplate = EmailTemolate::find($request->template)->template;
              $subject = $request->subject;
            if($request->input('client_id') != ""){
                if($request->input('client_id') == "all"){
                 foreach( $request->input('client') as $receiver_email ){
                    $client_name =Client::where('email',$receiver_email)->first()->name;
                     $jobs = (new EmailQueueJob(str_replace('{USERNAME}', $client_name,$emailTemplate), $receiver_email, $subject));
                      $this->dispatch($jobs);
                  }
                     $emailHistory = [
                        'sender_id' => auth()->user()->id,
                        'email_list' => json_encode($request->input('client')),
                        'template_id' => $request->template,
                        'subject' => $subject
                    ];

                    EmailHistory::create($emailHistory);
                }
                else{
                    $client_name =Client::where('email',$request->client_id)->first()->name;
                    $jobs = (new EmailQueueJob(str_replace('{USERNAME}', $client_name,$emailTemplate), $request->client_id, $subject));
                      $this->dispatch($jobs); 

                   $emailHistory = [
                        'sender_id' => auth()->user()->id,
                        'email_list' => json_encode($request->input('client_id')),
                        'template_id' => $request->template,
                        'subject' => $subject
                    ];

                    EmailHistory::create($emailHistory);
                }
            }

            if($request->input('brand_id') != ""){
                if($request->input('brand_id') == "all"){
                 foreach( $request->input('brand') as $receiver_email ){
                    $brand_name =Brand::where('email',$receiver_email)->first()->name;
                     $jobs = (new EmailQueueJob(str_replace('{USERNAME}',$brand_name, $emailTemplate), $receiver_email, $subject));
                      $this->dispatch($jobs);
                  }

                    $emailHistory = [
                        'sender_id' => auth()->user()->id,
                        'email_list' => json_encode($request->input('brand')),
                        'template_id' => $request->template,
                        'subject' => $subject
                    ];

                    EmailHistory::create($emailHistory);
                }
                else{
                    $brand_name =Brand::where('email',$request->brand_id)->first()->name;
                    $jobs = (new EmailQueueJob(str_replace('{USERNAME}',$brand_name, $emailTemplate), $request->brand_id, $subject));
                      $this->dispatch($jobs); 

                   $emailHistory = [
                        'sender_id' => auth()->user()->id,
                        'email_list' => json_encode($request->input('brand_id')),
                        'template_id' => $request->template,
                        'subject' => $subject
                    ];

                    EmailHistory::create($emailHistory);
                }
            }
            return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Send Email'),'load'=>true]);
        }
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
         if (!auth()->user()->can('email_marketing.view')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.marketing.email.mailhistory');
    }

    public function history_table(Request $request)
    {
        if ($request->ajax()) {
            $document = EmailHistory::orderBy('id','DESC')->get();
            return DataTables::of($document)
                ->addIndexColumn()
                ->editColumn('sender',function($model){
                   return $model->user->email;
                   })
                ->editColumn('email',function($model){
                   return count(json_decode($model->email_list)). ' emails'; 
                   })
                ->editColumn('template',function($model){
                   return $model->template->name;
                   })
                 ->editColumn('subject',function($model){
                   return $model->subject;
                   })
                 ->editColumn('time',function($model){
                   return $model->created_at;
                   })
                ->addColumn('action', function ($model) {
                    return view('admin.marketing.email.action', compact('model'));
                })->rawColumns(['sender','email','template','subject','time','action'])->make(true);
        }
    }

    public function history_view($id)
    {
        if (!auth()->user()->can('email_marketing.view')) {
            abort(403, 'Unauthorized action.');
        }
        $model =EmailHistory::find($id);

        return view('admin.marketing.email.mailhistory_view',compact('model'));
    }


    public function client_send_mail(Request $request)
    {
         if (!auth()->user()->can('email_marketing.create')) {
            abort(403, 'Unauthorized action.');
        }
         $validator = $request->validate([
            'template'=>'required',
            'email'=>'required|email',
            'subject'=>'required',
          ]);
          Overrider::load("Settings");
           $subject =$request->subject; 
           $emailTemplate = EmailTemolate::find($request->template)->template;
           $client_name =Client::where('email',$request->email)->first()->name;
                    $jobs = (new EmailQueueJob(str_replace('{USERNAME}', $client_name,$emailTemplate), $request->email, $subject));
                      $this->dispatch($jobs); 

             $emailHistory = [
                'sender_id' => auth()->user()->id,
                'email_list' => json_encode($request->input('email')),
                'template_id' => $request->template,
                'subject' => $subject
            ];

           EmailHistory::create($emailHistory);

           return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Send Mail'),'load'=>true]);
    }

    public function transaction_email(Request $request)
    {
         if (!auth()->user()->can('email_marketing.create')) {
            abort(403, 'Unauthorized action.');
        }
         $validator = $request->validate([
            'template'=>'required',
            'email'=>'required|email',
            'subject'=>'required',
          ]);
           Overrider::load("Settings");
           $subject =$request->subject; 
           $emailTemplate = EmailTemolate::find($request->template)->template;
           $client_name =Client::where('email',$request->email)->first()->name;
                    $jobs = (new EmailQueueJob(str_replace('{USERNAME}', $client_name,$emailTemplate), $request->email, $subject));
                      $this->dispatch($jobs); 

             $emailHistory = [
                'sender_id' => auth()->user()->id,
                'email_list' => json_encode($request->input('email')),
                'template_id' => $request->template,
                'subject' => $subject
            ];

           EmailHistory::create($emailHistory);
           return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Send Mail')]);
    }
}
