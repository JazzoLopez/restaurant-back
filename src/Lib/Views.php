<?php

namespace App\Lib;

class Views
{
    public function accountValidHtml($result)
    {
        return "
        <!DOCTYPE html>
            <html lang='en'>
            <head>
            <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Verificacion de cuenta</title>
            <head>
                <title>Cuenta Verificada</title>
                <style>
                    body {
                        font-family: system-ui;
                        text-align: center;
                        margin: 0;
                        padding: 0;
                    }
                    .container {
                        width: 100%;
                        max-width: 600px;
                        margin: 0 auto;
                        padding: 20px;
                    }
                    .card {
                        border: 1px solid #ccc;
                        border-radius: 10px;
                        padding: 20px;
                        background-color: #DFF0D8; /* Color verde para cuenta verificada */
                    }
                    h1 {
                        color: green; /* Título en verde para cuenta verificada */
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='card'>
                        <h1>Cuenta Verificada</h1>
                        <p>{$result->message}</p>
                    </div>
                    <p>Por favor cierra esta ventana y vuelve a la aplicación.</p>
                </div>
            </body>
        </html>
    ";
    }

    public function accountInvalidHTML($result)
    {
        return "
            <!DOCTYPE html>
                <html lang='en'>
    <head>
    <meta charset='UTF-8'>
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
<title>Verificacion de cuenta</title>
                <style>
                    body {
                        font-family: system-ui;
                        text-align: center;
                        margin: 0;
                        padding: 0;
                    }
                    .container {
                        width: 100%;
                        max-width: 600px;
                        margin: 0 auto;
                        padding: 20px;
                    }
                    .card {
                        border: 1px solid #ccc;
                        border-radius: 10px;
                        padding: 20px;
                        background-color: #F2DEDE; /* Color rojo para cuenta inválida */
                    }
                    h1 {
                        color: red; /* Título en rojo para cuenta inválida */
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='card'>
                        <h1>Fallo de Verificación de Cuenta</h1>
                        <p>{$result->message}</p>
                    </div>
                </div>
            </body>
        </html>
    ";
    }

}
