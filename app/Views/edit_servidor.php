
        
        <?php 

        $validation = \Config\Services::validation();


        ?>
        <h3 class="text-center mt-4 mb-4">Editar Servidor</h3>
        




        <div class="card">

        <img src="<?php echo base_url($servidores['foto'])?>" alt="Foto" class="rounded mx-auto d-block" style="width:250px;height:250px; padding-top: 10px">


<div class="card-body">
    <form method="post" enctype="multipart/form-data" action="<?php echo base_url("/servidores/edit_validation")?>">
    <div class="container">
        <div class="row">
            <div class="col">
                    <div class="form-group">
                    <label>Nome</label>
                    <input type="text" name="nome" class="form-control" placeholder="Digite o nome completo"  value="<?php echo $servidores['nome']; ?>" />
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                        <label>Data de nascimento</label>
                        <input type="text" name="data_nascimento" class="form-control" placeholder="Digite sua data de nascimento (dd/mm/aaaa)." value="<?php echo $servidores['data_nascimento']; ?>" />
                    </div>
            </div>
            
            


            </div>
        </div>

                <div class="container">
                    <div class="row">
                        <div class="col"> 
                        <div class="form-group">
                        <label>Siape</label>
                        <input type="text" name="siape" class="form-control" placeholder="Digite o número do seu siape" value="<?php echo $servidores['siape']; ?>"  />
                        </div>

                    </div>

                    <div class="col"> 
                        <div class="form-group">
                        <label>CPF</label>
                        <input type="text" name="cpf" class="form-control" placeholder="Digite o número do seu CPF" value="<?php echo $servidores['cpf']; ?>"  />
                        </div>
                
                    </div>

                </div>            
            </div>


            <div class="container">
                    <div class="row">
                        <div class="col"> 
                        
                        <div class="form-group">
                        <label>Endereço</label>
                        <textarea class="form-control" name="endereco" ><?php echo $servidores['endereco']; ?></textarea>
                    </div>


                        </div>

                    <div class="col"> 
                        
                    <div class="form-group">
            <label>Telefone</label>
            <input type="text" name="telefone" class="form-control" placeholder="Digite seu telefone" value="<?php echo $servidores['telefone']; ?>" />
        </div>
                    
                
                    </div>

                </div>            
            </div>

            <div class="container">
                    <div class="row">
                        <div class="col"> 
                        

                        <div class="form-group">
            <label>E-mail institucional</label>
            <input type="text" name="email_institucional" class="form-control" placeholder="Digite seu e-mail institucional" value="<?php echo $servidores['email_institucional']; ?>"  />
        </div>


                        </div>

                    <div class="col"> 
                        
                    <div class="form-group">
            <label>E-mail pessoal</label>
            <input type="text" name="email_pessoal" class="form-control" placeholder="Digite seu e-mail pessoal" value="<?php echo $servidores['email_pessoal']; ?>"  />
        </div>


                
                    </div>

                </div>            
            </div>

            <div class="container">
                    <div class="row">
                        <div class="col"> 
                        

                        <div class="form-group">
            <label>Cargo</label>
            <input type="text" name="cargo" class="form-control" placeholder="Digite seu cargo" value="<?php echo $servidores['cargo']; ?>"  />
        </div>


                        </div>

                    <div class="col"> 
                        
                    <div class="form-group">
                        <label>Nível do Cargo</label>
                        <input type="text" name="nivel_cargo" class="form-control" value="<?php echo $servidores['nivel_cargo']; ?>" >  
                    </div>


                
                    </div>

                </div>            
            </div>


            <div class="container">
                        <div class="row">
                            <div class="col"> 
                            

                            <div class="form-group">
                <label>Função (opcional)</label>
                <input type="text" name="funcao" class="form-control" placeholder="Digite sua função na SPU (caso tenha)" value="<?php echo $servidores['funcao']; ?>"  />
            </div>


                            </div>

                        <div class="col"> 
                            
                        <div class="form-group">
                <label>Data de admissão na SPU (opcional)</label>
                <input type="text" name="data_entrada_spu" class="form-control" placeholder="Digite a data de admissão na SPU" value="<?php echo $servidores['data_entrada_spu']; ?>"  />
    
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
            </div>


                            </div>

                        <div class="col"> </div>

                    </div>            
                </div>



    </div> 

    <div class="form-group text-center">
                        <input type="hidden" name="id" value="<?php echo $servidores["id"]; ?>" />
                        <button type="submit" class="btn btn-success">Salvar</button>
                        <input type="button" class="btn btn-primary" onclick="location.href='<?php echo base_url('/servidores')?>';" value="Voltar" />
                    </div>
    </form>
</div>

    </div>
 