<?php
require ("konf.php");
session_start();
if(isSet($_REQUEST["sisestusnupp"])){
    if(!empty(trim($_REQUEST["eesnimi"])) && !empty(trim($_REQUEST["perekonnanimi"]))) {
        $kask = $yhendus->prepare("INSERT INTO jalgrattaeksam(eesnimi, perekonnanimi) VALUES (?, ?)");
        $kask->bind_param("ss", $_REQUEST["eesnimi"], $_REQUEST["perekonnanimi"]);
        $kask->execute();
        $yhendus->close();
        header("Location: $_SERVER[PHP_SELF]?lisatudeesnimi=$_REQUEST[eesnimi]");
        exit();
    }
}
?>
<!doctype html>
<html>
<head>
    <title>Kasutaja registreerimine</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<div class="container">
    <nav class="card">
    <?php if(($_SESSION["onAdmin"])==0):?>
        <div class="nav_container">
            <a class="card-register" href="lubadeleht.php">Lubade leht</a>
        </div>
    <?php endif; ?>
    <?php if(($_SESSION["onAdmin"])==1):?>
        <a href="teooriaeksam.php">Teooriaeksam</a>
        <a href="slaalom.php">Slaalom</a>
        <a href="ringtee.php">Ringtee</a>
        <a href="t2nav.php">Tänav</a>
        <a href="lubadeleht.php">Lubade leht</a>
    <?php endif; ?>
    </nav>
</div>
<div class="login_container">
    <div class="screen">
    <h1 class="form_header2">Registreerimine</h1>
    <?php
    if(isSet($_REQUEST["lisatudeesnimi"])){
        echo "Lisati $_REQUEST[lisatudeesnimi]";
    }
    ?>
    <form class="login" action="?">
        <label class="login_label">Eesnimi:</label>
        <input class="login_input" type="text" name="eesnimi" />
        <label class="login_label">Perekonnanimi:</label>
        <input class="login_input" type="text" name="perekonnanimi" />
        <input class="login_submit" type="submit" name="sisestusnupp" value="sisesta" />
    </form>
    </div>
</div>
</body>
</html>
