<?php

/* 
 * INAI TPO
 */

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
</style>
<link href="<?php echo base_url(); ?>editors/tinymce/skins/lightgray/skin.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>editors/tinymce/tinymce.min.js"></script>
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
    <?php


        $sel_ejercicios = '';

        $ejercicio['id_ejercicio'] = "0";
        $ejercicio['ejercicio'] = "Todos";
        $ejercicios[] = $ejercicio;



        $ejercicios = array_reverse($ejercicios);
        for($z = 0; $z < sizeof($ejercicios); $z++)
        {
            if ($ejercicios[$z]['id_ejercicio'] == $yearSelected){
                $sel_ejercicios .= '<option value="'.$ejercicios[$z]['id_ejercicio'].'" selected>' . $ejercicios[$z]['ejercicio'] . '</option>';
            }else{
                $sel_ejercicios .= '<option value="'.$ejercicios[$z]['id_ejercicio'].'">' . $ejercicios[$z]['ejercicio'] . '</option>';
            }
            
        }


        $sel_estatus = '';
        $lista_estatus = ['-Seleccione-','Activo','Inactivo'];
        $lista_estatus_ids = ['','1','2'];
        for($z = 0; $z < sizeof($lista_estatus_ids); $z++)
        {
            
                if($lista_estatus_ids[$z] == '0' ){
                    $sel_estatus .= '<option value="'.$lista_estatus_ids[$z].'" selected>' . $lista_estatus[$z] . '</option>';
                }else{
                    $sel_estatus .= '<option value="'.$lista_estatus_ids[$z].'">' . $lista_estatus[$z] . '</option>';
                }
            
            
        }

        $sel_estatus2 = '';
        $lista_estatus2 = ['Todos','Activo','Inactivo'];
        $lista_estatus_ids2 = ['0','1','2'];
        for($z = 0; $z < sizeof($lista_estatus_ids2); $z++)
        {
            if ($lista_estatus_ids2[$z] == $statusSelected){
                $sel_estatus2 .= '<option value="'.$lista_estatus_ids2[$z].'" selected>' . $lista_estatus2[$z] . '</option>';            
            }else{
                $sel_estatus2 .= '<option value="'.$lista_estatus_ids2[$z].'">' . $lista_estatus2[$z] . '</option>';            
            }
        }

    ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box table-responsive">
                <div class="box-header">
                    <div class="pull-left">
                        <?php echo anchor("tpoadminv1/capturista/contratos/agregar_contrato", "<button class='btn btn-success'><i class=\"fa fa-plus-circle\"></i> Agregar</button></td>"); ?>

                        <br/>
                        <br/>
                        <form role="form" method="post" autocomplete="off" action="<?php echo base_url(); ?>index.php/tpoadminv1/capturista/contratos/validate_editar_status_contrato/" enctype="multipart/form-data" >

                            <div class="form-group">
                                <label style="margin-left: 25px;">Estatus*
                                    <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['active']?>"></i>
                                </label>
                                <select class="form-control" name="active" class="form-control <?php if($error_active) echo 'validation-error' ?>">
                                    <?php echo $sel_estatus; ?>
                                </select>
                                <br/>
                                <button class="btn btn-primary" type="submit">Guardar</button>
                            </div> 
                        </form>
                    </div>

                    <div class="pull-right">   
                        <div class="col-xs-12">                     
                            <a class="btn btn-default" <?php echo $print_onclick   ?>><i class="fa fa-print"></i> Imprimir</a>
                            <a id="descargabtn" class="btn btn-default" onclick="descargar_archivo()"><i class="fa fa-file"></i> Exportar a Excel</a>
                            <input type="hidden" id="link_descarga" value="<?php echo $link_descarga; ?>"/>
                        </div>
                        <br/>
                        <br/>
                        <div>
                            <div class="col-xs-6">
                                    <div class="form-group">
                                        <label>Ejercicio* 
                                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_ejercicio']?>"></i>
                                        </label>
                                        <select name="id_ejercicio" id="yearSelect" class="form-control <?php if($error_active) echo 'validation-error' ?>">
                                            <?php echo $sel_ejercicios; ?>
                                        </select>
                                    </div>  
                                
                            </div>
                            <div class="col-xs-6">
                                    <div class="form-group">
                                        <label style="margin-left: 25px;">Estatus
                                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['active']?>"></i>
                                        </label>
                                        <select class="form-control" id="statusSelect" name="active" class="form-control <?php if($error_active) echo 'validation-error' ?>">
                                            <?php echo $sel_estatus2; ?>
                                        </select>
                                    </div> 
                            </div>
                        </div>
                    </div>
                </div><!-- /.box-header -->
                
                <div class="box-body">
                    <table id="contratos" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Ejercicio  <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_ejercicio']?>"></i></th>
                                <th>Trimestre <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_trimestre']?>"></i></th>
                                <th>Sujeto obligado contratante <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_so_contratante']?>"></i></th>
                                <th>Sujeto obligado solicitante <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_so_solicitante']?>"></i></th>
                                <th>N&uacute;mero de contrato <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['numero_contrato']?>"></i></th>
                                <th>Nombre o raz&oacute;n social del proveedor <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_proveedor']?>"></i></th>
                                <th>Monto original del contrato <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['monto_contrato']?>"></i></th>
                                <th>Monto modificado <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['monto_modificado']?>"></i></th>
                                <th>Monto total <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['monto_total']?>"></i></th>
                                <th>Monto pagado a la fecha <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['monto_pagado_a_la_fecha']?>"></i></th>
                                <th>Estatus <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['active']?>"></i></th>
                                <th style="width: 8px;"></th>
                                <th style="width: 8px;"></th>
                                <th style="width: 8px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $c_replace = array('\'', '"');
                                if (is_array($registros)){
                                    for($z = 0; $z < sizeof($registros); $z++)
                                    {
                                        echo '<tr>';
                                        echo '<td>' . $registros[$z]['id'] . '</td>';
                                        echo '<td>' . $registros[$z]['ejercicio'] . '</td>';
                                        echo '<td>' . $registros[$z]['trimestre'] . '</td>';
                                        echo '<td>' . $registros[$z]['nombre_so_contratante'] . '</td>';
                                        echo '<td>' . $registros[$z]['nombre_so_solicitante'] . '</td>';
                                        echo '<td>' . $registros[$z]['numero_contrato'] . '</td>';
                                        echo '<td>' . $registros[$z]['nombre_proveedor'] . '</td>';
                                        echo '<td>' . $registros[$z]['monto_contrato'] . '</td>';
                                        echo '<td>' . $registros[$z]['monto_modificado'] . '</td>';
                                        echo '<td>' . $registros[$z]['monto_total'] . '</td>';
                                        echo '<td>' . $registros[$z]['monto_pagado'] . '</td>';
                                        echo '<td>' . $registros[$z]['active'] . '</td>';
                                        echo "<td> <span class='btn-group btn btn-info btn-sm' onclick=\"abrirModal(" . $registros[$z]['id_contrato'] . ")\"> <i class='fa fa-search'></i></span></td>";
                                        echo '<td>' . anchor("tpoadminv1/capturista/contratos/editar_contrato/".$registros[$z]['id_contrato'], "<button class='btn btn-warning btn-sm' title='Editar'><i class=\"fa fa-edit\"></i></button></td>"); 
                                        echo "<td> <span class='btn-group btn btn-danger btn-sm' onclick=\"eliminarModal(" . $registros[$z]['id_contrato'] . ", '". str_replace($c_replace, "", $registros[$z]['numero_contrato']) . "')\"> <i class='fa fa-close'></i></span></td>";
                                        
    									
                                        echo '</tr>';
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->

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
                            <b>Procedimiento*</b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_procedimiento']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_1"></td>
                    </tr>    
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Nombre o raz&oacute;n social del proveedor* </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_proveedor']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_2"></td>
                    </tr>    
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Ejercicio* </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_ejercicio']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_3"></td>
                    </tr>    
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Trimestre* </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_trimestre']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_4"></td>
                    </tr>    
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Sujeto obligado contratante*</b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_so_contratante']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_5"></td>
                    </tr>    
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Sujeto obligado solicitante*</b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_so_solicitante']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_6"></td>
                    </tr>    
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>N&uacute;mero de contrato*</b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['numero_contrato']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_7"></td>
                    </tr>   
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Objeto del contrato*</b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['objeto_contrato']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_8"></td>
                    </tr> 
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Descripci&oacute;n*</b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['descripcion_justificacion']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_9"></td>
                    </tr> 
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Fundamento jur&iacute;dico*</b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fundamento_juridico']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_10"></td>
                    </tr>
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Fecha de celebraci&oacute;n* </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_celebracion']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_11"></td>
                    </tr>
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Fecha de inicio* </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_inicio']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_12"></td>
                    </tr>
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Fecha de t&eacute;rmino* </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_fin']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_13"></td>
                    </tr>
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Monto original del contrato*</b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['monto_contrato']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_14"></td>
                    </tr>
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Hipervínculo al contrato firmado</b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['url_contrato']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_25"></td>
                    </tr>
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Archivo del contrato en PDF</b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['file_contrato']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_15"></td>
                    </tr>
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Fecha de validaci&oacute;n </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_validacion']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_16"></td>
                    </tr>   
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Área responsable de la informaci&oacute;n </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['area_responsable']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_17"></td>
                    </tr>      
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>A&ntilde;o </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['periodo']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_18"></td>
                    </tr> 
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Fecha de actualizaci&oacute;n </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_actualizacion']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_19"></td>
                    </tr>   
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Nota </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['nota']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_20"></td>
                    </tr>                     
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Estatus*</b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['active']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_21">
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Monto modificado </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['monto_modificado']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_22"></td>
                    </tr>
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Monto total </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['monto_total']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_23"></td>
                    </tr>   
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Monto pagado a la fecha </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['monto_pagado_a_la_fecha']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_24"></td>
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

    var yearSelected = "<?php echo  $yearSelected;?>";
    var statusSelect = "<?php echo  $statusSelected;?>";

    $('#statusSelect').on('change', function(){
        statusSelect = $(this).val();
        window.location.href = "<?php echo  base_url() . 'index.php/tpoadminv1/capturista/contratos/busqueda_contratos/'; ?>" + yearSelected + "/" + statusSelect; 
    });

    $('#yearSelect').on('change', function(){
        yearSelected = $(this).val();
        //alert(selected);
        window.location.href = "<?php echo  base_url() . 'index.php/tpoadminv1/capturista/contratos/busqueda_contratos/'; ?>" + yearSelected + "/" + statusSelect;
    });

    
    var eliminarModal = function(id, name){
        var html_btns = '<button type="button" class="btn btn-danger" onclick="eliminar('+id+')">Si</button>' +
                   '<button type="button" class="btn btn-default" data-dismiss="modal">No</button>';
        $('#myModalDelete').find('#footer_btns').html(html_btns);
        $('#myModalDelete').find('#mensaje_modal').html('¿Desea eliminar el contrato con n&uacute;mero <b>' + name+ '</b>?');
        $('#myModalDelete').modal('show');
    }

    var eliminar = function (id){
        window.location.href = "eliminar_contrato/" + id;
    }

    var abrirModal = function(id){
        //$('#myModal').find('#item_1').html(name);
        //$('#myModal').find('#item_2').html(active);
        //$('#myModal').modal('show'); 

        $.ajax({
            url: '<?php echo base_url() . 'index.php/tpoadminv1/capturista/contratos/get_contrato/' ?>'+id,
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
                    $('#myModal').find('#item_1').html(response.nombre_procedimiento);
                    $('#myModal').find('#item_2').html(response.nombre_proveedor);
                    $('#myModal').find('#item_3').html(response.ejercicio);
                    $('#myModal').find('#item_4').html(response.trimestre);
                    $('#myModal').find('#item_5').html(response.nombre_so_contratante);
                    $('#myModal').find('#item_6').html(response.nombre_so_solicitante);
                    $('#myModal').find('#item_7').html(response.numero_contrato);
                    $('#myModal').find('#item_8').html(response.objeto_contrato);
                    $('#myModal').find('#item_9').html(response.descripcion_justificacion);
                    $('#myModal').find('#item_10').html(response.fundamento_juridico);
                    $('#myModal').find('#item_11').html(response.fecha_celebracion);
                    $('#myModal').find('#item_12').html(response.fecha_inicio);
                    $('#myModal').find('#item_13').html(response.fecha_fin);
                    $('#myModal').find('#item_14').html(response.monto_contrato_formato);
                    $('#myModal').find('#item_25').html(response.url_contrato);
                    $('#myModal').find('#item_16').html(response.fecha_validacion);
                    $('#myModal').find('#item_17').html(response.area_responsable);
                    $('#myModal').find('#item_18').html(response.periodo);
                    $('#myModal').find('#item_19').html(response.fecha_actualizacion);
                    $('#myModal').find('#item_20').html(response.nota);
                    $('#myModal').find('#item_21').html(response.estatus);
                    $('#myModal').find('#item_22').html(response.monto_modificado);
                    $('#myModal').find('#item_23').html(response.monto_total);
                    $('#myModal').find('#item_24').html(response.monto_pagado);

                    if(response.name_file_contrato){
                        var html = '<a href="' + response.path_file_contrato + '" download>'+ response.name_file_contrato +'</a>' 
                        $('#myModal').find('#item_15').html(html);
                    }else{
                        $('#myModal').find('#item_15').html('No hay archivo');
                    }
                    
                    $('#myModal').modal('show'); 
                }
            }
        });
    }

    var descargar_archivo = function(){
        var url_server = $('#link_descarga').val();
        $('#descargabtn').empty();
        $('#descargabtn').append('<i class="fa fa-refresh fa-spin"></i>&nbsp;&nbsp;Exportar a Excel'); 
        $.ajax({
            url: url_server, // point to server-side PHP script 
            dataType: 'JSON',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: '',                         
            type: 'post',
            complete: function(){
                $('#descargabtn').empty();
                $('#descargabtn').append('<i class="fa fa-file"></i>&nbsp;&nbsp;Exportar a Excel'); 
            },
            error:function(){
            },
            success: function(response){
                window.open(response, '_blank');
            }
        });
    }
    
</script>