<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>

  Displays the Admin menu
  */

  require("header.php");
  printPg("Administration tasks","h1");

  $strCat = "";
  $i=1;
  if($strCatID > 0)
  {
    $strWhere = "WHERE iReadPriv <= $Priv and iCatID = $strCatID";
  }
  else
  {
    $strWhere = "WHERE iReadPriv <= $Priv and iCatID > 0";
  }

  print "<table class=\"Admin\">\n";

  $strQuery = "SELECT vcTitle, vcLink, bNewWindow, vcCatName FROM vwAdminCat $strWhere;";
  $QueryData = QuerySQL($strQuery);

  if($QueryData[0] > 0)
  {
    foreach($QueryData[1] as $Row)
    {
      $strLink     = $Row["vcLink"];
      $strName     = $Row["vcTitle"];
      $bNewWindow  = $Row["bNewWindow"];
      $strCategory = $Row["vcCatName"];
      if($strCat != $strCategory)
      {
        if($strCat != "")
        {
          print "</td>\n";
          if($i<$iNumCol)
          {
            $i++;
          }
          else
          {
            $i=1;
            print "</tr>\n";
            print "<tr>\n";
          }
        }
        else
        {
          print "<tr>\n";
        }
        print "<td class=\"Admin\">\n";
        print "<p class=\"AdminCategoryHeader\">$strCategory</p>\n";
        $strCat = $strCategory;
      }
      if($bNewWindow == 1)
      {
        print "<div class=\"MainText\"> <a href=\"$strLink\" target=\"_blank\">$strName</a></div>\n";
      }
      else
      {
        print "<div class=\"MainText\"> <a href=\"$strLink\">$strName</a></div>\n";
      }
    }
  }
  elseif ($QueryData[0] == 0)
  {
    printPg("No Tasks in this category","note");
  }
  else
  {
    $strMsg = Array2String($QueryData[1]);
    trigger_error("Query of $strQuery did not return data. Rowcount: $QueryData[0] Msg:$strMsg");
    printPg($ErrMsg,"error");
  }

  print "</td>\n";
  print "</tr>\n";
  print "</table>\n";

  require("footer.php");
?>