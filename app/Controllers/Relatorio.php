<?php
namespace App\Controllers;

use Mpdf\Mpdf;

use App\Models\CrudModel;
use App\Models\CrudModelDesaparecidos;

class Relatorio extends BaseController
{

    
    public function index()
	{
        
	}

    public function printpdf_processos(){

        $h = "3"; //HORAS DO FUSO ((BRASÍLIA = -3) COLOCA-SE SEM O SINAL -).
        $hm = $h * 60;
        $ms = $hm * 60;
        //COLOCA-SE O SINAL DO FUSO ((BRASÍLIA = -3) SINAL -) ANTES DO ($ms). DATA
        $gmdata = gmdate("d/m/Y", time()-($ms)); 
        //COLOCA-SE O SINAL DO FUSO ((BRASÍLIA = -3) SINAL -) ANTES DO ($ms). HORA
        $gmhora = gmdate("g:i", time()-($ms)); 


        $mpdf = new \Mpdf\Mpdf();
        $crudModel = new CrudModel();

        $processo = $crudModel->orderBy('id', 'ASC')->findAll();
        $total_processos = $crudModel->countAll();
        $data = '';
        foreach($processo as $detalhe){
            $data .= '<tr>'
                  .'<td>'.$detalhe['id'].'</td>'
                  .'<td>'.$detalhe['numero_processo_alias'].'</td>'
                  .'<td>'.$detalhe['estante'].'</td>'
                  .'<td>'.$detalhe['prateleira'].'</td>'
                  .'<td>'.$detalhe['caixa'].'</td>'
                  .'<td>'.$detalhe['cod_inventario'].'</td></tr>';
        }

        $pdfcontent = '
        
        <h3 class="text-center mt-4 mb-4">Relatório de Processos</h3>
        <p>Relatório gerado em: '.$gmdata.' - '.$gmhora.'</p>


            <div class="table-responsive">'.'Total de processos: '.$total_processos.'
                <table class="table table-striped table-bordered">
                    <tr>
                        <th>ID</th>
                        <th>Nº Processo</th>
                        <th>Estante</th>
                        <th>Prateleira</th>
                        <th>Caixa</th>
                        <th>COD</th>
                        
                    </tr>
		'.$data.'
		</table>';
    
        $url = base_url('public/css/style.css');
        $stylesheet = file_get_contents($url);
        $mpdf->WriteHTML($stylesheet, 1); // CSS Script goes here.
        $mpdf->WriteHTML($pdfcontent);
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0; 
        $mpdf->Output('relatorio_processos.pdf', 'D');

    }

    public function printpdf_processos_desaparecidos(){

        $h = "3"; //HORAS DO FUSO ((BRASÍLIA = -3) COLOCA-SE SEM O SINAL -).
        $hm = $h * 60;
        $ms = $hm * 60;
        //COLOCA-SE O SINAL DO FUSO ((BRASÍLIA = -3) SINAL -) ANTES DO ($ms). DATA
        $gmdata = gmdate("d/m/Y", time()-($ms)); 
        //COLOCA-SE O SINAL DO FUSO ((BRASÍLIA = -3) SINAL -) ANTES DO ($ms). HORA
        $gmhora = gmdate("g:i", time()-($ms)); 


        $mpdf = new \Mpdf\Mpdf();
        $crudModel = new CrudModelDesaparecidos();

        $processo = $crudModel->orderBy('id', 'ASC')->findAll();
        $total_processos_desaparecidos = $crudModel->countAll();
        $total_processos_perdidos = $crudModel->where('foi_achado', 0)->countAllResults();
        $total_processos_achados = $crudModel->where('foi_achado', 1)->countAllResults();
        $data = '';
        foreach($processo as $detalhe){
            
            if($detalhe["foi_achado"] == 1){
                $data .= '<tr>'
                  .'<td>'.$detalhe['id'].'</td>'
                  .'<td>'.$detalhe['numero_processo_alias'].'</td>'
                  .'<td>'.'Sim'.'</td>
                  .</tr>';
        } else {
            $data .= '<tr>'
                  .'<td>'.$detalhe['id'].'</td>'
                  .'<td>'.$detalhe['numero_processo_alias'].'</td>'
                  .'<td>'.'Não'.'</td>
                  .</tr>';
        }
            }

            

        $pdfcontent = '
        
        <h3 class="text-center mt-4 mb-4">Relatório de Processos Desaparecidos</h3>
        <br/>
        <br/>
        <p>Relatório gerado em: '.$gmdata.' - '.$gmhora.'</p>

        <div class="table-responsive">'.'Total de processos: '. $total_processos_desaparecidos . " / " . "Total de perdidos: " . $total_processos_perdidos . " / " . "Total de achados: ". $total_processos_achados.'
                <table class="table table-striped table-bordered">
                    <tr>
                        <th>ID</th>
                        <th>Nº Processo</th>
                        <th>Foi achado?</th>
                        
                    </tr>
		'.$data.'
		</table>';

    
        $url = base_url('public/css/style.css');
        $stylesheet = file_get_contents($url);
        $mpdf->WriteHTML($stylesheet, 1); // CSS Script goes here.
        $mpdf->WriteHTML($pdfcontent);
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0; 
        $mpdf->Output('relatorio_processos_desaparecidos.pdf', 'D');

    }

    public function printpdf_processos_achados(){

        $h = "3"; //HORAS DO FUSO ((BRASÍLIA = -3) COLOCA-SE SEM O SINAL -).
        $hm = $h * 60;
        $ms = $hm * 60;
        //COLOCA-SE O SINAL DO FUSO ((BRASÍLIA = -3) SINAL -) ANTES DO ($ms). DATA
        $gmdata = gmdate("d/m/Y", time()-($ms)); 
        //COLOCA-SE O SINAL DO FUSO ((BRASÍLIA = -3) SINAL -) ANTES DO ($ms). HORA
        $gmhora = gmdate("g:i", time()-($ms)); 


        $mpdf = new \Mpdf\Mpdf();
        $crudModel = new CrudModelDesaparecidos();

        $processo = $crudModel->where('foi_achado', 1)->findAll();
        $total_processos_achados = $crudModel->where('foi_achado', 1)->countAllResults();
        $data = '';
        foreach($processo as $detalhe){
            
            if($detalhe["foi_achado"] == 1){
                $data .= '<tr>'
                  .'<td>'.$detalhe['id'].'</td>'
                  .'<td>'.$detalhe['numero_processo_alias'].'</td>'
                  .'<td>'.'Sim'.'</td>
                  .</tr>';
        } else {
            $data .= '<tr>'
                  .'<td>'.$detalhe['id'].'</td>'
                  .'<td>'.$detalhe['numero_processo_alias'].'</td>'
                  .'<td>'.'Não'.'</td>
                  .</tr>';
        }
            }

            

        $pdfcontent = '
        
        <h3 class="text-center mt-4 mb-4">Relatório de Processos Achados</h3>
        <br/>
        <br/>
        <p>Relatório gerado em: '.$gmdata.' - '.$gmhora.'</p>

        <div class="table-responsive">'."Total de achados: ". $total_processos_achados.'
                <table class="table table-striped table-bordered">
                    <tr>
                        <th>ID</th>
                        <th>Nº Processo</th>
                        <th>Foi achado?</th>
                        
                    </tr>
		'.$data.'
		</table>';

    
        $url = base_url('public/css/style.css');
        $stylesheet = file_get_contents($url);
        $mpdf->WriteHTML($stylesheet, 1); // CSS Script goes here.
        $mpdf->WriteHTML($pdfcontent);
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0; 
        $mpdf->Output('relatorio_processos_achados.pdf', 'D');

    }

    public function printpdf_processos_perdidos(){

        $h = "3"; //HORAS DO FUSO ((BRASÍLIA = -3) COLOCA-SE SEM O SINAL -).
        $hm = $h * 60;
        $ms = $hm * 60;
        //COLOCA-SE O SINAL DO FUSO ((BRASÍLIA = -3) SINAL -) ANTES DO ($ms). DATA
        $gmdata = gmdate("d/m/Y", time()-($ms)); 
        //COLOCA-SE O SINAL DO FUSO ((BRASÍLIA = -3) SINAL -) ANTES DO ($ms). HORA
        $gmhora = gmdate("g:i", time()-($ms)); 


        $mpdf = new \Mpdf\Mpdf();
        $crudModel = new CrudModelDesaparecidos();

        $processo = $crudModel->where('foi_achado', 0)->findAll();
        $total_processos_perdidos = $crudModel->where('foi_achado', 0)->countAllResults();
        $data = '';
        foreach($processo as $detalhe){
            
            if($detalhe["foi_achado"] == 1){
                $data .= '<tr>'
                  .'<td>'.$detalhe['id'].'</td>'
                  .'<td>'.$detalhe['numero_processo_alias'].'</td>'
                  .'<td>'.'Sim'.'</td>
                  .</tr>';
        } else {
            $data .= '<tr>'
                  .'<td>'.$detalhe['id'].'</td>'
                  .'<td>'.$detalhe['numero_processo_alias'].'</td>'
                  .'<td>'.'Não'.'</td>
                  .</tr>';
        }
            }

            

        $pdfcontent = '
        
        <h3 class="text-center mt-4 mb-4">Relatório de Processos Perdidos</h3>
        <br/>
        <br/>
        <p>Relatório gerado em: '.$gmdata.' - '.$gmhora.'</p>

        <div class="table-responsive">'."Total de perdidos: " . $total_processos_perdidos.'
                <table class="table table-striped table-bordered">
                    <tr>
                        <th>ID</th>
                        <th>Nº Processo</th>
                        <th>Foi achado?</th>
                        
                    </tr>
		'.$data.'
		</table>';

    
        $url = base_url('public/css/style.css');
        $stylesheet = file_get_contents($url);
        $mpdf->WriteHTML($stylesheet, 1); // CSS Script goes here.
        $mpdf->WriteHTML($pdfcontent);
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0; 
        $mpdf->Output('relatorio_processos_perdidos.pdf', 'D');

    }
}

?>