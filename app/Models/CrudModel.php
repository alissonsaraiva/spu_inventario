<?php

namespace App\Models;

use CodeIgniter\Model;

class CrudModel extends Model
{
	protected $table = 'processos';

	protected $primaryKey = 'id';

	protected $allowedFields = ['local_arquivo','numero_processo', 'numero_processo_alias', 'estante', 'prateleira', 'caixa', 'cod_inventario', 'termo_encerramento', 'observacao', 'inventariante'];

}

?>