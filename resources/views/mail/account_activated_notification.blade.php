@extends('mail.layout.main')

@section('content')
    <table
        style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:separate;border-spacing:0px;border-radius:4px;background-color:#ffffff"
        width="100%" cellspacing="0" cellpadding="0" bgcolor="#ffffff" role="presentation">
        <tr style="border-collapse:collapse">
            <td class="es-m-txt-l" bgcolor="#ffffff" align="justify"
                style="Margin:0;padding-top:20px;padding-bottom:20px;padding-left:30px;padding-right:30px">
                <p
                    style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:lato, 'helvetica neue', helvetica, arial, sans-serif;line-height:27px;color:#666666;font-size:18px">
                    Se ha activado tu cuenta en el sistema {{config("app.name")}}.<br>
                     <br>
                    Para ingresar da clic en el enlace: <a href="{{url('/')}}">{{url('/')}}</a>
                    
                  <br>
                  Nombre de perfil: {{$user->email}}
                </p>
            </td>
        </tr>
        
        <tr style="border-collapse:collapse">
            <td class="es-m-txt-l" align="left"
                style="padding:0;Margin:0;padding-top:20px;padding-left:30px;padding-right:30px;text-size:15px">
                
            </td>
        </tr>
        <tr style="border-collapse:collapse">
            <td class="es-m-txt-l" align="left"
                style="padding:0;Margin:0;padding-top:20px;padding-left:30px;padding-right:30px">
                
            </td>
        </tr>
        <tr style="border-collapse:collapse">
            <td class="es-m-txt-l" align="left"
                style="padding:0;Margin:0;padding-top:20px;padding-left:30px;padding-right:30px">
                <p
                    style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:lato, 'helvetica neue', helvetica, arial, sans-serif;line-height:27px;color:#666666;font-size:18px">

                </p>
            </td>
        </tr>
        <tr style="border-collapse:collapse">
            <td class="es-m-txt-l" align="left"
                style="Margin:0;padding-top:20px;padding-left:30px;padding-right:30px;padding-bottom:40px">
              
            </td>
        </tr>
        <tr>
            <td style="padding: 5px">
                <img style="width: 100%;" src="{{ asset('dist/img/cintilla_logos.png') }}" alt="">
            </td>
        </tr>
    </table>
@endsection
