<?php
$kaubad=simplexml_load_file("andmed.xml");
//otsing nimetuse järgi

function searchByName($query){
    global $kaubad;
    $result=array();
    foreach ($kaubad->ilma as $ilma){
        if(substr(strtolower($ilma->temperatuur),0,strlen($query))==
        strtolower($query)){
            array_push($result,$ilma);
        }
    }
    return $result;
}

//andmete lisamine xml-i
 if(isset($_POST['submit'])){
    $temperatuur=$_POST['temperatuur'];
    $kuupaev=$_POST['kuupaev'];
    $maakonnanimi=$_POST['mnimi'];
    $maakonnakeskus=$_POST['mkeskus'];

    $xml_kaubad=$kaubad->addChild('ilma');
    $xml_kaubad->addChild('temperatuur',$temperatuur);
    //addchild ('xml struktuur',$nimi - teksti väli)
    $xml_kaubad->addChild('kuupaev',$kuupaev);
    $xml_kaubad->addChild('maakonnanimi',$maakonnanimi);
    //$xml_kaubad->addChild('hind',$hind);

     // andmete lisamine <kaup><kaubagrupp> alla

     $xml_maakonna=$xml_kaubad->addChild('maakonna');
     $xml_maakonna->addChild('maakonnakeskus',$maakonnakeskus);

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
     foreach ($result as $ilma){
        echo "<li>".$ilma->temperatuur;
        echo ", ".$ilma->kuupaev."<li>";
        echo ", ".$ilma->maakonna->maakonnanimi."<li>";
     }
    }
    ?>

    <table>
        <tr>
            <th>Temperatuur</th>
            <th>Kuupäev</th>
            <th>Maakonnanimi</th>
            <th>Maakonnakeskus</th>
        </tr>

        <?php
        foreach ($kaubad->ilma as $ilma){
            echo "<tr>";
            echo "<td>".($ilma->temperatuur)."</td>";
            echo "<td>".($ilma->kuupaev)."</td>";
            echo "<td>".($ilma->maakonna->maakonnanimi)."</td>";
            echo "<td>".($ilma->maakonna->maakonnakeskus)."</td>";
            echo "</tr>";
        }
        ?>

    </table>
    <section>
        <img src="bullymaguire.gif">
    </section>
<h1>
    Andmete lisamine xml faili sisse
</h1>
<form action="" method="post">
    <table border="1">
        <tr>
            <td><label for="temperatuur">Temperatuur</label></td>
            <td><input type="number" id="temperatuur" name="temperatuur"></td>
        </tr>
        <tr>
            <td><label for="kuupaev">Kuupäaev</label></td>
            <td><input type="date" id="kuupaev" name="kuupaev"></td>
        </tr>
        <tr>
            <td><label for="maakonnanimi">Makonnanimi</label></td>
            <td><input type="text" id="maakonnanimi" name="maakonnanimi"></td>
        </tr>
        <tr>
            <td><label for="maakonnakeskus">Makonnakeskus</label></td>
            <td><input type="text" id="maakonnakeskus" name="maakonnakeskus"></td>
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
