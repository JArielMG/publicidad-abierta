<?php

/* 
 INAI / EDITA SUJETO
 */

?>

<?php
//$sujeto_permisos = explode('|', $sujeto['usuario_permisos']);

$sel_funcion = '';
for($z = 0; $z < sizeof($atribuciones); $z++)
{
    $selected = '';
    if($atribuciones[$z]['id_so_atribucion'] == $sujeto['id_so_atribucion'])
    {
        $selected = ' selected="selected"';
    }
    $sel_funcion .= '<option value ="'.$atribuciones[$z]['id_so_atribucion'].'" '.$selected.'>' . $atribuciones[$z]['nombre_so_atribucion'] . '</option>';
}

$sel_orden = '';
for($z = 0; $z < sizeof($ordenes); $z++)
{
    $selected = '';
    if($ordenes[$z]['id_so_orden_gobierno'] == $sujeto['id_so_orden_gobierno'])
    {
        $selected = ' selected="selected"';
    }
    $sel_orden .= '<option value ="'.$ordenes[$z]['id_so_orden_gobierno'].'" ' . $selected . '>' . $ordenes[$z]['nombre_so_orden_gobierno'] . '</option>';
}


$sel_estado = '';
for($z = 0; $z < sizeof($estados); $z++)
{
    $selected = '';
    if($estados[$z]['id_so_estado'] == $sujeto['id_so_estado'])
    {
        $selected = ' selected="selected"';
    }
    $sel_estado .= '<option value ="'.$estados[$z]['id_so_estado'].'" ' . $selected . '>' . $estados[$z]['nombre_so_estado'] . '</option>';
}

?>

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
            <h4><i class="icon fa fa-check"></i> Exito!</h4>
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
            <h4><i class="icon fa fa-check"></i> Cuidado!</h4>
            <?php echo $this->session->flashdata('alerta'); ?>
        </div>
    <?php
    }
    ?>
    
    <div class="row">
        <!-- form start -->
        <form role="form" method="post" action="<?php echo base_url(); ?>index.php/tpoadminv1/sujetos/sujetos/validate_edita_sujeto">
            <input type="hidden" name="id_sujeto_obligado" value="<?php echo $sujeto['id_sujeto_obligado']; ?>">
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
                    <div class="box-header">
                        <h3 class="box-title">Datos</h3>
                    </div><!-- /.box-header -->

                    <div class="box-body">

                        <div class="form-group">
                            <label for="usuario_nombre">Funcion</label>
                            <select class="form-control" name="id_so_atribucion">
                                <option value="0">- Selecciona -</option>
                                <?php echo $sel_funcion; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="id_so_estado">Orden</label>
                            <select class="form-control" name="id_so_orden_gobierno">
                            <option value="0">- Selecciona -</option>
                                <?php echo $sel_orden; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Estado</label>
                            <select class="form-control" name="id_so_estado">
                            <option value="0">- Selecciona -</option>
                                <?php echo $sel_estado; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nombre_sujeto_obligado">Nombre</label>
                            <input type="text" placeholder="Ingrese Nombre" name="nombre_sujeto_obligado" class="form-control" value="<?php echo $sujeto['nombre_sujeto_obligado']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="siglas_sujeto_obligado">Siglas</label>
                            <input type="text" placeholder="Ingrese Siglas" name="siglas_sujeto_obligado" class="form-control" value="<?php echo $sujeto['siglas_sujeto_obligado']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="url_sujeto_obligado">URL Pagina</label>
                            <input type="text" placeholder="Ingrese URL" name="url_sujeto_obligado" class="form-control" value="<?php echo $sujeto['url_sujeto_obligado']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="active">Estatus</label>
                            <select class="form-control" name="active" id="active">
                                <option value="0">- Selecciona -</option>
                                <option value="1" <?php if($sujeto['active'] == '1') { ?>  selected="selected"; <?php } ?> >Activo</option>
                                <option value="2" <?php if($sujeto['active'] == '2') { ?>  selected="selected"; <?php } ?> >Inactivo</option>
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