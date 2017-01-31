<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>php resources</title>
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<link rel="stylesheet" type="text/css" href="../style/oophp.css" title="oophp" />
<!--local style elements here-->
<style type="text/css">
input, textarea{
  width:175px;
}
</style>
</head>
<body>
<!--resources-->
<h1>add link to our PHP resources page</h1>
<div class="sidebar">
<a href ="../index.php" >Main</a><br /><br /> 
<a href ="link.php" >Add link</a><br /><br /> 
<a href ="getresources.php" >View Resources</a><br /><br />

</div>

<div class="main" style="">
<div class="main" >
<div style="background-color:#EEE; border: black 1px dotted; padding:5px;padding-top:18px;width:350px;">
<p style="font-size:8pt; padding-bottom:15px;">Required fields are in bold. Your email address will <i>not</i> be publicly exposed.
</p>
<center>
<form action="addlink.php" method="post" name="frmaddlink" >
<table border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<label class="required">URL to add: </label>
</td>
<td>
<input type="text" name="url" maxlength="150" size="28" value="http://" />
<br />
</td>
</tr>
<tr>
<td>
<label>Preceding text <br />
(if applicable): </label>
</td>
<td>
<textarea name="precedingcopy" cols="25" rows="3"></textarea><br />
</td>
</tr>
<tr>
<td>
<label class="required">Link text: </label>
</td>
<td>
<input type="text" name="linktext" maxlength="150" size="28" /><br />
</td>
</tr>
<tr>
<td>
<label>Following text <br />
(if applicable): </label>
</td>
<td>
<textarea name="followingcopy" cols="25" rows="3" ></textarea><br />

</td>
</tr>
<tr>
<td>
<label>Link on your site: &nbsp;</label>
</td>
<td>
<input type="text" name="theirlinkpage" maxlength="150" size="28" value="http://" /><br />
</td>
</tr>
<tr>
<td>
<label class="required">Contact email: </label>
</td>
<td>
<input type="text" name="email" maxlength="100" size="28"  /><br />
</td>
</tr>
<tr>
<td colspan="2" style="text-align:center;">
<div style="text-align:center;padding-top:10px;padding-bottom:0px;"><input type="submit" value="submit" style="width:50px;" /> &nbsp;
<input type="reset" value="clear" style="width:50px" />
</div>
</td>
</tr>
</table>
</form>
</center>
<p style="text-align:left;padding-top:15px;">We welcome all submissions but reserve the right to accept only related sites.
</p>
<p style="text-align:left;">
We respect your privacy. Information provided to this site will not be shared with any outside parties. Your e-mail address is used solely for the purpose of communicating with you regarding your link.
</p>
</div>
</div>
</body>
</html>
