<?php
require_once("konf.php");
session_start();
if(!empty($_REQUEST["vormistamine_id"])){
    $kask=$yhendus->prepare(
        "UPDATE jalgrattaeksam SET luba=1 WHERE id=?");
    $kask->bind_param("i", $_REQUEST["vormistamine_id"]);
    $kask->execute();
}
$kask=$yhendus->prepare(
    "SELECT id, eesnimi, perekonnanimi, teooriatulemus, 
	     slaalom, ringtee, t2nav, luba FROM jalgrattaeksam;");
$kask->bind_result($id, $eesnimi, $perekonnanimi, $teooriatulemus,
    $slaalom, $ringtee, $t2nav, $luba);
$kask->execute();

function asenda($nr){
    if($nr==-1){return ".";} //tegemata
    if($nr== 1){return "korras";}
    if($nr== 2){return "ebaõnnestunud";}
    return "Tundmatu number";
}
?>
<!doctype html>
<html>
<head>
    <title>Lõpetamine</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<div class="container">
<nav class="card">
    <?php if(($_SESSION["onAdmin"])==0):?>
        <a href="registreerimine.php">Registreerimine</a>
    <?php endif; ?>
    <?php if(($_SESSION["onAdmin"])==1):?>
        <a href="teooriaeksam.php">Teooriaeksam</a>
        <a href="slaalom.php">Slaalom</a>
        <a href="ringtee.php">Ringtee</a>
        <a href="t2nav.php">Tänav</a>
    <?php endif; ?>
</nav>
</div>
<h2 class="logged_in_user"> <?=$_SESSION["kasutajad"]?> on sisse logitud</h2>
<form action="logout.php" method="post">
    <input class="button_submit" type="submit" value="Logi välja" name="logout">
</form>
<div class="content">
    <h1>Lõpetamine</h1>
    <div class="table-wrapper">
        <table class="fl-table">
            <div class="table-header">
            <tr>
                <th>Eesnimi</th>
                <th>Perekonnanimi</th>
                <th>Teooriaeksam</th>
                <th>Slaalom</th>
                <th>Ringtee</th>
                <th>Tänavasõit</th>
                <th>Lubade väljastus</th>
            </tr>
            </div>
            <?php
            while($kask->fetch()){
                $asendatud_slaalom=asenda($slaalom);
                $asendatud_ringtee=asenda($ringtee);
                $asendatud_t2nav=asenda($t2nav);
                $loalahter=".";
                if($luba==1){$loalahter="Väljastatud";}
                if($luba==-1 and $t2nav==1){
                    if (($_SESSION["onAdmin"]) == 1){
                        $loalahter="<a href='?vormistamine_id=$id'>Vormista load</a>";
                    }
                }
                echo "
                     <tr>
                       <td>$eesnimi</td>
                       <td>$perekonnanimi</td>
                       <td>$teooriatulemus</td>
                       <td>$asendatud_slaalom</td>
                       <td>$asendatud_ringtee</td>
                       <td>$asendatud_t2nav</td>
                       <td>$loalahter</td>
                     </tr>
                   ";
            }
            ?>
        </table>
    </div>
</div>
</body>
</html>