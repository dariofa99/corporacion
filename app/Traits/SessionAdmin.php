<?php
namespace App\Traits;
/**
 * 
 */
trait SessionAdmin
{
    //$user_agent = request()->header('User-Agent');
    public function getOS($user_agent) { 
        //global $user_agent;
        $os_array =  array(
                        '/windows nt 10/i'      =>  'Windows 10',
                        '/windows nt 6.3/i'     =>  'Windows 8.1',
                        '/windows nt 6.2/i'     =>  'Windows 8',
                        '/windows nt 6.1/i'     =>  'Windows 7',
                        '/windows nt 6.0/i'     =>  'Windows Vista',
                        '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                        '/windows nt 5.1/i'     =>  'Windows XP',
                        '/windows xp/i'         =>  'Windows XP',
                        '/windows nt 5.0/i'     =>  'Windows 2000',
                        '/windows me/i'         =>  'Windows ME',
                        '/win98/i'              =>  'Windows 98',
                        '/win95/i'              =>  'Windows 95',
                        '/win16/i'              =>  'Windows 3.11',
                        '/macintosh|mac os x/i' =>  'Mac OS X',
                        '/mac_powerpc/i'        =>  'Mac OS 9',
                        '/linux/i'              =>  'Linux',
                        '/ubuntu/i'             =>  'Ubuntu',
                        '/iphone/i'             =>  'iPhone',
                        '/ipod/i'               =>  'iPod',
                        '/ipad/i'               =>  'iPad',
                        '/android/i'            =>  'Android',
                        '/blackberry/i'         =>  'BlackBerry',
                        '/webos/i'              =>  'Mobile',
                        
                      );
        //
        $os_platform = "Unknown OS Platform";
        foreach ($os_array as $regex => $value) { 
            if (preg_match($regex, $user_agent)) {
                $os_platform = $value;
            }
        }
        return $os_platform;
    }

    public function getBrowser($user_agent) {
       // global $user_agent;
        $browser_array = array(
                            '/msie/i'       =>  'Internet Explorer',
                            '/firefox/i'    =>  'Firefox',
                            '/safari/i'     =>  'Safari',
                            '/chrome/i'     =>  'Chrome',
                            '/edge/i'       =>  'Edge',
                            '/opera/i'      =>  'Opera',
                            '/netscape/i'   =>  'Netscape',
                            '/maxthon/i'    =>  'Maxthon',
                            '/konqueror/i'  =>  'Konqueror',
                            '/mobile/i'     =>  'Handheld Browser'
                          );
        $browser = "Unknown Browser";
        foreach ($browser_array as $regex => $value) { 
            if (preg_match($regex, $user_agent)) {
                $browser = $value;
            } 
        }
        return $browser;
    }

    public function getGeoLocalization($param){        
        $ip = request()->ip();
        try {
            $dataArray = (file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));
            $dataArray =  json_decode($dataArray);
            switch ($param) {
                case 'city':
                    $value = $dataArray->geoplugin_city;
                    break;
                case 'country':
                    $value = $dataArray->geoplugin_countryName;
                    break;            
                default:
                   $value = 'No se ha encontrado el parámetro';
                    break;
            } 
           
        } catch (\Throwable $th) {
            $value = 'Hay problemas con la API';
        }
        
        return $value;
    }

    public function getUserIpAddr(){
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';    
        return $ipaddress;
     }

    public function verifyToken()
    {
       
        if ( request()->token == "" ) {
            $this->tokenpc = str_replace ('/', '', bcrypt(time())); 
            $this->token_pc=$this->tokenpc;
            $this->entry_date=date('Y-m-d H:i:s');
            $this->user_id=\Auth::user()->id;
            $this->token_confirm= str_replace ('/', '', bcrypt(time()));
            //$this->save();
            //enviar correo verify token
            //return response()->json(['token'=>$tokenpc, 'fecha'=>date('Y-m-d H:i:s')]);
        } else {
            $search_session = $this->where(['user_id'=> \Auth::user()->id, 'token_pc'=>request()->token])
            ->orderBy('id','desc')->first();
            $confirmpc = 0;
            $locked = 0;
            $logout = 0;
            $token_confirm = str_replace ('/', '', bcrypt(time()));
            if ($search_session) {
                if ( $search_session->confirm == '1') {
                    //Enviar correo inicio de sesion desde equipo confirmado
                    $confirmpc = 1;
                    $token_confirm="";
                } 

                if ( $search_session->locked) {
                   
                    $locked = 1;
                    
                } 
                if ( $search_session->logout) {
                   
                    $logout = 1;
                    
                } 

            } else {

                //enviar correo verify token
    
            }

            $this->tokenpc=request()->token;            
            $this->token_pc=$this->tokenpc;
            $this->entry_date=date('Y-m-d H:i:s');
            $this->user_id=\Auth::user()->id;
            $this->confirm = $confirmpc;
            $this->token_confirm = $token_confirm;
            $this->locked = $locked;
            $this->logout = $logout;
            //$session->save();


        }
        return "";
    }
}

