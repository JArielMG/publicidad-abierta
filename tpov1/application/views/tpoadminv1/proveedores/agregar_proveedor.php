
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
        
        if($lista_estatus_ids[$z] == '1' ){
            $sel_estatus .= '<option value="'.$lista_estatus_ids[$z].'" selected>' . $lista_estatus[$z] . '</option>';
        }else{
            $sel_estatus .= '<option value="'.$lista_estatus_ids[$z].'">' . $lista_estatus[$z] . '</option>';
        }
        
    }

    $sel_personalidad = '<option value="">-Seleccione-</option>';
    for($z = 0; $z < sizeof($personalidades); $z++)
    {
        if($registro['id_personalidad_juridica'] == $personalidades[$z]['id_personalidad_juridica']){
            $sel_personalidad .= '<option value="'.$personalidades[$z]['id_personalidad_juridica'].'" selected>' . $personalidades[$z]['nombre_personalidad_juridica'] . '</option>';
        }else{
            $sel_personalidad .= '<option value="'.$personalidades[$z]['id_personalidad_juridica'].'">' . $personalidades[$z]['nombre_personalidad_juridica'] . '</option>';
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
    .validation-error {
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
            <?php echo $this->session->flashdata('alert'); $this->session->set_flashdata('alert', '');  ?>
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
            $error_ipj = !empty(form_error('id_personalidad_juridica', '<div class="text-danger">', '</div>'));
            $error_nrs = !empty(form_error('nombre_razon_social', '<div class="text-danger">', '</div>'));
            $error_nc = !empty(form_error('nombre_comercial', '<div class="text-danger">', '</div>'));
            $error_rfc = !empty(form_error('rfc', '<div class="text-danger">', '</div>'));
            $error_active = !empty(form_error('active', '<div class="text-danger">', '</div>'));
            if(validation_errors() == TRUE)
            {
                echo '<div class="alert alert-danger"><button class="close"  data-dismiss="alert">x</button>
                <h4><i class="icon fa fa-ban"></i>¡Alerta!</h4>' . validation_errors() . $mensaje . '</div>';  
            }
        ?>
        <form role="form" method="post" autocomplete="off" action="<?php echo base_url(); ?>index.php/tpoadminv1/capturista/proveedores/validate_agregar_proveedor" enctype="multipart/form-data" >
            <div class="box box-primary">
                <div class="box-header">
                </div><!-- /.box-header -->
                <div class="box-body">
                    <input type="hidden" value="" class="form-control" name="id_proveedor"/>
					
					<div class="form-group">
                        <label>Personalidad jur&iacute;dica* 
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_personalidad_juridica']?>"></i>
                        </label>
                        <select name="id_personalidad_juridica" id="id_personalidad_juridica" class="form-control <?php if($error_ipj) echo 'validation-error' ?>" onchange="javascript:moral_fisica();">
                            <option value="0">- Selecciona -</option>
                            <option value="1" <?php if($this->input->post('id_personalidad_juridica') == '1') { ?>  selected="selected"; <?php } ?>>Persona física</option>
                            <option value="2" <?php if($this->input->post('id_personalidad_juridica') == '2') { ?>  selected="selected"; <?php } ?>>Persona moral</option>
                        </select>
                    </div>
					
						<script type="text/javascript">
							function moral_fisica() {
								id_personalidad_juridica=document.getElementById('id_personalidad_juridica').value;						
								document.getElementById("id_personalidad_juridica").value=id_personalidad_juridica;		
															
								if (id_personalidad_juridica == 1) 
								{									
									document.getElementById("nombre_comercial").value = '';
									document.getElementById("nombre_comercial").disabled = true;
									document.getElementById("primer_apellido").disabled = false;
									document.getElementById("segundo_apellido").disabled = false;
									document.getElementById("nombres").disabled = false;
								}
								else if (id_personalidad_juridica == 2)
								{
									document.getElementById("nombre_comercial").disabled = false;
									document.getElementById("primer_apellido").value = '';
									document.getElementById("primer_apellido").disabled = true;
									document.getElementById("segundo_apellido").value = '';
									document.getElementById("segundo_apellido").disabled = true;
									document.getElementById("nombres").value = '';
									document.getElementById("nombres").disabled = true;
								}
							}
							window.onload = moral_fisica;
						</script>
										 
                    <div class="form-group">
                        <label>Nombre o raz&oacute;n social*
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['nombre_razon_social']?>"></i>
                        </label>
                        <?php $class = "form-control";  if($error_nrs)  $class = "form-control validation-error";  
                            echo form_input(array('type' => 'text', 'name' => 'nombre_razon_social', 'value' => $registro['nombre_razon_social'], 'class' => $class)); ?>
                    </div>
                    <div class="form-group">
                        <label>Nombre comercial* 
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['nombre_comercial']?>"></i>
                        </label>
                        <?php $class = "form-control";  if($error_nc)  $class = "form-control validation-error";  
                            echo form_input(array('type' => 'text', 'name' => 'nombre_comercial', 'id' => 'nombre_comercial', 'value' => $registro['nombre_comercial'], 'class' => $class)); ?>
                    </div>
                    <div class="form-group">
                        <label>R.F.C.*
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['rfc']?>"></i>
                        </label>
                        <?php $class = "form-control";  if($error_rfc)  $class = "form-control validation-error";  
                            echo form_input(array('type' => 'text', 'name' => 'rfc', 'value' => $registro['rfc'], 'class' => $class)); ?>
                    </div>
                    <div class="form-group">
                        <label>Primer apellido*
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['primer_apellido']?>"></i>
                        </label>
                        <?php echo form_input(array('type' => 'text', 'name' => 'primer_apellido', 'id' => 'primer_apellido', 'value' => $registro['primer_apellido'], 'class' => 'form-control')); ?>
                    </div>
                    <div class="form-group">
                        <label>Segundo apellido*
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['segundo_apellido']?>"></i>
                        </label>
                        <?php echo form_input(array('type' => 'text', 'name' => 'segundo_apellido', 'id' => 'segundo_apellido', 'value' => $registro['segundo_apellido'], 'class' => 'form-control')); ?>
                    </div>
                    <div class="form-group">
                        <label>Nombre(s)*
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['nombres']?>"></i>
                        </label>
                        <?php echo form_input(array('type' => 'text', 'name' => 'nombres', 'id' => 'nombres', 'value' => $registro['nombres'], 'class' => 'form-control')); ?>
                    </div>
                    <div class="form-group">
                        <label>Descripci&oacute;n de sus servicios
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['descripcion_servicios']?>"></i>
                        </label>
                        <textarea class="form-control" name="descripcion_servicios" id="descripcion_servicios"><?php echo $registro['descripcion_servicios']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Fecha de validaci&oacute;n
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_validacion']?>"></i>
                        </label>
                        <?php echo form_input(array('type' => 'text', 'name' => 'fecha_validacion', 'value' => $registro['fecha_validacion'], 'class' => 'form-control')); ?>
                    </div>
                    <div class="form-group">
                        <label>&Aacute;rea responsable de la informaci&oacute;n
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['area_responsable']?>"></i>
                        </label>
                        <?php echo form_input(array('type' => 'text', 'name' => 'area_responsable', 'value' => $registro['area_responsable'], 'class' => 'form-control')); ?>
                    </div>
                    <div class="form-group">
                        <label>A&ntilde;o
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['periodo']?>"></i>
                        </label>
                        <?php echo form_input(array('type' => 'text', 'name' => 'periodo', 'value' => $registro['periodo'], 'class' => 'form-control')); ?>
                    </div>
                    <div class="form-group">
                        <label>Fecha de actualizaci&oacute;n
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_actualizacion']?>"></i>
                        </label>
                        <?php echo form_input(array('type' => 'text', 'name' => 'fecha_actualizacion', 'value' => $registro['fecha_actualizacion'], 'class' => 'form-control')); ?>
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
                        <select class="form-control" name="active" class="form-control <?php if($error_active) echo 'validation-error' ?>">
                            <?php echo $sel_estatus; ?>
                        </select>
                    </div> 
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <button class="btn btn-primary" type="submit">Guardar</button>
                    <?php echo anchor("tpoadminv1/capturista/proveedores/busqueda_proveedores", "<button class='btn btn-default' type='button'>Regresar</button></td>"); ?>
                </div>     
            </div><!-- /.box -->    
        </form>
    </div>
</section>