<?php
  require_once("secrets.php");
  print "<h1>Fetching secret from AKEYLESS secret management system at akeyless.io</h1>\n";
  
  function FetchKeylessStatic($SecretName)
  {
    $token = getenv("KEYLESSUID");
    $token = $GLOBALS ["UIDKey"];
    print "using UID of $token\n";
    $url = "https://rest.akeyless-security.com/get-secret-value?name=$SecretName&token=$token";
    print "<p>calling $url</p>\n";
    $curl = curl_init();
    $curlOpt = array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_HTTPHEADER => array("accept: application/json"),);
    curl_setopt_array($curl, $curlOpt);
    $response = curl_exec($curl);
    curl_close($curl);
    
    $arrResponse = json_decode($response, TRUE);
    return $arrResponse["response"][0];
  }

  $SecretValue = FetchKeylessStatic("MyFirstSecret");
  print "<p>The secret is $SecretValue</p>\n";
?>