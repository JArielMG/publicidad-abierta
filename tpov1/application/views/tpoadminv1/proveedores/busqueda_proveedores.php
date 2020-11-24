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
    <div class="row">
        <div class="col-xs-12">
            <div class="box table-responsive">
                <div class="box-header">
                    <div class="pull-left">
                        <?php echo anchor("tpoadminv1/capturista/proveedores/agregar_proveedor", "<button class='btn btn-success'><i class=\"fa fa-plus-circle\"></i> Agregar</button></td>"); ?>
                        <br/>
                        <br/>
                        <form role="form" method="post" autocomplete="off" action="<?php echo base_url(); ?>index.php/tpoadminv1/capturista/proveedores/validate_editar_status_proveedor" enctype="multipart/form-data" >

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
                        <a id="descargabtn" class="btn btn-default" onclick="descargar_archivo()"><i class="fa fa-file"></i> Exportar a Excel</a>
                        <input type="hidden" id="link_descarga" value="<?php echo $link_descarga; ?>"/>
                    </div>
                </div><!-- /.box-header -->
                
                <div class="box-body">
                    <table id="proveedores" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Personalidad jur&iacute;dica  <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_personalidad_juridica']?>"></i></th>
                                <th>Nombre o raz&oacute;n social <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['nombre_razon_social']?>"></i></th>
                                <th>Nombre comercial <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['nombre_comercial']?>"></i></th>
                                <th>R.F.C <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['rfc']?>"></i></th>
                                <th>Estatus <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['active']?>"></i></th>
                                <th style="width: 10px;"></th>
                                <th style="width: 10px;"></th>
                                <th style="width: 10px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $c_replace = array('\'', '"');
                                for($z = 0; $z < sizeof($registros); $z++)
                                {
                                    echo '<tr>';
                                    echo '<td>' . $registros[$z]['id'] . '</td>';
                                    echo '<td>' . $registros[$z]['nombre_personalidad_juridica'] . '</td>';
                                    echo '<td>' . $registros[$z]['nombre_razon_social'] . '</td>';
                                    echo '<td>' . $registros[$z]['nombre_comercial'] . '</td>';
                                    echo '<td>' . $registros[$z]['rfc'] . '</td>';
                                    echo '<td>' . $registros[$z]['active'] . '</td>';
                                    echo "<td> <span class='btn-group btn btn-info btn-sm' onclick=\"abrirModal(" . $registros[$z]['id_proveedor'] . ")\"> <i class='fa fa-search'></i></span></td>";
                                    echo '<td>' . anchor("tpoadminv1/capturista/proveedores/editar_proveedor/".$registros[$z]['id_proveedor'], "<button class='btn btn-warning btn-sm' title='Editar'><i class=\"fa fa-edit\"></i></button></td>"); 
                                    echo "<td> <span class='btn-group btn btn-danger btn-sm' onclick=\"eliminarModal(" . $registros[$z]['id_proveedor'] . ", '". str_replace($c_replace, "", $registros[$z]['nombre_razon_social']) . "')\"> <i class='fa fa-close'></i></span></td>";
                                    
									
                                    echo '</tr>';
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
                            <b>Personalidad jur&iacute;dica*</b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['id_personalidad_juridica']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_1"></td>
                    </tr>    
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Nombre o raz&oacute;n social* </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['nombre_razon_social']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_2"></td>
                    </tr>    
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Nombre comercial* </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['nombre_comercial']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_3"></td>
                    </tr>    
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>R.F.C.* </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['rfc']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_4"></td>
                    </tr>    
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Primer Apellido </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['primer_apellido']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_5"></td>
                    </tr>    
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Segundo Apellido </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['segundo_apellido']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_6"></td>
                    </tr>    
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Nombres </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['nombres']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_7"></td>
                    </tr>
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Descripci&oacute;n de sus servicios </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['descripcion_servicios']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_12"></td>
                    </tr>
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Fecha de validaci&oacute;n </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_validacion']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_8"></td>
                    </tr>   
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Área responsable de la informaci&oacute;n </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['area_responsable']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_9"></td>
                    </tr>      
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>A&ntilde;o </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['periodo']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_10"></td>
                    </tr> 
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Fecha de actualizaci&oacute;n </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_actualizacion']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_11"></td>
                    </tr>
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Nota </b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['nota']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_13"></td>
                    </tr>                     
                    <tr class="form-group">
                        <td class="control-label col-sm-4">
                            <b>Estatus*</b>
                            <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['active']?>"></i>
                        </td>
                        <td class="col-sm-8" id="item_14">
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


<script type="text/javascript">
    
    var eliminarModal = function(id, name){
        var html_btns = '<button type="button" class="btn btn-danger" onclick="eliminar('+id+')">Si</button>' +
                   '<button type="button" class="btn btn-default" data-dismiss="modal">No</button>';
        $('#myModalDelete').find('#footer_btns').html(html_btns);
        $('#myModalDelete').find('#mensaje_modal').html('¿Desea eliminar el proveedor <b>' + name+ '</b>?');
        $('#myModalDelete').modal('show');
    }

    var eliminar = function (id){
        window.location.href = "eliminar_proveedor/" + id;
    }

    var abrirModal = function(id){

        $.ajax({
            url: '<?php echo base_url() . 'index.php/tpoadminv1/capturista/proveedores/get_proveedor/' ?>'+id,
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
                    $('#myModal').find('#item_1').html(response.nombre_personalidad_juridica);
                    $('#myModal').find('#item_2').html(response.nombre_razon_social);
                    $('#myModal').find('#item_3').html(response.nombre_comercial);
                    $('#myModal').find('#item_4').html(response.rfc);
                    $('#myModal').find('#item_5').html(response.primer_apellido);
                    $('#myModal').find('#item_6').html(response.segundo_apellido);
                    $('#myModal').find('#item_7').html(response.nombres);
                    $('#myModal').find('#item_8').html(response.fecha_validacion);
                    $('#myModal').find('#item_9').html(response.area_responsable);
                    $('#myModal').find('#item_10').html(response.periodo);
                    $('#myModal').find('#item_11').html(response.fecha_actualizacion);
                    $('#myModal').find('#item_12').html(response.descripcion_servicios);
                    $('#myModal').find('#item_13').html(response.nota);
                    $('#myModal').find('#item_14').html(response.estatus);
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