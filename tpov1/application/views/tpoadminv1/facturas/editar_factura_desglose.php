
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
        if( $lista_estatus_ids[$z] == $registro['active'] ){
            $sel_estatus .= '<option value="'.$lista_estatus_ids[$z].'" selected>' . $lista_estatus[$z] . '</option>';
        }else{
            $sel_estatus .= '<option value="'.$lista_estatus_ids[$z].'">' . $lista_estatus[$z] . '</option>';
        }
        
    }

    $sel_campanas = '<option value="">-Seleccione-</option>';
    if(isset($campanas_avisos))
    {
        for($z = 0; $z < sizeof($campanas_avisos); $z++)
        {
            if($registro['id_campana_aviso'] == $campanas_avisos[$z]['id_campana_aviso']){
                $sel_campanas .= '<option value="'.$campanas_avisos[$z]['id_campana_aviso'].'" selected>' . $campanas_avisos[$z]['nombre_campana_aviso'] . '</option>';
            }else{
                $sel_campanas .= '<option value="'.$campanas_avisos[$z]['id_campana_aviso'].'">' . $campanas_avisos[$z]['nombre_campana_aviso'] . '</option>';
            }
        }
    }

    $sel_so_contratantes = '<option value="">-Seleccione-</option>';
    if(isset($so_contratantes))
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

    $sel_presupuestos = '<option value="0">-Seleccione-</option>';
    if(isset($presupuestos))
    {
        for($z = 0; $z < sizeof($presupuestos); $z++)
        {
            if($registro['id_presupuesto_concepto'] == $presupuestos[$z]['id_presupuesto_concepto']){
                $sel_presupuestos .= '<option value="'.$presupuestos[$z]['id_presupuesto_concepto'].'" selected>' . $presupuestos[$z]['nombre_presupuesto_concepto'] . '</option>';
            }else{
                $sel_presupuestos .= '<option value="'.$presupuestos[$z]['id_presupuesto_concepto'].'">' . $presupuestos[$z]['nombre_presupuesto_concepto'] . '</option>';
            }
        }
    }

    $sel_so_solicitantes = '<option value="">-Seleccione-</option>';
    if(isset($so_solicitantes))
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

    $sel_presupuestos_solicitantes = '<option value="0">-Seleccione-</option>';
    if(isset($presupuestos_solicitantes))
    {
        for($z = 0; $z < sizeof($presupuestos_solicitantes); $z++)
        {
            if($registro['id_presupuesto_concepto_solicitante'] == $presupuestos_solicitantes[$z]['id_presupuesto_concepto']){
                $sel_presupuestos_solicitantes .= '<option value="'.$presupuestos_solicitantes[$z]['id_presupuesto_concepto'].'" selected>' . $presupuestos_solicitantes[$z]['nombre_presupuesto_concepto'] . '</option>';
            }else{
                $sel_presupuestos_solicitantes .= '<option value="'.$presupuestos_solicitantes[$z]['id_presupuesto_concepto'].'">' . $presupuestos_solicitantes[$z]['nombre_presupuesto_concepto'] . '</option>';
            }
        }
    }

    $sel_clasificacion = '<option value="">-Seleccione-</option>';
    for($z = 0; $z < sizeof($clasificaciones); $z++)
    {
        if($registro['id_servicio_clasificacion'] == $clasificaciones[$z]['id_servicio_clasificacion']){
            $sel_clasificacion .= '<option value="'.$clasificaciones[$z]['id_servicio_clasificacion'].'" selected>' . $clasificaciones[$z]['nombre_servicio_clasificacion'] . '</option>';
        }else{
            $sel_clasificacion .= '<option value="'.$clasificaciones[$z]['id_servicio_clasificacion'].'">' . $clasificaciones[$z]['nombre_servicio_clasificacion'] . '</option>';
        }
    }

    $sel_categorias = '<option value="0">-Seleccione-</option>';
    if(isset($categorias)){
        for($z = 0; $z < sizeof($categorias); $z++)
        {
            if($registro['id_servicio_categoria'] == $categorias[$z]['id_servicio_categoria']){
                $sel_categorias .= '<option value="'.$categorias[$z]['id_servicio_categoria'].'" selected>' . $categorias[$z]['nombre_servicio_categoria'] . '</option>';
            }else{
                $sel_categorias .= '<option value="'.$categorias[$z]['id_servicio_categoria'].'">' . $categorias[$z]['nombre_servicio_categoria'] . '</option>';
            }
        }
    }
    
    $sel_subcategorias = '<option value="0">-Seleccione-</option>';
    if(isset($subcategorias))
    {
        for($z = 0; $z < sizeof($subcategorias); $z++)
        {
            if($registro['id_servicio_subcategoria'] == $subcategorias[$z]['id_servicio_subcategoria']){
                $sel_subcategorias .= '<option value="'.$subcategorias[$z]['id_servicio_subcategoria'].'" selected>' . $subcategorias[$z]['nombre_servicio_subcategoria'] . '</option>';
            }else{
                $sel_subcategorias .= '<option value="'.$subcategorias[$z]['id_servicio_subcategoria'].'">' . $subcategorias[$z]['nombre_servicio_subcategoria'] . '</option>';
            }
        }
    }

    $sel_unidades = '<option value="0">-Seleccione-</option>';
    if(isset($unidades))
    {
        for($z = 0; $z < sizeof($unidades); $z++)
        {
            if($registro['id_servicio_unidad'] == $unidades[$z]['id_servicio_unidad']){
                $sel_unidades .= '<option value="'.$unidades[$z]['id_servicio_unidad'].'" selected>' . $unidades[$z]['nombre_servicio_unidad'] . '</option>';
            }else{
                $sel_unidades .= '<option value="'.$unidades[$z]['id_servicio_unidad'].'">' . $unidades[$z]['nombre_servicio_unidad'] . '</option>';
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
           
            $error_ca = !empty(form_error('id_campana_aviso', '<div class="text-danger">', '</div>'));
            $error_sc = !empty(form_error('id_servicio_clasificacion', '<div class="text-danger">', '</div>'));
            $error_sca = !empty(form_error('id_servicio_categoria', '<div class="text-danger">', '</div>'));
            $error_ss = !empty(form_error('id_servicio_subcategoria', '<div class="text-danger">', '</div>'));
            $error_so_c = !empty(form_error('id_so_contratante', '<div class="text-danger">', '</div>'));
            $error_pc = !empty(form_error('id_presupuesto_concepto', '<div class="text-danger">', '</div>'));
            $error_so_s = !empty(form_error('id_so_solicitante', '<div class="text-danger">', '</div>'));
            $error_pcs = !empty(form_error('id_presupuesto_concepto_solicitante', '<div class="text-danger">', '</div>'));
            $error_ds = !empty(form_error('descripcion_servicios', '<div class="text-danger">', '</div>'));
            $error_cat = !empty(form_error('cantidad', '<div class="text-danger">', '</div>'));
            $error_pu = !empty(form_error('precio_unitarios', '<div class="text-danger">', '</div>'));
            $error_active = !empty(form_error('active', '<div class="text-danger">', '</div>'));

            if(validation_errors() == TRUE || $error_partida == TRUE || $error_monto_contrato == TRUE)
            {
                echo '<div class="alert alert-danger"><button class="close"  data-dismiss="alert">x</button>
                <h4><i class="icon fa fa-ban"></i>¡Alerta!</h4>' . validation_errors() . $mensaje_partida . @$mensaje_monto_contrato.'</div>';  
            }

            /** si se sa clic en el boton de regresar, se active el tab de desgloses **/
            $this->session->set_flashdata('tab_flag', "desglose");
        ?>
        <form role="form" method="post" autocomplete="off" action="<?php echo base_url(); ?>index.php/tpoadminv1/capturista/facturas/validate_editar_factura_desglose" enctype="multipart/form-data" >
            <div class="box box-primary">
                <div class="box-header">
                    <?php echo anchor("tpoadminv1/capturista/facturas/editar_factura/" . $registro['id_factura'], "<button class='btn btn-default' type='button'>Regresar</button></td>"); ?>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <input type="hidden" value="<?php echo $id_ejercicio; ?>" class="form-control" name="id_ejercicio"/>
                    <input type="hidden" value="<?php echo $registro['id_factura']; ?>" class="form-control" name="id_factura"/>
                    <input type="hidden" value="<?php echo $registro['id_factura_desglose']; ?>" class="form-control" name="id_factura_desglose"/>
                    <div class="form-group">
                        <label>Campa&ntilde;a o aviso institucional*
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_campana_aviso']?>"></i>
                        </label>
                        <select name="id_campana_aviso" class="form-control <?php if($error_ca) echo 'has-error' ?>">
                            <?php echo $sel_campanas; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Clasificaci&oacute;n del servicio*
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_servicio_clasificacion']?>"></i>
                        </label>
                        <select name="id_servicio_clasificacion" class="form-control <?php if($error_sc) echo 'has-error' ?>">
                            <?php echo $sel_clasificacion; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Categor&iacute;a del servicio* 
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_servicio_categoria']?>"></i>
                        </label>
                        <select name="id_servicio_categoria" class="form-control <?php if($error_sca) echo 'has-error' ?>">
                            <?php echo $sel_categorias; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Subcategor&iacute;a del servicio* 
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_servicio_subcategoria']?>"></i>
                        </label>
                        <select name="id_servicio_subcategoria" class="form-control <?php if($error_ss) echo 'has-error' ?>">
                            <?php echo $sel_subcategorias; ?>
                        </select>
                    </div> 
                    <div class="form-group">
                        <label>Unidad
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_servicio_unidad']?>"></i>
                        </label>
                        <select name="id_servicio_unidad" class="form-control">
                            <?php echo $sel_unidades; ?>
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
                        <label>Partida de contratante*
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_presupuesto_concepto']?>"></i>
                        </label>
                        <select name="id_presupuesto_concepto" class="form-control <?php if($error_pc) echo 'has-error' ?>">
                            <?php echo $sel_presupuestos; ?>
                        </select>
                        <p class="text-danger" id="error_p_c"></p>
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
                        <label>Partida de solicitante*
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_presupuesto_concepto_solicitante']?>"></i>
                        </label>
                        <select name="id_presupuesto_concepto_solicitante" class="form-control <?php if($error_pcs) echo 'has-error' ?>">
                            <?php echo $sel_presupuestos_solicitantes; ?>
                        </select>
                        <p class="text-danger" id="error_p_s"></p>
                    </div>
                    <div class="form-group">
                        <label>&Aacute;rea administrativa encargada de solicitar el servicio
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['area_administrativa']?>"></i>
                        </label>
                        <?php $class = "form-control";
                                echo form_input(array('type' => 'text', 'name' => 'area_administrativa', 'value' => $registro['area_administrativa'], 'class' => $class)); ?>
                    </div>
                    <div class="form-group <?php if($error_ds) echo 'has-error' ?>">
                        <label>Descripci&oacute;n del servicio o producto adquirido*
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['descripcion_servicios']?>"></i>
                        </label>
                        <textarea class="form-control" name="descripcion_servicios" id="descripcion_servicios"><?php echo $registro['descripcion_servicios']; ?></textarea>
                    </div> 
                    <div class="form-group">
                        <label>Cantidad*
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['cantidad']?>"></i>
                        </label>
                        <?php $class = "form-control"; if($error_cat) $class = "form-control has-error";
                                    echo form_input(array('type' => 'number', 'step'=>'0.01', 'name' => 'cantidad', 'value' => $registro['cantidad'], 'class' => $class)); ?>
                    </div>
                    <div class="form-group">
                        <label>Precio unitario con I.V.A. incluido*
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['precio_unitarios']?>"></i>
                        </label>
                        <?php $class = "form-control"; if($error_pu) $class = "form-control has-error";
                                    echo form_input(array('type' => 'number', 'step'=>'0.01', 'name' => 'precio_unitarios', 'value' => $registro['precio_unitarios'], 'class' => $class)); ?>
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
                        <select name="active" class="form-control <?php if($error_active) echo 'has-error' ?>">
                            <?php echo $sel_estatus; ?>
                        </select>
                    </div> 
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <button class="btn btn-primary" type="submit">Guardar</button>
                    <?php echo anchor("tpoadminv1/capturista/facturas/editar_factura/" . $registro['id_factura'], "<button class='btn btn-default' type='button'>Regresar</button></td>"); ?>
                </div>     
            </div><!-- /.box -->    
        </form>
    </div>
</section>

<script type="text/javascript">

    var get_partidas = function(tipo)
    {
        var form_data = new FormData();                  
        form_data.append('id_ejercicio', $('input[name="id_ejercicio"]').val());
        form_data.append('tipo', tipo);
        if(tipo == 'contratante'){
            form_data.append('id_so', $('select[name="id_so_contratante"]').val());
        }else if(tipo == 'solicitante'){
            form_data.append('id_so', $('select[name="id_so_solicitante"]').val());
        }
        var url = '<?php echo base_url() . 'index.php/tpoadminv1/capturista/presupuestos/get_presupuesto_conceptos' ?>';

        buscar_catalogos(url, form_data, set_partidas, tipo);
    }

    var get_categorias = function()
    {
        var form_data = new FormData();                  
        form_data.append('id_servicio_clasificacion', $('select[name="id_servicio_clasificacion"]').val());
        var url = '<?php echo base_url() . 'index.php/tpoadminv1/catalogos/servicios/get_categoria_filtro' ?>';

        buscar_catalogos(url, form_data, set_categorias);
    }

    var get_subcategorias = function()
    {
        var form_data = new FormData();                  
        form_data.append('id_servicio_categoria', $('select[name="id_servicio_categoria"]').val());
        var url = '<?php echo base_url() . 'index.php/tpoadminv1/catalogos/servicios/get_subcategoria_filtro' ?>';
        buscar_catalogos(url, form_data, set_subcategorias);
    }

    var get_unidades = function()
    {
        var form_data = new FormData();                  
        form_data.append('id_servicio_subcategoria', $('select[name="id_servicio_subcategoria"]').val());
        var url = '<?php echo base_url() . 'index.php/tpoadminv1/catalogos/servicios/get_unidad_filtro' ?>';

        buscar_catalogos(url, form_data, set_unidades);
    }

    var set_partidas = function(response, tipo)
    {
        var options = '<option values="0" >-Seleccione-</option>';
        if(response && response[0] == '['){
            var data = $.parseJSON(response);
            if($.isArray(data)){
                var i;
                if(data.length == 1){ //para poner el valor por default
                    options = ''
                    if(tipo == 'contratante'){
                        $('select[name="id_presupuesto_concepto"]').removeClass('has-error');
                    }else if(tipo == 'solicitante'){
                        $('select[name="id_presupuesto_concepto_solicitante"]').removeClass('has-error');
                    }
                }
                for (i = 0; i < data.length; i++) { 
                    options += "<option data-valido=" + data[i]['presupuesto_disponible'] + " value=" + data[i]['id_presupuesto_concepto'] + ">" + data[i]['nombre_presupuesto_concepto'] + "</option>";
                }
            }
        }
        if(tipo == 'contratante'){
            $('select[name="id_presupuesto_concepto"]').empty();
            $('select[name="id_presupuesto_concepto"]').append(options);
        }else if(tipo == 'solicitante'){
            $('select[name="id_presupuesto_concepto_solicitante"]').empty();
            $('select[name="id_presupuesto_concepto_solicitante"]').append(options);
        }
        
    }

    var set_categorias = function(response)
    {
        var options = '<option values="0" >-Seleccione-</option>';
        if(response && response[0] == '['){
            var data = $.parseJSON(response);
            if($.isArray(data)){
                var i;
                if(data.length == 1) //para poner el valor por default
                    options = ''
                for (i = 0; i < data.length; i++) { 
                    options += "<option value=" + data[i]['id_servicio_categoria'] + ">" + data[i]['nombre_servicio_categoria'] + "</option>";
                }
            }
        }
        $('select[name="id_servicio_categoria"]').empty();
        $('select[name="id_servicio_categoria"]').append(options);
    }

    var set_subcategorias = function(response)
    {
        var options = '<option value="0" >-Seleccione-</option>';
        if(response && response[0] == '['){
            var data = $.parseJSON(response);
            if($.isArray(data)){
                var i;
                if(data.length == 1) //para poner el sin contrato por default
                    options = ''
                for (i = 0; i < data.length; i++) { 
                    options += "<option value=" + data[i]['id_servicio_subcategoria'] + ">" + data[i]['nombre_servicio_subcategoria'] + "</option>";
                }
            }
        }
        $('select[name="id_servicio_subcategoria"]').empty();
        $('select[name="id_servicio_subcategoria"]').append(options);
    }

    var set_unidades = function(response)
    {
        var options = '<option value="0" >-Seleccione-</option>';
        if(response && response[0] == '['){
            var data = $.parseJSON(response);
            if($.isArray(data)){
                var i;
                if(data.length == 1) //para poner el sin contrato por default
                    options = ''
                for (i = 0; i < data.length; i++) { 
                    options += "<option value=" + data[i]['id_servicio_unidad'] + ">" + data[i]['nombre_servicio_unidad'] + "</option>";
                }
            }
        }
        $('select[name="id_servicio_unidad"]').empty();
        $('select[name="id_servicio_unidad"]').append(options);
    }

    var buscar_catalogos = function(url_server, formData, callback, tipo){
                                   
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
                    if(tipo){
                        callback(response, tipo);
                    }else{ 
                        callback(response);
                    }
                }
            }
        });
    }

</script>