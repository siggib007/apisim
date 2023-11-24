<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details   
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>
  */

  require("header.php");

  printPg("Share Your Experience","h1");
  print "<center>";
  print "<table>\n";
  print "<tr>\n";

  $strQuery = "select vcSiteName, vcSiteURL, vcImgPath from tblReviewSiteURL;";
  $QueryData = QuerySQL($strQuery);
  if($QueryData[0] > 0)
  {
    foreach($QueryData[1] as $Row)
    {
      $vcSiteName = $Row["vcSiteName"];
      $vcSiteURL = $Row["vcSiteURL"];
      $vcMMURL = $Row["vcImgPath"];
      print "<td class=\"ReviewLinks\">";
      print "<a href=\"$vcSiteURL\" target=\"_blank\">";
      if($vcMMURL!="")
      {
        print "<img style=\"border:0;\" src=\"$vcMMURL\" alt=\"$vcSiteName\" height=75>\n";
      }
      else
      {
        print "$vcSiteName";
      }
      print "</a>\n";
      print "</td>\n";
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

  print "</tr>\n";
  print "</table>\n";

  $strQuery = "select vcFeedbackName, tFeedbackDescr, vcImgPath from tblFeedback;";
  $QueryData = QuerySQL($strQuery);
  if($QueryData[0] > 0)
  {
    foreach($QueryData[1] as $Row)
    {
      $vcFeedbackName = $Row["vcFeedbackName"];
      $vcFeedbackDescr = $Row["tFeedbackDescr"];
      $vcMMURL = $Row["vcImgPath"];
      printPg($vcFeedbackName,"tmh2");
      printPg($vcFeedbackDescr,"normal");
      if($vcMMURL!="")
      {
        print "<img src=\"$vcMMURL\" height=200><br>\n";
      }
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
  print "</center>";
  require("footer.php");
?>
