<?php
  function FetchKeylessStatic_old($arrNames)
  {
    # $arrNames is an array of the secret names to be fetched
    # Returns an associated array with the secret name as key and the secret as the value
    # Requires AccessID and Accesskey as environment variables
    $AccessID = getenv("KEYLESSID");
    $AccessKey = getenv("KEYLESSKEY");
    $APIEndpoint = "https://api.akeyless.io";

    $PostData = array();
    $PostData["access-type"] = "access_key";
    $PostData["access-id"] = "$AccessID";
    $PostData["access-key"] = "$AccessKey";
    $jsonPostData = json_encode($PostData);

    $Service = "/auth";
    $url = $APIEndpoint.$Service;
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonPostData);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("accept: application/json","Content-Type: application/json"));
    $response = curl_exec($curl);
    curl_close($curl);
    $arrResponse = json_decode($response, TRUE);
    $token = $arrResponse["token"];

    $PostData = array();
    $PostData["token"] = $token;
    $PostData["names"] = $arrNames;
    $jsonPostData = json_encode($PostData);

    $Service = "/get-secret-value";
    $url = $APIEndpoint.$Service;
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonPostData);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("accept: application/json","Content-Type: application/json"));
    $response = curl_exec($curl);
    curl_close($curl);
    return json_decode($response, TRUE);
  }

  require_once("header.php");
  $arrname = array();

  $arrname[] = "MySecret1";
  $arrname[] = "MyFirstSecret";
  $arrname[] = "/TSC/AnotherTest2";
  $arrname[] = "/Test/MyPathTest";

  print "<h1>Fetching secret from AKEYLESS secret management system at akeyless.io</h1>\n";
  $arrSecretValues = FetchKeylessStatic($arrname);

  print "<p>Here are the secret names and corrensponding values</p>\n";
  foreach($arrSecretValues as $key => $value)
  {
    print "$key: $value <br>\n";
  }
  require_once("footer.php");
?>