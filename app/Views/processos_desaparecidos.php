

    <h3 class="text-center mt-4 mb-4">Processos desaparecidos</h3>
    
  

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

        if($session->getFlashdata('encontrado'))
        {
            echo '
            <div class="alert alert-danger">'.$session->getFlashdata("encontrado").'</div>
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
            <a href="<?php echo base_url("/desaparecidos/add")?>" class="btn btn-success btn-sm">Novo</a>
                    </div>
        </div>


    </div>
    

    
    <div class="card-body">
        <form method="post" action="<?php echo base_url("/desaparecidos/search_single_data")?>">
            <div class="form-group">
                <label>Nº do Processo</label>
                <input type="text" name="numero_processo" class="form-control" placeholder="Digite o número do processo desaparecido"  />
            </div>
            <div class="form-group">
                        <label>Foi achado?</label>
                        <select name="foi_achado" class="form-control">
                        <option value="">Selecione</option>
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                    </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Pesquisar</button>
                <a href="<?php echo base_url("/desaparecidos")?>" class="btn btn-success">Limpar</a>
            </div>
        </form>
    </div>
</div>
            </div>
            </div>
        





            <?php if(!is_null($total_processos_perdidos)): ?>

            <div class="row">
            <div class="col"></div>
            <div class="col-right">
            <a  href="<?php echo base_url("/relatorio/printpdf_processos_perdidos")?>" class="btn btn-primary btn-sm">Baixar em PDF</a>
            </div>
            </div>

            <?php endif ?>

            <?php if(!is_null($total_processos_achados)): ?>

            <div class="row">
            <div class="col"></div>
            <div class="col-right">
            <a  href="<?php echo base_url("/relatorio/printpdf_processos_achados")?>" class="btn btn-primary btn-sm">Baixar em PDF</a>
            </div>
            </div>

            <?php endif ?>

            <?php if(is_null($total_processos_perdidos) && is_null($total_processos_achados) && is_null($total_registros) && !is_null($total_processos_desaparecidos)): ?>

            <div class="row">
            <div class="col"></div>
            <div class="col-right">
            <a  href="<?php echo base_url("/relatorio/printpdf_processos_desaparecidos")?>" class="btn btn-primary btn-sm">Baixar em PDF</a>
            </div>
            </div>

            <?php endif ?>
            

            
                <div class="table-responsive">
                <?php 


            if(!is_null($total_processos_achados)){
                echo "Total de processos achados: ". $total_processos_achados;
            }

            if(!is_null($total_processos_perdidos)){
                echo "Total de processos perdidos: ". $total_processos_perdidos;
            }

            if(!is_null($total_registros)){
                echo "Total de processos: ". $total_registros;
            }

            if(!is_null($total_processos_desaparecidos)){
                echo "Total de processos: ". $total_processos_desaparecidos;
            }


            ?>
                    <table class="table table-striped table-bordered">
                        <tr>
                            <th>Nº Processo</th>
                            <th>Foi achado?</th>
                            <th>Inventariante</th>
                            <th>Data</th>
                            <th>Editar</th>
                            <th>Deletar</th>
                        </tr>
                        <?php

                        if($processo)
                        {
                            foreach($processo as $detalhe)
                            {
                             //   echo '
                             //   <tr>
                            //        <td>'.$detalhe["numero_processo_alias"].'</td>';
                                    
                                    

                                if($detalhe["foi_achado"] == 0){
                                    echo '
                                    <tr>
                                    <td>'.$detalhe["numero_processo_alias"].'</td>

                                    <td>'."Não".'</td>
                                    <td>'."".'</td>
                                    <td>'."".'</td>
                                    <td><a href="'.base_url().'/desaparecidos/fetch_single_data/'.$detalhe["id"].'" class="btn btn-sm btn-warning">Editar</a></td>
                                    <td><button type="button" onclick="delete_data('.$detalhe["id"].')" class="btn btn-danger btn-sm">Deletar</button></td>
                                    </tr>
                                    </tr>';
                                }

                                if($detalhe["foi_achado"] == 1){
                                    echo '
                                    <tr>
                                    <td><a href="'.base_url().'/desaparecidos/ver_processo/'.$detalhe["numero_processo"].'">'.$detalhe["numero_processo_alias"].'</a></td>

                                    <td>'."Sim".'</td>
                                    <td>'.$detalhe["inventariante"].'</td>
                                    <td>'.date("d/m/Y", strtotime($detalhe["data_hora"])).'</td>
                                    <td><a href="'.base_url().'/desaparecidos/fetch_single_data/'.$detalhe["id"].'" class="btn btn-sm btn-warning">Editar</a></td>
                                    <td><button type="button" onclick="delete_data('.$detalhe["id"].')" class="btn btn-danger btn-sm">Deletar</button></td>
                                    </tr>
                                    </tr>';
                                }
                            }
                        }

                        ?>
                    </table>
                </div>
                <div>
                    <?php

                    if($pagination_link)
                    {
                        $pagination_link->setPath('desaparecidos');

                        echo $pagination_link->links();
                    }
                    
                    ?>

                </div>
         
            </div>
        

    </div>
 


<script>
function delete_data(id)
{
    if(confirm("Você tem certeza desta ação?"))
    {
        window.location.href="<?php echo base_url(); ?>/desaparecidos/delete/"+id;
    }
    return false;
}
</script>