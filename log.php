<?php
   require_once "conn.php";     
   function logs($email, $estado, $accion) {
    global $conn;
        function getOs() {
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            $os_platform = "Unknown OS Platform";
            $os_array = array(
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
                '/iphone/i'             =>  'iPhone OS',
                '/ipod/i'               =>  'iPod OS',
                '/ipad/i'               =>  'iPad OS',
                '/android/i'            =>  'Android',
                '/blackberry/i'         =>  'BlackBerry',
                '/webos/i'              =>  'Mobile'
            );
            foreach ($os_array as $regex => $value) {
                if (preg_match($regex, $user_agent)) {
                    $os_platform = $value;
                }
            }
            return $os_platform;
        }
        $ipv4 = $_SERVER['REMOTE_ADDR'];
        $ipv4_tradicional = inet_ntop(inet_pton($ipv4));

		
		$ipv6 = $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? '';
		$browser = $_SERVER['HTTP_USER_AGENT'];
		$os = getOS();
		$status = (int) (bool)$estado; // 0 = fallido, 1 = exitoso
		date_default_timezone_set('America/Mexico_City');
         $date = date('Y-m-d H:i:s');

		$query = "INSERT INTO login_log (user, status, accion, ipv4, ipv6, date, browser, os) VALUES ('$email', '$status', '$accion', '$ipv4', '$ipv6', '$date',  '$browser', '$os')";
		mysqli_query($conn, $query);
   }

   function contador($ip, $hora){
        global $conn;
        date_default_timezone_set('America/Mexico_City');
         $date = date('Y-m-d H:i:s');
         $fechapas= date('Y-m-d H:i:s', strtotime("-$hora minute"));

         $query = "SELECT COUNT(*) as total FROM login_log WHERE ipv4= '$ip' and status=0 and date BETWEEN ' $fechapas' and '$date';";
         $result = mysqli_query($conn, $query);
         $data =mysqli_fetch_assoc($result);
         return $data['total']; 

   }
?>