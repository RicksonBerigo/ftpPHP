<?php

require_once __DIR__ . '/./config.php';
require_once __DIR__ . '/./functions.php';

// Conectando com o servidor remoto FTP
$ftp_connection = ftp_connect($ftp_host) or die("Não é possível conectar ao $ftp_host");
ftp_login($ftp_connection, $ftp_user, $ftp_pass) or die("Não é possível logar no servidor ftp");

ftp_pasv($ftp_connection, true);

// Diretorios
$local = "./arquivos/";
$remoto = "/";

pre_r(upload_files($ftp_connection, $local, $remoto));
