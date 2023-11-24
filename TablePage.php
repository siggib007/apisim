<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details   
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>
  
  Dynamic Table Page
  */

	require("header.php");
	
	$strQuery = "SELECT * FROM tblPageTable WHERE iMenuID = '$iMenuID'";
  $QueryData = QuerySQL($strQuery);
  if($QueryData[0] > 0)
  {
    foreach($QueryData[1] as $Row)
    {
      $PageHeader = $Row["vcPageHeader"];
      $ColumnList = $Row["vcColumnList"];
      $TableName  = $Row["vcTableName"];
      $FilterStr  = $Row["vcFilterStr"];
      $iLimit     = $Row["iLimit"];
    }
  }
  else
  {
    if($QueryData[0] == 0)
    {
      printPg("Unknown Page ID $iMenuID","error");
      exit;
    }
    else
    {
      $strMsg = Array2String($QueryData[1]);
      error_log("Query of $strQuery did not return data. Rowcount: $QueryData[0] Msg:$strMsg");
      printPg($ErrMsg,"error");
    }
  }
	
	$strQuery = "SELECT $ColumnList FROM $TableName ";
	if($FilterStr != "")
	{
		$strQuery .= "WHERE $FilterStr ";
	}
	$strQuery .= "LIMIT $iLimit;";
	
	printPg("$PageHeader","h1");

  $QueryData = QuerySQL($strQuery);
  if($QueryData[0] > 0)
  {
    print "<table class=OutlineCenter>\n<tr>\n";
    $RowKeys = array_keys($QueryData[1][0]);
    foreach($RowKeys as $key)
    {
      print "<th class=OutlineCenter>$key</th>\n";
    }
    print "</tr>\n<tr>";
    foreach($QueryData[1] as $Row)
    {
      print "<tr class=OutlineCenter>";
      foreach($Row as $key => $value)
      {
        print "<td class=OutlineCenter>$value</td>";
      }
      print "</tr>\n";
    }
    print "</table>\n</center>\n";
  }
  else
  {
    if($QueryData[0] == 0)
    {
      printPg("$TableName has no Records","note");
    }
    else
    {
      if(is_string($QueryData[1]))
      {
        $strMsg = $QueryData[1];
      }
      else 
      {
        $strMsg = Array2String($QueryData[1]);
      }
      printPg($strMsg,"error");
    }
  }
	
	require("footer.php");
?>