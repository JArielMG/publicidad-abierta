<?php

/* 
INAI / ALT SUJETO
 */

?>

<?php

$sel_funcion = '';

for($z = 0; $z < sizeof($funciones); $z++)
{
    $selected = '';
    if($funciones[$z]['id_so_atribucion'] == $this->input->post('id_so_atribucion'))
    {
        $selected = ' selected="selected"';
    }
    $sel_funcion .= '<option value="'.$funciones[$z]['id_so_atribucion'].'" '.$selected.'>' . $funciones[$z]['nombre_so_atribucion'] . '</option>';
}


$sel_estado = '';

for($z = 0; $z < sizeof($estados); $z++)
{
    $selected = '';
    if($estados[$z]['id_so_estado'] == $this->input->post('id_so_estado'))
    {
        $selected = ' selected="selected"';
    }
    $sel_estado .= '<option value="'.$estados[$z]['id_so_estado'].'" '.$selected.'>' . $estados[$z]['nombre_so_estado'] . '</option>';
}


$sel_orden = '';
for($z = 0; $z < sizeof($ordenes); $z++)
{
    $selected = '';
    if($ordenes[$z]['id_so_orden_gobierno'] == $this->input->post('id_so_orden_gobierno'))
    {
        $selected = ' selected="selected"';
    }
    $sel_orden .= '<option value="'.$ordenes[$z]['id_so_orden_gobierno'].'" '.$selected.'>' . $ordenes[$z]['nombre_so_orden_gobierno'] . '</option>';
}

?>

<style>
/* Invisible texto */
figcaption {
    display:none; 
    transition: all .5s;
}
/* Visible texto */
figure:hover > figcaption {
    display:block;
    transition: all .5s;
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
        <h4><i class="icon fa fa-ban"></i> Error!</h4>
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
        <h4>	<i class="icon fa fa-check"></i> Exito!</h4>
        <?php echo $this->session->flashdata('exito'); ?>
    </div>
    <?php
    }
    ?>

    <?php
    if ($this->session->flashdata('alerta'))
    {
    ?>
    <div class="alert alert-warning alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <h4>	<i class="icon fa fa-check"></i> Exito!</h4>
        <?php echo $this->session->flashdata('alerta'); ?>
    </div>
    <?php
    }
    ?>
        
    
    <div class="row">
        <!-- form start -->
        <form role="form" method="post" action="<?php echo base_url(); ?>index.php/tpoadminv1/sujetos/sujetos/validate_alta_sujeto" enctype="multipart/form-data">
            <div class="col-md-12">
            <?php 
                if(validation_errors() == TRUE)
                {
                    echo '<div class="alert alert-danger"><button class="close"  data-dismiss="alert">x</button>
                    <h4><i class="icon fa fa-ban"></i>Alerta!</h4>' . validation_errors() . '</div>';  
                }
                ?>
                <!-- general form elements -->
                <div class="box box-primary">
                    
                    <div class="box-body">
                        <div class="form-group">
                            <label>Funci&oacute;n *</label>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['funcion']?>"></i>
                            
                            <select class="form-control" name="id_so_atribucion" id="id_so_atribucion">
                                <option value="0">- Selecciona -</option>
                                <?php echo $sel_funcion; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Orden *</label>
                            <select class="form-control" name="id_so_orden_gobierno" id="id_so_orden_gobierno">
                            <option value="0">- Selecciona -</option>
                                <?php echo $sel_orden; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Estado *</label>
                            <select class="form-control" name="id_so_estado" id="id_so_estado">
                            <option value="0" selected="selected">- Selecciona -</option>
                                <?php echo $sel_estado; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nombre *</label>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['nombre']?>"></i>
                            <input type="text" placeholder="Ingrese Nombre" name="nombre_sujeto_obligado" value="<?php echo set_value('nombre_sujeto_obligado'); ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Siglas</label>
                            <input type="text" placeholder="Ingrese siglas" name="siglas_sujeto_obligado" value="<?php echo set_value('siglas_sujeto_obligado'); ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>URL Pagina</label>
                            <input type="text" placeholder="Ingrese URL" name="url_sujeto_obligado" value="<?php echo set_value('url_sujeto_obligado'); ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Activo *</label>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['activo']?>"></i>
                            <select class="form-control" name="active" id="active">
                                <option value="0">- Selecciona -</option>
                                <option value="1" <?php if($this->input->post('active') == '1') { ?>  selected="selected"; <?php } ?>>Activo</option>
                                <option value="2" <?php if($this->input->post('active') == '2') { ?>  selected="selected"; <?php } ?>>Inactivo</option>
                            </select>
                        </div>
                    </div><!-- /.box-body -->

                    <div class="box-footer">
                        <button class="btn btn-primary" type="submit">Guardar</button>
                        <?php echo anchor("tpoadminv1/sujetos/sujetos/busqueda_sujeto", "<button class='btn btn-default' type='button'>Regresar</button></td>"); ?>
                    </div>
                </div><!-- /.box -->
            </div>
        </form>
    </div>
</section>