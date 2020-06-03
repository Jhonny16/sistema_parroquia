<header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo" style="background: #222d32">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b><img src="../imagenes/cruz.png" style="width: 2em" alt=""></b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b><img src="../imagenes/cruz.png" style="width: 2em" alt=""> Parroquia</b></span>

    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top"
         style="text-align: center;background-image: linear-gradient(150deg, rgb(255,255,255) 150px, rgb(60,141,188) 95%);">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="../imagenes/user.png" class="user-image" alt="User Image">
                        <span class="hidden-xs"><?php echo $sesion_rol_name.': '.  $sesion_nombre_usuario; ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <img src="../imagenes/user.png" class="img-circle" alt="User Image">

                            <p>
                                <?php echo $sesion_nombre_usuario; ?> 
                                <br>
                                <?php echo $sesion_cargo_usuario; ?>
                            </p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                               <!-- <a href="perfil.usuario.vista.php" class="btn btn-primary btn-flat">Perfil</a>-->
                                <a href="perfil.usuario.vista.php" class="btn btn-primary btn-flat"><span class="fa fa-user"></span> Perfil</a>
                            </div>
                            <div class="pull-right">
                                <a href="../controlador/sesion.cerrar.controlador.php" class="btn btn-danger btn-flat">Cerrar Sesión</a>
                            </div>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </nav>
</header>