<?php require_once 'sesion.validar.vista.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Mantenimiento de Programación de Horarios</title>
        <?php require_once 'metas.vista.php'; ?>
        <?php require_once 'estilos.vista.php'; ?>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <!-- Site wrapper -->
        <div class="wrapper">
            <?php require_once 'menu.cabecera.vista.php'; ?>
            <!-- =============================================== -->

            <!-- Left side column. contains the sidebar -->
            <?php require_once 'menu.izquierda.vista.php'; ?>
            <!-- =============================================== -->

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style="background-color: white" >
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Mantenimiento de Programación de Horarios
                    </h1>
                    <ol class="breadcrumb">
                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal" id="agregar_horario"><i class="fa fa-copy"></i> Agregar Horario</button>&nbsp;&nbsp;&nbsp;
                        <li><a href="#"><i class="fa fa-dashboard"></i> Menú Principal</a></li>
                        <li><a href="#">Mantenimientos</a></li>
                        <li class="active">Mantenimiento de Programación de Horarios</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-default">
                                <div class="box-body">
                                    <div id="listado"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- INICIO del formulario modal -->
                    <small>
                        <form id="frmgrabar">
                            <div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="titulomodal">Título de la ventana</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-xs-3">
                                                    <p>
                                                        <input type="hidden" value="" id="operation" name="operation">
                                                        Código <input type="text"
                                                                      name="txtCodigo" 
                                                                      id="txtCodigo" 
                                                                      class="form-control input-sm text-bold" 
                                                                      readonly="">
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                
                                                <div class="col-xs-6">
                                                    <p>
                                                        HORA
                                                        <select name="cboHora" 
                                                                  id="cboHora" 
                                                                class="form-control input-sm" required="">

                                                        </select>
                                                    </p>
                                                </div>
                                            </div>
                                            
                                           <!-- checkbox -->
                                           <div class="form-check form-check-inline">
                                            <input type="checkbox" 
                                                     id="chkDom" 
                                                   name="chkDom" 
                                                  value="1" >
                                            <label  for="chkDom">Domingo</label>
                                           
                                            <input type="checkbox" 
                                                     id="chkLun" 
                                                   name="chkLun" 
                                                  value="1" >
                                            <label  for="chkLun">Lunes</label>
                                                                                   
                                            <input type="checkbox" 
                                                     id="chkMar" 
                                                   name="chkMar" 
                                                  value="1" >
                                            <label  for="chkMar">Martes</label>
                                            
                                            <input type="checkbox" 
                                                     id="chkMie" 
                                                   name="chkMie" 
                                                  value="1" >
                                            <label  for="chkMie">Miércoles</label>
                                            
                                            <input type="checkbox" 
                                                     id="chkJue" 
                                                   name="chkJue" 
                                                  value="1" >
                                            <label  for="chkMar">Jueves</label>
                                            
                                            <input type="checkbox" 
                                                     id="chkVie" 
                                                   name="chkVie" 
                                                  value="1" >
                                            <label  for="chkVie">Viernes</label>
                                            
                                            <input type="checkbox" 
                                                     id="chkSab" 
                                                   name="chkSab" 
                                                  value="1" >
                                            <label  for="chkSab">Sábado</label>
                                           </div> 
                                            
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success" aria-hidden="true"><i class="fa fa-save"></i> Grabar</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal" id="btncerrar"><i class="fa fa-close"></i> Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </small>
                    <!-- FIN del formulario modal -->


                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            <?php require_once 'menu.pie.vista.php'; ?>

            <!-- Control Sidebar -->
            <?php require_once 'menu.derecha.vista.php'; ?>
            <!-- /.control-sidebar -->
            <div class="control-sidebar-bg"></div>
        </div>
        <!-- ./wrapper -->

        <?php require_once 'scripts.vista.php'; ?>
        
        <!-- Scripts para mantenimiento -->
        
        <script src="js/cargar.combos.horarioProgramado.hora.js" type="text/javascript"></script>
        <script src="js/mantenimiento.horarioProgramado.js" type="text/javascript"></script>
        
    </body>
</html> 