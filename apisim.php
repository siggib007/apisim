<?php
  function HTTPCodeLookup ($iHTTPCode)
  {
    // Response texts from https://en.wikipedia.org/wiki/List_of_HTTP_status_codes
    // and http://php.net/manual/en/function.http-response-code.php
    switch ($iHTTPCode)
    {
      case 200: $text = 'OK'; break;
      case 201: $text = 'Created'; break;
      case 202: $text = 'Accepted'; break;
      case 203: $text = 'Non-Authoritative Information'; break;
      case 204: $text = 'No Content'; break;
      case 205: $text = 'Reset Content'; break;
      case 206: $text = 'Partial Content'; break;
      case 207: $text = 'Multi-Status'; break;
      case 208: $text = 'Already Reported'; break;
      case 226: $text = 'IM Used'; break;
      case 300: $text = 'Multiple Choices'; break;
      case 301: $text = 'Moved Permanently'; break;
      case 302: $text = 'Found'; break;
      case 303: $text = 'See Other'; break;
      case 304: $text = 'Not Modified'; break;
      case 305: $text = 'Use Proxy'; break;
      case 306: $text = 'Switch Proxy'; break;
      case 307: $text = 'Temporarily Redirect'; break;
      case 308: $text = 'Permanently Redirect'; break;
      case 400: $text = 'Bad Request'; break;
      case 401: $text = 'Unauthorized'; break;
      case 402: $text = 'Payment Required'; break;
      case 403: $text = 'Forbidden'; break;
      case 404: $text = 'Not Found'; break;
      case 405: $text = 'Method Not Allowed'; break;
      case 406: $text = 'Not Acceptable'; break;
      case 407: $text = 'Proxy Authentication Required'; break;
      case 408: $text = 'Request Time-out'; break;
      case 409: $text = 'Conflict'; break;
      case 410: $text = 'Gone'; break;
      case 411: $text = 'Length Required'; break;
      case 412: $text = 'Precondition Failed'; break;
      case 413: $text = 'Request Entity Too Large'; break;
      case 414: $text = 'Request-URI Too Large'; break;
      case 415: $text = 'Unsupported Media Type'; break;
      case 416: $text = 'Range Not Satisfiable'; break;
      case 417: $text = 'Expectation Failed'; break;
      case 418: $text = 'I am a teapot'; break;
      case 421: $text = 'Misdirected Request'; break;
      case 422: $text = 'Unprocessable Entity'; break;
      case 423: $text = 'Locked'; break;
      case 424: $text = 'Failed Dependency'; break;
      case 426: $text = 'Upgrade Required'; break;
      case 428: $text = 'Precondition Required'; break;
      case 429: $text = 'Too Many Requests'; break;
      case 431: $text = 'Request Header Fields Too Large'; break;
      case 451: $text = 'Unavailable For Legal Reasons '; break;
      case 500: $text = 'Internal Server Error'; break;
      case 501: $text = 'Not Implemented'; break;
      case 502: $text = 'Bad Gateway'; break;
      case 503: $text = 'Service Unavailable'; break;
      case 504: $text = 'Gateway Time-out'; break;
      case 505: $text = 'HTTP Version not supported'; break;
      case 506: $text = 'Variant Also Negotiates'; break;
      case 507: $text = 'Insufficient Storage'; break;
      case 508: $text = 'Loop Detected'; break;
      case 510: $text = 'Not Extended'; break;
      case 511: $text = 'Network Authentication Required'; break;
      //Unoffical Codes, No RFC backing but common use
      case 0:   $text = 'No Code';
      case 103: $text = 'Checkpoint'; break;
      case 419: $text = 'I am a fox'; break;
      case 420: $text = 'Enhance Your Calm'; break;
      case 450: $text = 'Blocked by Parental Controls'; break;
      case 498: $text = 'Invalid Token'; break;
      case 499: $text = 'Request has been forbidden by antivirus '; break;
      case 509: $text = 'Bandwidth Limit Exceeded'; break;
      case 530: $text = 'Site is frozen'; break;
      case 598: $text = 'Network read timeout error'; break;
      case 599: $text = 'Network connect timeout error'; break;
      case 440: $text = 'Login Time-out'; break;
      case 449: $text = 'Retry with ...'; break;
      case 551: $text = 'Exchange Activesync Redirect'; break;
      case 444: $text = 'No Response'; break;
      case 495: $text = 'SSL Cert Error'; break;
      case 496: $text = 'SSL Cert Required'; break;
      case 497: $text = 'HTTP Request sent to HTTPS port'; break;
      case 499: $text = 'Client Closed Request'; break;
      case 520: $text = 'Unknown Error'; break;
      case 521: $text = 'Web Server Is Down'; break;
      case 522: $text = 'Connection Timed Out'; break;
      case 523: $text = 'Origin Is Unreachable'; break;
      case 524: $text = 'A Timeout Occurred'; break;
      case 525: $text = 'SSL Handshake Failed'; break;
      case 526: $text = 'Invalid SSL Certificate'; break;
      case 527: $text = 'Railgun Error'; break;
      case 666: $text = 'Devil is ready'; break;
      default:  $text = 'Random Status Code'; break;
    }
    return $text;
  }

  function Array2XML ($ComplexArray)
  {
    $strXML = "";
    foreach ($ComplexArray as $key => $value)
    {
      if (is_array($value))
      {
        $strXML .= "<$key>\n";
        $strXML .= Array2XML($value);
        $strXML .= "</$key>\n";
      }
      else
      {
        $value = str_replace("&", "&amp;", $value);
        $strXML .= "<$key>$value</$key>\n";
      }
    }
    return $strXML;
  }

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
  $strTitle = "API Simulator";
  $strTestResp = "You asked for code $iResponse $text";
  $strSleepResp = "As requested I took a $iSleep second nap";
  $strTestError = "You asked for Response Code $iResponse. " .
    " Response codes less than 200 or greater than 999 are not supported";
  $strIntro = "This page will allow you test your code for abnormal responses from API calls, " .
    "such as wrong format, slow response, or response codes (aka error codes) " .
    "such as HTTP 418 :-D\n" .
    "Please contact siggi@supergeek.us with any questions, comments and complients.\n" .
  $OptionsArray["Options"]["rc"]["command"] = "$PageURL?rc=234";
  $OptionsArray["Options"]["rc"]["descr"] = "Sets the HTTP response code to 234, ".
    "any number between 200 and 999 supported";
  $OptionsArray["Options"]["sleep"]["command"] = "$PageURL?sleep=123";
  $OptionsArray["Options"]["sleep"]["descr"] = "Sleeps for 123 seconds before responding";
  $OptionsArray["Options"]["format"]["command"] = "$PageURL?result=html";
  $OptionsArray["Options"]["format"]["descr"] = "Overwrites the accepted header and specifies that the reponse should be in HTML. " .
    "Valid formats (case insensitive): HTML, XML, JSON, TXT and NONE. " .
    "Default format is HTML" ;
  $OptionsArray["OptionsDescr"] ="These can of course be chained together such as " .
    " $PageURL?sleep=234&rc=234";

  $ReturnArray[$PagebaseName]["ReceivedArgsCount"] = $iArgCount;
  $ReturnArray[$PagebaseName]["ReceivedArgs"] = $_GET;

  if ($iResponse!=0)
  {
    $ReturnArray[$PagebaseName]["ProcessResp"]["HTTPCode"] = $iResponse;
    if ($iResponse < 200 or $iResponse>999)
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

      print "<p class=\"MainText\">\nAccept: $AcceptHeader</p>\n";
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