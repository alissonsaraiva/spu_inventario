<?php

namespace App\Controllers;

use App\Libraries\SendMail;
use App\Libraries\Util;
use App\Models\CrudModel;
use App\Models\CrudModelDesaparecidos;

class Crud extends BaseController
{
    
    protected $sendmail;
    protected $util;


	public function __construct()
    {
        
        helper(['form', 'url']);

    }
    
    public function index()
	{
        $usuariosModel = new \App\Models\UsuariosModel();

        $usuarioLogadoId = session()->get('usuarioLogado');

        $usuarioInfo = $usuariosModel->find($usuarioLogadoId);

		$crudModel = new CrudModel();

        $data = [
            'processo' => $crudModel->orderBy('id', 'DESC')->paginate(10),
            'total_registros' => $crudModel->countAll(),
            'pagination_link' => $crudModel->pager,
            'title' => 'Inventário',
            'main_content' => 'crud_view',
            'tipoConsulta' => null,
            'usuarioInfo' => $usuarioInfo
        ];
		
        echo view('innerpages/template', $data);
    
	}

	function add()
	{
        $usuariosModel = new \App\Models\UsuariosModel();

        $usuarioLogadoId = session()->get('usuarioLogado');

        $usuarioInfo = $usuariosModel->find($usuarioLogadoId);

        $data = [
            'title' => 'Adicionar Processo',
            'main_content' => 'add_data',
            'usuarioInfo' => $usuarioInfo
        ];
		
        echo view('innerpages/template', $data);
	}

    function processos_desaparecidos()
	{

		$CrudModelDesaparecidos = new CrudModelDesaparecidos();

        $data['processo'] = $CrudModelDesaparecidos->orderBy('id', 'DESC')->paginate(10);

        $data['pagination_link'] = $CrudModelDesaparecidos->pager;

        return view('processos_desaparecidos', $data);
	}

	function add_validation()
	{
        $usuariosModel = new \App\Models\UsuariosModel();

        $usuarioLogadoId = session()->get('usuarioLogado');

        $usuarioInfo = $usuariosModel->find($usuarioLogadoId);

		$this->util = new Util();
        
        helper(['form', 'url']);
        $this->sendMail = new SendMail();
        $session = \Config\Services::session();
        $processo = $this->request->getVar('numero_processo');

        
        $error = $this->validate([
            'numero_processo' 	=> [
                'rules'=>'required',
                'errors'=> [
                    'required' => 'O campo número do processo é obrigatório.'
                ]
                ],
                     'cod_inventario' 	=> [
                            'rules'=>'required',
                            'errors'=> [
                                'required' => 'O campo COD é obrigatório.'
                            ]
                            ],
                            'termo_encerramento' 	=> [
                                'rules'=>'required',
                                'errors'=> [
                                    'required' => 'O campo termo de encerramento é obrigatório.'
                                ]
                                ]
        ]);

        

        if(!$error)
        {
        	$data['title'] 		= 'Novo';
		
            $data['main_content']	= 'add_data';

            $data['usuarioInfo']	= $usuarioInfo;
		
            echo view('innerpages/template', $data,  ['error' => $this->validator]);
            
            //echo view('add_data', [
              //  'error' => $this->validator
            //]);
        } 
        else 
        {
           
            $numeroprocesso = $this->util->limpa_numero_processo($this->request->getVar('numero_processo'));
            
            if(!$this->existe_processo($numeroprocesso)){
            $crudModel = new CrudModel();
            
            $inventariante = $this->request->getVar('inventariante');
            
            $crudModel->save([
                'numero_processo' => $numeroprocesso,
                'numero_processo_alias' => $processo,
	            'estante'  => $this->request->getVar('estante'),
	            'prateleira'  => $this->request->getVar('prateleira'),
                'caixa'  => $this->request->getVar('caixa'),
                'cod_inventario'  => $this->request->getVar('cod_inventario'),
                'termo_encerramento'  => $this->request->getVar('termo_encerramento'),
                'observacao'  => $this->request->getVar('observacao'),
                'inventariante'  => $usuarioInfo['nome']

            ]);          
            
            

            
            if ($this->verifica_processo_desaparecido($processo)){

                    $session->setFlashdata('alert', 'O Processo nº ' . $processo . ' estava desaparecido. Comunique à coordenação que foi encontrado!');
                    $this->sendMail->processo_desaparecido($processo, $inventariante);
            }

            $session->setFlashdata('success', 'Processo nº ' . $processo . ' cadastrado com sucesso!');

            return $this->response->redirect(base_url('/crud'));
        } else {
            
        $session->setFlashdata('alert', 'O Processo nº ' . $processo . ' já existe!');
        return $this->response->redirect(base_url('/crud'));
     }

	}
  }


	// show single user
    function fetch_single_data($id = null)
    {
        $crudModel = new CrudModel();

        $usuariosModel = new \App\Models\UsuariosModel();

        $usuarioLogadoId = session()->get('usuarioLogado');

        $usuarioInfo = $usuariosModel->find($usuarioLogadoId);

        $data['processo'] = $crudModel->where('id', $id)->first();

        $data['title'] 		= 'Editar Processo';

        $data['usuarioInfo'] = $usuarioInfo;
		
        $data['main_content']	= 'edit_data';
		
        echo view('innerpages/template', $data);
    }

    function view_single_data($id = null)
    {
        $crudModel = new CrudModel();
        
        $usuariosModel = new \App\Models\UsuariosModel();

        $usuarioLogadoId = session()->get('usuarioLogado');

        $usuarioInfo = $usuariosModel->find($usuarioLogadoId);

        $data['usuarioInfo'] = $usuarioInfo;

        $data['processo'] = $crudModel->where('id', $id)->first();

        $data['title'] 		= 'Ver Processo';
		
        $data['main_content']	= 'view_data';

        

		
        echo view('innerpages/template', $data);
    }

    function search_single_data()
    {
        $db = \Config\Database::connect();
        
        $this->util = new Util();
        
        helper(['form', 'url']);

        $usuariosModel = new \App\Models\UsuariosModel();

        $usuarioLogadoId = session()->get('usuarioLogado');

        $usuarioInfo = $usuariosModel->find($usuarioLogadoId);

        $crudModel = new CrudModel();

        $consulta = "SELECT * FROM processos WHERE ";

        $numero_processo = $this->util->limpa_numero_processo($this->request->getVar('numero_processo'));

        $prateleira = $this->request->getVar('prateleira');

        $estante = $this->request->getVar('estante');

        $caixa = $this->request->getVar('caixa');
        
        $cod = $this->request->getVar('cod');

        if($numero_processo !== ""){
            $consulta = $consulta . "numero_processo = " . $numero_processo;
        }

        if($prateleira !== ""){
            if($numero_processo !== ""){
                $consulta = $consulta . " AND " . "prateleira = " . $prateleira;
            } else {
                $consulta = $consulta .  "prateleira = " . $prateleira;
            }
        }
        

        if($estante !== ""){
            if($numero_processo !== "" || $prateleira !== "" ){
                $consulta = $consulta . " AND " . "estante = " . $estante;
            } else {
                $consulta = $consulta . "estante = " . $estante;
            }
        }
        

        if($caixa !== ""){
            if($numero_processo !== "" || $prateleira !== "" || $estante !== "" ){
                $consulta = $consulta . " AND " . "caixa = " . $caixa;
            } else {
                $consulta = $consulta . "caixa = " . $caixa;
            }
        }
        

        if($cod !== ""){
            if($numero_processo !== "" || $prateleira !== "" || $estante !== "" || $caixa !== "" ){
                $consulta = $consulta . " AND " . "cod_inventario = " . $cod;
            } else {
                $consulta = $consulta . "cod_inventario = " . $cod;
            }
        }

        $consulta = $consulta . ';';

        $query = $db->query($consulta);

        $results = $query->getResultArray();

       


        if($numero_processo !== "" || $prateleira !== "" || $estante !== "" || $caixa !== "" || $cod !== ""){
            $total_registros =  $query->getNumRows();
            $data = [
                'processo' => $results,
                'total_registros' => $total_registros,
                'pagination_link' => null,
                'title' => 'Inventário',
                'main_content' => 'crud_view',
                'tipoConsulta' => null,
                'usuarioInfo' => $usuarioInfo
            ];
            
            echo view('innerpages/template', $data);
        
        } else {


        $data = [
            'processo' => $crudModel->orderBy('id', 'DESC')->paginate(10),
            'total_registros' => $crudModel->countAll(),
            'pagination_link' => $crudModel->pager,
            'title' => 'Inventário',
            'main_content' => 'crud_view',
            'tipoConsulta' => null,
            'usuarioInfo' => $usuarioInfo
        ];
		
        echo view('innerpages/template', $data);
        }


    }

    function edit_validation()
    {
    	$this->util = new Util();
        
        helper(['form', 'url']);
        
        $error = $this->validate([
            'numero_processo' 	=> [
                'rules'=>'required',
                'errors'=> [
                    'required' => 'O campo número do processo é obrigatório.'
                ]
                ],
                        'cod_inventario' 	=> [
                            'rules'=>'required',
                            'errors'=> [
                                'required' => 'O campo COD é obrigatório.'
                            ]
                            ],
                            'termo_encerramento' 	=> [
                                'rules'=>'required',
                                'errors'=> [
                                    'required' => 'O campo termo de encerramento é obrigatório.'
                                ]
                                ]
        ]);

        $crudModel = new CrudModel();

        $id = $this->request->getVar('id');

        if(!$error)
        {
            $usuariosModel = new \App\Models\UsuariosModel();

            $usuarioLogadoId = session()->get('usuarioLogado');

            $usuarioInfo = $usuariosModel->find($usuarioLogadoId);

            $data['usuarioInfo'] = $usuarioInfo;
        	$data['processo'] = $crudModel->where('id', $id)->first();
        	$data['error'] = $this->validator;
            $data['title'] 		= 'Editar';
		
            $data['main_content']	= 'edit_data';
		
            echo view('innerpages/template', $data);
        } 
        else 
        {
            $processo = $this->request->getVar('numero_processo');
            $numeroprocesso = $this->util->limpa_numero_processo($this->request->getVar('numero_processo'));

	        $data = [
	            'numero_processo' => $numeroprocesso,
                'numero_processo_alias' => $processo,
	            'estante'  => $this->request->getVar('estante'),
	            'prateleira'  => $this->request->getVar('prateleira'),
                'caixa'  => $this->request->getVar('caixa'),
                'cod_inventario'  => $this->request->getVar('cod_inventario'),
                'termo_encerramento'  => $this->request->getVar('termo_encerramento'),
                'observacao'  => $this->request->getVar('observacao'),
                'inventariante'  => $this->request->getVar('inventariante')
	        ];
        	
            $crudModel->update($id, $data);

           

        	$session = \Config\Services::session();

            $session->setFlashdata('success', 'Processo nº ' . $processo . ' alterado com sucesso!');

        	return $this->response->redirect(base_url('/crud'));
        }
    }

    function delete($id)
    {
        $crudModel = new CrudModel();

        $processo = $crudModel->where('id', $id)->first();

        $crudModel->where('id', $id)->delete($id);

        $session = \Config\Services::session();

        $session->setFlashdata('success', 'Processo '.$processo['numero_processo_alias']. ' deletado com sucesso!');

        return $this->response->redirect(base_url('/crud'));
    }


    function verifica_processo_desaparecido($processo)
    {
    
    
    $this->util = new Util();

    $numero_processo = $this->util->limpa_numero_processo($processo);

    $db = \Config\Database::connect();
    $builder = $db->table('processos_desaparecidos');
    
    $result = $builder->where('numero_processo', $numero_processo);

    if($result->get()->getResult() != null){
    $processo = $builder->where('numero_processo', $numero_processo)->get()->getFirstRow();

    $id = $processo->id;


    $builder->set('foi_achado', true, false);
    $builder->where('id', $id);
    $builder->update();

    return true;

    } else {
        
        return false;

    }

    
    }


function existe_processo($numeroprocesso){
        $crudModel = new CrudModel();

        $data['processo'] = $crudModel->where('numero_processo', $numeroprocesso)->findAll();

        if($data['processo'] != null){
            return true;
        } else{
            return false;
        }
}

}

?>