<?php
$kaubad=simplexml_load_file("andmed.xml");
//otsing nimetuse järgi

function searchByName($query){
    global $kaubad;
    $result=array();
    foreach ($kaubad->kaup as $kaup){
        if(substr(strtolower($kaup->nimetus),0,strlen($query))==
            strtolower($query)){
            array_push($result,$kaup);
        }
    }
    return $result;
}

//andmete lisamine xml-i
if(isset($_POST['submit'])){
    $nimi=$_POST['nimi'];
    $hind=$_POST['hind'];
    $aasta=$_POST['vaasta'];
    $grupp=$_POST['grupp'];

    $xml_kaubad=$kaubad->addChild('kaup');
    $xml_kaubad->addChild('nimetus',$nimi);
    //addchild ('xml struktuur',$nimi - teksti väli)
    $xml_kaubad->addChild('hind',$hind);
    $xml_kaubad->addChild('vaasta',$aasta);
    //$xml_kaubad->addChild('hind',$hind);

    // andmete lisamine <kaup><kaubagrupp> alla

    $xml_kaubagrupp=$xml_kaubad->addChild('kaubagrupp');
    $xml_kaubagrupp->addChild('grupinimi',$grupp);

    $xmlDoc=new DOMDocument("1.0","UTF-8");
    $xmlDoc->loadXML($kaubad->asXML(),LIBXML_NOBLANKS);
    $xmlDoc->preserveWhiteSpace=false;
    $xmlDoc->formatOutput=true;
    $xmlDoc->save('andmed.xml');
    header("refresh: 0;");

}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>XML andmed</title>
    <link rel="stylesheet" href="andmedstyle.css">
</head>
<body>
<div id="menuu2">
    <a href="index.php">Back</a>
</div>
<h1>RSS - Rich Summary Site / üks XML andmevormingusts</h1>
<h2>Postimees rss uudised leht</h2>
<ul>
    <?php
    $feed=simplexml_load_file('https://rus.postimees.ee/rss');
    $linkide_arv=3;
    $loendur=1;
    foreach ($feed->channel->item as $item){
        if ($loendur<=$linkide_arv){
            echo "<li>";
            echo "<br>";
            echo "<a href='$item->link' target='_blank'> $item->title</a>";
            $loendur++;
        }
    }
    ?>
</ul>

<h2>Lenta rss uudised leht</h2>

<ul>
    <?php
    $feed=simplexml_load_file('https://lenta.ru/rss');
    $linkide_arv=3;
    $loendur=1;
    foreach ($feed->channel->item as $item){
        if ($loendur<=$linkide_arv){
            echo "<li>";
            echo "<br>";
            echo "<a href='$item->link' target='_blank'> $item->title</a>";
            $loendur++;
        }
    }
    ?>
</ul>

</body>
</html>