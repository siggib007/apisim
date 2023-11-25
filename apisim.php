<?php
  require("DBCon.php");
  $strURL = $_SERVER["SERVER_NAME"];
  $strURI = $_SERVER["REQUEST_URI"];
  $Protocol = $_SERVER['SERVER_PROTOCOL'];
  $strPHPSelf = $_SERVER['PHP_SELF'];
  $PageName = basename($strPHPSelf);
  $PagebaseName = basename($strPHPSelf,".php");
  $iPos = strripos($strURI, "/");

  $headers = apache_request_headers();
  $AcceptHeader = $headers["Accept"];

  if ($iPos>0)
  {
    $strPath = substr($strURI, 0,$iPos);
  }
  else
  {
    $strPath = "";
  }

  $iPos = strripos($Protocol, "/");
  if ($iPos>0)
  {
    $strProt = strtolower(substr($Protocol, 0,$iPos));
  }
  else
  {
    $strProt = "";
  }

  $PageURL = "$strProt://$strURL$strPath/$PageName";

  if (isset($_GET['rc']))
  {
    $iResponse = intval($_GET['rc']);
  }
  else
  {
    $iResponse=0;
  }

  $text = HTTPCodeLookup ($iResponse);

  if (isset($_GET['sleep']))
  {
    $iSleep = intval($_GET['sleep']);
  }
  else
  {
    $iSleep=0;
  }

  if ($iSleep>0)
  {
    sleep($iSleep);
  }

  if ($iResponse > 200 and $iResponse < 1000 and $iResponse!=0)
  {
    header("$Protocol $iResponse $text");
  }

  if (isset($_GET['result']))
  {
    $strFormat = strtolower(($_GET['result']));
  }
  elseif (str_contains(strtolower($AcceptHeader),"html"))
  {
    $strFormat="html";
  }
  elseif (str_contains(strtolower($AcceptHeader),"xml"))
  {
    $strFormat="xml";
  }
  elseif (str_contains(strtolower($AcceptHeader),"json"))
  {
    $strFormat="json";
  }
  else
  {
    $strFormat="html";
  }


  $iArgCount = count($_GET);
  $strTitle = $ConfArray["ProductName"];
  $RCLower = $ConfArray["rclower"];
  $RCUpper = $ConfArray["rcupper"];
  $SampleNum = $ConfArray["samplenum"];
  $SampleResult = $ConfArray["SampleResult"];
  $strTestResp = "You asked for code $iResponse $text";
  $strSleepResp = "As requested I took a $iSleep second nap";
  $strTestError = "You asked for Response Code $iResponse. " .
    " Response codes less than $RCLower or greater than $RCUpper are not supported";
  $strIntro = $TextArray["intro"];
  $strExample = "$PageURL?";

  $strQuery = "SELECT vcOptionCode, vcOptionDescr, vcValueType FROM tblOptions";
  $QueryData = QuerySQL($strQuery);
  if($QueryData[0] > 0)
  {
    foreach($QueryData[1] as $Row)
    {
      $OptionCode = $Row["vcOptionCode"];
      $OptionDescr = $Row["vcOptionDescr"];
      $OptionType = $Row["vcValueType"];
      switch ($OptionType)
      {
        case "int":
          $SampleValue = $SampleNum;
          break;
        case "string":
          $SampleValue = $SampleResult;
          break;
        default:
          $SampleValue = "";
          break;
      }
      $OptionDescr = str_replace("xyz", "$SampleNum", $OptionDescr);
      $OptionDescr = str_replace("xx", "$RCLower", $OptionDescr);
      $OptionDescr = str_replace("yy", "$RCUpper", $OptionDescr);
      $OptionDescr = str_replace("xystr", "$SampleResult", $OptionDescr);
      $OptionsArray["Options"][$OptionCode]["command"] = "$PageURL?$OptionCode=$SampleValue";
      $OptionsArray["Options"][$OptionCode]["descr"] = "Requires $OptionType. $OptionDescr";
      $strExample .= "$OptionCode=$SampleValue&";
    }
  }
  else
  {
    if($QueryData[0] == 0)
    {
      error_log("query of $strQuery returned no rows");
    }
    else
    {
      $strMsg = Array2String($QueryData[1]);
      error_log("Query of $strQuery did not return data. Rowcount: $QueryData[0] Msg:$strMsg");
      printPg($ErrMsg,"error");
    }
  }

  $strExample = rtrim($strExample,"&");
  $OptionsArray["OptionsDescr"] = $TextArray["OptDescr"] . $strExample;

  $ReturnArray[$PagebaseName]["ReceivedArgsCount"] = $iArgCount;
  $ReturnArray[$PagebaseName]["ReceivedArgs"] = $_GET;

  if ($iResponse!=0)
  {
    $ReturnArray[$PagebaseName]["ProcessResp"]["HTTPCode"] = $iResponse;
    if ($iResponse < $RCLower or $iResponse > $RCUpper)
    {
      $ReturnArray[$PagebaseName]["ProcessResp"]["TestResp"] = $strTestError;
    }
    else
    {
      $ReturnArray[$PagebaseName]["ProcessResp"]["TestResp"] = $strTestResp;
    }
  }

  if ($iSleep>0)
  {
    $ReturnArray[$PagebaseName]["ProcessResp"]["Sleep"] = $iSleep;
    $ReturnArray[$PagebaseName]["ProcessResp"]["SleepText"] = $strSleepResp;
  }

  $ReturnArray[$PagebaseName]["intro"] = $strIntro;
  $ReturnArray[$PagebaseName]["Help"] = $OptionsArray;

  switch ($strFormat)
  {
    case "html":
      require("header.php");

      if ($iArgCount>0)
      {
        print "<h3>Received $iArgCount parameters:</h3>";
        foreach ($_GET as $key => $value)
        {
          print "$key = $value<br>\n";
        }
      }
      if ($iResponse!=0)
      {
        if ($iResponse < 200 or $iResponse>999)
        {
          print "<h3>$strTestError</h3>\n";
        }
        else
        {
          print "<h3>$strTestResp</h3>\n";
        }
      }
      if ($iSleep>0)
      {
        print "<h3>$strSleepResp</h3>\n";
      }
      $strIntro = str_replace("\n", "<br>\n", $strIntro);
      print "<p class=\"MainText\">\n$strIntro</p>\n";
      print "<div class=\"MainText\">Options:<br>\n";

      foreach ($OptionsArray["Options"] as $Opt)
      {
        $strTemp = $Opt["command"];
        print "$strTemp<br>\n";
        $strTemp = $Opt["descr"];
        print " - $strTemp<br>\n<br>\n";
      }
      print $OptionsArray["OptionsDescr"];
      print "</div>\n";
      require("footer.php");
      break;
    case "xml":
      header("Content-type: text/xml");
      print "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
      $ReturnXML = Array2XML($ReturnArray);
      print "$ReturnXML";
      break;
    case "json":
      header("Content-type: text/json");
      $ReturnJSON = json_encode($ReturnArray);
      print "$ReturnJSON";
      break;
    case "none":
      exit;
      break;
    case "txt":
      header("Content-type: text/text");
      print "Welcome to $strTitle\n";
      if ($iArgCount>0)
      {
        print "Received $iArgCount parameters:\n";
        foreach ($_GET as $key => $value)
        {
          print "$key = $value\n";
        }
      }
      if ($iResponse!=0)
      {
        if ($iResponse < 200 or $iResponse>999)
        {
          print "$strTestError\n";
        }
        else
        {
          print "$strTestResp\n";
        }
      }
      if ($iSleep>0)
      {
        print "$strSleepResp\n";
      }
      print "\n";
      print "\n$strIntro\n";
      print "Options:\n";

      foreach ($OptionsArray["Options"] as $Opt)
      {
        $strTemp = $Opt["command"];
        print "$strTemp\n";
        $strTemp = $Opt["descr"];
        print " - $strTemp\n\n";
      }
      print $OptionsArray["OptionsDescr"];
      print "\n";
      // print_r($_GET);
      break;

    default:
      print "Format \"$strFormat\" is not supported";
      break;
  }
?>