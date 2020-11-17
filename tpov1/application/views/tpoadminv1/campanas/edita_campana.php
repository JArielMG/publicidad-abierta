<?php

/* 
 INAI / EDITA CAMPANA
 */

?>
<?php

	$sel_camp_tipo = '<option value="0">- Selecciona -</option>';
	for($z = 0; $z < sizeof($camp_tipo); $z++)
	{
	    if($campana['id_campana_tipo'] == $camp_tipo[$z]['id_campana_tipo']){
	        $sel_camp_tipo .= '<option value="'.$camp_tipo[$z]['id_campana_tipo'].'" selected>' . $camp_tipo[$z]['nombre_campana_tipo'] . '</option>';
	    }else{
	        $sel_camp_tipo .= '<option value="'.$camp_tipo[$z]['id_campana_tipo'].'">' . $camp_tipo[$z]['nombre_campana_tipo'] . '</option>';
	    }
	}

	$sel_camp_subtipo = '<option value="0">- Selecciona -</option>';
	for($z = 0; $z < sizeof($camp_subtipo); $z++)
	{
	    if($campana['id_campana_subtipo'] == $camp_subtipo[$z]['id_campana_subtipo']){
	        $sel_camp_subtipo .= '<option value="'.$camp_subtipo[$z]['id_campana_subtipo'].'" selected>' . $camp_subtipo[$z]['nombre_campana_subtipo'] . '</option>';
	    }else{
	        $sel_camp_subtipo .= '<option value="'.$camp_subtipo[$z]['id_campana_subtipo'].'">' . $camp_subtipo[$z]['nombre_campana_subtipo'] . '</option>';
	    }
	}

    $sel_ejercicios = '<option value="0">- Selecciona -</option>';
    for($z = 0; $z < sizeof($ejercicios); $z++)
    {
        if($campana['id_ejercicio'] == $ejercicios[$z]['id_ejercicio']){
            $sel_ejercicios .= '<option value="'.$ejercicios[$z]['id_ejercicio'].'" selected>' . $ejercicios[$z]['ejercicio'] . '</option>';
        }else{
            $sel_ejercicios .= '<option value="'.$ejercicios[$z]['id_ejercicio'].'">' . $ejercicios[$z]['ejercicio'] . '</option>';
        }
    }

    $sel_trimestre = '<option value="0">- Selecciona -</option>';
    for($z = 0; $z < sizeof($trimestres); $z++)
    {
        if($campana['id_trimestre'] == $trimestres[$z]['id_trimestre']){
            $sel_trimestre .= '<option value="'.$trimestres[$z]['id_trimestre'].'" selected>' . $trimestres[$z]['trimestre'] . '</option>';
        }else{
            $sel_trimestre .= '<option value="'.$trimestres[$z]['id_trimestre'].'">' . $trimestres[$z]['trimestre'] . '</option>';
        }
    }

    $sel_estatus = '';
    $lista_estatus = ['-Seleccione-','Activo','Inactivo'];
    $lista_estatus_ids = ['0','1','2'];
    for($z = 0; $z < sizeof($lista_estatus_ids); $z++)
    {
        if($campana['active'] == $lista_estatus_ids[$z]){
            $sel_estatus .= '<option value="'.$lista_estatus_ids[$z].'" selected>' . $lista_estatus[$z] . '</option>';
        }else{
            $sel_estatus .= '<option value="'.$lista_estatus_ids[$z].'">' . $lista_estatus[$z] . '</option>';
        }   
    }

    $sel_ejercicios = '<option value="0">-Seleccione-</option>';
    for($z = 0; $z < sizeof($ejercicios); $z++)
    {
        if($campana['id_ejercicio'] == $ejercicios[$z]['id_ejercicio']){
            $sel_ejercicios .= '<option value="'.$ejercicios[$z]['id_ejercicio'].'" selected>' . $ejercicios[$z]['ejercicio'] . '</option>';
        }else{
            $sel_ejercicios .= '<option value="'.$ejercicios[$z]['id_ejercicio'].'">' . $ejercicios[$z]['ejercicio'] . '</option>';
        }
    }

	$sel_so_solicitantes = '<option value="0">-Seleccione-</option>';
    for($z = 0; $z < sizeof($so_solicitantes); $z++)
    {
        if($campana['id_so_solicitante'] == $so_solicitantes[$z]['id_sujeto_obligado']){
            $sel_so_solicitantes .= '<option value="'.$so_solicitantes[$z]['id_sujeto_obligado'].'" selected>' . $so_solicitantes[$z]['nombre_sujeto_obligado'] . '</option>';
        }else{
            $sel_so_solicitantes .= '<option value="'.$so_solicitantes[$z]['id_sujeto_obligado'].'">' . $so_solicitantes[$z]['nombre_sujeto_obligado'] . '</option>';
        }
    }

    $sel_so_contratantes = '<option value="0">-Seleccione-</option>';
    for($z = 0; $z < sizeof($so_contratantes); $z++)
    {
        if($campana['id_so_contratante'] == $so_contratantes[$z]['id_sujeto_obligado']){
            $sel_so_contratantes .= '<option value="'.$so_contratantes[$z]['id_sujeto_obligado'].'" selected>' . $so_contratantes[$z]['nombre_sujeto_obligado'] . '</option>';
        }else{
            $sel_so_contratantes .= '<option value="'.$so_contratantes[$z]['id_sujeto_obligado'].'">' . $so_contratantes[$z]['nombre_sujeto_obligado'] . '</option>';
        }
    }

    $sel_camp_tema = '<option value="0">-Seleccione-</option>';
    for($z = 0; $z < sizeof($temas); $z++)
    {
        if($campana['id_campana_tema'] == $temas[$z]['id_campana_tema']){
            $sel_camp_tema .= '<option value="'.$temas[$z]['id_campana_tema'].'" selected>' . $temas[$z]['nombre_campana_tema'] . '</option>';
        }else{
            $sel_camp_tema .= '<option value="'.$temas[$z]['id_campana_tema'].'">' . $temas[$z]['nombre_campana_tema'] . '</option>';
        }
    }

    $sel_objetivo = '<option value="0">-Seleccione-</option>';
    for($z = 0; $z < sizeof($objetivos); $z++)
    {
        if($campana['id_campana_objetivo'] == $objetivos[$z]['id_campana_objetivo']){
            $sel_objetivo .= '<option value="'.$objetivos[$z]['id_campana_objetivo'].'" selected>' . $objetivos[$z]['campana_objetivo'] . '</option>';
        }else{
            $sel_objetivo .= '<option value="'.$objetivos[$z]['id_campana_objetivo'].'">' . $objetivos[$z]['campana_objetivo'] . '</option>';
        }
    }

    $sel_cobertura = '<option value="0">-Seleccione-</option>';
    for($z = 0; $z < sizeof($coberturas); $z++)
    {
        if($campana['id_campana_cobertura'] == $coberturas[$z]['id_campana_cobertura']){
            $sel_cobertura .= '<option value="'.$coberturas[$z]['id_campana_cobertura'].'" selected>' . $coberturas[$z]['nombre_campana_cobertura'] . '</option>';
        }else{
            $sel_cobertura .= '<option value="'.$coberturas[$z]['id_campana_cobertura'].'">' . $coberturas[$z]['nombre_campana_cobertura'] . '</option>';
        }
    }

	$sel_tipoTO = '<option value="0">-Seleccione-</option>';
    for($z = 0; $z < sizeof($tiposTO); $z++)
    {
        if($campana['id_campana_tipoTO'] == $tiposTO[$z]['id_campana_tipoTO']){
            $sel_tipoTO .= '<option value="'.$tiposTO[$z]['id_campana_tipoTO'].'" selected>' . $tiposTO[$z]['nombre_campana_tipoTO'] . '</option>';
        }else{
            $sel_tipoTO .= '<option value="'.$tiposTO[$z]['id_campana_tipoTO'].'">' . $tiposTO[$z]['nombre_campana_tipoTO'] . '</option>';
        }
    }
	
	$sel_categorias = '<option value="0">-Seleccione-</option>';
    if(isset($categorias)){
        for($z = 0; $z < sizeof($categorias); $z++)
        {
            if($campana['id_servicio_categoria'] == $categorias[$z]['id_servicio_categoria']){
                $sel_categorias .= '<option value="'.$categorias[$z]['id_servicio_categoria'].'" selected>' . $categorias[$z]['nombre_servicio_categoria'] . '</option>';
            }else{
                $sel_categorias .= '<option value="'.$categorias[$z]['id_servicio_categoria'].'">' . $categorias[$z]['nombre_servicio_categoria'] . '</option>';
            }
        }
    }
    
	$sel_pacs = '<option value="0">- Selecciona -</option>';
	for($z = 0; $z < sizeof($docpacs); $z++)
	{
		if($campana['id_presupuesto'] == $docpacs[$z]['id_presupuesto']){
			$sel_pacs .= '<option value="'.$docpacs[$z]['id_presupuesto'].'" selected>' . $docpacs[$z]['denominacion'] . '</option>';
		}else{
			$sel_pacs .= '<option value="'.$docpacs[$z]['id_presupuesto'].'">' . $docpacs[$z]['denominacion'] . '</option>';
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

    .disabled_tab2 {
        pointer-events: none;
        cursor: default;
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

    <link href="<?php echo base_url(); ?>editors/tinymce/skins/lightgray/skin.min.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo base_url();?>editors/tinymce/tinymce.min.js"></script>
    <div class="row">
        
        <?php 
            /*** El siguiente código es para colocar la clase .validation_error cuando hay un error en el form_validate 
             * form_error regresa una cadena, si es vacía significa que no hay error, si trae texto se marca el error
             * ***/
            $error_tipo = !empty(form_error('id_campana_tipo', '<div class="text-danger">', '</div>'));
            $error_subtipo = !empty(form_error('id_campana_subtipo', '<div class="text-danger">', '</div>'));
            $error_nombre = !empty(form_error('nombre_campana_aviso', '<div class="text-danger">', '</div>'));
            $error_ejercicio = !empty(form_error('id_ejercicio', '<div class="text-danger">', '</div>'));
            $error_trimestre = !empty(form_error('id_trimestre', '<div class="text-danger">', '</div>'));
            $error_soc = !empty(form_error('id_so_contratante', '<div class="text-danger">', '</div>'));
            $error_sos = !empty(form_error('id_so_solicitante', '<div class="text-danger">', '</div>'));
            $error_tema = !empty(form_error('id_campana_tema', '<div class="text-danger">', '</div>'));
            $error_obj_inst = !empty(form_error('id_campana_objetivo', '<div class="text-danger">', '</div>'));
            $error_cobertura = !empty(form_error('id_campana_objetivo', '<div class="text-danger">', '</div>'));
            $error_tipoTO = !empty(form_error('id_campana_tipoTO', '<div class="text-danger">', '</div>'));            
            $error_tiempo_oficial = !empty(form_error('id_campana_objetivo', '<div class="text-danger">', '</div>'));
            $error_fecha_pub = !empty(form_error('id_campana_objetivo', '<div class="text-danger">', '</div>'));
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
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs" id="pestanas">
                <li class="<?php if(!$this->session->flashdata('tab_flag')) echo 'active' ?>">
                    <a href="#tab_1" data-toggle="tab"> Campa&ntilde;as y avisos institucionales</a>
                <li>
                <li class="<?php if($this->session->flashdata('tab_flag')) echo 'active' ?>">
                    <a href="#tab_2" data-toggle="tab" onclick="verificar(<?php echo $this->session->userdata('id_campana_aviso')?>);">Grupo de edad </a>
                <li>
                <li class="<?php if($this->session->flashdata('tab_flag')) echo 'active' ?>">
                    <a href="#tab_3" data-toggle="tab" onclick="lugar(<?php echo $this->session->userdata('id_campana_aviso')?>);">Lugar</a>
                <li>
                <li class="<?php if($this->session->flashdata('tab_flag')) echo 'active' ?>">
                    <a href="#tab_4" data-toggle="tab" onclick="nivel(<?php echo $this->session->userdata('id_campana_aviso')?>);">Nivel Socioecon&oacute;mico</a>
                <li>
                <li class="<?php if($this->session->flashdata('tab_flag')) echo 'active' ?>">
                    <a href="#tab_5" data-toggle="tab" onclick="educacion(<?php echo $this->session->userdata('id_campana_aviso')?>);">Educaci&oacute;n</a>
                <li>
                <li class="<?php if($this->session->flashdata('tab_flag')) echo 'active' ?>">
                    <a href="#tab_6" data-toggle="tab" onclick="sexo(<?php echo $this->session->userdata('id_campana_aviso')?>);">Sexo</a>
                <li>
                <li class="<?php if($this->session->flashdata('tab_flag')) echo 'active' ?>">
                    <a href="#tab_7" data-toggle="tab" onclick="audios(<?php echo $this->session->userdata('id_campana_aviso')?>);">Audios</a>
                <li>
                <li class="<?php if($this->session->flashdata('tab_flag')) echo 'active' ?>">
                    <a href="#tab_8" data-toggle="tab" onclick="imagenes(<?php echo $this->session->userdata('id_campana_aviso')?>);">Im&aacute;genes</a>
                <li>
                <li class="<?php if($this->session->flashdata('tab_flag')) echo 'active' ?>">
                    <a href="#tab_9" data-toggle="tab" onclick="videos(<?php echo $this->session->userdata('id_campana_aviso')?>);">V&iacute;deos</a>
                <li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane <?php if(!$this->session->flashdata('tab_flag')) echo 'active' ?>" id="tab_1">
                    <form role="form" method="post" action="<?php echo base_url(); ?>index.php/tpoadminv1/campanas/campanas/validate_edita_campanas_avisos" enctype="multipart/form-data" >
                        <input type="hidden" name="id_campana_aviso" value="<?php echo $this->input->post('id_campana_aviso'); ?>" />

                        <div class="box">
                            <div class="box-header">
                            </div><!-- /.box-header -->
                            <div class="box-body">                                
                                <div class="form-group">
                                    <label>Tipo* 
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['tipo']?>"></i>
                                    </label>
                                    <select name="id_campana_tipo" id="id_campana_tipo" class="form-control <?php if($error_e) echo 'has-error' ?>">
                                        <?php echo $sel_camp_tipo; ?>
                                    </select>
                                </div> 
                                <div class="form-group">
                                    <label>Subtipo*
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['subtipo']?>"></i>
                                    </label>
                                    <div id="seleccion">
                                        <select class="form-control <?php if($error_subtipo) echo 'has-error' ?>" name="id_campana_subtipo" id="id_campana_subtipo">
                                            <!--<option value="0">- Selecciona -</option>-->
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Nombre* 
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['nombre']?>"></i>
                                    </label>
                                    <?php $class = "form-control"; if($error_nombre) $class="form-control has-error";
                                            echo form_input(array('type' => 'text', 'name' => 'nombre_campana_aviso', 
                                            'value' => $campana['nombre_campana_aviso'], 'class' => $class)); ?>
                                </div>
                                <div class="form-group">
                                    <label>Clave de campaña o aviso institucional</label>
                                    <?php $class = "form-control";
                                            echo form_input(array('type' => 'text', 'name' => 'clave_campana', 
                                            'value' => $campana['clave_campana'], 'class' => $class)); ?>
                                </div>
                                <div class="form-group">
                                    <label>Autoridad que proporcionó la clave
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['autoridad']?>"></i>
                                    </label>
                                    <?php $class = "form-control";
                                            echo form_input(array('type' => 'text', 'name' => 'autoridad', 
                                            'value' => $campana['autoridad'], 'class' => $class)); ?>    
                                </div>
                                <div class="form-group">
                                    <label>Ejercicio*
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['ejercicio']?>"></i>
                                    </label>
                                    <select name="id_ejercicio" class="form-control <?php if($error_so) echo 'has-error' ?>">
                                        <?php echo $sel_ejercicios; ?>
                                    </select>
                                    <input type="hidden" id="valor_ejercicio" name="valor_ejercicio" value="" />
                                </div>
                                <div class="form-group">
                                    <label>Trimestre*
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['trimestre']?>"></i>
                                    </label>
                                    <select name="id_trimestre" class="form-control <?php if($error_so) echo 'has-error' ?>">
                                        <?php echo $sel_trimestre; ?>
                                    </select>
                                </div>
                                
                                <!--Agregar fechas DGPA -->
			                    <div class="form-group">
			                    	<label>Fecha de inicio del periodo que se informa*
			                        	<i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_inicio_periodo']?>"></i>
			                        </label>
			            				<input type="text" value="<?php if($campana['fecha_inicio_periodo'] != '0000-00-00'){ echo $campana['fecha_inicio_periodo'];}else { echo '';} ?>" class="form-control" id="fecha_inicio_periodo" name="fecha_inicio_periodo" autocomplete="off"/>
			                    </div>                                  
                                 
			                    <div class="form-group">
			                        <label>Fecha de término del periodo que se informa*
			                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_termino_periodo']?>"></i>
			                        </label>
			                            <input type="text" value="<?php if($campana['fecha_termino_periodo'] != '0000-00-00'){ echo $campana['fecha_termino_periodo'];}else { echo '';} ?>" class="form-control" id="fecha_termino_periodo" name="fecha_termino_periodo" autocomplete="off"/>
			                    </div>
			                    <!--Fin de fechas DGPA-->
                                
                                <div class="form-group">
                                    <label>Sujeto obligado contratante*
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['soc']?>"></i>
                                    </label>
                                    <select name="id_so_contratante" class="form-control <?php if($error_so) echo 'has-error' ?>">
                                        <?php echo $sel_so_contratantes; ?>
                                    </select>
                                </div>                                
                                <div class="form-group">
                                    <label>Sujeto obligado solicitante*
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['sos']?>"></i>
                                    </label>
                                    <select name="id_so_solicitante" class="form-control <?php if($error_so) echo 'has-error' ?>">
                                        <?php echo $sel_so_solicitantes; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Tema*
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['tema']?>"></i>
                                    </label>
                                    <select name="id_campana_tema" class="form-control <?php if($error_so) echo 'has-error' ?>">
                                        <?php echo $sel_camp_tema; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Objetivo Institucional*
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['obj_institucional']?>"></i>
                                    </label>
                                    <select name="id_campana_objetivo" class="form-control <?php if($error_so) echo 'has-error' ?>">
                                        <?php echo $sel_objetivo; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Objetivo de comunicaci&oacute;n
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['obj_comunicacion']?>"></i>
                                    </label>
                                    <textarea class="form-control" name="objetivo_comunicacion" id="objetivo_comunicacion">
                                    <?php echo $campana['objetivo_comunicacion']; ?></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label>Cobertura*
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['cobertura']?>"></i>
                                    </label>
                                    <select name="id_campana_cobertura" class="form-control <?php if($error_so) echo 'has-error' ?>">
                                        <?php echo $sel_cobertura; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>&Aacute;mbito geogr&aacute;fico 
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['amb_geografico']?>"></i>
                                    </label>
                                    <?php $class = "form-control";
                                            echo form_input(array('type' => 'text', 'name' => 'campana_ambito_geo', 
                                            'value' => $campana['campana_ambito_geo'], 'class' => $class)); ?>   
                                </div>

                                <div class="form-group">
                                    <label>Fecha de inicio
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_inicio']?>"></i>
                                    </label>
                                    <input type="text" value="<?php if($campana['fecha_inicio'] != '0000-00-00'){ echo $campana['fecha_inicio'];}else { echo '';} ?>" class="form-control" id="fecha_inicio" name="fecha_inicio" autocomplete="off"/>                                   
                                </div>

                                <div class="form-group">
                                    <label>Fecha de t&eacute;rmino
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_termino']?>"></i>
                                    </label>
                                    <input type="text" value="<?php if($campana['fecha_termino'] != '0000-00-00'){ echo $campana['fecha_termino'];}else { echo '';} ?>" class="form-control" id="fecha_termino" name="fecha_termino" autocomplete="off"/>
                                </div>

		 <!-- I N I C I O      T I E M P O       O F I C I A L -->

                                <div class="form-group">
                                    <label>Tiempo oficial*
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['tiempo_oficial']?>"></i>
                                    </label>
                                    <select name="id_tiempo_oficial" onChange="toOnChange(this)" class="form-control <?php if($error_so) echo 'has-error' ?>">
                                        <option value="1" <?php if($campana['id_tiempo_oficial'] == '1') { ?>  selected="selected"; <?php } ?> >No</option>
                                        <option value="2" <?php if($campana['id_tiempo_oficial'] == '2') { ?>  selected="selected"; <?php } ?>>Sí</option>
                                    </select>
                                </div>
                                                             
                                <div>								      
								    <div id="timeOficial" style="display:none;">
		                                <div class="form-group">
		                                    <label>Monto total del tiempo de estado o tiempo fiscal consumidos
		                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['monto_tiempo']?>"></i>
		                                    </label>
		                                     <br>                                                           
			                                <table class="table">
												<tr>
													<th>Horas</th>
													<th>Minutos</th>
													<th>Segundos</th>
													<th>Monto total del tiempo</th>
												</tr>
			
												<tr>
													<td>
		                                            <input class="form-control" name="hora_to" id="hora_to" value="<?php echo $campana['hora_to']; ?>" onchange="javascript:monto_TO();"><?php echo set_value('hora_to');?> <?php echo set_value('hora_to');?>		  
													</td>
													<td>
													<input class="form-control" name="minutos_to" id="minutos_to" value="<?php echo $campana['minutos_to']; ?>" onchange="javascript:monto_TO();"><?php echo set_value('minutos_to');?> 
													</td>
													<td>
													<input class="form-control" name="segundos_to" id="segundos_to" value="<?php echo $campana['segundos_to']; ?>" onchange="javascript:monto_TO();"><?php echo set_value('segundos_to');?> 
													</td>
													<td>
													<input class="form-control" readonly="readonly" name="monto_tiempo" id="monto_tiempo" value="<?php echo $campana['monto_tiempo']; ?>"  />
													</td>
												</tr>
											</table>
		                                </div>
		                                
					                        <script type="text/javascript">
												function monto_TO() {
												    hora_to=document.getElementById('hora_to').value;
												    minutos_to=document.getElementById('minutos_to').value;
												    segundos_to=document.getElementById('segundos_to').value;
												
												    monto_tiempo=hora_to+':'+minutos_to+':'+segundos_to;
												
												    document.getElementById('monto_tiempo').value=monto_tiempo;	
						                       	}											
											</script>    
		                                                              
		                                <div class="form-group">
		                                    <label>Tipo de tiempo oficial
		                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['tipoTO']?>"></i>
		                                    </label>
		                                    <select name="id_campana_tipoTO" class="form-control <?php if($error_tipoTO) echo 'has-error' ?>">
		                                        <?php echo $sel_tipoTO; ?>
		                                    </select>
		                                </div>		                                
		                                <div class="form-group">
		                                    <label>Mensaje sobre el tiempo oficial
		                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['mensajeTO']?>"></i>
		                                    </label>
		                                    <textarea class="form-control" name="mensajeTO" id="mensajeTO">
		                                        <?php echo $campana['mensajeTO']; ?>
		                                    </textarea>
		                                </div>		
		                                <div class="form-group">
		                                    <label>Fecha inicio tiempo oficial 
		                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_inicio_to']?>"></i>
		                                    </label>
		                                    <input type="text" value="<?php if($campana['fecha_inicio_to'] != '0000-00-00'){ echo $campana['fecha_inicio_to'];}else { echo '';} ?>" class="form-control" id="fecha_inicio_to" name="fecha_inicio_to" autocomplete="off"/>
		                                </div>		
		                                <div class="form-group">
		                                    <label>Fecha t&eacute;rmino tiempo oficial
		                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_termino_to']?>"></i> 
		                                    </label>
		                                    <input type="text" value="<?php if($campana['fecha_termino_to'] != '0000-00-00'){ echo $campana['fecha_termino_to'];}else { echo '';} ?>" class="form-control" id="fecha_termino_to" name="fecha_termino_to" autocomplete="off"/>
		                                </div>
		                                <div class="form-group">
		                                    <label>Medio de comunicación
		                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title=""></i>
		                                    </label>
		                                    <select name="id_servicio_categoria" class="form-control">
		                                        <?php echo $sel_categorias; ?>
		                                    </select> 
		                                </div>
		                                <div class="form-group">
		                                    <label>Descripción de unidad, por ejemplo: spot de 30 segundos (radio); mensaje en TV 20 segundos
		                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['descripcion_unidad']?>"></i>
		                                    </label>
		                                    <?php $class = "form-control";
                                            echo form_input(array('type' => 'text', 'name' => 'descripcion_unidad', 'value' => $campana['descripcion_unidad'], 'class' => $class)); ?>  
		                                </div>
		                                <div class="form-group">
		                                    <label>Concesionario responsable de publicar la campaña o la comunicación correspondiente (razón social)
		                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['responsable_publisher']?>"></i>
		                                    </label>
		                                    <?php $class = "form-control";
                                            echo form_input(array('type' => 'text', 'name' => 'responsable_publisher', 'value' => $campana['responsable_publisher'], 'class' => $class)); ?>  
		                                </div>
		                                <div class="form-group">
		                                    <label>Distintivo y/o nombre comercial del concesionario responsable de publicar la campaña o comunicación
		                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['name_comercial']?>"></i>
		                                    </label>
		                                    <?php $class = "form-control";
                                            echo form_input(array('type' => 'text', 'name' => 'name_comercial', 'value' => $campana['name_comercial'], 'class' => $class)); ?>		                                   
		                                </div>
		                                <div class="form-group">
		                                    <label>Descripción breve de las razones que justifican la elección del proveedor
		                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['razones_supplier']?>"></i>
		                                    </label>
		                                    <?php $class = "form-control";
                                            echo form_input(array('type' => 'text', 'name' => 'razones_supplier', 'value' => $campana['razones_supplier'], 'class' => $class)); ?>
		                                </div>
		                                <div class="form-group">
		                                    <label>Área administrativa encargada de solicitar la difusión del mensaje o producto, en su caso
		                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['difusion_mensaje']?>"></i>
		                                    </label>
		                                    <?php $class = "form-control";
                                            echo form_input(array('type' => 'text', 'name' => 'difusion_mensaje', 'value' => $campana['difusion_mensaje'], 'class' => $class)); ?>
		                                </div>
		                                <div class="form-group">
		                                    <label>Número de factura, en su caso
		                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['num_factura']?>"></i>
		                                    </label>
		                                    <?php $class = "form-control";
                                            echo form_input(array('type' => 'text', 'name' => 'num_factura', 'value' => $campana['num_factura'], 'class' => $class)); ?>		                             
		                                </div>
		                      		</div>                              
								</div>
								 
		<script>
			function toOnChange(sel) {
				if (sel.value=="1"){								
					divT = document.getElementById("timeOficial");
					divT.style.display = "none";				
				}else{								
					divT = document.getElementById("timeOficial");
					divT.style.display = "";
			    }
			}
			
			window.onload= toOnChange;
		</script>						
									                               
         <!--   F I N      T I E M P O        O F I C I A L   --> 
                                
                                <div class="form-group">
                                    <label>Publicaci&oacute;n SEGOB.
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['segob']?>"></i> 
                                    </label>
                                    <?php $class = "form-control";
                                            echo form_input(array('type' => 'text', 'name' => 'publicacion_segob', 
                                            'value' => $campana['publicacion_segob'], 'class' => $class)); ?>  
                                </div>
                                <div class="form-group">
                                    <label>Documento del PACS
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['pacs']?>"></i> 
                                    </label>
                                     <select name="id_presupuesto" class="form-control">
                                        <?php echo $sel_pacs; ?>
                                    </select>  
                                </div>
                                <div class="form-group">
                                    <label>Fecha publicaci&oacute;n*
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_publicacion']?>"></i> 
                                    </label>
                                    <input type="text" value="<?php if($campana['fecha_dof'] != '0000-00-00'){ echo $campana['fecha_dof'];}else { echo '';} ?>" class="form-control" name="fecha_dof" id="fecha_dof" autocomplete="off"/>
                                </div>
                                <div class="form-group">
                                    <label>Evaluaci&oacute;n*
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['evaluacion']?>"></i>
                                    </label>
                                    <textarea class="form-control" name="evaluacion" id="evaluacion">
                                        <?php echo $campana['evaluacion']; ?>
                                    </textarea>
                                </div>
                                
                                <!-- CODIGO PARA CARGAR ARCHIVOS -->
                                <div class="form-group">
                                    <label class="custom-file-label"> Documento de evaluaci&oacute;n
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip"></i>
                                    </label>
                                </div>
                                <div class="input-group">
                                    <div id="file_by_save_documento" class="input-group-btn" style="<?php if($control_update['file_by_save_documento']) echo 'display:none;' ?>">
                                        <button class="btn btn-success" type="button" onclick="triggerClickDocumentoEdita('lanzar')">Subir archivo</button>
                                    </div>
                                    <div id="file_see_documento" class="input-group-btn" style="<?php if($control_update['file_see_documento']) echo 'display:none;' ?>">
                                        <button class="btn btn-info" type="button" onclick="triggerClickDocumentoEdita('ver')" >Ver archivo</button>
                                    </div>
                                    <div id="file_load_documento" class="input-group-btn" style="<?php if($control_update['file_load_documento']) echo 'display:none;' ?>">
                                        <button class="btn btn-success" type="button" ><i class="fa fa-refresh fa-spin"></i></button>
                                    </div>
                                    <input type="text" id="name_file_input_documento" placeholder="Ning&uacute;n archivo seleccionado" value="<?php echo $campana['evaluacion_documento']; ?>"  class="form-control" />
                                    <input type="hidden" id="file_evaluacion_nombre" name="file_evaluacion_nombre" value="<?php echo $campana['evaluacion_documento']; ?>" />
                                    <input type="file" name="file_programa_evaluacion" id="file_programa_evaluacion" class="hide" accept=".xlsx,.xls,.pdf,.doc,.docx"/>
                                    <div id="file_saved_documento" class="input-group-btn" style="<?php if($control_update['file_saved_documento']) echo 'display:none;' ?>">
                                        <button class="btn btn-danger" type="button" onclick="triggerClickDocumentoEdita('eliminar')" >Eliminar archivo</button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <p class="help-block" id="result_upload"><?php echo $control_update['mensaje_file_documento']; ?> </p>
                                </div>

                                <div class="form-group">
                                    <label>Estatus*
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['estatus']?>"></i>
                                    </label>
                                    <select name="active" class="form-control <?php if($error_active) echo 'has-error' ?>">
                                        <?php echo $sel_estatus; ?>
                                    </select>
                                </div> 

                                <div class="form-group">
                                    <label>Fecha de validaci&oacute;n
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_validacion']?>"></i>
                                    </label>
                                    <input type="text" value="<?php if($campana['fecha_validacion'] != '0000-00-00'){ echo $campana['fecha_validacion'];}else { echo '';} ?>" class="form-control" name="fecha_validacion" autocomplete="off"/>
                                </div>

                                <div class="form-group">
                                    <label>&Aacute;rea responsable de la informaci&oacute;n
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['area_responsable']?>"></i>
                                    </label>
                                    <?php $class = "form-control";
                                            echo form_input(array('type' => 'text', 'name' => 'area_responsable', 
                                            'value' => $campana['area_responsable'], 'class' => $class)); ?>  
                                </div>
                                <div class="form-group">
                                    <label>A&ntilde;o
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['anio']?>"></i>
                                    </label>
                                    <?php $class = "form-control"; $valor = $campana['periodo']; if($campana['periodo'] != '0')$valor = '';
                                            echo form_input(array('type' => 'text', 'name' => 'periodo', 
                                            'value' => $valor, 'class' => $class)); ?>  
                                </div>

                                <div class="form-group">
                                    <label>Fecha de actualizaci&oacute;n
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_actualizacion']?>"></i>
                                    </label>
                                    <input type="text" value="<?php if($campana['fecha_actualizacion'] != '0000-00-00'){ echo $campana['fecha_actualizacion'];}else { echo '';} ?>" class="form-control" name="fecha_actualizacion" autocomplete="off"/>
                                </div>
                                
                                <div class="form-group">
                                    <label>Nota
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['nota']?>"></i>
                                    </label>
                                    <textarea class="form-control" name="nota" id="nota">
                                        <?php echo $campana['nota']; ?>
                                    </textarea>
                                </div>

                                <br /><br />
                                
                                </div>
                            </div><!-- /.box-body -->
                            <div class="box-footer">
                                <button class="btn btn-primary" type="submit">Guardar</button>
                                <?php echo anchor("tpoadminv1/campanas/campanas/busqueda_campanas_avisos", "<button class='btn btn-default' type='button'>Regresar</button></td>"); ?>
                            </div>
                            <script type="text/javascript">
                                $('input:file').change(function (){
                                    upload_file_documento_edita();
                                });

                            </script>


                        </div><!-- /.box -->


                        <div class="tab-pane <?php if($this->session->flashdata('tab_flag')) echo 'active' ?>" id="tab_2"> 
                            <div class="box" id="tabla_edades"></div>
                        </div>

                        <div class="tab-pane <?php if($this->session->flashdata('tab_flag')) echo 'active' ?>" id="tab_3"> 
                            <div class="box" id="tabla_lugar"></div>
                        </div>

                        <div class="tab-pane <?php if($this->session->flashdata('tab_flag')) echo 'active' ?>" id="tab_4"> 
                            <div class="box" id="tabla_nivel"></div>
                        </div>

                        <div class="tab-pane <?php if($this->session->flashdata('tab_flag')) echo 'active' ?>" id="tab_5"> 
                            <div class="box" id="tabla_educacion"></div>
                        </div>

                        <div class="tab-pane <?php if($this->session->flashdata('tab_flag')) echo 'active' ?>" id="tab_6"> 
                            <div class="box" id="tabla_sexo"></div>
                        </div>

                        <div class="tab-pane <?php if($this->session->flashdata('tab_flag')) echo 'active' ?>" id="tab_7"> 
                            <div class="box" id="tabla_audios"></div>
                        </div>

                        <div class="tab-pane <?php if($this->session->flashdata('tab_flag')) echo 'active' ?>" id="tab_8"> 
                            <div class="box" id="tabla_imagenes"></div>
                        </div>

                        <div class="tab-pane <?php if($this->session->flashdata('tab_flag')) echo 'active' ?>" id="tab_9"> 
                        <div class="box" id="tabla_videos"></div>
                        </div>

                    </form>
                </div>
           
        </div>
        <!-- nav tabs custom-->

    </div>
</section>


<!-- Modal Details-->
<div class="modal fade" id="myModalPartida" role="dialog">
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
                            <b>Partida presupuestal*</b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_presupuesto_concepto']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item2_1"></td>
                    </tr>    
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Monto asignado* </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['monto_asignado']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item2_2"></td>
                    </tr>    
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Monto de modificaci&oacute;n* </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['monto_modificacion']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item2_3"></td>
                    </tr>    
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Fecha de validaci&oacute;n </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_validacion']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item2_4"></td>
                    </tr>    
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>&Aacute;rea responsable de la informaci&oacute;n</b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['area_responsable']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item2_5"></td>
                    </tr>  
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>A&ntilde;o</b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['periodo']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item2_6"></td>
                    </tr>     
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Fecha de actualizaci&oacute;n </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_actualizacion']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item2_7"></td>
                    </tr>    
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Nota </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['nota']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item2_8">
                        </td>
                    </tr>   
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Estatus*</b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['active']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item2_9">
                        </td>
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


<!-- Modal -->

<div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false" href="#">
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

    var triggerClickDocumentoEdita = function(action){
        if( action == 'lanzar'){
            $("input[name='file_programa_evaluacion']").trigger("click");
            //upload_file_documento();
        }else if(action == 'eliminar') {
            eliminar_archivo_documento_edita();
        }
    }

    var eliminar_archivo_documento_edita = function()
    {
        if($('#name_file_programa_imagen').val() != ''){
            $('#file_by_save').hide();
            $('#file_saved').hide();
            $('#file_load').show();
            $('#file_see').hide();
            var form_data = new FormData();                  
            form_data.append('file_programa_imagen', $('#name_file_programa_imagen').val());                           
            $.ajax({
                url: '<?php echo base_url() . 'index.php/tpoadminv1/campanas/campanas/clear_file_documento' ?>', // point to server-side PHP script 
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
                complete: function(){
                },
                success: function(response){
                    $('#file_by_save_documento').show();
                    $('#file_saved_documento').hide();
                    $('#file_load_documento').hide();
                    $('#file_see_documento').hide();
                    $('#result_upload').html('Formatos permitidos PDF, WORD y EXCEL.');
                    $('#name_file_input_documento').val('');
                    $("input[name='file_programa_anual']").val(null);
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

    var upload_file_documento_edita = function (){
        if($("input[name='file_programa_evaluacion']")[0].files.length > 0){
            $('#name_file_input').val($("input[name='file_programa_evaluacion']")[0].files[0].name );
            $('#file_load').show();
            $('#file_by_save').hide();
            var file_data = $('#file_programa_evaluacion').prop('files')[0];   
            var form_data = new FormData();                  
            form_data.append('file_programa_evaluacion', file_data);                           
            $.ajax({
                url: '<?php echo base_url() . 'index.php/tpoadminv1/campanas/campanas/upload_file_documento_edita' ?>', // point to server-side PHP script 
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
                complete: function(){
                },
                success: function(response){

                    if (response.match('Error')) 
                    {
                        $('#file_by_save_documento').show();
                        $('#file_saved_documento').hide();
                        $('#file_load_documento').hide();
                        $('#file_see_documento').hide();
                        $('#result_upload').html('<span class="text-warning">El tamaño máximo para la carga de archivos es de 20MB.</span>');
                        $('#name_file_input_documento').val('');
                        $('#file_evaluacion_nombre').val('');
                    }

                    if(response != ''){
                        var data = $.parseJSON(response);
                        if(data[0] == 'exito'){
                            $('#file_by_save_documento').hide();
                            $('#file_saved_documento').show();
                            $('#file_load_documento').hide();
                            $('#file_see_documento').hide();
                            $('#result_upload').html('<span class="text-success">Archivo cargado correctamente</span>');
                            $('#name_file_input_documento').val(data[1]);
                            $('#file_evaluacion_nombre').val(data[1]);
                        }else{
                            $('#file_by_save_documento').show();
                            $('#file_saved_documento').hide();
                            $('#file_load_documento').hide();
                            $('#file_see_documento').hide();
                            $('#result_upload').html(data[1]);
                            $('#name_file_input_documento').val('');
                            $("input[name='file_programa_evaluacion']").val(null);
                            $('#name_file_imagen').val('');
                            $('#file_evaluacion_nombre').val(data[1]);
                        }
                    }
                }, 
                error: function(){
                    $('#file_by_save_documento').show();
                    $('#file_saved_documento').hide();
                    $('#file_load_documento').hide();
                    $('#file_see_documento').hide();
                    $('#result_upload').html('<span class="text-success">No fue posible subir el archivo</span>');
                    $('#name_file_input_documento').val('');
                    $("input[name='file_programa_evaluacion']").val(null);
                    $('#name_file_imagen').val('');
                    $('#file_archivo_nombre').val('');
                }
            });
        }
        
    }

    //FUNCIONES TRIGGER
    var triggerClick = function(action){
        if( action == 'lanzar'){
            $("input[name='file_programa_anual']").trigger("click");
        }else if(action == 'eliminar') {
            eliminar_archivo();
        }
    }

    
    var triggerClickEdita = function(action){
        if( action == 'lanzar'){
            $("input[name='file_programa_anual_edita']").trigger("click");
        }else if(action == 'eliminar') {
            eliminar_audio_edita();
            //alert('asdlñasdasd');
        }
    }


    var ImagenTriggerClick = function(action){
        if( action == 'lanzarImagen'){
            $("input[name='file_campana_imagen']").trigger("click");
        }else if(action == 'eliminarImagen') {
            eliminar_archivo_imagen();
        }
    }


    var ImagenTriggerClickEdita = function(action){
        
        if( action == 'lanzarImagen'){
            $("input[name='file_campana_edita_imagen']").trigger("click");
        }else if(action == 'eliminarImagen') {
            eliminar_edita_archivo_imagen();
        }
    }


    var VideoTriggerClick = function(action){
        if( action == 'lanzarVideo'){
            $("input[name='file_campana_video']").trigger("click");
        }else if(action == 'eliminarVideo') {

            //alert('Eliminar video');

            eliminar_archivo_video();
        }
    }


    var VideoTriggerClickEdita = function(action){
        
        if( action == 'lanzarVideo'){
            $("input[name='file_campana_video_edita']").trigger("click");
        }else if(action == 'eliminarVideo') {
            //alert('EDITA ELIMINAR IMAGEN');
            eliminar_edita_archivo_video();
        }
    }
    
    
    $(document).ready(function(){
        $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
            localStorage.setItem('activeTab', $(e.target).attr('href'));
        });
        var activeTab = localStorage.getItem('activeTab');
        if(activeTab){
            $('#myTab a[href="' + activeTab + '"]').tab('show');
        }
    });


    var eliminarModal = function(id, id2 ,name){
        var html_btns = '<button type="button" class="btn btn-danger" onclick="eliminar('+id+', '+ id2 +')">Si</button>' +
                   '<button type="button" class="btn btn-default" data-dismiss="modal">No</button>';
        $('#myModalDelete').find('#footer_btns').html(html_btns);
        $('#myModalDelete').find('#mensaje_modal').html('¿Desea eliminar la partida presupuestal <b>' + name+ '</b>?');
        $('#myModalDelete').modal('show');
    }

    var eliminar = function (id, id2){
        window.location.href = '<?php echo base_url() . 'index.php/tpoadminv1/capturista/presupuestos/eliminar_presupuesto_partida/' ?>'+id+ "/"+ id2 ;
    }

    var abrirModalPartida = function(id){ 

        $.ajax({
            url: '<?php echo base_url() . 'index.php/tpoadminv1/capturista/presupuestos/get_presupuesto_desglose/' ?>'+id,
            data: {action: 'test'},
            dataType:'JSON',
            beforeSend: function () {
                $('#myModalPartida').find('#loading_modal').html('<span><i class="fa fa-spinner"><i> Cargando...</span>'); 
            },
            complete: function () {
                $('#myModalPartida').find('#loading_modal').html(''); 
            },
            error:function () {
                $('#myModalPartida').modal('hide');
            },
            success: function (response) {
                if(response){
                    $('#myModalPartida').find('#item2_1').html(response.nombre_presupuesto_concepto);
                    $('#myModalPartida').find('#item2_2').html(response.monto_presupuesto_format);
                    $('#myModalPartida').find('#item2_3').html(response.monto_modificacion_format);
                    $('#myModalPartida').find('#item2_4').html(response.fecha_validacion);
                    $('#myModalPartida').find('#item2_5').html(response.area_responsable);
                    $('#myModalPartida').find('#item2_6').html(response.periodo);
                    $('#myModalPartida').find('#item2_7').html(response.fecha_actualizacion);
                    $('#myModalPartida').find('#item2_8').html(response.nota);
                    $('#myModalPartida').find('#item2_9').html(response.estatus);
                    $('#myModalPartida').modal('show'); 
                }
            }
        });
    }


    //CAMPANAS IMAGENES

        //ALTA IMAGENES
        var upload_file_imagen = function (){
                                if($("input[name='file_campana_imagen']")[0].files.length > 0){
                                    $('#name_file_input').val($("input[name='file_campana_imagen']")[0].files[0].name );
                                    $('#file_load_agregar_imagen').show();
                                    $('#file_by_save_agregar_imagen').hide();
                                    var file_data = $('#file_campana_imagen').prop('files')[0];   
                                    var form_data = new FormData();                  
                                    form_data.append('file_campana_imagen', file_data);                           
                                    $.ajax({
                                        url: '<?php echo base_url() . 'index.php/tpoadminv1/campanas/campanas/upload_file_imagen' ?>', // point to server-side PHP script 
                                        dataType: 'text',  // what to expect back from the PHP script, if anything
                                        cache: false,
                                        contentType: false,
                                        processData: false,
                                        data: form_data,                         
                                        type: 'post',
                                        complete: function(){
                                        },
                                        success: function(response){
                                            //alert('EXITO');
                                            if(response != ''){
                                                var data = $.parseJSON(response);
                                                if(data[0] == 'exito'){
                                                    $('#file_by_save_agregar_imagen').hide();
                                                    $('#file_saved_agregar_imagen').show();
                                                    $('#file_load_agregar_imagen').hide();
                                                    $('#file_see_agregar_imagen').hide();
                                                    $('#result_upload').html('<span class="text-success">Archivo cargado correctamente</span>');
                                                    $('#name_file_campana_imagen').val(data[1]);
                                                    $('#name_file_agregar_imagen').val(data[1]);
                                                }else{
                                                    $('#file_by_save_agregar_imagen').show();
                                                    $('#file_saved_agregar_imagen').hide();
                                                    $('#file_load_agregar_imagen').hide();
                                                    $('#file_see_agregar_imagen').hide();
                                                    $('#result_upload_agregar_imagen').html(data[1]);
                                                    $('#name_file_input').val('');
                                                    $("input[name='file_campana_imagen']").val(null);
                                                    $('#name_file_campana_imagen').val('');
                                                    //$('#file_archivo_nombre').val(data[1]);
                                                }
                                            }
                                        }
                                    });
                                }
                                
        }

        var eliminar_archivo_imagen = function()
        {
            if($('#name_file_campana_imagen').val() != ''){
                $('#file_by_save_agregar_imagen').hide();
                $('#file_saved_agregar_imagen').hide();
                $('#file_load_agregar_imagen').show();
                $('#file_see_agregar_imagen').hide();
                var form_data = new FormData();                  
                form_data.append('name_file_campana_imagen', $('#name_file_campana_imagen').val());                           
                $.ajax({
                    url: '<?php echo base_url() . 'index.php/tpoadminv1/campanas/campanas/clear_file_imagen' ?>', // point to server-side PHP script 
                    dataType: 'text',  // what to expect back from the PHP script, if anything
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,                         
                    type: 'post',
                    complete: function(){
                    },
                    success: function(response){
                        $('#file_by_save_agregar_imagen').show();
                        $('#file_saved_agregar_imagen').hide();
                        $('#file_load_agregar_imagen').hide();
                        $('#file_see_agregar_imagen').hide();
                        $('#result_upload').html('Formatos permitidos JPG y PNG.');
                        $('#name_file_input').val('');
                        $("input[name='name_file_campana_imagen']").val(null);
                        $('#name_file_agregar_imagen').val('');
                        //$('#file_archivo_nombre').val('');
                    }
                });
            }
        }


        //EDITA IMAGENES
        var upload_file_edita_imagen = function ()
        {
                                if($("input[name='file_campana_edita_imagen']")[0].files.length > 0){
                                    $('#name_file_input').val($("input[name='file_campana_edita_imagen']")[0].files[0].name );
                                    $('#file_load_edita_imagen').show();
                                    $('#file_by_save_edita_imagen').hide();
                                    var file_data = $('#file_campana_edita_imagen').prop('files')[0];   
                                    var form_data = new FormData();                  
                                    form_data.append('file_campana_edita_imagen', file_data);                           
                                    $.ajax({
                                        url: '<?php echo base_url() . 'index.php/tpoadminv1/campanas/campanas/upload_file_edita_imagen' ?>', // point to server-side PHP script 
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

                                                    document.getElementById("file_by_save_edita_imagen").style.display = "none";
                                                    document.getElementById("file_see_edita_imagen").style.display = "none";
                                                    document.getElementById("file_load_edita_imagen").style.display = "none";
                                                    document.getElementById("file_saved_edita_imagen").style.display = "inline";
                                                    document.getElementById("result_upload_edita2").innerHTML = "Archivo cargado correctamente";
                                                    $('#name_file_imagen_edita').val(data[1]);
                                                    $('#name_file_campana_edita_imagen').val(data[1]);
                                                }else{
                                                    $('#file_by_save_edita_imagen').show();
                                                    $('#file_saved_edita_imagen').hide();
                                                    $('#file_load_edita_imagen').hide();
                                                    $('#file_see_edita_imagen').hide();
                                                    $('#result_upload_edita').html(data[1]);
                                                    $('#name_file_input_edita').val('');
                                                    $("input[name='file_campana_edita_imagen']").val(null);
                                                    $('#name_file_campana_edita_imagen').val('');
                                                    //$('#file_archivo_nombre').val(data[1]);
                                                }
                                            }
                                        },
                                        error: function(){
                                            document.getElementById("file_by_save_edita_imagen").style.display = "inline";
                                            document.getElementById("file_see_edita_imagen").style.display = "none";
                                            document.getElementById("file_load_edita_imagen").style.display = "none";
                                            document.getElementById("result_upload_edita2").innerHTML = "Error";
                                            //document.getElementById("result_upload_edita2").innerHTML = "Formatos permitidos JPG, PNG.";
                                            $('#name_file_imagen_edita').val(data[1]);
                                        }
                                    });
                                }
        }

        var eliminar_edita_archivo_imagen = function()
        {
            if($('#name_file_campana_imagen_edita').val() != ''){
                $('#file_by_save_edita_imagen').hide();
                $('#file_saved_edita_imagen').hide();
                $('#file_load_edita_imagen').show();
                $('#file_see_edita_imagen').hide();
                var form_data = new FormData();                  
                form_data.append('name_file_campana_imagen', $('#file_campana_imagen_edita').val());                           
                $.ajax({
                    url: '<?php echo base_url() . 'index.php/tpoadminv1/campanas/campanas/clear_file_imagen' ?>', // point to server-side PHP script 
                    dataType: 'text',  // what to expect back from the PHP script, if anything
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,                         
                    type: 'post',
                    complete: function(){
                    },
                    success: function(response){
                        $('#file_by_save_edita_imagen').show();
                        $('#file_saved_edita_imagen').hide();
                        $('#file_load_edita_imagen').hide();
                        $('#file_see_edita_imagen').hide();
                        $('#result_upload_edita2').html('Formatos permitidos JPG, PNG.');
                        $('#name_file_input').val('');
                        $("input[name='name_file_campana_edita_imagen']").val(null);
                        $('#name_file_imagen_edita').val('');
                    },
                    error: function(){
                        $('#file_by_save_edita_imagen').hide();
                        $('#file_saved_edita_imagen').show();
                        $('#file_load_edita_imagen').hide();
                        $('#file_see_edita_imagen').hide();
                        $('#result_upload_edita2').html(data[1]); 
                    }
                });
            }
        }


    //VIDEOS

        //ALTA VIDEO
        var upload_file_video = function (){
                                if($("input[name='file_campana_video']")[0].files.length > 0){
                                    $('#name_file_input').val($("input[name='file_campana_video']")[0].files[0].name );
                                    $('#file_load').show();
                                    $('#file_by_save').hide();
                                    var file_data = $('#file_campana_video').prop('files')[0];   
                                    var form_data = new FormData();                  
                                    form_data.append('file_campana_video', file_data);                           
                                    $.ajax({
                                        url: '<?php echo base_url() . 'index.php/tpoadminv1/campanas/campanas/upload_file_video' ?>', // point to server-side PHP script 
                                        dataType: 'text',  // what to expect back from the PHP script, if anything
                                        cache: false,
                                        contentType: false,
                                        processData: false,
                                        data: form_data,                         
                                        type: 'post',
                                        complete: function(){
                                        },
                                        success: function(response){

                                            if (response.match('Error')) 
                                            {
                                                //alert('encontrado');
                                                $('#file_by_save').show();
                                                $('#file_saved').hide();
                                                $('#file_load').hide();
                                                $('#file_see').hide();
                                                $('#result_upload').html('<span class="text-warning">El tamaño máximo para la carga de archivos es de 20MB.</span>');
                                                $('#name_file_input').val('');
                                                $("input[name='name_file_agregar_video']").val(null);
                                                $('#name_file_campana_video').val('');

                                                /*Match found */
                                            }


                                            //alert('EXITO VIDEO');
                                            //alert(response);
                                            if(response != ''){
                                                var data = $.parseJSON(response);
                                                if(data[0] == 'exito'){
                                                    $('#file_by_save').hide();
                                                    $('#file_saved').show();
                                                    $('#file_load').hide();
                                                    $('#file_see').hide();
                                                    $('#result_upload').html('<span class="text-success">Archivo cargado correctamente</span>');
                                                    $('#name_file_agregar_video').val(data[1]);
                                                    $('#name_file_campana_video').val(data[1]);
                                                }else{
                                                    $('#file_by_save').show();
                                                    $('#file_saved').hide();
                                                    $('#file_load').hide();
                                                    $('#file_see').hide();
                                                    $('#result_upload').html(data[1]);
                                                    $('#name_file_input').val('');
                                                    $("input[name='file_campana_video']").val(null);
                                                    $('#name_file_campana_video').val('');
                                                    //$('#file_archivo_nombre').val(data[1]);
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
                                            $("input[name='file_campana_video']").val(null);
                                            $('#name_file_campana_video').val('');
                                            //$('#file_archivo_nombre').val('');
                                        }
                                    });
                                }
                                
        }

        var eliminar_archivo_video = function()
        {
            if($('#name_file_campana_video').val() != ''){
                $('#file_by_save').hide();
                $('#file_saved').hide();
                $('#file_load').show();
                $('#file_see').hide();
                var form_data = new FormData();                  
                form_data.append('file_programa_video', $('#name_file_campana_video').val());                           
                $.ajax({
                    url: '<?php echo base_url() . 'index.php/tpoadminv1/campanas/campanas/clear_file_video' ?>', // point to server-side PHP script 
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
                        $('#result_upload').html('Formatos permitidos AVI, MPEG, MOV, WMV.');
                        $('#name_file_input').val('');
                        $("input[name='name_file_campana_video']").val(null);
                        $('#name_file_agregar_video').val('');
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


        //EDITA VIDEO
        var upload_file_edita_video = function ()
        {
            if($("input[name='file_campana_video_edita']")[0].files.length > 0)
            {
                $('#name_file_input').val($("input[name='file_campana_video_edita']")[0].files[0].name );
                $('#file_load_video_edita').show();
                $('#file_by_save_video_edita').hide();
                var file_data = $('#file_campana_video_edita').prop('files')[0];   
                var form_data = new FormData();                  
                form_data.append('file_campana_video_edita', file_data);                           
                $.ajax({
                    url: '<?php echo base_url() . 'index.php/tpoadminv1/campanas/campanas/upload_file_edita_video' ?>', // point to server-side PHP script 
                    dataType: 'text',  // what to expect back from the PHP script, if anything
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,                         
                    type: 'post',
                    complete: function(){
                    },
                    success: function(response)
                    {
                        if (response.match('Error')) 
                        {
                            $('#file_by_save_video_edita').show();
                            $('#file_saved_video_edita').hide();
                            $('#file_load_video_edita').hide();
                            $('#file_see_video_edita').hide();
                            $('#result_upload_edita2').html('<span class="text-warning">El tamaño máximo para la carga de archivos es de 20MB.</span>');
                            $('#name_file_input2').val('');
                            $("input[name='name_file_campana_video_edita']").val(null);
                            $('#name_file_campana_video').val('');
                        }

                        if(response != '')
                        {
                            var data = $.parseJSON(response);
                            if(data[0] == 'exito')
                            {
                                document.getElementById("file_by_save_video_edita").style.display = "none";
                                document.getElementById("file_see_video_edita").style.display = "none";
                                document.getElementById("file_load_video_edita").style.display = "none";
                                document.getElementById("file_saved_video_edita").style.display = "inline";
                                document.getElementById("result_upload_edita2").innerHTML = "Archivo cargado correctamente";
                                $('#name_file_video').val(data[1]);
                                $('#name_file_campana_video_edita').val(data[1]);
                            }
                            else
                            {
                                $('#file_by_save_video_edita').show();
                                $('#file_saved_video_edita').hide();
                                $('#file_load_video_edita').hide();
                                $('#file_see_video_edita').hide();
                                $('#result_upload_edita').html(data[1]);
                                $('#name_file_input_edita').val('');
                                $("input[name='file_campana_video_edita']").val(null);
                                $('#name_file_campana_video_edita').val('');
                                //$('#file_archivo_nombre').val(data[1]);
                            }
                        }
                    },
                    error: function(){
                        document.getElementById("file_by_save_video_edita").style.display = "inline";
                        document.getElementById("file_see_video_edita").style.display = "none";
                        document.getElementById("file_load_video_edita").style.display = "none";
                        document.getElementById("result_upload_edita2").innerHTML = "Error";
                        //document.getElementById("result_upload_edita2").innerHTML = "Formatos permitidos JPG, PNG.";
                        $('#name_file_imagen').val(data[1]);
                    },
                    alert: function(){
                        //alert('ALERT');
                        document.getElementById("file_by_save_video_edita").style.display = "inline";
                        document.getElementById("file_see_video_edita").style.display = "none";
                        document.getElementById("file_load_video_edita").style.display = "none";
                        document.getElementById("result_upload_edita2").innerHTML = "Alerta";
                        //document.getElementById("result_upload_edita2").innerHTML = "Formatos permitidos JPG, PNG.";
                        $('#name_file_imagen').val(data[1]);
                    }
                });
            }
        }
    
        var eliminar_edita_archivo_video = function()
        {
            if($('#name_file_campana_video_edita').val() != ''){
                $('#file_by_save_video_edita').hide();
                $('#file_saved_video_edita').hide();
                $('#file_load_video_edita').show();
                $('#file_see_video_edita').hide();
                var form_data = new FormData();                  
                form_data.append('name_file_campana_video', $('#file_campana_video_edita').val());                           
                $.ajax({
                    url: '<?php echo base_url() . 'index.php/tpoadminv1/campanas/campanas/clear_file_video' ?>', // point to server-side PHP script 
                    dataType: 'text',  // what to expect back from the PHP script, if anything
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,                         
                    type: 'post',
                    complete: function(){
                    },
                    success: function(response){
                        $('#file_by_save_video_edita').show();
                        $('#file_saved_video_edita').hide();
                        $('#file_load_video_edita').hide();
                        $('#file_see_video_edita').hide();
                        $('#result_upload_edita2').html('Formatos permitidos AVI, MPEG, MOV, WMV.');
                        $('#name_file_input').val('');
                        $("input[name='name_file_campana_video_edita']").val(null);
                        $('#name_file_video').val('');
                        //$('#file_archivo_nombre').val('');
                    },
                });
            }
        }


    //AUDIOS

        //ALTA AUDIO
        var upload_file = function ()
        {
            if($("input[name='file_programa_anual']")[0].files.length > 0)
            {
                $('#name_file_input').val($("input[name='file_programa_anual']")[0].files[0].name );
                $('#file_load').show();
                $('#file_by_save').hide();
                var file_data = $('#file_programa_anual').prop('files')[0];   
                var form_data = new FormData();                  
                form_data.append('file_programa_anual', file_data);                           
                $.ajax({
                    url: '<?php echo base_url() . 'index.php/tpoadminv1/campanas/campanas/upload_file' ?>', // point to server-side PHP script 
                    dataType: 'text',  // what to expect back from the PHP script, if anything
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,                         
                    type: 'post',
                    complete: function(){
                    },
                    success: function(response){

                        if (response.match('Error')) 
                        {
                            //alert('encontrado');
                            $('#file_by_save').show();
                            $('#file_saved').hide();
                            $('#file_load').hide();
                            $('#file_see').hide();
                            $('#result_upload_agrega').html('<span class="text-warning">El tamaño máximo para la carga de archivos es de 20MB.</span>');
                            $('#name_file_input').val('');
                            $("input[name='file_programa_anual']").val(null);
                            $('#name_file_programa_anual').val('');
                        }

                        if(response != ''){
                            var data = $.parseJSON(response);
                            if(data[0] == 'exito'){
                                $('#file_by_save_audio_agrega').hide();
                                $('#file_saved_audio_agrega').show();
                                $('#file_load_audio_agrega').hide();
                                $('#file_see_audio_agrega').hide();
                                $('#result_upload_agrega').html('<span class="text-success">Archivo cargado correctamente</span>');
                                $('#name_file_programa_anual').val(data[1]);
                                //$('#file_archivo_nombre').val(data[1]);
                                
                            }else{
                                $('#file_by_save_audio_agrega').show();
                                $('#file_saved_audio_agrega').hide();
                                $('#file_load_audio_agrega').hide();
                                $('#file_see_audio_agrega').hide();
                                $('#result_upload_agrega').html(data[1]);
                                $('#name_file_input').val('');
                                $("input[name='file_programa_anual']").val(null);
                                $('#name_file_programa_anual').val('');
                                //$('#file_archivo_nombre').val(data[1]);
                            }
                        }
                    },
                    error: function(){
                        $('#file_by_save').show();
                        $('#file_saved').hide();
                        $('#file_load').hide();
                        $('#file_see').hide();
                        $('#result_upload_agrega').html('<span class="text-success">No fue posible subir el archivo</span>');
                        $('#name_file_input').val('');
                        $("input[name='file_programa_anual']").val(null);
                        $('#name_file_programa_anual').val('');
                        //$('#file_archivo_nombre').val('');
                    }
                });
            }
        }

        var eliminar_archivo = function()
        {
            //if($('#name_file_programa_anual').val() != ''){
            if($('#name_file_programa_anual').val() != ''){
                $('#file_by_save_audio_agrega').hide();
                $('#file_saved_audio_agrega').hide();
                $('#file_load_audio_agrega').show();
                $('#file_see_audio_agrega').hide();
                var form_data = new FormData();                  
                //form_data.append('file_programa_anual', $('#name_file_programa_anual').val());
                form_data.append('name_file_input', $('#name_file_programa_anual').val());
                //name_file_input                  
                $.ajax({
                    url: '<?php echo base_url() . 'index.php/tpoadminv1/campanas/campanas/clear_file_agregar' ?>', // point to server-side PHP script 
                    dataType: 'text',  // what to expect back from the PHP script, if anything
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,                         
                    type: 'post',
                    complete: function(){
                    },
                    success: function(response){
                        $('#file_by_save_audio_agrega').show();
                        $('#file_saved_audio_agrega').hide();
                        $('#file_load_audio_agrega').hide();
                        $('#file_see_audio_agrega').hide();
                        $('#result_upload_agrega').html('Formatos permitidos MP3, ACC, WMA y WAV.');
                        $('#name_file_input').val('');
                        $("input[name='file_programa_anual']").val(null);
                        $('#name_file_programa_anual').val('');
                        //$('#file_archivo_nombre').val('');
                    },
                    error: function(){
                        $('#file_by_save_audio_agrega').hide();
                        $('#file_saved_audio_agrega').show();
                        $('#file_load_audio_agrega').hide();
                        $('#file_see_audio_agrega').hide();
                        $('#result_upload_agrega').html(data[1]); 
                    }
                });
            }
        }

        //EDITA AUDIO
        var eliminar_audio_edita = function()
        {
            if($('#name_file_audio').val() != '')
            {
                $('#file_by_save_audio_edita').hide();
                $('#file_saved_audio_edita').hide();
                $('#file_load_audio_edita').show();
                $('#file_see_audio_edita').hide();
                var form_data = new FormData();                  
                form_data.append('name_file_audio', $('#name_file_audio').val());                           
                $.ajax({
                url: '<?php echo base_url() . 'index.php/tpoadminv1/campanas/campanas/clear_file' ?>', // point to server-side PHP script 
                    dataType: 'text',  // what to expect back from the PHP script, if anything
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,                         
                    type: 'post',
                    complete: function(){
                    },
                    success: function(response){

                        if (response.match('Error')) 
                        {
                            //alert('encontrado');
                            $('#file_by_save_audio_edita').show();
                            $('#file_saved_audio_edita').hide();
                            $('#file_load_audio_edita').hide();
                            $('#file_see_audio_edita').hide();
                            $('#result_upload_audio_edita').html('<span class="text-warning">El tamaño máximo para la carga de archivos es de 20MB.</span>');
                            $('#name_file_input').val('');
                            $("input[name='file_programa_anual']").val(null);
                            $('#name_file_programa_anual').val('');

                            /*Match found */
                        }


                        $('#file_by_save_audio_edita').show();
                        $('#file_saved_audio_edita').hide();
                        $('#file_load_audio_edita').hide();
                        $('#file_see_audio_edita').hide();
                        $('#result_upload_edita2').html('Formatos permitidos MP3, ACC, WMA y WAV.');
                        $('#name_file_audio_edita').val('');
                        $('#campana_file_audio_edita').val('');
                        //$("input[name='file_programa_anual_edita']").val(null);
                        
                        //$('#file_archivo_nombre').val('');
                    },
                                        error: function(){
                                            $('#file_by_save_edita').hide();
                                            $('#file_saved_edita').show();
                                            $('#file_load_edita').hide();
                                            $('#file_see_edita').hide();
                                            $('#result_upload_edita').html(data[1]); 
                                        }
                                    });
                                }
        }


    //FIN FUNCIONES REVISADAS
    
    var eliminar_archivo_imagen22 = function()
    {
        if($('#name_file_programa_imagen').val() != ''){
            $('#file_by_save').hide();
            $('#file_saved').hide();
            $('#file_load').show();
            $('#file_see').hide();
            var form_data = new FormData();                  
            form_data.append('file_programa_imagen', $('#name_file_programa_imagen').val());                           
            $.ajax({
                url: '<?php echo base_url() . 'index.php/tpoadminv1/campanas/campanas/clear_file_imagenes' ?>', // point to server-side PHP script 
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
                    $('#result_upload').html('Formatos permitidos JPG, PNG.');
                    $('#name_file_input').val('');
                    $("input[name='file_programa_anual']").val(null);
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

    var upload_file_imagen2 = function (){
        if($("input[name='imagen_file']")[0].files.length > 0){
            $('#name_file_input').val($("input[name='imagen_file']")[0].files[0].name );
            $('#file_load').show();
            $('#file_by_save').hide();
            var file_data = $('#imagen_file').prop('files')[0];   
            var form_data = new FormData();                  
            form_data.append('imagen_file', file_data);                           
            $.ajax({
                url: '<?php echo base_url() . 'index.php/tpoadminv1/campanas/campanas/upload_file_imagen' ?>', // point to server-side PHP script 
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
                            $('#name_imagen_file').val(data[1]);
                            $('#file_archivo_nombre').val(data[1]);
                            
                            
                        }else{
                            $('#file_by_save').show();
                            $('#file_saved').hide();
                            $('#file_load').hide();
                            $('#file_see').hide();
                            $('#result_upload').html(data[1]);
                            $('#name_file_input').val('');
                            $("input[name='file_programa_imagen']").val(null);
                            $('#name_imagen_file').val('');
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
                    $('#name_imagen_file').val('');
                    $('#file_archivo_nombre').val('');
                }
            });
        }
        
    }


    var upload_file_video23 = function (){
        if($("input[name='file_programa_video']")[0].files.length > 0){
            $('#name_file_input').val($("input[name='file_programa_video']")[0].files[0].name );
            $('#file_load').show();
            $('#file_by_save').hide();
            var file_data = $('#file_programa_video').prop('files')[0];   
            var form_data = new FormData();                  
            form_data.append('file_programa_video', file_data);                           
            $.ajax({
                url: '<?php echo base_url() . 'index.php/tpoadminv1/campanas/campanas/upload_file_video' ?>', // point to server-side PHP script 
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
                            $('#name_file_programa_video').val(data[1]);
                            $('#file_archivo_nombre').val(data[1]);
                            
                        }else{
                            $('#file_by_save').show();
                            $('#file_saved').hide();
                            $('#file_load').hide();
                            $('#file_see').hide();
                            $('#result_upload').html(data[1]);
                            $('#name_file_input').val('');
                            $("input[name='file_programa_video']").val(null);
                            $('#name_file_programa_video').val('');
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
                    $("input[name='file_programa_video']").val(null);
                    $('#name_file_programa_video').val('');
                    $('#file_archivo_nombre').val('');
                }
            });
        }
        
    }


    var triggerClickImagen = function(action){
        if( action == 'lanzar'){
            $("input[name='file_programa_imagen']").trigger("click");
        }else if(action == 'eliminar') {
            eliminar_archivo_imagen();
        }
    }

    var triggerClickVideo = function(action){
        if( action == 'lanzar'){
            $("input[name='file_programa_video']").trigger("click");
        }else if(action == 'eliminar') {
            eliminar_archivo_video();
        }
    }

    var agregarAudio = function(){
        $('#modalAgregarAudio').modal('show');
    }


    var agregarVideo = function(){
        $('#modalAgregarVideo').modal('show');
    }

   
    var abrirModal = function(){

        $('#myModal').modal('show');
    }

    function verificar($id_campana_aviso)
    {
        $('#tabla_edades').load('busqueda_camp_edades?id_campana_aviso='+$id_campana_aviso, function(output) {

        });

    }

    function lugar($id_campana_aviso)
    {
        $('#tabla_lugar').load('alta_camp_lugar?id_campana_aviso='+$id_campana_aviso, function(output) {
            //alert(output);
        });
    }

    function nivel($id_campana_aviso)
    {
        $('#tabla_nivel').load('alta_camp_nivel?id_campana_aviso='+$id_campana_aviso, function(output) {
            //alert(output);
        });
    }

    function educacion($id_campana_aviso)
    {
        $('#tabla_educacion').load('alta_camp_educacion?id_campana_aviso='+$id_campana_aviso, function(output) {
            //alert(output);
        });
    }

    function sexo($id_campana_aviso)
    {
        $('#tabla_sexo').load('alta_camp_sexo?id_campana_aviso='+$id_campana_aviso, function(output) {
            //alert(output);
        });
    }

    function audios($id_campana_aviso)
    {
        $('#tabla_audios').load('alta_camp_audios?id_campana_aviso='+$id_campana_aviso, function(output) {
            //alert(output);
        });
    }

     
    function imagenes($id_campana_aviso)
    {
        $('#tabla_imagenes').load('alta_camp_imagenes?id_campana_aviso='+$id_campana_aviso, function(output) {
            //alert(output);
        });
    }
    

    function videos($id_campana_aviso)
    {
        $('#tabla_videos').load('alta_camp_videos?id_campana_aviso='+$id_campana_aviso, function(output) {
            //alert(output);
        });
    }


    //Despues de actualizar un tab, el refresh nos dejara en la pestana que fue modificada
    $(document).ready(function(){

        var id_campana_aviso = <?php echo $this->session->userdata('id_campana_aviso')?>;

        $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
            localStorage.setItem('activeTab', $(e.target).attr('href'));
        });
        var activeTab = localStorage.getItem('activeTab');

        $('#pestanas a[href="' + activeTab + '"]').tab('show');


        if(activeTab == '#tab_2')
        {
            $('#tabla_edades').load('busqueda_camp_edades?id_campana_aviso='+id_campana_aviso, function(output) {
            });
        }

        if(activeTab == '#tab_3')
        {
            $('#tabla_lugar').load('alta_camp_lugar?id_campana_aviso='+id_campana_aviso, function(output) {
                //alert(output);
            });
        }

        if(activeTab == '#tab_4')
        {
            $('#tabla_nivel').load('alta_camp_nivel?id_campana_aviso='+id_campana_aviso, function(output) {
                //alert(output);
            });
        }

        if(activeTab == '#tab_5')
        {
            $('#tabla_educacion').load('alta_camp_educacion?id_campana_aviso='+id_campana_aviso, function(output) {
                //alert(output);
            });
        }

        if(activeTab == '#tab_6')
        {
            $('#tabla_sexo').load('alta_camp_sexo?id_campana_aviso='+id_campana_aviso, function(output) {
                //alert(output);
            });
        }

        if(activeTab == '#tab_7')
        {
            $('#tabla_audios').load('alta_camp_audios?id_campana_aviso='+id_campana_aviso, function(output) {
                //alert(output);
            });
        }


        if(activeTab == '#tab_8')
        {
            $('#tabla_imagenes').load('alta_camp_imagenes?id_campana_aviso='+id_campana_aviso, function(output) {
                //alert(output);
            });
        }

        if(activeTab == '#tab_9')
        {
            $('#tabla_videos').load('alta_camp_videos?id_campana_aviso='+id_campana_aviso, function(output) {
                //alert(output);
            });
        }
    });


    var limitar_fecha = function(container){
        
        var ejercicio = $('select[name="id_ejercicio"] option:selected').text();
        var anio = anio_fecha(container);
        
        var inicio = $('select[name="id_ejercicio"] option:selected').text() +'/01/01';
        var fin = $('select[name="id_ejercicio"] option:selected').text() +'/12/31';
        var defaultDate = '01.01.' + $('select[name="id_ejercicio"] option:selected').text();
        //var defaultDate = $('select[name="id_ejercicio"] option:selected').text()+'-01-01';

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


    var anio_fecha2 = function(container){
        var fecha = $(container).val();
        if(fecha != '' && fecha != null){
            var aux = fecha.split('.');
            if(aux.length == 3){
                return aux[2];
            }
        }
        return '';
    }


    var dame_subtipos = function(container){
        var id_campana_tipo =  $(container).val();
        var subtipo = '<?php echo $campana['id_campana_subtipo'] ?>';

        //alert(subtipo);
        
        $.ajax({
            type:'POST',
            url:'busqueda_subtipo_edita',
            data: { 'id_campana_tipo':id_campana_tipo,'id_campana_subtipo':subtipo  },
            success:function(html){
                $('#id_campana_subtipo').html(html);
            }
        }); 
    }

    var dame_subtipos_post = function(container){
        var id_campana_tipo =  $(container).val();
        var subtipo = '<?php echo $this->input->post('id_campana_subtipo') ?>';
        
        //alert(subtipo);

        $.ajax({
            type:'POST',
            url:'busqueda_subtipo_post',
            data: { 'id_campana_tipo':id_campana_tipo,'id_campana_subtipo':subtipo  },
            success:function(html){
                $('#id_campana_subtipo').html(html);
            }
        }); 
    }

</script>

