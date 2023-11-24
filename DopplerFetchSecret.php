<?php
  print "<h1>Fetching secret from Doppler secret management system at doppler.com</h1>\n";
  
  function FetchDopplerStatic($strProject,$strConfig)
  {
    # $strProject is a simple string with the name of the Doppler Project holding your secret
    # $strConfig is a simple string with the name of the configuration to use
    # Returns an associated array with top level key of success, indicating if the fetch was successful or not
    # If success = true, all secrets will be under a top level key of secrets
    # with the secret name as key and the secret as the value
    # If success = false, there will a array of messages under top level key of messages with error messages
    # Requires DopplerKEY as environment variables
    $AccessKey = getenv("DopplerKEY");
    $APIEndpoint = "https://api.doppler.com";
    $Service = "/v3/configs/config/secrets";
    $method = "GET";

    $Param = array();
    $Param["project"] = $strProject;
    $Param["config"] = $strConfig;
    
    $url = $APIEndpoint.$Service . "?" . http_build_query($Param);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_USERPWD, "$AccessKey:");
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("accept: application/json"));
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
    $response = curl_exec($curl);
    curl_close($curl);
    $arrResponse = json_decode($response, TRUE);
    return json_decode($response, TRUE);
  }


  $arrSecretValues = FetchDopplerStatic("phpdev","dev");

  print "<p>Here are the secret names and corrensponding values</p>\n";

  if(array_key_exists("secrets",$arrSecretValues))
  {
    foreach($arrSecretValues["secrets"] as $key => $value) 
    {
      print "$key: " . $value["computed"] . "<br>\n";
    }
  }
  else
  {
    if(array_key_exists("messages",$arrSecretValues))
    {
      print "<p>There was an issue fetching the secrets:</p>\n";
      foreach($arrSecretValues["messages"] as $msg)
      {
        print "$msg<br>\n";
      }
    }
    else
    {
      var_dump($arrSecretValues);
    }
  }

?>