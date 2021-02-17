
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

    $sel_sujetos = '<option value="">-Seleccione-</option>';
    for($z = 0; $z < sizeof($sujetos); $z++)
    {
        if($registro['id_sujeto_obligado'] == $sujetos[$z]['id_sujeto_obligado']){
            $sel_sujetos .= '<option value="'.$sujetos[$z]['id_sujeto_obligado'].'" selected>' . $sujetos[$z]['nombre_sujeto_obligado'] . '</option>';
        }else{
            $sel_sujetos .= '<option value="'.$sujetos[$z]['id_sujeto_obligado'].'">' . $sujetos[$z]['nombre_sujeto_obligado'] . '</option>';
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
           
            $error_e = !empty(form_error('id_ejercicio', '<div class="text-danger">', '</div>'));
            $error_so = !empty(form_error('id_sujeto_obligado', '<div class="text-danger">', '</div>'));
            $error_active = !empty(form_error('active', '<div class="text-danger">', '</div>'));
            $error_file = false; 
            $mensaje = '';
            if(@$file_error == true )
            {
                $error_file = true; 
                $mensaje = '<p>Archivo del programa anual solo permite formatos PDF,  Word y Excel </p>';
            }

            if(validation_errors() == TRUE || $error_file)
            {
                echo '<div class="alert alert-danger"><button class="close"  data-dismiss="alert">x</button>
                <h4><i class="icon fa fa-ban"></i>¡Alerta!</h4>' . validation_errors() . $mensaje .'</div>';  
            }
        ?>
        <form role="form" method="post" autocomplete="off" action="<?php echo base_url(); ?>index.php/tpoadminv1/capturista/presupuestos/validate_agregar_presupuesto" enctype="multipart/form-data" >
            <div class="box box-primary">
                <div class="box-header">
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="callout callout-info"><h4>Presupuesto</h4></div>
                    <input type="hidden" value="" class="form-control" name="id_presupuesto"/>
                    <div class="form-group">
                        <label>Ejercicio* 
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_ejercicio']?>"></i>
                        </label>
                        <select name="id_ejercicio" class="form-control <?php if($error_e) echo 'has-error' ?>">
                            <?php echo $sel_ejercicios; ?>
                        </select>
                    </div> 
                    <div class="form-group">
                        <label>Sujeto obligado*
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_sujeto_obligado']?>"></i>
                        </label>
                        <select name="id_sujeto_obligado" class="form-control <?php if($error_so) echo 'has-error' ?>">
                            <?php echo $sel_sujetos; ?>
                        </select>
                    </div>
					
					<!--Agregar fechas DGPA -->
                    <div class="form-group">
                    	<label>Fecha de inicio del periodo que se informa
                        	<i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_inicio_periodo']?>"></i>
                        </label>
                        <?php $class = "form-control datepicker";
            				echo form_input(array('type' => 'text', 'autocomplete' => 'off', 'id' => 'fecha_inicio_periodo', 'name' => 'fecha_inicio_periodo',
                            'placeholder' => 'Ingrese fecha de inicio del período', 'value' => $this->input->post('fecha_inicio_periodo'), 'class' => $class)); ?>
                    </div>
                    <div class="form-group">
                        <label>Fecha de termino del periodo que se informa
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_termino_periodo']?>"></i>
                        </label>
                        <?php $class = "form-control datepicker";
                             echo form_input(array('type' => 'text', 'autocomplete' => 'off', 'id' => 'fecha_termino_periodo', 'name' => 'fecha_termino_periodo',
                             'placeholder' => 'Ingrese fecha de término del período', 'value' => $this->input->post('fecha_termino_periodo'), 'class' => $class)); ?>
                    </div>
                    <!--Fin de fechas DGPA-->
					
                    <div class="form-group">
                        <label>Fecha de validaci&oacute;n
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_validacion']?>"></i>
                        </label>
                        <?php $class = "form-control datepicker";
                            echo form_input(array('type' => 'text', 'name' => 'fecha_validacion', 'value' => $registro['fecha_validacion'], 'class' => $class)); ?>
                    </div>
                    <div class="form-group">
                        <label>&Aacute;rea responsable
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
                            echo form_input(array('type' => 'text', 'name' => 'anio', 'value' => $registro['anio'], 'class' => $class)); ?>
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
                    <br /><br />
                    <div class="callout callout-info">
                        <h4>Programa Anual de comunicaci&oacute;n social </h4>
                    </div>
                    <div class="form-group">
                        <label> Denominaci&oacute;n del documento
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['denominacion_documento']?>"></i>
                        </label>
                        <?php $class = "form-control";
                            echo form_input(array('type' => 'text', 'name' => 'denominacion', 'value' => $registro['denominacion'], 'class' => $class)); ?>
                    </div>
                    <div class="form-group">
                        <label> Misi&oacute;n y Visi&oacute;n oficiales del Ente P&uacute;blico
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['mision']?>"></i>
                        </label>
                        <?php $class = "form-control";
                            echo form_input(array('type' => 'text', 'name' => 'mision', 'value' => $registro['mision'], 'class' => $class)); ?>
                    </div>
                    <div class="form-group">
                        <label> Objetivo u objetivos institucionales
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['objetivo_institucional']?>"></i>
                        </label>
                        <?php $class = "form-control";
                            echo form_input(array('type' => 'text', 'name' => 'objetivo', 'value' => $registro['objetivo'], 'class' => $class)); ?>
                    </div>
                    <div class="form-group">
                        <label> Metas nacionales y/o Estrategias transversales establecidas en el Plan Nacional de Desarrollo
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['metas']?>"></i>
                        </label>
                        <?php $class = "form-control";
                            echo form_input(array('type' => 'text', 'name' => 'metas', 'value' => $registro['metas'], 'class' => $class)); ?>
                    </div>
                    <div class="form-group">
                        <label> Programa o programas sectoriales
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['programas']?>"></i>
                        </label>
                        <?php $class = "form-control";
                            echo form_input(array('type' => 'text', 'name' => 'programas', 'value' => $registro['programas'], 'class' => $class)); ?>
                    </div>
                    <div class="form-group">
                        <label> Objetivo estrat&eacute;gico o transversal
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['objetivo_estrategico']?>"></i>
                        </label>
                        <?php $class = "form-control";
                            echo form_input(array('type' => 'text', 'name' => 'objetivo_transversal', 'value' => $registro['objetivo_transversal'], 'class' => $class)); ?>
                    </div>
                    <div class="form-group">
                        <label> Temas espec&iacute;ficos derivados de los objetivos estrat&eacute;gicos o transversales
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['temas']?>"></i>
                        </label>
                        <?php $class = "form-control";
                            echo form_input(array('type' => 'text', 'name' => 'temas', 'value' => $registro['temas'], 'class' => $class)); ?>
                    </div>
                    <div class="form-group">
                        <label> Conjunto de Campa&ntilde;as de Comunicaci&oacute;n Social a difundirse en el ejercicio fiscal respectivo
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['conjunto_campanas']?>"></i>
                        </label>
                        <?php $class = "form-control";
                            echo form_input(array('type' => 'text', 'name' => 'conjunto_campanas', 'value' => $registro['conjunto_campanas'], 'class' => $class)); ?>
                    </div>
                    <div class="form-group">
                        <label> Hipervínculo al programa anual
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['url_programa_anual']?>"></i>
                        </label>
                        <?php $class = "form-control";
                            echo form_input(array('type' => 'url', 'name' => 'url_programa_anual', 'value' => $registro['url_programa_anual'], 'class' => $class)); ?>
                    </div>
                    <div class="form-group">
                        <label class="custom-file-label"> Archivo del programa anual
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['file_programa_anual']?>"></i>
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
                        <input type="text" id="name_file_input" placeholder="Ning&uacute;n archivo seleccionado" value="<?php echo $registro['name_file_programa_anual']; ?>"
                                class="form-control" />
                        <input type="hidden" id="name_file_programa_anual" name="name_file_programa_anual" value="<?php echo $registro['name_file_programa_anual']; ?>" />
                        <input type="file" name="file_programa_anual" id="file_programa_anual" class="hide" accept=".xls,.xlsx,.pdf,.doc,.docx"/>
                        <div id="file_saved" class="input-group-btn" style="<?php if($control_update['file_saved']) echo 'display:none;' ?>">
                            <button class="btn btn-danger" type="button" onclick="triggerClick('eliminar')" >Eliminar archivo</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <p class="help-block" id="result_upload"><?php echo $control_update['mensaje_file']; ?> </p>
                    </div>
                    <div class="form-group">
                        <label>Fecha publicaci&oacute;n
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_publicacion']?>"></i>
                        </label>
                        <?php $class = "form-control datepicker";
                            echo form_input(array('type' => 'text', 'name' => 'fecha_publicacion', 'value' => $registro['fecha_publicacion'], 'class' => $class)); ?>
                    </div>
                    <div class="form-group">
                        <label> Nota
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['nota']?>"></i>
                        </label>
                        <textarea class="form-control" name="nota_planeacion" id="nota_planeacion"><?php echo $registro['nota_planeacion']; ?></textarea>
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
                    <?php echo anchor("tpoadminv1/capturista/presupuestos/busqueda_presupuestos", "<button class='btn btn-default' type='button'>Regresar</button></td>"); ?>
                </div>     
            </div><!-- /.box -->    
        </form>
    </div>
</section>

<script type="text/javascript">
    var upload_file = function (){
        if($("input[name='file_programa_anual']")[0].files.length > 0){
            $('#name_file_input').val($("input[name='file_programa_anual']")[0].files[0].name );
            $('#file_load').show();
            $('#file_by_save').hide();
            var file_data = $('#file_programa_anual').prop('files')[0];   
            var form_data = new FormData();                  
            form_data.append('file_programa_anual', file_data);                           
            $.ajax({
                url: '<?php echo base_url() . 'index.php/tpoadminv1/capturista/presupuestos/upload_file' ?>', // point to server-side PHP script 
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
                            $('#file_see').show();
                            $('#result_upload').html('<span class="text-success">Archivo cargado correctamente</span>');
                            $('#name_file_programa_anual').val(data[1]);
                            
                        }else{
                            $('#file_by_save').show();
                            $('#file_saved').hide();
                            $('#file_load').hide();
                            $('#file_see').hide();
                            $('#result_upload').html(data[1]);
                            $('#name_file_input').val('');
                            $("input[name='file_programa_anual']").val(null);
                            $('#name_file_programa_anual').val('');
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
                    $("input[name='file_programa_anual']").val(null);
                    $('#name_file_programa_anual').val('');
                }
            });
        }
        
    } 

	// Limitar fechas
    var limitar_fecha = function(container){
        
        var ejercicio = $('select[name="id_ejercicio"] option:selected').text();
        var anio = anio_fecha(container);
        
        var inicio = $('select[name="id_ejercicio"] option:selected').text() +'/01/01';
        var fin = $('select[name="id_ejercicio"] option:selected').text() +'/12/31';
        var defaultDate = '01.01.' + $('select[name="id_ejercicio"] option:selected').text();

        jQuery.datetimepicker.setLocale('es');
        if(ejercicio != '' && ejercicio != null && ejercicio != '-Seleccione-' && ejercicio != '- Selecciona -'){
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

    var eliminar_archivo = function()
    {
        if($('#name_file_programa_anual').val() != ''){
            $('#file_by_save').hide();
            $('#file_saved').hide();
            $('#file_load').show();
            $('#file_see').hide();
            var form_data = new FormData();                  
            form_data.append('file_programa_anual', $('#name_file_programa_anual').val());                           
            $.ajax({
                url: '<?php echo base_url() . 'index.php/tpoadminv1/capturista/presupuestos/clear_file' ?>', // point to server-side PHP script 
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
                        $('#result_upload').html('Formatos permitidos PDF,  Word y Excel. ');
                        $('#name_file_input').val('');
                        $("input[name='file_programa_anual']").val(null);
                        $('#name_file_programa_anual').val('');
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
            $("input[name='file_programa_anual']").trigger("click");
        }else if(action == 'eliminar') {
            eliminar_archivo();
        }
    }
</script>