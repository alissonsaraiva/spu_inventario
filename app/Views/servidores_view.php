
    <h3 class="text-center mt-4 mb-4">Gestão de Servidores</h3>
    
  

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
        <div class="col">Pesquisar servidor</div>
        
            <div class="col-right">
                            <a href="<?php echo base_url("/servidores/adicionar")?>" class="btn btn-success btn-sm">Novo</a>
                        </div>
       
    </div>
</div>
<div class="card-body">
    <form method="post" action="<?php echo base_url("/servidores/search_single_data")?>">
        

    <div class="container">
        <div class="row">
            <div class="col-sm">
            <div class="form-group">
                    <label>Nome</label>
                    <input type="text" name="nome" class="form-control" placeholder="Digite o nome do servidor" value="<?php echo set_value(('nome')) ?>"/>
                </div>    
            <div class="form-group">
                    <label>Siape</label>
                    <input type="text" name="siape" class="form-control" placeholder="Digite o siape" value="<?php echo set_value(('siape')) ?>"/>
                </div>
                <div class="form-group">
                    <label>CPF</label>
                    <input type="text" name="cpf" class="form-control" placeholder="Digite o cpf do servidor" value="<?php echo set_value(('cpf')) ?>"/>
                </div>
        </div>
        <div class="col-sm">
                <div class="form-group">
                    <label>E-mail institucional</label>
                    <input type="text" name="email_institucional" class="form-control" placeholder="Digite o e-mail institucional do servidor" value="<?php echo set_value(('email_institucional')) ?>"/>
                </div>
                
                <div class="form-group">
                    <label>E-mail pessoal</label>
                    <input type="text" name="email_pessoal" class="form-control" placeholder="Digite o e-mail pessoal do servidor" value="<?php echo set_value(('email_pessoal')) ?>"/>
                </div>
               
                
            </div>
    </div>
    <div class="form-group">
            <button type="submit" class="btn btn-primary">Pesquisar</button>
    
    
            <a href="<?php echo base_url("/servidores")?>" class="btn btn-success">Limpar</a>
    </div>
    </div>

        
    </form>
</div>
</div>
        </div>
        </div>
        
        
        
        
           
        
        <div class="table-responsive">
        <?php
        if($total_registros !== null) 
        echo "Total de servidores: ". $total_registros;
        ?>
                <table class="table table-striped table-bordered">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Siape</th>
                        <th>CPF</th>
                        <th>Telefone</th>
                        <th>E-mail Inst</th>
                        <th>Detalhes</th>

                        <?php if($usuarioInfo['admin'] == 1): ?>

                        <th>Editar</th>
                        <th>Deletar</th>

                        <?php endif ?>
                        
                    </tr>
                    <?php

                    if($servidores)
                    {
                        foreach($servidores as $detalhe)
                        {
                            echo '
                            <tr>
                                <td>'.$detalhe["id"].'</td>
                                <td>'.$detalhe["nome"].'</td>
                                <td>'.$detalhe["siape"].'</td>
                                <td>'.$detalhe["cpf"].'</td>
                                <td>'.$detalhe["telefone"].'</td>
                                <td>'.$detalhe["email_institucional"].'</td>
                                <td><a href="'.base_url().'/servidores/view_single_data/'.$detalhe["id"].'" class="btn btn-sm btn-info">Detalhes</a></td>';
                                

                            if($usuarioInfo['admin'] == 1){
                                echo '<td><a href="'.base_url().'/servidores/fetch_single_data/'.$detalhe["id"].'" class="btn btn-sm btn-warning">Editar</a></td>
                                <td><button type="button" onclick="delete_data('.$detalhe["id"].')" class="btn btn-danger btn-sm">Deletar</button></td>
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
    window.location.href="<?php echo base_url(); ?>/servidores/delete/"+id;
}
return false;
}

</script>