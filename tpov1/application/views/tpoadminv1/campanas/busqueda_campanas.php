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
    <input type="hidden" id="url" value="<?php echo $serviceSide?>">
    <div class="row">
        <div class="col-xs-12">
            <div class="box table-responsive no-padding">
                <div class="box-header">
                    <div class="pull-left">
                        <?php echo anchor("tpoadminv1/campanas/campanas/alta_campanas_avisos", "<button class='btn btn-success'><i class=\"fa fa-plus-circle\"></i> Agregar</button></td>"); ?> 

                        <br/>
                        <br/>
                        <form role="form" method="post" action="<?php echo base_url(); ?>index.php/tpoadminv1/campanas/campanas/validate_edita_status_campanas_avisos" enctype="multipart/form-data" >

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
                    <table id="campanas" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Tipo <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['tipo']?>"></i></th>
                                <th>Subtipo <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['subtipo']?>"></i></th>
                                <th>Nombre <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['nombre']?>"></i></th>
                                <th>Ejercicio <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['ejercicio']?>"></th>
                                <th>Trimestre <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['trimestre']?>"></i></th>
                                <th>Sujeto Obligado Contratante <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['soc']?>"></i></th>
                                <th>Sujeto Obligado Solicitante <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['sos']?>"></i></th>
                                <th>Estatus <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['active']?>"></i></th>
                                <th> </th>
                                <th> </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            
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
                                <b>Tipo*</b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['tipo']?>"></i>
                            </td>
                            <td class="col-sm-8" id="item_1"></td>
                        </tr>    
                        <tr class="form-group">
                            <td class="control-label col-sm-4">
                                <b>Subtipo* </b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['subtipo']?>"></i>
                            </td>
                            <td class="col-sm-8" id="item_2"></td>
                        </tr>    
                        <tr class="form-group">
                            <td class="control-label col-sm-4">
                                <b>Nombre* </b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['nombre']?>"></i>
                            </td>
                            <td class="col-sm-8" id="item_3"></td>
                        </tr>    
                        <tr class="form-group">
                            <td class="control-label col-sm-4">
                                <b>Clave de campaña o aviso institucional* </b>
                                
                            </td>
                            <td class="col-sm-8" id="item_4"></td>
                        </tr>    
                        <tr class="form-group">
                            <td class="control-label col-sm-4">
                                <b>Autoridad que proporcionó la clave </b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['autoridad']?>"></i>
                            </td>
                            <td class="col-sm-8" id="item_5"></td>
                        </tr>    
                        <tr class="form-group">
                            <td class="control-label col-sm-4">
                                <b>Ejercicio* </b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['ejercicio']?>"></i>
                            </td>
                            <td class="col-sm-8" id="item_6"></td>
                        </tr>    
                        <tr class="form-group">
                            <td class="control-label col-sm-4">
                                <b>Trimestre* </b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['trimestre']?>"></i>
                            </td>
                            <td class="col-sm-8" id="item_7"></td>
                        </tr>
                        <tr class="form-group">
                            <td class="control-label col-sm-4">
                                <b>Sujeto Obligado contratante* </b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['soc']?>"></i>
                            </td>
                            <td class="col-sm-8" id="item_8"></td>
                        </tr>
                        
                        <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Fecha de inicio del periodo que se informa*</b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_inicio_periodo']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_30"></td>
                    </tr>
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Fecha de término del periodo que se informa*</b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_termino_periodo']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_31"></td>
                    </tr>
                        
                        <tr class="form-group">
                            <td class="control-label col-sm-4">
                                <b>Sujeto Obligado solicitante* </b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['sos']?>"></i>
                            </td>
                            <td class="col-sm-8" id="item_9"></td>
                        </tr>
                        <tr class="form-group">
                            <td class="control-label col-sm-4">
                                <b>Tema* </b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['tema']?>"></i>
                            </td>
                            <td class="col-sm-8" id="item_10"></td>
                        </tr>          
                        <tr class="form-group">
                            <td class="control-label col-sm-4">
                                <b>Objetivo institucional* </b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['objetivo_institucional']?>"></i>
                            </td>
                            <td class="col-sm-8" id="item_11"></td>
                        </tr>
                        <tr class="form-group">
                            <td class="control-label col-sm-4">
                                <b>Objetivo de comunicaci&oacute;n* </b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['objetivo_comunicacion']?>"></i>
                            </td>
                            <td class="col-sm-8" id="item_12"></td>
                        </tr>
                        <tr class="form-group">
                            <td class="control-label col-sm-4">
                                <b>Cobertura </b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['cobertura']?>"></i>
                            </td>
                            <td class="col-sm-8" id="item_13"></td>
                        </tr>
                        <tr class="form-group">
                            <td class="control-label col-sm-4">
                                <b>&Aacute;mbito geogr&aacute;fico </b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['ambito_geo']?>"></i>
                            </td>
                            <td class="col-sm-8" id="item_14"></td>
                        </tr>
                        
                        <tr class="form-group">
                            <td class="control-label col-sm-4">
                                <b>Fecha inicio </b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_inicio']?>"></i>
                            </td>
                            <td class="col-sm-8" id="item_15"></td>
                        </tr>
                        
                        <tr class="form-group">
                            <td class="control-label col-sm-4">
                                <b>Fecha t&eacute;rmino </b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_termino']?>"></i>
                            </td>
                            <td class="col-sm-8" id="item_16"></td>
                        </tr>
                        
                        <tr class="form-group">
                            <td class="control-label col-sm-4">
                                <b>Tiempo oficial* </b>
                                
                            </td>
                            <td class="col-sm-8" id="item_17"></td>
                        </tr>
                        
                        <tr class="form-group">
                            <td class="control-label col-sm-4">
                                <b>Monto total del tiempo de estado o tiempo fiscal consumidos</b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['monto_tiempo']?>"></i>
                            </td>
                            <td class="col-sm-8" id="item_34"></td>
                        </tr>
                        
                        <tr class="form-group">
                            <td class="control-label col-sm-4">
                                <b>Tipo de tiempo oficial</b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['tipoTO']?>"></i>
                            </td>
                            <td class="col-sm-8" id="item_32"></td>
                        </tr>
                        
                        <tr class="form-group">
                            <td class="control-label col-sm-4">
                                <b>Mensaje de tiempo oficial</b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['mensajeTO']?>"></i>
                            </td>
                            <td class="col-sm-8" id="item_33"></td>
                        </tr>
                        
                        <tr class="form-group">
                            <td class="control-label col-sm-4">
                                <b>Fecha inicio tiempo oficial </b>                                
                            </td>
                            <td class="col-sm-8" id="item_18"></td>
                        </tr>
                        <tr class="form-group">
                            <td class="control-label col-sm-4">
                                <b>Fecha t&eacute;rmino tiempo oficial</b>                            
                            </td>
                            <td class="col-sm-8" id="item_19"></td>
                        </tr>
                        <tr class="form-group">
                            <td class="control-label col-sm-4">
                                <b>Medio de comunicación</b>
                            </td>
                            <td class="col-sm-8" id="item_35"></td>
                        </tr>
                        <tr class="form-group">
                            <td class="control-label col-sm-4">
                                <b>Descripción de unidad</b>
                            </td>
                            <td class="col-sm-8" id="item_36"></td>
                        </tr>
                        <tr class="form-group">
                            <td class="control-label col-sm-4">
                                <b>Concesionario responsable de publicar la campaña o la comunicación correspondiente (razón social)</b>
                            </td>
                            <td class="col-sm-8" id="item_37"></td>
                        </tr>
                        <tr class="form-group">
                            <td class="control-label col-sm-4">
                                <b>Distintivo y/o nombre comercial del concesionario responsable de publicar la campaña o comunicación</b>
                            </td>
                            <td class="col-sm-8" id="item_38"></td>
                        </tr>
                        <tr class="form-group">
                            <td class="control-label col-sm-4">
                                <b>Descripción breve de las razones que justifican la elección del proveedor</b>
                            </td>
                            <td class="col-sm-8" id="item_39"></td>
                        </tr>
                        <tr class="form-group">
                            <td class="control-label col-sm-4">
                                <b>Área administrativa encargada de solicitar la difusión del mensaje o producto, en su caso</b>
                            </td>
                            <td class="col-sm-8" id="item_40"></td>
                        </tr>
                        <tr class="form-group">
                            <td class="control-label col-sm-4">
                                <b>Número de factura, en su caso</b>
                            </td>
                            <td class="col-sm-8" id="item_41"></td>
                        </tr>
                        
                        <tr class="form-group">
                            <td class="control-label col-sm-4">
                                <b>Publicaci&oacute;n SEGOB.</b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['segob']?>"></i>
                            </td>
                            <td class="col-sm-8" id="item_20"></td>
                        </tr>
                        <tr class="form-group">
                            <td class="control-label col-sm-4">
                                <b>Documento del PACS </b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['pacs']?>"></i>
                            </td>
                            <td class="col-sm-8" id="item_21"></td>
                        </tr>
                        <tr class="form-group">
                            <td class="control-label col-sm-4">
                                <b>Fecha publicaci&oacute;n* </b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_publicacion']?>"></i>
                            </td>
                            <td class="col-sm-8" id="item_22"></td>
                        </tr>

                        <tr class="form-group">
                            <td class="control-label col-sm-4">
                                <b>Evaluaci&oacute;n* </b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['documento']?>"></i>
                            </td>
                            <td class="col-sm-8" id="item_23"></td>
                        </tr>
                        <tr class="form-group">
                            <td class="control-label col-sm-4">
                                <b>Estatus</b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['active']?>"></i>
                            </td>
                            <td class="col-sm-8" id="item_24"></td>
                        </tr>
                        <tr class="form-group">
                            <td class="control-label col-sm-4">
                                <b>Fecha de validaci&oacute;n</b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_validacion']?>"></i>
                            </td>
                            <td class="col-sm-8" id="item_25"></td>
                        </tr>
                        
                        <tr class="form-group">
                            <td class="control-label col-sm-4">
                                <b>&Aacute;rea responsable de la informaci&oacute;n</b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['area_responsable']?>"></i>
                            </td>
                            <td class="col-sm-8" id="item_26"></td>
                        </tr>
                        <tr class="form-group">
                            <td class="control-label col-sm-4">
                                <b>A&ntilde;o</b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['anio']?>"></i>
                            </td>
                            <td class="col-sm-8" id="item_27"></td>
                        </tr>
                        <tr class="form-group">
                            <td class="control-label col-sm-4">
                                <b>Fecha de actualizaci&oacute;n </b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_actualizacion']?>"></i>
                            </td>
                            <td class="col-sm-8" id="item_28"></td>
                        </tr>
                        <tr class="form-group">
                            <td class="control-label col-sm-4">
                                <b>Nota</b>
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['nota']?>"></i>
                            </td>
                            <td class="col-sm-8" id="item_29"></td>
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
    
    var eliminarModal = function(id){

        //Hacemos una consulta por ajax para obtener el nombre de la campana/aviso a eliminar
        $.ajax({
            //url: '<?php echo base_url() . 'index.php/tpoadminv1/capturista/facturas/get_factura/' ?>'+id,
            url: '<?php echo base_url() . 'index.php/tpoadminv1/campanas/campanas/obten_campana_nombre/' ?>'+id,
            data: {action: 'test'},
            dataType:'JSON',
            
            success: function (response) {
                //alert(response);

                if(response){
                    
                    var html_btns = '<button type="button" class="btn btn-danger" onclick="eliminar('+id+')">Si</button>' +
                   '<button type="button" class="btn btn-default" data-dismiss="modal">No</button>';
                    $('#myModalDelete').find('#footer_btns').html(html_btns);
                    $('#myModalDelete').find('#mensaje_modal').html('¿Desea eliminar la campaña/aviso institucional <b>' + response+ '</b>?');
                    $('#myModalDelete').modal('show');

                }
            }
        });
    }

    var eliminar = function (id){
        window.location.href = "eliminar_campana_aviso/" + id;
    }

    var abrirModal = function(id){

        $.ajax({
            //url: '<?php echo base_url() . 'index.php/tpoadminv1/capturista/facturas/get_factura/' ?>'+id,
            url: '<?php echo base_url() . 'index.php/tpoadminv1/campanas/campanas/obten_campana_info/' ?>'+id,
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
                    
                    $('#myModal').find('#item_1').html(response.nombre_campana_tipo);
                    $('#myModal').find('#item_2').html(response.nombre_campana_subtipo);
                    $('#myModal').find('#item_3').html(response.nombre_campana_aviso);
                    $('#myModal').find('#item_4').html(response.clave_campana);
                    $('#myModal').find('#item_5').html(response.autoridad);
                    $('#myModal').find('#item_6').html(response.nombre_ejercicio);
                    $('#myModal').find('#item_7').html(response.nombre_trimestre);
                    $('#myModal').find('#item_30').html(response.fecha_inicio_periodo);
                    $('#myModal').find('#item_31').html(response.fecha_termino_periodo);
                    $('#myModal').find('#item_8').html(response.nombre_so_contratante);
                    $('#myModal').find('#item_9').html(response.nombre_so_solicitante);
                    $('#myModal').find('#item_10').html(response.nombre_tema);
                    $('#myModal').find('#item_11').html(response.objetivo_institucional);
                    $('#myModal').find('#item_12').html(response.objetivo_comunicacion);
                    $('#myModal').find('#item_13').html(response.nombre_cobertura);
                    $('#myModal').find('#item_14').html(response.campana_ambito_geo);
                    $('#myModal').find('#item_15').html(response.fecha_inicio);
                    $('#myModal').find('#item_16').html(response.fecha_termino);
                    $('#myModal').find('#item_17').html(response.nombre_tiempo_oficial);
                    $('#myModal').find('#item_34').html(response.monto_tiempo);
                    $('#myModal').find('#item_32').html(response.nombre_tipoTO);
                    $('#myModal').find('#item_33').html(response.mensajeTO);
                    $('#myModal').find('#item_18').html(response.fecha_inicio_to);
                    $('#myModal').find('#item_19').html(response.fecha_termino_to);
                    $('#myModal').find('#item_35').html(response.nombre_servicio_categoria);
                    $('#myModal').find('#item_36').html(response.descripcion_unidad);
                    $('#myModal').find('#item_37').html(response.responsable_publisher);
                    $('#myModal').find('#item_38').html(response.name_comercial);
                    $('#myModal').find('#item_39').html(response.razones_supplier);
                    $('#myModal').find('#item_40').html(response.difusion_mensaje);
                    $('#myModal').find('#item_41').html(response.num_factura);
                    $('#myModal').find('#item_20').html(response.publicacion_segob);
                    $('#myModal').find('#item_21').html(response.denominacion);
                    $('#myModal').find('#item_22').html(response.fecha_dof);
                    $('#myModal').find('#item_23').html(response.evaluacion);
                    $('#myModal').find('#item_24').html(response.active_nombre);
                    $('#myModal').find('#item_25').html(response.fecha_validacion);
                    $('#myModal').find('#item_26').html(response.area_responsable);
                    $('#myModal').find('#item_27').html(response.periodo);
                    $('#myModal').find('#item_28').html(response.fecha_actualizacion);
                    $('#myModal').find('#item_29').html(response.nota);
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
        $('#campanas').find('tbody').empty();
        initDataTable();
    }
	
    var set_valores_tabla = function(response, container){
        $('#campanas').find('tbody').empty();
        if(Array.isArray(response)){
            response.map(function(e){
                
                var html = '<tr>' +
                        //'<td>' + e.id_campana_aviso + '</td>' +
                        '<td>' + e.nombre_campana_tipo + '</td>' +
                        '<td>' + e.nombre_campana_subtipo + '</td>' +
                        '<td>' + e.nombre_campana_aviso + '</td>' +
                        '<td>' + e.nombre_ejercicio + '</td>' +
                        '<td>' + e.nombre_trimestre + '</td>' +
                        '<td>' + e.nombre_so_contratante + '</td>' +
                        '<td>' + e.nombre_so_solicitante+ '</td>' +
                        '<td>' + e.active + '</td>' +
                        '<td> <span class="btn-group btn btn-info btn-sm" onclick="abrirModal(' + e.id_campana_aviso + ')"> <i class="fa fa-search"></i></span></td>' +
                        '<td><form action="edita_campanas_avisos" method="post"><input type="hidden" name="id_campana_aviso" value="'+ e.id_campana_aviso +'" /><button class="btn-group btn btn-warning btn-sm" title="Editar"><i class="fa fa-edit"></i></button></form></td>'+
                        '<td> <span class="btn-group btn btn-danger btn-sm" onclick="eliminarModal('+ e.id_campana_aviso+')"> <i class="fa fa-close"></i></span></td>' +
                        '</tr>';
                $('#campanas').find('tbody').append(html);
            });
        } 
        initDataTable();
    }

    var initDataTable = function(){        
        $('#campanas').dataTable({
            'bPaginate': true,
            'bLengthChange': true,
            'bFilter': true,
            'bSort': true,
            'bInfo': true,
            'bAutoWidth': false,
            'columnDefs': [ 
                { 'orderable': false, 'targets': [8,9,10] } 
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
            url: '<?php echo base_url() . 'index.php/tpoadminv1/campanas/campanas/preparar_exportacion_campanas/' ?>',
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
        $('#campanas').find('tbody').empty();
        $('#campanas').find('tbody').append('<tr><td colspan="13" class="text-center"><i class="fa fa-refresh fa-spin"></i> Cargando...</td></tr>');
        buscar(url, null, set_valores_tabla, 'campanas');

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
