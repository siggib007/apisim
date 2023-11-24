<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details   
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>

  Page to display FAQs

  */
    
  require("header.php");

  printPg("Frequently Asked Questions (FAQ)","h1");
  $strQuery = "select iFAQid, vcQuestion, tAnswer from tblFAQ;";
  $QueryData = QuerySQL($strQuery);

  if($QueryData[0] > 0)
  {
    foreach($QueryData[1] as $Row)
    {
      $vcQuestion = $Row["vcQuestion"];
      $strAnswer = $Row["tAnswer"];
      $iFAQid = $Row["iFAQid"];
      print "<div class=\"ClassName\"><a id=$iFAQid>$vcQuestion</a></div>\n";
      print "<div class=\"ClassDescr\">$strAnswer</div>\n";
    }
  }
  else
  {
    if($QueryData[0] == 0)
    {
      printPg("No Records","note");
    }
    else 
    {
      $strMsg = Array2String($QueryData[1]);
      error_log("Query of $strQuery did not return data. Rowcount: $QueryData[0] Msg:$strMsg");
      printPg($ErrMsg,"error");
    }
  }

  require("footer.php");
?>
