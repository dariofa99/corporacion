<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\PaymentCredit;
use App\Models\File;
use Carbon\Carbon;
use App\Models\CaseM;

class PaymentsController extends Controller
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    public function deleteSupport(Request $request){
        $payment = Payment::find($request->payment_id);
        $file = $payment->files()->where('payment_has_files.id',$request->id)->first();
        $file->pivot->type_status_id = 15;
        $file->pivot->save();
        /* revisar el tiempo para elimiar de papelera
        if ($file and $file->path!='' and is_file(storage_path($file->path))) {
           unlink(storage_path($file->path));                   
        }
        $file->delete();
        */
        return response()->json(['status'=>200,'path'=>$file->path]);
    }

    public function insertSupport(Request $request)
    { 
        $payment = Payment::find($request->payment_id);
        if($request->file('file')!=''){
            //uploadFile(file,disk,ruta)
            $file = $payment->uploadFile($request->file('file'),'payment_files','/case_'.$payment->case_id);
            $payment->files()->attach($file,[
                'type_category_id'=>$request->type_category_id,
                'type_status_id'=>1
            ]);                 
        }        
        $response=[];
        $response['image_list'] = view('content.cases.partials.ajax.list_payments_files',compact('payment'))->render();
        return response()->json($response) ;
    }

    public function insertPaymentCredits(Request $request){
      //  return response()->json($request->all()) ;
        $payment = Payment::find($request->payment_id);
        $type_status_payment_id=50;
        $type_status_pcredit_id=111;
        if($request->type_payment_id==39){
            //si es contado
            $request['type_periodpay_id'] = 41;
            $request['num_payments'] = 1;
            $request['limit_payment_date']= date('Y-m-d');            
            if($request->payment_method_id==113){
                $type_status_payment_id=49;
                $type_status_pcredit_id=110; 
                $request['payment_date'] = date('Y-m-d');
            }           
        }else{
            $request['payment_method_id']= 114;
            $request['description_pmethod'] = 'No cuenta: 88100013080 - Banco: BANCOLOMBIA';
        }
        $days = 1;
        if($request->type_periodpay_id==41)$days = 1;
        if($request->type_periodpay_id==42)$days = 7;
        if($request->type_periodpay_id==43)$days = 15;
        if($request->type_periodpay_id==44)$days = 30;
        if($request->type_periodpay_id==45)$days = 60;
        if($request->type_periodpay_id==46)$days = 90;
        if($request->type_periodpay_id==47)$days = 180;
      
        $endDate = Carbon::parse($request->limit_payment_date);
        $pagos = intval($request->num_payments);
        while($pagos>0){
            $paymentCredit = new PaymentCredit($request->all());
            $paymentCredit->value = ceil($request->value / $request->num_payments);
            $paymentCredit->type_status_id = $type_status_pcredit_id;
            $paymentCredit->limit_payment_date = $endDate;
            $paymentCredit->save();
            $endDate = $endDate->addDays($days);
            $pagos = $pagos-1;
        }
        $payment->fill($request->all());
        $payment->type_status_id = $type_status_payment_id;

        $payment->save();
        $response=[];
     try {
        $case = CaseM::find($payment->case_id);
        $payment->get_total_payments = $case->getTotalPayments();
        $payment->get_balance_payments = $case->getBalancePayments();
         $response['payment'] = $payment;
         $response['render_view'] = view("content.cases.partials.ajax.case_bill",compact('case'))->render();
  
        } catch (\Throwable $th) {
        $response['error'] = $th->getMessage();
     }
    
   
     return response()->json($response);
    }

    public function payCredit(Request $request){
        $pcredit = PaymentCredit::find($request->credit_id);
        $pcredit->can_edit = auth()->user()->can('actualizar_pago');

        return response()->json($pcredit) ;
    }

    public function downloadFile($lgid){
        array_map('unlink', glob(public_path('temp/'.auth()->user()->id.'___*')));//elimina los archivos que el 
        $logfile= File::find($lgid)  ;
        if ($logfile) {
            $url = $logfile->path;
            $rutaDeArchivo = storage_path($url);
            $filename = auth()->user()->id.'___'.$logfile->original_name;
            copy( $rutaDeArchivo, public_path("temp/".$filename));
            return redirect("temp/".$filename); 
        }
    }
}
