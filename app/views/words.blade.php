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
<link rel="stylesheet" href="word.styles.css" />
</head>
<body onload="document.getElementById('word').focus();">
	<div>
		<div class="whiteTop">&nbsp;</div>
		<div class="mainContainer" >
			<table style="width: 750px;overflow:scroll;">
				<tr>
					<td style="width:180px;">&nbsp;</td>
					<td colspan="4" class="headerTd">
						<h1 >
						&nbsp;<a href="/?pre=&suf=&word=&any=&sort=">Words With Friends Help</a>
						</h1>
					</td>
					<td colspan="2"  style="width:180px;">&nbsp;</td>
				</tr>
				<tr>
					<td style="width:180px;">&nbsp;</td>
					<td class="borderthisa" style=""><i>starts with</i><br/>
					 <form name="wrdfrm" method=POST action="{{url('/')}}" style="display:inline;"> 
					&nbsp;<input type=hidden name="sort" value="">
					<input class="wordinput" type=text name="pre" value="<?php echo $_REQUEST['pre']; ?>">
					</td>
					
					<td class="borderthisb" colspan="1">
					<b>Tiles:</b><br/> 
								{{ Form::text('word', $_REQUEST['word'], array('placeholder' => '')) }}
					</td>
			
					<td class="borderthisc" >ends with<br/>
					<input class="wordinput" type=text name="suf" style="" value="<?php echo $_REQUEST['suf']; ?>">
					</td>
			
					<td class="borderthise" >
					<br/><input onClick="return subcheck();" type="submit" value="GO &gt;&gt;">
					</td>
					<td style="width:180px;">&nbsp;</td>
				</tr>
				<tr>
					<td class="borderthisd" colspan="7">
					Use <span >? *</span> or <span>.</span> for blank/wildcard tiles (up to 3).&nbsp;
					<br/>&nbsp;Use <span>&quot;</span>quotes<span >&quot;</span> around a group of letters to limit results to words that contain the quoted phrase.
					</td>
				</tr>
			</table>
			<table class="botTable" style=" " align="center" cellspacing=0 cellpadding=0>
				<tr>
					<td class="borderthis" colspan="5" style="text-align:center; font-weight:bold;color:red; padding:4px 0 0 0;">
<?php
$links = '';
$sortLinkValue = "<a class=\"orange\" href=\"?pre=".urlencode($_REQUEST['pre'])."&suf=".urlencode($_REQUEST['suf'])."&word=".urlencode($_REQUEST['word'])."&sort=\">sort by value</a>";
$sortLinkAlpha = "<a class=\"orange\" href=\"?pre=".urlencode($_REQUEST['pre'])."&suf=".urlencode($_REQUEST['suf'])."&word=".urlencode($_REQUEST['word'])."&sort=name\">sort alphabetically</a>";
$sortLinkLength = "<a class=\"orange\" href=\"?pre=".urlencode($_REQUEST['pre'])."&suf=".urlencode($_REQUEST['suf'])."&word=".urlencode($_REQUEST['word'])."&sort=length\">sort by length</a>";
		
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
	echo "<tr>\n<td class=\"borderthisMatch\" colspan=\"5\" >\n";
	echo count($points)." Matches!\n";
	echo "</td></tr>\n";
}
echo "			<tr>\n				<td class=\"borderthisLinks\" colspan=\"5\">\n";
echo $links;	
echo "				</td>\n			</tr>\n
					</td>
				</tr>
				<tr>
					<td class=\"borderthisWords\" colspan=\"5\">\n";
if($_REQUEST['sort']==='length'){ $words_ar=$length; } else { $words_ar=$points; }
foreach($words_ar as $w=>$wArr){
	echo "					<div style=\"\">\n";
	echo "					<span style=\"\">".$points[$w]."</span>\n";
	echo "					<span class=\"wordMatch\">"."<span class=\"lookup\" href=\"dictionary.php?word=".strtolower($w)."#".strtolower($w)."\" target=\"_BLANK\">".$w."</span>"."</span></div>\n";
}
			
?>
						</form>
						</td>
					</tr>
					<tr>
						<td colspan="5" style="height:100px;">&nbsp;</td>
					</tr>
				</table>
				<table style="padding-bottom:80px;max-width:730px;min-width:470px;border:0px;" align="center" cellspacing=0 cellpadding=0>
					<tr>
						<td class="borderthis" style="text-align:center; font-weight:bold; padding:38px 0px 0px 0px;color:white;"></td>
					</tr>
				</table>
				<div class="bottomDiv" >
				<div class="bottomDiv2">
					Like this site? <a class="orangebeer" style="" href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=cameronall%40gmail%2ecom&lc=US&item_name=wordswithfriendshelp%2enet+support&no_note=0&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHostedGuest" target="_BLANK">buy me a beer!</a> <span style="color:#FFFF00;">&#127866;</span><br/><br/>
				</div>
				<div class="bottomDiv2">This site is a free cheat tool that finds all possible word combinations using the letters entered for the popular iphone & Android game, "Words With Friends".  You can use up to 3 blank/wild tiles by entering one of the following: ( *?. )  
					This tool searches the <a href="/?word=dictionary" style="color:white;text-decoration:none;">Words With Friends dictionary</a> to find word combinations from given letters.
					You can also specify the prefix, suffix, or phrase of a word.  You can also sort the results by point value, word length, or alphabetically.</div><br/>
					<div class="whiteStripe">
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