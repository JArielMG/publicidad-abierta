<?php

/* 
 INAI / ALTA CAMPANA
 */

?>
<?php
//print_r($campana);

//Tipo
$sel_camp_tipo = '<option value="">- Selecciona -</option>';
for($z = 0; $z < sizeof($camp_tipo); $z++)
{
    if($this->input->post('id_campana_tipo') == $camp_tipo[$z]['id_campana_tipo']){
        $sel_camp_tipo .= '<option value="'.$camp_tipo[$z]['id_campana_tipo'].'" selected>' . $camp_tipo[$z]['nombre_campana_tipo'] . '</option>';
    }else{
        $sel_camp_tipo .= '<option value="'.$camp_tipo[$z]['id_campana_tipo'].'">' . $camp_tipo[$z]['nombre_campana_tipo'] . '</option>';
    }
}

//Subtipo 
$sel_camp_subtipo = '<option value="0">- Selecciona -</option>';
for($z = 0; $z < sizeof($camp_subtipo); $z++)
{
    if($this->input->post('id_campana_subtipo') == $camp_subtipo[$z]['id_campana_subtipo']){
        $sel_camp_subtipo .= '<option value="'.$camp_subtipo[$z]['id_campana_subtipo'].'" selected>' . $camp_subtipo[$z]['nombre_campana_subtipo'] . '</option>';
    }else{
        $sel_camp_subtipo .= '<option value="'.$camp_subtipo[$z]['id_campana_subtipo'].'">' . $camp_subtipo[$z]['nombre_campana_subtipo'] . '</option>';
    }
}

//Ejercicio
$sel_ejercicios = '<option value="0">- Selecciona -</option>';
for($z = 0; $z < sizeof($ejercicios); $z++)
{
    if($this->input->post('id_ejercicio') == $ejercicios[$z]['id_ejercicio']){
        $sel_ejercicios .= '<option value="'.$ejercicios[$z]['id_ejercicio'].'" selected>' . $ejercicios[$z]['ejercicio'] . '</option>';
    }else{
        $sel_ejercicios .= '<option value="'.$ejercicios[$z]['id_ejercicio'].'">' . $ejercicios[$z]['ejercicio'] . '</option>';
    }
}

//Trimestre
$sel_trimestre = '<option value="0">- Selecciona -</option>';
for($z = 0; $z < sizeof($trimestres); $z++)
{
    if($this->input->post('id_trimestre') == $trimestres[$z]['id_trimestre']){
        $sel_trimestre .= '<option value="'.$trimestres[$z]['id_trimestre'].'" selected>' . $trimestres[$z]['trimestre'] . '</option>';
    }else{
        $sel_trimestre .= '<option value="'.$trimestres[$z]['id_trimestre'].'">' . $trimestres[$z]['trimestre'] . '</option>';
    }
}

//Estatus
$sel_estatus = '';
$lista_estatus = ['-Seleccione-','Activo','Inactivo'];
$lista_estatus_ids = ['0','1','2'];
for($z = 0; $z < sizeof($lista_estatus_ids); $z++)
{
    if($this->input->post('active') == $lista_estatus_ids[$z]){
        $sel_estatus .= '<option value="'.$lista_estatus_ids[$z].'" selected>' . $lista_estatus[$z] . '</option>';
    }else{
        $sel_estatus .= '<option value="'.$lista_estatus_ids[$z].'">' . $lista_estatus[$z] . '</option>';
    }   
}

//Sujeto obligado solicitante
$sel_so_solicitantes = '<option value="0">-Seleccione-</option>';
    for($z = 0; $z < sizeof($so_solicitantes); $z++)
    {
        if($this->input->post('id_so_solicitante') == $so_solicitantes[$z]['id_sujeto_obligado']){
            $sel_so_solicitantes .= '<option value="'.$so_solicitantes[$z]['id_sujeto_obligado'].'" selected>' . $so_solicitantes[$z]['nombre_sujeto_obligado'] . '</option>';
        }else{
            $sel_so_solicitantes .= '<option value="'.$so_solicitantes[$z]['id_sujeto_obligado'].'">' . $so_solicitantes[$z]['nombre_sujeto_obligado'] . '</option>';
        }
    }

//Sujeto obligado contratante
$sel_so_contratantes = '<option value="0">-Seleccione-</option>';
    for($z = 0; $z < sizeof($so_contratantes); $z++)
    {
        if($this->input->post('id_so_contratante') == $so_contratantes[$z]['id_sujeto_obligado']){
            $sel_so_contratantes .= '<option value="'.$so_contratantes[$z]['id_sujeto_obligado'].'" selected>' . $so_contratantes[$z]['nombre_sujeto_obligado'] . '</option>';
        }else{
            $sel_so_contratantes .= '<option value="'.$so_contratantes[$z]['id_sujeto_obligado'].'">' . $so_contratantes[$z]['nombre_sujeto_obligado'] . '</option>';
        }
    }

//Tema
$sel_camp_tema = '<option value="0">-Seleccione-</option>';
for($z = 0; $z < sizeof($temas); $z++)
{
    if($this->input->post('id_campana_tema') == $temas[$z]['id_campana_tema']){
        $sel_camp_tema .= '<option value="'.$temas[$z]['id_campana_tema'].'" selected>' . $temas[$z]['nombre_campana_tema'] . '</option>';
    }else{
        $sel_camp_tema .= '<option value="'.$temas[$z]['id_campana_tema'].'">' . $temas[$z]['nombre_campana_tema'] . '</option>';
    }
}

//Objetivo
$sel_objetivo = '<option value="0">-Seleccione-</option>';
for($z = 0; $z < sizeof($objetivos); $z++)
{
    if($this->input->post('id_campana_objetivo') == $objetivos[$z]['id_campana_objetivo']){
        $sel_objetivo .= '<option value="'.$objetivos[$z]['id_campana_objetivo'].'" selected>' . $objetivos[$z]['campana_objetivo'] . '</option>';
    }else{
        $sel_objetivo .= '<option value="'.$objetivos[$z]['id_campana_objetivo'].'">' . $objetivos[$z]['campana_objetivo'] . '</option>';
    }
}

//Cobertura
$sel_cobertura = '<option value="">-Seleccione-</option>';
for($z = 0; $z < sizeof($coberturas); $z++)
{
    if($this->input->post('id_campana_cobertura') == $coberturas[$z]['id_campana_cobertura']){
        $sel_cobertura .= '<option value="'.$coberturas[$z]['id_campana_cobertura'].'" selected>' . $coberturas[$z]['nombre_campana_cobertura'] . '</option>';
    }else{
        $sel_cobertura .= '<option value="'.$coberturas[$z]['id_campana_cobertura'].'">' . $coberturas[$z]['nombre_campana_cobertura'] . '</option>';
    }
}

//Tipo tiempos oficiales
$sel_tipoTO = '<option value="0">-Seleccione-</option>';
	for($z = 0; $z < sizeof($tiposTO); $z++)
	{
	    if($this->input->post('id_campana_tipoTO') == $tiposTO[$z]['id_campana_tipoTO']){
	        $sel_tipoTO .= '<option value="'.$tiposTO[$z]['id_campana_tipoTO'].'" selected>' . $tiposTO[$z]['nombre_campana_tipoTO'] . '</option>';
	    }else{
	        $sel_tipoTO .= '<option value="'.$tiposTO[$z]['id_campana_tipoTO'].'">' . $tiposTO[$z]['nombre_campana_tipoTO'] . '</option>';
	    }
	}

//Medios de comunicación
$sel_categorias = '<option value="0">-Seleccione-</option>';
    if(isset($categorias)){
        for($z = 0; $z < sizeof($categorias); $z++)
        {
            if($this->input->post('id_servicio_categoria') == $categorias[$z]['id_servicio_categoria']){
                $sel_categorias .= '<option value="'.$categorias[$z]['id_servicio_categoria'].'" selected>' . $categorias[$z]['nombre_servicio_categoria'] . '</option>';
            }else{
                $sel_categorias .= '<option value="'.$categorias[$z]['id_servicio_categoria'].'">' . $categorias[$z]['nombre_servicio_categoria'] . '</option>';
            }
        }
    }
    
//Documentos_PACS
$sel_pacs = '<option value="0">-Seleccione-</option>';
for($z = 0; $z < sizeof($docpacs); $z++)
	{
		if($this->input->post('id_presupuesto') == $docpacs[$z]['id_presupuesto']){
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
            $error_tiempo_oficial = !empty(form_error('id_campana_objetivo', '<div class="text-danger">', '</div>'));
            $error_fecha_pub = !empty(form_error('fecha_dof', '<div class="text-danger">', '</div>'));
            $error_so = !empty(form_error('id_sujeto_obligado', '<div class="text-danger">', '</div>'));
            $error_active = !empty(form_error('active', '<div class="text-danger">', '</div>'));
            $error_fip = !empty(form_error('fecha_inicio_periodo', '<div class="text-danger">', '</div>'));
            $error_ftp = !empty(form_error('fecha_termino_periodo', '<div class="text-danger">', '</div>'));
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
            <ul class="nav nav-tabs">
                <li class="<?php if(!$this->session->flashdata('tab_flag')) echo 'active' ?>">
                    <a href="#tab_1" data-toggle="tab"> Campa&ntilde;as y avisos institucionales</a>
                <li>
                <li class="<?php if($this->session->flashdata('tab_flag')) echo 'active' ?>">
                    <a href="#tab_2" class="disabled_tab2" data-toggle="tab" onclick="verificar();">Grupo de edad </a>
                <li>
                <li class="<?php if($this->session->flashdata('tab_flag')) echo 'active' ?>">
                    <a href="#tab_3" class="disabled_tab2" data-toggle="tab" onclick="lugar();">Lugar</a>
                <li>
                <li class="<?php if($this->session->flashdata('tab_flag')) echo 'active' ?>">
                    <a href="#tab_4" class="disabled_tab2" data-toggle="tab" onclick="nivel();">Nivel Socioeconomico</a>
                <li>
                <li class="<?php if($this->session->flashdata('tab_flag')) echo 'active' ?>">
                    <a href="#tab_5" class="disabled_tab2" data-toggle="tab" onclick="educacion();">Educaci&oacute;n</a>
                <li>
                <li class="<?php if($this->session->flashdata('tab_flag')) echo 'active' ?>">
                    <a href="#tab_6" class="disabled_tab2" data-toggle="tab" onclick="sexo();">Sexo</a>
                <li>
                <li class="<?php if($this->session->flashdata('tab_flag')) echo 'active' ?>">
                    <a href="#tab_7" class="disabled_tab2" data-toggle="tab" onclick="audios();">Audios</a>
                <li>
                <li class="<?php if($this->session->flashdata('tab_flag')) echo 'active' ?>">
                    <a href="#tab_8" class="disabled_tab2" data-toggle="tab">Imagenes</a>
                <li>
                <li class="<?php if($this->session->flashdata('tab_flag')) echo 'active' ?>">
                    <a href="#tab_9" class="disabled_tab2" data-toggle="tab">Videos</a>
                <li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane <?php if(!$this->session->flashdata('tab_flag')) echo 'active' ?>" id="tab_1">
                    <form role="form" method="post" action="<?php echo base_url(); ?>index.php/tpoadminv1/campanas/campanas/validate_alta_campanas_avisos" enctype="multipart/form-data" >
                        <div class="box">
                            <div class="box-header">
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <div class="form-group">
                                    <label>Tipo* 
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['tipo']?>"></i>
                                    </label>
                                    <select name="id_campana_tipo" id="id_campana_tipo" class="form-control <?php if($error_tipo) echo 'has-error' ?>">
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
                                            echo form_input(array('type' => 'text', 'name' => 'nombre_campana_aviso', 'value' => $this->input->post('nombre_campana_aviso'), 'class' => $class)); ?>   
                                </div>
                                <div class="form-group">
                                    <label>Clave de campaña o aviso institucional</label>
                                    <?php $class = "form-control";
                                            echo form_input(array('type' => 'text', 'name' => 'clave_campana', 'value' => $this->input->post('clave_campana'), 'class' => $class)); ?>
                                </div>
                                <div class="form-group">
                                    <label>Autoridad que proporcionó la clave
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['autoridad']?>"></i>
                                    </label>
                                    <?php $class = "form-control";
                                            echo form_input(array('type' => 'text', 'name' => 'autoridad', 'value' => $this->input->post('autoridad'), 'class' => $class)); ?>
                                </div>
                                <div class="form-group">
                                    <label>Ejercicio*
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['ejercicio']?>"></i>
                                    </label>
                                    <select name="id_ejercicio" id="id_ejercicio" class="form-control <?php if($error_ejercicio) echo 'has-error' ?>">
                                        <?php echo $sel_ejercicios; ?>
                                    </select>
                                    <input type="hidden" id="valor_ejercicio" name="valor_ejercicio" value="" />
                                </div>
                                <div class="form-group">
                                    <label>Trimestre*
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['trimestre']?>"></i>
                                    </label>
                                    <select name="id_trimestre" class="form-control <?php if($error_trimestre) echo 'has-error' ?>">
                                        <?php echo $sel_trimestre; ?>
                                    </select>
                                </div>
                                
                                <!--Agregar fechas DGPA -->
			                    <div class="form-group">
			                    	<label>Fecha de inicio del periodo que se informa*
			                        	<i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_inicio_periodo']?>"></i>
			                        </label>
			                        <?php $class = "form-control datepicker"; if($error_fip) $class="form-control has-error";
			            				echo form_input(array('type' => 'text', 'autocomplete' => 'off', 'id' => 'fecha_inicio_periodo', 'name' => 'fecha_inicio_periodo',
			                            'placeholder' => 'Ingrese fecha de inicio del período', 'value' => $this->input->post('fecha_inicio_periodo'), 'class' => $class)); ?>
			                    </div>
			                    <div class="form-group">
			                        <label>Fecha de término del periodo que se informa*
			                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_termino_periodo']?>"></i>
			                        </label>
			                        <?php $class = "form-control datepicker"; if($error_ftp) $class="form-control has-error";
			                             echo form_input(array('type' => 'text', 'autocomplete' => 'off', 'id' => 'fecha_termino_periodo', 'name' => 'fecha_termino_periodo',
			                             'placeholder' => 'Ingrese fecha de término del período', 'value' => $this->input->post('fecha_termino_periodo'), 'class' => $class)); ?>
			                    </div>
			                    <!--Fin de fechas DGPA-->
                                
                                <div class="form-group">
                                    <label>Sujeto obligado contratante*
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['soc']?>"></i>
                                    </label>
                                    <select name="id_so_contratante" class="form-control <?php if($error_soc) echo 'has-error' ?>">
                                        <?php echo $sel_so_contratantes; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Sujeto obligado solicitante*
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['soc']?>"></i>
                                    </label>
                                    <select name="id_so_solicitante" class="form-control <?php if($error_sos) echo 'has-error' ?>">
                                        <?php echo $sel_so_solicitantes; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Tema*
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['tema']?>"></i>
                                    </label>
                                    <select name="id_campana_tema" class="form-control <?php if($error_tema) echo 'has-error' ?>">
                                        <?php echo $sel_camp_tema; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Objetivo Institucional*
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['obj_institucional']?>"></i>
                                    </label>
                                    <select name="id_campana_objetivo" class="form-control <?php if($error_obj_inst) echo 'has-error' ?>">
                                        <?php echo $sel_objetivo; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Objetivo de comunicaci&oacute;n
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['obj_comunicacion']?>"></i>
                                    </label>
                                    <textarea class="form-control" name="objetivo_comunicacion" id="objetivo_comunicacion">
                                        <?php echo set_value('objetivo_comunicacion'); ?> 
                                    </textarea>
                                </div>
                                <div class="form-group">
                                    <label>Cobertura*
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['cobertura']?>"></i>
                                    </label>
                                    <select name="id_campana_cobertura" class="form-control <?php if($error_cobertura) echo 'has-error' ?>">
                                        <?php echo $sel_cobertura; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>&Aacute;mbito geogr&aacute;fico
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['amb_geografico']?>"></i>
                                    </label>
                                    <?php $class = "form-control";
                                            echo form_input(array('type' => 'text', 'name' => 'campana_ambito_geo', 'value' => $this->input->post('campana_ambito_geo'), 'class' => $class)); ?>
                                </div>
                                <div class="form-group">
                                    <label>Fecha de inicio
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_inicio']?>"></i>
                                    </label>
                                    <?php $class = "form-control datepicker";
                                        echo form_input(array('type' => 'text', 'autocomplete' => 'off', 'id' => 'fecha_inicio', 'name' => 'fecha_inicio',
                                        'placeholder' => 'Ingresa fecha inicio', 'value' => $this->input->post('fecha_inicio'), 'class' => $class)); ?>
                                </div>
                                <div class="form-group">
                                    <label>Fecha de t&eacute;rmino
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_termino']?>"></i>
                                    </label>
                                    <?php $class = "form-control datepicker";
                                        echo form_input(array('type' => 'text', 'autocomplete' => 'off', 'id' => 'fecha_termino', 'name' => 'fecha_termino',
                                        'placeholder' => 'Ingrese fecha fin', 'value' => $this->input->post('fecha_termino'), 'class' => $class)); ?>
                                </div>
                                
         <!-- I N I C I O      T I E M P O       O F I C I A L -->
         
                                <div class="form-group">
                                    <label>Tiempo oficial*
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['tiempo_oficial']?>"></i>
                                    </label>
                                    <select name="id_tiempo_oficial" onChange="toOnChange(this)" class="form-control <?php if($error_tiempo_oficial) echo 'has-error' ?>">
                                        <option value="">-Seleccione-</option> 
                                        <option value="1" <?php if($this->input->post('id_tiempo_oficial') == '1') { ?>  selected="selected"; <?php } ?> >No</option>
                                        <option value="2" <?php if($this->input->post('id_tiempo_oficial') == '2') { ?>  selected="selected"; <?php } ?>>Sí</option>
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
													<td><input class="form-control" value="00" name="hora_to" id="hora_to" onchange="javascript:monto_TO();"><?php echo set_value('hora_to'); ?></input></td>
													<td><input class="form-control" value="00" name="minutos_to" id="minutos_to"  onchange="javascript:monto_TO();"><?php echo set_value('minutos_to'); ?></input></td>
													<td><input class="form-control" value="00" name="segundos_to" id="segundos_to" onchange="javascript:monto_TO();"><?php echo set_value('segundos_to'); ?></input></td>
													<td><input class="form-control" readonly="readonly" name="monto_tiempo" id="monto_tiempo"><?php echo set_value('monto_tiempo'); ?></input></td>
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
		                                        <?php echo set_value('mensajeTO'); ?> 
		                                    </textarea>
		                                </div>
		                                
		                                <div class="form-group">
		                                    <label>Fecha inicio tiempo oficial
		                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_inicio_to']?>"></i>
		                                    </label>
		                                    <?php $class = "form-control datepicker";
		                                        echo form_input(array('type' => 'text', 'autocomplete' => 'off', 'id' => 'fecha_inicio_to', 'name' => 'fecha_inicio_to',
		                                        'value' => $this->input->post('fecha_inicio_to'), 'class' => $class)); ?>
		                                </div>
		                                <div class="form-group">
		                                    <label>Fecha t&eacute;rmino tiempo oficial
		                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_termino_to']?>"></i>
		                                    </label>
		                                    <?php $class = "form-control datepicker";
		                                        echo form_input(array('type' => 'text', 'autocomplete' => 'off', 'id' => 'fecha_termino_to', 'name' => 'fecha_termino_to',
		                                        'value' => $this->input->post('fecha_termino_to'), 'class' => $class)); ?>
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
		                                            echo form_input(array('type' => 'text', 'name' => 'descripcion_unidad', 'value' => $this->input->post('descripcion_unidad'), 'class' => $class)); ?>
		                                </div>
		                                <div class="form-group">
		                                    <label>Concesionario responsable de publicar la campaña o la comunicación correspondiente (razón social)
		                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['responsable_publisher']?>"></i>
		                                    </label>
		                                    <?php $class = "form-control";
		                                            echo form_input(array('type' => 'text', 'name' => 'responsable_publisher', 'value' => $this->input->post('responsable_publisher'), 'class' => $class)); ?>
		                                </div>
		                                <div class="form-group">
		                                    <label>Distintivo y/o nombre comercial del concesionario responsable de publicar la campaña o comunicación
		                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['name_comercial']?>"></i>
		                                    </label>
		                                    <?php $class = "form-control";
		                                            echo form_input(array('type' => 'text', 'name' => 'name_comercial', 'value' => $this->input->post('name_comercial'), 'class' => $class)); ?>
		                                </div>
		                                <div class="form-group">
		                                    <label>Descripción breve de las razones que justifican la elección del proveedor
		                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['razones_supplier']?>"></i>
		                                    </label>
		                                    <?php $class = "form-control";
		                                            echo form_input(array('type' => 'text', 'name' => 'razones_supplier', 'value' => $this->input->post('razones_supplier'), 'class' => $class)); ?>
		                                </div>
		                                <div class="form-group">
		                                    <label>Área administrativa encargada de solicitar la difusión del mensaje o producto, en su caso
		                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['difusion_mensaje']?>"></i>
		                                    </label>
		                                    <?php $class = "form-control";
		                                            echo form_input(array('type' => 'text', 'name' => 'difusion_mensaje', 'value' => $this->input->post('difusion_mensaje'), 'class' => $class)); ?>
		                                </div>
		                                <div class="form-group">
		                                    <label>Número de factura, en su caso
		                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['num_factura']?>"></i>
		                                    </label>
		                                    <?php $class = "form-control";
		                                            echo form_input(array('type' => 'text', 'name' => 'num_factura', 'value' => $this->input->post('num_factura'), 'class' => $class)); ?>
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
		</script>						
									                               
         <!--   F I N      T I E M P O        O F I C I A L   -->                            
                                                            
                                <div class="form-group">
                                    <label>Publicaci&oacute;n SEGOB.
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['segob']?>"></i>
                                    </label>
                                    <?php $class = "form-control";
                                            echo form_input(array('type' => 'text', 'name' => 'publicacion_segob', 'value' => $this->input->post('publicacion_segob'), 'class' => $class)); ?>
                                </div>
                                <div class="form-group">
                                    <label>Documento del PACS
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['pacs']?>"></i>
                                    </label>
									<select name="id_presupuesto" id="id_presupuesto" class="form-control">
                                        <?php echo $sel_pacs; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Fecha publicaci&oacute;n*
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_publicacion']?>"></i>
                                    </label>
                                    <?php $class = "form-control datepicker"; if($error_fecha_pub) $class = "form-control datepicker has-error";
                                        echo form_input(array('type' => 'text', 'autocomplete' => 'off', 'id' => 'fecha_dof', 'name' => 'fecha_dof',
                                        'placeholder' => 'Ingresa fecha de publicación', 'value' => $this->input->post('fecha_dof'), 'class' => $class)); ?>
                                </div>
                                <div class="form-group">
                                    <label>Evaluaci&oacute;n*
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['evaluacion']?>"></i>
                                    </label>
                                    <textarea class="form-control" name="evaluacion" id="evaluacion"> 
                                        <?php echo set_value('evaluacion'); ?> 
                                    </textarea>
                                </div>

                                <!-- CODIGO PARA CARGAR ARCHIVOS -->
                                <div class="form-group">
                                    <label class="custom-file-label"> Documento de evaluaci&oacute;n
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip"></i>
                                    </label>
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
                                    <input type="file" name="file_programa_imagen" id="file_programa_imagen" class="hide" accept=".xlsx,.xls,.pdf,.doc,.docx"/>
                                    <div id="file_saved" class="input-group-btn" style="<?php if($control_update['file_saved']) echo 'display:none;' ?>">
                                        <button class="btn btn-danger" type="button" onclick="triggerClickDocumento('eliminar')" >Eliminar archivo</button>
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
                                        echo form_input(array('type' => 'text', 'autocomplete' => 'off', 'id' => 'fecha_validacion', 'name' => 'fecha_validacion', 'value' => $this->input->post('fecha_validacion'), 'class' => $class)); ?>
                                </div>
                                <div class="form-group">
                                    <label>&Aacute;rea responsable de la informaci&oacute;n
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['area_responsable']?>"></i>
                                    </label>
                                    <?php $class = "form-control";
                                            echo form_input(array('type' => 'text', 'name' => 'area_responsable', 'value' => $this->input->post('area_responsable'), 'class' => $class)); ?>
                                </div>
                                <div class="form-group">
                                    <label>A&ntilde;o
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['anio']?>"></i>
                                    </label>
                                    <?php $class = "form-control";
                                            echo form_input(array('type' => 'text', 'name' => 'periodo', 'value' => $this->input->post('periodo'), 'class' => $class)); ?>
                                </div>

                                <div class="form-group">
                                    <label>Fecha de actualizaci&oacute;n
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_actualizacion']?>"></i>
                                    </label>
                                    <?php $class = "form-control datepicker";
                                        echo form_input(array('type' => 'text', 'autocomplete' => 'off', 'id' => 'fecha_actualizacion', 'name' => 'fecha_actualizacion', 'value' => $this->input->post('fecha_actualizacion'), 'class' => $class)); ?>
                                </div>
                                
                                <div class="form-group">
                                    <label>Nota
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['nota']?>"></i>
                                    </label>
                                    <textarea class="form-control" name="nota" id="nota"> 
                                        <?php echo set_value('nota'); ?> 
                                    </textarea>
                                </div>
                                <div class="form-group">
                                    <label>Estatus*
                                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['estatus']?>"></i>
                                    </label>
                                    <select name="active" class="form-control <?php if($error_active) echo 'has-error' ?>">
                                        <?php echo $sel_estatus; ?>
                                    </select>
                                </div> 
                                <br />
                                </div>
                            </div><!-- /.box-body -->
                            <div class="box-footer">
                                <button class="btn btn-primary" type="submit">Guardar</button>
                                <?php echo anchor("tpoadminv1/campanas/campanas/busqueda_campanas_avisos", "<button class='btn btn-default' type='button'>Regresar</button></td>"); ?>
                            </div>     
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
                            <div class="box"></div>
                        </div>

                        <div class="tab-pane <?php if($this->session->flashdata('tab_flag')) echo 'active' ?>" id="tab_9"> 
                            <div class="box"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
                            $('#file_see').hide();
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
                    $('#file_by_save').show();
                    $('#file_saved').hide();
                    $('#file_load').hide();
                    $('#file_see').hide();
                    $('#result_upload').html('Formatos permitidos PDF, WORD Y EXCEL.');
                    $('#name_file_input').val('');
                    $("input[name='file_programa_anual']").val(null);
                    $('#name_file_programa_anual').val('');
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

    var abrirModal = function(){
        //$('#myModal').find('#item_1').html(name);
        $('#myModal').modal('show');
    }
 
    function verificar()
    {
        $('#tabla_edades').load('busqueda_camp_edades', function(output) {
            //alert(output);
        });
    }

    function lugar()
    {
        $('#tabla_lugar').load('alta_camp_lugar', function(output) {
            //alert(output);
        });
    }

    function nivel()
    {
        $('#tabla_nivel').load('alta_camp_nivel', function(output) {
            //alert(output);
        });
    }

    function educacion()
    {
        $('#tabla_educacion').load('alta_camp_educacion', function(output) {
            //alert(output);
        });
    }

    function sexo()
    {
        $('#tabla_sexo').load('alta_camp_sexo', function(output) {
            //alert(output);
        });
    }

    function audios()
    {
        $('#tabla_audios').load('alta_camp_audios', function(output) {
            //alert(output);
        });
    }
    
    // Limitar fechas

    var limitar_fecha = function(container){
        
        var ejercicio = $('select[name="id_ejercicio"] option:selected').text();
        var anio = anio_fecha(container);
        
        var inicio = $('select[name="id_ejercicio"] option:selected').text() +'/01/01';
        var fin = $('select[name="id_ejercicio"] option:selected').text() +'/12/31';
        var defaultDate = '01.01.' + $('select[name="id_ejercicio"] option:selected').text();
        //var defaultDate =  $('select[name="id_ejercicio"] option:selected').text() + '/01/01.';

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
                //format:'Y-m-d',
                format:'d.m.Y',
                scrollInput: false
            });
        }else{
            jQuery(container).datetimepicker({
                timepicker:false,
                //format:'Y-m-d',
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

    var dame_subtipos = function(container){
        var id_campana_tipo =  $(container).val();
        var subtipo = '<?php echo $this->input->post('id_campana_subtipo') ?>';
        
        $.ajax({
            type:'POST',
            url:'busqueda_subtipo_post',
            data: { 'id_campana_tipo':id_campana_tipo,'id_campana_subtipo':subtipo  },
            success:function(html){
                $('#id_campana_subtipo').html(html);
            }
        }); 
    }

    var dame_subtipos2 = function(container){
        var campana_tipo =  $(container).val();
        //alert(campana_tipo);
        
        var tipo = 'id_campana_tipo=' + campana_tipo;
        $.ajax({
            type:'POST',
            url:'busqueda_subtipo',
            data: tipo,
            success:function(html){
                $('#id_campana_subtipo').html(html);
            }
        }); 
    }


    $('input:file').change(function (){
        upload_file_documento();
        //upload_file_video('imagen');
    }); 

    var triggerClickDocumento = function(action){
        if( action == 'lanzar'){
            $("input[name='file_programa_imagen']").trigger("click");
        }else if(action == 'eliminar') {
            eliminar_archivo_documento();
        }
    }
    
    var upload_file_documento = function (){
        if($("input[name='file_programa_imagen']")[0].files.length > 0){
            $('#name_file_input').val($("input[name='file_programa_imagen']")[0].files[0].name );
            $('#file_load').show();
            $('#file_by_save').hide();
            var file_data = $('#file_programa_imagen').prop('files')[0];   
            var form_data = new FormData();                  
            form_data.append('file_programa_imagen', file_data);                           
            $.ajax({
                url: '<?php echo base_url() . 'index.php/tpoadminv1/campanas/campanas/upload_file_documento' ?>', // point to server-side PHP script 
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
                        $('#file_by_save').show();
                        $('#file_saved').hide();
                        $('#file_load').hide();
                        $('#file_see').hide();
                        $('#result_upload').html('<span class="text-warning">El tamaño máximo para la carga de archivos es de 20MB.</span>');
                        $('#name_file_input').val('');
                        $('#file_archivo_nombre').val('');
                    }



                    if(response != ''){
                        var data = $.parseJSON(response);
                        if(data[0] == 'exito'){
                            $('#file_by_save').hide();
                            $('#file_saved').show();
                            $('#file_load').hide();
                            $('#file_see').hide();
                            $('#result_upload').html('<span class="text-success">Archivo cargado correctamente</span>');
                            $('#name_file_imagen').val(data[1]);
                            $('#file_archivo_nombre').val(data[1]);
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

    var eliminar_archivo_documento = function()
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
                    $('#file_by_save').show();
                    $('#file_saved').hide();
                    $('#file_load').hide();
                    $('#file_see').hide();
                    $('#result_upload').html('Formatos permitidos DOC, DOCX.');
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
</script>