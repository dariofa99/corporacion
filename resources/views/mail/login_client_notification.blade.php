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
                    Perfil {{ $user->name }} {{ $user->lastname }} a iniciado sesión en el 
                    sistema {{ config('app.name') }}.
                    <br>
                    Fecha y hora: <strong>{{$date}}</strong> 
                </p>
            </td>
        </tr>
        <tr style="border-collapse:collapse">
            <td align="center" style="Margin:0;padding-left:10px;padding-right:10px;padding-top:35px;padding-bottom:35px">
                <span class="es-button-border"
                    style="border-style:solid;border-color:#DA4A23;background:1px;border-width:1px;display:inline-block;border-radius:2px;width:auto">

                </span>
            </td>
        </tr>
        <tr style="border-collapse:collapse">
            <td class="es-m-txt-l" align="left"
                style="padding:0;Margin:0;padding-top:20px;padding-left:30px;padding-right:30px;text-size:15px">
                Ingresa al sistema para ver más sobre esta
                novedad dondo clic
                <a href="{{ url('/') }}">aquí</a>.
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

        <tr>
            <td style="padding: 5px">
                <img style="width: 100%;" src="{{ asset('dist/img/cintilla_logos.png') }}" alt="">
            </td>
        </tr>
    </table>
@endsection
