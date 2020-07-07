<?php

require_once '../logica/Reportes.php';
require_once '../util/funciones/Funciones.php';
require_once '../reportes/Help.php';

$horario_id = $_POST["horario_id"];
$user_name = $_POST["user_name"];

try {
    $obj = new Reportes();

    $result = $obj->misas_por_hora($horario_id);

} catch (Exception $exc) {
    Funciones::mensaje($exc->getMessage(), "e");
}

$htmlDatos = '  
   <table style="font-size:16px;width:100%">
        <head >
            <tr style="text-align: center">
                <th colspan="2"><img src="../imagenes/cruz.png" style="width: 3em" alt=""><h3> ' . $result[0]["capilla_nombre"] . '</h3></th>
                <th></th>
            </tr>
            <tr style="color:#878787">
                <td style="text-align: left;font-style: oblique">Horario: ' . $result[0]['horario'] . '</td>    
                 <td style="text-align: left;font-style: oblique">Usuario : ' . $user_name. '</td>  
            </tr>
              
            <tr style="color:#878787">
                <td style="text-align: left;font-style: oblique">Tipo: ' . $result[0]['tc_nombre']. '</td>   ';

    for($i=0;$i<count($result); $i++){
        if ($result[$i]['tipoculto_type'] == 'Individual'){
            $htmlDatos .= '     <td style="text-align: left;font-style: oblique">Detalle : '  . $result[0]['tipoculto_detalle']. '</td>';
            break;
        }
    }

$htmlDatos .= '    
            </tr>
        </head>
   </table>
   <hr>
       <table style="font-size:16px;width:98%">
           
            <body>
                <tr>
                    <td >
                        <table style="width:100%;  border-collapse: collapse;margin: 15px;padding: 15px;
                        border: 0.2px solid #dcd9de;" class="table table-bordered">
                            <head>
                                <tr style=" border: 0.2px solid #dcd9de;color: #00cc66">
                                    <th>#</th>
                                    <th>Intención</th>         ';
                            for($i=0;$i<count($result); $i++){
                                if ($result[$i]['tipoculto_type'] != 'Individual'){
                                    $htmlDatos .= '     
                                    <th>Detalle</th> ';
                                    break;
                                }
}
                               $htmlDatos .=  ' </tr>                                
                            </head>
                            <body> ';

for ($i = 0; $i < count($result); $i++) {

    $htmlDatos .= '<tr style="color: #3a87ad">';
    $htmlDatos .= '<td style=" border: 0.2px solid #dcd9de;">' . ($i + 1) . '</td>';
    $htmlDatos .= '<td style=" border: 0.2px solid #dcd9de;">' . $result[$i]["dirigido"] . '</td>';
    if ($result[$i]['tipoculto_type'] != 'Individual'){
        $htmlDatos .= '<td style=" border: 0.2px solid #dcd9de;">' . $result[$i]["tipoculto_detalle"] . '</td>';

    }

    $htmlDatos .= '</tr>';
}

$htmlDatos .= '</body>';
$htmlDatos .= '</table>';
$htmlDatos .= '<table style="font-size:16px;width:100%"><body>
<tr><td><span style="color:#878787">Ofrece(n): ' . $result[0]['ofrece'] .'</span></td></tr>
</body>';
$htmlDatos .= '</table>';

//echo $htmlDatos;
$titulo = 'REPORTE ';
$htmlReporte = Help::exportar_pdf(utf8_encode($htmlDatos));
Help::generarReporte($htmlReporte, 2, 'Reporte_celebracion_' .$result[0]['horario_fecha'].'_'.$result[0]['horario_hora'], "vertical");




