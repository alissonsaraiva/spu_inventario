
        
        <h3 class="text-center mt-4 mb-4">Novo Processo</h3>

        <?php

        $validation = \Config\Services::validation();

        ?>
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col">Cadastrar novo processo</div>
            <div class="col text-right">
                
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="post" action="<?php echo base_url("/crud/add_validation")?>">
            <div class="form-group">
                <label>Nº do processo</label>
                <input type="text" name="numero_processo" class="form-control" placeholder="Digite o número do processo"  value="<?php echo set_value(('numero_processo')) ?>"/>
                <?php
                if($validation->getError('numero_processo'))
                {
                    echo '<div class="alert alert-danger mt-2">'.$validation->getError('numero_processo').'</div>';
                }
                ?>
            </div>

            <div class="form-group">
                <label>Estante</label>
                <input type="text" name="estante" class="form-control" placeholder="Digite o número da estante" value="<?php echo set_value(('estante')) ?>" />
                <?php
                if($validation->getError('estante'))
                {
                    echo "
                    <div class='alert alert-danger mt-2'>
                    ".$validation->getError('estante')."
                    </div>
                    ";
                }
                ?>
            </div>

            <div class="form-group">
                <label>Prateleira</label>
                <input type="text" name="prateleira" class="form-control" placeholder="Digite o número da prateleira" value="<?php echo set_value(('prateleira')) ?>" />
                <?php
                if($validation->getError('prateleira'))
                {
                    echo "
                    <div class='alert alert-danger mt-2'>
                    ".$validation->getError('prateleira')."
                    </div>
                    ";
                }
                ?>
            </div>

            <div class="form-group">
                <label>Caixa</label>
                <input type="text" name="caixa" class="form-control" placeholder="Digite o número da caixa" value="<?php echo set_value(('caixa')) ?>" />
                <?php
                if($validation->getError('caixa'))
                {
                    echo "
                    <div class='alert alert-danger mt-2'>
                    ".$validation->getError('caixa')."
                    </div>
                    ";
                }
                ?>
            </div>

            <div class="form-group">
                <label>COD</label>
                <input type="text" name="cod_inventario" class="form-control" placeholder="Digite número do código inventariante" value="<?php echo set_value(('cod_inventario')) ?>" />
                <?php
                if($validation->getError('cod_inventario'))
                {
                    echo "
                    <div class='alert alert-danger mt-2'>
                    ".$validation->getError('cod_inventario')."
                    </div>
                    ";
                }
                ?>
            </div>

            <div class="form-group">
                        <label>Possui termo de encerramento?</label>
                        <select name="termo_encerramento" class="form-control">
                            <option value="">Selecione</option>
                            <option value="sim" <?= set_select('termo_encerramento', 'sim') ?>>Sim</option>
                            <option value="nao" <?= set_select('termo_encerramento', 'nao') ?>>Não</option>
                        </select>
                <?php
                if($validation->getError('termo_encerramento'))
                {
                    echo "
                    <div class='alert alert-danger mt-2'>
                    ".$validation->getError('termo_encerramento')."
                    </div>
                    ";
                }
                ?>
            </div>

            <div class="form-group">
                <label>Observação</label>
                <textarea class="form-control" name="observacao" rows="3" placeholder="Digite alguma observação" ><?php echo set_value(('observacao')) ?></textarea>
                <?php
                if($validation->getError('observacao'))
                {
                    echo "
                    <div class='alert alert-danger mt-2'>
                    ".$validation->getError('observacao')."
                    </div>
                    ";
                }
                ?>
            </div>

            <div class="form-group">
                <label>Inventariante</label>
                <input type="text" name="inventariante" class="form-control" value="<?php echo $usuarioInfo['nome']; ?>" disabled />
            </div>


            <div class="form-group">
                <button type="submit" class="btn btn-success">Cadastrar</button>
                <input type="button" class="btn btn-primary" onclick="location.href='<?php echo base_url('/crud')?>';" value="Voltar" />
            </div>
        </form>
    </div>

    </div>
