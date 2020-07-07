<aside class="main-sidebar">
    <hr>
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="../imagenes/user.png" class="user-image" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?php echo $sesion_nombre_usuario; ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">Menú Principal</li>
            <input type="text" value="<?php echo $sesion_rol_id; ?>" id="sesion_rol_id" style="display: none">
            <input type="text" value="<?php echo $sesion_cargo_id; ?>" id="cargo_id" style="display: none">
            <input type="text" value="<?php echo $sesion_capilla_id; ?>" id="sesion_capilla_id" style="display: none">
            <input type="text" value="<?php echo $sesion_dni_usuario; ?>" id="sesion_dni" style="display: none">
            <input type="text" value="<?php echo $sesion_parroquia_id; ?>" id="sesion_parroquia_id" style="display: none">
            <input type="text" value="<?php echo $sesion_user_id; ?>" id="sesion_user_id" style="display: none">
            <input type="text" value="<?php echo $sesion_nombre_usuario; ?>" id="sesion_user_name" style="display: none">

            <!--<Menu Mantenimiento> -->

            <?php
            if ($sesion_rol_id == '3') {
                echo '
                 <li class="treeview">
                <a href="#">
                    <i class="fa fa-edit"></i> <span>Mantenimientos</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="mantenimiento.intencion.vista.php"><i class="fa fa-circle-o"></i> Misa</a></li>
                    <li><a href="mantenimiento.tipoCulto.vista.php"><i class="fa fa-circle-o"></i> Tipos de Culto</a></li>
                    <li><a href="tipoculto_detalle_vista.php"><i class="fa fa-circle-o"></i> Detalle Tipo Culto</a></li>
                    <li><a href="mantenimiento.celebracion.vista.php"><i class="fa fa-circle-o"></i> Celebracion</a>
                    </li>
                    <li><a href="mantenimiento.culto.vista.php"><i class="fa fa-circle-o"></i> Culto</a></li>
                    <li><a href="mantenimiento.horarioPatron.vista.php"><i class="fa fa-circle-o"></i> Horario Patron</a></li>                    
                    <li><a href="mantenimiento.parroquia.vista.php"><i class="fa fa-circle-o"></i> Parroquia</a></li>
                    <li><a href="capilla_vista.php"><i class="fa fa-circle-o"></i> Capilla</a></li>
                    <li><a href="mantenimiento.trabajador.vista.php"><i class="fa fa-circle-o"></i> Trabajador</a></li>
                    <li><a href="mantenimiento.cargo.vista.php"><i class="fa fa-circle-o"></i> Cargo</a></li>
                    <li><a href="mantenimiento.ocupacion.vista.php"><i class="fa fa-circle-o"></i> Ocupacion</a></li>
                </ul>
            </li>
                
                
                
                ';
            }
            ?>
            <?php
            if ($sesion_rol_id == '2') {
                echo '
                 <li class="treeview">
                <a href="#">
                    <i class="fa fa-edit"></i> <span>Mantenimientos</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                                   
                    <li><a href="mantenimiento.trabajador.vista.php"><i class="fa fa-circle-o"></i> Clientes</a></li>
                   
                </ul>
            </li>
                
                
                
                ';
            }
            ?>
            <?php
            if ($sesion_rol_id == '1') {
                echo '
                
                <li class="treeview">
                <a href="#">
                    <i class="fa fa-edit"></i> <span>Mantenimientos</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="mantenimiento.intencion.vista.php"><i class="fa fa-circle-o"></i> Misa</a></li>
                    <li><a href="mantenimiento.tipoCulto.vista.php"><i class="fa fa-circle-o"></i> Tipos de Culto</a>
                    </li>
                    <li><a href="tipoculto_detalle_vista.php"><i class="fa fa-circle-o"></i> Detalle Tipo Culto</a></li>
                    <li><a href="mantenimiento.celebracion.vista.php"><i class="fa fa-circle-o"></i> Celebracion</a>
                    </li>
                    <li><a href="mantenimiento.culto.vista.php"><i class="fa fa-circle-o"></i> Culto</a></li>
                                         
                    <li><a href="mantenimiento.trabajador.vista.php"><i class="fa fa-circle-o"></i> Trabajador</a></li>
                    <li><a href="mantenimiento.cargo.vista.php"><i class="fa fa-circle-o"></i> Cargo</a></li>
                    <li><a href="mantenimiento.ocupacion.vista.php"><i class="fa fa-circle-o"></i> Ocupacion</a></li>
                    <li><a href="mantenimiento_lista_precios.php"><i class="fa fa-circle-o"></i> Lista precios</a></li>
                </ul>
            </li>
                <li class="treeview">
                <a href="#">
                    <i class="fa fa-clock-o"></i> <span>Horarios</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                     <li><a href="mantenimiento.horarioPatron.vista.php"><i class="fa fa-circle-o"></i> Horario  Patron</a></li>      
                    <li><a href="horario_programacion_vista.php"><i class="fa fa-circle-o text-green"></i> Programación</a>
                    </li>
                </ul>
            </li>
                
                ';


            }
            ?>
            <?php
            if ($sesion_rol_id == '1' or $sesion_rol_id == '3') {
                echo '
               <li class="treeview">
                            <a href="#">
                                <i class="fa fa-user-o"></i> <span>Asignación Personal</span>
                                <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="personal_asignacion.php"><i class="fa fa-circle-o text-green"></i>Asignación </a></li>
                            </ul>
                        </li>
                            ';
            }
            ?>


            <?php
            if ($sesion_rol_id == '1' or $sesion_rol_id == '2') {
                echo '
                    <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-calendar-check-o"></i> <span>Reservas</span>
                                    <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="reserva_calendar.php"><i class="fa fa-circle-o text-green"></i> Reserva</a></li>
                                    <li><a href="reserva_por_horario.php"><i class="fa fa-circle-o text-green"></i> Búqueda de reservas</a></li>
                                    <li><a href="reserva_vista_externa.php"><i class="fa fa-circle-o text-green"></i> Reserva
                                            Externa</a></li>
                                </ul>
                            </li>
                    ';
            }
            ?>
            <?php
            if ($sesion_rol_id == '4') {
                echo '
                    <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-calendar-check-o"></i> <span>Reserva</span>
                                    <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="reserva_cliente_vista.php"><i class="fa fa-circle-o text-green"></i> Reserva
                                            </a></li>
                                </ul>
                            </li>
                    ';
            }
            ?>


            <?php
            if ($sesion_rol_id == '1' or $sesion_rol_id == '3' or $sesion_rol_id == '2'  ) {
                echo '
               <li class="treeview">
                            <a href="#">
                                <i class="fa fa-users"></i> <span>Usuarios</span>
                                <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="usuarios_vista.php"><i class="fa fa-circle-o text-green"></i> Usuarios</a></li>
                            </ul>
                        </li>
                            ';
            }
            ?>
            <?php
            if ($sesion_rol_id == '4') {
                echo '
                    <li class="treeview">      
                            <a href="#">
                                <i class="fa fa-list-alt"></i> <span>Historial</span>
                                <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="reserva_cliente_lista.php"><i class="fa fa-circle-o text-green"></i> Historial Reservas</a></li>
                            </ul>
                        </li>
               <li class="treeview">
                            <a href="#">
                                <i class="fa fa-users"></i> <span>Usuarios</span>
                                <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="usuario_cliente_vista.php"><i class="fa fa-circle-o text-green"></i> Cambio Password</a></li>
                            </ul>
                        </li>
                            ';
            }
            ?>


            <?php
            if ($sesion_rol_id == '1' or $sesion_rol_id == '2' or $sesion_rol_id == '3') {
                echo '
                    <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-list-alt"></i> <span>Reporte</span>
                                    <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                                </a>
                                <ul class="treeview-menu">
                                    <!--<li><a href="reporte_utilidades.php"><i class="fa fa-circle-o text-green"></i> Utilidades</a></li>-->
                                    <li><a href="reporte_misa_comunitaria.php"><i class="fa fa-circle-o text-green"></i> Misa comunitaria</a></li>
                                    <li><a href="reporte_misa_comunitaria_utilidades.php"><i class="fa fa-circle-o text-green"></i> Misa comuntaria utilidades</a></li>
                                    <li><a href="reporte_misa_individual_utilidades.php"><i class="fa fa-circle-o text-green"></i> Misa individual utilidades</a></li>
                                    <li><a href="reporte_resultado_caja.php"><i class="fa fa-circle-o text-green"></i> Resultado de caja</a></li>
                                    <li><a href="reporte_resultado_padre.php"><i class="fa fa-circle-o text-green"></i> Resultado limosnas y misas</a></li>
                                </ul>
                            </li>
                     ';
            }
            ?>



            <!--<Fin de Menu OPeraciones> -->
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>