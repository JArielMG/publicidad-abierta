
<?php

/* 
 * INAI TPO
 */

?>
<?php
    $sel_estatus = '';
    $lista_estatus = ['-Seleccione-','Activo','Inactivo'];
    $lista_estatus_ids = ['','1','2'];
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

    $sel_procedimientos = '<option value="">-Seleccione-</option>';
    for($z = 0; $z < sizeof($procedimientos); $z++)
    {
        if($registro['id_procedimiento'] == $procedimientos[$z]['id_procedimiento']){
            $sel_procedimientos .= '<option value="'.$procedimientos[$z]['id_procedimiento'].'" selected>' . $procedimientos[$z]['nombre_procedimiento'] . '</option>';
        }else{
            $sel_procedimientos .= '<option value="'.$procedimientos[$z]['id_procedimiento'].'">' . $procedimientos[$z]['nombre_procedimiento'] . '</option>';
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

    $sel_so_contratantes = '<option value="">-Seleccione-</option>';
    for($z = 0; $z < sizeof($so_contratantes); $z++)
    {
        if($registro['id_so_contratante'] == $so_contratantes[$z]['id_sujeto_obligado']){
            $sel_so_contratantes .= '<option value="'.$so_contratantes[$z]['id_sujeto_obligado'].'" selected>' . $so_contratantes[$z]['nombre_sujeto_obligado'] . '</option>';
        }else{
            $sel_so_contratantes .= '<option value="'.$so_contratantes[$z]['id_sujeto_obligado'].'">' . $so_contratantes[$z]['nombre_sujeto_obligado'] . '</option>';
        }
    }

    $sel_so_solicitantes = '<option value="">-Seleccione-</option>';
    for($z = 0; $z < sizeof($so_solicitantes); $z++)
    {
        if($registro['id_so_solicitante'] == $so_solicitantes[$z]['id_sujeto_obligado']){
            $sel_so_solicitantes .= '<option value="'.$so_solicitantes[$z]['id_sujeto_obligado'].'" selected>' . $so_solicitantes[$z]['nombre_sujeto_obligado'] . '</option>';
        }else{
            $sel_so_solicitantes .= '<option value="'.$so_solicitantes[$z]['id_sujeto_obligado'].'">' . $so_solicitantes[$z]['nombre_sujeto_obligado'] . '</option>';
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
           
            $error_p = !empty(form_error('id_procedimiento', '<div class="text-danger">', '</div>'));
            $error_ej = !empty(form_error('id_ejercicio', '<div class="text-danger">', '</div>'));
            $error_pe = !empty(form_error('id_proveedor', '<div class="text-danger">', '</div>'));
            $error_t = !empty(form_error('id_trimestre', '<div class="text-danger">', '</div>'));
            $error_so_c = !empty(form_error('id_so_contratante', '<div class="text-danger">', '</div>'));
            $error_so_s = !empty(form_error('id_so_solicitante', '<div class="text-danger">', '</div>'));
            $error_nc = !empty(form_error('numero_contrato', '<div class="text-danger">', '</div>'));
            $error_oc = !empty(form_error('objeto_contrato', '<div class="text-danger">', '</div>'));
            $error_dj = !empty(form_error('descripcion_justificacion', '<div class="text-danger">', '</div>'));
            $error_fj = !empty(form_error('fundamento_juridico', '<div class="text-danger">', '</div>'));
            $error_fc = !empty(form_error('fecha_celebracion', '<div class="text-danger">', '</div>'));
            $error_fi = !empty(form_error('fecha_inicio', '<div class="text-danger">', '</div>'));
            $error_ff = !empty(form_error('fecha_fin', '<div class="text-danger">', '</div>'));
            $error_cm = !empty(form_error('monto_contrato', '<div class="text-danger">', '</div>'));
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
            
                    <!-- custom tabs-->
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="<?php if(!$this->session->flashdata('tab_flag')) echo 'active' ?>">
                                <a href="#tab_1" data-toggle="tab"> Contrato</a>
                            <li>
                            <li class="<?php if($this->session->flashdata('tab_flag')) echo 'active' ?>">
                                <a href="#tab_2" data-toggle="tab"> Convenios modificatorios</a>
                            <li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane <?php if(!$this->session->flashdata('tab_flag')) echo 'active' ?>" id="tab_1">
                                <form role="form" method="post" autocomplete="off" action="<?php echo base_url(); ?>index.php/tpoadminv1/capturista/contratos/validate_editar_contrato/" enctype="multipart/form-data" >
                                    <div class="box">
                                        <div class="box-header">
                                        </div><!-- /.box-header -->
                                        <div class="box-body">
                                            <input type="hidden" value="<?php echo $registro['id_contrato']; ?>" class="form-control" name="id_contrato"/>
                                            <input type="hidden" value="<?php echo $nombre_ejercicio?>" class="form-control" name="valor_ejercicio" id="valor_ejercicio"/>
                                            <div class="form-group">
                                                <label>Procedimiento* 
                                                    <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_procedimiento']?>"></i>
                                                </label>
                                                <select name="id_procedimiento" class="form-control <?php if($error_p) echo 'has-error' ?>">
                                                    <?php echo $sel_procedimientos; ?>
                                                </select>
                                            </div> 
                                            <div class="form-group">
                                                <label>Nombre o raz&oacute;n social del proveedor*
                                                    <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_proveedor']?>"></i>
                                                </label>
                                                <select name="id_proveedor" class="form-control <?php if($error_pe) echo 'has-error' ?>">
                                                    <?php echo $sel_proveedores; ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Ejercicio*
                                                    <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_ejercicio']?>"></i>
                                                </label>
                                                <select name="id_ejercicio" class="form-control <?php if($error_ej) echo 'has-error' ?>">
                                                    <?php echo $sel_ejercicios; ?>
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
                                                <label>Sujeto obligado contratante*
                                                    <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_so_contratante']?>"></i>
                                                </label>
                                                <select name="id_so_contratante" class="form-control <?php if($error_so_c) echo 'has-error' ?>">
                                                    <?php echo $sel_so_contratantes; ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Sujeto obligado Solicitante*
                                                    <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_so_solicitante']?>"></i>
                                                </label>
                                                <select name="id_so_solicitante" class="form-control <?php if($error_so_s) echo 'has-error' ?>">
                                                    <?php echo $sel_so_solicitantes; ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>N&uacute;mero de contrato*
                                                    <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['numero_contrato']?>"></i></label>
                                                    <?php $class = "form-control"; if($error_nc) $class="form-control has-error";
                                                        echo form_input(array('type' => 'text', 'name' => 'numero_contrato', 'value' => $registro['numero_contrato'], 'class' => $class)); ?>
                                            </div>
                                            <div class="form-group <?php if($error_dj) echo 'has-error' ?>">
                                                <label>Objeto del contrato*
                                                    <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['objeto_contrato']?>"></i>
                                                </label>
                                                <textarea class="form-control <?php if($error_oc) echo 'has-error' ?>" name="objeto_contrato" id="objeto_contrato"><?php echo $registro['objeto_contrato']; ?></textarea>
                                            </div>
                                            <div class="form-group <?php if($error_dj) echo 'has-error' ?>">
                                                <label>Descripci&oacute;n*
                                                    <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['descripcion_justificacion']?>"></i>
                                                </label>
                                                <textarea class="form-control" name="descripcion_justificacion" id="descripcion_justificacion"><?php echo $registro['descripcion_justificacion']; ?></textarea>
                                            </div>
                                            <div class="form-group <?php if($error_fj) echo 'has-error' ?>">
                                                <label>Fundamento jur&iacute;dico*
                                                    <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fundamento_juridico']?>"></i>
                                                </label>
                                                <textarea class="form-control " name="fundamento_juridico" id="fundamento_juridico"><?php echo $registro['fundamento_juridico']; ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Fecha de celebraci&oacute;n*
                                                    <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_celebracion']?>"></i>
                                                </label>
                                                <?php $class = "form-control datepicker"; if($error_fc) $class="form-control datepicker has-error";
                                                    echo form_input(array('type' => 'text', 'id' => 'fecha_celebracion', 'name' => 'fecha_celebracion', 'value' => $registro['fecha_celebracion'], 'class' => $class)); ?>
                                            </div>
                                            <div class="form-group">
                                                <label>Fecha de inicio*
                                                    <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_inicio']?>"></i>
                                                </label>
                                                <?php $class = "form-control datepicker"; if($error_fi) $class="form-control datepicker has-error";
                                                    echo form_input(array('type' => 'text', 'name' => 'fecha_inicio', 'value' => $registro['fecha_inicio'], 'class' => $class)); ?>
                                            </div>
                                            <div class="form-group">
                                                <label>Fecha de t&eacute;rmino*
                                                    <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_fin']?>"></i>
                                                </label>
                                                <?php $class = "form-control datepicker"; if($error_ff) $class="form-control datepicker has-error";
                                                    echo form_input(array('type' => 'text', 'name' => 'fecha_fin', 'value' => $registro['fecha_fin'], 'class' => $class)); ?>
                                            </div>
                                            <div class="form-group">
                                                <label>Monto original del contrato*
                                                    <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['monto_contrato']?>"></i></label>
                                                    <?php $class = "form-control"; if($error_cm) $class = "form-control has-error";
                                                        echo form_input(array('type' => 'number', 'step'=>'0.01', 'name' => 'monto_contrato', 'value' => $registro['monto_contrato'], 'class' => $class)); ?>
                                            </div>
						                    <div class="form-group <?php if($error_dj) echo 'has-error' ?>">
                                                <label>Hipervínculo al contrato firmado 
                                                    <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['url_contrato']?>"></i>
                                                </label>
                                                <?php $class = "form-control";
                                                    echo form_input(array('type' => 'url', 'name' => 'url_contrato', 'value' => $registro['url_contrato'], 'class' => $class)); ?>                                                
                                            </div>
                                            <div class="form-group">
                                                <label class="custom-file-label"> Archivo del contrato en PDF
                                                    <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['file_contrato']?>"></i>
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
                                                <input type="text" id="name_file_input" placeholder="Ning&uacute;n archivo seleccionado" value="<?php echo $registro['name_file_contrato']; ?>"
                                                        class="form-control" />
                                                <input type="hidden" id="name_file_contrato" name="name_file_contrato" value="<?php echo $registro['name_file_contrato']; ?>" />
                                                <input type="file" name="file_contrato" id="file_contrato" class="hide" accept=".pdf"/>
                                                <div id="file_saved" class="input-group-btn" style="<?php if($control_update['file_saved']) echo 'display:none;' ?>">
                                                    <button class="btn btn-danger" type="button" onclick="triggerClick('eliminar')" >Eliminar archivo</button>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <p class="help-block" id="result_upload"><?php echo $control_update['mensaje_file']; ?> </p>
                                            </div>
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
                                            <div class="form-group">
                                                <label>Monto modificado
                                                    <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['monto_modificado']?>"></i>
                                                </label>
                                                <p><?php echo $registro['monto_modificado']; ?><p>
                                                <input type="hidden" name="monto_modificado" value="<?php echo $registro['monto_modificado']; ?>" >
                                            </div>
                                            <div class="form-group">
                                                <label>Monto total
                                                    <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['monto_total']?>"></i>
                                                </label>
                                                <p><?php echo $registro['monto_total']; ?><p>
                                                <input type="hidden" name="monto_total" value="<?php echo $registro['monto_total']; ?>" >
                                            </div>
                                            <div class="form-group">
                                                <label>Monto pagado a la fecha
                                                    <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['monto_pagado_a_la_fecha']?>"></i>
                                                </label>
                                                <p><?php echo $registro['monto_pagado']; ?><p>
                                                <input type="hidden" name="monto_pagado" value="<?php echo $registro['monto_pagado']; ?>" >
                                            </div>
                                        </div><!-- /.box-body -->
                                        <div class="box-footer">
                                            <button class="btn btn-primary" type="submit">Guardar</button>
                                            <?php echo anchor("tpoadminv1/capturista/contratos/busqueda_contratos", "<button class='btn btn-default' type='button'>Regresar</button></td>"); ?>
                                        </div>     
                                    </div><!-- /.box -->
                                </form>
                            </div>
                            <div class="tab-pane <?php if($this->session->flashdata('tab_flag')) echo 'active' ?>" id="tab_2">
                                <div class="box">
                                    <div class="box-header">
                                        <?php echo anchor("tpoadminv1/capturista/contratos/agregar_convenio_modificatorio/" . $registro['id_contrato'] , "<button class='btn btn-success'><i class=\"fa fa-plus-circle\"></i> Agregar</button></td>"); ?>
                                        <?php echo anchor("tpoadminv1/capturista/contratos/busqueda_contratos", "<button class='btn btn-default' type='button'>Regresar</button></td>"); ?>
                                        <div class="pull-right">
                                            <a class="btn btn-default" <?php echo $print_onclick   ?>><i class="fa fa-print"></i> Imprimir</a>
                                            <a class="btn btn-default" href="<?php echo base_url() . $path_file_csv ?>" download="<?php echo $name_file_csv ?>"><i class="fa fa-file"></i> Exportar a Excel</a>
                                        </div>
                                    </div><!-- /.box-header -->
                                    
                                    <div class="box-body">
                                        <table id="convenios" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Ejercicio  <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_ejercicio']?>"></i></th>
                                                    <th>Trimestre <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_trimestre']?>"></i></th>
                                                    <th>Convenio modificatorio <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['numero_convenio']?>"></i></th>
                                                    <th>Monto <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['monto_convenio']?>"></i></th>
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
                                                        echo '<td>' . $registros[$z]['ejercicio'] . '</td>';
                                                        echo '<td>' . $registros[$z]['trimestre'] . '</td>';
                                                        echo '<td>' . $registros[$z]['numero_convenio'] . '</td>';
                                                        echo '<td>' . $registros[$z]['monto_convenio'] . '</td>';
                                                        echo '<td>' . $registros[$z]['active'] . '</td>';
                                                        echo "<td> <span class='btn-group btn btn-info btn-sm' onclick=\"abrirModal(" . $registros[$z]['id_convenio_modificatorio'] . ")\"> <i class='fa fa-search'></i></span></td>";
                                                        echo '<td>' . anchor("tpoadminv1/capturista/contratos/editar_convenio_modificatorio/".$registros[$z]['id_convenio_modificatorio'], "<button class='btn btn-warning btn-sm' title='Editar'><i class=\"fa fa-edit\"></i></button></td>"); 
                                                        echo "<td> <span class='btn-group btn btn-danger btn-sm' onclick=\"eliminarModal(" . $registros[$z]['id_convenio_modificatorio'] . ", ". $registro['id_contrato'] . ", '". str_replace($c_replace, "", $registros[$z]['numero_convenio']) . "')\"> <i class='fa fa-close'></i></span></td>";

                                                        echo '</tr>';
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->
                            </div>
                        </div>
                        <!-- tab-content-->
                    </div>
                    <!-- nav tabs custom-->
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
                            <b>Ejercicio*</b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_ejercicio']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_1"></td>
                    </tr>    
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Trimestre* </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_trimestre']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_2"></td>
                    </tr>    
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Convenio modificatorio* </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['numero_convenio']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_3"></td>
                    </tr>    
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Objeto* </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['objeto_contrato']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_4"></td>
                    </tr>   
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Fundamento jur&iacute;dico* </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fundamento_juridico']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_5"></td>
                    </tr> 
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Fecha celebraci&oacute;n*</b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_celebracion']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_6"></td>
                    </tr>    
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Monto*</b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['monto_convenio']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_7"></td>
                    </tr>    
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Estatus*</b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['active']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_8"></td>
                    </tr>
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Hipervínculo Al Convenio Modificatorio, en su Caso</b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['url_convenio']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_15"></td>
                    </tr> 
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Archivo del convenio en PDF</b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['file_convenio']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_9"></td>
                    </tr> 
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Fecha de validaci&oacute;n</b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_validacion']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_10"></td>
                    </tr> 
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>&Aacute;rea responsable de la informaci&oacute;n</b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['area_responsable']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_11"></td>
                    </tr>
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>A&ntilde;o </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['periodo']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_12"></td>
                    </tr>
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Fecha de actualizaci&oacute;n </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_actualizacion']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_13"></td>
                    </tr>
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Fecha de t&eacute;rmino* </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_fin']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_14"></td>
                    </tr>
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Nota*</b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['nota']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_15"></td>
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

    var eliminarModal = function(id, id2, name){
        var html_btns = '<button type="button" class="btn btn-danger" onclick="eliminar('+id+', ' + id2 +')">Si</button>' +
                   '<button type="button" class="btn btn-default" data-dismiss="modal">No</button>';
        $('#myModalDelete').find('#footer_btns').html(html_btns);
        $('#myModalDelete').find('#mensaje_modal').html('¿Desea eliminar el convenio modificatorio <b>' + name+ '</b>?');
        $('#myModalDelete').modal('show');
    }

    var eliminar = function (id, id2){
        window.location.href = '<?php echo base_url() . 'index.php/tpoadminv1/capturista/contratos/eliminar_convenio_modificatorio/' ?>' + id + '/' + id2;
    }

    var abrirModal = function(id){

        $.ajax({
            url: '<?php echo base_url() . 'index.php/tpoadminv1/capturista/contratos/get_convenio_modificatorio/' ?>'+id,
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
                    $('#myModal').find('#item_1').html(response.ejercicio);
                    $('#myModal').find('#item_2').html(response.trimestre);
                    $('#myModal').find('#item_3').html(response.numero_convenio);
                    $('#myModal').find('#item_4').html(response.objeto_convenio);
                    $('#myModal').find('#item_5').html(response.fundamento_juridico);
                    $('#myModal').find('#item_6').html(response.fecha_celebracion);
                    $('#myModal').find('#item_7').html(response.monto_convenio_format);
                    $('#myModal').find('#item_8').html(response.estatus);
                    $('#myModal').find('#item_15').html(response.url_convenio);
                    $('#myModal').find('#item_10').html(response.fecha_validacion);
                    $('#myModal').find('#item_11').html(response.area_responsable);
                    $('#myModal').find('#item_12').html(response.periodo);
                    $('#myModal').find('#item_13').html(response.fecha_actualizacion);
                    $('#myModal').find('#item_14').html(response.nota);
                    
                    if(response.name_file_convenio){
                        var html = '<a href="' + response.ruta_file_convenio + '" download>'+ response.name_file_convenio +'</a>' 
                        $('#myModal').find('#item_9').html(html);
                    }else{
                        $('#myModal').find('#item_9').html('No hay archivo');
                    }
                    
                    $('#myModal').modal('show'); 
                }
            }
        });
    }


    var upload_file = function (){
        if($("input[name='file_contrato']")[0].files.length > 0){
            $('#name_file_input').val($("input[name='file_contrato']")[0].files[0].name );
            $('#file_load').show();
            $('#file_by_save').hide();
            var file_data = $('#file_contrato').prop('files')[0];   
            var form_data = new FormData();                  
            form_data.append('file_contrato', file_data);                           
            $.ajax({
                url: '<?php echo base_url() . 'index.php/tpoadminv1/capturista/contratos/upload_file' ?>', // point to server-side PHP script 
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
                            $('#name_file_contrato').val(data[1]);
                            $('#name_file_input').val(data[1]);
                            
                        }else{
                            $('#file_by_save').show();
                            $('#file_saved').hide();
                            $('#file_load').hide();
                            $('#file_see').hide();
                            $('#result_upload').html(data[1]);
                            $('#name_file_input').val('');
                            $("input[name='file_contrato']").val(null);
                            $('#name_file_contrato').val('');
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
                    $("input[name='file_contrato']").val(null);
                    $('#name_file_contrato').val('');
                }
            });
        }
        
    } 

    var eliminar_archivo = function()
    {
        if($('#name_file_contrato').val() != ''){
            $('#file_by_save').hide();
            $('#file_saved').hide();
            $('#file_load').show();
            $('#file_see').hide();
            var form_data = new FormData();                  
            form_data.append('file_contrato', $('#name_file_contrato').val());                           
            $.ajax({
                url: '<?php echo base_url() . 'index.php/tpoadminv1/capturista/contratos/clear_file' ?>', // point to server-side PHP script 
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
                    $('#result_upload').html('Formato permitido PDF. ');
                    $('#name_file_input').val('');
                    $("input[name='file_contrato']").val(null);
                    $('#name_file_contrato').val('');
                    
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
            $("input[name='file_contrato']").trigger("click");
        }else if(action == 'eliminar') {
            eliminar_archivo();
        }
    }

    var limitar_fecha_celebracion = function(container){
        
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

            jQuery('#fecha_celebracion').datetimepicker({
                timepicker:false,
                defaultDate: defaultDate,
                minDate: inicio,
                maxDate: fin,
                format:'d.m.Y', 
                scrollInput: false
            });
        }else{
            jQuery('#fecha_celebracion').datetimepicker({
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