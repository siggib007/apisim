<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>

  Dynamic Text page

  */

  require("header.php");
  $strQuery = "SELECT * FROM tblContent WHERE iMenuID = '$iMenuID' and dtTimeStamp = (select max(dtTimeStamp) from tblContent where iMenuID = '$iMenuID');";
  $QueryData = QuerySQL($strQuery);

  if($QueryData[0] > 0)
  {
    foreach($QueryData[1] as $Row)
    {
      $PageHeader = $Row["vcPageHeader"];
      $PageText = $Row["tPageText"];
      $bCRLF = $Row["bLineBreak"];
    }
  }
  else
  {
    $strMsg = Array2String($QueryData[1]);
    trigger_error("Query of $strQuery did not return data. Rowcount: $QueryData[0] Msg:$strMsg");
    $PageHeader = "Error occured";
    $PageText = "Failed to fetch the pagetext from the database";
    $bCRLF = "";
  }

  printPg("$PageHeader","h1");
  if(substr($PageText,0,1)=="<")
  {
    print "$PageText\n";
  }
  else
  {
    if($bCRLF == 1)
    {
      $PageText = str_replace("\n","<br>\n",$PageText);
    }
    $PageText = str_replace("\r\n","\n",$PageText);
    $PageText = str_replace("\r","\n",$PageText);
    $PageText = str_replace("\n\n","\n</p>\n<p class=MainText>\n",$PageText);

    printPg("$PageText");
  }

  require("footer.php");
?>
