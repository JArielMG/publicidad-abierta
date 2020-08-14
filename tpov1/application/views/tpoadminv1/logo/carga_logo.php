
<?php

/* 
 INAI / CARGA LOGO
 */
 //var_dump($_SESSION["pnt"]["token"]["token"]);
//session_destroy();
?>

<style>
    .tooltip.top .tooltip-inner {
        background-color: #fff;
        border: 2px solid #ccc;
        color: black;
    }
    .tooltip.top .tooltip-arrow {
        border-top-color: #ccc;
    }
    .has-error {
        box-shadow: 0 0 1px red, 0 0 3px red !important;
        background: #FFEBEB !important;
    }

    .disabled_tab2 {
        pointer-events: none;
        cursor: default;
    }

    #login-pnt .form-control {
        display: inline ;
        width: 200px ;
    }


    #login-pnt label{
        margin-left: 45px;
        margin-right: 5px;
    }

    .status{
        font-weight: bolder;
        display:none;
    }

    .active{ color: green; }

    .inactive{ color: red; }

    #login-pnt input[type=submit]{
        margin-left: 25px;
    }

    .circle {
        
        display: inline-flex;
        width: 15px;
        color: #5cb85c;
        height: 15px;
        -moz-border-radius: 50%;
        -webkit-border-radius: 50%;
        border-radius: 50%;
    }

</style>


<!-- Main content -->
<section class="content">
    <?php
        if ($this->session->flashdata('error'))
        {
        ?>
        <div class="alert alert-danger alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <h4><i class="icon fa fa-ban"></i> ¡Error!</h4>
            <?php echo $this->session->flashdata('error'); ?>
        </div>
        <?php
        }
    ?>

    <?php
    if ($this->session->flashdata('exito'))
    {
    ?>
        <div class="alert alert-success alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <h4>	<i class="icon fa fa-check"></i> ¡Exito!</h4>
            <?php echo $this->session->flashdata('exito'); ?>
        </div>
    <?php
    }
    ?>

    <?php
    if ($this->session->flashdata('alert'))
    {
    ?>
        <div class="alert alert-warning alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <h4><i class="icon fa fa-ban"></i> ¡Alerta!</h4>
            <?php echo $this->session->flashdata('alert'); ?>
        </div>
    <?php
    }
    ?>

    <div class="row">
        <input id="url_logo" type="hidden" value="<?php echo $url_logo;?>" >
        <?php 
            /*** El siguiente código es para colocar la clase .validation_error cuando hay un error en el form_validate 
             * form_error regresa una cadena, si es vacía significa que no hay error, si trae texto se marca el error
             * ***/
           
            $error_e = !empty(form_error('id_ejercicio', '<div class="text-danger">', '</div>'));
            $error_so = !empty(form_error('id_sujeto_obligado', '<div class="text-danger">', '</div>'));
            $error_active = !empty(form_error('active', '<div class="text-danger">', '</div>'));
            $error_file = false; 
            $mensaje = '';

            if(validation_errors() == TRUE)
            {
                echo '<div class="alert alert-danger"><button class="close"  data-dismiss="alert">x</button>
                <h4><i class="icon fa fa-ban"></i>¡Alerta!</h4>' . validation_errors() . $mensaje .'</div>';  
            }
        ?>
        <!-- custom tabs-->
        <form role="form" method="post" action="<?php echo base_url(); ?>index.php/tpoadminv1/campanas/campanas/validate_alta_campanas_avisos" enctype="multipart/form-data" >
            <div class="box box-info">
                <div class="box-header">
                    <h4>Actualiza Logo</h4>
                    <div  class="box-tools pull-right">
                        <img id="img_logo" src="<?php echo $url_logo; ?>" width="150"  height="90"/>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <!-- CODIGO PARA CARGAR ARCHIVOS -->
                    <div class="form-group">
                        <label class="custom-file-label"> Logo en formato PNG 150px ancho por 90px de alto, con efecto de transparencia.</label>
                    </div>
                    <div class="input-group">
                        <div id="file_by_save" class="input-group-btn" style="<?php if($control_update['file_by_save']) echo 'display:none;' ?>">
                            <button class="btn btn-success" type="button" onclick="triggerClickDocumento('lanzar')">Subir archivo</button>
                        </div>
                        <div id="file_see" class="input-group-btn" style="<?php if($control_update['file_see']) echo 'display:none;' ?>">
                            <button class="btn btn-info" type="button" onclick="triggerClickDocumento('ver')" >Ver archivo</button>
                        </div>
                        <div id="file_load" class="input-group-btn" style="<?php if($control_update['file_load']) echo 'display:none;' ?>">
                            <button class="btn btn-success" type="button" ><i class="fa fa-refresh fa-spin"></i></button>
                        </div>
                        <input type="text" id="name_file_input" placeholder="Ning&uacute;n archivo seleccionado" value="<?php echo $registro['name_file_imagen']; ?>"  class="form-control" />
                        <input type="hidden" id="file_archivo_nombre" name="file_archivo_nombre" value="<?php echo $registro['name_file_imagen']; ?>" />
                        <input type="hidden" id="name_file_imagen" name="name_file_imagen" value="<?php echo $registro['name_file_imagen']; ?>" />
                        <input type="file" name="file_programa_imagen" id="file_programa_imagen" class="hide" accept=".png"/>
                        <div id="file_saved" class="input-group-btn" style="<?php if($control_update['file_saved']) echo 'display:none;' ?>">
                            <button class="btn btn-danger" type="button" onclick="triggerClickDocumento('eliminar')" >Eliminar archivo</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <p class="help-block" id="result_upload"><?php echo $control_update['mensaje_file']; ?> </p>
                    </div>
                </div><!-- /.box-body -->
                <!-- <div class="box-footer">
                    <button class="btn btn-primary" type="submit">Guardar</button>
                    <?php echo anchor("tpoadminv1/capturista/presupuestos/busqueda_presupuestos", "<button class='btn btn-default' type='button'>Regresar</button></td>"); ?>
                </div>-->
            </div><!-- /.box -->
        </form>
                
        
        

        <!-- Verificamos si ya esta dada de alta una fecha manualmente -->
        <?php
        if($fecha_act != '0')
        {
            ?>
                <!-- Mostramos los detalles de los grupos de lugares dados de alta -->

            <div class="box">
                <div class="box-header">
                    <h4>Detalles fecha actualización</h4>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Fecha de actualizaci&oacute;n</th>
                                <th>Comentarios</th>
                                <th> </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                echo '<tr>';
                                echo '<td>' . $fecha_act['fecha_act'] . '</td>';
                                echo '<td>' . $fecha_act['comentario_act'] . '</td>';
                                echo "<td> <span class='btn-group btn btn-warning btn-sm' onclick=\"editarFecha(" .$fecha_act['id_fecha_act'].",'".$fecha_act['fecha_act']."','".$fecha_act['comentario_act']."')\"> <i class='fa fa-edit'></i></span></td>";
                                echo '</tr>';
                            ?>
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        <?php
        }
        else
        { 
        ?>
        <form role="form" method="post" action="<?php echo base_url(); ?>index.php/tpoadminv1/logo/logo/validate_alta_carga_logo" enctype="multipart/form-data" >
            <div class="box">
                <div class="box-header">
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                        <label class="custom-file-label">
                            Fecha de actualizaci&oacute;n manual:
                        </label>
                    </div>
                    <div class="form-group">
                        <input type="text" id= "fecha_act" class="form-control" placeholder="Ingresa fecha actualizaci&oacute; manual" name="fecha_act" value="<?php echo set_value('fecha_act'); ?>" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label class="custom-file-label">
                            Comentario:
                        </label>
                    </div>
                    <div class="form-group">
                        <input type="text" id= "comentario_act" class="form-control" placeholder="Ingresa un comentario sobre la actualizaci&oacute;n manual" name="comentario_act" value="<?php echo set_value('comentario_act'); ?>" autocomplete="off">
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <button class="btn btn-primary" type="submit">Guardar</button>
                </div>   <!-- /.box-footer --> 
            </div><!-- /.box -->
        </form>
        <?php
        }
        ?>
    
    </div><!-- /. div row-->

    <div class="row">
        <!-- Mostramos los detalles de los grupos de lugares dados de alta -->
        <div class="box box-info">
            <div class="box-header">
               <h4 class="modal-title">
               <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="Cuando se configure la url del sistema, &eacute;sta se debe ingresar a la configuraci&oacute;n de Google reCAPTCHA."></i>  
                reCAPTCHA
               </h4>
            </div>
            <div class="box-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="Se debe obtener en Google reCAPTCHA"></i>
                            Clave del sitio
                        </th>
                        <th>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="Se debe obtener en Google reCAPTCHA"></i>
                            Clave secreta
                        </th>
                        <th>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="En activo se habilita el reCAPTCHA en el inicio de sesi&oacute;n, en inactivo se desahabilita."></i>
                            Estatus
                        </th>
                        <th> <?php 
                                if(!isset($recaptcha)){  
                                    echo "<button type='button' class='btn-group btn btn-primary btn-sm' onclick=\"agregarRecaptcha()\"> <i class='fa fa-edit'></i> Agregar</button>";
                                }
                            ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        if(isset($recaptcha)){
                            echo "<tr>";
                            echo "<td>" . $recaptcha->recaptcha . "</td>";
                            echo "<td>" . $recaptcha->clave . "</td>";
                            echo "<td>" . ($recaptcha->active == 1 ? 'Activo' : 'Inactivo') . "</td>";
                            echo "<td><button type='button' class='btn-group btn btn-warning btn-sm' onclick=\"editarRecaptcha(" . $recaptcha->id_settings. ", '". $recaptcha->recaptcha. "', '". $recaptcha->clave . "', " . $recaptcha->active . ")\"> <i class='fa fa-edit'></i></button></td>";
                            echo "</tr>";
                        } 
                    ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>



    <div class="row">
        <!-- Mostramos los detalles de los grupos de lugares dados de alta -->
        <div class="box box">
            <div class="box-header">
               <h4 class="modal-title">
                    <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="Esta opci&oacute;n te permite habilitar o desahabilitar la gr&aacute;fica de la vista publica."></i>  
                    Gr&aacute;fica <b>Presupuestos/&Oacute;rdenes de Gobierno</b> de la vista publica de la pesta&ntilde;a Presupuesto  
               </h4>
            </div>
            <div class="box-body">
            <table class="table table-bordered table-hover">
                <tbody style="font-size:16px;">
                    <tr>
                    <?php 
                        if(!isset($grafica) || $grafica->active == 0){
                            echo "<td width='90%'>La gr&aacute;fica se encuentra actualmente <span id='tdMensaje' class='text-danger'><b>deshabilitada</b></span>.</td>";
                            echo "<td><button id='btnhabilitar' type='button' class='btn-group btn btn-success btn-sm' data-option='habilitar' onclick=\"habilitarGrafica()\"> <i class='fa fa-check'></i> Habilitar</button></td>";
                        }else{
                            echo "<td width='90%'>La gr&aacute;fica se encuentra actualmente <span id='tdMensaje' class='text-success'><b>habilitada</b></span>.</td>";
                            echo "<td><button id='btnhabilitar' type='button' class='btn-group btn btn-danger btn-sm' data-option='deshabilitar' onclick=\"habilitarGrafica()\"> <i class='fa fa-close'></i> Deshabilitar</button></td>";
                        }
                    ?>
                    </tr>
                </tbody>
            </table>
            </div>
        </div>
    </div>


    <div class="row">
        <!-- Mostramos los detalles de los grupos de lugares dados de alta -->
        <div class="box box-info">
            <div class="box-header">
               <h4 class="modal-title">
               <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="Cuando se ingrese a los servicios del PNT se podrán agregar registros."></i>  
                Conexión a WEB Services PNT 
               </h4>
            </div>
            <div class="box-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="Usuario activo de PNT."></i>
                            Usuario
                        </th>

                        <th>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title=""></i>
                            Clave Secreta
                        </th>

                        <th>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="En activo se habilitan los servicios del PNT, en Inactivo no."></i>
                            Estatus
                        </th>
                        <th> <?php 
                                if(!isset($recaptcha)){  
                                    echo "<button type='button' class='btn-group btn btn-primary btn-sm' onclick=\"entrarPNT()\"> <i class='fa fa-edit'></i> Ingresar </button>";
                                }
                            ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        //$myfile = fopen($_SERVER["DOCUMENT_ROOT"] . "/tpov2/data/archivo_conexion.txt", "w") or die("Unable to open file!");
                        echo "<tr>";
                        if( isset($_SESSION['pnt']) ){
                            if($_SESSION["pnt"]["success"]){
                                echo "<td> <input type='input' id='re-user' class='form-control' name='re-user' value='" . $_SESSION["user_pnt"] . "'> </td>";
                                echo "<td> <input type='password' id='re-pass' class='form-control' name='re-pass'> </td>";
                                echo "<td class='active'> <span class='circle' style='background: #3f3'>  </span> Activo </td>";
                                
                                echo "<td> <a type='submit' class='btn-group btn btn-success btn-sm' href='" . base_url() . "index.php/tpoadminv1/logo/logo/entrar_pnt' id='re-conectar'> Conectar </a> &nbsp;&nbsp;&nbsp;"; 
                                echo      "<a type='submit' class='btn-group btn btn-danger btn-sm' href='" . base_url() . "index.php/tpoadminv1/logo/logo/salir_pnt'  id='desconectar'> Desconectar </a> </td>";
                                echo "</tr></tbody></table>";
                                echo "</form>";
                                
                                //$txt = "conexión: " . json_encode($_SESSION["pnt"]["success"]) . ", mensaje: " . $_SESSION["pnt"]["mensaje"];
                            } else{
                                $_SESSION["user_pnt"] = "";
                                echo "<td> <input type='input' id='re-user' class='form-control' name='re-user'>  </td>";
                                echo "<td> <input type='password' id='re-pass' class='form-control' name='re-pass'> </td>";
                                echo "<td class='inactive'> <span class='circle' style='background: #f33'> </span> Inactivo </td>";
                                echo "<td> <a type='submit' class='btn-group btn btn-success btn-sm' 
                                              href='" . base_url() . "index.php/tpoadminv1/logo/logo/entrar_pnt' id='re-conectar'> Conectar </a></td>";
                                              
                                echo "</tr></tbody> </table>";
                              
                                //$txt = "conexión: " . json_encode($_SESSION["pnt"]["success"]) . ", mensaje: " . ( isset($_SESSION["pnt"]["mensaje"])? $_SESSION["pnt"]["mensaje"] : '');
                            }
                            /*
                            echo "<div class='box-header'>" . 
                                        "<h4 class='modal-title'>" . 
                                            "<i class='fa fa-info-circle text-primary' data-toggle='tooltip' " . 
                                            "title='En este documento puedes ver los el detalle de tu conexión.'></i>" . 
                                            "Logs de conexión" . 
                                        "</h4>" . 
                                    "</div><div class='box-body'>" . 
                                    "<table class='table table-bordered table-hover'>" . 
                                        "<tr>" . 
                                            "<!--th> <a href='" . base_url() . "data/archivo_conexion.txt' download> archivo_conexion.txt </a> </th-->" . 
                                            "<!--th> <a href='" . base_url() . "data/archivo_conexion.txt' download type='submit' class='btn btn-default' type='button'> Descargar </th-->" . 
                                        "</tr> " . 
                                    "</table>" . 
                                    "</div>";

                            fwrite($myfile, $txt);
                            fclose($myfile); */
                        }else{
                            echo "<td> <input type='input' id='re-user' class='form-control' name='re-user'> </td>";
                            echo "<td> <input type='password' id='re-pass' class='form-control' name='re-pass'> </td>";
                            echo "<td class='inactive'> <span class='circle' style='background: #f33'> </span> Inactivo </td>";
                            echo "<td> <a type='submit' class='btn-group btn btn-success btn-sm' 
                                          href='" . base_url() . "index.php/tpoadminv1/logo/logo/entrar_pnt' id='re-conectar'> Conectar </a></td>";
                                          
                            echo "</tr></tbody> </table>";
                        }
                    ?>
                </tbody>
            </table>
            </div>

            <?php if( ( isset($_SESSION['pnt']) ) and ( isset($_SESSION["pnt"]["success"]) ) and ( $_SESSION["pnt"]["success"] ) ){ ?>
                <div class="box-body"><table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="Usuario activo de PNT."></i>
                                Unidad Administrativa
                            </th>

                            <th>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title=""></i>
                                Sujeto Obligado
                            </th>
                            <th> 
                                
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        echo "  <tr>";
                        echo "    <form>";
                        echo "    <td> <input type='input' id='unidad_administrativa' class='form-control' name='unidad_administrativa' value='" . ( ( isset($_SESSION['unidad_administrativa']) )? $_SESSION["unidad_administrativa"] : '' ) . "'> </td>";
                        echo "    <td> <input type='input' id='sujeto_obligado' class='form-control' name='sujeto_obligado' value='" . ( ( isset($_SESSION['sujeto_obligado']) )? $_SESSION["sujeto_obligado"] : '' ) . "'> </td>";
                        echo "    <td> <a type='button' id='modificar_sujeto' href='" . base_url() . "index.php/tpoadminv1/logo/logo/modificar_sujeto' 
                                            class='btn-group btn btn-primary btn-sm'> <i class='fa fa-edit'></i> Actualizar datos de Sujeto Obligado </a> </td>"; 
                        echo "    </form>";
                        echo "  </tr>";
                    ?>
                    </tbody>
                </table> </div>
            <?php  } ?>
        </div>
    </div>

   

    <!-- MODAL EDITAR FECHA -->
    <div class="modal fade" id="modalEditarFecha" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content"><!-- Modal content-->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title">Fecha actualizaci&oacute;n manual</h3>
                </div><!-- ./ modal-header-->
                <div class="modal-body">
                    <form role="form" method="post" action="<?php echo base_url(); ?>index.php/tpoadminv1/logo/logo/actualizar_fecha">
                        <input type="hidden" name="id_fecha_act" id="id_fecha_act" value="" />
                        <div class="box-body">
                            <div class="form-group">
                                <label class="custom-file-label">
                                    Fecha de actualizaci&oacute;n manual:
                                </label>
                                <input type="text" id= "fecha_act" class="form-control" placeholder="Ingresa fecha actualizaci&oacute; manual" name="fecha_act" value="<?php echo set_value('fecha_act'); ?>" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label class="custom-file-label">
                                    Comentario:
                                </label>
                                <input type="text" id= "comentario_act" class="form-control" placeholder="Ingresa un comentario sobre la actualizaci&oacute;n manual" name="comentario_act" value="<?php echo set_value('comentario_act'); ?>" autocomplete="off">
                            </div>
                            <?php /*<div class="form-group">
                                    <label class="custom-file-label">
                                        Estatus:
                                    </label>
                                    <select class="form-control" name="active">
                                        <option value="0">- Selecciona -</option>
                                        <option value="a" selected="selected";>Activo</option>
                                        <option value="i">Inactivo</option>
                                    </select>
                            </div>*/ ?>
                        </div><!-- ./ box-body-->
                        <div class="box-footer">
                            <button class="btn btn-primary" type="submit">Guardar</button>
                        </div><!-- ./ box-footer-->
                    </form>   
                </div><!-- ./ modal-body-->
            </div><!-- ./ modal-content-->
        </div><!-- ./ modal-dialog-->
    </div><!-- /. modal-->

     <!-- MODAL reCAPTCHA -->
    <div class="modal fade" id="modalRecaptcha" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title">reCaptcha</h3>
                </div>
                <div class="modal-body">
                    <span>Se deben agregar correctamente las claves proporcionadas por <b>Google reCAPTCHA</b> para que funcione adecuadamente la validaci&oacute;n en el inicio de sesi&oacute;n.</span>
                    <a href="https://www.google.com/recaptcha/intro/v3.html" target="_blank"> Ir a Google reCAPTCHA</a>
                    <form role="form" method="post" action="<?php echo base_url(); ?>index.php/tpoadminv1/logo/logo/actualizar_recaptcha">
                        <input type="hidden" name="id_settings" id="id_settings" value="" />
                        <div class="box-body">
                            <div class="form-group">
                                <label class="custom-file-label">
                                    Clave del sitio:
                                    <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="Se debe obtener en Google reCAPTCHA"></i>
                                </label>
                                <input type="text" id= "recaptcha" class="form-control" placeholder="Ingresa la clave del sitio" name="recaptcha" value="" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label class="custom-file-label">
                                    Clave secreta:
                                    <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="Se debe obtener en Google reCAPTCHA"></i>
                                </label>
                                <input type="password" id= "clave" class="form-control" placeholder="Ingresa la clave secreta" name="clave" value="" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label class="custom-file-label">
                                    Estatus:
                                    <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="En activo se habilita el reCAPTCHA en el inicio de sesi&oacute;n, en inactivo se desahabilita."></i>
                                </label>
                                <select class="form-control" name="active">
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                            <div class="box-footer">
                                <button class="btn btn-primary" type="submit">Guardar</button>
                                <button class="btn btn-default" type="button" onclick="cerrarModel()">Cerrar</button>
                            </div>
                        </div>
                    </form>                       
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalPNT" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title">reCaptcha</h3>
                </div>
                <div class="modal-body">
                    <span>Se deben agregar los datos correctos de la conexión exitosa al WEB services del PNT.</span>

                    <form role="form" method="post" action="<?php echo base_url(); ?>index.php/tpoadminv1/logo/logo/entrar_pnt">
                        <input type="hidden" name="id_settings" id="id_settings" value="" />
                        <div class="box-body">
                            <div class="form-group">
                                <label class="custom-file-label">
                                    Usuario:
                                    <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="Usuario del PNT"></i>
                                </label>
                                <input type="text" id= "user" class="form-control" placeholder="Ingresa tu usuario del sitio" name="user" value="" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label class="custom-file-label">
                                    Clave Secreta:
                                    <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="Password del PNT"></i>
                                </label>
                                <input type="password" id= "password" class="form-control" placeholder="Ingresa la clave secreta" name="password" value="" autocomplete="off">
                            </div>
                            <div class="box-footer">
                                <button class="btn btn-primary" type="submit">Guardar</button>
                                <button class="btn btn-default" type="button" onclick="cerrarModel()">Cerrar</button>
                            </div>
                        </div>
                    </form>                       
                </div>
            </div>
        </div>
    </div>

    
</section>




<script type="text/javascript">
    
    var cerrarModel = function(){
        $('#modalRecaptcha').modal('hide');
    }

    var triggerClick = function(action){
        if( action == 'lanzar'){
            $("input[name='file_programa_anual']").trigger("click");
        }else if(action == 'eliminar') {
            eliminar_archivo();
        }
    }

    $('input:file').change(function (){
        upload_file();
        //upload_file_video('imagen');
    }); 

    var triggerClickDocumento = function(action){
        if( action == 'lanzar'){
            $("input[name='file_programa_imagen']").trigger("click");
        }else if(action == 'eliminar') {
            eliminar_archivo();
        }
    }


    $("a#re-conectar").on("click", function(e){
        e.preventDefault()
        $("td.inactive").prepend(
            "<img class='loading' src='<?php echo base_url(); ?>plugins/img/loading.gif'>")
        
        $.post( $(this).attr("href"), { 'user': $("#re-user").val() , 'password': $("#re-pass").val() }, 
            function(data, error){
                $("td.inactive").children(".loading").remove()
                location.reload(); 
            }
        );
        $("td.inactive").children(".loading").remove()
    })

     $("a#modificar_sujeto").on("click", function(e){
        e.preventDefault()
        if ( confirm( "El cambio de estos parámetros podría afectar el uso del módulo de PNT" + 
            "¿Esta seguro que quiere modificarlo? ") ){

            $.post( $(this).attr("href"), { 'sujeto_obligado': $("#sujeto_obligado").val(), 
                'unidad_administrativa': $("#unidad_administrativa").val() }, function(data){  
                    if(data) location.reload();
                    else console.log(data)
                }
            );
        }
    })


    $("a#desconectar").on("click", function(e){
        //$.ajaxSetup({ async: false });  
        e.preventDefault()
        $(".active").prepend("<img class='loading' src='<?php echo base_url(); ?>plugins/img/loading.gif'>")
        $.post( $(this).attr("href"), {  }, 
            function(data){ 
                $(".active").children(".loading").remove()
                location.reload(); 
            }
        );
        $(".active").children(".loading").remove()   
    })

    var upload_file = function (){
        if($("input[name='file_programa_imagen']")[0].files.length > 0){
            $('#name_file_input').val($("input[name='file_programa_imagen']")[0].files[0].name );
            $('#file_load').show();
            $('#file_by_save').hide();
            var file_data = $('#file_programa_imagen').prop('files')[0];   
            var form_data = new FormData();                  
            form_data.append('file_programa_imagen', file_data);                           
            $.ajax({
                url: '<?php echo base_url() . 'index.php/tpoadminv1/logo/logo/upload_file' ?>', // point to server-side PHP script 
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
                complete: function(){
                },
                success: function(response){
                    if(response != ''){
                        var data = $.parseJSON(response);
                        if(data[0] == 'exito'){
                            $('#file_by_save').show();
                            $('#file_saved').hide();
                            $('#file_load').hide();
                            $('#file_see').hide();
                            $('#result_upload').html('<span class="text-success">Archivo cargado correctamente</span>');
                            $('#name_file_input').val('');
                            $('#file_archivo_nombre').val('');
                            var url = $('#url_logo').val() + '?timestamp=' + new Date().getTime();
                            $('#img_logo').attr('src', url);
                        }else{
                            $('#file_by_save').show();
                            $('#file_saved').hide();
                            $('#file_load').hide();
                            $('#file_see').hide();
                            $('#result_upload').html(data[1]);
                            $('#name_file_input').val('');
                            $("input[name='file_programa_imagen']").val(null);
                            $('#name_file_imagen').val('');
                            $('#file_archivo_nombre').val(data[1]);
                        }
                    }
                },
                error: function(){
                    $('#file_by_save').show();
                    $('#file_saved').hide();
                    $('#file_load').hide();
                    $('#file_see').hide();
                    $('#result_upload').html('<span class="text-success">No fue posible subir el archivo</span>');
                    $('#name_file_input').val('');
                    $("input[name='file_programa_imagen']").val(null);
                    $('#name_file_imagen').val('');
                    $('#file_archivo_nombre').val('');
                }
            });
        }
        
    }


    var eliminar_archivo = function()
    {
        //if($('#name_file_programa_imagen').val() != ''){
        if($('#file_archivo_nombre').val() != ''){
            $('#file_by_save').hide();
            $('#file_saved').hide();
            $('#file_load').show();
            $('#file_see').hide();
            var form_data = new FormData();                  
            form_data.append('file_programa_imagen', $('#file_archivo_nombre').val());                           
            $.ajax({
                url: '<?php echo base_url() . 'index.php/tpoadminv1/logo/logo/clear_file' ?>', // point to server-side PHP script 
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
                complete: function(){
                },
                success: function(response){
                    $('#file_by_save').show();
                    $('#file_saved').hide();
                    $('#file_load').hide();
                    $('#file_see').hide();
                    $('#result_upload').html('Formatos permitidos DOC, DOCX.');
                    $('#name_file_input').val('');
                    $("input[name='file_programa_imagen']").val(null);
                    $('#name_file_imagen').val('');
                    $('#file_archivo_nombre').val('');
                },
                error: function(){
                    $('#file_by_save').hide();
                    $('#file_saved').show();
                    $('#file_load').hide();
                    $('#file_see').hide();
                    $('#result_upload').html(data[1]); 
                }
            });
        }
    }

    var editarFecha = function(id_fecha_act,fecha_act, comentarios_act)
    {
        //var html_btns = '<button type="button" class="btn btn-danger" onclick="eliminar123('+id_rel+')">Si</button>' +
        //    '<button type="button" class="btn btn-default" data-dismiss="modal">No</button>';
        $('#modalEditarFecha').find('#id_fecha_act').val(id_fecha_act);
        $('#modalEditarFecha').find('#fecha_act').val(fecha_act);
        $('#modalEditarFecha').find('#comentario_act').val(comentarios_act);
        $('#modalEditarFecha').find('#mensaje_modal').html('Modificar la fecha de actualizaci&oacute;n <b>' + fecha_act+ '</b>?');
        $('#modalEditarFecha').modal('show');
    }

    var agregarRecaptcha = function(){
        $('#modalRecaptcha').find('.modal-title').empty();
        $('#modalRecaptcha').find('.modal-title').append('<h3>Agregar reCAPTCHA</h3>');
        $('#modalRecaptcha').modal('show');
    }

    var entrarPNT = function(){
        $('#modalPNT').find('.modal-title').empty();
        $('#modalPNT').find('.modal-title').append('<h3>Entrar PNT</h3>');
        $('#modalPNT').modal('show');
    }


    var editarRecaptcha = function(id, recaptcha, clave, estatus){
        console.log('entro');
        $('#modalRecaptcha').find('#id_settings').val(id);
        $('#modalRecaptcha').find('#recaptcha').val(recaptcha);
        $('#modalRecaptcha').find('#clave').val(clave);
        $('#modalRecaptcha').find('select[name=\"active\"]').val(estatus);
        $('#modalRecaptcha').find('.modal-title').empty();
        $('#modalRecaptcha').find('.modal-title').append('<h3>Editar reCAPTCHA</h3>');
        $('#modalRecaptcha').modal('show');
    }

    var habilitarGrafica =  function(){
        loadBtn(true);
        var url = '<?php echo base_url() . 'index.php/tpoadminv1/logo/logo/habilitarGrafica' ?>';
        $.ajax({
            url: url, // point to server-side PHP script 
            dataType: 'JSON',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: '',                         
            type: 'post',
            complete: function(){
            },
            error:function(){
                loadBtn(false);
            },
            success: function(response){
                if(response == 1){
                    terminoSatisfactoriamente();
                }else{
                    loadBtn(false);
                }
            }
        });
    }

    var terminoSatisfactoriamente = function(){
        var option = $('#btnhabilitar').data('option');
        if(option == 'habilitar'){
            $('#btnhabilitar').removeClass('btn-success');
            $('#btnhabilitar').addClass('btn-danger');
            $('#btnhabilitar').empty();
            $('#btnhabilitar').append('<i class="fa fa-close"></i> Deshabilitar');
            $('#btnhabilitar').data('option', 'deshabilitar'); 
            $('#tdMensaje').html('<b>habilitada</b>');
            $('#tdMensaje').removeClass('text-danger');
            $('#tdMensaje').addClass('text-success');
        }else if(option == 'deshabilitar'){
            $('#btnhabilitar').removeClass('btn-danger');
            $('#btnhabilitar').addClass('btn-success');
            $('#btnhabilitar').empty();
            $('#btnhabilitar').append('<i class="fa fa-check"></i> Habilitar');
            $('#btnhabilitar').data('option', 'habilitar'); 
            $('#tdMensaje').html('<b>deshabilitada</b>');
            $('#tdMensaje').removeClass('text-success');
            $('#tdMensaje').addClass('text-danger');
        }
    }

    var loadBtn = function(inicio){
        var option = $('#btnhabilitar').data('option');
        var btnname = '';
        var btnnameO = '';
        var classBtn = '';
        if(option == 'habilitar'){
            btnname = 'Habilitando';
            btnnameO = 'Habilitado';
            classBtn = 'fa fa-check';
        }else if(option == 'deshabilitar'){
            btnname = 'Deshabilitando';
            btnnameO = 'Deshabilitado';
            classBtn = 'fa fa-close';
        }

        if(inicio){
            $('#btnhabilitar').empty();
            $('#btnhabilitar').append('<i class="fa fa-refresh fa-spin"></i>&nbsp;' + btnname);
        }else{
            $('#btnhabilitar').empty();
            $('#btnhabilitar').append('<i class="' + classBtn+ '"></i>&nbsp;' + btnnameO);
        }
    }

</script>

