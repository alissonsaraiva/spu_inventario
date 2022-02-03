
        
        <?php 

        $validation = \Config\Services::validation();


        ?>
        <h3 class="text-center mt-4 mb-4">Editar Processo Desaparecido</h3>
        
        <div class="card">
            <div class="card-header">Editar Processo</div>
            <div class="card-body">
                <form method="post" action="<?php echo base_url('desaparecidos/edit_validation'); ?>">
                    
                
                <div class="form-group">
                        <label>Número do processo</label>
                        <input type="text" name="numero_processo" class="form-control" value="<?php echo $processo['numero_processo_alias']; ?>">

                        
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
                        <label>Foi achado?</label>
                        <select name="foi_achado" class="form-control">
                            <option value="">Selecione</option>
                            <option value="1" <?php if($processo['foi_achado'] == 1) echo 'selected'; ?>>Sim</option>
                            <option value="0" <?php if($processo['foi_achado'] == 0) echo 'selected'; ?>>Não</option>
                        </select>

                        <?php 
                        if($validation->getError('foi_achado'))
                        {
                            echo "
                            <div class='alert alert-danger mt-2'>
                            ".$validation->getError('foi_achado')."
                            </div>
                            ";
                        }
                        ?>
                    </div>
                    
                    
                    <div class="form-group">
                        <input type="hidden" name="id" value="<?php echo $processo["id"]; ?>" />
                        <button type="submit" class="btn btn-success">Salvar</button>
                        <input type="button" class="btn btn-primary" onclick="location.href='<?php echo base_url('/desaparecidos')?>';" value="Voltar" />
                    </div>
                </form>
            </div>
        </div>

    </div>
 
