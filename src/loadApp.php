<?php
$base = __DIR__ . '/';

$folders = [
    'Controladores',
    'Modelos',
    'Rutas',
    'Lib'
];

foreach($folders as $f)
{
    foreach (glob($base . "$f/*.php") as $k => $filename)
    {
        require $filename;
    }
}

