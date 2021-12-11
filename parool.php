<?php
$parool='kala';
$sool='tavalinetekst';
$krypt=crypt($parool, $sool);
echo $krypt;