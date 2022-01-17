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
    <h1>
        XML failist andmed
    </h1>
    <form action="?" method="post">
        <label for="otsing">Otsing</label>
        <input type="text" name="otsing" id="otsing" placeholder="nimetus">
        <input type="submit" value="otsi">
        <br><br>
    </form>

    <?php
    if (!empty($_POST['otsing'])){
     $result=searchByName($_POST['otsing']);
     foreach ($result as $kaup){
        echo "<li>".$kaup->nimetus;
        echo ", ".$kaup->vaasta."<li>";
        echo ", ".$kaup->kaubagrupp->gruppinimi."<li>";
     }
    }
    ?>

    <table>
        <tr>
            <th>Kaubanimetus</th>
            <th>Hind</th>
            <th>Väljastamise aasta</th>
            <th>Kaubagrupp</th>
            <th>Kirjeldus</th>
        </tr>

        <?php
        foreach ($kaubad->kaup as $kaup){
            echo "<tr>";
            echo "<td>".($kaup->nimetus)."</td>";
            echo "<td>".($kaup->hind)."</td>";
            echo "<td>".($kaup->vaasta)."</td>";
            echo "<td>".($kaup->kaubagrupp->gruppinimi)."</td>";
            echo "<td>".($kaup->kaubagrupp->kirjeldus)."</td>";
            echo "</tr>";
        }
        ?>

    </table>
<h1>
    Andmete lisamine xml faili sisse
</h1>
<form action="" method="post">
    <table border="1">
        <tr>
            <td><label for="nimi">Kauba nimetus</label></td>
            <td><input type="text" id="nimi" name="text"></td>
        </tr>
        <tr>
            <td><label for="hind">Hind</label></td>
            <td><input type="text" id="hind" name="hind"></td>
        </tr>
        <tr>
            <td><label for="vaasta">Väljastamise aasta</label></td>
            <td><input type="text" id="vaasta" name="vaasta"></td>
        </tr>
        <tr>
            <td><label for="grupp">Kauba grupp</label></td>
            <td><input type="text" id="grupp" name="grupp"></td>
        </tr>
        <tr>
            <td><label for="kirjeldus">Kirjeldus</label></td>
            <td><input type="text" id="kirjeldus" name="kirjeldus"></td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" value="lisa" name="submit">
            </td>
        </tr>
    </table>
</form>
    <div id="menuu">
        <br><br>
        <a href="uudised.php">Vaata 3 uued uudised</a>
        <br><br>
        <a href="andmed.xml">Vajuta siia (XML)</a>
    </div>
</body>
</html>
