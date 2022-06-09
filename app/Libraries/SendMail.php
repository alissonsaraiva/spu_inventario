<?php

namespace App\Libraries;

class SendMail
{
    // This function converts a string into slug format
    public function processo_desaparecido($processo, $inventariante = null)
    {
        $to = ['genar.junior@economia.gov.br', 'spuce@economia.gov.br', 'cogesspuce@economia.gov.br', 'walter.godinho@economia.gov.br'];
        //$to = 'alissonsaraiva@gmail.com';
        $subject = "Sistema SPU - Processo ".$processo. " encontrado!";
        $message1 = "O sistema de inventário acabou de encontrar o processo de nº ".$processo . "." ;
        $message2 = " Este processo foi cadastrado hoje no sistema pelo inventariante " . $inventariante . "." ;

        if(!is_null($inventariante)){
            $message = $message1 . $message2;
        } else {
            $message = $message1;
        }

        $email = \Config\Services::email();
 
        $email->setTo($to);
        $email->setFrom('sistemaspu@spu.gov.br', 'Sistema - SPU');
        
        $email->setSubject($subject);
        $email->setMessage($message);
 
        $email->send();
    }

    public function usuario_ativo($nome,$emailusuario)
    {
        $email = \Config\Services::email();

        $to = $emailusuario;
        
        $subject = "Sistema SPU - Ativação de usuário";
        
        
        //$message = "Prezado(a) ". $nome .", Informamos que seu usuário foi ativado no Sistema de Inventário. Você poderá logar e utilizar normalmente o sistema." ;

        $message = '<html><body>';
        $message .= 'Prezado(a) '.$nome.',<br><br>';
        $message .= 'Informamos que seu usuário foi ativado no Sistema da SPU. Você poderá logar e utilizar normalmente o sistema.';
        $message .= '</body></html>';
        
        $email->setmailtype('html');
        
        
        $email->setTo($to);
        $email->setFrom('sistemaspu@spu.gov.br', 'Sistema - SPU');
        
        $email->setSubject($subject);
        $email->setMessage($message);
 
        $email->send();
    }

    public function recupera_senha($emailusuario, $token)
    {
        $email = \Config\Services::email();

        $to = $emailusuario;
        
        $subject = "Sistema SPU - Recuperação de senha";
        
        
        /*$message = 'Prezado(a),'.
        'Para resetar sua senha, clique no link:' .
        base_url().'/auth/resetar_senha/'.$token;*/

        $message = '<html><body>';
        $message .= 'Prezado(a),<br><br>';
        $message .= 'Para resetar sua senha do sistema spu, clique no link:<br><br>';
        $message .= '<a href='.base_url().'/auth/resetar_senha/'.$token.'>'.base_url().'/auth/resetar_senha/'.$token.'</a>';
        $message .= '</body></html>';
        
        $email->setmailtype('html');
        $email->setTo($to);
        $email->setFrom('sistemaspu@spu.gov.br', 'Sistema - SPU');
        
        $email->setSubject($subject);
        $email->setMessage($message);
 
        $email->send();
    }


    public function cadastro_servidor($nome,$emailusuario)
    {
        $email = \Config\Services::email();

        $to = $emailusuario;
        
        $subject = "Sistema SPU - Cadastro de Servidor";
        
        
        //$message = "Prezado(a) ". $nome .", Informamos que seu usuário foi ativado no Sistema de Inventário. Você poderá logar e utilizar normalmente o sistema." ;

        $message = '<html><body>';
        $message .= 'Prezado(a) '.$nome.',<br><br>';
        $message .= 'Informamos que seu cadastro foi realizado com sucesso!';
        $message .= '</body></html>';
        
        $email->setmailtype('html');
        
        
        $email->setTo($to);
        $email->setFrom('sistemaspu@spu.gov.br', 'Sistema - SPU');
        
        $email->setSubject($subject);
        $email->setMessage($message);
 
        $email->send();
    }
}