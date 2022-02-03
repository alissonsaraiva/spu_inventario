
    <div class="container">
        
        <?php 

        $validation = \Config\Services::validation();


        ?>
        <h3 class="text-center mt-4 mb-4">Detalhes do Processo</h3>
        
        <div class="card">
            <div class="card-header">Detalhes</div>
            <div class="card-body">

                <form method="post" action="<?php echo base_url('crud/edit_validation'); ?>">
                    
                
                <div class="form-group">
                        <label>Número do processo</label>
                        <input type="text" name="numero_processo" class="form-control" value="<?php echo $processo['numero_processo_alias']; ?>" disabled>

                        <!-- Error -->
                        <?php 
                        if($validation->getError('numero_processo'))
                        {
                            echo "
                            <div class='alert alert-danger mt-2'>
                            ".$validation->getError('numero_processo')."
                            </div>
                            ";
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label>Estante</label>
                        <input type="text" name="estante" class="form-control" value="<?php echo $processo['estante']; ?>" disabled>

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
                        <input type="text" name="prateleira" class="form-control" value="<?php echo $processo['prateleira']; ?>" disabled>

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
                        <input type="text" name="caixa" class="form-control" value="<?php echo $processo['caixa']; ?>" disabled>

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
                        <input type="text" name="cod" class="form-control" value="<?php echo $processo['cod_inventario']; ?>" disabled>

                        <?php 
                        if($validation->getError('cod'))
                        {
                            echo "
                            <div class='alert alert-danger mt-2'>
                            ".$validation->getError('cod')."
                            </div>
                            ";
                        }
                        ?>
                    </div>

                

                    <div class="form-group">
                        <label>Termo de encerramento</label>
                        <select name="termo_encerramento" class="form-control" disabled>
                            <option value="">Selecione</option>
                            <option value="sim" <?php if($processo['termo_encerramento'] == 'sim') echo 'selected'; ?>>Sim</option>
                            <option value="nao" <?php if($processo['termo_encerramento'] == 'nao') echo 'selected'; ?>>Não</option>
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
                        <textarea class="form-control" name="observacao" disabled><?php echo $processo['observacao']; ?></textarea>

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
                        <input type="text" name="inventariante" class="form-control" value="<?php echo $processo['inventariante']; ?>" disabled>

                        <?php 
                        if($validation->getError('inventariante'))
                        {
                            echo "
                            <div class='alert alert-danger mt-2'>
                            ".$validation->getError('inventariante')."
                            </div>
                            ";
                        }
                        ?>
                    </div>

                    <div class="form-group">
                        <label>Data de digitação</label>
                        <input type="text" name="data_hora" class="form-control" value="<?php echo date("d/m/Y", strtotime($processo['data_hora'])); ?>" disabled>
                    </div>


                    <div class="form-group">
                        <input type="hidden" name="id" value="<?php echo $processo["id"]; ?>" />
                        <input type="button" class="btn btn-primary" onclick="location.href='<?php echo base_url('/crud')?>';" value="Voltar" />
                    </div>
                </form>
            </div>
        </div>

    </div>

