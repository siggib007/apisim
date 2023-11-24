<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details   
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>

  Customize error handling for when error like 404 file not found occur
  */

  require("header.php");
  $page_redirected_from = $_SERVER["REQUEST_URI"];  // this is especially useful with error 404 to indicate the missing page.
  $server_url = "http://" . $_SERVER["SERVER_NAME"];
  $ErrCodes["400"] = array("Bad Request","The syntax of the URL submitted by your browser could not be understood. Please verify the address and try again.");
  $ErrCodes["401"] = array("Unauthorized","The requested page needs a username and a password.");
  $ErrCodes["402"] = array("Payment Required","You can not use this code yet.");
  $ErrCodes["403"] = array("Forbidden","Access is forbidden to the requested page.");
  $ErrCodes["404"] = array("Not Found","The requested resource '" . $page_redirected_from . "' could not be found on this server. Please verify the address and try again.");
  $ErrCodes["405"] = array("Method Not Allowed","The method specified in the request is not allowed.");
  $ErrCodes["406"] = array("Not Acceptable","The server can only generate a response that is not accepted by the client.");
  $ErrCodes["407"] = array("Proxy Authentication Required","You must authenticate with a proxy server before this request can be served.");
  $ErrCodes["408"] = array("Request Timeout","The request took longer than the server was prepared to wait.");
  $ErrCodes["409"] = array("Conflict","The request could not be completed because of a conflict.");
  $ErrCodes["410"] = array("Gone","The requested page is no longer available .");
  $ErrCodes["411"] = array("Length Required","The 'Content-Length' is not defined. The server will not accept the request without it.");
  $ErrCodes["412"] = array("Precondition Failed","The pre condition given in the request evaluated to false by the server.");
  $ErrCodes["413"] = array("Request Entity Too Large","The server will not accept the request, because the request entity is too large.");
  $ErrCodes["414"] = array("Request-url Too Long","The server will not accept the request, because the url is too long. Occurs when you convert a 'post' request to a 'get' request with a long query information.");
  $ErrCodes["415"] = array("Unsupported Media Type","The server will not accept the request, because the mediatype is not supported .");
  $ErrCodes["416"] = array("Requested Range Not Satisfiable","The requested byte range is not available and is out of bounds.");
  $ErrCodes["417"] = array("Expectation Failed","The expectation given in an Expect request-header field could not be met by this server.");
  $ErrCodes["500"] = array("Internal Server Error","The request was not completed. The server met an unexpected condition.");
  $ErrCodes["501"] = array("Not Implemented","The request was not completed. The server did not support the functionality required.");
  $ErrCodes["502"] = array("Bad Gateway","The request was not completed. The server received an invalid response from the upstream server.");
  $ErrCodes["503"] = array("Service Unavailable","The request was not completed. The server is temporarily overloading or down.");
  $ErrCodes["504"] = array("Gateway Timeout","The gateway has timed out.");
  $ErrCodes["505"] = array("HTTP Version Not Supported","The server does not support the 'http protocol' version.");
  
  $iErrNum = getenv("REDIRECT_STATUS");
  if(array_key_exists($iErrNum,$ErrCodes))
  {
    $error_code = $iErrNum . " - " . $ErrCodes[$iErrNum][0];
    $explanation = $ErrCodes[$iErrNum][1];
  }
  else 
  {
    $error_code = $iErrNum . " Error";
    $explanation = "Unknown error occured";
  }

  printPg("Unexpected error seems to have occured, sorry about that. Here are the error details:","error");
  printPg("$error_code. $explanation","error");
  printPg("If you have any questions please reach out to us at <a href=mailto:$SupportEmail>$SupportEmail</a>","note");
  require("footer.php");  
?>