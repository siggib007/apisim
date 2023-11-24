<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details   
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>

  Page for statistics
  */

	$col0 = "15%";
	$col0 = 250;
	$col1 = 200;
	$col2 = 800;
	$Tcol = $col1 + $col2 ;
	$PostVarCount = count($_POST);
	if(isset($_POST["btnSubmit"]))
	{
		$btnSubmit = $_POST["btnSubmit"];
	}
	else
	{
		$btnSubmit = "";
	}

	if(($PostVarCount == 1) and ($btnSubmit == "Go Back"))
	{
		unset($_POST);
		$PostVarCount = 0;
	}
	require("header.php");
	printPg("Web site statistics","h1");

	if($btnSubmit == "New")
	{
		if($WritePriv <=  $Priv)
		{
			$strQuery =  "SELECT max(iOrderID) as MaxOrderID FROM tblstats;";
      $iNextOrderID = GetSQLValue($strQuery) + 1;

			print "<center><form method=\"POST\">\n<input type=\"Submit\" value=\"Go Back\" name=\"btnSubmit\"></form></center>";
			print "<form method=\"POST\">\n";
			print "<table border=\"0\" width=\"$Tcol\">\n";
			print "<tr>\n<td width=\"$col0\">&nbsp;</td>\n";
			print "<td colspan=2 class=\"lbl\">Statistic Label or Name: </td>\n</tr>\n";
			print "<tr>\n<td width=\"$col0\">&nbsp;</td>\n";
			print "<td colspan=2><input type=\"text\" name=\"txtStatName\" size=\"88\"></td>\n";
			print "</tr>\n";
			print "<tr>\n<td width=\"$col0\">&nbsp;</td>\n";
			print "<td colspan=2 class=\"lbl\">From Clause with out the 'from' keyword:</td>\n";
			print "</tr>\n";
			print "<tr>\n<td width=\"$col0\">&nbsp;</td>\n";
			print "<td colspan=2 ><textarea name=\"txtFrom\" rows=\"3\" cols=\"90\"></textarea></td>\n";
			print "</tr>\n";
			print "<tr>\n<td width=\"$col0\">&nbsp;</td>\n";
			print "<td colspan=2  class=\"lbl\">[Optional] Where Clause with out the 'where' keyword:</td>\n</tr>\n";
			print "<tr>\n<td width=\"$col0\">&nbsp;</td>\n";
			print "<td colspan=2 ><textarea name=\"txtWhere\" rows=\"3\" cols=\"90\"></textarea></td>\n";
			print "</tr>\n";
			print "<tr>\n<td width=\"$col0\">&nbsp;</td>\n";
			print "<td width=\"$col1\" align=\"right\" class=\"lbl\">[Optional] Group By: </td>\n";
			print "<td width=\"$col2\" align=\"left\"><input type=\"text\" name=\"txtGroupBy\" size=\"53\"></td>\n";
			print "</tr>\n";
			print "<tr>\n<td width=\"$col0\">&nbsp;</td>\n";
			print "<td width=\"$col1\" align=\"right\" class=\"lbl\">[Optional] Distinct Column: </td>\n";
			print "<td width=\"$col2\" align=\"left\"><input type=\"text\" name=\"txtUnique\" size=\"53\"></td>\n";
			print "</tr>\n";
			print "<tr>\n<td width=\"$col0\">&nbsp;</td>\n";
			print "<td width=\"$col1\" align=\"right\" class=\"lbl\">Order number: </td>\n";
			print "<td width=\"$col2\" align=\"left\"><input type=\"text\" name=\"txtOrderID\" size=\"5\" value=$iNextOrderID></td>\n";
			print "</tr>\n";
			print "<tr>\n<td width=\"$col0\">&nbsp;</td>\n";
			print "<td>&nbsp;</td>\n<td align=left><input type=\"Submit\" value=\"Insert\" name=\"btnSubmit\"></td>\n";
			print "</tr>\n";
			print "</table>\n";
			print "</form>\n";
		}
	}

	if($btnSubmit == "Delete")
	{
		$iStatID = intval(trim($_POST["txtStatID"]));
		$strQuery =  "SELECT vcStatName FROM tblstats where iStatID=$iStatID;";
    $strStatName = GetSQLValue($strQuery);
		printPg("Are you sure you wish to delete statistic with the label \"$strStatName\"? <br>" .
		        "Just leave this page anyway you please if you do not want to delete it.","alert");
		print "<form method=\"POST\">\n";
		print "<div class=MainTextCenter><input type=\"Submit\" value=\"Yes I am sure!\" name=\"btnSubmit\"></div>";
		print "<input type=\"hidden\" value=\"$iStatID\" name=\"txtStatID\"></form>\n</center>\n";
	}

	if($btnSubmit == "Yes I am sure!")
	{
		$iStatID = intval(trim($_POST["txtStatID"]));
		$strQuery = "Delete from tblstats where iStatID=$iStatID;";
		$type = "Delete";
		UpdateSQL($strQuery,$type);
		unset($_POST);
		$PostVarCount = 0;
	}

	if($btnSubmit == "Edit")
	{
		$iStatID = intval(trim($_POST["txtStatID"]));
		$strQuery =  "SELECT iStatID,vcFromClause,vcWhereClause,vcGroupByClause,vcUnique,vcStatName, iOrderID FROM tblstats where iStatID=$iStatID;";
    $QueryData = QuerySQL($strQuery);
    if($QueryData[0] > 0)
    {
      foreach($QueryData[1] as $Row)
      {
        $strStatName = $Row["vcStatName"];
        $strFrom = $Row["vcFromClause"];
        $strWhere = $Row["vcWhereClause"];
        $strGroupBy = $Row["vcGroupByClause"];
        $strUnique = $Row["vcUnique"];
        $iOrder = $Row["iOrderID"];
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
		
    print "<form method=\"POST\">\n<input type=\"Submit\" value=\"Go Back\" name=\"btnSubmit\"></form>";
		print "<form method=\"POST\">\n";
		print "<table border=\"0\" width=\"$Tcol\">\n";
		print "<tr>\n<td width=\"$col0\">&nbsp;</td>\n";
		print "<td colspan=2 class=\"lbl\">Statistic Label or Name: </td>\n</tr>\n";
		print "<tr>\n<td width=\"$col0\">&nbsp;</td>\n";
		print "<td colspan=2><input type=\"text\" name=\"txtStatName\" size=\"88\" value=\"$strStatName\"></td>\n";
		print "</tr>\n";
		print "<tr>\n<td width=\"$col0\">&nbsp;</td>\n";
		print "<td colspan=2 class=\"lbl\">From Clause with out the 'from' keyword:</td>\n";
		print "</tr>\n";
		print "<tr>\n<td width=\"$col0\">&nbsp;</td>\n";
		print "<td colspan=2 ><textarea name=\"txtFrom\" rows=\"3\" cols=\"90\">$strFrom</textarea></td>\n";
		print "</tr>\n";
		print "<tr>\n<td width=\"$col0\">&nbsp;</td>\n";
		print "<td colspan=2  class=\"lbl\">[Optional] Where Clause with out the 'where' keyword:</td>\n</tr>\n";
		print "<tr>\n<td width=\"$col0\">&nbsp;</td>\n";
		print "<td colspan=2 ><textarea name=\"txtWhere\" rows=\"3\" cols=\"90\">$strWhere</textarea></td>\n";
		print "</tr>\n";
		print "<tr>\n<td width=\"$col0\">&nbsp;</td>\n";
		print "<td width=\"$col1\" align=\"right\" class=\"lbl\">[Optional] Group By: </td>\n";
		print "<td width=\"$col2\" align=\"left\"><input type=\"text\" name=\"txtGroupBy\" size=\"53\" value=\"$strGroupBy\"></td>\n";
		print "</tr>\n";
		print "<tr>\n<td width=\"$col0\">&nbsp;</td>\n";
		print "<td width=\"$col1\" align=\"right\" class=\"lbl\">[Optional] Distinct Column: </td>\n";
		print "<td width=\"$col2\" align=\"left\"><input type=\"text\" name=\"txtUnique\" size=\"53\" value=\"$strUnique\"></td>\n";
		print "</tr>\n";
		print "<tr>\n<td width=\"$col0\">&nbsp;</td>\n";
		print "<td width=\"$col1\" align=\"right\" class=\"lbl\">Order number: </td>\n";
		print "<td width=\"$col2\" align=\"left\"><input type=\"text\" name=\"txtOrderID\" size=\"5\" value=\"$iOrder\"></td>\n";
		print "</tr>\n";
		print "<tr>\n<td width=\"$col0\">&nbsp;</td>\n";
		print "<td><input type=\"hidden\" name=\"txtStatID\" size=\"5\" value=\"$iStatID\"></td>\n";
		print "<td align=left><input type=\"Submit\" value=\"Update\" name=\"btnSubmit\"></td>\n";
		print "</tr>\n";
		print "</table>\n";
		print "</form>\n";
	}

	if($btnSubmit == "Update")
	{
		$strStatName = substr(CleanSQLInput(trim($_POST["txtStatName"])),0,49);
		$strFrom = substr(CleanSQLInput(trim($_POST["txtFrom"])),0,299);
		$strWhere = substr(CleanSQLInput(trim($_POST["txtWhere"])),0,299);
		$strGroupBy = substr(CleanSQLInput(trim($_POST["txtGroupBy"])),0,99);
		$strUnique = substr(CleanSQLInput(trim($_POST["txtUnique"])),0,29);
		$iOrder = substr(CleanSQLInput(trim($_POST["txtOrderID"])),0,9);
		$iStatID = substr(CleanSQLInput(trim($_POST["txtStatID"])),0,9);
		if($strStatName != "" and $strFrom != "" and is_numeric($iOrder))
		{
			$strQuery =  "update tblstats set vcFromClause='$strFrom', vcWhereClause='$strWhere',vcGroupByClause='$strGroupBy', ";
			$strQuery .= " vcUnique='$strUnique', vcStatName='$strStatName', iOrderID='$iOrder', vcModifiedBy='$UsersName', dtModifiedTime=now()";
			$strQuery .= " where iStatID=$iStatID;";
			$type = "updated";
			UpdateSQL($strQuery,$type);
			unset($_POST);
			$PostVarCount = 0;
		}
		else
		{
			printPg("Invalid data submitted. Required entries missing or Order number is not a number","error");
			print "<form method=\"POST\">\n";
			print "<table border=\"0\" width=\"$Tcol\">\n";
			print "<tr>\n<td width=\"$col0\">&nbsp;</td>\n";
			print "<td colspan=2 class=\"lbl\">Statistic Label or Name: </td>\n</tr>\n";
			print "<tr>\n<td width=\"$col0\">&nbsp;</td>\n";
			print "<td colspan=2><input type=\"text\" name=\"txtStatName\" size=\"88\" value=\"$strStatName\"></td>\n";
			print "</tr>\n";
			print "<tr>\n<td width=\"$col0\">&nbsp;</td>\n";
			print "<td colspan=2 class=\"lbl\">From Clause with out the 'from' keyword:</td>\n";
			print "</tr>\n";
			print "<tr>\n<td width=\"$col0\">&nbsp;</td>\n";
			print "<td colspan=2 ><textarea name=\"txtFrom\" rows=\"3\" cols=\"90\">$strFrom</textarea></td>\n";
			print "</tr>\n";
			print "<tr>\n<td width=\"$col0\">&nbsp;</td>\n";
			print "<td colspan=2  class=\"lbl\">[Optional] Where Clause with out the 'where' keyword:</td>\n</tr>\n";
			print "<tr>\n<td width=\"$col0\">&nbsp;</td>\n";
			print "<td colspan=2 ><textarea name=\"txtWhere\" rows=\"3\" cols=\"90\">$strWhere</textarea></td>\n";
			print "</tr>\n";
			print "<tr>\n<td width=\"$col0\">&nbsp;</td>\n";
			print "<td width=\"$col1\" align=\"right\" class=\"lbl\">[Optional] Group By: </td>\n";
			print "<td width=\"$col2\" align=\"left\"><input type=\"text\" name=\"txtGroupBy\" size=\"53\" value=\"$strGroupBy\"></td>\n";
			print "</tr>\n";
			print "<tr>\n<td width=\"$col0\">&nbsp;</td>\n";
			print "<td width=\"$col1\" align=\"right\" class=\"lbl\">[Optional] Distinct Column: </td>\n";
			print "<td width=\"$col2\" align=\"left\"><input type=\"text\" name=\"txtUnique\" size=\"53\" value=\"$strUnique\"></td>\n";
			print "</tr>\n";
			print "<tr>\n<td width=\"$col0\">&nbsp;</td>\n";
			print "<td width=\"$col1\" align=\"right\" class=\"lbl\">Order number: </td>\n";
			print "<td width=\"$col2\" align=\"left\"><input type=\"text\" name=\"txtOrderID\" size=\"5\" value=\"$iOrder\"></td>\n";
			print "</tr>\n";
			print "<tr>\n<td width=\"$col0\">&nbsp;</td>\n";
			print "<td><input type=\"hidden\" name=\"txtStatID\" size=\"5\" value=\"$iStatID\"></td>\n";
			print "<td align=left><input type=\"Submit\" value=\"Update\" name=\"btnSubmit\"></td>\n";
			print "</tr>\n";
			print "</table>\n";
			print "</form>\n";
		}
	}

	if($btnSubmit == "Insert")
	{
		$strStatName = substr(CleanSQLInput(trim($_POST["txtStatName"])),0,49);
		$strFrom = substr(CleanSQLInput(trim($_POST["txtFrom"])),0,299);
		$strWhere = substr(CleanSQLInput(trim($_POST["txtWhere"])),0,299);
		$strGroupBy = substr(CleanSQLInput(trim($_POST["txtGroupBy"])),0,99);
		$strUnique = substr(CleanSQLInput(trim($_POST["txtUnique"])),0,29);
		$iOrder = substr(CleanSQLInput(trim($_POST["txtOrderID"])),0,9);
		if($strStatName != "" and $strFrom != "" and is_numeric($iOrder))
		{
			$strQuery =  "INSERT INTO tblstats (vcFromClause, vcWhereClause, vcGroupByClause, vcUnique, vcStatName, iOrderID, vcModifiedBy, dtModifiedTime) ";
			$strQuery .= " VALUES ('$strFrom', '$strWhere', '$strGroupBy', '$strUnique', '$strStatName', '$iOrder','$UsersName',now());";
			$type = "insert";
			UpdateSQL($strQuery,$type);
			unset($_POST);
			$PostVarCount = 0;
		}
		else
		{
			printPg("Invalid data submitted. Required entries missing or Order number is not a number","error");
			print "<form method=\"POST\">\n";
			print "<table border=\"0\" width=\"$Tcol\">\n";
			print "<tr>\n<td width=\"$col0\">&nbsp;</td>\n";
			print "<td colspan=2 class=\"lbl\">Statistic Label or Name: </td>\n</tr>\n";
			print "<tr>\n<td width=\"$col0\">&nbsp;</td>\n";
			print "<td colspan=2><input type=\"text\" name=\"txtStatName\" size=\"88\" value=\"$strStatName\"></td>\n";
			print "</tr>\n";
			print "<tr>\n<td width=\"$col0\">&nbsp;</td>\n";
			print "<td colspan=2 class=\"lbl\">From Clause with out the 'from' keyword:</td>\n";
			print "</tr>\n";
			print "<tr>\n<td width=\"$col0\">&nbsp;</td>\n";
			print "<td colspan=2 ><textarea name=\"txtFrom\" rows=\"3\" cols=\"90\">$strFrom</textarea></td>\n";
			print "</tr>\n";
			print "<tr>\n<td width=\"$col0\">&nbsp;</td>\n";
			print "<td colspan=2  class=\"lbl\">[Optional] Where Clause with out the 'where' keyword:</td>\n</tr>\n";
			print "<tr>\n<td width=\"$col0\">&nbsp;</td>\n";
			print "<td colspan=2 ><textarea name=\"txtWhere\" rows=\"3\" cols=\"90\">$strWhere</textarea></td>\n";
			print "</tr>\n";
			print "<tr>\n<td width=\"$col0\">&nbsp;</td>\n";
			print "<td width=\"$col1\" align=\"right\" class=\"lbl\">[Optional] Group By: </td>\n";
			print "<td width=\"$col2\" align=\"left\"><input type=\"text\" name=\"txtGroupBy\" size=\"53\" value=\"$strGroupBy\"></td>\n";
			print "</tr>\n";
			print "<tr>\n<td width=\"$col0\">&nbsp;</td>\n";
			print "<td width=\"$col1\" align=\"right\" class=\"lbl\">[Optional] Distinct Column: </td>\n";
			print "<td width=\"$col2\" align=\"left\"><input type=\"text\" name=\"txtUnique\" size=\"53\" value=\"$strUnique\"></td>\n";
			print "</tr>\n";
			print "<tr>\n<td width=\"$col0\">&nbsp;</td>\n";
			print "<td width=\"$col1\" align=\"right\" class=\"lbl\">Order number: </td>\n";
			print "<td width=\"$col2\" align=\"left\"><input type=\"text\" name=\"txtOrderID\" size=\"5\" value=\"$iOrder\"></td>\n";
			print "</tr>\n";
			print "<tr>\n<td width=\"$col0\">&nbsp;</td>\n";
			print "<td>&nbsp;</td>\n<td align=left><input type=\"Submit\" value=\"Insert\" name=\"btnSubmit\"></td>\n";
			print "</tr>\n";
			print "</table>\n";
			print "</form>\n";
		}
	}


	if($PostVarCount == 0)
	{
		if($WritePriv <=  $Priv)
		{
			print "<center><form method=\"POST\">\n<input type=\"Submit\" value=\"New\" name=\"btnSubmit\"></form></center>";
		}
		print "<table align=center cellpadding=1>\n";
		$strQuery =  "SELECT iStatID,vcFromClause,vcWhereClause,vcGroupByClause,vcUnique,vcStatName FROM tblstats order by iOrderID;";
    $QueryData = QuerySQL($strQuery);
    if($QueryData[0] > 0)
    {
      foreach($QueryData[1] as $Row)
      {
        if($Row["vcGroupByClause"] == "")
        {
          $GroupBy = "";
          $GroupOn = "";
          $GroupHeader = "";
        }
        else
        {
          $GroupBy = " Group by {$Row['vcGroupByClause']}";
          $GroupOn = "{$Row['vcGroupByClause']} 'Group',";
          $GroupHeader = $Row["vcGroupByClause"];
        }
        if($Row["vcWhereClause"] == "")
        {
          $Where = "";
        }
        else
        {
          $Where = " where {$Row["vcWhereClause"]}";
        }
        if($Row["vcUnique"] == "")
        {
          $Unique = "*";
        }
        else
        {
          $Unique = " Distinct {$Row['vcUnique']}";
        }
        $From = $Row["vcFromClause"];
        $StatName = $Row["vcStatName"];
        $StatID = $Row["iStatID"];
        $iLoopCount = 0;
        $strQuery = "select '$StatName' as 'Name', $GroupOn Count($Unique) as 'Count' from $From $Where $GroupBy";
        $StatResult = QuerySQL($strQuery);
        $NumAffected = $StatResult[0];
        if($StatResult[0] > 0)
        {
          foreach($StatResult[1] as $SRow)
          {
            print "<tr>\n";
            print "<td>{$SRow['Name']} ";
            if($GroupHeader != "")
            {
              print " - {$SRow['Group']}";
            }
            print " : {$SRow['Count']}</td>\n";
            if(($WritePriv <=  $Priv) and ($iLoopCount < 1))
            {
              print "<td align=right width=200 rowspan=$NumAffected><form method=\"POST\">\n";
              print "<input type=\"Submit\" value=\"Edit\" name=\"btnSubmit\">\n";
              print "<input type=\"hidden\" value=\"$StatID\" name=\"txtStatID\">\n";
              print "<input type=\"Submit\" value=\"Delete\" name=\"btnSubmit\">\n";
              print "</form>\n</td>";
              $iLoopCount ++;
            }
            print "</tr>\n";
          }
        }
        else
        {
          if($StatResult[0] == 0)
          {
            printPg("No Records","note");
          }
          else
          {
            $strMsg = Array2String($StatResult[1]);
            error_log("Query of $strQuery did not return data. Rowcount: $StatResult[0] Msg:$strMsg");
            print "<tr>\n";
            print "<td>$StatName : error</td>\n";
            if(($WritePriv <=  $Priv) and ($iLoopCount < 1))
            {
              print "<td align=right width=200 rowspan=$NumAffected><form method=\"POST\">\n";
              print "<input type=\"Submit\" value=\"Edit\" name=\"btnSubmit\">\n";
              print "<input type=\"hidden\" value=\"$StatID\" name=\"txtStatID\">\n";
              print "<input type=\"Submit\" value=\"Delete\" name=\"btnSubmit\">\n";
              print "</form>\n</td>";
              $iLoopCount ++;
            }
            print "</tr>\n";
          }
        }
      }
    }
    else
    {
      if($QueryData[0] == 0)
      {
        printPg("No statistics have been defined","alert");
      }
      else
      {
        $strMsg = Array2String($QueryData[1]);
        error_log("Query of $strQuery did not return data. Rowcount: $QueryData[0] Msg:$strMsg");
        printPg($ErrMsg,"error");
      }
    }
		print "</table>\n";
	}

	require("footer.php");
?>
