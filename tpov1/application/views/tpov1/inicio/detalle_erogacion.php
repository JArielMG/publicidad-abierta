
<?php 

    $link_pdf = '';
    if($disponible == true && !empty($factura['file_factura_pdf'])){
        $link_pdf = "<a href='" . $factura['path_file_factura_pdf'] . "' download>" . $factura['file_factura_pdf'] . "</a>";
    }

    $link_xml = '';
    if($disponible == true && !empty($factura['file_factura_xml'])){
        $link_xml = "<a href='" . $factura['path_file_factura_xml'] . "' download>" . $factura['file_factura_xml'] . "</a>";
    }
?>

<?php
if($disponible == true){ /* se muestra la info*/ 
?> 
<style>
    #info_factura td{
        padding: 2px !important;
        font-size: 12px;
    }

    #table_modal td{
        padding: 0px !important;
    }

    #table_modal p{
        padding: 0 0 0px !important;
        margin: 0 0 5px !important;
    }
</style>

<input name="id_factura" type="hidden" value="<?php echo $factura['id_factura'] ?>">
<div class="row">
    <div class="box box-info box-solid">
        <div class="box-header header">
            <h3 class="box-title">Informaci&oacute;n de la erogaci&oacute;n</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        </div> <!-- / .box-header-->
        <div class="box-body with-border">
            <table id="info_factura" class="table table-striped">
                <tbody>
                    <tr>
                        <td class="text-right">N&uacute;mero de factura <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['numero_factura']?>"></i>: </td>
                        <td width="80%"><?php echo $factura['numero_factura']?></td>
                    </tr>
                    <tr>
                        <td class="text-right">Proveedor <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['proveedor']?>"></i>: </td>
                        <td width="80%"><?php echo $factura['nombre_proveedor'] . @$linkproveedor ?></td>
                    </tr>
                    <tr>
                        <td class="text-right">Nombre comercial del proveedor <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['nombre_comercial_proveedor']?>"></i>: </td>
                        <td width="80%"><?php echo $factura['nombre_comercial_proveedor']?></td>
                    </tr>
                    <tr>
                        <td class="text-right">Contrato <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['numero_contrato']?>"></i>: </td>
                        <td width="80%"><?php echo $factura['nombre_contrato'] . @$linkcontrato ?></td>
                    </tr>
                    <tr>
                        <td class="text-right">Orden de compra <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['orden_compra']?>"></i>: </td>
                        <td width="80%"><?php echo $factura['numero_orden_compra'] . @$linkorden ?></td>
                    </tr>
                    <tr>
                        <td class="text-right">Ejercicio <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['ejercicio']?>"></i>: </td>
                        <td width="80%"><?php echo $factura['ejercicio']?></td>
                    </tr>
                    <tr>
                        <td class="text-right">Trimestre <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['trimestre']?>"></i>: </td>
                        <td width="80%"><?php echo $factura['trimestre']?></td>
                    </tr>
                    <tr>
                        <td class="text-right">Hipervínculo a la factura en formato PDF <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['url_factura_pdf']?>"></i>: </td>
                        <td width="80%"> <a href="<?php echo $factura['url_factura_pdf']?>" target="_blank"><?php echo $factura['url_factura_pdf']?></a> </td>
                    </tr>
                    <tr>
                        <td class="text-right">Archivo de la factura en PDF <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['file_factura_pdf']?>"></i>: </td>
                        <td width="80%"><?php echo $link_pdf?></td>
                    </tr>
                    <tr>
                        <td class="text-right">Hipervínculo a la factura en formato XML<i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['url_factura_xml']?>"></i>: </td>
                        <td width="80%"> <a href="<?php echo $factura['url_factura_xml']?>" target="_blank"><?php echo $factura['url_factura_xml']?></a> </td>
                    </tr>
                    <tr>
                        <td class="text-right">Archivo de la factura en XML <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['file_factura_xml']?>"></i>: </td>
                        <td width="80%"><?php echo $link_xml?></td>
                    </tr>
                    <tr>
                        <td class="text-right">Fecha de erogaci&oacute;n <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_erogacion']?>"></i>: </td>
                        <td width="80%"><?php echo $factura['fecha_erogacion']?></td>
                    </tr>
                    <tr>
                        <td class="text-right">Monto total <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['monto_factura']?>"></i>: </td>
                        <td width="80%"><?php echo $factura['monto']?></td>
                    </tr>
                    <tr>
                        <td class="text-right">Nota <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['nota']?>"></i>: </td>
                        <td width="80%"><?php echo $factura['nota']?></td>
                    </tr>
                </tbody>
            </table>    
        </div> <!-- /. box-body -->
    </div> <!-- /. box -->
</div> <!-- /. row-->

<div class="row"> <!-- Servicios de información-->
    <div class="box box-default">
        <div class="box-header header">
            <h3 class="box-title">Subconceptos de factura asociados a la erogaci&oacute;n</h3>
            <div id="options_subconceptos" class="row" style="margin-bottom:5px; margin-right:0px;">
                <div class="pull-right">
                    <a class="btn btn-default" onclick="print_btn()"><i class="fa fa-print"></i> Imprimir</a>
                    <a id="descargabtntable" class="btn btn-default" onclick="descargar_archivo_table()"><i class="fa fa-file"></i> Exportar datos</a>
                    <input type="hidden" id="link_descarga_table" value="<?php echo $link_descarga_table; ?>"/>
                    <input type="hidden" id="link_print" value="<?php echo $print_url; ?>"/>
                </div>
            </div>
        </div> <!-- / .box-header-->
        <div class="box-body with-border table-responsive">
            <div class="table-responsive-md">
                <table id="subconceptos" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Campa&ntilde;a o aviso institucional  <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['campana_aviso']?>"></i></th>
                            <th>Clasificaci&oacute;n <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['clasificacion']?>"></i></th>
                            <th>Categor&iacute;a del servicio<i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['categoria']?>"></i></th>
                            <th>Monto del subconcepto <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['monto_subconcepto']?>"></i></th>            
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                                    
                    </tbody>
                    <tfoot>
                        <tr style="font-size:13px; border-top: 2px solid #e8e8e8;">
                            <th>Σ</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div> <!-- /. table-responsive -->
        </div> <!-- / .box-body-->
    </div> <!-- / .box-->
</div>

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
                        <td>
                            <p>
                                <b>Campa&ntilde;a o aviso institucional </b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['campana_aviso']?>"></i>
                            </p>
                            <p id="item_1"></p>
                        </td>
                    </tr>   
                    <tr class="form-group">
                        <td>
                            <p>
                                <b>Clasificaci&oacute;n del servicio* </b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['servicio_clasificacion']?>"></i>
                            </p>
                            <p id="item_2"></p>
                        </td>
                    </tr> 
                    <tr class="form-group">
                        <td>
                            <p>
                                <b>Categor&iacute;a del servicio* </b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['servicio_categoria']?>"></i>
                            </p>
                            <p id="item_3"></p>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td>
                            <p>
                                <b>Subcategor&iacute;a del servicio*</b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['servicio_subcategoria']?>"></i>
                            </p>
                            <p id="item_4"></p>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td>
                            <p>
                                <b>Unidad* </b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['servicio_unidad']?>"></i>
                            </p>
                            <p id="item_5"></p>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td>
                            <p>
                                <b>Sujeto obligado contratante*</b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['so_contratante']?>"></i>
                            </p>
                            <p id="item_6"></p>
                        </td>
                    </tr> 
                    <tr class="form-group">
                        <td>
                            <p>
                                <b>Partida de contratante* </b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['presupuesto_concepto']?>"></i>
                            </p>
                            <p id="item_7"></p>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td>
                            <p>
                                <b>Sujeto obligado solicitante*</b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['so_solicitante']?>"></i>
                            </p>
                            <p id="item_8"></p>
                        </td>
                    </tr> 
                    <tr class="form-group">
                        <td>
                            <p>
                                <b>Partida de solicitante* </b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['presupuesto_concepto']?>"></i>
                            </p>
                            <p id="item_9"></p>
                        </td>
                    </tr>    
                    <tr class="form-group">
                        <td>
                            <p>
                                <b>&Aacute;rea administrativa encargada de solicitar el servicio</b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['area_administrativa']?>"></i>
                            </p>
                            <p id="item_10"></p>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td>
                            <p>
                                <b>Descripci&oacute;n del servicio o producto adquirido</b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['descripcion_servicios']?>"></i>
                            </p>
                            <p id="item_11"></p>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td>
                            <p>
                                <b>Cantidad*</b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['cantidad']?>"></i>
                            </p>
                            <p id="item_12"></p>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td>
                            <p>
                                <b>Precio unitario con I.V.A. incluido</b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['precio_unitarios']?>"></i>
                            </p>
                            <p id="item_13"></p>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td>
                            <p>
                                <b>Fecha de validaci&oacute;n </b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_validacion']?>"></i>
                            </p>
                            <p id="item_14"></p>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td>
                            <p>
                                <b>Área responsable de la informaci&oacute;n </b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['area_responsable']?>"></i>
                            </p>
                            <p id="item_15"></p>
                        </td>
                    </tr>      
                    <tr class="form-group">
                        <td>
                            <p>
                                <b>A&ntilde;o </b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['periodo']?>"></i>
                            </p>
                            <p id="item_16"></p>
                        </td>
                    </tr> 
                    <tr class="form-group">
                        <td>
                            <p>
                                <b>Fecha de actualizaci&oacute;n </b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_actualizacion']?>"></i>
                            </p>
                            <p id="item_17"></p>
                        </td>
                    </tr>   
                    <tr class="form-group">
                        <td>
                            <p>
                                <b>Nota </b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['nota']?>"></i>
                            </p>
                            <p id="item_18"></p>
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

<script>
    var init = function(){
        get_subconceptos();
    }

    var get_subconceptos = function(){
        $('#subconceptos').find('tbody').empty();
        $('#subconceptos').find('tbody').append('<tr><td colspan="9" class="text-center">Cargando informaci&oacute;n ...</td></tr>');

        var form_data = new FormData();                  
        form_data.append('id_factura', $('input[name="id_factura"]').val());
        var url = '<?php echo base_url() . 'index.php/tpov1/erogaciones/get_factura_desglose' ?>';

        buscar(url, form_data, set_valores_table, 'subconceptos');
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
                error_datos(container);
            },
            success: function(response){
                if(response && callback){
                    callback(response, container);
                }else{
                    error_datos(container);
                }
            }
        });
    }

    var set_valores_table = function(response, container){
        $('#subconceptos').find('tbody').empty();
        if(Array.isArray(response)){
            response.map(function(e){
                var link = "<button type='button' onClick='abrirModal(" + e.id_factura_desglose + ")'  class='btn btn-default btn-xs' data-toggle='tooltip' title='Detalle'><i class='fa fa-eye'></i></button>";
                
                html = "<tr>" +
                    "<td>"+e.id+"</td>" +
                    "<td>"+e.nombre_campana_aviso+"</td>" +
                    "<td>"+e.nombre_servicio_clasificacion+"</td>" +
                    "<td>"+e.nombre_servicio_categoria+"</td>" +
                    "<td>"+e.monto_desglose_format+"</td>" +
                    "<td width='30'>" + link + "</td>" + 
                    "</tr>"; //definir a donde se va este link

                $('#subconceptos').find('tbody').append(html);
            });
        }
        initDataTable();
    }

    var error_datos =  function(){
        $('#subconceptos').find('tbody').empty();
        $('#subconceptos').find('tbody').append('<tr><td colspan="9">No se encontraron resultados</td></tr>');
    }

    var initDataTable = function(){
        $('#subconceptos').dataTable({
            'bPaginate': true,
            'bLengthChange': true,
            'bFilter': true,
            'bSort': true,
            'bInfo': true,
            'bAutoWidth': false,
            'columnDefs': [ 
                { 'orderable': false, 'targets': 5 } 
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
            },
            'footerCallback': function(row, data, start, end, display){
                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };

                // Total over this page
                pageTotal4 = api
                    .column( 4 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                var colum_4 = '$' + parseFloat(pageTotal4, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString(); 
                
                // Update footer
                $( api.column( 4 ).footer() ).html(
                    colum_4 
                );
            }
        });
    }

    var abrirModal = function(id){
        console.log('si entra');
        $.ajax({
            url: '<?php echo base_url() . 'index.php/tpov1/erogaciones/get_factura_desglose_detalle/' ?>'+id,
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
                    $('#myModal').find('#item_1').html(response.nombre_campana_aviso);
                    $('#myModal').find('#item_2').html(response.nombre_servicio_clasificacion);
                    $('#myModal').find('#item_3').html(response.nombre_servicio_categoria);
                    $('#myModal').find('#item_4').html(response.nombre_servicio_subcategoria);
                    $('#myModal').find('#item_5').html(response.nombre_servicio_unidad);
                    $('#myModal').find('#item_6').html(response.nombre_so_contratante);
                    $('#myModal').find('#item_7').html(response.nombre_presupuesto_concepto);
                    $('#myModal').find('#item_8').html(response.nombre_so_solicitante);
                    $('#myModal').find('#item_9').html(response.nombre_presupuesto_concepto_solicitante);
                    $('#myModal').find('#item_10').html(response.area_administrativa);
                    $('#myModal').find('#item_11').html(response.descripcion_servicios);
                    $('#myModal').find('#item_12').html(response.cantidad);
                    $('#myModal').find('#item_13').html(response.monto_desglose_format);
                    $('#myModal').find('#item_14').html(response.fecha_validacion);
                    $('#myModal').find('#item_15').html(response.area_responsable);
                    $('#myModal').find('#item_16').html(response.periodo);
                    $('#myModal').find('#item_17').html(response.fecha_actualizacion);
                    $('#myModal').find('#item_18').html(response.nota);
                    
                    $('#myModal').modal('show'); 
                }
            }
        });
    }

    var print_btn = function(){
        var url = $('#link_print').val() + $('input[name="id_factura"]').val();
        window.open(url, '_blank', 'location=yes,height=670,width=1020,scrollbars=yes,status=yes');
    }

    var descargar_archivo_table = function(){
        var url_server = $('#link_descarga_table').val();
        $('#descargabtntable').empty();
        $('#descargabtntable').append('<i class="fa fa-refresh fa-spin"></i>&nbsp;&nbsp;Exportando'); 
        $.ajax({
            url: url_server, // point to server-side PHP script 
            dataType: 'JSON',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: '',                         
            type: 'post',
            complete: function(){
                $('#descargabtntable').empty();
                $('#descargabtntable').append('<i class="fa fa-file"></i>&nbsp;&nbsp;Exportar datos'); 
            },
            error:function(){
            },
            success: function(response){
                window.open(response, '_blank');
            }
        });
    }
    
</script>
<?php }else {
    echo 'Informaci&oacute;n no disponible';
}
?>