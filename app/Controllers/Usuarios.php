<?php

namespace App\Controllers;

use App\Models\UsuariosModel;
use App\Libraries\SendMail;

class Usuarios extends BaseController
{

    protected $sendmail;

    public function __construct()
    {
        
        helper(['form', 'url']);

    }

	public function index()
	{

		$usuariosModel = new UsuariosModel();

        $usuarioLogadoId = session()->get('usuarioLogado');

        $usuarioInfo = $usuariosModel->find($usuarioLogadoId);

        $data = [
            'usuarios' => $usuariosModel->orderBy('id', 'DESC')->paginate(10),
            'total_registros' => $usuariosModel->countAll(),
            'total_ativos' => $usuariosModel->where('ativo', 1)->countAllResults(),
            'pagination_link' => $usuariosModel->pager,
            'title' => 'Gestão de Usuários',
            'main_content' => 'gerir_usuarios',
            'usuarioInfo' => $usuarioInfo
        ];
		
        echo view('innerpages/template', $data);

		
    
	}

   public function search_single_data()
    {

        $db = \Config\Database::connect();

        helper(['form', 'url']);

        $usuariosModel = new UsuariosModel();

        $usuarioLogadoId = session()->get('usuarioLogado');

        $usuarioInfo = $usuariosModel->find($usuarioLogadoId);

        $usuariosModel = new UsuariosModel();

        $consulta = "SELECT * FROM usuarios WHERE ";

        $nome = $this->request->getVar('nome');

        $email = $this->request->getVar('email');

        if($nome !== ""){
            $consulta = $consulta . "nome" . " LIKE " . "'" . "%" . $nome . "%" . "'";
        }
        

        if($email !== ""){
            if($nome !== "" ){
                $consulta = $consulta . " AND " . "email" . " LIKE " . "'" . "%" . $email . "%" . "'";
            } else {
                $consulta = $consulta . "email" . " LIKE " . "'" . "%" . $email . "%" . "'";
            }
        }

        $consulta = $consulta . ';';

        $query = $db->query($consulta);

        $results = $query->getResultArray();



            $data['usuarios'] = $results;

            $data['title'] 		= 'Gestão de Usuários';
		
            $data['main_content']	= 'gerir_usuarios';

            $data['usuarioInfo'] = $usuarioInfo;

            $data['pagination_link'] = $usuariosModel->pager;

            $data['total_registros'] = $usuariosModel->countAll();

            $data['total_ativos'] = $usuariosModel->where('ativo', 1)->countAllResults();

            $data['consulta'] = $consulta;
		
        echo view('innerpages/template', $data);
    

    }

    public function ativar_usuario($id){

        $session = \Config\Services::session();
        
        $usuariosModel = new UsuariosModel();
        
        $data = [
            'ativo' => 1
        ];
        
        $usuariosModel->update($id, $data);

        $usuarioInfo = $usuariosModel->where('id', $id)->first();

        $this->sendMail = new SendMail();

        $session->setFlashdata('success', 'O usuário foi ativado com sucesso! O sistema enviará um email automático para o usuário.');
        
        $nome = $usuarioInfo['nome'];
        $email = $usuarioInfo['email'];
        
        $this->sendMail->usuario_ativo($nome, $email);

        return $this->response->redirect(base_url('/usuarios'));

    }

   public function desativar_usuario($id){

        $session = \Config\Services::session();
        
        $usuariosModel = new UsuariosModel();
        
        $data = [
            'ativo' => 0
        ];
        
        
        $usuariosModel->update($id, $data);

        $session->setFlashdata('success', 'O usuário foi desativado com sucesso!');

        return $this->response->redirect(base_url('/usuarios'));

    }

    public function tornar_admin($id){

        $session = \Config\Services::session();

        $usuariosModel = new UsuariosModel();
        
        $data = [
            'admin' => 1
        ];
        
        
        $usuariosModel->update($id, $data);

        $session->setFlashdata('success', 'O usuário foi tornado admin com sucesso!');

        return $this->response->redirect(base_url('/usuarios'));

    }

   public function retirar_admin($id){

        $session = \Config\Services::session();

        $usuariosModel = new UsuariosModel();
        
        $data = [
            'admin' => 0
        ];
        
        
        $usuariosModel->update($id, $data);

        $session->setFlashdata('success', 'A permissão de admin foi revogada com sucesso!');

        return $this->response->redirect(base_url('/usuarios'));

    }

    function delete($id)
    {
        $usuariosModel = new UsuariosModel();

        $usuario = $usuariosModel->where('id', $id)->first();

        $usuariosModel->where('id', $id)->delete($id);

        $session = \Config\Services::session();

        $session->setFlashdata('success', 'Usuário '.$usuario['nome']. ' deletado com sucesso!');

        return $this->response->redirect(base_url('/usuarios'));
    }



    public function habilitar_consultar_servidores($id){

        $session = \Config\Services::session();

        $usuariosModel = new UsuariosModel();
        
        $data = [
            'consultar_servidores' => 1
        ];
        
        
        $usuariosModel->update($id, $data);

        $session->setFlashdata('success', 'A permissão para consultar servidores foi dada com sucesso!');

        return $this->response->redirect(base_url('/usuarios'));

    }

   public function desabilitar_consultar_servidores($id){

        $session = \Config\Services::session();

        $usuariosModel = new UsuariosModel();
        
        $data = [
            'consultar_servidores' => 0
        ];
        
        
        $usuariosModel->update($id, $data);

        $session->setFlashdata('success', 'A permissão de consultar servidores foi revogada com sucesso!');

        return $this->response->redirect(base_url('/usuarios'));

    }


}
