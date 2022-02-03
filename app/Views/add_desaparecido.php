
        
        <h3 class="text-center mt-4 mb-4">Novo Processo</h3>

        <?php

        $validation = \Config\Services::validation();

        ?>
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col">Cadastrar novo processo desaparecido</div>
            <div class="col text-right">
                
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="post" action="<?php echo base_url("/desaparecidos/add_processo_desaparecido")?>">
            <div class="form-group">
                <label>Nº do processo</label>
                <input type="text" name="numero_processo" class="form-control" placeholder="Digite o número do processo" />
                <?php
                if($validation->getError('numero_processo'))
                {
                    echo '<div class="alert alert-danger mt-2">'.$validation->getError('numero_processo').'</div>';
                }
                ?>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success">Cadastrar</button>
                <input type="button" class="btn btn-primary" onclick="location.href='<?php echo base_url('/desaparecidos')?>';" value="Voltar" />
            </div>
        </form>
    </div>

    </div>
 