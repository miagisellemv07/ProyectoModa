<?php

$filename = "./Archive.zip";

if (file_exists($filename)) {
    $zip = new ZipArchive;

    $result = $zip->open($filename);

    if ($result === TRUE) {
        $zip->extractTo('./');
        $zip->close();
        echo "ok";
    } else {
        echo "error al abrir zip. Código: " . $result;
    }
} else {
    echo "no existe el zip";
}