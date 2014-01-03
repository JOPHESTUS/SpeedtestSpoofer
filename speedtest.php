<?php
if (isset($_POST["down"])){
$dow = $_POST["down"]; 
$down = $dow . '0';
if ($down > 999000){
$down = 999000;
$round = true;
}
} else {
$down = 5000;
}

if (isset($_POST["up"])){
$u = $_POST["up"];
$up = $u . '0';
if ($up > 999000){
$up = 999000;
$round = true;
}
} else {
$up = 5000;
}
if (isset($_POST["ping"])){
$ping = $_POST["ping"];
}  else {
$ping = 3;
}
if (isset($_POST["server"])){
$server = $_POST["server"];
} else {
$server = 2223;
}
$ip = $_SERVER['REMOTE_ADDR'];


$accuracy = 8;
$hash = md5("$ping-$up-$down-297aae72");
$headers = Array(
        'POST /api/api.php HTTP/1.1',
        'Host: www.speedtest.net',
        'User-Agent: DrWhat Speedtest',
        'Content-Type: application/x-www-form-urlencoded',
        'Origin: http://c.speedtest.net',
        'Referer: http://c.speedtest.net/flash/speedtest.swf',
        'Cookie: PLACE YOUR COOKIE HERE', // change this for history tests
        'Connection: Close',
		'X-Forwarded-For: ' .$ip,
    );
    $post = "startmode=recommendedselect&promo=&upload=$up&accuracy=$accuracy&recommendedserverid=$server&serverid=$server&ping=$ping&hash=$hash&download=$down";
    //$post = urlencode($post);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://www.speedtest.net/api/api.php');
    curl_setopt($ch, CURLOPT_ENCODING, "" );
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
    $data = curl_exec($ch);
    foreach (explode('&', $data) as $chunk) {
        $param = explode("=", $chunk);
        if (urldecode($param[0])== "resultid"){
            print ' Speed test succesful - <a href="http://www.speedtest.net/my-result/'.urldecode($param[1]).'">Link</a>';
        }
    }
	if ($round == true){
	echo("<br>A value you entered was higher than the permitted amount so it was rounded down to 999.00mbps");
	}
?>