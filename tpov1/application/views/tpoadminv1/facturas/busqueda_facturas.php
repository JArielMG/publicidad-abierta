<?php

/* 
 *
 * INAI TPO
 * DIC - 2018
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

    ?>
    <input type="hidden" id="url" value="<?php echo $serviceSide?>">
    <div class="row">
        <div class="col-xs-12">
            <div class="box table-responsive">
                <div class="box-header">
                    <div class="pull-left">
                        <?php echo anchor("tpoadminv1/capturista/facturas/agregar_factura", "<button class='btn btn-success'><i class=\"fa fa-plus-circle\"></i> Agregar</button></td>"); ?>

                        <br/>
                        <br/>
                        <form role="form" method="post" autocomplete="off" action="<?php echo base_url(); ?>index.php/tpoadminv1/capturista/facturas/validate_editar_status_factura" enctype="multipart/form-data" >

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
                        <a class="btn btn-default" <?php echo $print_onclick   ?>><i class="fa fa-print"></i> Imprimir</a>
                        <a id="descargabtn" class="btn btn-default" onclick="descargar_archivo()" <?php //echo $print_onclick_exp   ?>><i class="fa fa-file"></i> Exportar a Excel</a>
                        <input type="hidden" id="link_descarga" value="<?php echo $link_descarga; ?>"/>
                    </div>
                </div><!-- /.box-header -->
                
                <div class="box-body">
                    <input type="hidden" id="link_edit_factura" value="<?php echo $link_edit_factura; ?>"/>
                    <table id="facturas" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Contrato <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_contrato']?>"></i></th>
                                <th>Orden <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_orden_compra']?>"></i></th>
                                <th>Ejercicio  <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_ejercicio']?>"></i></th>
                                <th>Trimestre <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_trimestre']?>"></i></th>
                                <th>Proveedor <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_proveedor']?>"></i></th>
                                <th>N&uacute;mero de factura <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['numero_factura']?>"></i></th>
                                <th>Fecha de erogaci&oacute;n <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_erogacion']?>"></i></th>
                                <th>Monto <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['monto_factura']?>"></i></th>
                                <th>Estatus <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['active']?>"></i></th>
                                <th style="width: 10px;"></th>
                                <th style="width: 10px;"></th>
                                <th style="width: 10px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                               /* $c_replace = array('\'', '"');
                                for($z = 0; $z < sizeof($registros); $z++)
                                {
                                    echo '<tr>';
                                    echo '<td>' . $registros[$z]['id'] . '</td>';
                                    echo '<td>' . $registros[$z]['contrato'] . '</td>';
                                    echo '<td>' . $registros[$z]['orden'] . '</td>';
                                    echo '<td>' . $registros[$z]['ejercicio'] . '</td>';
                                    echo '<td>' . $registros[$z]['trimestre'] . '</td>';
                                    echo '<td>' . $registros[$z]['proveedor'] . '</td>';
                                    echo '<td>' . $registros[$z]['numero_factura'] . '</td>';
                                    echo '<td>' . $registros[$z]['fecha_erogacion'] . '</td>';
                                    echo '<td>' . $registros[$z]['monto_factura'] . '</td>';
                                    echo '<td>' . $registros[$z]['active'] . '</td>';
                                    echo "<td> <span class='btn-group btn btn-info btn-sm' onclick=\"abrirModal(" . $registros[$z]['id_factura'] . ")\"> <i class='fa fa-search'></i></span></td>";
                                    echo '<td>' . anchor("tpoadminv1/capturista/ordenes_compra/editar_orden_compra/".$registros[$z]['id_factura'], "<button class='btn btn-warning btn-sm' title='Editar'><i class=\"fa fa-edit\"></i></button></td>"); 
                                    echo "<td> <span class='btn-group btn btn-danger btn-sm' onclick=\"eliminarModal(" . $registros[$z]['id_factura'] . ", '". str_replace($c_replace, "", $registros[$z]['numero_factura']) . "')\"> <i class='fa fa-close'></i></span></td>";
                                    
                                    echo '</tr>';
                                }*/
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
                            <b>Ejercicio* </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_ejercicio']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_1"></td>
                    </tr>   
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Proveedor* </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_proveedor']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_2"></td>
                    </tr> 
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Contrato* </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_contrato']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_3"></td>
                    </tr>
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Orden*</b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_orden_compra']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_4"></td>
                    </tr>
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Trimestre* </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_trimestre']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_5"></td>
                    </tr>
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>N&uacute;mero de factura*</b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['numero_factura']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_8"></td>
                    </tr>
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Monto</b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['monto_factura']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_9"></td>
                    </tr>
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Hipervínculo a la factura en formato PDF</b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['url_factura_pdf']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_19"></td>
                    </tr>
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Archivo de la factura en PDF</b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['file_factura_pdf']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_10"></td>
                    </tr>
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Hipervínculo a la factura en formato XML</b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['url_factura_xml']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_20"></td>
                    </tr>
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Archivo de la factura en XML</b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['file_factura_xml']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_11"></td>
                    </tr>
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Fecha de erogaci&oacute;n* </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_erogacion']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_12"></td>
                    </tr>
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Estatus*</b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['active']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_13"></td>
                    </tr>
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Fecha de validaci&oacute;n </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_validacion']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_14"></td>
                    </tr>   
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Área responsable de la informaci&oacute;n </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['area_responsable']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_15"></td>
                    </tr>      
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>A&ntilde;o </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['periodo']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_16"></td>
                    </tr> 
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Fecha de actualizaci&oacute;n </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_actualizacion']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_17"></td>
                    </tr>   
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Nota </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['nota']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_18"></td>
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
    
    var eliminarModal = function(id, name){
        var html_btns = '<button type="button" class="btn btn-danger" onclick="eliminar('+id+')">Si</button>' +
                   '<button type="button" class="btn btn-default" data-dismiss="modal">No</button>';
        $('#myModalDelete').find('#footer_btns').html(html_btns);
        $('#myModalDelete').find('#mensaje_modal').html('¿Desea eliminar la factura <b>' + name+ '</b>?');
        $('#myModalDelete').modal('show');
    }

    var eliminar = function (id){
        window.location.href = "eliminar_factura/" + id;
    }

    var abrirModal = function(id){

        $.ajax({
            url: '<?php echo base_url() . 'index.php/tpoadminv1/capturista/facturas/get_factura/' ?>'+id,
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
                    $('#myModal').find('#item_1').html(response.ejercicio);
                    $('#myModal').find('#item_2').html(response.nombre_proveedor);
                    $('#myModal').find('#item_3').html(response.nombre_contrato);
                    $('#myModal').find('#item_4').html(response.numero_orden_compra);
                    $('#myModal').find('#item_5').html(response.trimestre);
                    $('#myModal').find('#item_8').html(response.numero_factura);
                    $('#myModal').find('#item_9').html(response.monto);
                    $('#myModal').find('#item_12').html(response.fecha_erogacion);
                    $('#myModal').find('#item_13').html(response.estatus);
                    $('#myModal').find('#item_14').html(response.fecha_validacion);
                    $('#myModal').find('#item_15').html(response.area_responsable);
                    $('#myModal').find('#item_16').html(response.periodo);
                    $('#myModal').find('#item_17').html(response.fecha_actualizacion);
                    $('#myModal').find('#item_18').html(response.nota);
                    $('#myModal').find('#item_19').html(response.url_factura_pdf);
                    $('#myModal').find('#item_20').html(response.url_factura_xml);

                    if(response.name_file_factura_pdf){
                        var html = '<a href="' + response.path_file_factura_pdf + '" download>'+ response.name_file_factura_pdf +'</a>' 
                        $('#myModal').find('#item_10').html(html);
                    }else{
                        $('#myModal').find('#item_10').html('No hay archivo');
                    }

                    if(response.name_file_factura_xml){
                        var html = '<a href="' + response.name_file_factura_xml + '" download>'+ response.name_file_factura_xml +'</a>' 
                        $('#myModal').find('#item_11').html(html);
                    }else{
                        $('#myModal').find('#item_11').html('No hay archivo');
                    }
                    
                    $('#myModal').modal('show'); 
                }
            }
        });
    }

    var buscar = function(url_server, formData, callback, container){   
               
        $.ajax({
            url: url_server, // point to server-side PHP script 
            dataType: 'JSON',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: formData,                         
            type: 'post',
            complete: function(){
            },
            error:function(){
                error_data();
            },
            success: function(response){
                if(response && callback){
                    callback(response, container);
                }else{
                    error_data();
                }
            }
        });
    }

    var error_data = function(){
        $('#facturas').find('tbody').empty();
        initDataTable();
    }

    var set_valores_tabla = function(response, container){
        $('#facturas').find('tbody').empty();
        if(Array.isArray(response)){
            var position = 1;
            response.map(function(e){
                var html = '<tr>' +
                        '<td>' + position + '</td>' +
                        '<td>' + e.contrato + '</td>' +
                        '<td>' + e.orden + '</td>' +
                        '<td>' + e.ejercicio + '</td>' +
                        '<td>' + e.trimestre + '</td>' +
                        '<td>' + e.proveedor + '</td>' +
                        '<td>' + e.numero_factura + '</td>' +
                        '<td>' + e.fecha_erogacion+ '</td>' +
                        '<td>$' + parseFloat(e.monto_factura, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString() + '</td>' +
                        '<td>' + e.active + '</td>' +
                        '<td> <span class="btn-group btn btn-info btn-sm" onclick="abrirModal(' + e.id_factura + ')"> <i class="fa fa-search"></i></span></td>' +
                        '<td><a href="' + $('#link_edit_factura').val() +  e.id_factura + '" class="btn btn-warning btn-sm" ><i class="fa fa-edit"></i></a></td>' +
                        '<td> <span class="btn-group btn btn-danger btn-sm" onclick="eliminarModal('+ e.id_factura +', \'' + e.numero_factura +'\')"> <i class="fa fa-close"></i></span></td>' +
                        '</tr>';
                $('#facturas').find('tbody').append(html);
                position++;
            });
        }
        initDataTable();
    }

    var initDataTable = function(){
        $('#facturas').dataTable({
            'bPaginate': true,
            'bLengthChange': true,
            'bFilter': true,
            'bSort': true,
            'bInfo': true,
            'bAutoWidth': false,
            'columnDefs': [ 
                { 'orderable': false, 'targets': [10,11,12] } 
            ],
            'aLengthMenu': [[10, 25, 50, 100], [10, 25, 50, 100]],  //Paginacion
            'oLanguage': { 
                'sSearch': 'B&uacute;squeda ',
                'sInfoFiltered': '(filtrado de un total de _MAX_ registros)',
                'sInfo': 'Mostrando registros del <b>_START_</b> al <b>_END_</b> de un total de <b>_TOTAL_</b> registros',
                'sZeroRecords': 'No se encontraron resultados',
                'EmptyTable': 'Ning&uacute;n dato disponible en esta tabla',
                'sInfoEmpty': 'Mostrando registros del 0 al 0 de un total de 0 registros',
                'sLoadingRecords': 'Cargando...',
                'sProcessing': 'Cargando...',
                'oPaginate': {
                    'sFirst': 'Primero',
                    'sLast': '&Uacute;ltimo',
                    'sNext': 'Siguiente',
                    'sPrevious': 'Anterior'
                },
                'sLengthMenu': '_MENU_ Registros por p&aacute;gina'
            }
        });
    }

    var preparar_exportacion = function ()
    {
        
        $.ajax({
            url: '<?php echo base_url() . 'index.php/tpoadminv1/capturista/facturas/preparar_exportacion_facturas/' ?>',
            dataType:'JSON',
            beforeSend: function () {
            },
            complete: function () {
        
            },
            error:function () {
               
            },
            success: function (response) {
                if(response){
                    $('#export_file').attr('href', response)
                }
            }
        });
    }

    var init = function(){
        //preparar_exportacion();
        var url = $('#url').val();
        $('#facturas').find('tbody').empty();
        $('#facturas').find('tbody').append('<tr><td colspan="13" class="text-center"><i class="fa fa-refresh fa-spin"></i> Cargando...</td></tr>');
        buscar(url, null, set_valores_tabla, 'facturas');

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