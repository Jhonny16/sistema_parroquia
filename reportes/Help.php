<?php

/**
 * Created by PhpStorm.
 * User: tito_
 * Date: 16/10/2018
 * Time: 11:44 PM
 */
date_default_timezone_set("America/Lima");

class Help
{
    public static $DIRECTORIO_PRINCIPAL = "SISTEMAPARROQUIAL";

    public static function export_pdf($htmlDatos, $usuario, $titulo, $capilla)
    {

        $html = '';
        $html .= '<!DOCTYPE html>
                    <html>
                        <head lang="es">
                            <meta charset="utf-8">                             
                            <meta http-equiv="X-UA-Compatible" content="IE=edge">   
                            <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">                                                                                                                                                                      
                        </head>
                        <body>
                                <table style="width: 100%">
                                    <head>
                                        <tr>
                                            <th><img src="../imagenes/cruz.png" style="width:2em"></th>
                                            <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ' . $titulo . '</th>
                                        </tr>
                                    </head>
                                </table> 
                                <hr style="color: #0056b2;" />
                                    <table style="width: 100%">
                                        <body>
                                        <tr>
                                        <td>Capilla: </td><td>' . $capilla . '</td>
                                        </tr>
                                        <tr>
                                        <td>Fecha: </td><td>Chiclayo,&nbsp;' . date("d") . ' de ' . date(" M ") . '  del ' . date(" Y ") . '</td>
                                        </tr>
                                        <tr>
                                        <td>Hora: </td><td>' . date('H:i:s') . '</td>
                                        </tr>
                                          <tr>
                                        <td>Usuario : </td><td>' . $usuario . '</td>
                                        </tr>
                                        </body>
                                    </table>
                                <br><br>                        
                        ';
                $html .= $htmlDatos;
                $html .= '</body>';
                $html .= '</html>';

        return $html;
    }


    public static function exportar_pdf($htmlDatos)
    {

        $html = '';
        $html .= '<!DOCTYPE>
                    <html>
                    <head lang="es">
                        <meta charset="utf-8">                             
                        <meta http-equiv="X-UA-Compatible" content="IE=edge">   
                        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">       
                    </head>
                    <body style="margin-top: 0.3em;
            margin-left: 0.6em;">
                  ';
        $html .= $htmlDatos;
        $html .= '</body>';
        $html .= '</html>';

        return $html;
    }

    public static function generarReporte($html_reporte, $tipo_reporte, $nombre_archivo,$horientacion)
    {
        if ($tipo_reporte == 1) {
            //Genera el reporte en HTML
            echo $html_reporte;
        } else if ($tipo_reporte == 2) {
            //Genera el reporte en PDF
            $archivo_pdf = "../reportes/" . $nombre_archivo . ".pdf";
            Help::generaPDF($archivo_pdf, $html_reporte, $horientacion);
            header('Content-type: text/html; charset=UTF-8');
//            header('Content-Type: application/pdf; charset=utf-8');
            header("location:" . $archivo_pdf);
        } else {
            //Genera el reporte en Excel
            header("Content-type: application/vnd.ms-excel; name='excel'");
            header("Content-Disposition: filename=" . $nombre_archivo . ".xls");
            header("Pragma: no-cache");
            header("Expires: 0");

            echo $html_reporte;
        }
    }


    public static function cargarArchivo($nombreArchivo, $ruta)
    {
        try {
            if ($nombreArchivo != "") {
                move_uploaded_file($nombreArchivo, $ruta);
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function eliminarArchivo($nombreArchivo)
    {
        try {
            if (file_exists($nombreArchivo)) {
                unlink($nombreArchivo);
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function generaPDF($file = '', $html = '', $horientacion,$paper = 'a4', $download = true)
    {
        require_once '../dompdf/autoload.inc.php';
        require_once '../dompdf/lib/html5lib/Parser.php';
        require_once '../dompdf/lib/php-font-lib/src/FontLib/Autoloader.php';
        require_once '../dompdf/lib/php-svg-lib/src/autoload.php';
        require_once '../dompdf/src/Autoloader.php';
        Dompdf\Autoloader::register();


        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml(utf8_decode($html));
        $dompdf->set_option('isHtml5ParserEnabled', true);
// (Optional) Setup the paper size and orientation

        if($horientacion == 'vertical'){
            $dompdf->setPaper('A4', 'portrait');

        }else{
            $dompdf->setPaper('A4', 'landscape');

        }

// Render the HTML as PDF
        $dompdf->render();

// Output the generated PDF to Browser
        $dompdf->stream($file);
    }




}