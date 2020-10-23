
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
    if(isset($procedimientos) && !empty($procedimientos))
    {
        for($z = 0; $z < sizeof($procedimientos); $z++)
        {
            if($registro['id_procedimiento'] == $procedimientos[$z]['id_procedimiento']){
                $sel_procedimientos .= '<option value="'.$procedimientos[$z]['id_procedimiento'].'" selected>' . $procedimientos[$z]['nombre_procedimiento'] . '</option>';
            }else{
                $sel_procedimientos .= '<option value="'.$procedimientos[$z]['id_procedimiento'].'">' . $procedimientos[$z]['nombre_procedimiento'] . '</option>';
            }
        }
    }
    
    $sel_proveedores = '<option value="">-Seleccione-</option>';
    if(isset($proveedores) && !empty($proveedores))
    {
        for($z = 0; $z < sizeof($proveedores); $z++)
        {
            if($registro['id_proveedor'] == $proveedores[$z]['id_proveedor']){
                $sel_proveedores .= '<option value="'.$proveedores[$z]['id_proveedor'].'" selected>' . $proveedores[$z]['nombre_razon_social'] . '</option>';
            }else{
                $sel_proveedores .= '<option value="'.$proveedores[$z]['id_proveedor'].'">' . $proveedores[$z]['nombre_razon_social'] . '</option>';
            }
        }
    }

    $select = '<option value="">-Seleccione-</option>';
    
    $sel_so_contratantes = '<option value="">-Seleccione-</option>';
    if(isset($so_contratantes) && !empty($so_contratantes))
    {
        for($z = 0; $z < sizeof($so_contratantes); $z++)
        {
            if($registro['id_so_contratante'] == $so_contratantes[$z]['id_sujeto_obligado']){
                $sel_so_contratantes .= '<option value="'.$so_contratantes[$z]['id_sujeto_obligado'].'" selected>' . $so_contratantes[$z]['nombre_sujeto_obligado'] . '</option>';
            }else{
                $sel_so_contratantes .= '<option value="'.$so_contratantes[$z]['id_sujeto_obligado'].'">' . $so_contratantes[$z]['nombre_sujeto_obligado'] . '</option>';
            }
        }
    }

    $sel_so_solicitantes = '<option value="">-Seleccione-</option>';
    if(isset($so_solicitantes) && !empty($so_solicitantes))
    {
        for($z = 0; $z < sizeof($so_solicitantes); $z++)
        {
            if($registro['id_so_solicitante'] == $so_solicitantes[$z]['id_sujeto_obligado']){
                $sel_so_solicitantes .= '<option value="'.$so_solicitantes[$z]['id_sujeto_obligado'].'" selected>' . $so_solicitantes[$z]['nombre_sujeto_obligado'] . '</option>';
            }else{
                $sel_so_solicitantes .= '<option value="'.$so_solicitantes[$z]['id_sujeto_obligado'].'">' . $so_solicitantes[$z]['nombre_sujeto_obligado'] . '</option>';
            }
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

    $sel_campanas_aviso = '<option value="0">-Seleccione-</option>';
    if(isset($campanas_avisos)){
        for($z = 0; $z < sizeof($campanas_avisos); $z++)
        {
            if($registro['id_campana_aviso'] == $campanas_avisos[$z]['id_campana_aviso']){
                $sel_campanas_aviso .= '<option value="'.$campanas_avisos[$z]['id_campana_aviso'].'" selected>' . $campanas_avisos[$z]['nombre_campana_aviso'] . '</option>';
            }else{
                $sel_campanas_aviso .= '<option value="'.$campanas_avisos[$z]['id_campana_aviso'].'">' . $campanas_avisos[$z]['nombre_campana_aviso'] . '</option>';
            }
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
           
            $error_ej = !empty(form_error('id_ejercicio', '<div class="text-danger">', '</div>'));
            $error_c = !empty(form_error('id_contrato', '<div class="text-danger">', '</div>'));
            $error_pe = !empty(form_error('id_proveedor', '<div class="text-danger">', '</div>'));
            $error_t = !empty(form_error('id_trimestre', '<div class="text-danger">', '</div>'));
            $error_ca = !empty(form_error('id_campana_aviso', '<div class="text-danger">', '</div>'));
            $error_p = !empty(form_error('id_procedimiento', '<div class="text-danger">', '</div>'));
            $error_so_c = !empty(form_error('id_so_contratante', '<div class="text-danger">', '</div>'));
            $error_so_s = !empty(form_error('id_so_solicitante', '<div class="text-danger">', '</div>'));
            $error_noc = !empty(form_error('numero_orden_compra', '<div class="text-danger">', '</div>'));
            $error_dj = !empty(form_error('descripcion_justificacion', '<div class="text-danger">', '</div>'));
            $error_ma = !empty(form_error('motivo_adjudicacion', '<div class="text-danger">', '</div>'));
            $error_fo = !empty(form_error('fecha_orden', '<div class="text-danger">', '</div>'));
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
        <form role="form" method="post" autocomplete="off" action="<?php echo base_url(); ?>index.php/tpoadminv1/capturista/ordenes_compra/validate_editar_orden_compra" enctype="multipart/form-data" >
            <div class="box box-primary">
                <div class="box-header">
                </div><!-- /.box-header -->
                <div class="box-body">
                    <input type="hidden" value="<?php echo $registro['id_orden_compra']; ?>" class="form-control" name="id_orden_compra"/>
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
                        <label>Nombre o raz&oacute;n social del proveedor*
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
                        <label>Campa&ntilde;a o aviso institucional* 
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_campana_aviso']?>"></i>
                        </label>
                        <select name="id_campana_aviso" class="form-control <?php if($error_ca) echo 'has-error' ?>">
                            <?php echo $sel_campanas_aviso; ?>
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
                        <label>Procedimiento* 
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_procedimiento']?>"></i>
                        </label>
                        <select name="id_procedimiento" class="form-control <?php if($error_p) echo 'has-error' ?>">
                            <?php echo $sel_procedimientos; ?>
                        </select>
                    </div> 
                    <div class="form-group">
                        <label>Sujeto obligado ordenante*
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_so_contratante']?>"></i>
                        </label>
                        <select name="id_so_contratante" class="form-control <?php if($error_so_c) echo 'has-error' ?>">
                            <?php echo $sel_so_contratantes; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Sujeto obligado solicitante*
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_so_solicitante']?>"></i>
                        </label>
                        <select name="id_so_solicitante" class="form-control <?php if($error_so_s) echo 'has-error' ?>">
                            <?php echo $sel_so_solicitantes; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Orden de compra*
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['numero_orden_compra']?>"></i>
                        </label>
                        <?php $class = "form-control"; if($error_noc) $class="form-control has-error";
                            echo form_input(array('type' => 'text', 'name' => 'numero_orden_compra', 'value' => $registro['numero_orden_compra'], 'class' => $class)); ?>
                    </div>
                    <div class="form-group <?php if($error_dj) echo 'has-error' ?>">
                        <label>Justificaci&oacute;n*
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['descripcion_justificacion']?>"></i>
                        </label>
                        <textarea class="form-control <?php if($error_dj) echo 'has-error' ?>" name="descripcion_justificacion" id="descripcion_justificacion"><?php echo $registro['descripcion_justificacion']; ?></textarea>
                    </div>
                    <div class="form-group <?php if($error_ma) echo 'has-error' ?>">
                        <label>Motivo de adjudicaci&oacute;n*</label>
                        <textarea class="form-control" name="motivo_adjudicacion" id="motivo_adjudicacion"><?php echo $registro['motivo_adjudicacion']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Fecha de orden*
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_orden']?>"></i>
                        </label>
                        <?php $class = "form-control datepicker"; if($error_fo) $class="form-control datepicker has-error";
                            echo form_input(array('type' => 'text', 'id' => 'fecha_orden', 'name' => 'fecha_orden', 'value' => $registro['fecha_orden'], 'class' => $class)); ?>
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
                        <label>Hipervínculo a la orden de compra
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['url_orden']?>"></i>
                        </label>
                        <?php $class = "form-control";
                            echo form_input(array('type' => 'url', 'name' => 'url_orden', 'value' => $registro['url_orden'], 'class' => $class)); ?>
                    </div>
                    <div class="form-group">
                        <label class="custom-file-label"> Archivo de la orden de compra en PDF
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['file_orden']?>"></i>
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
                        <input type="text" id="name_file_input" placeholder="Ning&uacute;n archivo seleccionado" value="<?php echo $registro['name_file_orden']; ?>"
                                class="form-control" />
                        <input type="hidden" id="name_file_orden" name="name_file_orden" value="<?php echo $registro['name_file_orden']; ?>" />
                        <input type="file" name="file_orden" id="file_orden" class="hide" accept=".pdf"/>
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
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <button class="btn btn-primary" type="submit">Guardar</button>
                    <?php echo anchor("tpoadminv1/capturista/ordenes_compra/busqueda_ordenes_compra", "<button class='btn btn-default' type='button'>Regresar</button></td>"); ?>
                </div>     
            </div><!-- /.box -->    
        </form>
    </div>
</section>

<script type="text/javascript">


    var get_contratos = function()
    {
        var form_data = new FormData();                  
        form_data.append('id_ejercicio', $('select[name="id_ejercicio"]').val());
        form_data.append('id_proveedor', $('select[name="id_proveedor"]').val());
        var url = '<?php echo base_url() . 'index.php/tpoadminv1/capturista/contratos/get_contratos_filtro' ?>';

        buscar_catalogos(url, form_data, set_contratos);
    }

    var get_campanas = function()
    {
        var form_data = new FormData();                  
        form_data.append('id_ejercicio', $('select[name="id_ejercicio"]').val());
        var url = '<?php echo base_url() . 'index.php/tpoadminv1/capturista/ordenes_compra/get_campanas_filtro' ?>';
        
        console.log('entra');
        buscar_catalogos(url, form_data, set_campanas);
    }

    var set_campanas = function(response)
    {
        console.log('respuesta: ' + response);
        var options = '<option>-Seleccione-</option>';
        if(response && response[0] == '['){
            var data = $.parseJSON(response);
            if($.isArray(data)){
                var i;
                if(data.length == 1) //para poner el valor por default
                    options = ''
                for (i = 0; i < data.length; i++) { 
                    options += "<option value=" + data[i]['id_campana_aviso'] + ">" + data[i]['nombre_campana_aviso'] + "</option>";
                }
            }
        }
        $('select[name="id_campana_aviso"]').empty();
        $('select[name="id_campana_aviso"]').append(options);
    }

    var set_contratos = function(response)
    {
        var options = '<option>-Seleccione-</option>';
        if(response && response[0] == '['){
            var data = $.parseJSON(response);
            if($.isArray(data)){
                var i;
                if(data.length == 1) //para poner el sin contrato por default
                    options = ''
                for (i = 0; i < data.length; i++) { 
                    options += "<option data-proveedor=" + data[i]['id_proveedor'] + " value=" + data[i]['id_contrato'] + ">" + data[i]['numero_contrato'] + "</option>";
                }
            }
        }
        $('select[name="id_contrato"]').empty();
        $('select[name="id_contrato"]').append(options);
    }

    var set_proveedor = function(){
        var id = $('select[name="id_contrato"]  option:selected').attr('data-proveedor');
        if( ($('select[name="id_proveedor"]').val() == '' || $('select[name="id_proveedor"]').val() != id ) && id != "undefined" ){
            $('select[name="id_proveedor"]').val(id);
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
        if($("input[name='file_orden']")[0].files.length > 0){
            $('#name_file_input').val($("input[name='file_orden']")[0].files[0].name );
            $('#file_load').show();
            $('#file_by_save').hide();
            var file_data = $('#file_orden').prop('files')[0];   
            var form_data = new FormData();                  
            form_data.append('file_orden', file_data);                           
            $.ajax({
                url: '<?php echo base_url() . 'index.php/tpoadminv1/capturista/ordenes_compra/upload_file' ?>', // point to server-side PHP script 
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
                            $('#name_file_orden').val(data[1]);
                            $('#name_file_input').val(data[1]);
                            
                        }else{
                            $('#file_by_save').show();
                            $('#file_saved').hide();
                            $('#file_load').hide();
                            $('#file_see').hide();
                            $('#result_upload').html(data[1]);
                            $('#name_file_input').val('');
                            $("input[name='file_orden']").val(null);
                            $('#name_file_orden').val('');
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
                    $("input[name='file_orden']").val(null);
                    $('#name_file_orden').val('');
                }
            });
        }
        
    } 

    var eliminar_archivo = function()
    {
        if($('#name_file_orden').val() != ''){
            $('#file_by_save').hide();
            $('#file_saved').hide();
            $('#file_load').show();
            $('#file_see').hide();
            var form_data = new FormData();                  
            form_data.append('file_orden', $('#name_file_orden').val());                           
            $.ajax({
                url: '<?php echo base_url() . 'index.php/tpoadminv1/capturista/ordenes_compra/clear_file' ?>', // point to server-side PHP script 
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
                        $("input[name='file_orden']").val(null);
                        $('#name_file_orden').val('');
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
            $("input[name='file_orden']").trigger("click");
        }else if(action == 'eliminar') {
            eliminar_archivo();
        }
    }

    var limitar_fecha_orden = function(container){
        
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

            jQuery('#fecha_orden').datetimepicker({
                timepicker:false,
                defaultDate: defaultDate,
                minDate: inicio,
                maxDate: fin,
                format:'d.m.Y',
                scrollInput: false
            });
        }else{
            jQuery('#fecha_orden').datetimepicker({
                timepicker:false,
                format:'d.m.Y',
                scrollInput: false
            });
            $(container).val('');
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