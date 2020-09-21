
<?php

/* 
 * INAI TPO
 */

?>
<?php
    $sel_estatus = '';
    $lista_estatus = ['-Seleccione-','Activo','En Proceso','Inactivo','Pago Emitido'];
    $lista_estatus_ids = ['','1','3','2','4'];
    for($z = 0; $z < sizeof($lista_estatus_ids); $z++)
    {
        if( $registro['active'] == 'null' )
        {
            if($lista_estatus_ids[$z] == '1' ){
                $sel_estatus .= '<option value="'.$lista_estatus_ids[$z].'" selected>' . $lista_estatus[$z] . '</option>';
            }else{
                $sel_estatus .= '<option value="'.$lista_estatus_ids[$z].'">' . $lista_estatus[$z] . '</option>';
            }
        } else{
            if( $lista_estatus_ids[$z] == $registro['active'] ){
                $sel_estatus .= '<option value="'.$lista_estatus_ids[$z].'" selected>' . $lista_estatus[$z] . '</option>';
            }else{
                $sel_estatus .= '<option value="'.$lista_estatus_ids[$z].'">' . $lista_estatus[$z] . '</option>';
            }
        }
        
    }

    $sel_ejercicios = '<option value="">-Seleccione-</option>';
    for($z = 0; $z < sizeof($ejercicios); $z++)
    {
        if($registro['id_ejercicio'] == $ejercicios[$z]['id_ejercicio']){
            $sel_ejercicios .= '<option value="'.$ejercicios[$z]['id_ejercicio'].'" selected>' . $ejercicios[$z]['ejercicio'] . '</option>';
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
            $error_t = !empty(form_error('id_trimestre', '<div class="text-danger">', '</div>'));
            $error_nc = !empty(form_error('numero_convenio', '<div class="text-danger">', '</div>'));
            $error_oc = !empty(form_error('objeto_convenio', '<div class="text-danger">', '</div>'));
            $error_fj = !empty(form_error('fundamento_juridico', '<div class="text-danger">', '</div>'));
            $error_fc = !empty(form_error('fecha_celebracion', '<div class="text-danger">', '</div>'));
            $error_cm = !empty(form_error('monto_convenio', '<div class="text-danger">', '</div>'));
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
        <form role="form" method="post" autocomplete="off" action="<?php echo base_url(); ?>index.php/tpoadminv1/capturista/contratos/validate_agregar_convenio_modificatorio" enctype="multipart/form-data" >
            <div class="box box-primary">
                <div class="box-header">
                </div><!-- /.box-header -->
                <div class="box-body">
                    <input type="hidden" value="<?php echo $registro['id_contrato']; ?>" class="form-control" name="id_contrato"/>
                    <input type="hidden" value="" class="form-control" name="id_convenio_modificatorio"/>
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
                        <label>Convenio modificatorio*
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['numero_convenio']?>"></i>
                        </label>
                        <?php $class = "form-control"; if($error_nc) $class="form-control has-error";
                            echo form_input(array('type' => 'text', 'name' => 'numero_convenio', 'value' => $registro['numero_convenio'], 'class' => $class)); ?>
                    </div>
                    <div class="form-group <?php if($error_oc) echo 'has-error' ?>">
                        <label>Objeto*
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['objeto_convenio']?>"></i>
                        </label>
                        <textarea class="form-control" name="objeto_convenio" id="objeto_convenio"><?php echo $registro['objeto_convenio']; ?></textarea>
                    </div>
                    <div class="form-group <?php if($error_fj) echo 'has-error' ?>">
                        <label>Fundamento jur&iacute;dico*
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fundamento_juridico']?>"></i>
                        </label>
                        <textarea class="form-control" name="fundamento_juridico" id="fundamento_juridico"><?php echo $registro['fundamento_juridico']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Fecha de celebraci&oacute;n*
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_celebracion']?>"></i>
                        </label>
                        <?php $class = "form-control datepicker"; if($error_fc) $class="form-control datepicker has-error";
                            echo form_input(array('type' => 'text', 'id' => 'fecha_celebracion', 'name' => 'fecha_celebracion', 'value' => $registro['fecha_celebracion'], 'class' => $class)); ?>
                    </div>
                    <div class="form-group">
                        <label>Monto*
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['monto_convenio']?>"></i>
                        </label>
                        <?php $class = "form-control"; if($error_cm) $class = "form-control has-error";
                                echo form_input(array('type' => 'number', 'step'=>'0.01', 'name' => 'monto_convenio', 'value' => $registro['monto_convenio'], 'class' => $class)); ?>
                    </div>
                    <div class="form-group">
                        <label>Estatus*
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['active']?>"></i>
                        </label>
                        <select class="form-control <?php if($error_active) echo 'has-error' ?>" name="active" >
                            <?php echo $sel_estatus; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="custom-file-label"> Archivo del convenio modificatorio en PDF
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['file_convenio']?>"></i>
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
                        <input type="text" id="name_file_input" placeholder="Ning&uacute;n archivo seleccionado" value="<?php echo $registro['name_file_convenio']; ?>"
                                class="form-control" />
                        <input type="hidden" id="name_file_convenio" name="name_file_convenio" value="<?php echo $registro['name_file_convenio']; ?>" />
                        <input type="file" name="file_convenio" id="file_convenio" class="hide" accept=".pdf"/>
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
                            echo form_input(array('type' => 'text', 'name' => 'fecha_validacion', 'value' => $registro['fecha_validacion'], 'class' => $class)); ?>
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
                    <?php echo anchor("tpoadminv1/capturista/contratos/editar_contrato/". $registro['id_contrato'] , "<button class='btn btn-default' type='button'>Regresar</button></td>"); ?>
                </div>     
            </div><!-- /.box -->    
        </form>
    </div>
</section>

<script type="text/javascript">
    var upload_file = function (){
        if($("input[name='file_convenio']")[0].files.length > 0){
            $('#name_file_input').val($("input[name='file_convenio']")[0].files[0].name );
            $('#file_load').show();
            $('#file_by_save').hide();
            var file_data = $('#file_convenio').prop('files')[0];   
            var form_data = new FormData();                  
            form_data.append('file_convenio', file_data);                           
            $.ajax({
                url: '<?php echo base_url() . 'index.php/tpoadminv1/capturista/contratos/upload_file_convenio' ?>', // point to server-side PHP script 
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
                            $('#name_file_convenio').val(data[1]);
                            $('#name_file_input').val(data[1]);
                            
                        }else{
                            $('#file_by_save').show();
                            $('#file_saved').hide();
                            $('#file_load').hide();
                            $('#file_see').hide();
                            $('#result_upload').html(data[1]);
                            $('#name_file_input').val('');
                            $("input[name='file_convenio']").val(null);
                            $('#name_file_convenio').val('');
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
                    $("input[name='file_convenio']").val(null);
                    $('#name_file_convenio').val('');
                }
            });
        }
        
    } 

    var eliminar_archivo = function()
    {
        if($('#name_file_convenio').val() != ''){
            $('#file_by_save').hide();
            $('#file_saved').hide();
            $('#file_load').show();
            $('#file_see').hide();
            var form_data = new FormData();                  
            form_data.append('file_convenio', $('#name_file_convenio').val());                           
            $.ajax({
                url: '<?php echo base_url() . 'index.php/tpoadminv1/capturista/contratos/clear_file_convenio' ?>', // point to server-side PHP script 
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
                    $("input[name='file_convenio']").val(null);
                    $('#name_file_convenio').val('');
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
            $("input[name='file_convenio']").trigger("click");
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
            }else{
                $(container).val('');
            }

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