<?php
require_once("konf.php");
if(!empty($_REQUEST["korras_id"])){
    $kask=$yhendus->prepare(
        "UPDATE jalgrattaeksam SET slaalom=1 WHERE id=?");
    $kask->bind_param("i", $_REQUEST["korras_id"]);
    $kask->execute();
}
if(!empty($_REQUEST["vigane_id"])){
    $kask=$yhendus->prepare(
        "UPDATE jalgrattaeksam SET slaalom=2 WHERE id=?");
    $kask->bind_param("i", $_REQUEST["vigane_id"]);
    $kask->execute();
}
$kask=$yhendus->prepare("SELECT id, eesnimi, perekonnanimi 
     FROM jalgrattaeksam WHERE teooriatulemus>=60 AND slaalom=-1");
$kask->bind_result($id, $eesnimi, $perekonnanimi);
$kask->execute();
?>
<!doctype html>
<html>
<head>
    <title>Slaalom</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <div class="ocean">
        <div class="wave"></div>
        <div class="wave"></div>
    </div>
</head>
<body>
<div class="container">
    <nav class="card">
        <a href="teooriaeksam.php">Teooriaeksam</a>
        <a href="ringtee.php">Ringtee</a>
        <a href="t2nav.php">Tänav</a>
        <a href="lubadeleht.php">Lubade leht</a>
    </nav>
</div>
<div class="content">
<h1>Slaalom</h1>
    <div class="table-wrapper">
        <table class="fl-table">
        <?php
        while($kask->fetch()){
            echo "
                <tr>
                  <td>$eesnimi</td>
                  <td>$perekonnanimi</td>
                  <td>
                    <a class='ok' href='?korras_id=$id'>Korras</a>
                  </td>
                  <td>
                    <a class='non-ok' href='?vigane_id=$id'>Ebaõnnestunud</a>
                  </td>
                </tr>
              ";
        }
        ?>
        </table>
    </div>
</body>
</html>
