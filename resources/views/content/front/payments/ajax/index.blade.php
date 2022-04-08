   @foreach (session('session_case')->payments()->where('type_status_id','<>',15)
   ->where('shared',1)->orderBy('created_at','desc')->get() as $payment)
       

            <tr>
              <td>
               {{getDateForNotification($payment->created_at)}}
              </td>
              <td>
               {{$payment->category->name}}
              </td>
              <td>
                {{$payment->concept}}
              </td>
              <td>
                {{$payment->type_payment->name}}
              </td>
              <td>
                 {{number_format($payment->value)}}
              </td>
              <td>
                <span style="display:block" class="badge badge-pill 
                     badge-{{$payment->getColorStatus()}}">
                 {{$payment->status->name}}</span>         
             </td>

    
             <td></td>
              <td width="20%">
              
              
              <button class="btn btn-primary btn-sm btn_edit_bill" data-id="{{$payment->id}}">Detalles</button>
             
              </td>
             </tr>

            @if(count($payment->credits)>0 and ($payment->type_payment_id==40 || $payment->type_status_id!=49))
            <tr >
            <td style='padding: 8px;'>
            </td>
            <td style='padding: 8px;'>
              <b>Cuota</b>
            </td>
            <td colspan='2' style='padding: 8px;'>
              <b>Fecha limite</b>
            </td>
            <td style='padding: 8px;'>
              <b>Valor a pagar</b>
            </td>

            <td  style='padding: 8px;'>
              <b>Estado del pago</b>
            </td>
            <td style='padding: 8px;'>
            
            </td>
            <td style='padding: 8px;'>
            
            </td>
            </tr>
              @foreach ($payment->credits as $key=>$credit)
                  <tr>
                  <td style='padding: 8px;'>
                  </td>
                  <td style='padding: 8px;'>
                    {{ $key+1 }}
                  </td>
                  <td colspan='2' style='padding: 8px;'>
                  {{$credit->limit_payment_date}}  
                  </td> 
                  <td style='padding: 8px;'>
                  {{number_format($credit->value)}}
                  </td>
  
                  <td  style='padding: 8px;'>
                  <span style="display:block;" class="badge badge-pill 
                     badge-{{$credit->getColorStatus()}}">
                
                   {{$credit->status->name}}</span>
                  </td>
                  <td style='padding: 8px;'>
            
                   </td>

                  <td  style='padding: 8px;'> 
                 @if($credit->status->id==111)
                  
<button class="btn btn-sm {{$credit->status->id == 116 ? 'btn-success':'btn-primary'}} btn_pay_credit" data-id="{{$credit->id}}">
                  {{$credit->status->id == 116 ? 'Confirmar pago':'Detalles'}}</button>              
                 @endif
@if($credit->status->id!=110)
                  <button class="btn btn-sm {{$credit->status->id == 116 ? 'btn-default':'btn-success btn_up_pay_support'}} " data-id="{{$credit->id}}">
                  {{$credit->status->id == 116 ? 'Por confirmar pago':'Subir evidencia'}}</button>              
         @endif 
                               
                  </td>
                  </tr>
              @endforeach
             @endif 
             
@endforeach