<?php

$time = time();

$url = "https://sandbox.api.visa.com/visadirect/fundstransfer/v1/pullfundstransactions";

$certificatePath = "C:\laravel\FloodHelp\public\cert.pem";
$privateKey = "C:\laravel\FloodHelp\public\key_FloodHelp.pem";
$userId = "6WBEFSSCV4MOUY3DI5J021x1tuCI7nkudrMmopeoi4t937LPA";
$password = "rTDBzAxju3vxPEz0MEp64mAt9FwuKElM65yM";

$requestBodyString = json_encode([
  'systemsTraceAuditNumber' => 300259,
  'retrievalReferenceNumber' => '407509300259',
  'localTransactionDateTime' => '2016-03-03T10:41:27',
  'acquiringBin' => 409999,
  'acquirerCountryCode' => '101',
  'senderPrimaryAccountNumber' => '4957030100009952',
  'senderCardExpiryDate' => '2020-03',
  'senderCurrencyCode' => 'INR',
  'amount' => $fund,
  'surcharge' => '2.00',
  'cavv' => '0000010926000071934977253000000000000000',
  'foreignExchangeFeeTransaction' => '0.00',
  'businessApplicationId' => 'AA',
  'merchantCategoryCode' => 6012,
  'cardAcceptor' => [
    'name' => 'Saranya',
    'terminalId' => '365539',
    'idCode' => 'VMT200911026070',
    'address' => [
      'state' => 'CA',
      'county' => '081',
      'country' => 'USA',
      'zipCode' => '94404'
    ]
  ],
  'magneticStripeData' => [
    'track1Data' => '1010101010101010101010101010'
  ],
  'pointOfServiceData' => [
    'panEntryMode' => '90',
    'posConditionCode' => '0',
    'motoECIIndicator' => '0'
  ],
  'pointOfServiceCapability' => [
    'posTerminalType' => '4',
    'posTerminalEntryCapability' => '2'
  ],
  'feeProgramIndicator' => '123'
] );

$authString = $userId.":".$password;
$authStringBytes = utf8_encode($authString);
$authloginString = base64_encode($authStringBytes);
$authHeader = "Authorization:Basic ".$authloginString;
echo "<strong>URL:</strong><br>".$url. "<br><br>";
$header = (array("Accept: application/json", "Content-Type: application/json", $authHeader));
       
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBodyString); 
curl_setopt($ch, CURLOPT_SSLCERT, $certificatePath);
curl_setopt($ch, CURLOPT_SSLKEY, $privateKey);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//getting response from server
$response = curl_exec($ch);
if(!$response) {
    die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
}
echo "<strong>HTTP Status:</strong> <br>".curl_getinfo($ch, CURLINFO_HTTP_CODE)."<br><br>";
curl_close($ch);
$json = json_decode($response);
$json = json_encode($json, JSON_PRETTY_PRINT);
printf("<pre>%s</pre>", $json);
echo "Amount donated: " . $fund;
exit();
?>
