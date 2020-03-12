<?php
$api_domain = 'http://tl-api.com';

$user_id = 4290;
$api_key = '410d235140208d03c58b6a9dd3a4543b';
$model = 'lead';
$method = 'create';

$data = array(
'user_id' => $user_id,
'data' => array(
'name' => $_POST["name"],
'country' => 'IT', // ввести код страны http://kirste.userpage.fu-berlin.de/diverse/doc/ISO_3166.html
'phone' => $_POST["phone"],
'offer_id' => 1504, // ввести id офера
'sub_id' => 'dollar_adwords',
'sub_id_1' => 'maks' //ввести свой сид
)
);

$json_data = json_encode($data);

$api_url = $api_domain.'/api/'.$model.'/'.$method.'?'.http_build_query(array(
'check_sum' => sha1($json_data.$api_key)
));

$response = post_request($api_url, $json_data);
$res = json_decode($response['result']);
if ($res->{'status'} === 'ok') {
echo '<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<body style="
text-align: center;
">
<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:GcPVh9kkUSdL2dKAUcGmejPXaNwnfbS5y5XtMFsXVSTzj106cGW0Y4KF" alt="" style="
max-width: 100%;
margin-top: 5%;
">
<h1 style="
font-size: 42px;
">Grazie!</h1>

    <p style="
font-size: 24px;
margin: 0;
">Il Suo ordine è stato accettato ed è in elaborazione.</p>
<p style="
font-size: 24px;
margin: 0;
line-height: 1.2;
">In breve tempo Lei verrà contattato dal responsabile per ulteriori dettagli.</p>

</body>';
}
print_r();

function post_request( $url, $data, $headers = array() )
{
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST,true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

if( !empty($headers) ){
    $http_headers = array();

    foreach( $headers as $header_name => $header_value ){
        $http_headers[] = $header_name.': '.$header_value;
    }

    curl_setopt($ch, CURLOPT_HTTPHEADER, $http_headers);
}

$result = curl_exec($ch);

$curl_error = curl_error($ch);
$http_code  = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close ($ch);

$response = array(
    'error'    => $curl_error,
    'httpCode' => $http_code,
    'result'   => $result,
);

return $response;
}