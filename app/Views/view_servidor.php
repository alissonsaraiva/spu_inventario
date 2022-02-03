
    <div class="container">
        
        <?php 

        $validation = \Config\Services::validation();


        ?>
        <h3 class="text-center mt-4 mb-4">Detalhes do Servidor</h3>



<div class="card">


<img src="<?php echo base_url($servidores['foto'])?>" alt="Foto" class="rounded mx-auto d-block" style="width:250px;height:250px; padding-top: 10px">


<div class="card-body">
    
    
   
    
    
    <div class="container">
        <div class="row">
            <div class="col">
                    <div class="form-group">
                    <label>Nome</label>
                    <input type="text" name="nome" class="form-control"  value="<?php echo $servidores['nome'] ?>" disabled/>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                        <label>Data de nascimento</label>
                        <input type="text" name="data_nascimento" class="form-control"  value="<?php echo $servidores['data_nascimento'] ?>" disabled/>
                    </div>
            </div>
            
            


            </div>
        </div>

                <div class="container">
                    <div class="row">
                        <div class="col"> 
                        <div class="form-group">
                        <label>Siape</label>
                        <input type="text" name="siape" class="form-control"  value="<?php echo $servidores['siape'] ?>" disabled />
                        </div>

                    </div>

                    <div class="col"> 
                        <div class="form-group">
                        <label>CPF</label>
                        <input type="text" name="cpf" class="form-control"  value="<?php echo $servidores['cpf'] ?>" disabled />
                        </div>
                
                    </div>

                </div>            
            </div>


            <div class="container">
                    <div class="row">
                        <div class="col"> 
                        
                        <div class="form-group">
                        <label>Endereço</label>
                        <textarea class="form-control" name="endereco" disabled><?php echo $servidores['endereco'];?></textarea>
                    </div>


                        </div>

                    <div class="col"> 
                        
                    <div class="form-group">
            <label>Telefone</label>
            <input type="text" name="telefone" class="form-control"  value="<?php echo $servidores['telefone'] ?>" disabled/>
        </div>
                    
                
                    </div>

                </div>            
            </div>

            <div class="container">
                    <div class="row">
                        <div class="col"> 
                        

                        <div class="form-group">
            <label>E-mail institucional</label>
            <input type="text" name="email_institucional" class="form-control"  value="<?php echo $servidores['email_institucional'] ?>"  disabled/>
        </div>


                        </div>

                    <div class="col"> 
                        
                    <div class="form-group">
            <label>E-mail pessoal</label>
            <input type="text" name="email_pessoal" class="form-control"  value="<?php echo $servidores['email_pessoal'] ?>" disabled />
        </div>


                
                    </div>

                </div>            
            </div>

            <div class="container">
                    <div class="row">
                        <div class="col"> 
                        

                        <div class="form-group">
            <label>Cargo</label>
            <input type="text" name="cargo" class="form-control"  value="<?php echo $servidores['cargo'] ?>"  disabled/>
        </div>


                        </div>

                    <div class="col"> 
                        
                    <div class="form-group">
            <label>Nível do cargo</label>
            <input type="text" name="nivel_cargo" class="form-control"  value="<?php echo $servidores['nivel_cargo'] ?>"  disabled/>
        </div>


                
                    </div>

                </div>            
            </div>

            <div class="container">
                    <div class="row">
                        <div class="col"> 
                        

                        <div class="form-group">
            <label>Função</label>
            <input type="text" name="funcao" class="form-control"  value="<?php echo $servidores['funcao'] ?>"  disabled/>
        </div>


                        </div>

                    <div class="col"> 
                        
                    <div class="form-group">
            <label>Data de admissão na SPU</label>
            <input type="text" name="data_entrada_spu" class="form-control"  value="<?php echo $servidores['data_entrada_spu'] ?>"  disabled/>
        </div>


                
                    </div>

                </div>            
            </div>



    </div> 

    <div class="form-group text-center">
                        <input type="hidden" name="id" value="<?php echo $servidores["id"]; ?>" />
                        <input type="button" class="btn btn-primary" onclick="location.href='<?php echo base_url('/servidores')?>';" value="Voltar" />
                    </div>

</div>








    </div>

