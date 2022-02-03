<?php

namespace App\Controllers;

use App\Libraries\SendMail;
use App\Libraries\Util;
use App\Models\CrudModelDesaparecidos;
use App\Models\CrudModel;

class Desaparecidos extends BaseController
{
protected $sendmail;
protected $util;



	public function index()
	{
        $usuariosModel = new \App\Models\UsuariosModel();

        $usuarioLogadoId = session()->get('usuarioLogado');

        $usuarioInfo = $usuariosModel->find($usuarioLogadoId);

		$crudModelDesaparecidos = new crudModelDesaparecidos();


        
        $data = [
            'processo' => $crudModelDesaparecidos->orderBy('id', 'DESC')->paginate(10),
            'total_processos_desaparecidos' => $crudModelDesaparecidos->countAll(),
            'total_processos_perdidos' => null,
            'total_registros' => null,
            'total_processos_achados' => null,
            'pagination_link' => $crudModelDesaparecidos->pager,
            'title' => 'Processos Desaparecidos',
            'main_content' => 'processos_desaparecidos',
            'usuarioInfo' => $usuarioInfo
        ];
		
        echo view('innerpages/template', $data);
		
    
	}

	public function add()
	{

        $usuariosModel = new \App\Models\UsuariosModel();

        $usuarioLogadoId = session()->get('usuarioLogado');

        $usuarioInfo = $usuariosModel->find($usuarioLogadoId);

        $data['title'] 		= 'Adicionar Processo';
		
        $data['main_content']	= 'add_desaparecido';

        $data['usuarioInfo'] = $usuarioInfo;
		
        echo view('innerpages/template', $data);
    
	}

	public function add_processo_desaparecido()
	{
        
        helper(['form', 'url']);
        $this->util = new Util();
        $crudModelDesaparecidos = new crudModelDesaparecidos();
        $crudModel = new crudModel();
        $session = \Config\Services::session();

        $usuariosModel = new \App\Models\UsuariosModel();

        $usuarioLogadoId = session()->get('usuarioLogado');

        $usuarioInfo = $usuariosModel->find($usuarioLogadoId);

            $numero_processo_alias = $this->request->getVar('numero_processo');
            $numeroprocesso = $this->util->limpa_numero_processo($this->request->getVar('numero_processo'));
            $processo = $this->request->getVar('numero_processo');

            $data['processo_inventario'] = $crudModel->where('numero_processo', $numeroprocesso)->findAll();

            $error = $this->validate([
                'numero_processo' 	=> [
                    'rules'=>'required',
                    'errors'=> [
                        'required' => 'O campo número do processo é obrigatório.'
                    ]
                    ]
            ]);


            if(!$error)
            {
                $data['title'] 		= 'Novo';
		
                $data['main_content']	= 'add_desaparecido';

                $data['usuarioInfo'] = $usuarioInfo;
		
            echo view('innerpages/template', $data,  ['error' => $this->validator]);
            
                //echo view('add_desaparecido', [
                   // 'error' => $this->validator
                //]);
            } else {
            
            
            if(!$this->existe_processo($numeroprocesso)){
            
            $crudModelDesaparecidos->save([
                'numero_processo' => $numeroprocesso,
                'numero_processo_alias' => $numero_processo_alias,
                'foi_achado'  => false

            ]);          
            
            $session->setFlashdata('success', 'Processo nº ' . $processo . ' cadastrado com sucesso!');

           
        } else {
            
            $session->setFlashdata('alert', 'O Processo nº ' . $processo . ' já existe!');
        }

        if ($data['processo_inventario'] != null){

            $crudModelDesaparecidos
                ->whereIn('numero_processo', [$numeroprocesso])
                ->set(['foi_achado' => 1])
                ->update();

            
            $session->setFlashdata('encontrado', 'O Processo nº ' . $processo . ' estava desaparecido. Comunique à coordenação que foi encontrado!');
            $this->sendMail->processo_desaparecido($processo);
        }

        return $this->response->redirect(base_url('/desaparecidos'));
    }
        
    
	}

	function search_single_data()
    {
        $this->util = new Util();
        
        helper(['form', 'url']);
        

        $usuariosModel = new \App\Models\UsuariosModel();

        $usuarioLogadoId = session()->get('usuarioLogado');

        $usuarioInfo = $usuariosModel->find($usuarioLogadoId);

        $session = \Config\Services::session();

        $crudModelDesaparecidos = new crudModelDesaparecidos();

        $numero_processo = $this->util->limpa_numero_processo($this->request->getVar('numero_processo'));

        $foi_achado = $this->request->getVar('foi_achado');

        if($foi_achado === "" && $numero_processo != ""){

            $data['processo'] = $crudModelDesaparecidos->where('numero_processo', $numero_processo)->findAll();

            $data['total_processos_perdidos'] = null;

            $data['total_processos_achados'] = null;

            $data['total_processos_desaparecidos'] = null;

            $data['total_registros'] = $crudModelDesaparecidos->where('numero_processo', $numero_processo)->countAllResults();

        } else {
            
            $data['processo'] = $crudModelDesaparecidos->where('foi_achado', $foi_achado)->orderBy('id', 'DESC')->paginate(10);

            if($foi_achado === "0"){
                $data['total_processos_perdidos'] = $crudModelDesaparecidos->where('foi_achado', 0)->countAllResults();
                $data['total_processos_desaparecidos'] = null;
                $data['total_processos_achados'] = null;
                $data['total_registros'] = null;
            
            }

            if($foi_achado === "1"){
                $data['total_processos_achados'] = $crudModelDesaparecidos->where('foi_achado', 1)->countAllResults();
                $data['total_processos_desaparecidos'] = null;
                $data['total_processos_perdidos'] = null;
                $data['total_registros'] = null;
            }

        }

        if($foi_achado === "" && $numero_processo == ""){


        
        $data = [
            'processo' => $crudModelDesaparecidos->orderBy('id', 'DESC')->paginate(10),
            'total_processos_desaparecidos' => $crudModelDesaparecidos->countAll(),
            'total_processos_perdidos' => null,
            'total_registros' => null,
            'total_processos_achados' => null,
            'pagination_link' => $crudModelDesaparecidos->pager,
            'title' => 'Processos Desaparecidos',
            'main_content' => 'processos_desaparecidos',
            'usuarioInfo' => $usuarioInfo
        ];
		
            echo view('innerpages/template', $data);
        }

        $data['title'] 		= 'Processos Desaparecidos';
		
        $data['main_content']	= 'processos_desaparecidos';

        $data['usuarioInfo'] = $usuarioInfo;

        $data['pagination_link'] = $crudModelDesaparecidos->pager;
        
		
        echo view('innerpages/template', $data);
    

    }

	function delete($id)
    {
        $crudModelDesaparecidos = new CrudModelDesaparecidos();

        $crudModelDesaparecidos->where('id', $id)->delete($id);

        $session = \Config\Services::session();

        $session->setFlashdata('success', 'Processo deletado com sucesso!');

        return $this->response->redirect(base_url('/desaparecidos'));
    }

	function fetch_single_data($id = null)
    {
  

        $crudModelDesaparecidos = new CrudModelDesaparecidos();

        $usuariosModel = new \App\Models\UsuariosModel();

        $usuarioLogadoId = session()->get('usuarioLogado');

        $usuarioInfo = $usuariosModel->find($usuarioLogadoId);

        $data['processo'] = $crudModelDesaparecidos->where('id', $id)->first();

        $data['title'] 		= 'Editar Processo';
		
        $data['main_content']	= 'edit_desaparecido';

        $data['usuarioInfo'] = $usuarioInfo;
        
		
        echo view('innerpages/template', $data);
    }

	function edit_validation()
    {
        $this->sendMail = new SendMail();
        $this->util = new Util();

        $usuariosModel = new \App\Models\UsuariosModel();

        $usuarioLogadoId = session()->get('usuarioLogado');

        $usuarioInfo = $usuariosModel->find($usuarioLogadoId);
        
    	helper(['form', 'url']);

        $session = \Config\Services::session();
        
        $error = $this->validate([
            'numero_processo' 	=> [
                'rules'=>'required',
                'errors'=> [
                    'required' => 'O campo número do processo é obrigatório.'
                ]
                ],
                'foi_achado' 	=> [
                    'rules'=>'required',
                    'errors'=> [
                        'required' => 'O campo número do processo é obrigatório.'
                    ]
                    ]
        ]);

        $crudModelDesaparecidos = new CrudModelDesaparecidos();

        $id = $this->request->getVar('id');

        if(!$error)
        {
        	$data['processo'] = $crudModelDesaparecidos->where('id', $id)->first();
        	
            $data['error'] = $this->validator;

            $data['title'] 		= 'Editar';
		
            $data['main_content']	= 'edit_desaparecido';

            $data['usuarioInfo']	= $usuarioInfo;
		
            echo view('innerpages/template', $data);
        } 
        else 
        {
            $numeroprocesso = $this->util->limpa_numero_processo($this->request->getVar('numero_processo'));
            $processo = $this->request->getVar('numero_processo');
            $foi_achado = $this->request->getVar('foi_achado');

	        $data = [
	            'numero_processo' => $numeroprocesso,
                'numero_processo_alias' => $processo,
                'foi_achado'=>$foi_achado
	        ];
            
        	
            $crudModelDesaparecidos->update($id, $data);

            if($foi_achado == 1){
                
                
                $session->setFlashdata('alert', 'O Processo nº ' . $processo . ' estava desaparecido. Comunique à coordenação que foi encontrado!');
                $this->sendMail->processo_desaparecido($processo);
            }


            $session->setFlashdata('success', 'Processo nº ' . $processo . ' alterado com sucesso!');

        	return $this->response->redirect(base_url('/desaparecidos'));
        }
    }

    function existe_processo($numeroprocesso){
        $crudModelDesaparecidos = new crudModelDesaparecidos();

        $data['processo'] = $crudModelDesaparecidos->where('numero_processo', $numeroprocesso)->findAll();

        if($data['processo'] != null){
            return true;
        } else{
            return false;
        }
}


}

?>