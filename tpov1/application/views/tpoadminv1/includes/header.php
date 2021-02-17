<?php

header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1.
header('Pragma: no-cache'); // HTTP 1.0.
header('Expires: 0'); // Proxies.

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $title; ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link rel="shortcut icon" href="<?php echo base_url(); ?>dist/img/pin_publicidad.png" />
        <!-- Bootstrap 3.3.2 -->
        <link href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="<?php echo base_url(); ?>dist/css/font-awesome-4.3.0.css" rel="stylesheet" type="text/css" />

        <!-- fullCalendar 2.2.5-->
        <link href="<?php echo base_url(); ?>plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>plugins/fullcalendar/fullcalendar.print.css" rel="stylesheet" type="text/css" media='print' />
        <!-- Theme style -->
        <link href="<?php echo base_url(); ?>dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
        <!-- DataTables -->
        <script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>plugins/jQuery/jQuery-3.3.1.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>plugins/datatables/jquery.dataTables.min.js"></script>

        <link href="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
        <!-- jQuery Datetimepicker -->
        <link href="<?php echo base_url(); ?>plugins/datetimepicker/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />
    </head>
<body class="<?php echo $body_class; ?>">
    
    
    <!-- Site wrapper -->
    <div class="wrapper">

        <header class="main-header">
            <span class="logo"><b>INAI</b></span>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="<?php echo base_url(); ?>dist/img/inai_user.png" class="user-image" alt="User Image"/>
                                <span class="hidden-xs"><?php echo $heading; ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <img src="<?php echo base_url(); ?>dist/img/inai_user.png" class="img-circle" alt="User Image" />
                                    <p>
                                        <?php echo $heading; ?> <br> <?php echo $job; ?>
                                        <!--<small>Member since Nov. 2012</small>-->
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <li class="user-body">
                                    <!--<div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>-->
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-right">
                                        <a href="<?php echo base_url() . 'index.php/tpoadminv1/securecms/logout'; ?>" class="btn btn-default btn-flat">Salir</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- =============================================== -->

        <!-- Left side column. contains the sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="<?php echo base_url(); ?>dist/img/inai_user.png" class="img-circle" alt="User Image" />
                    </div>
                    <div class="pull-left info">
                        <p><?php echo $heading; ?></p>
                    </div>
                </div>
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu">
                    <li class="header">MENU</li>
                    <?php if($this->session->userdata('usuario_rol') == '1'){ ?>
                    <li class="treeview <?php if(@$active == 'usuarios') { echo ' active'; } ?>">
                        <a href="#">
                            <i class="fa fa-users"></i> <span>Usuarios</span> <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li <?php if($subactive == 'busqueda_usuario') { echo ' class="active"'; } ?>>
                                <a href="<?php echo base_url(); ?>index.php/tpoadminv1/usuarios/usuarios/busqueda_usuario"><i class="fa fa-circle-o"></i> Usuarios</a>
                            </li>
                            <li <?php if($subactive == 'busqueda_rol') { echo ' class="active"'; } ?>>
                                <a href="<?php echo base_url(); ?>index.php/tpoadminv1/usuarios/usuarios/busqueda_rol"><i class="fa fa-circle-o"></i> Roles</a>
                            </li>
                        </ul>
                    </li>
                      
                    <li class="treeview <?php if($active == 'sujetos') { echo ' active'; } ?>">
                        <a href="#">
                            <i class="fa fa-desktop"></i> <span>Sujetos Obligados</span> <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            
                            <li <?php if($subactive == 'busqueda_sujeto') { echo ' class="active"'; } ?>>
                                <a href="<?php echo base_url(); ?>index.php/tpoadminv1/sujetos/sujetos/busqueda_sujeto"><i class="fa fa-circle-o"></i> B&uacute;squeda</a>
                            </li>
                        </ul>
                    </li>

                    <li class="treeview <?php if($active == 'catalogos') { echo ' active'; } ?>">
                        <a href="#">
                            <i class="fa fa-folder"></i> <span>Cat&aacute;logos</span> <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li <?php if($subactive == 'campanas_avisos') { echo ' class="active"'; } ?>>
                                <a href="#">
                                    <i class="fa fa-bullhorn"></i> <span>Campa&ntilde;as y avisos institucionales</span> <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li <?php if(@$optionactive == 'busqueda_coberturas') { echo ' class="active"'; } ?>>
                                        <a href="<?php echo base_url(); ?>index.php/tpoadminv1/catalogos/campanas_avisos/busqueda_coberturas"><i class="fa fa-circle-o"></i> Coberturas</a>
                                    </li>
                                    <li <?php if(@$optionactive == 'busqueda_objetivos') { echo ' class="active"'; } ?>>
                                        <a href="<?php echo base_url(); ?>index.php/tpoadminv1/catalogos/campanas_avisos/busqueda_objetivos"><i class="fa fa-circle-o"></i> Objetivos institucionales</a>
                                    </li>
                                    <li <?php if(@$optionactive == 'busqueda_tipos') { echo ' class="active"'; } ?>>
                                        <a href="<?php echo base_url(); ?>index.php/tpoadminv1/catalogos/campanas_avisos/busqueda_tipos"><i class="fa fa-circle-o"></i> Tipos</a>
                                    </li>
                                    <li <?php if(@$optionactive == 'busqueda_subtipos') { echo ' class="active"'; } ?>>
                                        <a href="<?php echo base_url(); ?>index.php/tpoadminv1/catalogos/campanas_avisos/busqueda_subtipos"><i class="fa fa-circle-o"></i> Subtipos</a>
                                    </li>
                                    <li <?php if(@$optionactive == 'busqueda_temas') { echo ' class="active"'; } ?>>
                                        <a href="<?php echo base_url(); ?>index.php/tpoadminv1/catalogos/campanas_avisos/busqueda_temas"><i class="fa fa-circle-o"></i> Temas</a>
                                    </li>
                                    <li <?php if(@$optionactive == 'busqueda_tiposTO') { echo ' class="active"'; } ?>>
                                        <a href="<?php echo base_url(); ?>index.php/tpoadminv1/catalogos/campanas_avisos/busqueda_tiposTO"><i class="fa fa-circle-o"></i> Tipos tiempos oficiales</a>
                                    </li>
                                </ul>
                            <li>
                            <li <?php if($subactive == 'poblacion_objetivo') { echo ' class="active"'; } ?>>
                                <a href="#">
                                    <i class="fa fa-male"></i> <span>Campa&ntilde;as y avisos inst. poblaci&oacute;n objetivo</span> <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li <?php if(@$optionactive == 'busqueda_edad') { echo ' class="active"'; } ?>>
                                        <a href="<?php echo base_url(); ?>index.php/tpoadminv1/catalogos/poblacion_objetivo/busqueda_edad"><i class="fa fa-circle-o"></i> Edad</a>
                                    </li>
                                    <li <?php if(@$optionactive == 'busqueda_nivel_socioeconomico') { echo ' class="active"'; } ?>>
                                        <a href="<?php echo base_url(); ?>index.php/tpoadminv1/catalogos/poblacion_objetivo/busqueda_nivel_socioeconomico"><i class="fa fa-circle-o"></i> Nivel socioecon&oacute;mico</a>
                                    </li>
                                    <li <?php if(@$optionactive == 'busqueda_nivel_educacion') { echo ' class="active"'; } ?>>
                                        <a href="<?php echo base_url(); ?>index.php/tpoadminv1/catalogos/poblacion_objetivo/busqueda_nivel_educacion"><i class="fa fa-circle-o"></i> Nivel de educaci&oacute;n</a>
                                    </li>
                                    <li <?php if(@$optionactive == 'busqueda_sexo') { echo ' class="active"'; } ?>>
                                        <a href="<?php echo base_url(); ?>index.php/tpoadminv1/catalogos/poblacion_objetivo/busqueda_sexo"><i class="fa fa-circle-o"></i> Sexo</a>
                                    </li>
                                </ul>
                            <li>
                            <li <?php if($subactive == 'servicios') { echo ' class="active"'; } ?>>
                                <a href="#">
                                    <i class="fa fa-files-o"></i> <span>Servicios</span> <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li <?php if(@$optionactive == 'busqueda_clasificacion') { echo ' class="active"'; } ?>>
                                        <a href="<?php echo base_url(); ?>index.php/tpoadminv1/catalogos/servicios/busqueda_clasificacion"><i class="fa fa-circle-o"></i> Clasificaci&oacute;n</a>
                                    </li>
                                    <li <?php if(@$optionactive == 'busqueda_categoria') { echo ' class="active"'; } ?>>
                                        <a href="<?php echo base_url(); ?>index.php/tpoadminv1/catalogos/servicios/busqueda_categorias"><i class="fa fa-circle-o"></i> Categor&iacute;as</a>
                                    </li>
                                    <li <?php if(@$optionactive == 'busqueda_subcategoria') { echo ' class="active"'; } ?>>
                                        <a href="<?php echo base_url(); ?>index.php/tpoadminv1/catalogos/servicios/busqueda_subcategorias"><i class="fa fa-circle-o"></i> Subcategor&iacute;as</a>
                                    </li>
                                    <li <?php if(@$optionactive == 'busqueda_unidades') { echo ' class="active"'; } ?>>
                                        <a href="<?php echo base_url(); ?>index.php/tpoadminv1/catalogos/servicios/busqueda_unidades"><i class="fa fa-circle-o"></i> Unidades</a>
                                    </li>
                                </ul>
                            <li>
                            <li <?php if($subactive == 'sujetos_so') { echo ' class="active"'; } ?>>
                                <a href="#">
                                    <i class="fa fa-user"></i> <span>Sujetos</span> <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li <?php if(@$optionactive == 'busqueda_atribuciones') { echo ' class="active"'; } ?>>
                                        <a href="<?php echo base_url(); ?>index.php/tpoadminv1/catalogos/catalogos/busqueda_atribuciones"><i class="fa fa-circle-o"></i> Funciones</a>
                                    </li>
                                    <li <?php if(@$optionactive == 'busqueda_estados') { echo ' class="active"'; } ?>>
                                        <a href="<?php echo base_url(); ?>index.php/tpoadminv1/catalogos/catalogos/busqueda_estados"><i class="fa fa-circle-o"></i> Estados</a>
                                    </li>
                                    <li <?php if(@$optionactive == 'busqueda_ordenes') { echo ' class="active"'; } ?>>
                                        <a href="<?php echo base_url(); ?>index.php/tpoadminv1/catalogos/catalogos/busqueda_ordenes"><i class="fa fa-circle-o"></i> &Oacute;rdenes de gobierno</a>
                                    </li>
                                </ul>
                            <li>
                            <li <?php if($subactive == 'otros_co') { echo ' class="active"'; } ?>>
                                <a href="#">
                                    <i class="fa fa-table"></i> <span>Otros</span> <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li <?php if(@$optionactive == 'busqueda_presupuestos') { echo ' class="active"'; } ?>>
                                        <a href="<?php echo base_url(); ?>index.php/tpoadminv1/catalogos/catalogos/busqueda_presupuestos"><i class="fa fa-circle-o"></i> Partidas presupuestar&iacute;as</a>
                                    </li>
                                    <li <?php if(@$optionactive == 'busqueda_trimestres') { echo ' class="active"'; } ?>>
                                        <a href="<?php echo base_url(); ?>index.php/tpoadminv1/catalogos/catalogos/busqueda_trimestres"><i class="fa fa-circle-o"></i> Trimestres</a>
                                    </li>
                                    <li <?php if(@$optionactive == 'busqueda_ejercicios') { echo ' class="active"'; } ?>>
                                        <a href="<?php echo base_url(); ?>index.php/tpoadminv1/catalogos/catalogos/busqueda_ejercicios"><i class="fa fa-circle-o"></i> Ejercicios</a>
                                    </li>
                                    <li <?php if(@$optionactive == 'busqueda_personalidades') { echo ' class="active"'; } ?>>
                                        <a href="<?php echo base_url(); ?>index.php/tpoadminv1/catalogos/catalogos/busqueda_personalidades"><i class="fa fa-circle-o"></i> Personalidad jur&iacute;dica del proveedor</a>
                                    </li>
                                    <li <?php if(@$optionactive == 'busqueda_procedimientos') { echo ' class="active"'; } ?>>
                                        <a href="<?php echo base_url(); ?>index.php/tpoadminv1/catalogos/catalogos/busqueda_procedimientos"><i class="fa fa-circle-o"></i> Procedimientos de contrataci&oacute;n</a>
                                    </li>
                                    <li <?php if(@$optionactive == 'busqueda_ligas') { echo ' class="active"'; } ?>>
                                        <a href="<?php echo base_url(); ?>index.php/tpoadminv1/catalogos/catalogos/busqueda_ligas"><i class="fa fa-circle-o"></i> Ligas</a>
                                    </li>
                                </ul>
                            <li>
                        </ul>
                    </li>

                    <li class="treeview <?php if($active == 'bitacora') { echo ' active'; } ?>">
                        <a href="#">
                            <i class="fa fa-calendar-o"></i> <span>Bit&aacute;cora</span> <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li <?php if($subactive == 'busqueda_bitacora') { echo ' class="active"'; } ?>>
                                <a href="<?php echo base_url(); ?>index.php/tpoadminv1/bitacora/bitacora/busqueda_bitacora"><i class="fa fa-circle-o"></i>Bit&aacute;cora</a>
                            </li>
                        </ul>
                    </li>
                    
					
                    <?php } 
                    else if($this->session->userdata('usuario_rol') == '2' 
                        && ($this->session->userdata('usuario_id_so_atribucion') == 0 || $this->session->userdata('usuario_id_so_atribucion') == 2)){ ?>
                    <li class=" <?php if($active == 'proveedores') { echo ' active'; } ?>">
                        <a href="<?php echo base_url(); ?>index.php/tpoadminv1/capturista/proveedores/busqueda_proveedores">
                            <i class="fa fa-users"></i> Proveedores
                        </a>
                    </li>
                    <?php } if($this->session->userdata('usuario_rol') != '1' ){ ?>
                    <li class=" <?php if($active == 'presupuestos') { echo ' active'; } ?>">
                        <a href="<?php echo base_url(); ?>index.php/tpoadminv1/capturista/presupuestos/busqueda_presupuestos">
                            <i class="fa fa-line-chart"></i> Planeaci&oacute;n y presupuestos
                        </a>
                    </li>
                    <?php } if($this->session->userdata('usuario_rol') == '2' 
                        && ($this->session->userdata('usuario_id_so_atribucion') == 1 || $this->session->userdata('usuario_id_so_atribucion') == 2)){ ?>
                    <li class=" <?php if($active == 'campanas') { echo ' active'; } ?>">
                        <a href="<?php echo base_url(); ?>index.php/tpoadminv1/campanas/campanas/busqueda_campanas_avisos">
                            <i class="fa fa-database"></i> Campañas y avisos institucionales
                        </a>
                    </li>
					<?php } if($this->session->userdata('usuario_rol') == '2' 
                        && ($this->session->userdata('usuario_id_so_atribucion') == 0 || $this->session->userdata('usuario_id_so_atribucion') == 2)){ ?>
                    <li class=" <?php if($active == 'contratos') { echo ' active'; } ?>">
                        <a href="<?php echo base_url(); ?>index.php/tpoadminv1/capturista/contratos/busqueda_contratos">
                            <i class="fa fa-bookmark-o"></i> Contratos
                        </a>
                    </li>
                    <?php } if($this->session->userdata('usuario_rol') == '2' 
                        && ($this->session->userdata('usuario_id_so_atribucion') == 0 || $this->session->userdata('usuario_id_so_atribucion') == 2)){ ?>
                    <li class=" <?php if($active == 'ordenes_compra') { echo ' active'; } ?>">
                        <a href="<?php echo base_url(); ?>index.php/tpoadminv1/capturista/ordenes_compra/busqueda_ordenes_compra">
                            <i class="fa fa-file-text-o"></i> &Oacute;rdenes de compra
                        </a>
                    </li>
                    <li class=" <?php if($active == 'facturas') { echo ' active'; } ?>">
                        <a href="<?php echo base_url(); ?>index.php/tpoadminv1/capturista/facturas/busqueda_facturas">
                            <i class="fa fa-file-o"></i> Facturas
                        </a>
                    </li>
                    <?php }
                    ?>
                    

                    <?php
                    
                    if(strpos($this->session->userdata('usuario_permisos'), 'wiki') !== false)
                    {
                        
                    ?>
                    <li class="treeview<?php if($active == 'wiki') { echo ' active'; } ?>">
                        <a href="#">
                            <i class="fa fa-file"></i> <span>Wiki</span> <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <?php
                            if(strpos($this->session->userdata('usuario_permisos'), 'busqueda_wiki') !== false)
                            {
                            ?>
                            <li<?php if($subactive == 'busqueda_wiki') { echo ' class="active"'; } ?>>
                                <a href="<?php echo base_url(); ?>index.php/cms/wiki/wiki/busqueda_wiki"><i class="fa fa-circle-o"></i> Búsqueda</a>
                            </li>
                            <?php
                            }
                            ?>
                            
                            <?php
                            if(strpos($this->session->userdata('usuario_permisos'), 'alta_wiki') !== false)
                            {
                            ?>
                            <li<?php if($subactive == 'alta_wiki') { echo ' class="active"'; } ?>>
                                <a href="<?php echo base_url(); ?>index.php/cms/wiki/wiki/alta_wiki"><i class="fa fa-circle-o"></i> Alta</a>
                            </li>
                            <?php
                            }
                            ?>
                            
                            
                        </ul>
                    </li>
                    <?php
                    
                    }
                    
                    ?>
                    
                    <li class=" <?php if($active == 'logo') { echo ' active'; } ?>">
                        <a href="<?php echo base_url(); ?>index.php/tpoadminv1/logo/logo/alta_carga_logo">
                            <i class="fa fa-cog"></i> Configuraci&oacute;n
                        </a>
                    </li>
                    
                    <?php if(isset($_SESSION['pnt']) AND isset($_SESSION["pnt"]["success"]) AND $_SESSION["pnt"]["success"] ){?>
                        <!--li class=" <?php if($active == 'pnt') { echo ' active'; } ?>"-->
                        <li class="">
                            <a href="<?php echo base_url(); ?>index.php/tpoadminv1/pnt/listado?formato=a">
                                 <i class="fa fa-database"></i> SIPOT
                            </a>
                        </li>
                    <?php } ?>
                   
                    
                    <?php
                    if(strpos($this->session->userdata('usuario_permisos'), 'philips_') !== false)
                    {
                    ?>
                        <li class="treeview<?php if($active == 'smart') { echo ' active'; } ?>">
                            <a href="#">
                                <i class="fa fa-home"></i> <span>Smart Home</span> <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <?php
                                if(strpos($this->session->userdata('usuario_permisos'), 'philips_alta') !== false)
                                {
                                ?>
                                    <li<?php if($subactive == 'philips') { echo ' class="active"'; } ?>>
                                        <a href="#">
                                            <i class="fa fa-circle-o"></i> <span>Philips</span> <i class="fa fa-angle-left pull-right"></i>
                                        </a>
                                        <ul class="treeview-menu">
                                            <?php
                                            if(strpos($this->session->userdata('usuario_permisos'), 'philips_alta') !== false)
                                            {
                                            ?>
                                                <li<?php if(@$sub_subactive == 'philips_alta') { echo ' class="active"'; } ?>>
                                                    <a href="<?php echo base_url(); ?>index.php/cms/smart/smart/alta_philips"><i class="fa fa-circle-o"></i> Alta</a>
                                                </li>
                                            <?php
                                            }
                                            ?>

                                            <?php
                                            if(strpos($this->session->userdata('usuario_permisos'), 'philips_busqueda') !== false)
                                            {
                                            ?>
                                            <li<?php if(@$sub_subactive == 'philips_busqueda') { echo ' class="active"'; } ?>>
                                                <a href="<?php echo base_url(); ?>index.php/cms/smart/smart/busqueda_philips"><i class="fa fa-circle-o"></i> B&uacute;squeda</a>
                                            </li>

                                            <?php
                                            }
                                            ?>
                                        </ul>
                                    </li>
                                <?php
                                }
                                ?>

                                <?php
                                if(strpos($this->session->userdata('usuario_permisos'), 'sonos_alta') !== false)
                                {
                                ?>
                                    <li<?php if($subactive == 'sonos') { echo ' class="active"'; } ?>>
                                        <a href="#">
                                            <i class="fa fa-circle-o"></i> <span>Sonos</span> <i class="fa fa-angle-left pull-right"></i>
                                        </a>
                                        <ul class="treeview-menu">
                                            <?php
                                            if(strpos($this->session->userdata('usuario_permisos'), 'sonos_alta') !== false)
                                            {
                                            ?>
                                                <li<?php if(@$sub_subactive == 'sonos_alta') { echo ' class="active"'; } ?>>
                                                    <a href="<?php echo base_url(); ?>index.php/cms/smart/smart/alta_sonos"><i class="fa fa-circle-o"></i> Alta</a>
                                                </li>
                                            <?php
                                            }
                                            ?>
                                            <?php
                                            if(strpos($this->session->userdata('usuario_permisos'), 'sonos_busqueda') !== false)
                                            {
                                            ?>
                                                <li<?php if(@$sub_subactive == 'sonos_busqueda') { echo ' class="active"'; } ?>>
                                                    <a href="<?php echo base_url(); ?>index.php/cms/smart/smart/busqueda_sonos"><i class="fa fa-circle-o"></i> B&uacute;squeda</a>
                                                </li>

                                            <?php
                                            }
                                            ?>
                                        </ul>
                                    </li>
                                <?php
                                }
                                ?>

                                <?php
                                if(strpos($this->session->userdata('usuario_permisos'), 'mobotix_alta') !== false)
                                {
                                ?>
                                    <li<?php if($subactive == 'mobotix') { echo ' class="active"'; } ?>>
                                        <a href="#">
                                            <i class="fa fa-circle-o"></i> <span>Mobotix</span> <i class="fa fa-angle-left pull-right"></i>
                                        </a>
                                        <ul class="treeview-menu">
                                            <?php
                                            if(strpos($this->session->userdata('usuario_permisos'), 'mobotix_alta') !== false)
                                            {
                                            ?>
                                                <li<?php if(@$sub_subactive == 'mobotix_alta') { echo ' class="active"'; } ?>>
                                                    <a href="<?php echo base_url(); ?>index.php/cms/smart/smart/alta_mobotix"><i class="fa fa-circle-o"></i> Alta</a>
                                                </li>
                                            <?php
                                            }
                                            ?>

                                            <?php
                                            if(strpos($this->session->userdata('usuario_permisos'), 'mobotix_busqueda') !== false)
                                            {
                                            ?>
                                                <li<?php if(@$sub_subactive == 'mobotix_busqueda') { echo ' class="active"'; } ?>>
                                                    <a href="<?php echo base_url(); ?>index.php/cms/smart/smart/busqueda_mobotix"><i class="fa fa-circle-o"></i> B&uacute;squeda</a>
                                                </li>
                                            <?php
                                            }
                                            ?>
                                        </ul>
                                    </li>
                                <?php
                                }
                                ?>

                            </ul>
                        </li>
                    <?php
                    }
                    ?>
                    
                    
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- =============================================== -->
        
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    <?php echo $title; ?>
                    <small><?php echo $mensaje; ?></small>
                </h1>
                <!--<ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="#">Examples</a></li>
                    <li class="active">Blank page</li>
                </ol>-->
            </section>
            
            <!-- Main content -->
            <section class="content">