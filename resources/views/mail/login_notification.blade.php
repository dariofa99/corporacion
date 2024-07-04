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

                    Se ha detectado un inicio de sesión desde un equipo
                    @if ($session->locked)
                        registrado como
                        <strong> BLOQUEADO</strong>
                        @if ($session->confirm)
                            y <strong> CONFIRMADO</strong>
                        @endif
                    @elseif($session->confirm)
                        registrado como <strong>SEGURO</strong>
                        @if ($session->logout)
                            y con la<strong> SESIÓN CERRADA</strong>
                        @endif
                    @else
                        sin confirmar @if ($session->logout)
                            y con la<strong> SESIÓN CERRADA</strong>
                        @endif
                    @endif
                    en tu cuenta de {{ config('app.name') }}.<br>

                    Fecha y hora: {{ $data['time'] }}<br>
                    Lugar: {{ $data['city'] != '' ? $data['city'] . ',' : '' }} {{ $data['country'] }}<br>
                    Navegador: {{ $data['browser'] }}<br>
                    Sistema Operativo: {{ $data['os'] }}<br>

                    @if ($session->locked)
                        Si<strong> NO has sido tú</strong> y crees que hay problemas de seguridad, te recomedamos cambiar la
                        contraseña.</strong>
                        {{-- <strong> SI has sido tú</strong> y quieres <strong> DESBLOQUEAR EL EQUIPO</strong> , dar clic en el siguiente <a target="_blank" href="{{url('/token/admin/session/'.$session->token_confirm.'/unlocked')}}">enlace</a> para bloquear el equipo.<br>
 --}}
                    @elseif(!$session->confirm and !$session->logout)
                        Para confirmar como un equipo seguro, dar clic en el siguiente <a target="_blank"
                            href=" {{ url('/token/admin/session/' . $session->token_confirm . '/confirm') }}">enlace. </a> <br>
                        Si <strong>NO</strong> has sido tú, dar clic en el siguiente <a target="_blank"
                            href="{{ url('/token/admin/session/' . $session->token_confirm . '/locked') }}">enlace</a> para
                        bloquear el equipo.<br>
                        Si solamente quieres <strong>CERRAR LA SESIÓN</strong>, da clic en el siguiente <a target="_blank"
                            href="{{ url('/token/admin/session/' . $session->token_confirm . '/logout') }}">enlace</a>.
                    @elseif($session->logout)
                        Para confirmar como un equipo seguro y habilitar nuevamente la sesión, dar clic en el siguiente <a
                            target="_blank"
                            href=" {{ url('/token/admin/session/' . $session->token_confirm . '/unconfirmed') }}">enlace. </a>
                        <br>
                    @endif
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
