<?php

namespace App\Controllers;


use App\Models\UsuariosModel;

class Produtividade extends BaseController
{

	public function index()
	{
        $db = \Config\Database::connect();

        $usuariosModel = new UsuariosModel();

        $usuarioLogadoId = session()->get('usuarioLogado');

        $usuarioInfo = $usuariosModel->find($usuarioLogadoId);

        $data_hora_formatada = date("Y-m-d");

        $data_pesquisa = date("d/m/Y");

        $consulta = "SELECT inventariante, COUNT(*) AS 'qtd_processos' FROM processos WHERE cast(data_hora as date) = " ."'".$data_hora_formatada."'"." GROUP BY inventariante;";

        $query   = $db->query($consulta);

        $results = $query->getResultArray();

        $qtd_processos = 0;

        foreach ($results as $valor) {
            $qtd_processos += $valor['qtd_processos'];
        }

        $data = [
            'produtividade' => $results,
            'qtd_processos' => $qtd_processos,
            'consulta' => $consulta,
            'data_pesquisa' => $data_pesquisa,
            'title' => 'Gestão de Produtividade',
            'main_content' => 'gerir_produtividade',
            'usuarioInfo' => $usuarioInfo
        ];
		
        echo view('innerpages/template', $data);

		
		
    
	}

   public function search()
    {
        $db = \Config\Database::connect();
        
        helper(['form', 'url']);

        $usuariosModel = new UsuariosModel();

        $usuarioLogadoId = session()->get('usuarioLogado');

        $usuarioInfo = $usuariosModel->find($usuarioLogadoId);

        $data_hora_inicio = $this->request->getVar('date_inicio');

        $data_hora_fim = $this->request->getVar('date_fim');

        if($data_hora_fim != ""){

        $data_hora_formatada_inicio = date("Y-m-d", strtotime($data_hora_inicio));

        $data_hora_formatada_fim = date("Y-m-d", strtotime($data_hora_fim));

        $data_pesquisa = date("d-m-Y", strtotime($data_hora_inicio)) . " a " . date("d-m-Y", strtotime($data_hora_fim));

        $consulta = "SELECT inventariante, COUNT(*) AS 'qtd_processos' FROM `processos` WHERE cast(data_hora as date) >= " ."'".$data_hora_formatada_inicio."'"." and " ."'".$data_hora_formatada_fim."'"." GROUP BY inventariante;";
        

        } else {

        $data_hora_formatada_inicio = date("Y-m-d", strtotime($data_hora_inicio));

        $data_pesquisa = date("d-m-Y", strtotime($data_hora_inicio));

        $consulta = "SELECT inventariante, COUNT(*) AS 'qtd_processos' FROM processos WHERE cast(data_hora as date) = " ."'".$data_hora_formatada_inicio."'"." GROUP BY inventariante;";
        
        
        }

        $query   = $db->query($consulta);
        
        $results = $query->getResultArray();

        $qtd_processos = 0;

        foreach ($results as $valor) {
            $qtd_processos += $valor['qtd_processos'];
        }


        $data = [
            'produtividade' => $results,
            'qtd_processos' => $qtd_processos,
            'data_pesquisa' => $data_pesquisa,
            'consulta' => $consulta,
            'title' => 'Gestão de Produtividade',
            'main_content' => 'gerir_produtividade',
            'usuarioInfo' => $usuarioInfo
        ];
		
        echo view('innerpages/template', $data);
    

    }

}
