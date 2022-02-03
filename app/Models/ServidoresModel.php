<?php

namespace App\Models;

use CodeIgniter\Model;

class ServidoresModel extends Model
{
	protected $table = 'servidores';

	protected $primaryKey = 'id';

	protected $allowedFields = ['nome', 'data_nascimento', 'siape', 'cpf', 'endereco', 'telefone', 'email_institucional', 'email_pessoal', 'cargo', 'nivel_cargo', 'foto','funcao','data_entrada_spu', 'data_criacao'];

}

?>