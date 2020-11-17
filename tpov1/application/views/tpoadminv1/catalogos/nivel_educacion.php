<?php

/* 
 * INAI TPO
 */

?>

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
    <div class="row">
        <div class="col-xs-12">
            <div class="box table-responsive">
                <div class="box-header">
                    <?php echo anchor("tpoadminv1/catalogos/poblacion_objetivo/agregar_nivel_educacion", "<button class='btn btn-success'><i class=\"fa fa-plus-circle\"></i> Agregar</button></td>"); ?>
                    <div class="pull-right">
                        <a class="btn btn-default" <?php echo $print_onclick   ?>><i class="fa fa-print"></i> Imprimir</a>
                        <a class="btn btn-default" href="<?php echo base_url() . $path_file_csv ?>" download="<?php echo $name_file_csv ?>"></i> Exportar a Excel</a>
                    </div>
                </div><!-- /.box-header -->
                
                <div class="box-body">
                    <table id="educacion" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nivel de educaci&oacute;n</th>
                                <th>Estatus</th>
                                <th style="width: 12px;"></th>
                                <th style="width: 12px;"></th>
                                <th style="width: 12px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $c_replace = array('\'', '"');
                                for($z = 0; $z < sizeof($educacion); $z++)
                                {
                                    echo '<tr>';
                                    echo '<td>' . $educacion[$z]['id_poblacion_nivel_educativo'] . '</td>';
                                    echo '<td>' . $educacion[$z]['nombre_poblacion_nivel_educativo'] . '</td>';
                                    echo '<td>' . $educacion[$z]['active'] . '</td>';
                                    echo "<td> <span class='btn-group btn btn-info btn-sm' onclick=\"abrirModal(" . $educacion[$z]['id_poblacion_nivel_educativo'] . ", '". str_replace($c_replace, "", $educacion[$z]['nombre_poblacion_nivel_educativo']) . "', '" .  $educacion[$z]['active'] . "')\"> <i class='fa fa-search'></i></span></td>";
                                    echo '<td>' . anchor("tpoadminv1/catalogos/poblacion_objetivo/editar_nivel_educacion/".$educacion[$z]['id_poblacion_nivel_educativo'], "<button class='btn btn-warning btn-sm' title='Editar'><i class=\"fa fa-edit\"></i></button></td>"); 
                                    echo "<td> <span class='btn-group btn btn-danger btn-sm' onclick=\"eliminarModal(" . $educacion[$z]['id_poblacion_nivel_educativo'] . ", '". str_replace($c_replace, "", $educacion[$z]['nombre_poblacion_nivel_educativo']) . "')\"> <i class='fa fa-close'></i></span></td>";
                                    
									
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
                        <td class="control-label col-sm-4"><b>Nivel de educaci&oacute;n* </b>
                        </td>
                        <td class="col-sm-8" id="item_1"></td>
                    </tr>                        
                    <tr class="form-group">
                        <td class="control-label col-sm-4"><b>Estatus*</b></td>
                        <td class="col-sm-8" id="item_2"></td>
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
        $('#myModalDelete').find('#mensaje_modal').html('¿Desea eliminar el nivel de educaci&oacute;n <b>' + name+ '</b>?');
        $('#myModalDelete').modal('show');
    }

    var eliminar = function (id){
        window.location.href = "eliminar_nivel_educacion/" + id;
    }

    var abrirModal = function(id, name, active){
        $('#myModal').find('#item_1').html(name);
        $('#myModal').find('#item_2').html(active);
        $('#myModal').modal('show'); 
    }
    
</script>