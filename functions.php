<?php

// Printando arquivos
function pre_r($array)
{
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

const BR = "<br />";

function clean_scandir($dir)
{
    return array_values(array_diff(scandir($dir), array("..", ".")));
}

function clean_ftp_nlist($ftp_connection, $server_dir)
{
    $files_on_server = ftp_nlist($ftp_connection, $server_dir);
    return array_values(array_diff($files_on_server, array(".", "..")));
}

function upload_files($ftp_connection, $local, $server_dir)
{
    $files = clean_scandir($local);

    for ($i = 0; $i < count($files); $i++) {

        $files_on_server = clean_ftp_nlist($ftp_connection, $server_dir);
        if (!in_array("$files[$i]", $files_on_server)) {

            if (ftp_put($ftp_connection, "$server_dir/$files[$i]", "$local/$files[$i]", FTP_BINARY)) {
                echo "Upload feito com sucesso $files[$i]" . BR;
            } else {
                echo "Ocorreu um problema ao fazer o upload em $files[$i]" . BR;
            }
        } else {
            echo "$server_dir/$files[$i] já existe!" . BR;
        }
    }

    $files_on_server = clean_ftp_nlist($ftp_connection, $server_dir);
    ftp_close($ftp_connection);
    return $files_on_server;
}
