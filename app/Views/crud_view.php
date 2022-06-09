
    <h3 class="text-center mt-4 mb-4">Inventário de Processos</h3>
    
  

        <?php

        $session = \Config\Services::session();

        if($session->getFlashdata('success'))
        {
            echo '
            <div class="alert alert-success">'.$session->getFlashdata("success").'</div>
            ';
        }

        if($session->getFlashdata('alert'))
        {
            echo '
            <div class="alert alert-danger">'.$session->getFlashdata("alert").'</div>
            ';
        }

        ?>





<?php

$validation = \Config\Services::validation();

?>

<div class="row" style="margin-bottom: 15px;">

<div class="col-md">
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col">Pesquisar processo</div>
            <div class="col-right">
                        <a href="<?php echo base_url("/crud/add")?>" class="btn btn-success btn-sm">Novo</a>
                    </div>
        </div>
    </div>
    <div class="card-body">
        <form method="post" action="<?php echo base_url("/crud/search_single_data")?>">
            
    
        <div class="container">
            <div class="row">
                <div class="col-sm">
                <div class="form-group">
                        <label>Estante</label>
                        <input type="text" name="estante" class="form-control" placeholder="Digite o número da estante" value="<?php echo set_value(('estante')) ?>"/>
                    </div>    
                <div class="form-group">
                        <label>Prateleira</label>
                        <input type="text" name="prateleira" class="form-control" placeholder="Digite o número da prateleira" value="<?php echo set_value(('prateleira')) ?>"/>
                    </div>
                    <div class="form-group">
                        <label>Caixa</label>
                        <input type="text" name="caixa" class="form-control" placeholder="Digite o número da caixa" value="<?php echo set_value(('caixa')) ?>"/>
                    </div>
                    <div class="form-group">
                <label>Observação</label>
                <input type="text" name="observacao" class="form-control" placeholder="Digite o termo a ser pesquisado" value="<?php echo set_value(('observacao')) ?>"/>
            </div>
            </div>
            <div class="col-sm">
                    <div class="form-group">
                        <label>Nº do Processo</label>
                        <input type="text" name="numero_processo" class="form-control" placeholder="Digite o número do processo" value="<?php echo set_value(('numero_processo')) ?>"/>
                    </div>
                    
                    <div class="form-group">
                        <label>COD</label>
                        <input type="text" name="cod" class="form-control" placeholder="Digite o COD" value="<?php echo set_value(('cod')) ?>"/>
                    </div>

                    <div class="form-group">
                        <label>Local do arquivo</label>
                        <select name="local_arquivo" class="form-control">
                            <option value="">Selecione</option>
                            <option value="terreo" <?= set_select('local_arquivo', 'terreo') ?>>Térreo</option>
                            <option value="9andar" <?= set_select('local_arquivo', '9andar') ?>>9º Andar</option>
                        </select>
            </div>

            <div class="form-group">
                        <label>Possui termo de encerramento?</label>
                        <select name="termo_encerramento" class="form-control">
                            <option value="">Selecione</option>
                            <option value="sim" <?php if($processo['termo_encerramento'] == 'sim') echo 'selected'; ?>>Sim</option>
                            <option value="nao" <?php if($processo['termo_encerramento'] == 'nao') echo 'selected'; ?>>Não</option>
                        </select>
                    </div>
                </div>

        </div>
        <div class="form-group">
                <button type="submit" class="btn btn-primary">Pesquisar</button>
                <a href="<?php echo base_url("/crud")?>" class="btn btn-success">Limpar</a>
            </div>
        </div>
 
            
        </form>
    </div>
</div>
            </div>
            </div>

            


            <?php if(is_null($tipoConsulta)): ?> 

                <!--
                <div class="row">
                <div class="col"></div>
                <div class="col-right">
                <a  href="<?php echo base_url("/relatorio/printpdf_processos")?>" class="btn btn-primary btn-sm">Baixar em PDF</a>
                </div>
                </div>
            -->

                <?php endif ?>
            
            
            
            
               
            
            <div class="table-responsive">
            <?php
            if($total_registros !== null) 
            echo "Total de processos: ". $total_registros;
            ?>
                    <table class="table table-striped table-bordered">
                        <tr>
                            <th>Local</th>
                            <th>Nº Processo</th>
                            <th>Estante</th>
                            <th>Prateleira</th>
                            <th>Caixa</th>
                            <th>Observação</th>
                            <th>Detalhes</th>
                            <th>Editar</th>

                            <?php if($usuarioInfo['admin'] == 1): ?>
                        
                            <th>Deletar</th>

                            <?php endif ?>
                            
                        </tr>
                        <?php

                        $local = "";
                        $observacao = "";

                        if($processo)
                        {
                            foreach($processo as $detalhe)
                            {
                                if ($detalhe["local_arquivo"] == "9andar"){
                                    $local = "9º Andar";
                                } else if ($detalhe["local_arquivo"] == "terreo") {
                                    $local = "Térreo";
                                }

                                if(empty($detalhe["observacao"])){
                                    $observacao = "nenhuma observação cadastrada";
                                } else {
                                    $observacao = $detalhe["observacao"];
                                }   

                                echo '
                                <tr>
                                    <td>'.$local.'</td>
                                    <td>'.$detalhe["numero_processo_alias"].'</td>
                                    <td>'.$detalhe["estante"].'</td>
                                    <td>'.$detalhe["prateleira"].'</td>
                                    <td>'.$detalhe["caixa"].'</td>
                                    <td>'.$observacao.'</td>
                                    <td><a href="'.base_url().'/crud/view_single_data/'.$detalhe["id"].'" class="btn btn-sm btn-info">Detalhes</a></td>
                                    <td><a href="'.base_url().'/crud/fetch_single_data/'.$detalhe["id"].'" class="btn btn-sm btn-warning">Editar</a></td>';

                                if($usuarioInfo['admin'] == 1){
                                    echo '<td><button type="button" onclick="delete_data('.$detalhe["id"].')" class="btn btn-danger btn-sm">Deletar</button></td>
                                </tr>';
                                } else {
                                    echo '</tr>';
                                }
                            }
                        }

                        ?>
                    </table>
                </div>
               
                    <?php

                    if($pagination_link !== null)
                    {
                        $pagination_link->setPath('crud');

                        echo $pagination_link->links();
                    }
                    
                    ?>

               
           
            </div>

    </div>
 
    <script>
function delete_data(id)
{
    if(confirm("Você tem certeza desta ação?"))
    {
        window.location.href="<?php echo base_url(); ?>/crud/delete/"+id;
    }
    return false;
}

</script>