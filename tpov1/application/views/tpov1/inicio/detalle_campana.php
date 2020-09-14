<?php

if($disponible == true){ /* se muestra la info*/
    
    if($campana['fecha_inicio'] == '0000-00-00'){
        $fecha_inicio = 'N/A';
    }
    else
    {
        $fecha_inicio = $campana['fecha_inicio'];
    }
    
    if($campana['fecha_termino'] == '0000-00-00'){
        $fecha_termino = 'N/A';
    }
    else
    {
        $fecha_termino = $campana['fecha_termino'];
    }
    
    
    if($campana['fecha_inicio_to'] == '0000-00-00'){
        $fecha_inicio_to = 'N/A';
    }
    else
    {
        $fecha_inicio_to = $campana['fecha_inicio_to'];
    }
    
    if($campana['fecha_termino_to'] == '0000-00-00'){
        $fecha_termino_to = 'N/A';
    }
    else
    {
        $fecha_termino_to = $campana['fecha_termino_to'];
    }
    
    if($campana['fecha_inicio_periodo'] == '0000-00-00'){
    	$fecha_inicio_periodo = 'N/A';
    }
    else
    {
        $fecha_inicio_periodo = $campana['fecha_inicio_periodo'];
    }
    
    if($campana['fecha_termino_periodo'] == '0000-00-00'){
    	$fecha_termino_periodo = 'N/A';
    }
    else
    {
        $fecha_termino_periodo = $campana['fecha_termino_periodo'];
    }    
    
    $link_file = 'No hay archivo';
    if(!empty($campana['evaluacion_documento'])){
        $link_file = "<a href='" . $campana['path_file_evaluacion'] . "' download>" . $campana['evaluacion_documento'] . "</a>";
    }
?> 

<style>
    #info_contratos td{
        padding: 2px !important;
        font-size: 12px;
    }
</style>
<input name="id_campana_aviso" type="hidden" value="<?php echo $campana['id_campana_aviso'] ?>">
<div class="row">
    <div class="box box-info box-solid">
        <div class="box-header header">
            <h3 class="box-title">Detalle de la campa&ntilde;a o aviso institucional </h3>
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
                        <td>Tipo* <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['tipo']?>"></i></td>
                        <td width="70%"><?php echo $campana['nombre_campana_tipo']?></td>
                    </tr>
                    <tr>
                        <td>Subtipo* <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['subtipo']?>"></i></td>
                        <td><?php echo $campana['nombre_campana_subtipo']?></td>
                    </tr>
                    <tr>
                        <td>Nombre* <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['nombre_campana_aviso']?>"></i></td>
                        <td><?php echo $campana['nombre_campana_aviso']?></td>
                    </tr>
                    <tr>
                        <td>Clave de campaña o aviso	</td>
                        <td><?php echo $campana['clave_campana']; ?></td>
                    </tr>
                    <tr>
                        <td>Autoridad que proporcionó la clave <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['autoridad']?>"></i></td>
                        <td><?php echo $campana['autoridad']?></td>
                    </tr>
                    <tr>
                        <td>Ejercicio* <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['ejercicio']?>"></i></td>
                        <td><?php echo $campana['nombre_ejercicio']?></td>
                    </tr>
                    <tr>
                        <td>Trimestre* <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['trimestre']?>"></i></td>
                        <td><?php echo $campana['nombre_trimestre']?></td>
                    </tr>
                    <tr>
                        <td>Fecha de inicio del periodo que se informa* <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_inicio_periodo']?>"></i></td>
                        <td><?php echo $campana['fecha_inicio_periodo']?></td>
                    </tr>
                    <tr>
                        <td>Fecha de término del periodo que se informa* <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_termino_periodo']?>"></i></td>
                        <td><?php echo $campana['fecha_termino_periodo']?></td>
                    </tr>                    
                    <tr>
                        <td>Sujeto obligado contratante* <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['so_contratante']?>"></i></td>
                        <td><?php echo $campana['nombre_so_contratante'] . @$link_so_contratante?></td>
                    </tr>

                    <tr>
                        <td>Sujeto obligado solicitante* <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['so_solicitante']?>"></i></td>
                        <td><?php echo $campana['nombre_so_solicitante'] . @$link_so_solicitante?></td>
                    </tr>
                    <tr>
                        <td>Tema* <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['tema']?>"></i></td>
                        <td><?php echo $campana['nombre_tema']?></td>
                    </tr>
                    <tr>
                        <td>Objetivo institucional* <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['objetivo_institucional']?>"></i></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Objetivo de comunicación <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['objetivo_comunicacion']?>"></i></td>
                        <td><?php echo $campana['objetivo_comunicacion']?></td>
                    </tr>
                    <tr>
                        <td>Cobertura* <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['cobertura']?>"></i></td>
                        <td><?php echo $campana['nombre_cobertura']?></td>
                    </tr>
                    <tr>
                        <td>Ámbito geográfico <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['ambito_geografico']?>"></i></td>
                        <td><?php echo $campana['campana_ambito_geo']?></td>
                    </tr>
                    <tr>
                        <td>Fecha de inicio <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_inicio']?>"></i></td>
                        <td><?php echo $fecha_inicio; ?></td>
                    </tr>
                    <tr>
                        <td>Fecha de término <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_termino']?>"></i></td>
                        <td><?php echo $fecha_termino; ?></td>
                    </tr>
                    <tr>
                        <td>Tiempo oficial* <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['tiempo_oficial']?>"></i></td>
                        <td><?php echo $campana['nombre_tiempo_oficial']?></td>
                    </tr>
                    <tr>
                        <td>Monto total del tiempo oficial <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['monto_tiempo']?>"></i></td>
                        <td><?php echo $campana['monto_tiempo'] ?></td>
                    </tr>
                    <tr>
                        <td>Tipo de tiempo oficial <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['tipoTO']?>"></i></td>
                        <td><?php echo $campana['nombre_tipoTO'] ?></td>
                    </tr>
                    <tr>
                        <td>Mensaje sobre el tiempo oficial <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['mensajeTO']?>"></i></td>
                        <td><?php echo $campana['mensajeTO'] ?></td>
                    </tr>
                    <tr>
                        <td>Fecha de inicio tiempo oficial <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_inicio_to']?>"></i></td>
                        <td><?php echo $fecha_inicio_to; ?></td>
                    </tr>
                    <tr>
                        <td>Fecha de término tiempo oficial <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_termino_to']?>"></i></td>
                        <td><?php echo $fecha_termino_to; ?></td>
                    </tr>
                    
                    <tr>
                        <td>Medio de comunicación <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title=""></i></td>
                        <td><?php echo $campana['nombre_servicioCat'] ?></td>
                    </tr>
                    <tr>
                        <td>Descripción de unidad <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title=""></i></td>
                        <td><?php echo $campana['descripcion_unidad'] ?></td>
                    </tr>
                    <tr>
                        <td>Concesionario responsable de publicar la campaña o la comunicación correspondiente (razón social) <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title=""></i></td>
                        <td><?php echo $campana['responsable_publisher'] ?></td>
                    </tr>
                    <tr>
                        <td>Distintivo y/o nombre comercial del concesionario responsable de publicar la campaña o comunicación <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title=""></i></td>
                        <td><?php echo $campana['name_comercial'] ?></td>
                    </tr>
                    <tr>
                        <td>Descripción breve de las razones que justifican la elección del proveedor <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title=""></i></td>
                        <td><?php echo $campana['razones_supplier'] ?></td>
                    </tr>
                    <tr>
                        <td>Área administrativa encargada de solicitar la difusión del mensaje o producto, en su caso <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title=""></i></td>
                        <td><?php echo $campana['difusion_mensaje'] ?></td>
                    </tr>
                    <tr>
                        <td>Número de factura, en su caso <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title=""></i></td>
                        <td><?php echo $campana['num_factura'] ?></td>
                    </tr>
                    
                    <tr>
                        <td>Publicación SEGOB. <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['segob']?>"></i></td>
                        <td><?php echo $campana['publicacion_segob']?></td>
                    </tr>
                    <tr>
                        <td>Documento del PACS <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['pacs']?>"></i></td>
                        <td><?php echo $campana['denominacion']?></td>
                    </tr>
                    <tr>
                        <td>Fecha de publicación* <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['fecha_publicacion']?>"></i></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Estatus* <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['active']?>"></i></td>
                        <td><?php echo $campana['active_nombre']?></td>
                    </tr>
                    <tr>
                        <td>Nota <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['nota']?>"></i></td>
                        <td><?php echo $campana['nota']?></td>
                    </tr>
                    <tr>
                        <td>Monto total ejercido <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['monto_total_ejercido']?>"></i></td>
                        <td><?php echo $monto_total; ?></td>
                    </tr>
                </tbody>
            </table>
        </div> <!-- / .box-body-->
    </div> <!-- / .box-->
</div>

<div class="row">
    <div class="box box-default box">
        <div class="box-header header">
            <h3 class="box-title">Nivel socioeconómico</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        </div> <!-- / .box-header-->
        <div class="box-body table-responsive with-border">
            <table id="nivel" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Nivel socioeconómico</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if($niveles != '')
                    {
                        for($z = 0; $z < sizeof($niveles); $z++)
                        {
                            echo '<tr>';
                            echo '<td>' . $niveles[$z]['nombre_poblacion_nivel'] . '</td>';
                            echo '</tr>';
                        }
                    }
                    ?>         
                </tbody>
            </table>
        </div> <!-- /. table-responsive -->
    </div> <!-- / .box-->
</div>


<div class="row">
    <div class="box box-info box">
        <div class="box-header header">
            <h3 class="box-title">Grupos edad</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        </div> <!-- / .box-header-->
        <div class="box-body table-responsive with-border">
            <table id="edad" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Grupos de edad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if($edades != '')
                    {
                        for($z = 0; $z < sizeof($edades); $z++)
                        {
                            echo '<tr>';
                            echo '<td>' . $edades[$z]['nombre_grupo_edad'] . '</td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="row">
    <div class="box box-default box">
        <div class="box-header header">
            <h3 class="box-title">Lugares</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        </div> <!-- / .box-header-->
        <div class="box-body table-responsive with-border">
            <table id="lugares" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Lugar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if($lugares != '')
                    {
                        for($z = 0; $z < sizeof($lugares); $z++)
                        {
                            echo '<tr>';
                            echo '<td>' . $lugares[$z]['poblacion_lugar'] . '</td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="row">
    <div class="box box-info box">
        <div class="box-header header">
            <h3 class="box-title">Nivel educativo</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        </div> <!-- / .box-header-->
        <div class="box-body table-responsive with-border">
            <table id="educacion" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Nivel educativo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if($educacion != '')
                    {
                        for($z = 0; $z < sizeof($educacion); $z++)
                        {
                            echo '<tr>';
                            echo '<td>' . $educacion[$z]['nombre_nivel_educativo'] . '</td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="row">
    <div class="box box-default box">
        <div class="box-header header">
            <h3 class="box-title">Sexo</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        </div> <!-- / .box-header-->
        <div class="box-body table-responsive with-border">
            <table id="sexo" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Sexo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if($sexos != '')
                    {
                        for($z = 0; $z < sizeof($sexos); $z++)
                        {
                            echo '<tr>';
                            echo '<td>' . $sexos[$z]['nombre_sexo'] . '</td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="box box-info box">
        <div class="box-header header">
            <h3 class="box-title">Audios</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        </div> <!-- / .box-header-->
        <div class="box-body table-responsive with-border">
            <table id="audios" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Tipo de liga</th>
                        <th>Nombre del audio</th>
                        <th>URL del audio</th>
                        <th>Archivo del audio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if($audios != '')
                    {
                        for($z = 0; $z < sizeof($audios); $z++)
                        {
                            echo '<tr>';
                            echo '<td>' . $audios[$z]['nombre_tipo_liga'] . '</td>';
                            echo '<td>' . $audios[$z]['nombre_campana_maudio'] . '</td>';
                            echo '<td><a href="' . $audios[$z]['url_audio'] . '" target="_blank">' . $audios[$z]['url_audio'] . '</a></td>'; 
                            echo '<td><a href="'.base_url().'data/campanas/audios/' . $audios[$z]['file_audio'] . '" target="_blank">' . $audios[$z]['file_audio'] . '</a></td>'; 
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="box box-default box">
        <div class="box-header header">
            <h3 class="box-title">Im&aacute;genes</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        </div> <!-- / .box-header-->
        <div class="box-body table-responsive with-border">
            <table id="imagenes" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Tipo de liga</th>
                        <th>Nombre de la imagen</th>
                        <th>URL de la imagen</th>
                        <th>Archivo de la imagen</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if($imagenes != '')
                    {
                        for($z = 0; $z < sizeof($imagenes); $z++)
                        {
                            echo '<tr>';
                            echo '<td>' . $imagenes[$z]['nombre_tipo_liga'] . '</td>';
                            echo '<td>' . $imagenes[$z]['nombre_campana_mimagen'] . '</td>';
                            echo '<td><a href="' . $imagenes[$z]['url_imagen'] . '" target="_blank">' . $imagenes[$z]['url_imagen'] . '</a></td>'; 
                            echo '<td><a href="'.base_url().'data/campanas/imagenes/' . $imagenes[$z]['file_imagen'] . '" target="_blank">' . $imagenes[$z]['file_imagen'] . '</a></td>'; 
                            echo '</tr>';
                        }
                    }
                    ?>           
                </tbody>
            </table>
        </div> <!-- / .box-body-->
    </div> <!-- / .box-->
</div>


<div class="row">
    <div class="box box-info box">
        <div class="box-header header">
            <h3 class="box-title">Videos</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        </div> <!-- / .box-header-->
        <div class="box-body table-responsive with-border">
            <table id="videos" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Tipo de liga</th>
                        <th>Nombre del audio</th>
                        <th>URL del audio</th>
                        <th>Archivo del audio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if($videos != '')
                    {
                        for($z = 0; $z < sizeof($videos); $z++)
                        {
                            echo '<tr>';
                            echo '<td>' . $videos[$z]['nombre_tipo_liga'] . '</td>';
                            echo '<td>' . $videos[$z]['nombre_campana_mvideo'] . '</td>';
                            echo '<td><a href="' . $videos[$z]['url_video'] . '" target="_blank">' . $videos[$z]['url_video'] . '</a></td>'; 
                            echo '<td><a href="'.base_url().'data/campanas/videos/' . $videos[$z]['file_video'] . '" target="_blank">' . $videos[$z]['file_video'] . '</a></td>'; 
                            //echo '<td><a href="' . $videos[$z]['file_video'] . '" target="_blank">' . $videos[$z]['file_video'] . '</a></td>'; 
                            echo '</tr>';
                        }
                    }
                    ?>          
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="box box-default box">
        <div class="box-header header">
            <h3 class="box-title">Evaluación de la campa&ntilde;a o aviso institucional</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        </div> <!-- / .box-header-->
        <div class="box-body table-responsive with-border">
            <table id="videos" class="table table-striped">
                <tbody>
                    <tr>
                        <td>Nombre* <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['nombre_campana_aviso']?>"></i></td>
                        <td width="80%"><?php echo $campana['nombre_campana_aviso'] ?></td>
                    </tr>
                    <tr>
                        <td>Evaluaci&oacute;n</th>
                        <td><?php echo $campana['evaluacion'] ?></td>
                    </tr>
                    <tr>
                        <td>Documento de evaluaci&oacute;n</td>
                        <td><?php echo $link_file ?></td>
                    </tr>        
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="box box-info box">
        <div class="box-header header">
            <h3 class="box-title">Servicio de difusión en medios de comunicación relacionados con la campaña</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        </div> <!-- / .box-header-->
        <div class="box-body table-responsive with-border">
            <div id="options_servicio" class="row" style="margin-bottom:5px; margin-right:0px;">
                <div class="pull-right">
                    <a class="btn btn-default" onclick="print_btn_servicio()"><i class="fa fa-print"></i> Imprimir</a>
                    <a id="descargabtntableservicio" class="btn btn-default" onclick="descargar_archivo_table_servicio()"><i class="fa fa-file"></i> Exportar datos</a>
                    <input type="hidden" id="link_descarga_table_servicio" value="<?php echo $link_descarga_table_servicio; ?>"/>
                    <input type="hidden" id="link_print_servicio" value="<?php echo $print_url_servicio; ?>"/>
                </div> 
            </div>
            <table id="servicios_difusion" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Ejercicio</th>
                        <th>Factura  <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['ejercicio']?>"></i></th>
                        <th>Fecha  <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['ejercicio']?>"></i></th>
                        <th>Proveedor  <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['ejercicio']?>"></i></th>
                        <th>Categor&iacute;a  <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['ejercicio']?>"></i></th>
                        <th>Subcategor&iacute;a  <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['ejercicio']?>"></i></th>
                        <th>Tipo</th>
                        <th>Campana o aviso  <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['ejercicio']?>"></i></th>
                        <th>Monto gastado  <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['ejercicio']?>"></i></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if($servicios_difusion != '')
                    {
                        for($z = 0; $z < sizeof($servicios_difusion); $z++)
                        {
                            echo '<tr>';
                            echo '<td>' . $servicios_difusion[$z]['ejercicio'] . '</td>';
                            echo '<td>' . $servicios_difusion[$z]['factura'] . '</td>';
                            echo '<td>' . $servicios_difusion[$z]['fecha_erogacion'] . '</td>';
                            echo '<td>' . $servicios_difusion[$z]['proveedor'] . '</td>';
                            echo '<td>' . $servicios_difusion[$z]['nombre_servicio_categoria'] . '</td>';
                            echo '<td>' . $servicios_difusion[$z]['nombre_servicio_subcategoria'] . '</td>';
                            echo '<td>' . $servicios_difusion[$z]['tipo'] . '</td>';
                            echo '<td>' . $servicios_difusion[$z]['nombre_campana_aviso'] . '</td>';
                            echo '<td>' . $servicios_difusion[$z]['monto_servicio'] . '</td>';
                            echo '<td><a href="../../erogaciones/detalle/' . $servicios_difusion[$z]['id_factura'] . '" target="_blank" class="btn btn-default btn-xs" data-toggle="tooltip" title="Detalle factura"><i class="fa fa-link"></i></a></td>';
                            echo '<td><a href="../../proveedores/proveedor_detalle/' . $servicios_difusion[$z]['id_proveedor'] . '" target="_blank" class="btn btn-default btn-xs" data-toggle="tooltip" title="Detalle proveedor"><i class="fa fa-link"></i></a></td>';
                            echo '</tr>';
                        }
                    }
                    ?>
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
        </div> <!-- / .box-body-->
    </div> <!-- / .box-->
</div>


<div class="row">
    <div class="box box-default box">
        <div class="box-header header">
            <h3 class="box-title">Otros servicios asociados a la comunicaci&oacute;n relacionados con la campa&ntilde;a</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        </div> <!-- / .box-header-->
        <div class="box-body table-responsive with-border">
            <div id="options_otros" class="row" style="margin-bottom:5px; margin-right:0px;">
                <div class="pull-right">
                    <a class="btn btn-default" onclick="print_btn_otros()"><i class="fa fa-print"></i> Imprimir</a>
                    <a id="descargabtntableotros" class="btn btn-default" onclick="descargar_archivo_table_otros()"><i class="fa fa-file"></i> Exportar datos</a>
                    <input type="hidden" id="link_descarga_table_otros" value="<?php echo $link_descarga_table_otros; ?>"/>
                    <input type="hidden" id="link_print_otros" value="<?php echo $print_url_otros; ?>"/>
                </div> 
            </div>
            <table id="otros_servicios_difusion" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        
                        <th>Ejercicio</th>
                        <th>Factura  <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['ejercicio']?>"></i></th>
                        <th>Fecha  <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['ejercicio']?>"></i></th>
                        <th>Proveedor  <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['ejercicio']?>"></i></th>
                        <th>Categor&iacute;a  <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['ejercicio']?>"></i></th>
                        <th>Subcategor&iacute;a  <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['ejercicio']?>"></i></th>
                        <th>Tipo</th>
                        <th>Campa&ntilde;a o aviso  <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['ejercicio']?>"></i></th>
                        <th>Monto gastado  <i class="fa fa-info-circle text-primary" data-toggle="tooltip" title="<?php echo $texto_ayuda['ejercicio']?>"></i></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if($otros_servicios_difusion != '')
                    {
                        for($z = 0; $z < sizeof($otros_servicios_difusion); $z++)
                        {
                            echo '<tr>';
                            echo '<td>' . $otros_servicios_difusion[$z]['ejercicio'] . '</td>';
                            echo '<td>' . $otros_servicios_difusion[$z]['factura'] . '</td>';
                            echo '<td>' . $otros_servicios_difusion[$z]['fecha_erogacion'] . '</td>';
                            echo '<td>' . $otros_servicios_difusion[$z]['proveedor'] . '</td>';
                            echo '<td>' . $otros_servicios_difusion[$z]['nombre_servicio_categoria'] . '</td>';
                            echo '<td>' . $otros_servicios_difusion[$z]['nombre_servicio_subcategoria'] . '</td>';
                            echo '<td>' . $otros_servicios_difusion[$z]['tipo'] . '</td>';
                            echo '<td>' . $otros_servicios_difusion[$z]['nombre_campana_aviso'] . '</td>';
                            echo '<td>' . $otros_servicios_difusion[$z]['monto_servicio'] . '</td>';
                            echo '<td><a href="../../erogaciones/detalle/' . $otros_servicios_difusion[$z]['id_factura'] . '" target="_blank" class="btn btn-default btn-xs" data-toggle="tooltip" title="Detalle factura"><i class="fa fa-link"></i></a></td>';
                            echo '<td><a href="../../proveedores/proveedor_detalle/' . $otros_servicios_difusion[$z]['id_proveedor'] . '" target="_blank" class="btn btn-default btn-xs" data-toggle="tooltip" title="Detalle proveedor"><i class="fa fa-link"></i></a></td>';
                            echo '</tr>';
                        }
                    }
                    ?>            
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
        </div> <!-- / .box-body-->
    </div> <!-- / .box-->
</div>


<script>
    
    var table_ordenes = null;
    var table_contratos = null;
    var init_tables = function(){
        get_valores_table_ordenes();
        get_valores_table_contratos();
        
    }

    var get_valores_table_ordenes = function(){
        
        if(table_ordenes !== undefined && table_ordenes != null){
            table_ordenes.fnDestroy();
        }

        $('#ordenes').find('tbody').empty();
        $('#ordenes').find('tbody').append('<tr><td colspan="7" class="text-center">Cargando informaci&oacute;n ...</td></tr>');


        var form_data = new FormData();                  
        form_data.append('id_campana_aviso', $('input[name="id_campana_aviso"]').val());
        var url = '<?php echo base_url() . 'index.php/tpov1/proveedores/getDatosProveedorOrdenes' ?>';
        buscar(url, form_data, set_valores_table_ordenes, 'ordenes');
    }

    var get_valores_table_contratos = function(){
        
        if(table_contratos !== undefined && table_contratos != null){
            table_contratos.fnDestroy();
        }

        $('#contratos').find('tbody').empty();
        $('#contratos').find('tbody').append('<tr><td colspan="11" class="text-center">Cargando informaci&oacute;n ...</td></tr>');

        var form_data = new FormData();                  
        form_data.append('id_campana_aviso', $('input[name="id_campana_aviso"]').val());
        var url = '<?php echo base_url() . 'index.php/tpov1/proveedores/getDatosProveedorContratos' ?>';
        buscar(url, form_data, set_valores_table_contratos, 'contratos');
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
                }
            }
        });
    }

    var error_datos = function(container){
        if(container == 'ordenes'){
            $('#ordenes').find('tbody').empty();
            $('#ordenes').find('tbody').append('<tr><td colspan="7" class="text-center">No se encontr&oacute; ning&uacute;n registro</td></tr>');
        }else if(container == 'contratos'){
            $('#contratos').find('tbody').empty();
            $('#contratos').find('tbody').append('<tr><td colspan="11" class="text-center">No se encontr&oacute; ning&uacute;n registro</td></tr>');
        }
    }

    var set_valores_table_contratos = function(response, container){
        $('#contratos').find('tbody').empty();
        if(Array.isArray(response)){
            response.map(function (e){
                var html = "<tr>" +
                                "<td>"+e.id+"</td>" +
                                "<td>"+e.ejercicio+"</td>" +
                                "<td>"+e.trimestre+"</td>" +
                                "<td>"+e.so_contratante+"</td>" +
                                "<td>"+e.so_solicitante+"</td>" +
                                "<td>"+e.numero_contrato+"</td>" +
                                "<td>"+e.monto_contrato+"</td>" +
                                "<td>"+e.monto_modificado+"</td>" +
                                "<td>"+e.monto_total+"</td>" +
                                "<td>"+e.monto_pagado+"</td>" +
                                "<td><a href='" + e.link + "' class='btn btn-default btn-xs' data-toggle='tooltip' title='Detalle'><i class='fa fa-link'></i></a></td>" + 
                           "</tr>";
                $('#contratos').find('tbody').append(html);
            });
            var no_filter = [10];
            initDataTable(table_contratos, '#contratos', no_filter);
        }else{
            $('#contratos').find('tbody').append('<tr><td colspan="11" class="text-center">No se encontr&oacute; ning&uacute;n registro</td></tr>');
        }

    }

    var set_valores_table_ordenes = function(response, container){
        $('#ordenes').find('tbody').empty();
        if(Array.isArray(response)){
            response.map(function (e){
                var html = "<tr>" +
                                "<td>"+e.id+"</td>" +
                                "<td>"+e.ejercicio+"</td>" +
                                "<td>"+e.trimestre+"</td>" +
                                "<td>"+e.numero_orden_compra+"</td>" +
                                "<td>"+e.nombre_campana_aviso+"</td>" +
                                "<td>"+e.monto+"</td>" +
                                "<td><a href='" + e.link + "' class='btn btn-default btn-xs' data-toggle='tooltip' title='Detalle'><i class='fa fa-link'></i></a></td>" + 
                           "</tr>";
                $('#ordenes').find('tbody').append(html);
            });
            var no_filter = [6];
            initDataTable(table_ordenes, '#ordenes', no_filter);
        }else{
            $('#ordenes').find('tbody').append('<tr><td colspan="7" class="text-center">No se encontr&oacute; ning&uacute;n registro</td></tr>');
        }
    }

    var initDataTable = function(table, container, no_filter){
        table = $(container).dataTable({
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
            }
        });
    }


    var print_btn_servicio = function(){
        var url = $('#link_print_servicio').val() + $('input[name="id_campana_aviso"]').val();
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
        var url = $('#link_print_otros').val() + $('input[name="id_campana_aviso"]').val();
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
                                
                            





</script>


<?php   
}else {
    echo "Campaña o aviso institucional no encontrado";
}?>
