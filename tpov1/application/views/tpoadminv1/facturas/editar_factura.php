
<?php

/* 
 * INAI TPO
 * 
 * Dic - 2018
 */

?>
<?php
    $sel_estatus = '';
    $lista_estatus = ['-Seleccione-','Activo','En Proceso','Inactivo','Pago Emitido'];
    $lista_estatus_ids = ['','1','3','2','4'];
    for($z = 0; $z < sizeof($lista_estatus_ids); $z++)
    {
        if( $lista_estatus_ids[$z] == $registro['active'] ){
            $sel_estatus .= '<option value="'.$lista_estatus_ids[$z].'" selected>' . $lista_estatus[$z] . '</option>';
        }else{
            $sel_estatus .= '<option value="'.$lista_estatus_ids[$z].'">' . $lista_estatus[$z] . '</option>';
        }
        
    }

    $nombre_ejercicio = '';
    $sel_ejercicios = '<option value="">-Seleccione-</option>';
    for($z = 0; $z < sizeof($ejercicios); $z++)
    {
        if($registro['id_ejercicio'] == $ejercicios[$z]['id_ejercicio']){
            $sel_ejercicios .= '<option value="'.$ejercicios[$z]['id_ejercicio'].'" selected>' . $ejercicios[$z]['ejercicio'] . '</option>';
            $nombre_ejercicio = $ejercicios[$z]['ejercicio'];
        }else{
            $sel_ejercicios .= '<option value="'.$ejercicios[$z]['id_ejercicio'].'">' . $ejercicios[$z]['ejercicio'] . '</option>';
        }
    }

    $sel_trimestres = '<option value="">-Seleccione-</option>';
    for($z = 0; $z < sizeof($trimestres); $z++)
    {
        if($registro['id_trimestre'] == $trimestres[$z]['id_trimestre']){
            $sel_trimestres .= '<option value="'.$trimestres[$z]['id_trimestre'].'" selected>' . $trimestres[$z]['trimestre'] . '</option>';
        }else{
            $sel_trimestres .= '<option value="'.$trimestres[$z]['id_trimestre'].'">' . $trimestres[$z]['trimestre'] . '</option>';
        }
    }
    
    $sel_proveedores = '<option value="">-Seleccione-</option>';
    for($z = 0; $z < sizeof($proveedores); $z++)
    {
        if($registro['id_proveedor'] == $proveedores[$z]['id_proveedor']){
            $sel_proveedores .= '<option value="'.$proveedores[$z]['id_proveedor'].'" selected>' . $proveedores[$z]['nombre_razon_social'] . '</option>';
        }else{
            $sel_proveedores .= '<option value="'.$proveedores[$z]['id_proveedor'].'">' . $proveedores[$z]['nombre_razon_social'] . '</option>';
        }
    }

    $sel_contratos = '<option value="0">-Seleccione-</option>';
    if(isset($contratos)){
        for($z = 0; $z < sizeof($contratos); $z++)
        {
            if($registro['id_contrato'] == $contratos[$z]['id_contrato']){
                $sel_contratos .= '<option value="'.$contratos[$z]['id_contrato'].'" selected>' . $contratos[$z]['numero_contrato'] . '</option>';
            }else{
                $sel_contratos .= '<option value="'.$contratos[$z]['id_contrato'].'">' . $contratos[$z]['numero_contrato'] . '</option>';
            }
        }
    }

    $sel_ordenes = '<option value="0">-Seleccione-</option>';
    if(isset($ordenes)){
        for($z = 0; $z < sizeof($ordenes); $z++)
        {
            if($registro['id_orden_compra'] == $ordenes[$z]['id_orden_compra']){
                $sel_ordenes .= '<option value="'.$ordenes[$z]['id_orden_compra'].'" selected>' . $ordenes[$z]['numero_orden_compra'] . '</option>';
            }else{
                $sel_ordenes .= '<option value="'.$ordenes[$z]['id_orden_compra'].'">' . $ordenes[$z]['numero_orden_compra'] . '</option>';
            }
        }
    }

    $sel_estatus2 = '';
    $lista_estatus2 = ['-Seleccione-','Activo','Inactivo'];
    $lista_estatus_ids2 = ['','1','2'];
    for($z = 0; $z < sizeof($lista_estatus_ids2); $z++)
    {
        
            if($lista_estatus_ids2[$z] == '0' ){
                $sel_estatus2 .= '<option value="'.$lista_estatus_ids2[$z].'" selected>' . $lista_estatus2[$z] . '</option>';
            }else{
                $sel_estatus2 .= '<option value="'.$lista_estatus_ids2[$z].'">' . $lista_estatus2[$z] . '</option>';
            }
        
        
    }

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
            <?php echo $this->session->flashdata('error'); $this->session->set_flashdata('error', '');?>
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
        <?php echo $this->session->flashdata('exito'); $this->session->set_flashdata('exito', '');?>
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
            <?php echo $this->session->flashdata('alert'); $this->session->set_flashdata('alert', ''); ?>
        </div>
        <?php
        }
    ?>

    <link href="<?php echo base_url(); ?>editors/tinymce/skins/lightgray/skin.min.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo base_url();?>editors/tinymce/tinymce.min.js"></script>
    <div class="row">
        <?php 
            /*** El siguiente código es para colocar la clase .validation_error cuando hay un error en el form_validate 
             * form_error regresa una cadena, si es vacía significa que no hay error, si trae texto se marca el error
             * ***/
           
            $error_ej = !empty(form_error('id_ejercicio', '<div class="text-danger">', '</div>'));
            $error_c = !empty(form_error('id_contrato', '<div class="text-danger">', '</div>'));
            $error_pe = !empty(form_error('id_proveedor', '<div class="text-danger">', '</div>'));
            $error_oc = !empty(form_error('id_orden_compra', '<div class="text-danger">', '</div>'));
            $error_t = !empty(form_error('id_trimestre', '<div class="text-danger">', '</div>'));
            $error_nf = !empty(form_error('numero_factura', '<div class="text-danger">', '</div>'));
            $error_fe = !empty(form_error('fecha_erogacion', '<div class="text-danger">', '</div>'));
            $error_active = !empty(form_error('active', '<div class="text-danger">', '</div>'));
            if(@$file_error == true )
            {
                $error_file = true; 
                $mensaje = '<p>Archivo del programa anual solo permite formatos PDF,  Word y Excel </p>';
            }

            if(validation_errors() == TRUE)
            {
                echo '<div class="alert alert-danger"><button class="close"  data-dismiss="alert">x</button>
                <h4><i class="icon fa fa-ban"></i>¡Alerta!</h4>' . validation_errors() . '</div>';  
            }
        ?>
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="<?php if(!$this->session->flashdata('tab_flag')) echo 'active' ?>">
                    <a href="#tab_1" data-toggle="tab"> Factura</a>
                <li>
                <li class="<?php if($this->session->flashdata('tab_flag')) echo 'active' ?>">
                    <a href="#tab_2" data-toggle="tab"> Detalle de factura</a>
                <li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane <?php if(!$this->session->flashdata('tab_flag')) echo 'active' ?>" id="tab_1">
                    <form role="form" method="post" autocomplete="off" action="<?php echo base_url(); ?>index.php/tpoadminv1/capturista/facturas/validate_editar_factura" enctype="multipart/form-data" >
                        <div class="box box">
                            <div class="box-header">
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <input type="hidden" value="<?php echo $registro['id_factura']; ?>" class="form-control" name="id_factura"/>
                                <input type="hidden" value="" class="form-control" id="type_file"/>
                                <input type="hidden" value="<?php echo $nombre_ejercicio?>" class="form-control" name="valor_ejercicio" id="valor_ejercicio"/>
                                <div class="form-group">
                                    <label>Ejercicio*
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_ejercicio']?>"></i>
                                    </label>
                                    <select name="id_ejercicio" class="form-control <?php if($error_ej) echo 'has-error' ?>">
                                        <?php echo $sel_ejercicios; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Proveedor*
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_proveedor']?>"></i>
                                    </label>
                                    <select name="id_proveedor" class="form-control <?php if($error_pe) echo 'has-error' ?>">
                                        <?php echo $sel_proveedores; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Contrato* 
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_contrato']?>"></i>
                                    </label>
                                    <select name="id_contrato" class="form-control <?php if($error_c) echo 'has-error' ?>">
                                        <?php echo $sel_contratos; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Orden* 
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_orden_compra']?>"></i>
                                    </label>
                                    <select name="id_orden_compra" class="form-control <?php if($error_oc) echo 'has-error' ?>">
                                        <?php echo $sel_ordenes; ?>
                                    </select>
                                </div> 
                                <div class="form-group">
                                    <label>Trimestre*
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_trimestre']?>"></i>
                                    </label>
                                    <select name="id_trimestre" class="form-control <?php if($error_t) echo 'has-error' ?>">
                                        <?php echo $sel_trimestres; ?>
                                    </select>
                                </div> 
                                <div class="form-group">
                                    <label>N&uacute;mero de factura*
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['numero_factura']?>"></i>
                                    </label>
                                    <?php $class = "form-control"; if($error_nf) $class="form-control has-error";
                                            echo form_input(array('type' => 'text', 'name' => 'numero_factura', 'value' => $registro['numero_factura'], 'class' => $class)); ?>    
                                </div>
                                <div class="form-group">
                                    <label>Fecha de erogaci&oacute;n*
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_erogacion']?>"></i>
                                    </label>
                                    <?php $class = "form-control datepicker"; if($error_fe) $class="form-control datepicker has-error";
                                        echo form_input(array('type' => 'text', 'id' => 'fecha_erogacion', 'name' => 'fecha_erogacion', 'value' => $registro['fecha_erogacion'], 'class' => $class)); ?>
                                    <input type="hidden" value="<?php echo $registro['fecha_erogacion']; ?>" name="fecha_erogacion_actual" />
                                </div>
                                <div class="form-group">
                                    <label>Hipervínculo a la factura en formato PDF
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['url_factura_pdf']?>"></i>
                                    </label>
                                    <?php $class = "form-control";
                                    	echo form_input(array('type' => 'url', 'name' => 'url_factura_pdf', 'value' => $registro['url_factura_pdf'], 'class' => $class)); ?>                                                
                                </div>                                
                                <div class="form-group"><!-- Inicio de input para el cargado de pdf-->
                                    <label class="custom-file-label"> Archivo de la factura en PDF
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['file_factura_pdf']?>"></i>
                                    </label>
                                </div>
                                <div class="input-group">
                                    <div id="file_by_save" class="input-group-btn" style="<?php if($control_update['file_by_save']) echo 'display:none;' ?>">
                                        <button class="btn btn-success" type="button" onclick="triggerClick('lanzar')">Subir archivo</button>
                                    </div>
                                    <div id="file_see" class="input-group-btn" style="<?php if($control_update['file_see']) echo 'display:none;' ?>">
                                        <button class="btn btn-info" type="button" onclick="triggerClick('ver')" >Ver archivo</button>
                                    </div>
                                    <div id="file_load" class="input-group-btn" style="<?php if($control_update['file_load']) echo 'display:none;' ?>">
                                        <button class="btn btn-success" type="button" ><i class="fa fa-refresh fa-spin"></i></button>
                                    </div>
                                    <input type="text" id="name_file_input" placeholder="Ning&uacute;n archivo seleccionado" value="<?php echo $registro['name_file_factura_pdf']; ?>"
                                            class="form-control" />
                                    <input type="hidden" id="name_file_factura_pdf" name="name_file_factura_pdf" value="<?php echo $registro['name_file_factura_pdf']; ?>" />
                                    <input type="file" name="file_factura_pdf" id="file_factura_pdf" class="hide" accept=".pdf"/>
                                    <div id="file_saved" class="input-group-btn" style="<?php if($control_update['file_saved']) echo 'display:none;' ?>">
                                        <button class="btn btn-danger" type="button" onclick="triggerClick('eliminar')" >Eliminar archivo</button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <p class="help-block" id="result_upload"><?php echo $control_update['mensaje_file']; ?> </p>
                                </div><!-- fin de input de pdf-->
                                <div class="form-group">
                                    <label>Hipervínculo a la factura en formato XML
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['url_factura_xml']?>"></i>
                                    </label>
                                    <?php $class = "form-control";
                                    	echo form_input(array('type' => 'url', 'name' => 'url_factura_xml', 'value' => $registro['url_factura_xml'], 'class' => $class)); ?>                                                
                                </div>
                                <div class="form-group"><!-- Inicio de input para el cargado de xml-->
                                    <label class="custom-file-label"> Archivo de la factura en XML
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['file_factura_xml']?>"></i>
                                    </label>
                                </div>
                                <div class="input-group">
                                    <div id="file_by_save_2" class="input-group-btn" style="<?php if($control_update_2['file_by_save_2']) echo 'display:none;' ?>">
                                        <button class="btn btn-success" type="button" onclick="triggerClick_2('lanzar')">Subir archivo</button>
                                    </div>
                                    <div id="file_see_2" class="input-group-btn" style="<?php if($control_update_2['file_see_2']) echo 'display:none;' ?>">
                                        <button class="btn btn-info" type="button" onclick="triggerClick_2('ver')" >Ver archivo</button>
                                    </div>
                                    <div id="file_load_2" class="input-group-btn" style="<?php if($control_update_2['file_load_2']) echo 'display:none;' ?>">
                                        <button class="btn btn-success" type="button" ><i class="fa fa-refresh fa-spin"></i></button>
                                    </div>
                                    <input type="text" id="name_file_input_2" placeholder="Ning&uacute;n archivo seleccionado" value="<?php echo $registro['name_file_factura_xml']; ?>"
                                            class="form-control" />
                                    <input type="hidden" id="name_file_factura_xml" name="name_file_factura_xml" value="<?php echo $registro['name_file_factura_xml']; ?>" />
                                    <input type="file" name="file_factura_xml" id="file_factura_xml" class="hide" accept=".xmls, .xml"/>
                                    <div id="file_saved_2" class="input-group-btn" style="<?php if($control_update_2['file_saved_2']) echo 'display:none;' ?>">
                                        <button class="btn btn-danger" type="button" onclick="triggerClick_2('eliminar')" >Eliminar archivo</button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <p class="help-block" id="result_upload_2"><?php echo $control_update_2['mensaje_file_2']; ?> </p>
                                </div><!-- fin de input de xml-->
                                <div class="form-group">
                                    <label>Fecha de validaci&oacute;n
                                    <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_validacion']?>"></i>
                                    </label>
                                    <?php $class = "form-control datepicker";
                                        echo form_input(array('type' => 'text', 'id' => 'fecha_validacion', 'name' => 'fecha_validacion', 'value' => $registro['fecha_validacion'], 'class' => $class)); ?>
                                </div>
                                <div class="form-group">
                                    <label>&Aacute;rea responsable de la informaci&oacute;n
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['area_responsable']?>"></i>
                                    </label>
                                    <?php $class = "form-control";
                                        echo form_input(array('type' => 'text', 'name' => 'area_responsable', 'value' => $registro['area_responsable'], 'class' => $class)); ?>
                                </div>
                                <div class="form-group">
                                    <label>A&ntilde;o
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['periodo']?>"></i>
                                    </label>
                                    <?php $class = "form-control";
                                        echo form_input(array('type' => 'text', 'name' => 'periodo', 'value' => $registro['periodo'], 'class' => $class)); ?>
                                </div>
                                <div class="form-group">
                                    <label>Fecha de actualizaci&oacute;n
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_actualizacion']?>"></i>
                                    </label>
                                    <?php $class = "form-control datepicker";
                                        echo form_input(array('type' => 'text', 'name' => 'fecha_actualizacion', 'value' => $registro['fecha_actualizacion'], 'class' => $class)); ?>
                                </div>
                                <div class="form-group">
                                    <label>Nota
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['nota']?>"></i>
                                    </label>
                                    <textarea class="form-control" name="nota" id="nota"><?php echo $registro['nota']; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Estatus*
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['active']?>"></i>
                                    </label>
                                    <select class="form-control" name="active" class="form-control <?php if($error_active) echo 'has-error' ?>">
                                        <?php echo $sel_estatus; ?>
                                    </select>
                                </div> 
                            </div><!-- /.box-body -->
                            <div class="box-footer">
                                <button class="btn btn-primary" type="submit">Guardar</button>
                                <?php echo anchor("tpoadminv1/capturista/facturas/busqueda_facturas", "<button class='btn btn-default' type='button'>Regresar</button></td>"); ?>
                            </div>     
                        </div><!-- /.box -->    
                    </form>
                </div>
                <div class="tab-pane <?php if($this->session->flashdata('tab_flag')) echo 'active' ?>" id="tab_2">
                    <div class="box box table-responsive">
                        <div class="box-header">
                            <div class="pull-left">
                                <?php echo anchor("tpoadminv1/capturista/facturas/agregar_factura_desglose/". $registro['id_factura'] , "<button class='btn btn-success'><i class=\"fa fa-plus-circle\"></i> Agregar</button></td>"); ?>
                                <?php echo anchor("tpoadminv1/capturista/facturas/busqueda_facturas", "<button class='btn btn-default' type='button'>Regresar</button></td>"); ?>

                                <br/>
                                <br/>
                                <form role="form" method="post" autocomplete="off" action="<?php echo base_url(); ?>index.php/tpoadminv1/capturista/facturas/validate_editar_status_factura_desglose" enctype="multipart/form-data" >
                                    <input type="hidden" value="<?php echo $registro['id_factura']; ?>" class="form-control" name="id_factura"/>
                                    <div class="form-group">
                                        <label style="margin-left: 25px;">Estatus*
                                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['active']?>"></i>
                                        </label>
                                        <select class="form-control" name="active" class="form-control <?php if($error_active) echo 'validation-error' ?>">
                                            <?php echo $sel_estatus2; ?>
                                        </select>
                                        <br/>
                                        <button class="btn btn-primary" type="submit">Guardar</button>
                                    </div> 
                                </form>
                            </div>
                            <div class="pull-right">
                                <a class="btn btn-default" <?php echo $print_onclick   ?>><i class="fa fa-print"></i> Imprimir</a>
                                <a class="btn btn-default" href="<?php echo base_url() . $path_file_csv ?>" download="<?php echo $name_file_csv ?>"><i class="fa fa-file"></i> Exportar a Excel</a>
                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <table id="detalle_facturas" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Campa&ntilde;a o aviso institucional <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_campana_aviso']?>"></i></th>
                                        <th>Monto subconcepto <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['monto_desglose']?>"></i></th>
                                        <th>Estatus <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['active']?>"></i></th>
                                        <th style="width: 10px;"></th>
                                        <th style="width: 10px;"></th>
                                        <th style="width: 10px;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $c_replace = array('\'', '"');
                                    for($z = 0; $z < sizeof($registros); $z++)
                                    {
                                        echo '<tr>';
                                        echo '<td>' . $registros[$z]['id'] . '</td>';
                                        echo '<td>' . $registros[$z]['nombre_campana_aviso'] . '</td>';
                                        echo '<td>' . $registros[$z]['monto_subconcepto'] . '</td>';
                                        echo '<td>' . $registros[$z]['active'] . '</td>';
                                        echo "<td> <span class='btn-group btn btn-info btn-sm' onclick=\"abrirModal(" . $registros[$z]['id_factura_desglose'] . ")\"> <i class='fa fa-search'></i></span></td>";
                                        echo '<td>' . anchor("tpoadminv1/capturista/facturas/editar_factura_desglose/".$registros[$z]['id_factura_desglose'] . "/" . $registros[$z]['id_factura'], "<button class='btn btn-warning btn-sm' title='Editar'><i class=\"fa fa-edit\"></i></button></td>"); 
                                        echo "<td> <span class='btn-group btn btn-danger btn-sm' onclick=\"eliminarModal(" . $registros[$z]['id_factura_desglose'] . ", ". $registros[$z]['id_factura'] . ", '" . str_replace($c_replace, "", $registros[$z]['monto_subconcepto']) . "')\"> <i class='fa fa-close'></i></span></td>";
                                        
                                        echo '</tr>';
                                    }
                                ?>
                                </tbody>
                            </table>
                        </div> <!-- /. box-body -->
                    </div><!-- /. box-->
                </div>
            </div>
        </div><!-- nav-tabs-custom -->
    </div>
</section>

<!-- Modal Details-->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">Detalle </h3>
        </div>
        <div class="modal-body">
            <div id="loading_modal" ></div>
            <table id="table_modal" class="table form-horizontal">
                <tbody> 
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Campa&ntilde;a o aviso institucional* </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_campana_aviso']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_1"></td>
                    </tr>   
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Clasificaci&oacute;n del servicio* </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_servicio_clasificacion']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_2"></td>
                    </tr> 
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Categor&iacute;a del servicio* </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_servicio_categoria']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_3"></td>
                    </tr>
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Subcategor&iacute;a del servicio*</b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_servicio_subcategoria']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_4"></td>
                    </tr>
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Unidad* </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_servicio_unidad']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_5"></td>
                    </tr>
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Sujeto obligado contratante*</b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_so_contratante']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_6"></td>
                    </tr> 
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Partida de contratante* </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_presupuesto_concepto']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_7"></td>
                    </tr>
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Sujeto obligado solicitante*</b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_so_solicitante']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_8"></td>
                    </tr> 
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Partida de solicitante* </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_presupuesto_concepto_solicitante']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_9"></td>
                    </tr>    
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>&Aacute;rea administrativa encargada de solicitar el servicio</b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['area_administrativa']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_10"></td>
                    </tr>
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Descripci&oacute;n del servicio o producto adquirido</b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['descripcion_servicios']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_11"></td>
                    </tr>
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Cantidad*</b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['cantidad']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_12"></td>
                    </tr>
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Precio unitario con I.V.A. incluido*</b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['precio_unitarios']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_13"></td>
                    </tr>
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Fecha de validaci&oacute;n </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_validacion']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_14"></td>
                    </tr>
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Área responsable de la informaci&oacute;n </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['area_responsable']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_15"></td>
                    </tr>      
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>A&ntilde;o </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['periodo']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_16"></td>
                    </tr> 
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Fecha de actualizaci&oacute;n </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_actualizacion']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_17"></td>
                    </tr>   
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Nota </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['nota']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_18"></td>
                    </tr> 
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Estatus*</b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['active']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_19"></td>
                    </tr>           
                </tbody>
            </table> 
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModalDelete" role="dialog">
    <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">Eliminar registro</h3>
        </div>
        <div class="modal-body">
            <div id="mensaje_modal">
                ¿Desea eliminar el registro?
            </div>
        </div>
        <div class="modal-footer" id="footer_btns">
            
        </div>
        </div>
    </div>
</div>

<script type="text/javascript">


    var get_contratos = function()
    {
        var form_data = new FormData();                  
        form_data.append('id_ejercicio', $('select[name="id_ejercicio"]').val());
        form_data.append('id_proveedor', $('select[name="id_proveedor"]').val());
        var url = '<?php echo base_url() . 'index.php/tpoadminv1/capturista/contratos/get_contratos_filtro' ?>';

        buscar_catalogos(url, form_data, set_contratos);
    }

    var get_ordenes = function()
    {
        var form_data = new FormData();                  
        form_data.append('id_ejercicio', $('select[name="id_ejercicio"]').val());
        form_data.append('id_proveedor', $('select[name="id_proveedor"]').val());
        form_data.append('id_contrato', $('select[name="id_contrato"]').val());
        var url = '<?php echo base_url() . 'index.php/tpoadminv1/capturista/ordenes_compra/get_ordenes_compra_filtro' ?>';
        buscar_catalogos(url, form_data, set_ordenes);
    }

    var set_ordenes = function(response)
    {
        var options = '<option value="0">-Seleccione-</option>';
        if(response && response[0] == '['){
            var data = $.parseJSON(response);
            if($.isArray(data)){
                var i;
                if(data.length == 1) //para poner el valor por default
                    options = ''
                for (i = 0; i < data.length; i++) { 
                    options += "<option value=" + data[i]['id_orden_compra'] + ">" + data[i]['numero_orden_compra'] + "</option>";
                }
            }
        }
        $('select[name="id_orden_compra"]').empty();
        $('select[name="id_orden_compra"]').append(options);
    }

    var set_contratos = function(response)
    {
        var options = '<option value="0">-Seleccione-</option>';
        if(response && response[0] == '['){
            var data = $.parseJSON(response);
            if($.isArray(data)){
                var i;
                if(data.length == 1) //para poner el sin contrato por default
                    options = ''
                for (i = 0; i < data.length; i++) { 
                    options += "<option value=" + data[i]['id_contrato'] + ">" + data[i]['numero_contrato'] + "</option>";
                }
            }
        }
        $('select[name="id_contrato"]').empty();
        $('select[name="id_contrato"]').append(options);
    }

    var set_proveedor_id = function(id){
        if(id !== undefined && id !== 'undefined' && id != null && id != ''){
            $('select[name=\"id_proveedor\"]').val(id);
        }    
    }
    
    var buscar_catalogos = function(url_server, formData, callback){
                                   
        $.ajax({
            url: url_server, // point to server-side PHP script 
            dataType: 'text',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: formData,                         
            type: 'post',
            complete: function(){
            },
            success: function(response){
                if(response && callback){
                    callback(response);
                }
            }
        });
    }

    var upload_file = function (){
        if($("input[name='file_factura_pdf']")[0].files.length > 0){
            $('#name_file_input').val($("input[name='file_factura_pdf']")[0].files[0].name );
            $('#file_load').show();
            $('#file_by_save').hide();
            var file_data = $('#file_factura_pdf').prop('files')[0];   
            var form_data = new FormData();                  
            form_data.append('file', file_data);
            form_data.append('type', 'file_factura_pdf');                           
            $.ajax({
                url: '<?php echo base_url() . 'index.php/tpoadminv1/capturista/facturas/upload_file' ?>', // point to server-side PHP script 
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
                            $('#file_by_save').hide();
                            $('#file_saved').show();
                            $('#file_load').hide();
                            $('#file_see').hide();
                            $('#result_upload').html('<span class="text-success">Archivo cargado correctamente</span>');
                            $('#name_file_factura_pdf').val(data[1]);
                            $('#name_file_input').val(data[1]);
                            
                        }else{
                            $('#file_by_save').show();
                            $('#file_saved').hide();
                            $('#file_load').hide();
                            $('#file_see').hide();
                            $('#result_upload').html(data[1]);
                            $('#name_file_input').val('');
                            $("input[name='file_factura_pdf']").val(null);
                            $('#name_file_factura_pdf').val('');
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
                    $("input[name='file_factura_pdf']").val(null);
                    $('#name_file_factura_pdf').val('');
                }
            });
        }
        
    } 

    var eliminar_archivo = function()
    {
        if($('#name_file_factura_pdf').val() != ''){
            $('#file_by_save').hide();
            $('#file_saved').hide();
            $('#file_load').show();
            $('#file_see').hide();
            var form_data = new FormData();                  
            form_data.append('file', $('#name_file_factura_pdf').val());                        
            $.ajax({
                url: '<?php echo base_url() . 'index.php/tpoadminv1/capturista/facturas/clear_file' ?>', // point to server-side PHP script 
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
                complete: function(){
                },
                success: function(response){
                    var data = $.parseJSON(response);
                    if(data[0] == 'exito'){
                        $('#file_by_save').show();
                        $('#file_saved').hide();
                        $('#file_load').hide();
                        $('#file_see').hide();
                        $('#result_upload').html('Formato permitido PDF. ');
                        $('#name_file_input').val('');
                        $("input[name='file_factura_pdf']").val(null);
                        $('#name_file_factura_pdf').val('');
                    }else{
                        $('#file_by_save').hide();
                        $('#file_saved').show();
                        $('#file_load').hide();
                        $('#file_see').hide();
                        $('#result_upload').html(data[1]); 
                    }
                    
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

    var triggerClick = function(action){
        if( action == 'lanzar'){
            $('#type_file').val('pdf');
            $("input[name='file_factura_pdf']").trigger("click");
        }else if(action == 'eliminar') {
            eliminar_archivo();
        }
    }

    var upload_file_2 = function (){
        if($("input[name='file_factura_xml']")[0].files.length > 0){
            $('#name_file_input_2').val($("input[name='file_factura_xml']")[0].files[0].name );
            $('#file_load_2').show();
            $('#file_by_save_2').hide();
            var file_data = $('#file_factura_xml').prop('files')[0];   
            var form_data = new FormData();                  
            form_data.append('file', file_data);
            form_data.append('type', 'file_factura_xml');                           
            $.ajax({
                url: '<?php echo base_url() . 'index.php/tpoadminv1/capturista/facturas/upload_file' ?>', // point to server-side PHP script 
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
                            $('#file_by_save_2').hide();
                            $('#file_saved_2').show();
                            $('#file_load_2').hide();
                            $('#file_see_2').hide();
                            $('#result_upload_2').html('<span class="text-success">Archivo cargado correctamente</span>');
                            $('#name_file_factura_xml').val(data[1]);
                            $('#name_file_input_2').val(data[1]);
                            
                        }else{
                            $('#file_by_save_2').show();
                            $('#file_saved_2').hide();
                            $('#file_load_2').hide();
                            $('#file_see_2').hide();
                            $('#result_upload_2').html(data[1]);
                            $('#name_file_input_2').val('');
                            $("input[name='file_factura_xml']").val(null);
                            $('#name_file_factura_xml').val('');
                        }
                    }
                },
                error: function(){
                    $('#file_by_save_2').show();
                    $('#file_saved_2').hide();
                    $('#file_load_2').hide();
                    $('#file_see_2').hide();
                    $('#result_upload_2').html('<span class="text-success">No fue posible subir el archivo</span>');
                    $('#name_file_input_2').val('');
                    $("input[name='file_factura_xml']").val(null);
                    $('#name_file_factura_xml').val('');
                }
            });
        }
        
    } 

    var eliminar_archivo_2 = function()
    {
        if($('#name_file_factura_xml').val() != ''){
            $('#file_by_save_2').hide();
            $('#file_saved_2').hide();
            $('#file_load_2').show();
            $('#file_see_2').hide();
            var form_data = new FormData();                  
            form_data.append('file', $('#name_file_factura_xml').val());                        
            $.ajax({
                url: '<?php echo base_url() . 'index.php/tpoadminv1/capturista/facturas/clear_file' ?>', // point to server-side PHP script 
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
                complete: function(){
                },
                success: function(response){
                    var data = $.parseJSON(response);
                    if(data[0] == 'exito'){
                        $('#file_by_save_2').show();
                        $('#file_saved_2').hide();
                        $('#file_load_2').hide();
                        $('#file_see_2').hide();
                        $('#result_upload_2').html('Formato permitido XML. ');
                        $('#name_file_input_2').val('');
                        $("input[name='file_factura_xml']").val(null);
                        $('#name_file_factura_xml').val('');
                    }else{
                        $('#file_by_save_2').hide();
                        $('#file_saved_2').show();
                        $('#file_load_2').hide();
                        $('#file_see_2').hide();
                        $('#result_upload_2').html(data[1]); 
                    }
                    
                },
                error: function(){
                    $('#file_by_save_2').hide();
                    $('#file_saved_2').show();
                    $('#file_load_2').hide();
                    $('#file_see_2').hide();
                    $('#result_upload_2').html(data[1]); 
                }
            });
        }
    }

    var triggerClick_2 = function(action){
        if( action == 'lanzar'){
            $('#type_file').val('xml');
            $("input[name='file_factura_xml']").trigger("click");
        }else if(action == 'eliminar') {
            eliminar_archivo_2();
        }
    }

    var eliminarModal = function(id, id2, name){
        var html_btns = '<button type="button" class="btn btn-danger" onclick="eliminar('+id+','+ id2 +')">Si</button>' +
                   '<button type="button" class="btn btn-default" data-dismiss="modal">No</button>';
        $('#myModalDelete').find('#footer_btns').html(html_btns);
        $('#myModalDelete').find('#mensaje_modal').html('¿Desea eliminar la factura desglose <b>' + name+ '</b>?');
        $('#myModalDelete').modal('show');
    }

    var eliminar = function (id, id2){
        window.location.href = '<?php echo base_url() . 'index.php/tpoadminv1/capturista/facturas/eliminar_factura_desglose' ?>' + '/' + id + '/' + id2;
    }

    var abrirModal = function(id){

        $.ajax({
            url: '<?php echo base_url() . 'index.php/tpoadminv1/capturista/facturas/get_factura_desglose/' ?>'+id,
            data: {action: 'test'},
            dataType:'JSON',
            beforeSend: function () {
                //Loading('Buscando');
                $('#myModal').find('#loading_modal').html('<span><i class="fa fa-spinner"><i> Cargando...</span>'); 
            },
            complete: function () {
                //Loading();
                $('#myModal').find('#loading_modal').html(''); 
            },
            error:function () {
                $('#myModal').modal('hide');
            },
            success: function (response) {
                if(response){
                    $('#myModal').find('#item_1').html(response.nombre_campana_aviso);
                    $('#myModal').find('#item_2').html(response.nombre_servicio_clasificacion);
                    $('#myModal').find('#item_3').html(response.nombre_servicio_categoria);
                    $('#myModal').find('#item_4').html(response.nombre_servicio_subcategoria);
                    $('#myModal').find('#item_5').html(response.nombre_servicio_unidad);
                    $('#myModal').find('#item_6').html(response.nombre_so_contratante);
                    $('#myModal').find('#item_7').html(response.nombre_presupuesto_concepto);
                    $('#myModal').find('#item_8').html(response.nombre_so_solicitante);
                    $('#myModal').find('#item_9').html(response.nombre_presupuesto_concepto_solicitante);
                    $('#myModal').find('#item_10').html(response.area_administrativa);
                    $('#myModal').find('#item_11').html(response.descripcion_servicios);
                    $('#myModal').find('#item_12').html(response.cantidad);
                    $('#myModal').find('#item_13').html(response.monto_desglose_format);
                    $('#myModal').find('#item_14').html(response.fecha_validacion);
                    $('#myModal').find('#item_15').html(response.area_responsable);
                    $('#myModal').find('#item_16').html(response.periodo);
                    $('#myModal').find('#item_17').html(response.fecha_actualizacion);
                    $('#myModal').find('#item_18').html(response.nota);
                    $('#myModal').find('#item_19').html(response.estatus);
                    
                    $('#myModal').modal('show'); 
                }
            }
    });
}

var limitar_fecha = function(container){
        
        var ejercicio = $('select[name="id_ejercicio"] option:selected').text();
        var anio = anio_fecha(container);
        
        var inicio = $('select[name="id_ejercicio"] option:selected').text() +'/01/01';
        var fin = $('select[name="id_ejercicio"] option:selected').text() +'/12/31';
        var defaultDate = '01.01.' + $('select[name="id_ejercicio"] option:selected').text();

        jQuery.datetimepicker.setLocale('es');
        if(ejercicio != '' && ejercicio != null && ejercicio != '-Seleccione-'){
            if(anio == ejercicio){
                defaultDate = $(container).val();
            }
            
            $('#valor_ejercicio').val(ejercicio);

            jQuery(container).datetimepicker({
                timepicker:false,
                defaultDate: defaultDate,
                minDate: inicio,
                maxDate: fin,
                format:'d.m.Y',
                scrollInput: false
            });
        }else{
            jQuery(container).datetimepicker({
                timepicker:false,
                format:'d.m.Y',
                scrollInput: false
            });
        }
    }

    var anio_fecha = function(container){
        var fecha = $(container).val();
        if(fecha != '' && fecha != null){
            var aux = fecha.split('.');
            if(aux.length == 3){
                return aux[2];
            }
        }
        return '';
    }

</script>

<?php $this->session->set_flashdata('tab_flag', ''); //se limpia la bandera ?>