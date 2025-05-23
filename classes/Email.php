<?php 

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {

    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token) {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion() {

        //Crear el objeto de email
        $mail = new PHPMailer();

        //protocolo de envio email, configuracion del servidor
        $mail->isSMTP();
        $mail->Host = 'smtp-relay.brevo.com';
        $mail->SMTPAuth = true;
        $mail->Username = '8d512c001@smtp-brevo.com';
        $mail->Password = 'RYfQdL8G37B2OtZs';
        $mail->Port = 587;

        //Recipiente, dominio del proyecto que debo modificar al entrar al hosting 
        $mail->setFrom('onofrej14@gmail.com','Pëluqueria canina');
        $mail->addAddress($this->email);
        $mail->Subject = 'Confirma tu cuenta';

        //Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UFT-8';

        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has creado tu cuenta en Peluqueria Canina, solo debes confirmarla presionando el siguiente enlace </p>";
        $contenido .= "<p>Presionar aqui: <a href='http://peluqueriacanina.alwaysdata.net/confirmar-cuenta?token=". $this->token ."'>Confirmar Cuenta</a> </p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje.</p>";
        $contenido .= "</html>";
        $mail->Body = $contenido;

        //enviar el mail
        $mail->send();
    }

    public function enviarInstrucciones() {

        // create a new object
        $mail = new PHPMailer();
        //protocolo de envio email, configuracion del servidor
        $mail->isSMTP();
        $mail->Host = 'smtp-relay.brevo.com';
        $mail->SMTPAuth = true;
        $mail->Username = '8d512c001@smtp-brevo.com';
        $mail->Password = 'RYfQdL8G37B2OtZs';
        $mail->Port = 587;

        //Recipiente, dominio del proyecto que debo modificar al entrar al hosting 
        $mail->setFrom('onofrej14@gmail.com','Pëluqueria canina');
        $mail->addAddress($this->email);
        $mail->Subject = 'Confirma tu cuenta';

        //Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UFT-8';

        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre .  "</strong> Has solicitado reestablecer tu password, sigue el siguiente enlace para hacerlo.</p>";
        $contenido .= "<p>Presiona aquí: <a href='http://peluqueriacanina.alwaysdata.net/recuperar?token=" . $this->token . "'>Reestablecer Password</a>";        
        $contenido .= "<p>Si tu no solicitaste este cambio, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";
        $mail->Body = $contenido;

            //Enviar el mail
        $mail->send();
    }

}