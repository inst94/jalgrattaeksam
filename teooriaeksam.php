<?php
require_once("konf.php");
//andmete kustutamine
if(isSet($_REQUEST["kustutamine"])) {
    $kask=$yhendus->prepare("DELETE FROM jalgrattaeksam WHERE id=?");
    $kask->bind_param("i", $_REQUEST["kustutamine"]);
    $kask->execute();
}
if(!empty($_REQUEST["teooriatulemus"])){
    $kask=$yhendus->prepare(
        "UPDATE jalgrattaeksam SET teooriatulemus=? WHERE id=?");
    $kask->bind_param("ii", $_REQUEST["teooriatulemus"], $_REQUEST["id"]);
    $kask->execute();
}
$kask=$yhendus->prepare("SELECT id, eesnimi, perekonnanimi 
     FROM jalgrattaeksam WHERE teooriatulemus=-1");
$kask->bind_result($id, $eesnimi, $perekonnanimi);
$kask->execute();
?>
<!doctype html>
<html>
<head>
    <title>Teooriaeksam</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <div class="ocean">
        <div class="wave"></div>
        <div class="wave"></div>
    </div>
</head>
<body>
<div class="container">
    <nav class="card">
        <a href="slaalom.php">Slaalom</a>
        <a href="ringtee.php">Ringtee</a>
        <a href="t2nav.php">Tänav</a>
        <a href="lubadeleht.php">Lubade leht</a>
    </nav>
</div>
<div class="content">
    <div class="table-wrapper">
        <table class="fl-table">
        <?php
        while($kask->fetch()){
            echo "
                <tr>
                  <td>$eesnimi</td>
                  <td>$perekonnanimi</td>
                  <td><form action=''>
                         <input type='hidden' name='id' value='$id' />
                         <input type='text' name='teooriatulemus' />
                         <input type='submit' value='Sisesta tulemus' />
                         <a href='?kustutamine=$id'>Kustuta osaleja<a/>
                      </form>
                  </td>
                </tr>
              ";
        }
        ?>
        </table>
    </div>
</body>
</html>
