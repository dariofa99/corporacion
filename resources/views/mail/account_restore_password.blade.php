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
                    Estas recibiendo este correo porque solicitaste
                    cambiar tu contraseña.<br>
                    <br>
                    Para restablecerla presiona el botón.
                </p>
            </td>
        </tr>
        <tr style="border-collapse:collapse">
            <td align="center" style="Margin:0;padding-left:10px;padding-right:10px;padding-top:35px;padding-bottom:35px">
                <span class="es-button-border"
                    style="border-style:solid;border-color:#DA4A23;background:1px;border-width:1px;display:inline-block;border-radius:2px;width:auto">
                    <a href="{{ url('/password/reset/' . $token . '/?email=' . $email) }}" class="es-button es-button-1"
                        target="_blank"
                        style="mso-style-priority:100 !important;text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;color:#FFFFFF;font-size:20px;border-style:solid;border-color:#DA4A23;border-width:15px 30px;display:inline-block;background:#DA4A23;border-radius:2px;font-family:helvetica, 'helvetica neue', arial, verdana, sans-serif;font-weight:normal;font-style:normal;line-height:24px;width:auto;text-align:center">
                        Cambiar contraseña</a>
                </span>
            </td>
        </tr>
        <tr style="border-collapse:collapse">
            <td class="es-m-txt-l" align="left"
                style="padding:0;Margin:0;padding-top:20px;padding-left:30px;padding-right:30px;text-size:15px">
                <p
                    style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:lato, 'helvetica neue', helvetica, arial, sans-serif;line-height:27px;color:#666666;font-size:18px">
                    <small> Si eso no funciona, copie y pegue el
                        siguiente enlace en su navegador:</small>
                </p>
            </td>
        </tr>
        <tr style="border-collapse:collapse">
            <td class="es-m-txt-l" align="left"
                style="padding:0;Margin:0;padding-top:20px;padding-left:30px;padding-right:30px">
                <a target="_blank" href="{{ url('/password/reset/' . $token . '/?email=' . $email) }}"
                    style="text-size:8px;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#FFA73B;font-size:18px">
                    <small>
                        {{ url('/password/reset/' . $token) }}</small></a>
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
                <p
                    style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:lato, 'helvetica neue', helvetica, arial, sans-serif;line-height:27px;color:#666666;font-size:18px">
                </p>
                <p
                    style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:lato, 'helvetica neue', helvetica, arial, sans-serif;line-height:27px;color:#666666;font-size:18px">
                    <small>Si no has sido tú, omite este mensaje.
                        <br> Corporación Ocho de Marzo
                    </small>
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
