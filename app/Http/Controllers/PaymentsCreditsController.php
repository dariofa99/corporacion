<?php

namespace App\Http\Controllers;
use App\Models\PaymentCredit;
use App\Models\CaseM;
use Illuminate\Http\Request;

class PaymentsCreditsController extends Controller
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
       // return response()->json($request->all()); 
        $paymentC = PaymentCredit::find($id);
        $paymentC->fill($request->all());
        if($request->payment_method_id==113)$paymentC->type_status_id = 110;
        //$paymentC->type_status_id = 110;
        $paymentC->save();

        $payments = $paymentC->payment->credits()->where('type_status_id','<>',110)->sum('value');
        $payment = $paymentC->payment;
        if($payments<=0){          
            $payment->type_status_id = 49;
            $payment->save();
            //return response()->json($payments);
        }
       // return response()->json($payments); 
        try {
            $response=[];
            $case = CaseM::find($paymentC->payment->case_id);
            $payment->get_total_payments = $case->getTotalPayments();
            $payment->get_balance_payments = $case->getBalancePayments();
            $response['payment'] = $payment;
            $response['render_view'] = view("content.cases.partials.ajax.case_bill",compact('case'))->render();
      
            } catch (\Throwable $th) {
            $response['error'] = $th->getMessage();
         }
        return response()->json($response); 
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
}
