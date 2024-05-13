<?php
$base = __DIR__ . '/';

$folders = [
    'Controllers',
    'Lib',
    'Models',
    'Routes',

];

foreach($folders as $f)
{
    foreach (glob($base . "$f/*.php") as $k => $filename)
    {
        require $filename;
    }
}

