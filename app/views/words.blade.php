<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Cache-Control" content="no-cache"/>
<meta http-equiv="Pragma" content="no-cache"/>
<meta name="viewport" content="width=device-width" />
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
<link rel="icon" href="/favicon.ico" type="image/x-icon" />
<title>Words With Friends Help | Word Builder | Dictionary | Word Help</title>
<script type="text/javascript" src="jquery.min.js"></script>
<script type="text/javascript" src="words.js"></script>
<link rel="stylesheet" href="word.styles.css">
</head>
<body onload="document.getElementById('word').focus();" style="height: 100%;min-height:560px;position:relative;">
<div style="padding-bottom:160px;position:relative;min-height:99%;top:0px;bottom:0px; width:100%; position:relative; padding:0px; text-align:center; align:center;">
<div style="position:absolute;top:0px;left:0px;height:41px;width:100%;min-width:488px;background:#FFFFFF;z-index:0;border-bottom:3px solid #FEB000;overflow:visible;">
&nbsp;</div>
<div style="width:98%;padding:0px 10px 0px 10px;z-index:2;">
<table style="margin-bottom:0px;" align="center" cellspacing=0 cellpadding=0>
<tr>
<td style="width:180px;">&nbsp;</td>
<td colspan="4" style="position:relative;z-index:999;height:50px; padding-left:2px; padding-top:12px; background: url('words3.png') no-repeat 0px 4px;">
<h1 style="margin-bottom:1px;">
&nbsp;<a style="text-decoration:none; color:black;" href="/?pre=&suf=&word=&any=&sort=">Words With Friends Help</a>
</h1>
</td>
<td colspan="2"  style="width:180px;">&nbsp;</td>
</tr>
<tr>
<td style="width:180px;">&nbsp;</td>
<td class="borderthis" style="font-size:10px;text-align:center;padding:0 10px 0 0;margin:0;height:auto;"><i>starts with</i><br/>


 <form name="wrdfrm" method=POST action="{{url('/')}}" style="display:inline;"> 
&nbsp;<input type=hidden name="sort" value="">
<input class="wordinput" type=text name="pre" style="width:60px;" value="<?php echo $_REQUEST['pre']; ?>">
</td>
<td class="borderthis" style="text-align:left;padding:0px 2px 2px 2px;" colspan="1">
<b>Tiles:</b><br/> 
			{{ Form::text('word', $_REQUEST['word'], array('placeholder' => '')) }}
</td>
<td class="borderthis" style="font-size:10px;text-align:center;padding:0 0 0 10px;margin:0;height:auto;"><i>ends with</i><br/>
<input class="wordinput" type=text name="suf" style="width:60px;" value="<?php echo $_REQUEST['suf']; ?>">
</td>
<td class="borderthis" style="font-size:10px;text-align:center;padding:0 0 0 10px;margin:0;height:auto;">
<br/><input onClick="return subcheck();" type=submit style="font-weight:bold;" value="GO &gt;&gt;">
</td>
<td style="width:180px;">&nbsp;</td>
</tr>
<tr>
<td class="borderthis" style="font-size:10px; padding:0; color:white;text-align:center;" colspan="7">
Use <span style="color:orange;font-weight:bold;font-size:12px;">? *</span> or <span style="font-weight:bold;color:orange;font-size:12px;">.</span> for blank/wildcard tiles (up to 3).&nbsp;
<br/>&nbsp;Use <span style="color:orange;font-weight:bold;font-size:12px;">&quot;</span>quotes<span style="color:orange;font-weight:bold;font-size:12px;">&quot;</span> around a group of letters to limit results to words that contain the quoted phrase.
</td></tr>
</table>
<table style="width:310px;" align="center" cellspacing=0 cellpadding=0>
<tr>
<td class="borderthis" colspan="5" style="text-align:center; font-weight:bold;color:red; padding:4px 0 0 0;">
<?php
$links = '';
$sortLinkValue = "<a class=\"orange\" style=\"font-size:80%;text-decoration:none;\" href=\"?pre=".urlencode($_REQUEST['pre'])."&suf=".urlencode($_REQUEST['suf'])."&word=".urlencode($_REQUEST['word'])."&sort=\">sort by value</a>";
$sortLinkAlpha = "<a class=\"orange\" style=\"font-size:80%; text-decoration:none;\"href=\"?pre=".urlencode($_REQUEST['pre'])."&suf=".urlencode($_REQUEST['suf'])."&word=".urlencode($_REQUEST['word'])."&sort=name\">sort alphabetically</a>";
$sortLinkLength = "<a class=\"orange\" style=\"font-size:80%;text-decoration:none;\" href=\"?pre=".urlencode($_REQUEST['pre'])."&suf=".urlencode($_REQUEST['suf'])."&word=".urlencode($_REQUEST['word'])."&sort=length\">sort by length</a>";

if($_REQUEST['sort']=='name'){
	$links = $sortLinkValue."&nbsp;|&nbsp;";
	$links .= $sortLinkLength;
} elseif($_REQUEST['sort']=='length'){
	$links = $sortLinkAlpha."&nbsp;|&nbsp;";
	$links .= $sortLinkValue;
} else {
	$links = $sortLinkAlpha."&nbsp;|&nbsp;";
	$links .= $sortLinkLength;
}
if(!empty($_REQUEST['word'])){
	echo "<tr>\n<td class=\"borderthis\" colspan=\"5\" style=\"text-align:center; font-weight:bold;color:red; padding:4px 0 0 0;\">\n";
	echo count($points)." Matches!\n";
	echo "</td></tr>\n";
}
echo "<tr><td class=\"borderthis\" style=\"text-align:center; font-weight:bold; padding:0px 0px 0px 0px;color:white;\" colspan=\"5\">\n";
echo $links;	
echo "</td></tr>\n";
?>
	
</td></tr>

<tr><td class="borderthis" colspan="5">
<?php
	if($_REQUEST['sort']==='length'){ $words_ar=$length; } else { $words_ar=$points; }
	foreach($words_ar as $w=>$wArr){
		echo "<div style=\"margin-right:4px; border:0px solid red;width:45%;float:left; padding:1px 2px 0 2px;text-align:left;\">\n";
		echo "<span style=\"color:yellow;padding-right:6px; width:25px; float:left; text-align:right;\">".$points[$w]."</span>\n";
		echo "<span style=\"font-weight:bold;color:white;text-align:left;\">"."<span class=\"lookup\" href=\"dictionary.php?word=".strtolower($w)."#".strtolower($w)."\" target=\"_BLANK\">".$w."</span>"."</span></div>\n";
	}

?>
</form>
</td>
</tr>
</table>
<table style="padding-bottom:180px;max-width:730px;min-width:470px;border:0px;" align="center" cellspacing=0 cellpadding=0>
<tr><td class="borderthis" style="text-align:center; font-weight:bold; padding:38px 0px 0px 0px;color:white;">
</td></tr>
</table>
<div style="position:absolute; min-width:565px;width:-webkit-fill-available; bottom:0px; left:0px; color:white; padding:3px 3px;font-size:6px;text-align:center;">
<div style="overflow:display;padding:0 12%;text-align:center; font-size:14px;">
Like this site? <a class="orangebeer" style="" href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=cameronall%40gmail%2ecom&lc=US&item_name=wordswithfriendshelp%2enet+support&no_note=0&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHostedGuest" target="_BLANK">buy me a beer!</a> <span style="color:#FFFF00;">&#127866;</span><br/><br/>
</div>
<div style="overflow:display;padding:0 12%;text-align:center;">This site is a free cheat tool that finds all possible word combinations using the letters entered for the popular iphone & Android game, "Words With Friends".  You can use up to 3 blank/wild tiles by entering one of the following: ( *?. )  
This tool searches the <a href="/?word=dictionary" style="color:white;text-decoration:none;">Words With Friends dictionary</a> to find word combinations from given letters.
You can also specify the prefix, suffix, or phrase of a word.  You can also sort the results by point value, word length, or alphabetically.</div><br/>
<div style="align:center;text-align:center;position:relative;background:#FFFFFF;z-index:1;border:3px solid #FEB000;padding:3px;white-space:nowrap;margin-bottom:5px;">
<a style="color:#2D2D2D;" href="/?word=cheat">Words With Friends Help</a>
&nbsp;&nbsp;
<a style="color:#2D2D2D;" href="http://wordswithfriends.com/">Official Site</a>
&nbsp;&nbsp;
<a style="color:#2D2D2D;" href="http://www.zyngawithfriends.com/wordswithfriends/support/WWF_Rulebook.html">Rules</a>
&nbsp;&nbsp;
</div>
Words With Friends Help.net is not affiliated or associated with Words With Friends, Newtoy, Inc., or Zynga Inc.
<?php echo "<br/><br/>&copy; Copyright ".date('Y')." <a href=\"?word=copyright\" style=\"color:white;text-decoration:none;\">WordsWithFriendsHelp.net</a>\n"; ?>

</div>
</div>
<img src="spacer.gif" style="width:468px;height:1px;"/>
</div>


</body>
</html>
