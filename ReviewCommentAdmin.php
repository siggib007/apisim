<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>

  Manages the Review Comments
  */

	require("header.php");

  $DocRoot = "ReviewMedia/";

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

	printPg("Feedback Administration","h1");

	if($btnSubmit == "Save")
	{
		$iFeedbackID = CleanSQLInput(substr(trim($_POST["iFeedbackID"]),0,9));
		$strFeedbackName = CleanSQLInput(substr(trim($_POST["txtFeedbackName"]),0,99));
		$strDescr = CleanSQLInput($_POST["txtDescr"]);
		$strMMURL= CleanSQLInput(substr(trim($_POST["txtMMURL"]),0,99));
    $strImgPath="";

    if(isset($_FILES["fPict"]))
    {
      if($_FILES["fPict"]["name"]!="")
      {
        $tmpFile = $_FILES["fPict"]["tmp_name"];
        $Error = $_FILES["fPict"]["error"];
        $DocFileName = $_FILES["fPict"]["name"];
        $DocBaseName = str_replace(" ","_",basename($DocFileName));
        $newPath = $DocRoot . $DocBaseName;
        if($Error == UPLOAD_ERR_OK)
        {
          if(move_uploaded_file($tmpFile, $newPath))
          {
            $strImgPath = $newPath;
            printPg("File $DocBaseName uploaded successfully","normal");
          }
          else
          {
            printPg("Couldn't move file to $newPath","error");
          }
        }
        else
        {
          $ErrMsg = codeToMessage($Error);
          printPg("Error \"$ErrMsg\" while uploading $DocFileName","error");
        }
      }
    }

    if($strImgPath == "")
    {
      $strImgPath = $strMMURL;
    }

		$strQuery = "update tblFeedback set vcFeedbackName = '$strFeedbackName', "
              . "tFeedbackDescr = '$strDescr', vcImgPath = '$strImgPath' where iFeedbackID = $iFeedbackID;";
		UpdateSQL($strQuery,"update");
	}

	if($btnSubmit == "Delete")
	{
		$iFeedbackID = CleanSQLInput(substr(trim($_POST["iFeedbackID"]),0,9));

		$strQuery = "delete from tblFeedback where iFeedbackID = $iFeedbackID;";
		UpdateSQL($strQuery,"delete");
	}

	if($btnSubmit == "Insert")
	{
		$strFeedbackName = CleanSQLInput(substr(trim($_POST["txtFeedbackName"]),0,99));
		$strDescr = CleanSQLInput($_POST["txtDescr"]);
		$strMMURL = CleanSQLInput(substr(trim($_POST["txtMMURL"]),0,99));
    $strImgPath ="";

    if(isset($_FILES["fPict"]))
    {
      if($_FILES["fPict"]["name"]!="")
      {
        $tmpFile = $_FILES["fPict"]["tmp_name"];
        $Error = $_FILES["fPict"]["error"];
        $DocFileName = $_FILES["fPict"]["name"];
        $DocBaseName = basename($DocFileName);
        $newPath = $DocRoot . $DocBaseName;
        if($Error == UPLOAD_ERR_OK)
        {
          if(move_uploaded_file($tmpFile, $newPath))
          {
            $strImgPath = $newPath;
            printPg("File $DocBaseName uploaded successfully<br>","normal");
          }
          else
          {
            printPg("Couldn't save file to $newPath","error");
          }
        }
        else
        {
          $ErrMsg = codeToMessage($Error);
          printPg("Error \"$ErrMsg\" while uploading $DocFileName","error");
        }
      }
      else
      {
        $strImgPath = $strMMURL;
      }
    }
    else
    {
      $strImgPath = $strMMURL;
    }

		if($strFeedbackName == "")
		{
			printPg("Please provide a name for the feedback to insert","error");
		}
		else
		{
			$strQuery = "insert tblFeedback (vcFeedbackName, tFeedbackDescr, vcImgPath) "
                . "values ('$strFeedbackName','$strDescr', '$strImgPath');";
			UpdateSQL($strQuery,"insert");
		}
	}

	//Print the normal form after update is complete.
	print "<table>\n";
  print "<tr>\n";
  print "<th>Update existing feedback</th>\n";
  print "<th width = 100></th>\n";
  if($btnSubmit != "Edit")
  {
    print "<th class=lbl>Or Insert New one</th>";
  }
	print "</tr>\n";
  print "<tr>\n";
  print "<td valign=\"top\">\n";
  print "<table border = 0>\n";
	$strQuery = "select iFeedbackID, vcFeedbackName, tFeedbackDescr from tblFeedback;";
  $QueryData = QuerySQL($strQuery);
  if($QueryData[0] > 0)
  {
    foreach($QueryData[1] as $Row)
    {
      $vcFeedbackName = $Row["vcFeedbackName"];
      $iFeedbackID = $Row["iFeedbackID"];
      if ($WritePriv <=  $Priv)
      {
        print "<form method=\"POST\">\n";
        print "<tr valign=\"top\">\n";
        print "<td class=\"lbl\"><input type=\"hidden\" value=\"$iFeedbackID\" name=\"iFeedbackID\"></td>\n";
        print "<td>$vcFeedbackName</td>\n";
        print "<td><input type=\"Submit\" value=\"Edit\" name=\"btnSubmit\"></td>";
        print "<td><input type=\"Submit\" value=\"Delete\" name=\"btnSubmit\"></td>";
        print "</tr>\n";
        print "</form>\n";
      }
      else
      {
        print "<tr><td>$vcFeedbackName</td></tr>\n";
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

	print "</table>\n";
  print "<form method=\"POST\">\n";
  print "<input type=\"Submit\" value=\"Go Back\" name=\"btnSubmit\">\n";
  print "</form>";
	print "</td>\n";
  print "<td>\n";
  print "</td>\n";
  print "<td valign=\"top\">\n";

  if(isset($_POST["iFeedbackID"]) and $btnSubmit == "Edit")
  {
    $iFeedbackID = $_POST["iFeedbackID"];
    $strQuery = "select iFeedbackID, vcFeedbackName, tFeedbackDescr, vcImgPath from tblFeedback where iFeedbackID = $iFeedbackID;";
    $QueryData = QuerySQL($strQuery);
    if($QueryData[0] > 0)
    {
      foreach($QueryData[1] as $Row)
      {
        $strFeedbackName = $Row["vcFeedbackName"];
        $strClassDescr = $Row["tFeedbackDescr"];
        $strMMURL = $Row["vcImgPath"];
        $strBtnLabel = "Save";
      }
    }
    else
    {
      if($QueryData[0] == 0)
      {
        $strFeedbackName = "";
        $strClassDescr = "";
        $iFeedbackID = "";
        $strMMURL ="";
        $strBtnLabel = "Insert";
      }
      else
      {
        $strMsg = Array2String($QueryData[1]);
        error_log("Query of $strQuery did not return data. Rowcount: $QueryData[0] Msg:$strMsg");
        printPg($ErrMsg,"error");
      }
    }

  }
  else
  {
    $strFeedbackName = "";
    $strClassDescr = "";
    $iFeedbackID = "";
    $strMMURL ="";
    $strBtnLabel = "Insert";
  }
	print "<form method=\"POST\" enctype=\"multipart/form-data\">\n";
  print "<input type=\"hidden\" value=\"$iFeedbackID\" name=\"iFeedbackID\">";
	print "<span class=\"lbl\">Feedback Name:</span>\n";
	print "<input type=\"text\" name=\"txtFeedbackName\" size=\"70\" value=\"$strFeedbackName\"><br>\n";
  print "<span class=\"lbl\">Attach Picture: </span>\n";
  print "<input type=\"File\" name=\"fPict\" size=\"30\" >\n<br>\n";
  print "<span class=\"lbl\">Or specify a URL to picture or video:</span>\n";
	print "<input type=\"text\" name=\"txtMMURL\" size=\"47\" value=\"$strMMURL\"><br>\n";
  print "<div class=\"lbl\">Description:</div>\n";
  print "<textarea name=\"txtDescr\" rows=\"10\" cols=\"80\">$strClassDescr</textarea>\n<br>\n";
	print "<div align=\"center\"><input type=\"Submit\" value=\"$strBtnLabel\" name=\"btnSubmit\"></div>\n";
	print "</form>\n";
  if(isset($_POST["iFeedbackID"]))
  {
    print "<form method=\"POST\">\n";
    print "<input type=\"Submit\" value=\"Go Back\" name=\"btnSubmit\">\n";
    print "</form>\n";
  }
	print "</td>\n";
  print "</tr>\n";
  print "</table>\n";

	require("footer.php");
?>
