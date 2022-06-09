<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
     content="width=device-width, initial-scale=1, user-scalable=yes">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico"/>
   
    <link href="<?php echo base_url('public/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet" id="bootstrap-css">

    <script src="<?php echo base_url('public/bootstrap/js/bootstrap.min.js') ?>"></script>
    <script src="<?php echo base_url('public/js/jquery-3.6.0.min.js') ?>"></script>
    <script src="<?php echo base_url('public/js/jquery-1.2.6.pack.js') ?>"></script>
    <script src="<?php echo base_url('public/js/jquery.maskedinput-1.1.4.pack.js') ?>"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
    <title><?php echo $title; ?></title>

    <script>

$(document).ready( function(){
  setTimeout(function () {
              $(".alert").fadeOut("fast");
            
       }, 10000);

       $("#cpf").mask("999.999.999-99");
       $("#data_nascimento").mask("99/99/9999");
       $("#telefone").mask("(99) 99999-9999"); 
});
    
    </script>
    

</head>
<body>
        
        
        
        <h3 class="text-center mt-4 mb-4">Cadastro de Servidor</h3>

        <?php

        $validation = \Config\Services::validation();

        ?>

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
<div class="card">

    <div class="card-body">
        <form method="post" enctype="multipart/form-data" action="<?php echo base_url("/servidores/add_validation")?>">
        <div class="container">
            <div class="row">
                <div class="col">
                        <div class="form-group">
                        <label>Nome</label>
                        <input type="text" name="nome" class="form-control" placeholder="Digite o nome completo"  value="<?php echo set_value(('nome')) ?>"/>
                        <?php
                        if($validation->getError('nome'))
                        {
                            echo '<div class="alert alert-danger mt-2">'.$validation->getError('nome').'</div>';
                        }
                        ?>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                            <label>Data de nascimento</label>
                            <input type="text" name="data_nascimento" id = "data_nascimento" class="form-control" placeholder="Digite sua data de nascimento (dd/mm/aaaa)." value="<?php echo set_value(('data_nascimento')) ?>" />
                            <?php
                            if($validation->getError('data_nascimento'))
                            {
                                echo "
                                <div class='alert alert-danger mt-2'>
                                ".$validation->getError('data_nascimento')."
                                </div>
                                ";
                            }
                            ?>
                        </div>
                </div>
                
                


                </div>
            </div>

                    <div class="container">
                        <div class="row">
                            <div class="col"> 
                            <div class="form-group">
                            <label>Siape</label>
                            <input type="text" name="siape" class="form-control" placeholder="Digite o número do seu siape" value="<?php echo set_value(('siape')) ?>" />
                            <?php
                            if($validation->getError('siape'))
                            {
                                echo "
                                <div class='alert alert-danger mt-2'>
                                ".$validation->getError('siape')."
                                </div>
                                ";
                            }
                            ?>
                            </div>

                        </div>

                        <div class="col"> 
                            <div class="form-group">
                            <label>CPF</label>
                            <input id="cpf" type="text" name="cpf" class="form-control" placeholder="Digite o número do seu CPF" value="<?php echo set_value(('cpf')) ?>" />
                            <?php
                            if($validation->getError('cpf'))
                            {
                                echo "
                                <div class='alert alert-danger mt-2'>
                                ".$validation->getError('cpf')."
                                </div>
                                ";
                            }
                            ?>
                            </div>
                    
                        </div>

                    </div>            
                </div>

                <div class="container">
                        <div class="row">
                            <div class="col"> 
                            


                            </div>

                        <div class="col"> 
                            
                        
                    
                        </div>

                    </div>            
                </div>

                <div class="container">
                        <div class="row">
                            <div class="col"> 
                            

                        <div class="form-group">
                        <label>Endereço</label>
                <textarea class="form-control" name="endereco" rows="3" placeholder="Digite o seu endereço" ><?php echo set_value(('endereco')) ?></textarea>
                <?php
                if($validation->getError('endereco'))
                {
                    echo "
                    <div class='alert alert-danger mt-2'>
                    ".$validation->getError('endereco')."
                    </div>
                    ";
                }
                ?>
            </div>


                            </div>

                        <div class="col"> 
                            
                        <div class="form-group">
                <label>Telefone</label>
                <input type="text" name="telefone" id="telefone" class="form-control" placeholder="Digite seu telefone" value="<?php echo set_value(('telefone')) ?>" />
                <?php
                if($validation->getError('telefone'))
                {
                    echo "
                    <div class='alert alert-danger mt-2'>
                    ".$validation->getError('telefone')."
                    </div>
                    ";
                }
                ?>
            </div>
                        
                    
                        </div>

                    </div>            
                </div>

                <div class="container">
                        <div class="row">
                            <div class="col"> 
                            

                            <div class="form-group">
                <label>E-mail institucional</label>
                <input type="text" name="email_institucional" class="form-control" placeholder="Digite seu e-mail institucional" value="<?php echo set_value(('email_institucional')) ?>"  />
                <?php
                if($validation->getError('email_institucional'))
                {
                    echo "
                    <div class='alert alert-danger mt-2'>
                    ".$validation->getError('email_institucional')."
                    </div>
                    ";
                }
                ?>
            </div>


                            </div>

                        <div class="col"> 
                            
                        <div class="form-group">
                <label>E-mail pessoal</label>
                <input type="text" name="email_pessoal" class="form-control" placeholder="Digite seu e-mail pessoal" value="<?php echo set_value(('email_pessoal')) ?>"  />
                <?php
                if($validation->getError('email_pessoal'))
                {
                    echo "
                    <div class='alert alert-danger mt-2'>
                    ".$validation->getError('email_pessoal')."
                    </div>
                    ";
                }
                ?>
            </div>


                    
                        </div>

                    </div>            
                </div>

                <div class="container">
                        <div class="row">
                            <div class="col"> 
                            

                            <div class="form-group">
                <label>Cargo</label>
                <input type="text" name="cargo" class="form-control" placeholder="Digite seu cargo" value="<?php echo set_value(('cargo')) ?>"  />
                <?php
                if($validation->getError('cargo'))
                {
                    echo "
                    <div class='alert alert-danger mt-2'>
                    ".$validation->getError('cargo')."
                    </div>
                    ";
                }
                ?>
            </div>


                            </div>

                        <div class="col"> 
                            
                        <div class="form-group">
                <label>Nível do cargo</label>
                <input type="text" name="nivel_cargo" class="form-control" placeholder="Digite o nível do seu cargo" value="<?php echo set_value(('nivel_cargo')) ?>"  />
                <?php
                if($validation->getError('nivel_cargo'))
                {
                    echo "
                    <div class='alert alert-danger mt-2'>
                    ".$validation->getError('nivel_cargo')."
                    </div>
                    ";
                }
                ?>
            </div>


                    
                        </div>

                    </div>            
                </div>

                <div class="container">
                        <div class="row">
                            <div class="col"> 
                            

                            <div class="form-group">
                <label>Função (opcional)</label>
                <input type="text" name="funcao" class="form-control" placeholder="Digite sua função na SPU (caso tenha)" value="<?php echo set_value(('funcao')) ?>"  />
                <?php
                if($validation->getError('funcao'))
                {
                    echo "
                    <div class='alert alert-danger mt-2'>
                    ".$validation->getError('funcao')."
                    </div>
                    ";
                }
                ?>
            </div>


                            </div>

                        <div class="col"> 
                            
                        <div class="form-group">
                <label>Data de admissão na SPU (opcional)</label>
                <input type="text" name="data_entrada_spu" class="form-control" placeholder="Digite a data de admissão na SPU (dd/mm/aaaa)" value="<?php echo set_value(('data_entrada_spu')) ?>"  />
                <?php
                if($validation->getError('data_entrada_spu'))
                {
                    echo "
                    <div class='alert alert-danger mt-2'>
                    ".$validation->getError('data_entrada_spu')."
                    </div>
                    ";
                }
                ?>
            </div>


                    
                        </div>

                    </div>            
                </div>

                <div class="container">
                        <div class="row">
                            <div class="col"> 
                            

                            <div class="mb-3">
                <label for="formFile" class="form-label">Foto (JPG, PNG ou JPEG)</label>
                <input class="form-control" type="file" id="foto" name="foto">
                <?php
                if($validation->getError('foto'))
                {
                    echo "
                    <div class='alert alert-danger mt-2'>
                    ".$validation->getError('foto')."
                    </div>
                    ";
                }
                ?>
            </div>


                            </div>

                        <div class="col"> </div>

                    </div>            
                </div>



        </div> 
 
            <div class="form-group text-center">
                <button type="submit" class="btn btn-success">Enviar</button>
            </div>
        </form>
    </div>

    </div>

    </body>
<br/>

</html>
<style>
.pagination li a
{
    position: relative;
    display: block;
    padding: .5rem .75rem;
    margin-left: -1px;
    line-height: 1.25;
    color: #007bff;
    background-color: #fff;
    border: 1px solid #dee2e6;
}

.pagination li.active a {
    z-index: 1;
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
}

/* Add a black background color to the top navigation */
.topnav {
  background-color: #e8e8e8;
  overflow: hidden;
}

/* Style the links inside the navigation bar */
.topnav a {
  float: left;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

/* Change the color of links on hover */
.topnav a:hover {
  background-color: #ddd;
  color: black;
}

/* Add a color to the active/current link */
.topnav a.active {
  background-color: #007bff;
  color: white;
}




</style>

