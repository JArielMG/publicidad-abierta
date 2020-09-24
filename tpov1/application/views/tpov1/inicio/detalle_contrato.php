<?php 
    $link_file = '';
    if($disponible == true && !empty($contrato['name_file_contrato'])){
        $link_file = "<a href='" . $contrato['path_file_contrato'] . "' download>" . $contrato['name_file_contrato'] . "</a>";
    }
?>
<?php

if($disponible == true){ /* se muestra la info*/ 
?> 
<style>
    #info_contratos td{
        padding: 2px !important;
        font-size: 12px;
    }
</style>
<input name="id_contrato" type="hidden" value="<?php echo $contrato['id_contrato'] ?>">
<div class="row">
    <div class="box box-info box-solid">
        <div class="box-header header">
            <h3 class="box-title">Informaci&oacute;n del contrato</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        </div> <!-- / .box-header-->
        <div class="box-body with-border">
            <table id="info_contratos" class="table table-striped">
                <tbody>
                    <tr>
                        <td class="text-right">Ejercicio <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['ejercicio']?>"></i>: </td>
                        <td width="80%"><?php echo $contrato['ejercicio']?></td>
                    </tr>
                    <tr>
                        <td class="text-right">Trimestre <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['trimestre']?>"></i>: </td>
                        <td width="80%"><?php echo $contrato['trimestre']?></td>
                    </tr>
                    <tr>
                        <td class="text-right">N&uacute;mero contrato <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['numero_contrato']?>"></i>: </td>
                        <td width="80%"><?php echo $contrato['numero_contrato']?></td>
                    </tr>
                    <tr>
                        <td class="text-right">Sujeto obligado contratante <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['so_contratante']?>"></i>: </td>
                        <td width="80%"><?php echo $contrato['nombre_so_contratante'] . @$link_so_contratante ?></td>
                    </tr>
                    <tr>
                        <td class="text-right">Sujeto obligado solicitante <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['so_solicitante']?>"></i>: </td>
                        <td width="80%"><?php echo $contrato['nombre_so_solicitante'] . @$link_so_solicitante ?></td>
                    </tr>
                    <tr>
                        <td class="text-right">Proveedor <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['proveedor']?>"></i>: </td>
                        <td width="80%"><?php echo $contrato['nombre_proveedor'] . @$link_proveedor?></td>
                    </tr>
                    <tr>
                        <td class="text-right">Nombre comercial del proveedor <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['nombre_comercial_proveedor']?>"></i>: </td>
                        <td width="80%"><?php echo $contrato['nombre_comercial_proveedor']?></td>
                    </tr>
                    <tr>
                        <td class="text-right">Fecha celebraci&oacute;n <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_celebracion']?>"></i>: </td>
                        <td width="80%"><?php echo $contrato['fecha_celebracion']?></td>
                    </tr>
                    <tr>
                        <td class="text-right">Objeto <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['objeto_contrato']?>"></i>: </td>
                        <td width="80%"><?php echo $contrato['objeto_contrato']?></td>
                    </tr>
                    <tr>
                        <td class="text-right">Tipo de adjudicaci&oacute;n <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['nombre_procedimiento']?>"></i>: </td>
                        <td width="80%"><?php echo $contrato['nombre_procedimiento']?></td>
                    </tr>
                    <tr>
                        <td class="text-right">Motivo de adjudicacion <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['descripcion_justificacion']?>"></i>: </td>
                        <td width="80%"><?php echo $contrato['descripcion_justificacion']?></td>
                    </tr>
                    <tr>
                        <td class="text-right">Fundamento jur&iacute;dico <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fundamento_juridico']?>"></i>: </td>
                        <td width="80%"><?php echo $contrato['fundamento_juridico']?></td>
                    </tr>
                    <tr>
                        <td class="text-right">Monto del contrato <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['monto_contrato']?>"></i>: </td>
                        <td width="80%"><?php echo $contrato['monto_contrato_formato']?></td>
                    </tr>
                    <tr>
                        <td class="text-right">Monto total <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['monto_total']?>"></i>: </td>
                        <td width="80%"><?php echo $contrato['monto_total']?></td>
                    </tr>
                    <tr>
                        <td class="text-right">Monto modificado <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['monto_modificado']?>"></i>: </td>
                        <td width="80%"><?php echo $contrato['monto_modificado']?></td>
                    </tr>
                    <tr>
                        <td class="text-right">Monto pagado <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['monto_pagado']?>"></i>: </td>
                        <td width="80%"><?php echo $contrato['monto_pagado']?></td>
                    </tr>
                    <tr>
                        <td class="text-right">Fecha de inicio <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_inicio']?>"></i>: </td>
                        <td width="80%"><?php echo $contrato['fecha_inicio']?></td>
                    </tr>
                    <tr>
                        <td class="text-right">Fecha de fin <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_fin']?>"></i>: </td>
                        <td width="80%"><?php echo $contrato['fecha_fin']?></td>
                    </tr>
                    <tr>
                        <td class="text-right">Hipervínculo al contrato firmado <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['url_contrato']?>"></i>: </td>
                        <td width="80%"> <a href="<?php echo $contrato['url_contrato']?>" target="_blank"><?php echo $contrato['url_contrato']?></a> </td>
                    </tr>
                    <tr>
                        <td class="text-right">Vinculo al archivo del contrato <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['file_contrato']?>"></i>: </td>
                        <td width="80%"><?php echo $link_file?></td>
                    </tr>
                    <tr>
                        <td class="text-right">Fecha de validaci&oacute;n <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_validacion']?>"></i>: </td>
                        <td width="80%"><?php echo $contrato['fecha_validacion']?></td>
                    </tr>
                    <tr>
                        <td class="text-right">&Aacute;rea responsable de la informaci&oacute;n <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['area_responsable']?>"></i>: </td>
                        <td width="80%"><?php echo $contrato['area_responsable']?></td>
                    </tr>
                    <tr>
                        <td class="text-right">A&ntilde;o <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['periodo']?>"></i>: </td>
                        <td width="80%"><?php echo $contrato['periodo']?></td>
                    </tr>
                    <tr>
                        <td class="text-right">Fecha de actualizaci&oacute;n <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_actualizacion']?>"></i>: </td>
                        <td width="80%"><?php echo $contrato['fecha_actualizacion']?></td>
                    </tr>
                    <tr>
                        <td class="text-right">Nota <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['nota']?>"></i>: </td>
                        <td width="80%"><?php echo $contrato['nota']?></td>
                    </tr>
                </tbody>
            </table>
        </div> <!-- / .box-body-->
    </div> <!-- / .box-->
</div>

<div class="row"> <!-- convenios modificatorios-->
    <div class="box box-default">
        <div class="box-header header">
            <h3 class="box-title">Convenios modificatorios asociados al contrato</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        </div> <!-- / .box-header-->
        <div class="box-body with-border table-responsive">
            <div id="options_convenios" class="row" style="margin-bottom:5px; margin-right:0px;">
                <div class="pull-right">
                    <a class="btn btn-default" onclick="print_btn_convenios()"><i class="fa fa-print"></i> Imprimir</a>
                    <a id="descargabtntableconvenios" class="btn btn-default" onclick="descargar_archivo_table_convenios()"><i class="fa fa-file"></i> Exportar datos</a>
                    <input type="hidden" id="link_descarga_table_convenios" value="<?php echo $link_descarga_table_convenios; ?>"/>
                    <input type="hidden" id="link_print_convenios" value="<?php echo $print_url_convenios; ?>"/>
                </div> 
            </div>
            <div class="table-responsive-md">
                <table id="convenios" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Ejercicio  <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['ejercicio']?>"></i></th>
                            <th>Trimestre <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['trimestre']?>"></i></th>
                            <th>Convenio modificatorio <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['numero_convenio']?>"></i></th>
                            <th>Monto <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['monto_convenio']?>"></i></th>            
                            
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
                        </tr>
                    </tfoot>
                </table>
            </div> <!-- /. table-responsive -->
        </div> <!-- / .box-body-->
    </div> <!-- / .box-->
</div>

<div class="row"> <!-- Ordenes de compra-->
    <div class="box box-info">
        <div class="box-header header">
            <h3 class="box-title">&Oacute;rdenes de compra asociadas al contrato</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        </div> <!-- / .box-header-->
        <div class="box-body with-border table-responsive">
            <div id="options_ordenes" class="row" style="margin-bottom:5px; margin-right:0px;">
                <div class="pull-right">
                    <a class="btn btn-default" onclick="print_btn_ordenes()"><i class="fa fa-print"></i> Imprimir</a>
                    <a id="descargabtntableordenes" class="btn btn-default" onclick="descargar_archivo_table_ordenes()"><i class="fa fa-file"></i> Exportar datos</a>
                    <input type="hidden" id="link_descarga_table_ordenes" value="<?php echo $link_descarga_table_ordenes; ?>"/>
                    <input type="hidden" id="link_print_ordenes" value="<?php echo $print_url_ordenes; ?>"/>
                </div> 
            </div>
            <div class="table-responsive-md">
                <table id="ordenes" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Ejercicio  <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['ejercicio']?>"></i></th>
                            <th>Trimestre <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['trimestre']?>"></i></th>
                            <th>Orden de compra <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['orden_compra']?>"></i></th>
                            <th>Fecha <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_orden_compra']?>"></i></th>
                            <th>Solicitante <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['so_solicitante']?>"></i></th>
                            <th>Campa&ntilde;a o aviso <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['campana_aviso']?>"></i></th>
                            <th>Monto <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['monto_orden_compra']?>"></i></th>            
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

<div class="row"> <!-- Servicios de información-->
    <div class="box box-default">
        <div class="box-header header">
            <h3 class="box-title">Servicios de difusi&oacute;n en medios de comunicaci&oacute;n relacionados con el contrato</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        </div> <!-- / .box-header-->
        <div class="box-body with-border table-responsive">
            <div id="options_servicio" class="row" style="margin-bottom:5px; margin-right:0px;">
                <div class="pull-right">
                    <a class="btn btn-default" onclick="print_btn_servicio()"><i class="fa fa-print"></i> Imprimir</a>
                    <a id="descargabtntableservicio" class="btn btn-default" onclick="descargar_archivo_table_servicio()"><i class="fa fa-file"></i> Exportar datos</a>
                    <input type="hidden" id="link_descarga_table_servicio" value="<?php echo $link_descarga_table_servicio; ?>"/>
                    <input type="hidden" id="link_print_servicio" value="<?php echo $print_url_servicio; ?>"/>
                </div> 
            </div>
            <div class="table-responsive-md">
                <table id="servicios" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Ejercicio  <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['ejercicio']?>"></i></th>
                            <th>Factura <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['numero_factura']?>"></i></th>
                            <th>Fecha <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_erogacion']?>"></i></th>
                            <th>Proveedor <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['proveedor']?>"></i></th>
                            <th>Categor&iacute;a <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['categoria']?>"></i></th>
                            <th>Subcategor&iacute;a <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['subcategoria']?>"></i></th>
                            <th>Tipo </th>
                            <th>Campa&ntilde;a o aviso <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['campana_aviso']?>"></i></th>
                            <th>Monto gastado <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['monto_gastado']?>"></i></th>            
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

<div class="row"> <!-- Otros medios de información-->
    <div class="box box-info">
        <div class="box-header header">
            <h3 class="box-title">Otros servicios asociados a la comunicaci&oacute;n relacionados con el contrato</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        </div> <!-- / .box-header-->
        <div class="box-body with-border table-responsive">
            <div id="options_otros" class="row" style="margin-bottom:5px; margin-right:0px;">
                <div class="pull-right">
                    <a class="btn btn-default" onclick="print_btn_otros()"><i class="fa fa-print"></i> Imprimir</a>
                    <a id="descargabtntableotros" class="btn btn-default" onclick="descargar_archivo_table_otros()"><i class="fa fa-file"></i> Exportar datos</a>
                    <input type="hidden" id="link_descarga_table_otros" value="<?php echo $link_descarga_table_otros; ?>"/>
                    <input type="hidden" id="link_print_otros" value="<?php echo $print_url_otros; ?>"/>
                </div> 
            </div>
            <div class="table-responsive-md">
                <table id="otros" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Ejercicio  <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['ejercicio']?>"></i></th>
                            <th>Factura <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['numero_factura']?>"></i></th>
                            <th>Fecha <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_erogacion']?>"></i></th>
                            <th>Proveedor <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['proveedor']?>"></i></th>
                            <th>Categor&iacute;a <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['categoria']?>"></i></th>
                            <th>Subcategor&iacute;a <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['subcategoria']?>"></i></th>
                            <th>Tipo </th>
                            <th>Campa&ntilde;a o aviso <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['campana_aviso']?>"></i></th>
                            <th>Monto gastado <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['monto_gastado']?>"></i></th>            
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

<script>

    var init = function(){
        get_convenios();
        get_ordenes_compra();
        get_servicios();
        get_servicios_otros();
    }

    var get_servicios = function(){

        $('#servicios').find('tbody').empty();
        $('#servicios').find('tbody').append('<tr><td colspan="9" class="text-center">Cargando informaci&oacute;n ...</td></tr>');

        var form_data = new FormData();                  
        form_data.append('id_contrato', $('input[name="id_contrato"]').val());
        var url = '<?php echo base_url() . 'index.php/tpov1/contratos_ordenes/get_servicio_contrato' ?>';

        buscar(url, form_data, set_valores_table, 'servicios');
    }

    var get_servicios_otros = function(){

        $('#otros').find('tbody').empty();
        $('#otros').find('tbody').append('<tr><td colspan="9" class="text-center">Cargando informaci&oacute;n ...</td></tr>');

        var form_data = new FormData();                  
        form_data.append('id_contrato', $('input[name="id_contrato"]').val());
        var url = '<?php echo base_url() . 'index.php/tpov1/contratos_ordenes/get_servicio_otros_contrato' ?>';

        buscar(url, form_data, set_valores_table, 'otros');
    }

    var get_ordenes_compra = function(){

        $('#ordenes').find('tbody').empty();
        $('#ordenes').find('tbody').append('<tr><td colspan="9" class="text-center">Cargando informaci&oacute;n ...</td></tr>');

        var form_data = new FormData();                  
        form_data.append('id_contrato', $('input[name="id_contrato"]').val());
        var url = '<?php echo base_url() . 'index.php/tpov1/contratos_ordenes/get_ordenes_compra_contrato' ?>';

        buscar(url, form_data, set_valores_table, 'ordenes');
    }

    var get_convenios = function(){
        $('#convenios').find('tbody').empty();

        $('#convenios').find('tbody').append('<tr><td colspan="6" class="text-center">Cargando informaci&oacute;n ...</td></tr>');

        var form_data = new FormData();                  
        form_data.append('id_contrato', $('input[name="id_contrato"]').val());
        var url = '<?php echo base_url() . 'index.php/tpov1/contratos_ordenes/get_convenios_modificatorios' ?>';

        buscar(url, form_data, set_valores_table, 'convenios');
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

    var error_datos =  function(container){
        var tag = '#' + container;
        var num = get_numero_columnas(container);
        $(tag).find('tbody').empty();
        var no_filter = [num - 1];
        initDataTable(tag, no_filter);
        
    }

    var set_valores_table = function(response, container){
        var tag = '#' + container;
        $(tag).find('tbody').empty();
        if(Array.isArray(response)){
            response.map(function (e){
                var html = get_row_table(container, e);
                $(tag).find('tbody').append(html);
            });
        }

        var num = get_numero_columnas(container);
        var no_filter = [num - 1];
        initDataTable(tag, no_filter);
    }

    var get_row_table = function(container, e){
        var html = '<tr></tr>';
        switch(container){ 
            case 'convenios':
                html = "<tr>" +
                    "<td>"+e.id+"</td>" +
                    "<td>"+e.ejercicio+"</td>" +
                    "<td>"+e.trimestre+"</td>" +
                    "<td>"+e.numero_convenio+"</td>" +
                    "<td>"+e.monto_convenio_formato+"</td>" +
                    //"<td><a href='" + e.id_convenio_modificatorio + "' class='btn btn-default btn-xs' data-toggle='tooltip' title='Detalle'><i class='fa fa-link'></i></a></td>" + 
                    "</tr>"; 
                break;
            case 'ordenes':
                html = "<tr>" +
                    "<td>"+e.id+"</td>" +
                    "<td>"+e.ejercicio+"</td>" +
                    "<td>"+e.trimestre+"</td>" +
                    "<td>"+e.numero_orden_compra+"</td>" +
                    "<td>"+e.fecha_orden+"</td>" +
                    "<td>"+e.nombre_so_solicitante+"</td>" +
                    "<td>"+e.campana_aviso+"</td>" +
                    "<td>"+e.monto+"</td>" +
                    "<td><a href='" + e.link_detalle + "' class='btn btn-default btn-xs' data-toggle='tooltip' title='Detalle' target='_blank'><i class='fa fa-link'></i></a></td>" + 
                    "</tr>"; //definir a donde se va este link
                break;
            case 'servicios':
            case 'otros':
                var link1 = "<a href='" + e.link_factura + "' class='btn btn-default btn-xs' data-toggle='tooltip' title='Detalle Factura' target='_blank'><i class='fa fa-link'></i></a>";
                var link2 = "&nbsp;<a href='" + e.link_proveedor + "' class='btn btn-default btn-xs' data-toggle='tooltip' title='Detalle Proveedor' target='_blank'><i class='fa fa-link'></i></a>";
                var link3 = "&nbsp;<a href='" + e.link_campana + "' class='btn btn-default btn-xs' data-toggle='tooltip' title='Detalle Campa&ntilde;a o aviso institucional' target='_blank'><i class='fa fa-link'></i></a>";
                html = "<tr>" +
                    "<td>"+e.id+"</td>" +
                    "<td>"+e.ejercicio+"</td>" +
                    "<td>"+e.factura+"</td>" +
                    "<td>"+e.fecha_erogacion+"</td>" +
                    "<td>"+e.proveedor+"</td>" +
                    "<td>"+e.nombre_servicio_categoria+"</td>" +
                    "<td>"+e.nombre_servicio_subcategoria+"</td>" +
                    "<td>"+e.tipo+"</td>" +
                    "<td>"+e.nombre_campana_aviso+"</td>" +
                    "<td>"+e.monto_servicio+"</td>" +
                    "<td width='80'>" + link1 + link2 + link3 + "</td>" + 
                    "</tr>"; //definir a donde se va este link
                break;
        }

        return html;
    }

    var get_numero_columnas = function(container){
        var num = 0;
        switch(container){ //obtiene numero de columnas
            case 'convenios':
                num = 5; 
                break;
            case 'ordenes':
                num = 9;
                break;
            case 'servicios':
            case 'otros':
                num = 11;
                break;
        }

        return num;
    }

    var initDataTable = function(container, no_filter){
        $(container).dataTable({
            'bPaginate': true,
            'bLengthChange': true,
            'bFilter': true,
            'bSort': true,
            'bInfo': true,
            'bAutoWidth': false,
            'columnDefs': [ 
                { 'orderable': false, 'targets': no_filter } 
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

                if(container == '#convenios'){
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

                if(container == '#ordenes'){
                    // Total over this page
                    pageTotal7 = api
                        .column( 7 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    var colum_7 = '$' + parseFloat(pageTotal7, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString(); 
                    
                    // Update footer
                    $( api.column( 7 ).footer() ).html(
                        colum_7 
                    );
                }

                if(container == '#servicios'){
                    // Total over this page
                    pageTotal9 = api
                        .column( 9 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    var colum_9 = '$' + parseFloat(pageTotal9, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString(); 
                    
                    // Update footer
                    $( api.column( 9 ).footer() ).html(
                        colum_9 
                    );
                }

                if(container == '#otros'){
                    // Total over this page
                    pageTotal9 = api
                        .column( 9 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    var colum_9 = '$' + parseFloat(pageTotal9, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString(); 
                    
                    // Update footer
                    $( api.column( 9 ).footer() ).html(
                        colum_9 
                    );
                }
            }
        });
    }

    var print_btn_servicio = function(){
        var url = $('#link_print_servicio').val() + $('input[name="id_contrato"]').val();
        window.open(url, '_blank', 'location=yes,height=670,width=1020,scrollbars=yes,status=yes');
    }

    var descargar_archivo_table_servicio = function(){
        var url_server = $('#link_descarga_table_servicio').val();
        $('#descargabtntableservicio').empty();
        $('#descargabtntableservicio').append('<i class="fa fa-refresh fa-spin"></i>&nbsp;&nbsp;Exportando'); 
        $.ajax({
            url: url_server, // point to server-side PHP script 
            dataType: 'JSON',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: '',                         
            type: 'post',
            complete: function(){
                $('#descargabtntableservicio').empty();
                $('#descargabtntableservicio').append('<i class="fa fa-file"></i>&nbsp;&nbsp;Exportar datos'); 
            },
            error:function(){
            },
            success: function(response){
                window.open(response, '_blank');
            }
        });
    }

    var print_btn_otros = function(){
        var url = $('#link_print_otros').val() + $('input[name="id_contrato"]').val();
        window.open(url, '_blank', 'location=yes,height=670,width=1020,scrollbars=yes,status=yes');
    }

    var descargar_archivo_table_otros = function(){
        var url_server = $('#link_descarga_table_otros').val();
        $('#descargabtntableotros').empty();
        $('#descargabtntableotros').append('<i class="fa fa-refresh fa-spin"></i>&nbsp;&nbsp;Exportando'); 
        $.ajax({
            url: url_server, // point to server-side PHP script 
            dataType: 'JSON',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: '',                         
            type: 'post',
            complete: function(){
                $('#descargabtntableotros').empty();
                $('#descargabtntableotros').append('<i class="fa fa-file"></i>&nbsp;&nbsp;Exportar datos'); 
            },
            error:function(){
            },
            success: function(response){
                window.open(response, '_blank');
            }
        });
    }

    var print_btn_convenios = function(){
        var url = $('#link_print_convenios').val() + $('input[name="id_contrato"]').val();
        window.open(url, '_blank', 'location=yes,height=670,width=1020,scrollbars=yes,status=yes');
    }

    var descargar_archivo_table_convenios = function(){
        var url_server = $('#link_descarga_table_convenios').val();
        $('#descargabtntableconvenios').empty();
        $('#descargabtntableconvenios').append('<i class="fa fa-refresh fa-spin"></i>&nbsp;&nbsp;Exportando'); 
        $.ajax({
            url: url_server, // point to server-side PHP script 
            dataType: 'JSON',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: '',                         
            type: 'post',
            complete: function(){
                $('#descargabtntableconvenios').empty();
                $('#descargabtntableconvenios').append('<i class="fa fa-file"></i>&nbsp;&nbsp;Exportar datos'); 
            },
            error:function(){
            },
            success: function(response){
                window.open(response, '_blank');
            }
        });
    }

    var print_btn_ordenes = function(){
        var url = $('#link_print_ordenes').val() + $('input[name="id_contrato"]').val();
        window.open(url, '_blank', 'location=yes,height=670,width=1020,scrollbars=yes,status=yes');
    }

    var descargar_archivo_table_ordenes = function(){
        var url_server = $('#link_descarga_table_ordenes').val();
        $('#descargabtntableordenes').empty();
        $('#descargabtntableordenes').append('<i class="fa fa-refresh fa-spin"></i>&nbsp;&nbsp;Exportando'); 
        $.ajax({
            url: url_server, // point to server-side PHP script 
            dataType: 'JSON',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: '',                         
            type: 'post',
            complete: function(){
                $('#descargabtntableordenes').empty();
                $('#descargabtntableordenes').append('<i class="fa fa-file"></i>&nbsp;&nbsp;Exportar datos'); 
            },
            error:function(){
            },
            success: function(response){
                window.open(response, '_blank');
            }
        });
    }

</script>

<?php 
}else{
    echo 'Información no disponible';
}
?>