<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details   
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>

  Page to manage contact information details
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

	printPg("Contact information","h1");

	if(($PostVarCount == 1) and ($btnSubmit == "Go Back"))
	{
		header("Location: $strPageURL");
	}

	if($btnSubmit == "Save")
	{
    $iSortNum  = CleanSQLInput(substr(trim($_POST["iSortNum"]),0,49));
    $strValue  = CleanSQLInput(substr(trim($_POST["txtValue"]),0,49));
    $strType   = CleanSQLInput(substr(trim($_POST["cmbType"]),0,49));
    $strLabel  = CleanSQLInput(substr(trim($_POST["txtLabel"]),0,49));
    $ContactID = CleanSQLInput(substr(trim($_POST["iContactID"]),0,49));

    if($iSortNum == "")
    {
      $iSortNum = 0;
    }
    if($strValue== "")
    {
      printPg("Contact Value is requried","note");
    }
    else
    {
      $strQuery = "update tblContactInfo set vcType = '$strType', vcLabel = '$strLabel', vcValue = '$strValue', iSequence = $iSortNum where iContactID = $ContactID;";
      UpdateSQL($strQuery,"update");
    }
	}

	if($btnSubmit == "Delete")
	{
		$ContactID = substr(trim($_POST["iContactID"]),0,49);

		$strQuery = "delete from tblContactInfo where iContactID = $ContactID;";
		UpdateSQL($strQuery,"delete");
	}

	if($btnSubmit == "Insert")
	{
    $iSortNum = CleanSQLInput(substr(trim($_POST["iSortNum"]),0,49));
    $strValue = CleanSQLInput(substr(trim($_POST["txtValue"]),0,49));
    $strType  = CleanSQLInput(substr(trim($_POST["cmbType"]),0,49));
    $strLabel = CleanSQLInput(substr(trim($_POST["txtLabel"]),0,49));

    if($iSortNum == "")
    {
      $iSortNum = 0;
    }

    if($strValue== "")
    {
      printPg("Please provide a contact value to insert","note");
    }
    else
    {
      $strQuery = "insert tblContactInfo (vcValue, iSequence, vcLabel, vcType)"
                . "values ('$strValue',$iSortNum, '$strLabel', '$strType');";
      UpdateSQL($strQuery,"insert");
    }
	}

	//Print the normal form after update is complete.
	print "<table>\n";
  print "<tr>\n";
  print "<th class=lbl>Update existing Contacts</th>\n";
  print "<th width = 100></th>\n";
  print "<th class=lbl>Or Insert New one</th>\n";
  print "</tr>\n";
	print "<tr>\n";
  print "<td>\n";
  print "<table border = 0>\n";
  print "<tr>\n";
  print "<th></th>\n";
  print "<th class=lbl>Type</th>\n";
  print "<th class=lbl>Sort order</th>\n";
  print "<th class=lbl>Label</th>\n";
  print "<th class=lbl>Value</th>\n";
  print "</tr>\n";
	$strQuery = "SELECT vcValue, iSequence, iContactID, vcType, vcLabel FROM tblContactInfo order by vcType, iSequence;";
  $QueryData = QuerySQL($strQuery);

  if($QueryData[0] > 0)
  {
    foreach($QueryData[1] as $Row)
    {
      $strValue  = $Row["vcValue"];
      $iSortNum  = $Row["iSequence"];
      $ContactID = $Row["iContactID"];
      $strType   = $Row["vcType"];
      $strLabel  = $Row["vcLabel"];
      if($WritePriv <=  $Priv)
      {
        print "<form method=\"POST\">\n";
        print "<tr valign=\"top\">\n";
        print "<td><input type=\"hidden\" value=\"$ContactID\" name=\"iContactID\"> </td>\n";
        print "<td>\n";
        print "<select size=\"1\" name=\"cmbType\">\n";
        $strQuery = "SELECT vcTypes FROM tblContactTypes;";
        $QueryData2 = QuerySQL($strQuery);

        if($QueryData2[0] > 0)
        {
          foreach($QueryData2[1] as $Row2)
          {
            $vcTypes = $Row2["vcTypes"];
            if($vcTypes == $strType)
            {
              print "<option selected value=\"$vcTypes\">$vcTypes</option>\n";
            }
            else
            {
              print "<option value=\"$vcTypes\">$vcTypes</option>\n";
            }
          }
        }
        else
        {
          $strMsg = Array2String($QueryData2[1]);
          error_log("Query of $strQuery did not return data. Rowcount: $QueryData2[0] Msg:$strMsg");
          printPg($ErrMsg,"error");
        }
        print "</select>\n";
        print "</td>\n";
        print "<td><input type=\"text\" value=\"$iSortNum\" name=\"iSortNum\" size=\"5\" ></td>\n";
        print "<td><input type=\"text\" value=\"$strLabel\" name=\"txtLabel\" size=\"15\" ></td>\n";
        print "<td><input type=\"text\" value=\"$strValue\" name=\"txtValue\" size=\"25\" ></td>\n";
        print "<td><input type=\"Submit\" value=\"Save\" name=\"btnSubmit\"></td>";
        print "<td><input type=\"Submit\" value=\"Delete\" name=\"btnSubmit\"></td>";
        print "</tr>\n";
        print "</form>\n";
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
	print "</td>\n<td>\n</td>\n<td valign=\"top\">\n";
	print "<form method=\"POST\">\n";
	print "<table>\n";
	print "<tr>\n<td align = right class = lbl>Contact Type: </td>\n";
	print "<td>";
  print "<select size=\"1\" name=\"cmbType\">\n";
  $strQuery = "SELECT vcTypes FROM tblContactTypes;";
  $QueryData2 = QuerySQL($strQuery);

  if($QueryData2[0] > 0)
  {
    foreach($QueryData2[1] as $Row2)
    {
      $vcTypes = $Row2["vcTypes"];
      if($vcTypes == $strType)
      {
        print "<option selected value=\"$vcTypes\">$vcTypes</option>\n";
      }
      else
      {
        print "<option value=\"$vcTypes\">$vcTypes</option>\n";
      }
    }
  }
  else
  {
    $strMsg = Array2String($QueryData2[1]);
    error_log("Query of $strQuery did not return data. Rowcount: $QueryData2[0] Msg:$strMsg");
    printPg($ErrMsg,"error");
  }
  print "</select>\n";
  print "</td>\n</tr>\n";
	print "<tr>\n<td align = right class = lbl>Sort Order: </td>\n";
	print "<td><input type=\"text\" name=\"iSortNum\" size=\"13\" ></td></tr>\n";
	print "<tr>\n<td align = right class = lbl>Contact Label: </td>\n";
	print "<td><input type=\"text\" name=\"txtLabel\" size=\"30\" ></td>\n</tr>\n";
	print "<tr>\n<td align = right class = lbl>Contact Value: </td>\n";
	print "<td><input type=\"text\" name=\"txtValue\" size=\"30\" ></td>\n</tr>\n";
	print "<tr><td colspan=2 align=center><input type=\"Submit\" value=\"Insert\" name=\"btnSubmit\"></td></tr>\n";
	print "</table>\n";
	print "</form>\n</td>\n</tr>\n</table>";

	require("footer.php");
?>
