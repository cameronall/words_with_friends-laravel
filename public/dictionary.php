<?php
error_reporting(341);

function pullContent($url) {
	$req = $url;
	$pos = strpos($req, '://');
	$protocol = strtolower(substr($req, 0, $pos));
	$req = substr($req, $pos+3);
	$pos = strpos($req, '/');
	
	if($pos === false) {
		$pos = strlen($req);
	}
	
	$host = substr($req, 0, $pos);
	
	if(strpos($host, ':') !== false) {
		list($host, $port) = explode(':', $host);
	} else {
		$host = $host;
		$port = ($protocol == 'https') ? 443 : 80;
	}
	
	$uri = substr($req, $pos);
	if($uri == '') {
		$uri = '/';
	}
	
	$crlf = "\r\n";
	// generate request
	$req = 'GET ' . $uri . ' HTTP/1.0' . $crlf
	.    'Host: ' . $host . $crlf
	.    $crlf;
	
	// fetch
	$fp = fsockopen(($protocol == 'https' ? 'ssl://' : '') . $host, $port);
	fwrite($fp, $req);
	$response = '';
	while(is_resource($fp) && $fp && !feof($fp)) {
		$response .= fread($fp, 1024);
	}
	fclose($fp);
	
	// split header and body
	$pos = strpos($response, $crlf . $crlf);
	if($pos === false) {
		return($response);
	}
	$header = substr($response, 0, $pos);
	$body = substr($response, $pos + 2 * strlen($crlf));
	
	// parse headers
	$headers = array();
	$lines = explode($crlf, $header);
	foreach($lines as $line) {
		if(($pos = strpos($line, ':')) !== false) {
			$headers[strtolower(trim(substr($line, 0, $pos)))] = trim(substr($line, $pos+1));
		}
	}
	// redirection?
	if(isset($headers['location'])) {
		return(pullContent($headers['location']));
	} else {
		return($body);
	}
}	// End pullContent function

$word = strtolower(preg_replace('/[^a-z]/i','',$_REQUEST['word']));
$jsonar = pullContent('https://www.merriam-webster.com/dictionary/'.$word);
$jsonar=preg_replace('/<div id="dictionary-entry-[0-9]{1,2}"/i','<div id="dictionary-entry"',$jsonar);
$matches = explode('<span class="dtText">', $jsonar);

unset($matches['0']);
foreach($matches as $var=>$val){
	$exp=explode('</span>',$val);
	$valz=strip_tags($exp['0']);
	if(strlen($valz) < 200 && strlen($valz) > 3){
		$matches2[$var]=str_replace(':','',$valz);
	}
}
$matches=$matches2;
$gogo = 0;
$def = '';

if(count($matches) > 0){
	foreach($matches as $mm){	
		$ff = explode('</span>', $mm);
		$def .= ($gogo+1).':'.$ff['0']."<br>";
		++$gogo;
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
		<script type="text/javascript">
			$(function(){
				$('dt:even, dd:even').css({'background-color':'#eee'});
			});
		</script>
		
		<style type="text/css">
			body { font: 16px "Lucida Grande",Helvetica,Verdana,Arial,Tahoma,sans-serif; }
			dl { color: #444; 
				 line-height: 20px;
				 width: 450px; }
			dt { border-top: 1px solid #ddd;
				 clear: both;
				 float: left;
				 font-weight: bold;				 
				 margin: 0;
				 padding: 8px 3px;
				 width: 94px; }
			dd { border-top: 1px solid #ddd;
				 float: left;
				 margin: 0;
				 padding: 8px 3px;
				 width: 344px; }
			dd p { margin: 0; 
				   padding: 0; }
		</style>

    </head>
    <body>
<?php

echo "<dl id=\"definitions\">\n";
echo "	<dt id=\"".$word."\">".ucfirst($word)."</dt>\n";
echo "		<dd><p><b>".ucfirst($word).'</b>:<br/> '.$def."</p></dd>\n";
echo "</dl>\n";
?>
</body>
</html>