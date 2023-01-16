   @foreach ($case->payments()->orderBy('created_at','desc')
   ->where('type_status_id','<>',15)->get() as $payment)
       

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

    
              <td>
                 <span style="display:block" class="badge badge-pill 
                      badge-{{$payment->shared ? 'success' : 'danger'}}">
                 {{$payment->shared ? 'SI' : 'NO'}}</span>         
              </td>
              <td width="20%">
              
              
              <button class="btn btn-primary btn-sm btn_edit_bill" data-id="{{$payment->id}}">Editar</button>
              <button class="btn btn-danger btn-sm btn_delete_bill" data-id="{{$payment->id}}">Eliminar</button>
             {{--  <button class="btn btn-warning btn-sm btn_dtfact_bill" data-id="{{$payment->id}}">Factura y pago</button>
              --}} 
              </td>
             </tr>

            @if(count($payment->credits)>0)
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
                  @if($credit->status->id!=110)
                  <button class="btn btn-sm {{$credit->status->id == 116 ? 'btn-success btn_confirm_pay_credit':'btn-primary btn_pay_credit'}} " data-id="{{$credit->id}}">
                  {{$credit->status->id == 116 ? 'Confirmar pago':'Editar'}}</button> 
                  @endif
                               
                  </td>
                  </tr>
              @endforeach
             @endif 
             
@endforeach