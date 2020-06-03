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
        $html .= '<!DOCTYPE html>
                    <html>
                        <head lang="es">
                            <meta charset="utf-8">                             
                            <meta http-equiv="X-UA-Compatible" content="IE=edge">   
                            <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">       
                            <link rel="shortcut icon" type="image/x-icon" href="../imagenes/cruz.png" />   
                            <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
                            <link rel="stylesheet" href="../util/lte/bower_components/bootstrap/dist/css/bootstrap.min.css">
                            <link rel="stylesheet" href="../util/lte/bower_components/bootstrap-daterangepicker/daterangepicker.css">
                            <link rel="stylesheet" href="../util/lte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
                            <link rel="stylesheet" href="../util/lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
                            <link rel="stylesheet" href="../util/lte/bower_components/bootstrap-timepicker/css/timepicker.less">
                            
                            <link rel="stylesheet" href="../util/lte/bower_components/select2/dist/css/select2.min.css">
                            
                            <link rel="stylesheet" href="../util/lte/bower_components/datatables.net-bs/css/dataTables.bootstrap.css">
                            
                            <link rel="stylesheet" href="../util/lte/bower_components/swa/sweetalert.css">
                            
                            <link rel="stylesheet" href="../util/lte//bower_components/font-awesome/css/font-awesome.min.css">
                            <link rel="stylesheet" href="../util/lte/bower_components/Ionicons/css/ionicons.min.css">
                            <link rel="stylesheet" href="../util/lte/dist/css/AdminLTE.min.css">
                            
                            <link rel="stylesheet" href="../util/lte/plugins/iCheck/all.css">
                            
                            <link rel="stylesheet" href="../util/lte/dist/css/skins/_all-skins.min.css">
                            <link rel="stylesheet" href="../util/dropify/css/dropify.min.css">
                            
                            <link rel="stylesheet"
                                  href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">';
        $html .= '</head>
                    <body>
                  ';
        $html .= $htmlDatos;


                $html .= '
<script src="../util/lte/bower_components/jquery/dist/jquery.min.js"></script>
<script src="../util/lte/bower_components/jquery-ui/jquery-ui.min.js"></script>
<script src="../util/lte/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../util/lte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<script src="../util/lte/bower_components/select2/dist/js/select2.full.min.js"></script>

<!--DATA TABLE -->
<script src="../util/lte/bower_components/datatables.net/js/jquery.dataTables.js"></script>
<script src="../util/lte/bower_components/datatables.net-bs/js/dataTables.bootstrap.js"></script>

<!-- bootstrap datepicker -->
<script src="../util/lte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->
<script src="../util/lte/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>

<!--DATA TIMEPICKER  -->
<script src="../util/lte/bower_components/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>

<!--sweet alert-->
<script src="../util/lte/bower_components/swa/sweetalert-dev.js"></script>

<!-- SlimScroll -->
<script src="../util/lte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../util/lte/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../util/lte/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../util/lte/dist/js/demo.js"></script>
<!--  Mostrar el cuadro arrastar imagen -->
<script src="../util/dropify/js/dropify.min.js"></script>

<script src="../util/lte/plugins/iCheck/icheck.min.js"></script>

<script src="../util/lte/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="../util/lte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<!-- fullCalendar -->
<script src="../util/lte/bower_components/moment/min/moment.min.js"></script>
</body>';
                $html .= '</html>';

        return $html;
    }

    public static function generarReporte($html_reporte, $tipo_reporte, $nombre_archivo)
    {
        if ($tipo_reporte == 1) {
            //Genera el reporte en HTML
            echo $html_reporte;
        } else if ($tipo_reporte == 2) {
            //Genera el reporte en PDF
            $archivo_pdf = "../reportes/" . $nombre_archivo . ".pdf";
            Help::generaPDF($archivo_pdf, $html_reporte);
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

    public static function generaPDF($file = '', $html = '', $paper = 'a4', $download = true)
    {
        require_once '../dompdf/autoload.inc.php';
        require_once '../dompdf/lib/html5lib/Parser.php';
        require_once '../dompdf/lib/php-font-lib/src/FontLib/Autoloader.php';
        require_once '../dompdf/lib/php-svg-lib/src/autoload.php';
        require_once '../dompdf/src/Autoloader.php';
        Dompdf\Autoloader::register();


        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml(utf8_decode($html));

// (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
        $dompdf->render();

// Output the generated PDF to Browser
        $dompdf->stream($file);
    }


}