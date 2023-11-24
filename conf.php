<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details   
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>

  Allows for management of configuration items

  */

  require("header.php");

  if($strReferer != $strPageURL and $PostVarCount > 0)
  {
    printPg("Invalid operation, Bad Reference!!!","error");
    exit;
  }

  printPg("Site Configuration","h1");

  if(($PostVarCount == 1) and ($_POST["btnSubmit"] == "Go Back"))
  {
    header("Location: $strPageURL");
  }

  if(isset($_POST["btnSubmit"]))
  {
    $btnSubmit = $_POST["btnSubmit"];
  }
  else
  {
    $btnSubmit = "";
  }

  if($btnSubmit == "Save")
  {
    $strValueName = CleanSQLInput(substr(trim($_POST["txtValueName"]),0,49));
    $strValue = "False";
    if(isset($_POST["txtValue"]))
    {
      $strValue = CleanSQLInput(substr(trim($_POST["txtValue"]),0,49));
    }
    if(isset($_POST["chkValue"]))
    {
      $strValue = "True";
    }
    $strQuery = "update tblconf set vcValue = '$strValue' where vcValueName = '$strValueName';";
    UpdateSQL($strQuery,"update");
  }

  print "<table>\n";
  $strQuery = "SELECT * FROM tblconf where vcValueName not in ('Maintenance','ROOTPATH');";
  $QueryData = QuerySQL($strQuery);

  if($QueryData[0] > 0)
  {
    foreach($QueryData[1] as $Row)
    {
      $Key = $Row["vcValueName"];
      $Value = $Row["vcValue"];
      $ValueDescr = $Row["vcValueDescr"];
      $ValueType = $Row["vcValueType"];
      if($WritePriv <=  $Priv)
      {
        print "<form method=\"POST\">\n";
        print "<tr valign=\"top\">\n";
        print "<td class=\"lblright\"><input type=\"hidden\" value=\"$Key\" name=\"txtValueName\">$ValueDescr: </td>\n";
        print "<td>";
        switch($ValueType)
        {
          case "Boolean":
            if($Value=="True")
            {
              $strChecked = "checked";
            }
            else
            {
              $strChecked = "";
            }
            print "<input type=\"checkbox\" name=\"chkValue\" $strChecked>";
            break;
          case "int":
          case "text":
            print "<input type=\"text\" value=\"$Value\" name=\"txtValue\" size=\"50\" >";
            break;
          default :
            print "<select size=\"1\" name=\"txtValue\">\n";
            $strQuery = "SELECT vcType, vcText FROM $ValueType ORDER BY iOrder;";
            $QueryData = QuerySQL($strQuery);

            if($QueryData[0] > 0)
            {
              foreach($QueryData[1] as $Row2)
              {
                if($Row2["vcType"] == $Value)
                {
                  print "<option selected value=\"{$Row2['vcType']}\">{$Row2['vcText']}</option>\n";
                }
                else
                {
                  print "<option value=\"{$Row2['vcType']}\">{$Row2['vcText']}</option>\n";
                }
              }
            }
            else
            {
              $strMsg = Array2String($QueryData[1]);
              error_log("Query of $strQuery did not return data. Rowcount: $QueryData[0] Msg:$strMsg");
              printPg($ErrMsg,"error");
            }
            print "</select>\n";
        }
        print "</td>\n";
        print "<td><input type=\"Submit\" value=\"Save\" name=\"btnSubmit\"></td>";
        print "</tr>\n";
        print "</form>\n";
      }
      else
      {
        print "$ValueDescr : $Value<br>\n";
      }
    }
  }
  else
  {
    $strMsg = Array2String($QueryData[1]);
    error_log("Query of $strQuery did not return data. Rowcount: $QueryData[0] Msg:$strMsg");
    printPg($ErrMsg,"error");
  }

  print "</table>\n";
  require("footer.php");
?>
