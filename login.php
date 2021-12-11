<link rel="stylesheet" href="styles.css">
<div class="login_container">
    <div class="screen">
        <h1 class="form_header">Login vorm</h1>
        <form class="login" action="" method="post">
            <label class="login_label">Kasutaja nimi:</label>
            <input class="login_input" type="text" name="login" placeholder="nimi">
            <label class="login_label">Salasõna:</label>
            <input class="login_input" type="password" name="pass">
            <br>
            <?php
            require("konf.php");
            global $yhendus;
            session_start();
            if (!empty($_POST['login']) && !empty($_POST['pass'])) {
                $login = htmlspecialchars(trim($_POST['login']));
                $pass = htmlspecialchars(trim($_POST['pass']));

                $sool = 'taiestisuvalinetekst';
                $kryp = crypt($pass, $sool);
                //kontroll, et andmebaasis on selline kasutaja
                $paring = "SELECT kasutaja,onAdmin,koduleht FROM kool WHERE kasutaja=? AND parool=?";
                $kask = $yhendus->prepare($paring);
                $kask->bind_param("ss", $login, $kryp);
                $kask->bind_result($kasutaja, $onAdmin, $koduleht);
                $kask->execute();
                if ($kask->fetch()) {
                    $_SESSION['tuvastamine'] = 'misiganes';
                    $_SESSION['kasutajad'] = $kasutaja;
                    $_SESSION['onAdmin'] = $onAdmin;
                    if (isset($koduleht)) {
                        header('Location: lubadeleht.php');
                        exit();
                    } else {
                        header('Location: lubadeleht.php');
                        exit();
                    }
                }elseif (strlen($pass) < 5) {
                    echo "<label class='validation_error1'>Parool peab olema vähemalt 5 märku pikk</label>";
                }else{
                    echo "<label class='validation_error2'>Kasutaja $login voi parool $kryp on valed</label>";
                }
            }
            ?>
            <br>
            <input class="login_submit" type="submit" value="Logi sisse">
        </form>
    </div>
</div>
<?php
/*
 * CREATE TABLE kool(
    id int PRIMARY KEY AUTO_INCREMENT,
    kasutaja varchar(10),
    parool text,
    onAdmin tinyint(4),
    koduleht varchar(100))
 */