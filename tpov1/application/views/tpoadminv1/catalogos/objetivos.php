<?php

/* 
 *  INAI TPO
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
                    <?php echo anchor("tpoadminv1/catalogos/campanas_avisos/agregar_objetivo", "<button class='btn btn-success'><i class=\"fa fa-plus-circle\"></i> Agregar</button></td>"); ?>
                    <div class="pull-right">
                        <a class="btn btn-default" <?php echo $print_onclick   ?>><i class="fa fa-print"></i> Imprimir</a>
                        <a class="btn btn-default" href="<?php echo base_url() . $path_file_csv ?>" download="<?php echo $name_file_csv ?>"><i class="fa fa-file"></i> Exportar a Excel</a>
                    </div>
                </div><!-- /.box-header -->
                
                <div class="box-body">
                    <table id="objetivos" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Objetivos de campa&ntilde;as o avisos institucionales</th>
                                <th>Estatus</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $c_replace = array('\'', '"');
                                for($z = 0; $z < sizeof($objetivos); $z++)
                                {
                                    echo '<tr>';
                                    echo '<td>' . $objetivos[$z]['id_campana_objetivo'] . '</td>';
                                    echo '<td>' . $objetivos[$z]['campana_objetivo'] . '</td>';
                                    echo '<td>' . $objetivos[$z]['estatus'] . '</td>';
                                    echo "<td> <span class='btn-group btn btn-info btn-sm' onclick=\"abrirModal(" . $objetivos[$z]['id_campana_objetivo'] . ", '". str_replace($c_replace, "", $objetivos[$z]['campana_objetivo'] ). "', '" .  $objetivos[$z]['estatus'] . "')\"> <i class='fa fa-search'></i></span></td>";
                                    echo '<td>' . anchor("tpoadminv1/catalogos/campanas_avisos/editar_objetivo/".$objetivos[$z]['id_campana_objetivo'], "<button class='btn btn-warning btn-sm' title='Editar'><i class=\"fa fa-edit\"></i></button></td>");
                                    echo "<td> <span class='btn-group btn btn-danger btn-sm' onclick=\"eliminarModal(" . $objetivos[$z]['id_campana_objetivo'] . ", '". str_replace($c_replace, "", $objetivos[$z]['campana_objetivo'] ). "')\"> <i class='fa fa-close'></i></span></td>";
                                   
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
                <h3 class="modal-title">Detalle</h3>
        </div>
        <div class="modal-body">
            <div id="loading_modal" ></div>
            <table id="table_modal" class="table form-horizontal">
                <tbody>
                    <tr class="form-group">
                        <td class="control-label col-sm-4"><b>Objetivo de campa&ntilde;a o aviso institucional* </b>
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
        $('#myModalDelete').find('#mensaje_modal').html('¿Desea eliminar el objetivo institucional <b>' + name+ '</b>?');
        $('#myModalDelete').modal('show');
    }

    var eliminar = function (id){
        window.location.href = "eliminar_objetivo/" + id;
    }

    var abrirModal = function(id, name, active){
        $('#myModal').find('#item_1').html(name);
        $('#myModal').find('#item_2').html(active);
        $('#myModal').modal('show'); 
    }
    
</script>