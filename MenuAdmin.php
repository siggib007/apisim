<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>

  Page to control how the menu is laid out, what's in menu, what admin, etc.
  */

  require("header.php");

  if($strReferer != $strPageURL and $PostVarCount > 0)
  {
    printPg("Invalid operation, Bad Reference!!!","error");
    exit;
  }

  if(isset($_POST["btnSubmit"]))
  {
    $btnSubmit = $_POST["btnSubmit"];
  }
  else
  {
    $btnSubmit = "";
  }
  printPg("Menu Maintenance","h1");

  if($btnSubmit == "Edit")
  {
    print "<div class=\"MainTextCenter\"><form method=\"POST\">\n<input type=\"Submit\" value=\"Go Back\" name=\"btnSubmit\"></form></div>";
    $iMenuID = intval(substr(trim($_POST["MenuID"]),0,49));
    $strQuery = "SELECT * FROM vwMenuPos where iMenuID = $iMenuID;";
    $QueryData = QuerySQL($strQuery);
    if($QueryData[0] > 0)
    {
      foreach($QueryData[1] as $Row)
      {
        if($Row["bSecure"] == 0)
        {
          $strChecked = "";
        }
        else
        {
          $strChecked = "checked";
        }
        if($Row["bNewWindow"] == 0)
        {
          $bWindow = "";
        }
        else
        {
          $bWindow = "checked";
        }
      }
    }
    else
    {
      if($QueryData[0] < 0)
      {
        $strMsg = Array2String($QueryData[1]);
        error_log("Query of $strQuery did not return data. Rowcount: $QueryData[0] Msg:$strMsg");
        printPg("$ErrMsg","error");
      }
    }

    print "<form method=\"POST\">\n";
    print "<table border=\"0\" width=\"850\" class=center>\n";
    print "<input type=\"hidden\" name=\"MenuID\" size=\"5\" value=\"$iMenuID\"></p>";
    print "<tr><td width=\"280\" align=\"right\" class=\"lbl\">Menu Title: </td>\n";
    print "<td width=\"520\"><input type=\"text\" name=\"txtTitle\" size=\"50\" value=\"{$Row['vcTitle']}\"></td></tr>\n";
    print "<tr><td width=\"280\" align=\"right\" class=\"lbl\">Page Header:</td>\n";
    print "<td width=\"520\"><input type=\"text\" name=\"txtHeader\" size=\"50\" value=\"{$Row['vcHeader']}\"></td></tr>";
    print "<tr><td width=\"280\" align=\"right\" class=\"lbl\">Contains sensitive data:</td>\n";
    print "<td width=\"520\"><input type=\"checkbox\" name=\"chkSensitive\" $strChecked></td></tr>";
    print "<tr><td width=\"280\" align=\"right\" class=\"lbl\">Show in new window:</td>\n";
    print "<td width=\"520\"><input type=\"checkbox\" name=\"chkNewWindow\" $bWindow></td></tr>";
    print "<tr><td width=\"280\" align=\"right\" class=\"lbl\">Read Priviledge Required:</td>";
    print "<td><select size=\"1\" name=\"cmbReadPrivLevel\">\n";
    $strQuery = "select * from tblprivlevels;";
    $QueryData = QuerySQL($strQuery);
    if($QueryData[0] > 0)
    {
      foreach($QueryData[1] as $Row2)
      {
        if($Row2["iPrivLevel"] == $Row["iReadPriv"])
        {
          print "<option selected value=\"{$Row2['iPrivLevel']}\">{$Row2['vcPrivName']}</option>\n";
        }
        else
        {
          print "<option value=\"{$Row2['iPrivLevel']}\">{$Row2['vcPrivName']}</option>\n";
        }
      }
    }
    else
    {
      if($QueryData[0] < 0)
      {
        $strMsg = Array2String($QueryData[1]);
        error_log("Query of $strQuery did not return data. Rowcount: $QueryData[0] Msg:$strMsg");
        printPg("$ErrMsg","error");
      }
    }
    print "</select>\n</td>\n</tr>";
    print "<tr><td width=\"280\" align=\"right\" class=\"lbl\">Write Priviledge Required:</td>";
    print "<td><select size=\"1\" name=\"cmbWritePrivLevel\">\n";
    $strQuery = "select * from tblprivlevels;";
    $QueryData = QuerySQL($strQuery);
    if($QueryData[0] > 0)
    {
      foreach($QueryData[1] as $Row2)
      {
        if($Row2["iPrivLevel"] == $Row["iWritePriv"])
        {
          print "<option selected value=\"{$Row2['iPrivLevel']}\">{$Row2['vcPrivName']}</option>\n";
        }
        else
        {
          print "<option value=\"{$Row2['iPrivLevel']}\">{$Row2['vcPrivName']}</option>\n";
        }
      }
    }
    else
    {
      if($QueryData[0] < 0)
      {
        $strMsg = Array2String($QueryData[1]);
        error_log("Query of $strQuery did not return data. Rowcount: $QueryData[0] Msg:$strMsg");
        printPg("$ErrMsg","error");
      }
    }
    print "</select>\n</td>\n</tr>";
    print "<tr><td width=\"280\" align=\"right\" class=\"lbl\">Administrative category:</td>";
    print "<td><select size=\"1\" name=\"cmbAdminCat\">\n";
    $strQuery = "select * from tblAdminCategories;";
    $QueryData = QuerySQL($strQuery);
    if($QueryData[0] > 0)
    {
      foreach($QueryData[1] as $Row2)
      {
        if($Row2["iCatID"] == $Row["bAdmin"])
        {
          print "<option selected value=\"{$Row2['iCatID']}\">{$Row2['vcCatName']}</option>\n";
        }
        else
        {
          print "<option value=\"{$Row2['iCatID']}\">{$Row2['vcCatName']}</option>\n";
        }
      }
    }
    else
    {
      if($QueryData[0] < 0)
      {
        $strMsg = Array2String($QueryData[1]);
        error_log("Query of $strQuery did not return data. Rowcount: $QueryData[0] Msg:$strMsg");
        printPg("$ErrMsg","error");
      }
    }

    print "</select>\n</td>\n</tr>";
    print "<tr><td width=\"280\" align=\"right\" class=\"lbl\">Subordinate of page:</td>";
    print "<td><select size=\"1\" name=\"cmbSubOf\">\n";
    $strQuery = "SELECT * FROM vwTopMenu WHERE iMenuID != $iMenuID;";
    $QueryData = QuerySQL($strQuery);
    if($QueryData[0] > 0)
    {
      foreach($QueryData[1] as $MenuItem)
      {
        if($MenuItem["iMenuID"] == $Row["iSubOfMenu"])
        {
          print "<option selected value=\"{$MenuItem['iMenuID']}\">{$MenuItem['vcTitle']}</option>\n";
        }
        else
        {
          print "<option value=\"{$MenuItem['iMenuID']}\">{$MenuItem['vcTitle']}</option>\n";
        }
      }
    }
    else
    {
      $strMsg = Array2String($QueryData[1]);
      trigger_error("Query of $strQuery did not return data. Rowcount: $QueryData[0] Msg:$strMsg");
      print "<option value=\"0\">Failed to fetch list</option>\n";
    }
    print "</select>\n</td>\n</tr>";
    print "<tr><td colspan=\"2\" align=\"center\"><input type=\"Submit\" value=\"Save\" name=\"btnSubmit\"></td></tr>";
    print "</table></form>\n";
    print "<div class=\"MainTextCenter\"><form method=\"POST\">\n<input type=\"Submit\" value=\"Go Back\" name=\"btnSubmit\"></form></div>";
  }

  if($btnSubmit == "Save")
  {
    $strTitle = CleanReg(substr(trim($_POST["txtTitle"]),0,49));
    $strHeader = CleanReg(substr(trim($_POST["txtHeader"]),0,49));
    $iReadPriv = intval(substr(trim($_POST["cmbReadPrivLevel"]),0,6));
    $iWritePriv = intval(substr(trim($_POST["cmbWritePrivLevel"]),0,6));
    $iAdminCatID = intval(substr(trim($_POST["cmbAdminCat"]),0,6));
    $iSubOfID = intval(substr(trim($_POST["cmbSubOf"]),0,6));
    $iMenuID = intval(substr(trim($_POST["MenuID"]),0,4));
    if(isset($_POST["chkSensitive"]))
    {
      $bSensitive = 1;
    }
    else
    {
      $bSensitive = 0;
    }
    if(isset($_POST['chkNewWindow']))
    {
      $bWindow = 1;
    }
    else
    {
      $bWindow = 0;
    }
    $iCurSubOf = GetSQLValue("SELECT iSubOfMenu FROM tblmenutype WHERE iMenuID = $iMenuID;");
    $strQuery = "update tblmenu set vcTitle = '$strTitle', vcHeader = '$strHeader', bAdmin = '$iAdminCatID', " .
                " iReadPriv = $iReadPriv, iWritePriv = $iWritePriv, bSecure = $bSensitive, bNewWindow = $bWindow " .
                " where iMenuID=$iMenuID";

    UpdateSQL($strQuery,"update");
    if($iAdminCatID > 0)
    {
      $strQuery = "DELETE FROM tblmenutype WHERE iMenuID=$iMenuID;";
      UpdateSQL($strQuery,"delete");
    }
    else
    {
      $strQuery = "UPDATE tblmenutype SET iSubOfMenu = $iSubOfID WHERE iMenuID = $iMenuID;";
      UpdateSQL($strQuery,"update");
      if($iSubOfID > 0)
      {
        $NewHeadPos = GetSQLValue("SELECT iMenuOrder FROM tblmenutype WHERE iMenuID = $iSubOfID;");
        $NewHeadPos ++;
        $strQuery = "CALL spMovePos ('$iMenuID', '$NewHeadPos', 'head') ";
        UpdateSQL($strQuery);
      }
      else
      {
        if($iCurSubOf > 0)
        {
          $NewHeadPos = GetSQLValue("SELECT iMenuOrder FROM tblmenutype WHERE iMenuID = $iCurSubOf;");
          $NewHeadPos --;
          $strQuery = "CALL spMovePos ('$iMenuID', '$NewHeadPos', 'head') ";
          UpdateSQL($strQuery);
        }
      }
    }
  }

  if($btnSubmit == "Update Position")
  {
    $NewHeadPos = intval(substr(trim($_POST["NewHeadPos"]),0,4));
    $OldHeadPos = intval(substr(trim($_POST["OldHeadPos"]),0,4));
    $iMenuID = intval(substr(trim($_POST["MenuID"]),0,4));

    if($NewHeadPos > 0)
    {
      $strQuery = "CALL spMovePos ('$iMenuID', '$NewHeadPos', 'head') ";
      UpdateSQL($strQuery);
    }
  }

  if($btnSubmit == "Add to menu")
  {
    $iMenuID = intval(substr(trim($_POST["MenuID"]),0,4));
    $strQuery = "SELECT max(iMenuOrder)+1 AS NextID FROM tblmenutype";
    $nextPos = GetSQLValue($strQuery);
    $strQuery = "INSERT INTO tblmenutype (iMenuID, vcMenuType, iMenuOrder) VALUES ($iMenuID, 'head', $nextPos);";
    UpdateSQL($strQuery,"insert");
    $strQuery = "UPDATE tblmenu SET bAdmin = 0 WHERE iMenuID=$iMenuID;";
    UpdateSQL($strQuery,"delete");
  }

  if($btnSubmit == "Remove from Menu")
  {
    $iMenuID = intval(substr(trim($_POST["MenuID"]),0,4));
    $strQuery = "DELETE FROM tblmenutype WHERE iMenuID=$iMenuID;";
    UpdateSQL($strQuery,"delete");
  }

  printPg("Visible in menu","tmh2");
  print "<table class=\"TextCenterScreen\" cellPadding=\"4\" cellSpacing=\"0\">\n";
  if($WritePriv <=  $Priv)
  {
    print "<tr align=\"left\"><th>Menu Title</th><th>Page Title</th><th>Read Priv</th><th>Write Priv</th><th>Sensitive</th>";
    print "<th>New Window</th><th></th><th width=\"20\">Header Position</th></tr>\n";
  }
  else
  {
    print "<tr align=\"left\"><th>Menu Title</th><th>Page Title</th><th>Read Priv</th><th>Write Priv</th>th>Sensitive</th><th>New Window</th></tr>\n";
  }
  $strQuery = "SELECT * FROM vwmenupriv where bAdmin=0  AND iMenuOrder IS NOT NULL order by iMenuOrder";
  $QueryData = QuerySQL($strQuery);
  if($QueryData[0] > 0)
  {
    foreach($QueryData[1] as $Row)
    {
      print "<tr valign=\"top\">\n";
      if($Row["iSubOfMenu"] > 0)
      {
        print "<td>&nbsp;&nbsp; $Row[vcTitle]</td>\n";
      }
      else
      {
        print "<td>$Row[vcTitle]</td>\n";
      }
      print "<td>$Row[vcHeader]</td>\n";
      print "<td>$Row[ReadPriv]</td>\n";
      print "<td>$Row[WritePriv]</td>\n";
      if($Row["bSecure"] == 0)
      {
        print "<td align=center><input type=\"checkbox\" disabled></td>\n";
      }
      else
      {
        print "<td align=center><input type=\"checkbox\" checked disabled></td>\n";
      }
      if($Row["bNewWindow"] == 0)
      {
        print "<td align=center><input type=\"checkbox\" disabled></td>\n";
      }
      else
      {
        print "<td align=center><input type=\"checkbox\" checked disabled></td>\n";
      }
      if($WritePriv <=  $Priv)
      {
        $HeaderPos = $Row["iMenuOrder"];
        print "<form method=\"POST\">\n";
        print "<td><input type=\"Submit\" value=\"Edit\" name=\"btnSubmit\">";
        print "<input type=\"hidden\" value=\"$Row[iMenuID]\" name=\"MenuID\"></td>\n";
        print "</form>\n";
        if($HeaderPos > 0)
        {
          print "<form method=\"POST\">\n";
          print "<td>\n";
          print "<input type=\"text\" value=\"$HeaderPos\" name=\"NewHeadPos\" size=\"3\">\n";
          print "<input type=\"hidden\" value=\"$HeaderPos\" name=\"OldHeadPos\">\n";
          print "</td>\n";
          print "<td>\n";
          print "<input type=\"Submit\" value=\"Update Position\" name=\"btnSubmit\">\n";
          print "<input type=\"hidden\" value=\"$Row[iMenuID]\" name=\"MenuID\">";
          print "</td>\n";
          print "</form>\n";
        }
        print "<form method=\"POST\">\n";
        print "<td><input type=\"Submit\" value=\"Remove from Menu\" name=\"btnSubmit\">";
        print "<input type=\"hidden\" value=\"$Row[iMenuID]\" name=\"MenuID\"></td>\n";
        print "</form>\n";
      }
      print "</tr>\n";
    }
  }
  else
  {
    if($QueryData[0] < 0)
    {
      $strMsg = Array2String($QueryData[1]);
      error_log("Query of $strQuery did not return data. Rowcount: $QueryData[0] Msg:$strMsg");
      printPg("$ErrMsg","error");
    }
  }

  print "</table>";

  printPg("Administrative Items","tmh2");
  print "<table class=\"TextCenterScreen\" border=\"0\" cellPadding=\"4\" cellSpacing=\"0\">\n";
  if($WritePriv <=  $Priv)
  {
    print "<tr align=\"left\"><th>Menu Title</th><th>Page Title</th><th>Read Priv</th><th>Write Priv</th><th>Sensitive</th>";
    print "<th>New Window</th><th></th></tr>\n";
  }
  else
  {
    print "<tr align=\"left\"><th>Menu Title</th><th>Page Title</th><th>Read Priv</th><th>Write Priv</th>th>Sensitive</th><th>New Window</th></tr>\n";
  }
  $strQuery = "SELECT * FROM vwmenupriv where bAdmin > 0 order by vcTitle";
  $QueryData = QuerySQL($strQuery);
  if($QueryData[0] > 0)
  {
    foreach($QueryData[1] as $Row)
    {
      print "<tr valign=\"top\">\n";
      print "<td>$Row[vcTitle]</td>";
      print "<td>$Row[vcHeader]</td>";
      print "<td>$Row[ReadPriv]</td>\n";
      print "<td>$Row[WritePriv]</td>\n";
      if($Row["bSecure"] == 0)
      {
        print "<td align=center><input type=\"checkbox\" disabled></td>\n";
      }
      else
      {
        print "<td align=center><input type=\"checkbox\" checked disabled></td>\n";
      }
      if($Row["bNewWindow"] == 0)
      {
        print "<td align=center><input type=\"checkbox\" disabled></td>\n";
      }
      else
      {
        print "<td align=center><input type=\"checkbox\" checked disabled></td>\n";
      }
      if($WritePriv <=  $Priv)
      {
        print "<form method=\"POST\">\n";
        print "<td><input type=\"Submit\" value=\"Edit\" name=\"btnSubmit\">";
        print "<input type=\"hidden\" value=\"$Row[iMenuID]\" name=\"MenuID\"></td>\n";
        print "</form>\n";

        print "<form method=\"POST\">\n";
        print "<td><input type=\"Submit\" value=\"Add to menu\" name=\"btnSubmit\">";
        print "<input type=\"hidden\" value=\"$Row[iMenuID]\" name=\"MenuID\"></td>\n";
        print "</form>\n";
      }
      print "</tr>\n";
    }
  }
  else
  {
    if($QueryData[0] < 0)
    {
      $strMsg = Array2String($QueryData[1]);
      error_log("Query of $strQuery did not return data. Rowcount: $QueryData[0] Msg:$strMsg");
      printPg("$ErrMsg","error");
    }
  }
  print "</table>";

  printPg("Other Items","tmh2");
  print "<table class=\"TextCenterScreen\" border=\"0\" cellPadding=\"4\" cellSpacing=\"0\">\n";
  if($WritePriv <=  $Priv)
  {
    print "<tr align=\"left\"><th>Menu Title</th><th>Page Title</th><th>Read Priv</th><th>Write Priv</th><th>Sensitive</th>";
    print "<th>New Window</th><th></th></tr>\n";
  }
  else
  {
    print "<tr align=\"left\"><th>Menu Title</th><th>Page Title</th><th>Read Priv</th><th>Write Priv</th>th>Sensitive</th><th>New Window</th></tr>\n";
  }
  $strQuery = "SELECT * FROM vwmenupriv where bAdmin=0 AND iMenuOrder IS NULL order by vcTitle";
  $QueryData = QuerySQL($strQuery);
  if($QueryData[0] > 0)
  {
    foreach($QueryData[1] as $Row)
    {
      print "<tr valign=\"top\">\n";
      print "<td>$Row[vcTitle]</td>";
      print "<td>$Row[vcHeader]</td>";
      print "<td>$Row[ReadPriv]</td>\n";
      print "<td>$Row[WritePriv]</td>\n";
      if($Row["bSecure"] == 0)
      {
        print "<td align=center><input type=\"checkbox\" disabled></td>\n";
      }
      else
      {
        print "<td align=center><input type=\"checkbox\" checked disabled></td>\n";
      }
      if($Row["bNewWindow"] == 0)
      {
        print "<td align=center><input type=\"checkbox\" disabled></td>\n";
      }
      else
      {
        print "<td align=center><input type=\"checkbox\" checked disabled></td>\n";
      }
      if($WritePriv <=  $Priv)
      {
        print "<form method=\"POST\">\n";
        print "<td><input type=\"Submit\" value=\"Edit\" name=\"btnSubmit\">";
        print "<input type=\"hidden\" value=\"$Row[iMenuID]\" name=\"MenuID\"></td>\n";
        print "</form>\n";

        print "<form method=\"POST\">\n";
        print "<td><input type=\"Submit\" value=\"Add to menu\" name=\"btnSubmit\">";
        print "<input type=\"hidden\" value=\"$Row[iMenuID]\" name=\"MenuID\"></td>\n";
        print "</form>\n";
      }
      print "</tr>\n";
    }
  }
  else
  {
    if($QueryData[0] < 0)
    {
      $strMsg = Array2String($QueryData[1]);
      error_log("Query of $strQuery did not return data. Rowcount: $QueryData[0] Msg:$strMsg");
      printPg("$ErrMsg","error");
    }
  }
  print "</table>";

  require("footer.php");
?>
