<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://appsdev.mueblesjamar.com.co/ComunicacionesCarteraService/api/historial/update",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{ \r\n   \"c_emp\":\"JA\",\r\n   \"token\":\"8fba6c52-fb92-4127-8dab-518089579ea4\",\r\n   \"api_key\":\"d47c29cfdf8e2456ac678c51f9e4ddfa8ec577f64e98aa9e863399f6a10210d4\",\r\n   \"data\":[\r\n      {\r\n         \"cod_uid\":\"945547DE67E600BAE0530A01558200BA\",\r\n         \"est\":\"ECM05\",\r\n         \"causal\":\"CCM08\",\r\n         \"guia\":\"prvcod01\",\r\n         \"fecha\":\"17/07/2019 000000\"\r\n      }\r\n   ]\r\n}\r\n",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: application/json",
    "postman-token: 0861fc19-1d03-3c5c-5e9c-64cec2e640a9"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}