<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>

  Page to manage and maintain dynamic pages
  */

  require("header.php");

  $TextTemplatefile = "TemplatePage.php";
  $TableTemplateFile = "TablePage.php";

  if(isset($_POST["btnSubmit"]))
  {
    $btnSubmit = $_POST["btnSubmit"];
  }
  else
  {
    $btnSubmit = "";
  }
  if(isset($_POST["PageID"]))
  {
    $iPageID = intval(substr(trim($_POST["PageID"]),0,49));
  }
  else
  {
    $iPageID = -10;
  }

  if(isset($_POST["cmbType"]))
  {
    $PageType = intval($_POST["cmbType"]);
  }
  else
  {
    $strQuery = "SELECT bCont FROM tblmenu WHERE iMenuID = '$iPageID';";
    $PageType = GetSQLValue($strQuery);
  }

  if($strReferer != $strPageURL and $PostVarCount > 0)
  {
    printPg("Invalid operation, Bad Reference!!!","error");
    exit;
  }

  switch($PageType)
  {
    case 1:
        $Templatefile = $TextTemplatefile;
        $AdminPage = 0;
        $PrivLevel = 500;
        break;
    case 2:
        $Templatefile = $TableTemplateFile;
        $AdminPage = 7;
        $PrivLevel = 300;
        break;
  }

  printPg("Page Maintenace","h1");

  if(($btnSubmit == "Create New") and ($PageType == 2) or (($btnSubmit == "Edit") and ($PageType == 2)))
  {
    print "<div class=\"MainTextCenter\"><form method=\"POST\">\n<input type=\"Submit\" value=\"Go Back\" name=\"btnSubmit\"></form></div>";
    print "<form method=\"POST\">\n";
    if($iPageID > 0)
    {
      $strQuery = "SELECT * FROM tblPageTable WHERE iMenuID = '$iPageID';";
      $QueryData = QuerySQL($strQuery);
      if($QueryData[0] > 0)
      {
        foreach($QueryData[1] as $Row)
        {
          $PageHeader = $Row["vcPageHeader"];
          $strFields  = $Row["vcColumnList"];
          $strTable   = $Row["vcTableName"];
          $strFilter  = $Row["vcFilterStr"];
          $iLimit     = $Row["iLimit"];
          $RecID      = $Row["iTableID"];
        }
      }
      else
      {
        if($QueryData[0] == 0)
        {
          $PageHeader = "Can't find page ID $iPageID";
          $strFields  = "";
          $strTable   = "";
          $strFilter  = "";
          $iLimit     = "";
          $RecID      = "";
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
      $PageHeader = "";
      $strFields  = "*";
      $strTable   = "";
      $strFilter  = "";
      $iLimit     = "3000";
      $RecID      = "";
      print "<span class=\"lbl\">Page Name:</span>\n";
      print "<input type=\"text\" name=\"txtName\" size=\"25\">\n";
      print "<span class=\"lbl\">Page Title:</span>\n";
      print "<input type=\"text\" name=\"txtTitle\" size=\"25\">\n";
      print "<span class=\"lbl\">File Name:</span>\n";
      print "<input type=\"text\" name=\"txtFile\" size=\"25\">\n<br>\n";
    }
    print "<div class=\"lbl\">Page Main header: </div>\n";
    print "<input type=\"text\" name=\"txtHeader\" size=\"90\" value=\"$PageHeader\"><br>\n";
    print "<div class=\"lbl\">List of columns, comma seperate:</div>\n";
    print "<textarea name=\"txtFields\" rows=\"3\" cols=\"90\">$strFields</textarea><br>\n";
    print "<div class=\"lbl\">Table name:</div>\n";
    print "<input type=\"text\" name=\"txtFrom\" size=\"90\" value=\"$strTable\"><br>\n";
    print "<div class=\"lbl\">[Optional] Filter criteria:</div>\n";
    print "<textarea name=\"txtWhere\" rows=\"3\" cols=\"90\">$strFilter</textarea><br>\n";
    print "<span class=\"lbl\">Limit results to: </span>\n";
    print "<input type=\"text\" name=\"txtLimit\" size=\"5\" value=\"$iLimit\"><br>\n";
    print "<input type=\"hidden\" name=\"PageID\" size=\"5\" value=\"$iPageID\">";
    print "<input type=\"hidden\" name=\"RecID\" size=\"5\" value=\"$RecID\">";
    print "<input type=\"hidden\" name=\"cmbType\" size=\"5\" value=\"2\">";
    print "<input type=\"Submit\" value=\"Save\" name=\"btnSubmit\"><br>\n";
    print "</form>\n";
  }

  if(
      ($btnSubmit == "Edit" and $PageType == 1)
      or ($btnSubmit == "Create New" and $PageType == 1)
      or ($btnSubmit == "Change")
      )
  {
    print "<div class=\"MainTextCenter\"><form method=\"POST\">\n<input type=\"Submit\" value=\"Go Back\" name=\"btnSubmit\"></form></div>";
    $PageHeader="";
    $PageText = "";

    printPg("It is advised that the Page body is composed off-line and pasted here to " .
            "avoid data loss in case of network error, etc.","note");
    printPg("Also please only use A-Z and 0-9 in the filename, and be sure to end with .php","note");
    printPg("Filename will be automatically adjusted to match these rules if nessisary.","note");
    if($iPageID > 0)
    {
      if(isset($_POST["cmbRevTime"]))
      {
        $RevTime = CleanReg(substr(trim($_POST["cmbRevTime"]),0,49));
        $QueryAdd = "'$RevTime'";
      }
      else
      {
        $QueryAdd = "(select max(dtTimeStamp) from tblContent where iMenuID = '$iPageID')";
        $RevTime = "";
      }
      print "<div class=CenterBoxLarge>\n";
      print "<form method=\"POST\">\n";
      print "<input type=\"hidden\" name=\"PageID\" size=\"5\" value=\"$iPageID\">";
      print "<span class=\"lbl\">Change to revision from:</span>\n";
      print "\n<select size=\"1\" name=\"cmbRevTime\">\n";
      $strQuery = "SELECT dtTimeStamp FROM tblContent WHERE iMenuID = '$iPageID' order by dtTimeStamp desc";
      $QueryData = QuerySQL($strQuery);
      if($QueryData[0] > 0)
      {
        foreach($QueryData[1] as $Row)
        {
          $TimeStamp = date('F jS Y \a\t G:i',strtotime($Row["dtTimeStamp"]));
          if($Row["dtTimeStamp"] == $RevTime)
          {
            print "<option selected value=\"{$Row['dtTimeStamp']}\">$TimeStamp</option>\n";
          }
          else
          {
            print "<option value=\"{$Row['dtTimeStamp']}\">$TimeStamp</option>\n";
          }
        }
      }
      else
      {
        if($QueryData[0] < 0)
        {
          $strMsg = Array2String($QueryData[1]);
          error_log("Query of $strQuery did not return data. Rowcount: $QueryData[0] Msg:$strMsg");
          printPg($ErrMsg,"error");
        }
      }
      print "</select>\n";
      print "<input type=\"Submit\" value=\"Change\" name=\"btnSubmit\" >";
      print "</form>\n";

      $strQuery = "SELECT * FROM tblContent WHERE iMenuID = '$iPageID' and dtTimeStamp = $QueryAdd;";

      $QueryData = QuerySQL($strQuery);
      if($QueryData[0] > 0)
      {
        foreach($QueryData[1] as $Row)
        {
          $PageHeader = $Row["vcPageHeader"];
          $PageText = $Row["tPageText"];
          $bCRLF = $Row["bLineBreak"];
        }
      }
      else
      {
        if($QueryData[0] == 0)
        {
          $PageHeader = "";
          $PageText = "";
          $bCRLF = 0;
        }
        else
        {
          $strMsg = Array2String($QueryData[1]);
          error_log("Query of $strQuery did not return data. Rowcount: $QueryData[0] Msg:$strMsg");
          printPg($ErrMsg,"error");
        }
      }

      print "<form method=\"POST\">\n";
      print "<input type=\"hidden\" name=\"PageID\" size=\"5\" value=\"$iPageID\">";
    }
    else
    {
      $bCRLF = 0;
      print "<div class=CenterBoxLarge>\n";
      print "<form method=\"POST\">\n";
      print "<input type=\"hidden\" name=\"cmbType\" size=\"5\" value=\"$PageType\">";
      print "<span class=\"lbl\">Page Name:</span>\n";
      print "<input type=\"text\" name=\"txtName\" size=\"25\">\n";
      print "<span class=\"lbl\">Page Title:</span>\n";
      print "<input type=\"text\" name=\"txtTitle\" size=\"25\">\n";
      print "<span class=\"lbl\">File Name:</span>\n";
      print "<input type=\"text\" name=\"txtFile\" size=\"25\">\n<br>\n";
    }
    print "<span class=\"lbl\">Page Header:</span>\n";
    print "<input type=\"text\" name=\"txtHeader\" size=\"50\" value=\"$PageHeader\">\n";
    print "<span class=\"lbl\">Maintain Linebreaks:</span>\n";
    if($bCRLF==0)
    {
      print "<input type=\"checkbox\" name=\"chkCR\">\n";
    }
    else
    {
      print "<input type=\"checkbox\" name=\"chkCR\" checked>\n";
    }
    print "<div class=\"lbl\">Page Body:</div>\n";
    print "<textarea name=\"txtBody\" class=LargeArea>$PageText </textarea>\n<br>\n";
    print "<div class=\"Submit\"><input type=\"Submit\" value=\"Save\" name=\"btnSubmit\"></div>";
    print "</form>\n";
    print "</div>\n";
    print "<div class=\"MainTextCenter\"><form method=\"POST\">\n<input type=\"Submit\" value=\"Go Back\" name=\"btnSubmit\"></form></div>";
  }

  if($btnSubmit == "Save")
  {
    if(isset($_POST["txtFile"]))
    {
      $FileName = CleanReg(substr(trim($_POST["txtFile"]),0,49));
      $PageName = CleanReg(substr(trim($_POST["txtName"]),0,49));
      $MenuTitle = CleanReg(substr(trim($_POST["txtTitle"]),0,49));
      $FileName = preg_replace("/[^a-z0-9]*/i", "", $FileName);

      if(substr($FileName,-4)!=".php")
      {
        $FileName .= ".php";
      }
      printPg("Page will be saved as $FileName","note");
      if(file_exists($FileName))
      {
        printPg("The filename you specified already exists, please choose another","error");
        exit(3);
      }
      else
      {
        if(copy($Templatefile, $FileName))
        {
          $strQuery = "INSERT INTO tblmenu (vcTitle, vcLink, iReadPriv, iWritePriv, vcHeader, bAdmin, bCont, bdel, bSecure)"
                    . "VALUES ('$MenuTitle', '$FileName', '$PrivLevel', '$PrivLevel', '$PageName', '$AdminPage', '$PageType', '1', '0');";
          if(UpdateSQL($strQuery,"insert"))
          {
            $strQuery = "SELECT iMenuID FROM tblmenu WHERE vcLink = '$FileName' LIMIT 1;";
            $iPageID = GetSQLValue($strQuery);
            if($AdminPage == 0)
            {
              $strQuery = "SELECT MAX(iMenuOrder) as MaxHead FROM tblmenutype WHERE vcMenuType = 'head';";
              $iMaxHead = GetSQLValue($strQuery) + 1;

              if($iPageID > 0)
              {
                $strQuery = "INSERT INTO tblmenutype (iMenuID, vcMenuType, iMenuOrder, iSubOfMenu)" .
                            " VALUES ('$iPageID', 'head', '$iMaxHead', 0);";
                UpdateSQL($strQuery,"insert");
              }
            }
          }
          else
          {
            exit(1);
          }
        }
        else
        {
          printPg("Failed to create the file $FileName from template file $Templatefile","error");
        }
      }
    }
    if($iPageID > 0)
    {
      if(isset($_POST["txtHeader"]))
      {
        $strHeader = CleanSQLInput(substr(trim($_POST["txtHeader"]),0,79));
      }
      else
      {
        $strHeader = "";
      }
      if(isset($_POST["chkCR"]))
      {
        $bCRLF = 1;
      }
      else
      {
        $bCRLF = 0;
      }

      switch($PageType)
      {
        case 1:
          if(isset($_POST["txtBody"]))
          {
            $strBody = CleanSQLInput(trim($_POST["txtBody"]));
          }
          else
          {
            $strBody = "";
          }
          $strQuery = "insert into tblContent (iMenuID, vcPageHeader, tPageText, bLineBreak) " .
                      "values ('$iPageID','$strHeader','$strBody','$bCRLF');";
          break;
        case 2:
          if(isset($_POST["txtFields"]))
          {
            $strFields = CleanSQLInput(substr(trim($_POST["txtFields"]),0,799));
          }
          else
          {
            $strFields = "";
          }
          if(isset($_POST["txtFrom"]))
          {
            $strTableName = CleanSQLInput(substr(trim($_POST["txtFrom"]),0,34));
          }
          else
          {
            $strTableName = "";
          }
          if(isset($_POST["txtWhere"]))
          {
            $strCrit = CleanSQLInput(substr(trim($_POST["txtWhere"]),0,34));
          }
          else
          {
            $strCrit = "";
          }
          if(isset($_POST["RecID"]))
          {
            $iRecID = CleanSQLInput(substr(trim($_POST["RecID"]),0,5));
          }
          else
          {
            $iRecID = "";
          }
          if(isset($_POST["txtLimit"]))
          {
            $iLimit = CleanSQLInput(substr(trim($_POST["txtLimit"]),0,5));
          }
          else
          {
            $iLimit = "";
          }
          if(!is_numeric($iLimit) or $iLimit > 5000)
          {
            $iLimit = 5000;
          }
          if($iRecID == "")
          {
            $strQuery = "insert into tblPageTable (iMenuID, vcPageHeader, vcColumnList, vcTableName, vcFilterStr, iLimit) " .
                        "values ('$iPageID','$strHeader','$strFields', '$strTableName', '$strCrit', '$iLimit');";
          }
          else
          {
            $strQuery = "UPDATE tblPageTable SET iMenuID = '$iPageID', vcPageHeader = '$strHeader', " .
                               "vcColumnList = '$strFields', vcTableName = '$strTableName', " .
                               "vcFilterStr = '$strCrit', iLimit = '$iLimit' WHERE iTableID = '$iRecID'";
          }
          break;
      }
      UpdateSQL($strQuery,"insert");
      printPg("Page Created or updated Successfully","note");
    }
    else
    {
      printPg("Unable to save due to missing PageID","error");
    }
    print "<div class=\"MainTextCenter\"><form method=\"POST\">\n<input type=\"Submit\" value=\"Go Back\" name=\"btnSubmit\"></form></div>";
  }

  if($btnSubmit == "Delete")
  {
    $strQuery = "SELECT * FROM tblmenu WHERE iMenuID = '$iPageID';";
    $QueryData = QuerySQL($strQuery);
    if($QueryData[0] > 0)
    {
      foreach($QueryData[1] as $Row)
      {
        $FileName = $Row["vcLink"];
        $PageTitle = $Row["vcTitle"];
        $PageHeader = $Row["vcHeader"];
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

    printPg("Are you sure you want to delete $PageTitle $PageHeader "
        . "and the associated file $FileName. This action is irreversible.","alert");
    print "<center>\n<form method=\"POST\">\n";
    print "<input type=\"Submit\" value=\"Yes I am very sure\" name=\"btnSubmit\">";
    print "<input type=\"hidden\" value=\"$iPageID\" name=\"PageID\">\n";
    print "<input type=\"hidden\" value=\"$FileName\" name=\"FileName\">\n";
    print "</form>\n";

    print "<div class=\"MainTextCenter\"><form method=\"POST\">\n<input type=\"Submit\" value=\"Go Back\" name=\"btnSubmit\"></form></div>";
  }

  if($btnSubmit == "Yes I am very sure")
  {
    $FileName = CleanReg(substr(trim($_POST["FileName"]),0,49));

    if(unlink($FileName))
    {
      printPg("Successfully deleted $FileName","note");
      $strQuery = "DELETE FROM tblmenu WHERE iMenuID = '$iPageID';";
      UpdateSQL($strQuery,"Delete");
      $strQuery = "DELETE FROM tblmenutype WHERE iMenuID = '$iPageID';";
      UpdateSQL($strQuery,"Delete");
      $strQuery = "DELETE FROM tblContent WHERE iMenuID = '$iPageID';";
      UpdateSQL($strQuery,"Delete");
      $strQuery = "DELETE FROM tblPageTable WHERE iMenuID = '$iPageID';";
    }
    else
    {
      printPg("Failed to deleted $FileName","error");
    }
    print "<div class=\"MainTextCenter\"><form method=\"POST\">\n<input type=\"Submit\" value=\"Go Back\" name=\"btnSubmit\"></form></div>";
  }

  if(($PostVarCount == 0) or ($btnSubmit == "Go Back"))
  {
    print "<center><form method=\"POST\">\n";
    print "<input type=\"Submit\" value=\"Create New\" name=\"btnSubmit\">\n";
    print "<select size=\"1\" name=\"cmbType\">\n";
    $strQuery = "select * from tblPageTypes;";
    $QueryData = QuerySQL($strQuery);
    if($QueryData[0] > 0)
    {
      foreach($QueryData[1] as $Row2)
      {
        if($Row2["iTypeID"] == $PageType)
        {
          print "<option selected value=\"{$Row2['iTypeID']}\">{$Row2['vcPageType']}</option>\n";
        }
        else
        {
          print "<option value=\"{$Row2['iTypeID']}\">{$Row2['vcPageType']}</option>\n";
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

    print "</select>\n";
    print "</form>\n";
    print "<table class=\"MainText\" border=\"0\" cellPadding=\"4\" cellSpacing=\"0\">\n";
    print "<tr align=\"center\"><th>Menu Title</th><th>Page Title</th></tr>\n";
    $strQuery = "SELECT * FROM tblmenu where bCont>0 order by vcTitle";

    $QueryData = QuerySQL($strQuery);
    if($QueryData[0] > 0)
    {
      foreach($QueryData[1] as $Row)
      {
      print "<tr valign=\"top\">\n";
      print "<td>$Row[vcTitle]</td>";
      print "<td>$Row[vcHeader]</td>";
      print "<form method=\"POST\">\n";
      print "<td>\n<input type=\"Submit\" value=\"Edit\" name=\"btnSubmit\">\n";
      print "<input type=\"hidden\" value=\"$Row[iMenuID]\" name=\"PageID\"></td>\n";
      print "</form>\n";
      if($Row["bdel"]==1)
      {
        print "<form method=\"POST\">\n";
        print "<td><input type=\"Submit\" value=\"Delete\" name=\"btnSubmit\">";
        print "<input type=\"hidden\" value=\"$Row[iMenuID]\" name=\"PageID\"></td>\n";
        print "</form>\n";
      }
      print "</tr>\n";
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
    print "</table></center>";
  }
  require("footer.php");
?>
