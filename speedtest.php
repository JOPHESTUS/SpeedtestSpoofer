<?php
$dow = $_POST["down"]; //Mbps . Decimal
$u = $_POST["up"] ; //Mbps . Decimal
$ping = $_POST["ping"];
$up = $u . '000';
$down = $dow . '000';
$server = $_POST["server"];
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
        'Connection: Close'
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
            print 'http://www.speedtest.net/my-result/'.urldecode($param[1]).' Speed test succesful.';
        }
    }
?>