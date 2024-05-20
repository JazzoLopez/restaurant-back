<?php

namespace App\Lib;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    private $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->configure();
    }

    private function configure()
    {
        $this->mail->isSMTP();
        $this->mail->Host = 'smtp.gmail.com';
        $this->mail->SMTPAuth = true;
        $this->mail->Username = $_ENV['EMAIL'];;
        $this->mail->Password = $_ENV['EMAIL_PASSWORD'];;
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port = 587;
    }

    public function sendMail($to, $subject, $userData, $token = null, $altBody = '')
    {
        try {
            $this->mail->setFrom($_ENV['EMAIL'], 'Reservaciones Express');
            $this->mail->addAddress($to);

            $body = "
            <html>
                <head>
                    <style>
                        .container {
                            font-family: Arial, sans-serif;
                            margin: 20px;
                            padding: 20px;
                            border: 1px solid #ccc;
                            border-radius: 10px;
                            background-color: #f9f9f9;
                        }
                        .header {
                            text-align: center;
                            background-color: #4CAF50;
                            color: white;
                            padding: 10px;
                            border-radius: 10px 10px 0 0;
                        }
                        .content {
                            margin-top: 20px;
                            padding: 10px;
                            border: 1px solid #ccc;
                            border-radius: 10px;
                            letter-spacing: 0.5px;
                        }
                        .button {
                            display: inline-block;
                            padding: 10px 20px;
                            font-size: 16px;
                            color: white;
                            background-color: #4CAF50;
                            text-align: center;
                            text-decoration: none;
                            border-radius: 5px;
                            margin-top: 20px;
                            transition-duration: 0.2s;
                        }

                        .button:hover{
                            display: inline-block;
                            padding: 10px 20px;
                            font-size: 16px;
                            color: rgb(90, 90, 90);
                            background-color: #a0f3a2;
                            text-align: center;
                            text-decoration: none;
                            border-radius: 5px;
                            margin-top: 20px;
                        }
                        .footer {
                            margin-top: 20px;
                            text-align: center;
                            color: #777;
                            font-size: 12px;
                        }
                    </style>
                </head>
                    <body>
                        <div class='container'>
                            <div class='header'>
                                <h1>Verificación de Cuenta</h1>
                            </div>
                                <div class='content'>
                                    <p>Hola, {$userData->name}</p>
                                    <p>Gracias por registrarte. Por favor, haz clic en el botón de abajo para activar tu cuenta:</p>
                                    <a href='https://site--restaurant--kzdpwwvkt5l6.code.run/verificar-cuenta/{$token}' class='button'>Activar cuenta</a>
                                    <p>Gracias por tu atención.</p>
                                </div>
                            <div class='footer'>
                                <p>Reservaciones Express S.A de C.V</p>
                            </div>
                        </div>
                    </body>
                </html>

            ";

            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body = $body;
            $this->mail->AltBody = $altBody;
            $this->mail->send();

        } catch (Exception $e) {
            echo "El mensaje no pudo ser enviado. Error de PHPMailer: {$this->mail->ErrorInfo}";
        }
    }

}
