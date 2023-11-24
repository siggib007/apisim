<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>

  Main authentication code.
  */


	require_once("DBCon.php");
  use RobThree\Auth\TwoFactorAuth;
  spl_autoload_register(
    function($className)
    {
      include_once str_replace(array("RobThree\\Auth", "\\"), array(__DIR__."/RobThree2FA", "/"), $className) . ".php";
    }
  );

  if(isset($_SESSION["auth_username"] ) )
  {
    header("Location: index.php");
    exit;
  }

  if(isset($_POST["txtDest"]))
  {
    $strDest = trim($_POST["txtDest"]);
  }
  else
  {
    $strDest ="";
  }
  if(isset($_SERVER["HTTP_REFERER"]))
  {
    $strReferer = $_SERVER["HTTP_REFERER"];
  }
  else
  {
    $strReferer = "";
  }
  $strURI = $_SERVER["REQUEST_URI"];
  $strPageNameParts = explode("/",$strURI);
  $HowMany = count($strPageNameParts);
  $LastIndex = $HowMany - 1;
  $strPageName = strtolower($strPageNameParts[$LastIndex]);
  if($strPageName == "auth.php")
  {
    header("Location: index.php");
    exit;
  }
  $strPageNameParts = explode("/",$strReferer);
  $HowMany = count($strPageNameParts);
  $LastIndex = $HowMany - 1;
  $strReferPage = $strPageNameParts[$LastIndex];
  if($strReferPage=="registerconf.php")
  {
    $strReferPage = "index.php";
  }
  if($strReferPage=="register.php")
  {
    $strReferPage = "index.php";
  }
  if($strReferPage=="delete.php")
  {
    $strReferPage = "index.php";
  }

	if($strReferPage=="update.php")
  {
    $strReferPage = "index.php";
	}
	if($strReferPage=="recover.php")
	{
    $strReferPage = "index.php";
	}
	if($strReferPage=="")
	{
    $strReferPage = "index.php";
	}
	if($strDest != "")
	{
    $strReturn = $strDest;
	}
	else if($strPageName != "login.php")
	{
    $strReturn = $strPageName;
	}
	else if($strReferPage != "login.php")
	{
    $strReturn = $strReferPage;
	}
	else
	{
    $strReturn = "index.php";
	}
	if(isset($_SESSION["ReturnPage"]))
	{
    $strReturn = $_SESSION["ReturnPage"];
    unset($_SESSION["ReturnPage"]);
	}

	if(isset($_POST["txtLogin"]))
	{
    $strLogin = CleanReg(trim($_POST["txtLogin"]));
	}
	else
	{
    $strLogin ="";
	}
	if(isset($_POST["txtPwd"]))
	{
    $strPWD = CleanReg(trim($_POST["txtPwd"]));
	}
	else
	{
    $strPWD ="";
	}

  if(isset($_POST["txtCode"]))
	{
    $strCode = CleanReg(trim($_POST["txtCode"]));
	}
	else
	{
    $strCode ="";
	}
  if(isset($_POST["cmbMFA"]))
	{
    $strMFAType = CleanReg(trim($_POST["cmbMFA"]));
	}
	else
	{
    $strMFAType ="na";
	}
	$dtNow = date('Y-m-d H:i:s');
  $tfa = new TwoFactorAuth();
	if($strLogin and $strPWD)
	{
    $strQuery = "select * from tblUsers where vcUID = '$strLogin'";

    $QueryData = QuerySQL($strQuery);

    if($QueryData[0] > 0)
    {
      foreach($QueryData[1] as $Row)
      {
        $iUserID = $Row["iUserID"];
        $iPrivlvl = $Row["iPrivLevel"];
        $strUPWD = $Row["vcPWD"];
        $strTOTP = $Row["vcMFASecret"];
        $strRHash = $Row["vcRecovery"];
        $strLastUpdated = $Row["dtUpdated"];
        $strEmail = $Row["vcEmail"];
      }
    }
    else
    {
      $strMsg = Array2String($QueryData[1]);
      error_log("Query of $strQuery did not return data. Rowcount: $QueryData[0] Msg:$strMsg");
      $iUserID = 0;
      $iPrivlvl = 0;
      $strUPWD = "";
      $strTOTP = "";
      $strRHash = "";
      $strLastUpdated = "";
      $strEmail = "";
    }
    $arrMFAOptions = LoadMFAOptions($iUserID);

    if(password_verify($strPWD, $strUPWD))
    {
      if(!$_SESSION["bMFA_active"])
      {
        require("AuthIncl.php");
      }
      else
      {
        if($strCode == "")
        {
          require_once("MFAOptions.php");
        }
        else
        {
          if($strMFAType == "totp")
          {
            if($tfa->verifyCode($strTOTP, $strCode) === true)
            {
              require("AuthIncl.php");
            }
            else
            {
              printPg("Invalid code","attn");
              require_once("MFAOptions.php");
            }
          }
          if($strMFAType == "smsemail")
          {
            if(isset($_SESSION["ConfCode"]))
            {
              $ConfCode = $_SESSION["ConfCode"];
            }
            else
            {
              $ConfCode = "";
            }
            if($strCode == $ConfCode)
            {
              require("AuthIncl.php");
            }
            else
            {
              printPg("Invalid code","Attn");
              require_once("MFAOptions.php");
            }
            unset($_SESSION["ConfCode"]);
            unset($ConfCode);
          }
          if($strMFAType == "recover")
          {
            $strActivity = "Recovery Code usage";
            $arrTypes = array("SMS"=>"6","email"=>"7");
            NotifyActivity($strActivity,$arrTypes);

            $strCode = str_replace(" ","",$strCode);
            if(password_verify($strCode, $strRHash))
            {
              require("AuthIncl.php");
            }
            else
            {
              printPg("Invalid token","attn");
              require_once("MFAOptions.php");
            }
          }
        }
      }
    }
    else
    {
      require_once("header.php");
      printPg("Invalid username or password","attn");
      require("LoginIncl.php");
      require_once("footer.php");
    }
	}
	else
	{
    if($strLogin and !$strPWD)
    {
      printPg("You provided your username but not your password. Please provide both","attn");
    }
    else if(!$strLogin and $strPWD)
    {
      printPg("You provided your password but not your username. Please provide both","attn");
    }
    require_once("header.php");
    if(isset($_SESSION["Reason"]))
    {
      printPg("$_SESSION[Reason]","h1");
      unset($_SESSION["Reason"]);
    }
    require_once("LoginIncl.php");
    require_once("footer.php");
	}
?>