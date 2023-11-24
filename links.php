<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details   
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>

  Page to show all the cool links we've recorded in LinkAdmin
  */

  require("header.php");
  printPg("Links","h1");
  $strCat = "";
  $strQuery = "SELECT vcCategory,vcLink,vcName,vcComment FROM vwLinks order by iSortNum;";
  $QueryData = QuerySQL($strQuery);
  if($QueryData[0] > 0)
  {
    foreach($QueryData[1] as $Row)
    {
      $strCategory = $Row["vcCategory"];
      $strLink     = $Row["vcLink"];
      $strName     = $Row["vcName"];
      $strComment  = $Row["vcComment"];
      if($strCat != $strCategory)
      {
        if($strCat != "")
        {
          print "</ul>\n";
        }
        print "<p class=\"LinkCategoryHeader\">$strCategory</p>\n<ul>\n";
        $strCat = $strCategory;
      }
      if($ShowLinkURL == "False")
      {
        print "<li class=\"MainText\"><a href=\"$strLink\" target=\"_blank\"><b>$strName</b></a>  $strComment</li> \n";
      }
      else
      {
        print "<li class=\"MainText\"><b>$strName</b> <a href=\"$strLink\" target=\"_blank\">$strLink</a>  $strComment</li> \n";
      }
    }
  }
  else
  {
    if($QueryData[0] == 0)
    {
      printPg("No Data","note");
    }
    else
    {
      $strMsg = Array2String($QueryData[1]);
      error_log("Query of $strQuery did not return data. Rowcount: $QueryData[0] Msg:$strMsg");
      printPg("$ErrMsg","error");
    }
  }
  require("footer.php");
?>