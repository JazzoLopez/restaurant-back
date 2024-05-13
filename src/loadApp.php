<?php
$base = __DIR__ . '/';

$folders = [
    'Controladores',
    'Lib',
    'Modelos',
    'Rutas',

];

foreach($folders as $f)
{
    foreach (glob($base . "$f/*.php") as $k => $filename)
    {
        require $filename;
    }
}

