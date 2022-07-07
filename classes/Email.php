<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;


class Email{
    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }


    public function enviarConfirmacion(){
        //crear objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'a76564791843f9';
        $mail->Password = '4eceb513d720fd';

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com','AppSalon.com');
        $mail->Subject = 'Confirma tu cuenta';

        $mail->isHTML(true);    
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .="<p>Hola <strong>" . $this->nombre . "</strong>, Has creado tu cuenta en App Salon, solo debes confirmarla abriendo el siguiente enlace. </p>";
        $contenido .="<p>Presiona aqui: <a href='https://agile-wave-82507.herokuapp.com/confirmar-cuenta?token=" . $this->token . "'>Confirmar mi cuenta</a> </p>";
        $contenido .= "<p>Si no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;
        
        //enviar email
        $mail->send();
    }

    public function enviarRestablecer(){
        //crear objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'a76564791843f9';
        $mail->Password = '4eceb513d720fd';

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com','AppSalon.com');
        $mail->Subject = 'Restablecer tu password';

        $mail->isHTML(true);    
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .="<p>Hola <strong>" . $this->nombre . "</strong>, Has solicitado restablecer tu password, debes abrir el siguiente enlace para hacerlo. </p>";
        $contenido .="<p>Presiona aqui: <a href='https://agile-wave-82507.herokuapp.com/recuperar?token=" . $this->token . "'>Restablecer mi password</a> </p>";
        $contenido .= "<p>Si  no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;
        
        //enviar email
        $mail->send();
    }

}