<?php
ini_set("allow_url_fopen", "On");
$card = $_POST['Card'];
$lcard = strtolower($card);
$ucard = rawurlencode($card);
$set = urlencode($_POST['Set']);
$lset = strtolower($set);
$uset = rawurlencode($set);
$imageset =  str_replace("+", " ", $set);  
$apiget = str_replace(" ", "-", $lcard);
$foil = $_POST['Foil'];
$url = "http://partner.tcgplayer.com/x3/phl.asmx/p?pk=TCGTEST&s=$set&p=$ucard";


echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Underground Games - Card Search</title>
</head>

<body>
<html>
<head>
	<meta charset="utf-8" />
	<title>Underground Games - Card Search</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="blurBg-true" style="background-color:#EBEBEB">

<link rel="stylesheet" href="cssb.css" type="text/css" />
<script type="text/javascript" src="jquery.min.js"></script>';

echo '<form class="cssb" style="background-color:#FFFFFF;font-size:14px;font-family:Roboto,Arial,Helvetica,sans-serif;color:#34495E;max-width:480px;min-width:150px" action="search.php" method="post" enctype="application/x-www-form-urlencoded">';
echo '<div class="title"> 
     <h2>Underground Games - Card Search</h2>
     </div>
	<div class="element-input">
    <label class="title">
    </label><div class="item-cont">';

//!card name replacement//
if (empty($_POST["Card"])) {
//! Enter Card Name
echo '<input class="large" type="text" name="Card" required="required" value="" placeholder="Card Name"/>';
echo '<div class="submit"><input type="submit" value="Submit"/>';
echo '<span class="icon-place">
    </span>
    </div>
    </div>
	<div class="element-input">
    <label class="title">
    </label><div class="item-cont">';;
} else {
echo '<input class="large" type="text" name="Card" required="required" value="';
echo $card;
echo '" placeholder="Card Name"/>';
echo '<span class="icon-place"></span></div></div><div class="element-input"><label class="title"></label><div class="item-cont">';

//! Pulling sets the searched card was printed in. 

$cardfile = "https://api.deckbrew.com/mtg/cards/$apiget";
$ch = curl_init();
curl_setopt ($ch, CURLOPT_URL, $cardfile);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
$cardinfo= curl_exec($ch);
curl_close($ch);

$setinfo = json_decode($cardinfo, true);
echo '<select name="Set">';
//! Make an entry in the list for each set listed.
foreach($setinfo['editions'] as $key => $val){

echo "<option value='";
echo $val['set'];
echo "'>";
echo $val['set'];
echo "</option>";
}
echo "</select>";
	
echo '<span class="icon-place">
    </span>
    </div>
    </div>
	<div class="submit"><input type="submit" value="Submit"/>';
}

//! Image Fetch.
if (empty($set)) {
    $img = "http://www.mtgimage.com/card/$card.jpg";
} else {
    $img = "http://www.mtgimage.com/setname/$imageset/$card.jpg";
}

if (empty($_POST["Card"])) {
    echo "Enter Card Name";
} else {
    $xml = simplexml_load_file($url) or die("Error: Cannot find card.");
	$link = $xml->product->link;
	$Highp = $xml->product->hiprice;
	$Midp = $xml->product->avgprice;
	$Lowp = $xml->product->lowprice;
	$Foilp = $xml->product->foilavgprice;
	$tcgid = $xml->product->id;
	$purchase = "http://store.tcgplayer.com/product.aspx?id=$tcgid&partner=TCGTEST";
	echo $xml;
	echo "<center><img src=\"".$img."\" alt=\"Card\" style=\"width:270px;height:382px\"></center>";
	echo '<p><center><table width="200" border="1">';
	echo '<caption>';
	echo "$card";
	echo ' - ';
	echo "$imageset";
	echo '</caption>';
	echo '<tr><td>High</td><td>Mid</td><td>Low</td><td>Foil</td></tr><tr><td>';
	echo $Highp;
	echo '</td><td>';
	echo $Midp;
	echo '</td><td>';
	echo $Lowp;
	echo '</td><td>';
	echo $Foilp;
	echo '</td></tr></table></center><br>';
	echo "<br>";
	echo '<center><ahref=http://store.tcgplayer.com/product.aspx?id=';
	echo $tcgid;
	echo "&partner=TCGTEST>Purchase</a>";
	echo "</center></p>";
}



echo '</div>';
echo "<center>&#169 Copyright Underground Games 2015</center>";
echo '</form>';
echo "</body>";
echo "</html>";

?>

