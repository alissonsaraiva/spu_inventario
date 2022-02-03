



<h3 class="text-center mt-4 mb-4">Gestão de Produtividade</h3>

<div class="row"  style="margin-bottom: 15px;">





<div class="col-md">
<div class="card">
<div class="card-header">
        <div class="row">
            <div class="col">Pesquisar</div>
            
        </div>


    </div>
    






<div class="card-body">
    <form method="post" action="<?php echo base_url("/produtividade/search")?>">
    <div class="form-group"> <!-- Date input -->
        <label class="control-label" for="date">Data Início (obrigatório)</label>
        <input class="form-control" id="date_inicio" name="date_inicio" placeholder="dd-mm-yyy" type="text" required  />
      </div>
      <div class="form-group"> <!-- Date input -->
        <label class="control-label" for="date">Data Fim</label>
        <input class="form-control" id="date_fim" name="date_fim" placeholder="dd-mm-yyy" type="text"  />
      </div>

        
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Pesquisar</button>
            <a href="<?php echo base_url("/produtividade")?>" class="btn btn-success">Limpar</a>
        </div>
    </form>
</div>
</div>
        </div>
        </div>

            <div class="table-responsive">

            <?php 
                    
                    if($data_pesquisa)
                    {
                        echo '
                        Data da pesquisa: '.$data_pesquisa.'
                        ';
                    }
                    
                    ?>
                    
                <table class="table table-striped table-bordered">
                    
                    <tr>
                        <th>Inventariante</th>
                        <th>Quantidade de Processos</th>
                    </tr>
                    <?php

                    

                    if($produtividade)
                    {
                        foreach($produtividade as $detalhe)
                        {

                         
                            echo '
                            <tr>
                                <td>'.$detalhe["inventariante"].'</td>
                                <td>'.$detalhe["qtd_processos"].'</td>';
                            
                        }
                    }

                    ?>
                </table>
            </div>
            <div>

            </div>

        </div>
    

</div>

<script>
    $(document).ready(function(){
      var date_input_inicio=$('input[name="date_inicio"]'); //our date input has the name "date"
      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
      var options={
        format: 'dd-mm-yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true,
        language: 'pt-br'
      };

    
      var date_input_fim=$('input[name="date_fim"]'); //our date input has the name "date"
      var container_fim=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
      var options_fim={
        format: 'dd-mm-yyyy',
        container_fim: container,
        todayHighlight: true,
        autoclose: true,
        language: 'pt-br'
      };

      $.fn.datepicker.dates['pt-br'] = {
        days: ["Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado"],
        daysShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"],
        daysMin: ["Do", "Se", "Te", "Qu", "Qu", "Se", "Sa"],
        months: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
        monthsShort: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
        today: "Hoje",
        monthsTitle: "Meses",
        clear: "Limpar"
    };

      date_input_inicio.datepicker(options);
  
      date_input_fim.datepicker(options_fim);
    })

    
    
</script>