<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details   
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>

  Page to do mass privledge updates on users
  */

  require_once("header.php");
  if($strReferer != $strPageURL and $PostVarCount > 0)
  {
    printPg("Invalid operation, Bad Reference!!!","error");
    exit;
  }
  if(isset($_POST["cmbUser"]))
  {
    $iUserArray = $_POST["cmbUser"];
  }
  else
  {
    $iUserArray = array();
  }
  if(isset($_POST["btnSubmit"]))
  {
    $btnSubmit = $_POST["btnSubmit"];
  }
  else
  {
    $btnSubmit = "";
  }

  if($btnSubmit == "Update")
  {
    $iPrivUpdate = CleanSQLInput(substr(trim($_POST["cmbPrivUpdate"]),0,4));
    $iPrivLevel = CleanSQLInput(substr(trim($_POST["iPrivLvl"]),0,4));
    $strUserList = "";
    foreach($iUserArray as $val)
    {
      $strUserList .= "$val, ";
    }
    $strUserList .= "-55";
    $strQuery = "update tblUsers set iPrivLevel = $iPrivUpdate where iUserID in ($strUserList);";
    UpdateSQL($strQuery,"update");
  }
      
  if($btnSubmit == "Change")
  {
    $iPrivLevel = CleanSQLInput(substr(trim($_POST["cmbPriv"]),0,4));
  }
  else
  {
    $iPrivLevel = 300;
  }

  printPg("Priviledge Administration","h1");

  print "<form method=\"POST\">\n";
  print "<p align=\"center\">Change Priviledges for anyone who's priviledge is less than:\n";
  print "<select size=\"1\" name=\"cmbPriv\">\n";
  $strQuery = "SELECT iPrivLevel, vcPrivName FROM tblprivlevels ORDER BY iPrivLevel;";
  $QueryData = QuerySQL($strQuery);
  if($QueryData[0] > 0)
  {
    foreach($QueryData[1] as $Row)
    {
      $iPrivlvl = $Row["iPrivLevel"];
      $PrivName = $Row["vcPrivName"];

      if($iPrivlvl == $iPrivLevel)
      {
          print "<option selected value=\"$iPrivlvl \">$PrivName</option>\n";
      }
      else
      {
          print "<option value=\"$iPrivlvl \">$PrivName </option>\n";
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
      printPg("$ErrMsg","error");
    }
  }

  print "</select>\n";
  print "<input type=\"Submit\" value=\"Change\" name=\"btnSubmit\">\n";
  print "</form>\n";

  print "<form method=\"POST\">\n";
  print "<input type=\"hidden\" name=\"iPrivLvl\" value=\"$iPrivLevel\">";
  $strQuery = ("SELECT u.iUserID, u.vcName, u.vcEmail, p.vcPrivName " .
                "FROM tblUsers u JOIN tblprivlevels p ON u.iPrivLevel = p.iPrivLevel ".
                "WHERE u.iPrivLevel < $iPrivLevel ORDER BY u.vcName;");
  $QueryData = QuerySQL($strQuery);
  $NumAffected = $QueryData[0];
  switch($NumAffected)
  {
    case "0":
        print "<p align=\"center\">No one has less priviledges than that</p>";
        break;
    case "1":
        print "<p align=\"center\">Only one person has less priviledges than that</p>";
        break;
    default:
        print "<p align=\"center\">There are $NumAffected with less priviledges</p>";
        break;
  }

  print "<p align=\"center\">Choose users to change priviledges for:\n<br>\n";
  print "<select size=\"10\" multiple name=\"cmbUser[]\" style=\"min-width: 100px;\">\n";

  if($QueryData[0] > 0)
  {
    foreach($QueryData[1] as $Row)
    {
      $iUIDdb = $Row["iUserID"];
      $vcName = $Row["vcName"];
      $strEmail = $Row["vcEmail"];
      $strPriv = $Row["vcPrivName"];
      print "<option value=\"$iUIDdb \">$vcName - $strEmail - $strPriv</option>\n";
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
      printPg("$ErrMsg","error");
    }
  }
  
  print "</select>\n<br>";
  print "Change to:";
  print "<select size=\"1\" name=\"cmbPrivUpdate\">\n";
  $strQuery = "SELECT iPrivLevel, vcPrivName FROM tblprivlevels ORDER BY iPrivLevel;";
  $QueryData = QuerySQL($strQuery);
  if($QueryData[0] > 0)
  {
    foreach($QueryData[1] as $Row)
    {
      $iPrivlvl = $Row["iPrivLevel"];
      $PrivName = $Row["vcPrivName"];

      if($iPrivlvl == $iPrivLevel)
      {
        print "<option selected value=\"$iPrivlvl \">$PrivName</option>\n";
      }
      else
      {
        print "<option value=\"$iPrivlvl \">$PrivName </option>\n";
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
      printPg("$ErrMsg","error");
    }
  }
  print "</select>\n";

  print "<input type=\"Submit\" value=\"Update\" name=\"btnSubmit\">\n";
  print "</form>\n <br>\n";

  require("footer.php");
?>
