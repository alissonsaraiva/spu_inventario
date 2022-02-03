



<h3 class="text-center mt-4 mb-4">Gestão de Usuários</h3>

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
        



<div class="row"  style="margin-bottom: 15px;">





<div class="col-md">
<div class="card">
<div class="card-header">
        <div class="row">
            <div class="col">Pesquisar usuário</div>
            
        </div>


    </div>
    






<div class="card-body">
    <form method="post" action="<?php echo base_url("/usuarios/search_single_data")?>">
    <div class="form-group">
            <label>Nome do Usuário</label>
            <input type="text" name="nome" class="form-control" placeholder="Digite o nome do usuário" value="<?php echo set_value(('nome')) ?>" />
        </div>    
    
    <div class="form-group">
            <label>Email do Usuário</label>
            <input type="text" name="email" class="form-control" placeholder="Digite o email do usuário" />
        </div>

        
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Pesquisar</button>
            <a href="<?php echo base_url("/usuarios")?>" class="btn btn-success">Limpar</a>
        </div>
    </form>
</div>
</div>
        </div>
        </div>
      
            <?php 
            
                echo "Total de usuários: ". $total_registros . " / ". " Total de ativos: ". $total_ativos;
            
            ?>

            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <tr>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Data de cadastro</th>
                        <th>Ativar</th>
                        <th>Tornar Admin</th>
                        <th>Habilitar Cons. Serv.</th>
                        <th>Deletar</th>
                    </tr>
                    <?php

                    

                    if($usuarios)
                    {
                        foreach($usuarios as $detalhe)
                        {

                            if($usuarioInfo['email'] != $detalhe["email"]){
                            echo '
                            <tr>
                                <td>'.$detalhe["id"].'</td>
                                <td>'.$detalhe["nome"].'</td>
                                <td>'.$detalhe["email"].'</td>
                                <td>'.date("d/m/Y", strtotime($detalhe["criado_em"])).'</td>';

                                if($detalhe['ativo'] == 0) {
                                    echo '
                                        <td><a href="'.base_url().'/usuarios/ativar_usuario/'.$detalhe["id"].'" class="btn btn-sm btn-success">Ativar</a></td>';
                                   } else {
                                    echo '
                                    <td><a href="'.base_url().'/usuarios/desativar_usuario/'.$detalhe["id"].'" class="btn btn-sm btn-warning">Desativar</a></td>';
                                   }

                               if($detalhe['admin'] == 0) {
                                echo '
                                    <td><a href="'.base_url().'/usuarios/tornar_admin/'.$detalhe["id"].'" class="btn btn-sm btn-success">Tornar Admin</button></td>';
                               } else {
                                echo '
                                <td><a href="'.base_url().'/usuarios/retirar_admin/'.$detalhe["id"].'" class="btn btn-sm btn-warning">Retirar Admin</button></td>';
                               }

                               if($detalhe['consultar_servidores'] == 0) {
                                echo '
                                    <td><a href="'.base_url().'/usuarios/habilitar_consultar_servidores/'.$detalhe["id"].'" class="btn btn-sm btn-success">Habilitar Cons. Serv.</button></td>';
                               } else {
                                echo '
                                <td><a href="'.base_url().'/usuarios/desabilitar_consultar_servidores/'.$detalhe["id"].'" class="btn btn-sm btn-warning">Desabilitar Cons. Serv.</button></td>';
                               }


                            echo '
                               <td><button type="button" onclick="delete_data('.$detalhe["id"].')" class="btn btn-danger btn-sm">Deletar</button></td>
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
                    $pagination_link->setPath('usuarios');

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
        window.location.href="<?php echo base_url(); ?>/usuarios/delete/"+id;
    }
    return false;
}
</script>