<?php

namespace App\Controllers;

use App\Libraries\Hash;
use App\Libraries\SendMail;



class Auth extends BaseController
{
    protected $sendmail;

    public function __construct()
    {
        helper(['url', 'form']);
    }
    public function index()
    {

        return view('auth/login');
    }

    public function register()
    {
        return view('auth/register');
    }

    public function save()
    {
        $session = \Config\Services::session();

        $error = $this->validate([
            'nome'     => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'O campo nome é obrigatório.'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[usuarios.email]',
                'errors' => [
                    'required' => 'O campo email é obrigatório.',
                    'valid_email' => 'Digite um email válido.',
                    'is_unique' => 'Este email já está sendo utilizado'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'O campo senha é obrigatório.'
                ]
            ],
            'cpassword' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'O campo confirmação de   senha é obrigatório.',
                    'matches' => 'As senhas não conferem'
                ]
            ]
        ]);

        if (!$error) {
            return view('auth/register', [
                'validation' => $this->validator,
            ]);
        } else {
            $usuarioModel = new \App\Models\UsuariosModel();
            $query = $usuarioModel->save([
                'nome'  => $this->request->getPost('nome'),
                'email'  => $this->request->getPost('email'),
                'password'  => Hash::make($this->request->getPost('password')),
                'ativo' => 0,
                'admin' => 0
            ]);

            if (!$query) {
                $session->setFlashdata('fail', 'Ocorreu um problema na inserção no banco de dados.');
                return $this->response->redirect(base_url('/auth/register'));
            } else {
                $session->setFlashdata('success', 'O registro foi realizado com sucesso! Aguarde o administrador liberar seu acesso.');
                return $this->response->redirect(base_url('/auth/register'));
            }
        }
    }


    public function check()
    {
        $session = \Config\Services::session();
        $error = $this->validate([
            'email'     => [
                'rules' => 'required|valid_email|is_not_unique[usuarios.email]',
                'errors' => [
                    'required' => 'O campo email é obrigatório.',
                    'valid_email' => 'Digite um email válido.',
                    'is_not_unique' => 'Este email não está cadastrado na nossa base de dados.'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'O campo senha é obrigatório.'
                ]
            ]
        ]);

            $email = $this->request->getPost('email', FILTER_SANITIZE_EMAIL);
            $password = $this->request->getPost('password');
            $usuariosModel = new \App\Models\UsuariosModel();
            $usuario_info = $usuariosModel->where('email', $email)->first();

        if (!$error) {
            return view('auth/login', [
                'validation' => $this->validator,
            ]);
        } else if($usuario_info['ativo'] == 1) {
            
            
            $check_password = Hash::check_password($password, $usuario_info['password']);

            if(!$check_password)
            {
                $session->setFlashdata('fail', 'A senha digitada está incorreta.');
                return $this->response->redirect(base_url('/auth'));
            } else
            {
                $usuario_id = $usuario_info['id'];
                session()->set('usuarioLogado', $usuario_id);

                if($usuario_info['consultar_servidores'] == 1){
                    return $this->response->redirect(base_url('/servidores'));
                } else {
                return $this->response->redirect(base_url('/crud'));
                }
            }
        
            
        } else {
            $session->setFlashdata('fail', 'O usuário ainda não está ativado. Aguarde o administrador liberar seu acesso.');
            return $this->response->redirect(base_url('/auth'));
        }
    }

    public function verifica_email($email)
    {
        $session = \Config\Services::session();
        $usuarioModel = new \App\Models\UsuariosModel();
        $emailInfo = $usuarioModel->where('email', $email)->first();

        if(!empty($emailInfo)){
            return true;
        } else {
            return false;
        }

    }

    public function logout()
    {
        if(session()->has('usuarioLogado')){
            session()->remove('usuarioLogado');
            return redirect()->to('/auth?acesso=out')->with('success', 'Você efetuou logout com sucesso.');
        }
    }


    public function esqueceu_senha()
    {
        return view('auth/esqueceu_senha_view');
    }

    public function insere_token_provisorio($email,$token)
    {

        $usuarioModel = new \App\Models\UsuariosModel();

        $result = $usuarioModel->where('email', $email)->first();

        $id = $result["id"];
        
        $data = [
            'token_provisorio' => $token
        ];
        
        $query = $usuarioModel->update($id, $data);
        
        if (!$query) {
            return false;
        } else {
            return true;
        }
        
    }

    public function esqueceu_senha_validation()
    {
        $session = \Config\Services::session();
        $error = $this->validate([
            'email'     => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'O campo email é obrigatório.',
                    'valid_email' => 'Digite um email válido.'
                ]
            ]
        ]);

        $email = $this->request->getPost('email',FILTER_SANITIZE_EMAIL);

        if (!$error) {
            return view('auth/esqueceu_senha_view', [
                'validation' => $this->validator,
            ]);
        } else if($this->verifica_email($email)) {
            
            $token = md5(uniqid($email, true));

            if($this->insere_token_provisorio($email,$token)){
                $sendMail = new SendMail();
                $sendMail->recupera_senha($email, $token);
                $session->setFlashdata('success', 'Foi enviado um e-mail com as instruções para a recuperação de senha. Por favor verifique seu email.');
                return $this->response->redirect(base_url('/auth/esqueceu_senha_view'));
            } else {
                $session->setFlashdata('fail', 'E-mail não encontrado na base de dados.');
                return $this->response->redirect(base_url('/auth/esqueceu_senha_view'));
        }

    } else {
        $session->setFlashdata('fail', 'E-mail não encontrado na base de dados.');
        return $this->response->redirect(base_url('/auth/esqueceu_senha_view'));
    }
}   

public function resetar_senha($token = null)
{
    $session = \Config\Services::session();
    if(empty($token)){
        $session->setFlashdata('fail', 'Você não tem autorização para acessar.');
        return $this->response->redirect(base_url('/auth/resetar_senha_view'));
    } else {
        $data = ['token'=>$token];

        return view('/auth/resetar_senha_view', $data);
    }
    
}

public function resetar_senha_validation()
{
        $session = \Config\Services::session();


            $error = $this->validate([
                'nova_senha' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'O campo senha é obrigatório.'
                    ]
                ],
                'cnova_senha' => [
                    'rules' => 'required|matches[nova_senha]',
                    'errors' => [
                        'required' => 'O campo confirmação de nova senha é obrigatório.',
                        'matches' => 'As senhas não conferem'
                    ]
                ]
            ]);
            
                if (!$error) {
                        return view('auth/resetar_senha_view', [
                            'validation' => $this->validator,
                        ]);
                    } else {
                        
                        $nova_senha = Hash::make($this->request->getPost('nova_senha'));

                        $token = $this->request->getPost('token');
                        
                        $usuarioModel = new \App\Models\UsuariosModel();

                        $result = $usuarioModel->where('token_provisorio', $token)->first();

                        if(!empty($result)){
                            
                            $id = $result["id"];
        
                            $data = [
                                'password' => $nova_senha
                            ];
                            
                            $usuarioModel->update($id, $data);

                            $data = array("message" => "A nova senha foi cadastrada com sucesso.");
                            return view('auth/login', $data);
                        }
                    }
        
    }

}
