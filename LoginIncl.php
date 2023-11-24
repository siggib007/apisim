<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details   
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>

  Login form
  */

  $strURI = $_SERVER["REQUEST_URI"];
  $strPageNameParts = explode("/",$strURI);
  $HowMany = count($strPageNameParts);
  $LastIndex = $HowMany - 1;
  $strPageName = strtolower($strPageNameParts[$LastIndex]);
  if($strPageName == "loginincl.php")
  {
    header("Location: index.php");
    exit;
  }
?>
<p class="LargeAttnCenter">
  Please note BOTH username and password are case sensitive.
</p>
<p class="MainText">
  Please enter in your login and password below.
</p>
<form method="POST">
  <INPUT TYPE="HIDDEN" NAME="txtDest" VALUE="<?php print $strReturn ; ?>">
  <table border="0" id="table5">
    <tr>
      <td width="300" align="right"><span class="lbl">Username:</span></td>
      <td width="400"><input type="text" name="txtLogin" size="20"></td>
    </tr>
    <tr>
      <td align="right"><span class="lbl">Password:</span></td>
      <td><input type="password" name="txtPwd" size="20"></td>
    </tr>
    <tr>
      <td colspan="2" align="center">
        <input type="submit" value="Submit" name="btnLogin">
      </td>
    </tr>
  </table>
</form>
<p class="MainText">
  <b>Forgot your username or password?</b><br>
  Just enter in your email address and we'll email you your password.
</p>
<form action="recover.php" method="POST">
  <table border="0" id="table5">
    <tr>
      <td align="right" width="300"><span class="lbl">Email address:</span></td>
      <td width="400"><input type="text" name="txtRecEmail" size="50"></td>
    </tr>
    <tr>
      <td colspan="2" align="center">
        <input type="submit" value="Submit" name="btnRecover">
      </td>
    </tr>
  </table>
</form>
