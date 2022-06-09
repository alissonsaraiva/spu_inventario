<?php

namespace App\Models;

use CodeIgniter\Model;

class CrudModelDesaparecidos extends Model
{
	protected $table = 'processos_desaparecidos';

	protected $primaryKey = 'id';

	protected $allowedFields = ['numero_processo','numero_processo_alias', 'foi_achado', 'inventariante', 'data_hora'];

}

?>