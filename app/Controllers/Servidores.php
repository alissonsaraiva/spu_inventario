<?php

namespace App\Controllers;

use App\Libraries\SendMail;
use App\Libraries\Util;
use App\Models\CrudModel;
use App\Models\ServidoresModel;

class Servidores extends BaseController
{

    public function __construct()
    {
        
        helper(['form', 'url']);

    }
    
    public function index()
	{

        $usuariosModel = new \App\Models\UsuariosModel();

        $usuarioLogadoId = session()->get('usuarioLogado');

        $usuarioInfo = $usuariosModel->find($usuarioLogadoId);

		$servidoresModel = new ServidoresModel();

        $data = [
            'servidores' => $servidoresModel->orderBy('nome', 'ASC')->paginate(10),
            'total_registros' => $servidoresModel->countAll(),
            'pagination_link' => $servidoresModel->pager,
            'title' => 'Servidores',
            'main_content' => 'servidores_view',
            'tipoConsulta' => null,
            'usuarioInfo' => $usuarioInfo
        ];
		
        echo view('innerpages/template', $data);
    }

    function view_single_data($id = null)
    {
        $servidoresModel = new ServidoresModel();
        
        $usuariosModel = new \App\Models\UsuariosModel();

        $usuarioLogadoId = session()->get('usuarioLogado');

        $usuarioInfo = $usuariosModel->find($usuarioLogadoId);

        $data['usuarioInfo'] = $usuarioInfo;

        $data['servidores'] = $servidoresModel->where('id', $id)->first();

        $data['title'] 		= 'Ver Servidor';
		
        $data['main_content']	= 'view_servidor';

        

		
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

        $servidoresModel = new ServidoresModel();

        $consulta = "SELECT * FROM servidores WHERE ";

        $nome = $this->request->getVar('nome');

        $siape = $this->request->getVar('siape');

        $cpf = $this->util->limpa_numero_processo($this->request->getVar('cpf'));

        $email_institucional = $this->request->getVar('email_institucional');

        $email_pessoal = $this->request->getVar('email_pessoal');


        if($nome !== ""){
            $consulta = $consulta . "nome" . " LIKE " . "'" . "%" . $nome . "%" . "'";
        }

        if($siape !== ""){
            if($nome !== ""){
                $consulta = $consulta . " AND " . "siape = " . $siape;
            } else {
                $consulta = $consulta .  "siape = " . $siape;
            }
        }
        

        if($cpf !== ""){
            if($nome !== "" || $siape !== "" ){
                $consulta = $consulta . " AND " . "cpf = " . $cpf;
            } else {
                $consulta = $consulta . "cpf = " . $cpf;
            }
        }
        

        if($email_institucional !== ""){
            if($nome !== "" || $siape !== "" || $cpf !== "" ){
                $consulta = $consulta . " AND " . "email_institucional" . " LIKE " . "'" . "%" . $email_institucional . "%" . "'";
            } else {
                $consulta = $consulta . "email_institucional" . " LIKE " . "'" . "%" . $email_institucional . "%" . "'";
            }
        }
        

        if($email_pessoal !== ""){
            if($nome !== "" || $siape !== "" || $cpf !== "" || $email_institucional !== "" ){
                $consulta = $consulta . " AND " . "email_pessoal" . " LIKE " . "'" . "%" . $email_pessoal . "%" . "'";
            } else {
                $consulta = $consulta . "email_pessoal" . " LIKE " . "'" . "%" . $email_pessoal . "%" . "'";
            }
        }

        $consulta = $consulta . ';';

        $query = $db->query($consulta);

        $results = $query->getResultArray();

       


        if($nome !== "" || $siape !== "" || $cpf !== "" || $email_institucional !== "" || $email_pessoal !== ""){
            $total_registros =  $query->getNumRows();
            $data = [
                'servidores' => $results,
                'total_registros' => $total_registros,
                'pagination_link' => null,
                'title' => 'Inventário',
                'main_content' => 'servidores_view',
                'tipoConsulta' => null,
                'usuarioInfo' => $usuarioInfo
            ];
            
            echo view('innerpages/template', $data);
        
        } else {


        $data = [
            'servidores' => $servidoresModel->orderBy('id', 'DESC')->paginate(10),
            'total_registros' => $servidoresModel->countAll(),
            'pagination_link' => $servidoresModel->pager,
            'title' => 'Inventário',
            'main_content' => 'servidores_view',
            'tipoConsulta' => null,
            'usuarioInfo' => $usuarioInfo
        ];
		
        echo view('innerpages/template', $data);
        }


    }

    function fetch_single_data($id = null)
    {
        $servidoresModel = new ServidoresModel();

        $usuariosModel = new \App\Models\UsuariosModel();

        $usuarioLogadoId = session()->get('usuarioLogado');

        $usuarioInfo = $usuariosModel->find($usuarioLogadoId);

        $data['servidores'] = $servidoresModel->where('id', $id)->first();

        $data['title'] 		= 'Editar Servidor';

        $data['usuarioInfo'] = $usuarioInfo;
		
        $data['main_content']	= 'edit_servidor';
		
        echo view('innerpages/template', $data);
    }

    function edit_validation()
    {
    	$this->util = new Util();
        
        helper(['form', 'url']);
        
        $servidoresModel = new ServidoresModel();

        $id = $this->request->getVar('id');


            $nome = $this->request->getVar('nome');
            $cpf = $this->util->limpa_numero_processo($this->request->getVar('cpf'));

            if(filesize($this->request->getFile('foto'))){
                
                $file = $this->request->getFile('foto');
                $newName = $file->getRandomName();    
                $file->move('./public/uploads/images/users', $newName);

                $data = [
                    'nome' => $nome,
                    'cpf' => $cpf,
                    'siape'  => $this->request->getVar('siape'),
                    'data_nascimento'  => $this->request->getVar('data_nascimento'),
                    'endereco'  => $this->request->getVar('endereco'),
                    'telefone'  => $this->request->getVar('telefone'),
                    'email_institucional'  => $this->request->getVar('email_institucional'),
                    'email_pessoal'  => $this->request->getVar('email_pessoal'),
                    'cargo'  => $this->request->getVar('cargo'),
                    'nivel_cargo'  => $this->request->getVar('nivel_cargo'),
                    'funcao'  => $this->request->getVar('funcao'),
                    'data_entrada_spu'  => $this->request->getVar('data_entrada_spu'),
                    'foto'  => '/public/uploads/images/users/' . $newName
                ];

                $servidoresModel->update($id, $data);

            } else {
                
                $data = [
                    'nome' => $nome,
                    'cpf' => $cpf,
                    'siape'  => $this->request->getVar('siape'),
                    'data_nascimento'  => $this->request->getVar('data_nascimento'),
                    'endereco'  => $this->request->getVar('endereco'),
                    'telefone'  => $this->request->getVar('telefone'),
                    'email_institucional'  => $this->request->getVar('email_institucional'),
                    'email_pessoal'  => $this->request->getVar('email_pessoal'),
                    'cargo'  => $this->request->getVar('cargo'),
                    'nivel_cargo'  => $this->request->getVar('nivel_cargo'),
                    'funcao'  => $this->request->getVar('funcao'),
                    'data_entrada_spu'  => $this->request->getVar('data_entrada_spu')
                ];

                $servidoresModel->update($id, $data);
            }

        	$session = \Config\Services::session();

            $session->setFlashdata('success', 'Servidor(a) ' . $nome . ' alterado com sucesso!');

        	return $this->response->redirect(base_url('/servidores'));
       
    }

    function delete($id)
    {
        $servidoresModel = new ServidoresModel();

        $servidor = $servidoresModel->where('id', $id)->first();

        $servidoresModel->where('id', $id)->delete($id);

        $session = \Config\Services::session();

        $session->setFlashdata('success', 'Servidor(a) '.$servidor['nome']. ' deletado com sucesso!');

        return $this->response->redirect(base_url('/servidores'));
    }


    public function cadastro_servidor()
	{
        $data['title'] 		= 'Cadastro de Servidor';
        echo view('cadastro_servidor.php', $data);
    }

    function add_validation()
	{
        $usuariosModel = new \App\Models\UsuariosModel();

        $usuarioLogadoId = session()->get('usuarioLogado');

        $usuarioInfo = $usuariosModel->find($usuarioLogadoId);

		$this->util = new Util();
        
        helper(['form', 'url']);
        
        $session = \Config\Services::session();
        $nome = $this->request->getVar('nome');

        
        $error = $this->validate([
            'nome' 	=> [
                'rules'=>'required',
                'errors'=> [
                    'required' => 'O campo nome é obrigatório.'
                ]
                ],
                     'data_nascimento' 	=> [
                            'rules'=>'required',
                            'errors'=> [
                                'required' => 'O campo data de nascimento é obrigatório.'
                            ]
                            ],
                            'siape' 	=> [
                                'rules'=>'required',
                                'errors'=> [
                                    'required' => 'O campo siape é obrigatório.'
                                ]
                                ],
                                'cpf' 	=> [
                                    'rules'=>'required',
                                    'errors'=> [
                                        'required' => 'O campo CPF é obrigatório.'
                                    ]
                                    ],
                                    'endereco' 	=> [
                                        'rules'=>'required',
                                        'errors'=> [
                                            'required' => 'O campo endereço é obrigatório.'
                                        ]
                                        ],
                                        'telefone' 	=> [
                                            'rules'=>'required',
                                            'errors'=> [
                                                'required' => 'O campo telefone é obrigatório.'
                                            ]
                                            ],
                                            'email_institucional' 	=> [
                                                'rules'=>'required|valid_email',
                                                'errors'=> [
                                                    'required' => 'O campo e-mail institucional é obrigatório.',
                                                    'valid_email' => 'Digite um formato válido de e-mail'
                                                ]
                                                ],
                                                'email_pessoal' 	=> [
                                                    'rules'=>'required|valid_email',
                                                    'errors'=> [
                                                        'required' => 'O campo e-mail pessoal é obrigatório.',
                                                        'valid_email' => 'Digite um formato válido de e-mail'
                                                    ]
                                                    ],
                                                    'cargo' 	=> [
                                                        'rules'=>'required',
                                                        'errors'=> [
                                                            'required' => 'O campo cargo é obrigatório.'
                                                        ]
                                                        ],
                                                        'nivel_cargo' 	=> [
                                                            'rules'=>'required',
                                                            'errors'=> [
                                                                'required' => 'O campo nível do cargo é obrigatório.'
                                                            ]
                                                            ]
        ]);

        

        if(!$error)
        {
        	$data['title'] 		= 'Cadastro de Servidor';
		
            $data['main_content']	= 'cadastro_servidor';

            $data['usuarioInfo']	= $usuarioInfo;
		
            echo view('cadastro_servidor', $data,  ['error' => $this->validator]);
            
            //echo view('add_data', [
              //  'error' => $this->validator
            //]);
        } 
        else 
        {
           
            $cpf = $this->util->limpa_numero_processo($this->request->getVar('cpf'));
            
            if(!$this->existe_servidor($cpf)){
            $servidoresModel = new ServidoresModel();
            
            $nome = $this->request->getVar('nome');
            $email_institucional = $this->request->getVar('email_institucional');
            $email_pessoal = $this->request->getVar('email_pessoal');
            //$file = $this->request->getFile('foto');
            
            if(filesize($this->request->getFile('foto'))){
                
                $file = $this->request->getFile('foto');
                $newName = $file->getRandomName();    
                $file->move('./public/uploads/images/users', $newName);

            } else {
                $newName = "avatar_padrao.jpg";
            }
            
            
            
            $servidoresModel->save([
                'nome' => $nome,
	            'data_nascimento'  => $this->request->getVar('data_nascimento'),
	            'siape'  => $this->request->getVar('siape'),
                'cpf' => $cpf,
                'endereco'  => $this->request->getVar('endereco'),
                'telefone'  => $this->request->getVar('telefone'),
                'email_institucional'  => $email_institucional,
                'email_pessoal'  => $email_pessoal,
                'cargo'  => $this->request->getVar('cargo'),
                'nivel_cargo'  => $this->request->getVar('nivel_cargo'),
                'funcao'  => $this->request->getVar('funcao'),
                'data_entrada_spu'  => $this->request->getVar('data_entrada_spu'),
                'foto'  => '/public/uploads/images/users/' . $newName

            ]);
            
            $sendMail = new SendMail();
            $sendMail->cadastro_servidor($nome, $email_institucional);
            $sendMail->cadastro_servidor($nome, $email_pessoal);
            

            $session->setFlashdata('success', 'Servidor(a) ' . $nome . ' foi cadastrado com sucesso!');

            return $this->response->redirect(base_url('/servidor'));
        } else {
            
        $session->setFlashdata('alert', 'Servidor(a) ' . $nome . ' já existe!');
        return $this->response->redirect(base_url('/servidor'));
     }

	}
  }

  function add_validation_logado()
	{
        $usuariosModel = new \App\Models\UsuariosModel();

        $usuarioLogadoId = session()->get('usuarioLogado');

        $usuarioInfo = $usuariosModel->find($usuarioLogadoId);

		$this->util = new Util();
        
        helper(['form', 'url']);
        $this->sendMail = new SendMail();
        $session = \Config\Services::session();
        $nome = $this->request->getVar('nome');

        
        $error = $this->validate([
            'nome' 	=> [
                'rules'=>'required',
                'errors'=> [
                    'required' => 'O campo nome é obrigatório.'
                ]
                ],
                     'data_nascimento' 	=> [
                            'rules'=>'required',
                            'errors'=> [
                                'required' => 'O campo data de nascimento é obrigatório.'
                            ]
                            ],
                            'siape' 	=> [
                                'rules'=>'required',
                                'errors'=> [
                                    'required' => 'O campo siape é obrigatório.'
                                ]
                                ],
                                'cpf' 	=> [
                                    'rules'=>'required',
                                    'errors'=> [
                                        'required' => 'O campo CPF é obrigatório.'
                                    ]
                                    ],
                                    'endereco' 	=> [
                                        'rules'=>'required',
                                        'errors'=> [
                                            'required' => 'O campo endereço é obrigatório.'
                                        ]
                                        ],
                                        'telefone' 	=> [
                                            'rules'=>'required',
                                            'errors'=> [
                                                'required' => 'O campo telefone é obrigatório.'
                                            ]
                                            ],
                                            'email_institucional' 	=> [
                                                'rules'=>'required|valid_email',
                                                'errors'=> [
                                                    'required' => 'O campo e-mail institucional é obrigatório.',
                                                    'valid_email' => 'Digite um formato válido de e-mail'
                                                ]
                                                ],
                                                'email_pessoal' 	=> [
                                                    'rules'=>'required|valid_email',
                                                    'errors'=> [
                                                        'required' => 'O campo e-mail pessoal é obrigatório.',
                                                        'valid_email' => 'Digite um formato válido de e-mail'
                                                    ]
                                                    ],
                                                    'cargo' 	=> [
                                                        'rules'=>'required',
                                                        'errors'=> [
                                                            'required' => 'O campo cargo é obrigatório.'
                                                        ]
                                                        ],
                                                        'nivel_cargo' 	=> [
                                                            'rules'=>'required',
                                                            'errors'=> [
                                                                'required' => 'O campo nível do cargo é obrigatório.'
                                                            ]
                                                            ]
        ]);

        

        if(!$error)
        {
        	$data['title'] 		= 'Cadastro de Servidor';
		
            $data['main_content']	= 'cadastro_servidor';

            $data['usuarioInfo']	= $usuarioInfo;
		
            echo view('cadastro_servidor_logado', $data,  ['error' => $this->validator]);
            
            //echo view('add_data', [
              //  'error' => $this->validator
            //]);
        } 
        else 
        {
           
            $cpf = $this->util->limpa_numero_processo($this->request->getVar('cpf'));
            
            if(!$this->existe_servidor($cpf)){
            $servidoresModel = new ServidoresModel();
            
            $nome = $this->request->getVar('nome');
           // $file = $this->request->getFile('foto');
           // $newName = $file->getRandomName();    
           // $file->move('./public/uploads/images/users', $newName);

           
            
            if(filesize($this->request->getFile('foto'))){
                
                $file = $this->request->getFile('foto');
                $newName = $file->getRandomName();    
                $file->move('./public/uploads/images/users', $newName);

            } else {
                $newName = "avatar_padrao.jpg";
            }
            
            $servidoresModel->save([
                'nome' => $nome,
	            'data_nascimento'  => $this->request->getVar('data_nascimento'),
	            'siape'  => $this->request->getVar('siape'),
                'cpf' => $cpf,
                'endereco'  => $this->request->getVar('endereco'),
                'telefone'  => $this->request->getVar('telefone'),
                'email_institucional'  => $this->request->getVar('email_institucional'),
                'email_pessoal'  => $this->request->getVar('email_pessoal'),
                'cargo'  => $this->request->getVar('cargo'),
                'nivel_cargo'  => $this->request->getVar('nivel_cargo'),
                'funcao'  => $this->request->getVar('funcao'),
                'data_entrada_spu'  => $this->request->getVar('data_entrada_spu'),
                'foto'  => '/public/uploads/images/users/' . $newName

            ]);          
            

            $session->setFlashdata('success', 'Servidor(a) ' . $nome . ' foi cadastrado com sucesso!');

            return $this->response->redirect(base_url('/servidores'));
        } else {
            
        $session->setFlashdata('alert', 'Servidor(a) ' . $nome . ' já existe!');
        return $this->response->redirect(base_url('/servidores'));
     }

	}
  }


  function existe_servidor($cpf){
    $servidoresModel = new ServidoresModel();

    $data['servidor'] = $servidoresModel->where('cpf', $cpf)->findAll();

    if($data['servidor'] != null){
        return true;
    } else{
        return false;
    }
}


function adicionar()
{
    $usuariosModel = new \App\Models\UsuariosModel();

    $usuarioLogadoId = session()->get('usuarioLogado');

    $usuarioInfo = $usuariosModel->find($usuarioLogadoId);

    $data = [
        'title' => 'Cadastro de Servidor',
        'main_content' => 'cadastro_servidor_logado',
        'usuarioInfo' => $usuarioInfo
    ];
    
    echo view('innerpages/template', $data);
}




}