<?php

if (!defined('BASEPATH'))
{
    exit('No direct script access allowed');
}

class Exportar extends CI_Controller
{
    function index() 
    {
        echo 'Directory access is forbidden';
    }

    function pnt(){
        $file_F70FXXIIIA = $this->F70FXXIIIA('data/archivos/', 'F70FXXIIIA.csv');
        $file_F70FXXIIIB = $this->F70FXXIIIB('data/archivos/', 'F70FXXIIIB.csv');
        $file_F70FXXIIIB_tabla_10633 = $this->F70FXXIIIB_tabla_10633('data/archivos/', 'F70FXXIIIB_tabla_10633.csv');
        $file_F70FXXIIIB_tabla_10632 = $this->F70FXXIIIB_tabla_10632('data/archivos/', 'F70FXXIIIB_tabla_10632.csv');
        $file_F70FXXIIIB_tabla_10656 = $this->F70FXXIIIB_tabla_10656('data/archivos/', 'F70FXXIIIB_tabla_10656.csv');
		$file_F70FXXIIIC = $this->F70FXXIIIC('data/archivos/', 'F70FXXIIIC.csv');
		$file_F70FXXIIIC_tabla_333914 = $this->F70FXXIIIC_tabla_333914('data/archivos/', 'F70FXXIIIC_tabla_333914.csv');
        $file_F70FXXIIID = $this->F70FXXIIID('data/archivos/', 'F70FXXIIID.csv');		
        $files =array($file_F70FXXIIIA, $file_F70FXXIIIB, $file_F70FXXIIIB_tabla_10633, $file_F70FXXIIIB_tabla_10632, $file_F70FXXIIIB_tabla_10656, $file_F70FXXIIIC, $file_F70FXXIIIC_tabla_333914, $file_F70FXXIIID);
               
        $leemefile = 'leeme.txt';
        $leemetexto = $this->leemePNT();
        $this->creaZip($leemefile, $leemetexto, $files, "data/archivos/PNT.zip");

        $urlfilename = base_url() . "data/archivos/PNT.zip"; 

        sleep( 1 );
        header('Content-type: application/json');
        echo json_encode( $urlfilename );
    }

    function inicio(){
        
        $this->load->model('tpov1/graficas/Graficas_model');
        $str = $this->Graficas_model->limpiar_Cadena($this->uri->segment(4));
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $file_presupuesto = $this->Presupuestos_model->crear_archivo_presupuesto('data/archivos/', 'presupuestos.csv', $str);
        $file_so = $this->crear_archivo_so('data/archivos/', 'sujetos_obligados.csv');
        $file_contratos = $this->crear_archivo_contratos('data/archivos/', 'contratos.csv');
        $file_convenios = $this->crear_archivo_convenios('data/archivos/', 'convenios.csv');
        $file_ordenes_compra = $this->crear_archivo_ordenes_compra('data/archivos/', 'orden_compra.csv');
        $file_facturas = $this->crear_archivo_facturas('data/archivos/', 'facturas.csv');
        $file_facturas_detalle = $this->crear_archivo_facturas_desglose('data/archivos/', 'facturas_detalles.csv');
        $file_proveedores = $this->crear_archivo_proveedores('data/archivos/', 'proveedores.csv');
        $file_desglose_partidas = $this->crear_archivo_desglose_partidas('data/archivos/', 'desglosepartidas.csv');
        $file_videos = $this->crear_archivo_videos('data/archivos/', 'campanasyavisos_videos.csv');
        $file_socioeconomicos = $this->crear_archivo_socioeconomicos('data/archivos/', 'campanasyavisos_socioeconomicos.csv');
        $file_campanasyavisos = $this->crear_archivo_campanasyavisos('data/archivos/', 'campanasyavisos.csv');
        $file_sexo = $this->crear_archivo_sexo('data/archivos/', 'campanasyavisos_sexo.csv');
        $file_lugar = $this->crear_archivo_lugar('data/archivos/', 'campanasyavisos_lugar.csv');
        $file_imagenes = $this->crear_archivo_imagenes('data/archivos/', 'campanasyavisos_imagenes.csv');
        $file_educacion = $this->crear_archivo_educacion('data/archivos/', 'campanasyavisos_educacion.csv');
        $file_edad = $this->crear_archivo_edad('data/archivos/', 'campanasyavisos_edad.csv');
        $file_audios = $this->crear_archivo_audios('data/archivos/', 'campanasyavisos_audios.csv');

        $files =array($file_presupuesto, $file_so, $file_contratos, $file_convenios, $file_ordenes_compra, $file_proveedores, 
            $file_desglose_partidas, $file_facturas, $file_facturas_detalle,$file_videos, $file_socioeconomicos, $file_campanasyavisos, $file_sexo,
            $file_lugar, $file_imagenes, $file_educacion, $file_edad, $file_audios);
               
        $leemefile = 'leeme.txt';
        $leemetexto = $this->leemeInicio();
        $this->creaZip($leemefile, $leemetexto, $files, "data/archivos/InicioData.zip");

        $urlfilename = base_url() . "data/archivos/InicioData.zip"; 

        sleep( 1 );
        header('Content-type: application/json');
        echo json_encode( $urlfilename );
    }
//Generación del archivo de la sección Erogaciones botón "Descarga de datos"
    function erogaciones(){
        
        $file_facturas = $this->crear_archivo_facturas('data/archivos/', 'facturas.csv');
        $file_facturas_detalle = $this->crear_archivo_facturas_desglose('data/archivos/', 'facturas_detalles.csv');
        $files =array($file_facturas, $file_facturas_detalle);
             
        $leemefile = 'leeme.txt';
        $leemetexto = $this->leemeErogaciones();
        $this->creaZip($leemefile, $leemetexto, $files, "data/archivos/ErogacionesData.zip");

        $urlfilename = base_url() . "data/archivos/ErogacionesData.zip"; 

        sleep( 1 );
        header('Content-type: application/json');
        echo json_encode( $urlfilename );
    }

    function sujetosObligados(){
        $file_so = $this->crear_archivo_so('data/archivos/', 'sujetos_obligados.csv');
        $file_contratos = $this->crear_archivo_contratos('data/archivos/', 'contratos.csv');
        $file_convenios = $this->crear_archivo_convenios('data/archivos/', 'convenios.csv');
        $file_ordenes_compra = $this->crear_archivo_ordenes_compra('data/archivos/', 'orden_compra.csv');
        $files =array($file_so, $file_ordenes_compra, $file_contratos, $file_convenios);
               
        $leemefile = 'leeme.txt';
        $leemetexto = $this->leemeSO();
        $this->creaZip($leemefile, $leemetexto, $files, "data/archivos/SujetosObligadosData.zip");

        $urlfilename = base_url() . "data/archivos/SujetosObligadosData.zip"; 

        sleep( 1 );
        header('Content-type: application/json');
        echo json_encode( $urlfilename );
    }

    function contratosOrdenes(){
        
        $file_contratos = $this->crear_archivo_contratos('data/archivos/', 'contratos.csv');
        $file_convenios = $this->crear_archivo_convenios('data/archivos/', 'convenios.csv');
        $file_ordenes_compra = $this->crear_archivo_ordenes_compra('data/archivos/', 'orden_compra.csv');
        $files =array($file_ordenes_compra, $file_contratos, $file_convenios);
               
        $leemefile = 'leeme.txt';
        $leemetexto = $this->leemeContratosyOrdenes();
        $this->creaZip($leemefile, $leemetexto, $files, "data/archivos/ContratosyOrdenesData.zip");

        $urlfilename = base_url() . "data/archivos/ContratosyOrdenesData.zip"; 

        sleep( 1 );
        header('Content-type: application/json');
        echo json_encode( $urlfilename );
    }

    function gastoPorServicio(){
        
        $file_facturas = $this->crear_archivo_facturas('data/archivos/', 'facturas.csv');
        $file_facturas_detalle = $this->crear_archivo_facturas_desglose('data/archivos/', 'facturas_detalles.csv');
        $files =array($file_facturas, $file_facturas_detalle);
               
        $leemefile = 'leeme.txt';
        $leemetexto = $this->leemeGastoPorServicio();
        $this->creaZip($leemefile, $leemetexto, $files, "data/archivos/GastoPorServicioData.zip");

        $urlfilename = base_url() . "data/archivos/GastoPorServicioData.zip"; 

        sleep( 1 );
        header('Content-type: application/json');
        echo json_encode( $urlfilename );
    }

    function porProveedores(){

        $this->load->model('tpov1/graficas/Graficas_model');
        
        $str = $this->Graficas_model->limpiar_Cadena($this->uri->segment(4));

        $file_gasto_x_proveedor = $this->crear_archivo_gasto_x_proveedor('data/archivos/', 'gasto_x_proveedor.csv');
        $file_gasto_x_oc_proveedor = $this->crear_archivo_gasto_x_oc_proveedor('data/archivos/', 'oc_x_proveedor.csv');
        $file_gasto_contratos = $this->crear_archivo_contratos('data/archivos/', 'contratos.csv');
        $file_gasto_convenios = $this->crear_archivo_convenios('data/archivos/', 'convenios.csv');
        $files =array($file_gasto_x_proveedor, $file_gasto_x_oc_proveedor, $file_gasto_contratos, $file_gasto_convenios);
               
        $leemefile = 'leeme.txt';
        $leemetexto = $this->leemePorProveedor();
        $this->creaZip($leemefile, $leemetexto, $files, "data/archivos/GastoXProveedorData.zip");

        $urlfilename = base_url() . "data/archivos/GastoXProveedorData.zip"; 

        sleep( 1 );
        header('Content-type: application/json');
        echo json_encode( $urlfilename );

    }

    function presupuesto()
    {
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $this->load->model('tpov1/graficas/Graficas_model');
        
        $file_presupuesto = $this->Presupuestos_model->crear_archivo_presupuesto('data/archivos/', 'presupuestos.csv');
        $file_desglose_partidas = $this->crear_archivo_desglose_partidas('data/archivos/', 'desglosepartidas.csv');
        $files =array($file_presupuesto, $file_desglose_partidas);
               
        $leemefile = 'leeme.txt';
        $leemetexto = $this->leemePresupuestos();
        $this->creaZip($leemefile, $leemetexto, $files, "data/archivos/presupuestoData.zip");

        $urlfilename = base_url() . "data/archivos/presupuestoData.zip"; 

        sleep( 1 );
        header('Content-type: application/json');
        echo json_encode( $urlfilename );
    }

    function creaZip($leeme, $leemetexto, $files, $filename ="salida.zip"){
        if (file_Exists($filename)) { unlink($filename); }
        $zip = new ZipArchive();
        if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
           exit("cannot open <$filename>\n");
        }    
        $zip->addFromString($leeme, $leemetexto );
        foreach ($files as &$file) {
           $zip->addFile($file);
        }
        $zip->close();
    }

    function crear_archivo_gasto_x_proveedor($path, $namefile)
    {
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/Generales_model');
        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $query = $this->db->get('vout_gasto_x_proveedor');
        $csv_header = array('#',
                    utf8_decode('Personalidad jurídica'),
                    utf8_decode('Nombre o razón social'),
                    utf8_decode('Nombre comercial'),
                    utf8_decode('R.F.C.'),
                    utf8_decode('Monto total pagado'),
                    utf8_decode('Estatus'));
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if($query->num_rows() > 0)
        {
            $count = 1;
            foreach ($query->result_array() as $row) 
            {
                $csv = array(
                    utf8_decode($count),
                    utf8_decode($row['Personalidad jurídica']),
                    utf8_decode($row['Nombre o razón social']),
                    utf8_decode($row['Nombre comercial']),
                    utf8_decode($row['R.F.C.']),
                    utf8_decode($row['Monto total pagado']),
                    utf8_decode($row['Estatus'])
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }

    function crear_archivo_gasto_x_oc_proveedor($path, $namefile)
    {
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/Generales_model');

        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $query = $this->db->get('vout_oc_x_proveedor');
        $csv_header = array('#',
                    utf8_decode('Nombre de proveedor'),
                    utf8_decode('Procedimiento'),
                    utf8_decode('Número de contrato'),
                    utf8_decode('Ejercicio'),
                    utf8_decode('Trimestre'),
                    utf8_decode('Sujeto obligado ordenante'),
                    utf8_decode('Campaña o aviso institucional'),
                    utf8_decode('Sujeto obligado solicitante'),
                    utf8_decode('Justificación'),
                    utf8_decode('Fecha de orden'),
                    utf8_decode('Archivo de la orden de compra en PDF'),
                    utf8_decode('Estatus'));
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if($query->num_rows() > 0)
        {
            $count = 1;
            foreach ($query->result_array() as $row) 
            {
                $csv = array(
                    utf8_decode($count),
                    utf8_decode($row['Nombre Proveedor']),
                    utf8_decode($row['Procedimiento']),
                    utf8_decode($row['ID (Número de contrato)']),
                    utf8_decode($row['Ejercicio']),
                    utf8_decode($row['Trimestre']),
                    utf8_decode($row['Sujeto obligado ordenante']),
                    utf8_decode($row['Campana o aviso institucional']),
                    utf8_decode($row['Sujeto obligado solicitante']),
                    utf8_decode($this->Generales_model->clear_html_tags($row['Justificación'])),
                    utf8_decode($row['Fecha de orden']),
                    utf8_decode($row['Archivo de la orden de compra en PDF']),
                    utf8_decode($row['Estatus'])
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }

    function crear_archivo_contratos($path, $namefile)
    {
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/Generales_model');
        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $query = $this->db->get('vout_contratos');
        $csv_header = array('#',
                    utf8_decode('Número de contrato'),
                    utf8_decode('Procedimiento'),
                    utf8_decode('Proveedor'),
                    utf8_decode('Ejercicio'),
                    utf8_decode('Trimestre'),
                    utf8_decode('Contratante'),
                    utf8_decode('Solicitante'),
                    utf8_decode('Objeto del contrato'),
                    utf8_decode('Descripción'),
                    utf8_decode('Fundamento jurídico'),
                    utf8_decode('Fecha celebración'),
                    utf8_decode('Fecha inicio'),
                    utf8_decode('Fecha fin'),
                    utf8_decode('Monto original del contrato'),
                    utf8_decode('Monto modificado'),
                    utf8_decode('Monto total'),
                    utf8_decode('Monto pagado a la fecha'),
                    utf8_decode('Archivo contrato en PDF (Vinculo al archivo)'),
                    utf8_decode('Estatus'));
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if($query->num_rows() > 0)
        {
            $count = 1;
            foreach ($query->result_array() as $row) 
            {
                $csv = array(
                    utf8_decode($count),
                    utf8_decode($row['ID (Número de contrato)']),
                    utf8_decode($row['Procedimiento']),
                    utf8_decode($row['Proveedor']),
                    utf8_decode($row['Ejercicio']),
                    utf8_decode($row['Trimestre']),
                    utf8_decode($row['Contratante']),
                    utf8_decode($row['Solicitante']),
                    utf8_decode($this->Generales_model->clear_html_tags($row['Objeto del contrato'])),
                    utf8_decode($this->Generales_model->clear_html_tags($row['Descripción'])),
                    utf8_decode($this->Generales_model->clear_html_tags($row['Fundamento jurídico'])),
                    utf8_decode($row['Fecha celebración']),
                    utf8_decode($row['Fecha inicio']),
                    utf8_decode($row['Fecha fin']),
                    utf8_decode($row['Monto original del contrato']),
                    utf8_decode($row['Monto modificado']),
                    utf8_decode($row['Monto total']),
                    utf8_decode($row['Monto pagado a la fecha']),
                    utf8_decode($row['Archivo contrato en PDF (Vinculo al archivo)']),
                    utf8_decode($row['Estatus'])
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }

    function crear_archivo_convenios($path, $namefile)
    {
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/Generales_model');
        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $query = $this->db->get('vout_convenios_modificatorios');
        $csv_header = array('#',
                    utf8_decode('Número de convenio modificatorio'),
                    utf8_decode('Número de contrato'),
                    utf8_decode('Ejercicio'),
                    utf8_decode('Trimestre'),
                    utf8_decode('Objeto'),
                    utf8_decode('Fundamento jurídico'),
                    utf8_decode('Fecha celebración'),
                    utf8_decode('Monto'),
                    utf8_decode('Archivo convenio en PDF (Vinculo al archivo)'),
                    utf8_decode('Estatus'));
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if($query->num_rows() > 0)
        {
            $count = 1;
            foreach ($query->result_array() as $row) 
            {
                $csv = array(
                    utf8_decode($count),
                    utf8_decode($row['ID (Número de convenio modificatorio)']),
                    utf8_decode($row['ID (Número de contrato)']),
                    utf8_decode($row['Ejercicio']),
                    utf8_decode($row['Trimestre']),
                    utf8_decode($this->Generales_model->clear_html_tags($row['Objeto'])),
                    utf8_decode($this->Generales_model->clear_html_tags($row['Fundamento jurídico'])),
                    utf8_decode($row['Fecha celebración']),
                    utf8_decode($row['Monto']),
                    utf8_decode($row['Archivo convenio en PDF (Vinculo al archivo)']),
                    utf8_decode($row['Estatus'])
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }

    function crear_archivo_ordenes_compra($path, $namefile)
    {
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/Generales_model');
        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $query = $this->db->get('vout_ordenes_compra');
        $csv_header = array('#',
                    utf8_decode('ID (Orden de compra)'),
                    utf8_decode('Proveedor'),
                    utf8_decode('Procedimiento'),
                    utf8_decode('Contrato'),
                    utf8_decode('Ejercicio'),
                    utf8_decode('Trimestre'),
                    utf8_decode('Sujeto obligado ordenante'),
                    utf8_decode('Campaña o aviso institucional'),
                    utf8_decode('Sujeto obligado solicitante'),
                    utf8_decode('Número orden de compra'),
                    utf8_decode('Justificación'),
                    utf8_decode('Fecha de orden'),
                    utf8_decode('Archivo de la orden de compra en PDF (Vínculo al documento)'),
                    utf8_decode('Estatus'));
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if($query->num_rows() > 0)
        {
            $count = 1;
            foreach ($query->result_array() as $row) 
            {
                $csv = array(
                    utf8_decode($count),
                    utf8_decode($row['ID_Orden_de_compra)']),
                    utf8_decode($row['Proveedor']),
                    utf8_decode($row['Procedimiento']),
                    utf8_decode($row['Contrato']),
                    utf8_decode($row['Ejercicio']),
                    utf8_decode($row['Trimestre']),
                    utf8_decode($row['Sujeto_obligado_ordenante']),
                    utf8_decode($row['Campana o aviso institucional']),
                    utf8_decode($row['Sujeto obligado solicitante']),
                    utf8_decode($row['numero_orden_de_compra']),
                    utf8_decode($this->Generales_model->clear_html_tags($row['Justificación'])),
                    utf8_decode($row['Fecha_de_orden']),
                    utf8_decode($row['Archivo_de_la_orden_de_compra_en_PDF_(Vínculo_al_documento)']),
                    utf8_decode($row['Estatus'])
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }

    function crear_archivo_facturas($path, $namefile)
    {
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/Generales_model');
        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');

        $query = $this->db->get('vout_facturas');
        $csv_header = array('#',
                    utf8_decode('Número de factura'),
                    utf8_decode('Proveedor'),
                    utf8_decode('Contrato'),
                    utf8_decode('Orden'),
                    utf8_decode('Ejercicio'),
                    utf8_decode('Trimestre'),
                    utf8_decode('Monto'),
                    utf8_decode('Archivo factura en PDF (Vínculo al archivo)'),
                    utf8_decode('Archivo factura en XML (Vínculo al archivo)'),
                    utf8_decode('Fecha de erogación'),
                    utf8_decode('Estatus'));
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if($query->num_rows() > 0)
        {
            $count = 1;
            foreach ($query->result_array() as $row) 
            {
                $csv = array(
                    utf8_decode($count),
                    utf8_decode($row['ID Factura']),
                    utf8_decode($row['Proveedor']),
                    utf8_decode($row['Contrato']),
                    utf8_decode($row['Orden']),
                    utf8_decode($row['Ejercicio']),
                    utf8_decode($row['Trimestre']),
                    utf8_decode($row['Monto']),
                    utf8_decode($row['Archivo factura en PDF (Vínculo al archivo)']),
                    utf8_decode($row['Archivo factura en XML (Vínculo al archivo)']),
                    utf8_decode($row['Fecha de erogación']),
                    utf8_decode($row['Estatus'])
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }

    function crear_archivo_facturas_desglose($path, $namefile)
    {
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/Generales_model');
        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $query = $this->db->get('vout_facturas_desglose_v2');
        $csv_header = array('#',
                    utf8_decode('ID Detalle Factura'),
                    utf8_decode('Número de factura'),
                    utf8_decode('Campaña o aviso institucional'),
                    utf8_decode('Nombre campaña o aviso institucional'),
                    utf8_decode('Clasificación del servicio'),
                    utf8_decode('Categoría del servicio'),
                    utf8_decode('Subcategoría del servicio'),
                    utf8_decode('Unidad'),
                    utf8_decode('Sujeto obligado contratante'),
                    utf8_decode('Partida contratante'),
                    utf8_decode('Sujeto obligado solicitante'),
                    utf8_decode('Partida solicitante'),
                    utf8_decode('Área administrativa solicitante'),
                    utf8_decode('Descripción del servicio o producto adquirido'),
                    utf8_decode('Cantidad'),
                    utf8_decode('Precio unitario con I.V.A incluido'),
                    utf8_decode('Monto'),
                    utf8_decode('Estatus'));
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if($query->num_rows() > 0)
        {
            $count = 1;
            foreach ($query->result_array() as $row) 
            {
                $csv = array(
                    utf8_decode($count),
                    utf8_decode($row['ID Detalle Factura']),
                    utf8_decode($row['ID Factura']),
                    utf8_decode($row['Campana o aviso institucional']),
                    utf8_decode($row['Nombre campana o aviso institucional']),
                    utf8_decode($row['Clasificación del servicio']),
                    utf8_decode($row['Categoría del servicio']),
                    utf8_decode($row['Subcategoría del servicio']),
                    utf8_decode($row['Unidad']),
                    utf8_decode($row['Sujeto obligado contratante']),
                    utf8_decode($row['Partida contratante']),
                    utf8_decode($row['Sujeto obligado solicitante']),
                    utf8_decode($row['Partida solicitante']),
                    utf8_decode($this->Generales_model->clear_html_tags($row['Área administrativa solicitante'])),
                    utf8_decode($this->Generales_model->clear_html_tags($row['Descripción del servicio o producto adquirido'])),
                    utf8_decode($row['Cantidad']),
                    utf8_decode($row['Precio unitario con I.V.A incluido']),
                    utf8_decode($row['Monto']),
                    utf8_decode($row['Estatus'])
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }

    function crear_archivo_so($path, $namefile)
    {
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/Generales_model');
        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $query = $this->db->get('vout_sujetos_obligados');
        $csv_header = array('#',
                    utf8_decode('ID de sujeto obligado'),
                    utf8_decode('Función'),
                    utf8_decode('Orden (Federal, Estatal, Municipal)'),
                    utf8_decode('Estado'),
                    utf8_decode('Nombre'),
                    utf8_decode('Siglas'),
                    utf8_decode('URL de página'));
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if($query->num_rows() > 0)
        {
            $count = 1;
            foreach ($query->result_array() as $row) 
            {
                $csv = array(
                    utf8_decode($count),
                    utf8_decode($row['ID de S.O.']),
                    utf8_decode($row['Función']),
                    utf8_decode($row['Orden (Federal, Estatal, Municipal)']),
                    utf8_decode($row['Estado']),
                    utf8_decode($row['Nombre']),
                    utf8_decode($row['Siglas']),
                    utf8_decode($row['URL de página'])
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }

    function crear_archivo_desglose_partidas($path, $namefile)
    {
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/Generales_model');
        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $query = $this->db->get('vout_presupuestos_desglose');
        $csv_header = array('#',
                    utf8_decode('ID de desglose'),
                    utf8_decode('ID de presupuesto'),
                    utf8_decode('Partida presupuestal'),
                    utf8_decode('Monto asignado'),
                    utf8_decode('Monto de modificación'),
                    utf8_decode('Estatus'));
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if($query->num_rows() > 0)
        {
            $count = 1;
            foreach ($query->result_array() as $row) 
            {
                $csv = array(
                    utf8_decode($count),
                    utf8_decode($row['ID de desglose']),
                    utf8_decode($row['ID de presupuesto']),
                    utf8_decode($row['Partida presupuestal']),
                    utf8_decode($row['Monto asignado']),
                    utf8_decode($row['Monto de modificación']),
                    utf8_decode($row['Estatus'])
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }

    function crear_archivo_proveedores($path, $namefile)
    {
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/Generales_model');
        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $query = $this->db->get('vout_proveedores');
        $csv_header = array('#',
                    utf8_decode('ID'),
                    utf8_decode('Personalidad jurídica'),
                    utf8_decode('Nombre o razón social'),
                    utf8_decode('Nombre comercial'),
                    utf8_decode('R.F.C.'),
                    utf8_decode('Estatus'));
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if($query->num_rows() > 0)
        {
            $count = 1;
            foreach ($query->result_array() as $row) 
            {
                $csv = array(
                    utf8_decode($count),
                    utf8_decode($row['ID']),
                    utf8_decode($row['Personalidad jurídica']),
                    utf8_decode($row['Nombre o razón social']),
                    utf8_decode($row['Nombre comercial']),
                    utf8_decode($row['R.F.C.']),
                    utf8_decode($row['Estatus'])
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }

    private function F70FXXIIIA($path, $namefile) //Formato A
    {

        $this->load->model('tpov1/graficas/Tablas_model');
        $this->load->model('tpoadminv1/Generales_model');
        
        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $registros = $this->Tablas_model->F70FXXIIIA();
        $csv_header = array('#',
                    utf8_decode('Ejercicio'),
                    utf8_decode('Fecha de inicio del periodo que se informa'),
                    utf8_decode('Fecha de término del periodo que se informa'),
                    utf8_decode('Denominación del documento'),
                    utf8_decode('Fecha en La Que Se Aprobó El Programa Anual de Comunicacion Social'),
                    utf8_decode('Hipervínculo Al Programa Anual de Comunicacion Social O Equivalente'),
                    utf8_decode('Área(s) Responsable(s) Que Genera(n), Posee(n), Publica(n) y Actualizan la Información'),
                    utf8_decode('Fecha de Validación'),
                    utf8_decode('Fecha de actualización'),
                    utf8_decode('Nota'));
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if(sizeof($registros) > 0)
        {
            $count = 1;
            foreach ($registros as $row) 
            {
                $csv = array(
                    utf8_decode($count),
                    utf8_decode($row['ejercicio']),
					utf8_decode($this->Generales_model->clear_date($row['fecha_inicio_periodo'])),
					utf8_decode($this->Generales_model->clear_date($row['fecha_termino_periodo'])),
                    utf8_decode($this->Generales_model->clear_html_tags($row['denominacion'])),
                    utf8_decode($this->Generales_model->clear_date($row['publicacion'])),
                    utf8_decode($this->Generales_model->ruta_descarga_archivos($row['hipervinculo'],  'data/programas/')),
                    utf8_decode($row['area_responsable']),
                    utf8_decode($this->Generales_model->clear_date($row['validacion'])),
                    utf8_decode($this->Generales_model->clear_date($row['actualizacion'])),
                    utf8_decode($this->Generales_model->clear_html_tags($row['nota']))
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
     }  
     
     function F70FXXIIIB($path, $namefile)  //Formato B
     {
        $this->load->model('tpov1/graficas/Tablas_model');
        $this->load->model('tpoadminv1/Generales_model');
        
        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $registros = $this->Tablas_model->F70FXXIIIB();
        $csv_header = array(
                    utf8_decode('Ejercicio'),
                    utf8_decode('Fecha de Inicio Del periodo Que Se Informa'),
                    utf8_decode('Fecha de Término Del periodo Que Se Informa'),
                    utf8_decode('Funcion Del Sujeto Obligado (catálogo)'),
                    utf8_decode('Área Administrativa Encargada de Solicitar El Servicio o Producto, en su caso'),
                    utf8_decode('Clasificación Del(los) Servicios (catálogos)'),
                    utf8_decode('Tipo de Servicio'),
                    utf8_decode('Tipo de Medio (catálogo)'),
                    utf8_decode('Descripción de Unidad'),
                    utf8_decode('Tipo (catálogo)'),
                    utf8_decode('Nombre de La Campaña O Aviso Institucional, en su Caso'),
                    utf8_decode('Año de La Campaña'),
                    utf8_decode('Tema de La Campaña O Aviso Institucional'),
                    utf8_decode('Objetivo Institucional'),
                    utf8_decode('Objetivo de Comunicación'),
                    utf8_decode('Costo por unidad'),
                    utf8_decode('Clave Única de Identificación de Campaña'),
                    utf8_decode('Autoridad Que Proporcionó La Clave'),
                    utf8_decode('Cobertura (catálogo)'),
                    utf8_decode('Ámbito Geográfico de Cobertura'),
                    utf8_decode('Fecha de Inicio de La Campaña O Aviso Institucional'),
                    utf8_decode('Fecha de término de La Campaña O Aviso Institucional'),
                    utf8_decode('Sexo (catálogo)'),
                    utf8_decode('Lugar de Residencia'),
                    utf8_decode('Nivel Educativo'),
                    utf8_decode('Grupo de Edad'),
                    utf8_decode('Nivel Socioeconómico'),
                    utf8_decode('Respecto a Los Proveedores y su Contratación'),
                    utf8_decode('Respecto a Los Recursos y El Presupuesto'),
                    utf8_decode('Respecto Al Contrato y Los Montos'),
                    utf8_decode('Área(s) Responsable(s) Que Genera(n), Posee(n), Publica(n) Y Actualizan La Información'),
                    utf8_decode('Fecha de validación'),
                    utf8_decode('Fecha de actualización'),
                    utf8_decode('Nota'));
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if(sizeof($registros) > 0)
        {
            $count = 1;
            foreach ($registros as $row) 
            {
                $csv = array(
                    utf8_decode($row['ejercicio']),
                    utf8_decode($this->Generales_model->set_fecha_termino_trimestre($row['id_trimestre'], $row['ejercicio'], true)),
                    utf8_decode($this->Generales_model->set_fecha_termino_trimestre($row['id_trimestre'], $row['ejercicio'], false)),
                    utf8_decode($row['funcion']),
                    utf8_decode($row['area_administrativa']),
                    utf8_decode($row['id_servicio_clasificacion']),
                    utf8_decode($row['id_servicio_categoria']),
                    utf8_decode($row['id_servicio_subcategoria']),
                    utf8_decode($this->Generales_model->clear_html_tags($row['descripcion_servicios'])),
                    utf8_decode($row['id_campana_tipo']),
                    utf8_decode($row['nombre_campana_aviso']),
                    utf8_decode($row['periodo']),
                    utf8_decode($row['id_campana_tema']),
                    utf8_decode($this->Generales_model->clear_html_tags($row['id_campana_objetivo'])),
                    utf8_decode($this->Generales_model->clear_html_tags($row['objetivo_comunicacion'])),
                    utf8_decode($row['precio_unitarios']),
                    utf8_decode($row['clave_campana']),
                    utf8_decode($row['autoridad']),
                    utf8_decode($row['id_campana_cobertura']),
                    utf8_decode($row['campana_ambito_geo']),
                    utf8_decode($row['fecha_inicio']),
                    utf8_decode($row['fecha_termino']),
                    utf8_decode($row['sexo']),
                    utf8_decode($row['lugar']),
                    utf8_decode($row['educacion']),
                    utf8_decode($row['grupo_edad']),
                    utf8_decode($row['nivel_socioeconomico']),
                    utf8_decode($row['id_respecto_proveedor']),
                    utf8_decode($row['id_respecto_presupuesto']),
                    utf8_decode($row['id_respecto_contrato']),
                    utf8_decode($row['area_responsable']),
                    utf8_decode($this->Generales_model->clear_date($row['fecha_validacion'])),
                    utf8_decode($this->Generales_model->clear_date($row['fecha_actualizacion'])),
                    utf8_decode($this->Generales_model->clear_html_tags($row['nota']))
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }

    function F70FXXIIIB_tabla_10633($path, $namefile) {
        $this->load->model('tpov1/graficas/Tablas_model');
        $this->load->model('tpoadminv1/Generales_model');
        
        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $registros = $this->Tablas_model->F70FXXIIIB_tabla_10633();
        $csv_header = array(
                    utf8_decode('ID Respecto a los recursos y el presupuesto (Factura-Orden de compra-Contrato-Proveedor)'),
                    utf8_decode('Partida Genérica'),
                    utf8_decode('Clave Del Concepto'),
                    utf8_decode('Nombre Del Concepto'),
                    utf8_decode('Presupuesto Asignado por Concepto'),
                    utf8_decode('Presupuesto Modificado por Concepto'),
                    utf8_decode('Presupuesto Total Ejercido por Concepto'),
                    utf8_decode('Denominación de Cada Partida'),
                    utf8_decode('Presupuesto Total Asignado a Cada Partida'),
                    utf8_decode('Presupuesto Modificado por Partida'),
                    utf8_decode('Presupuesto Ejercido Al Periodo Reportado de Cada Partida')
                );
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if(sizeof($registros) > 0)
        {
            $count = 1;
            foreach ($registros as $row) 
            {
                $csv = array(
                    utf8_decode($row['id_respecto_presupuesto']),
                    utf8_decode($row['Partida genérica']),
                    utf8_decode($row['Clave del concepto']),
                    utf8_decode($row['Nombre del concepto']),
                    utf8_decode($row['Presupuesto asignado por concepto']),
                    utf8_decode($row['Presupuesto modificado por concepto']),
                    utf8_decode($row['Presupuesto total ejercido por concepto']),
                    utf8_decode($row['Denominación de cada partida']),
                    utf8_decode($row['Presupuesto total asignado a cada partida']),
                    utf8_decode($row['Presupuesto modificado por partida']),
                    utf8_decode($row['Presupuesto ejercido al periodo'])
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }

    function F70FXXIIIB_tabla_10656($path, $namefile) {
        $this->load->model('tpov1/graficas/Tablas_model');
        $this->load->model('tpoadminv1/Generales_model');
        
        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $registros = $this->Tablas_model->F70FXXIIIB_tabla_10656();
        $csv_header = array(
                    utf8_decode('ID Respecto al contrato y los montos (Factura-Orden de compra-Contrato-Proveedor)'),
                    utf8_decode('Fecha de Firma Del Contrato'),
                    utf8_decode('Número O Referencia de Identificación Del Contrato'),
                    utf8_decode('Objeto Del Contrato'),
                    utf8_decode('Hipervínculo Al Contrato Firmado'),
                    utf8_decode('Hipervínculo Al Convenio Modificatorio, en su Caso'),
                    utf8_decode('Monto Total Del Contrato'),
                    utf8_decode('Monto Pagado Al Periodo Publicado'),
                    utf8_decode('Fecha de Inicio de Los Servicios Contratados'),
                    utf8_decode('Fecha de Término de Los Servicios Contratados'),
                    utf8_decode('Número de Factura'),
                    utf8_decode('Hipervínculo a La Factura')
                );
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if(sizeof($registros) > 0)
        {
            $count = 1;
            foreach ($registros as $row) 
            {
                $csv = array(
                    utf8_decode($row['id_respecto_contrato']),
                    utf8_decode($this->Generales_model->clear_date($row['Fecha de firma de contrato'])),
                    utf8_decode($row['Número o referencia de identificación del contrato']),
                    utf8_decode($this->Generales_model->clear_html_tags($row['Objeto del contrato'])),
                    utf8_decode($this->Generales_model->ruta_descarga_archivos($row['Hipervínculo al contrato firmado'], 'data/contratos/')),
                    utf8_decode($this->Generales_model->ruta_descarga_archivos($row['Hipervínculo al convenio modificatorio, en su caso'], 'data/convenios/')),
                    utf8_decode($row['Monto total del contrato']),
                    utf8_decode($row['Monto pagado al periodo publicado']),
                    utf8_decode($this->Generales_model->clear_date($row['Fecha de inicio'])),
                    utf8_decode($this->Generales_model->clear_date($row['Fecha de término'])),
                    utf8_decode($row['Número de Factura']),
                    utf8_decode($this->Generales_model->ruta_descarga_archivos($row['Hipervínculo a la factura'], 'data/facturas/'))
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }

    function F70FXXIIIB_tabla_10632($path, $namefile) {
        $this->load->model('tpov1/graficas/Tablas_model');
        $this->load->model('tpoadminv1/Generales_model');
        
        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $registros = $this->Tablas_model->F70FXXIIIB_tabla_10632();
        $csv_header = array(
                    utf8_decode('ID Respecto a los proveedores y su contratación (Factura-Orden de compra-Contrato-Proveedor)'),
                    utf8_decode('Razón social'),
                    utf8_decode('Nombre(s)'),
                    utf8_decode('Primer apellido'),
                    utf8_decode('Segundo apellido'),
                    utf8_decode('Nombre(s) de los Proveedores Y/o Responsables'),
                    utf8_decode('Registro Federal de Contribuyente'),
                    utf8_decode('Procedimiento de contratación'),
                    utf8_decode('Fundamento jurídico Del Proceso de Contratación'),
                    utf8_decode('Descripción Breve Del Las Razones Que Justifican')
                );
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if(sizeof($registros) > 0)
        {
            $count = 1;
            foreach ($registros as $row) 
            {
                $csv = array(
                    utf8_decode($row['id_respecto_proveedor']),
                    utf8_decode($row['razon_social']),
                    utf8_decode($row['nombres']),
                    utf8_decode($row['primer_apellido']),
                    utf8_decode($row['segundo_apellido']),
                    utf8_decode($row['nombre_comercial']),
                    utf8_decode($row['rfc']),
                    utf8_decode($row['procedimiento']),
                    utf8_decode($this->Generales_model->clear_html_tags($row['motivo'])),
                    utf8_decode($this->Generales_model->clear_html_tags($row['razones']))
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }

    private function F70FXXIIIC($path, $namefile)   //Formato C
    {

        $this->load->model('tpov1/graficas/Tablas_model');
        $this->load->model('tpoadminv1/Generales_model');
        
        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $registros = $this->Tablas_model->F70FXXIIIC();
        $csv_header = array('#',
                    utf8_decode('Ejercicio'),
                    utf8_decode('Fecha de inicio del periodo que se informa'),
                    utf8_decode('Fecha de término del periodo que se informa'),
                    utf8_decode('Sujeto Obligado'),
                    utf8_decode('Tipo (catálogo)'),
                    utf8_decode('Medio de Comunicación (catálogo)'),
                    utf8_decode('Descripción de Unidad'),
                    utf8_decode('Concepto o Campaña'),
                    utf8_decode('Clave Única de Identificación de Campaña o Aviso Institucional'),
                    utf8_decode('Autoridad Que Proporcionó la Clave Única de Identificación de Campaña o Aviso Institucional'),
                    utf8_decode('Cobertura (catálogo)'),
                    utf8_decode('Ámbito Geográfico de Cobertura'),
                    utf8_decode('Sexo (catálogo)'),
                    utf8_decode('Lugar de Residencia'),
                    utf8_decode('Nivel Educativo'),
                    utf8_decode('Grupo de Edad'),
                    utf8_decode('Nivel socioeconómico'),
                    utf8_decode('Concesionario Responsable de Publicar la Campaña o la Comunicación Correspondiente (razón social)'),
                    utf8_decode('Distintivo y/o Nombre Comercial del Concesionario Responsable de Publicar la Campaña o Comunicación'),
                    utf8_decode('Descripción Breve de las Razones que Justifican la Elección del Proveedor'),
                    utf8_decode('Monto Total del Tiempo de Estado o Tiempo Fiscal Consumidos'),
                    utf8_decode('Área administrativa Encargada de Solicitar la Difusión del Mensaje o Producto'),
                    utf8_decode('Fecha de Inicio de Difusión del Concepto o Campaña'),
                    utf8_decode('Fecha de Término de Difusión del Concepto o Campaña'),
                    utf8_decode('Número de Factura'),
                    utf8_decode('Área(s) Responsable(s) Que Genera(n), Posee(n), Publica(n) y Actualizan la Información'),
                    utf8_decode('Fecha de Validación'),
                    utf8_decode('Fecha de actualización'),
                    utf8_decode('Nota'));
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if(sizeof($registros) > 0)
        {
            $count = 1;
            foreach ($registros as $row) 
            {
                $csv = array(
                    utf8_decode($count),
                    utf8_decode($row['ejercicio']),
                    utf8_decode($this->Generales_model->set_fecha_termino_trimestre($row['id_trimestre'], $row['ejercicio'], true)),
                    utf8_decode($this->Generales_model->set_fecha_termino_trimestre($row['id_trimestre'], $row['ejercicio'], false)),
                    utf8_decode($row['nombre_sujeto_obligado']),
                    utf8_decode($row['id_campana_tipoTO']),
                    utf8_decode($row['id_servicio_categoria']),
                    utf8_decode($row['id_servicio_unidad']),
                    utf8_decode($row['nombre_campana_aviso']),
                    utf8_decode($row['clave_campana']),
                    utf8_decode($row['autoridad']),
                    utf8_decode($row['id_campana_cobertura']),
                    utf8_decode($row['campana_ambito_geo']),
                    utf8_decode($row['sexo']),
                    utf8_decode($row['lugar']),
                    utf8_decode($row['educacion']),
                    utf8_decode($row['grupo_edad']),
                    utf8_decode($row['nivel_socioeconomico']),
                    utf8_decode($row['razon_social']),
                    utf8_decode($row['nombre_comercial']),
                    utf8_decode($this->Generales_model->clear_html_tags($row['razones'])),
					utf8_decode($row['monto_tiempo']),
                    utf8_decode($row['Area 2']),
                    utf8_decode($row['fecha_inicio']),
                    utf8_decode($row['fecha_termino']),
                    utf8_decode($row['numero_factura']),
                    utf8_decode($row['Area 1']),
                    utf8_decode($this->Generales_model->clear_date($row['fecha_validacion'])),
                    utf8_decode($this->Generales_model->clear_date($row['fecha_actualizacion'])),
                    utf8_decode($this->Generales_model->clear_html_tags($row['nota']))
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
     }
	
     function F70FXXIIIC_tabla_333914($path, $namefile) {
        $this->load->model('tpov1/graficas/Tablas_model');
        $this->load->model('tpoadminv1/Generales_model');
        
        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $registros = $this->Tablas_model->F70FXXIIIC_tabla_333914();
        $csv_header = array(
                    utf8_decode('ID Respecto a los recursos y el presupuesto (Periodo-Partida)'),
                    utf8_decode('Denominación de Cada Partida'),
                    utf8_decode('Presupuesto Total Asignado a Cada Partida'),
                    utf8_decode('Presupuesto Ejercido Al Periodo Reportado de Cada Partida')
                );
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if(sizeof($registros) > 0)
        {
            $count = 1;
            foreach ($registros as $row) 
            {
                $csv = array(
                    utf8_decode($row['id_respecto_presupuesto']),
                    utf8_decode($row['Denominación de cada partida']),
                    utf8_decode($row['Presupuesto total asignado a cada partida']),
                    utf8_decode($row['Presupuesto ejercido al periodo'])
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }
	
    private function F70FXXIIID($path, $namefile)   //Formato D
    {

        $this->load->model('tpov1/graficas/Tablas_model');
        $this->load->model('tpoadminv1/Generales_model');
        
        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $registros = $this->Tablas_model->F70FXXIIID();
        $csv_header = array('#',
                    utf8_decode('Ejercicio'),
                    utf8_decode('Fecha de inicio del periodo que se informa'),
                    utf8_decode('Fecha de término del periodo que se informa'),
					utf8_decode('Mensaje'),
                    utf8_decode('Hipervínculo Que Dirija a La Información Relativa a La Utilización de Los Tiempos Oficiales'),
                    utf8_decode('Área(s) Responsable(s) Que Genera(n), Posee(n), Publica(n) y Actualizan la Información'),
                    utf8_decode('Fecha de Validación'),
                    utf8_decode('Fecha de actualización'),
                    utf8_decode('Nota'));
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if(sizeof($registros) > 0)
        {
            $count = 1;
            foreach ($registros as $row) 
            {
                $csv = array(
                    utf8_decode($count),
                    utf8_decode($row['ejercicio']),
                    utf8_decode($this->Generales_model->set_fecha_termino_trimestre($row['id_trimestre'], $row['ejercicio'], true)),
                    utf8_decode($this->Generales_model->set_fecha_termino_trimestre($row['id_trimestre'], $row['ejercicio'], false)),
					utf8_decode($this->Generales_model->clear_html_tags($row['mensajeTO'])),
                    utf8_decode($row['publicacion_segob']),
                    utf8_decode($row['area_responsable']),
                    utf8_decode($this->Generales_model->clear_date($row['fecha_validacion'])),
                    utf8_decode($this->Generales_model->clear_date($row['fecha_actualizacion'])),
                    utf8_decode($this->Generales_model->clear_html_tags($row['nota']))
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
     }
	
	private function getDateTimeMD5( $filename ) {  
        $file = FCPATH . 'data/archivos/' . $filename . '.csv';
        if (file_exists($file)) {
           $outstr = 'Archivo: ' . $filename . '.csv  Generado: ' . 
                     date("d/m/Y H:i:s", time()) . ' MD5=' .  md5_file ( $file ) . ': ';
        } else {
           $outstr = 'Archivo: ' . $filename . '.csv: \r\n';
        }
        return $outstr;
    }

    private function leemePorProveedor() {
        return "TPO Ver 2.0\n" .
               "A continuación se detalla la exportación de la opción \"Gasto por proveedor\", " . 
               "del sitio " . base_url() . "index.php/tpov1/proveedores" .  
               ", relacionandose los archivos por medio de los ID's. \n\n" .
        $this->leemeGastoProveedores(). "\n\n".
        $this->leemeOCProveedores(). "\n\n".
        $this->leemeContratos(). "\n\n";
    }

    private function leemeGastoProveedores () {
        return $this->getDateTimeMD5( 'gasto_x_proveedor' ) . "Gasto x Proveedor \r\n
        ID de proveedor\r\n
        Personalidad jurídica\r\n
        Nombre o razón social\r\n
        Nombre comercial\r\n
        R.F.C.\r\n
        Monto total pagado\r\n
        Estatus\r\n";
    }

    private function leemeOCProveedores () {
        return $this->getDateTimeMD5( 'oc_x_proveedor' ) . "Órdenes de compra x Proveedor \r\n
        Orden de compra \r\n
        ID de proveedor\r\n
        Procedimiento\r\n
        Número de contrato\r\n
        Ejercicio\r\n
        Trimestre\r\n
        Sujeto obligado ordenante\r\n
        Campaña o aviso institucional\r\n
        Sujeto obligado solicitante\r\n
        Justificación\r\n
        Fecha de orden\r\n
        Archivo de la orden de compra en PDF\r\n
        Estatus\r\n";
    }

    private function leemeContratos() {
        return $this->getDateTimeMD5( 'contratos' ) . "Contratos\r\n
        Número de contrato\r\n
        Procedimiento\r\n
        Proveedor\r\n
        Ejercicio\r\n
        Trimestre\r\n
        Contratante\r\n
        Solicitante\r\n
        Objeto del contrato\r\n
        Descripción\r\n
        Fundamento jurídico\r\n
        Fecha celebración\r\n
        Fecha inicio\r\n
        Fecha fin\r\n
        Monto original del contrato\r\n
        Monto modificado\r\n
        Monto total\r\n
        Monto pagado a la fecha\r\n
        Archivo contrato en PDF (Vinculo al archivo)\r\n
        Estatus\r\n";
    }
  
    private function leemePresupuestos() {
        return "TPO Ver 2.0\n" .
               "A continuación se detalla la exportación de la opción \"Presupuesto\", " . 
               "del sitio " . base_url() .  
               ", relacionandose los archivos por medio de los ID's. \n\n" .
        $this->leemePresupuesto(). "\n\n".
        $this->leemeDesglosePartidas(). "\n\n";
     }

    private function leemePresupuesto () {
        return $this->getDateTimeMD5( 'presupuestos' ) . "Presupuesto \r\n
        ID de presupuesto\r\n
        Ejercicio\r\n
        Sujeto obligado\r\n
        Presupuesto original\r\n
        Monto modificado\r\n
        Presupuesto modificado\r\n
        Programa Anual\r\n
        Estatus\r\n";
    }

    private function leemeGastoPorServicio() {
        return "TPO Ver 2.0\n" .
               "A continuación se detalla la exportación de la opción \"Gasto por tipo de servicio\", " . 
               "del sitio " . base_url() .  
               ", relacionandose los archivos por medio de los ID's. \n\n" .
        $this->leemeFacturas() . "\n\n" .
        $this->leemeDetalleFacturas() . "\n\n";      
     }

     private function leemeFacturas() {
        return $this->getDateTimeMD5( 'facturas' ) . "Facturas\r\n
        ID (Número de factura)\r\n
        Proveedor\r\n
        Contrato\r\n
        Orden\r\n
        Ejercicio\r\n
        Trimestre\r\n
        Monto\r\n
        Archivo factura en PDF (Vínculo al archivo)\r\n
        Archivo factura en XML (Vínculo al archivo)\r\n
        Fecha de erogación\r\n
        Estatus\r\n";
     }

     private function leemeDetalleFacturas() {
        return $this->getDateTimeMD5( 'facturas_detalle' ) . "Detalle de Facturas\r\n
        ID de subconcepto \r\n
        ID (Número de factura)\r\n
        Campaña o aviso institucional\r\n
        Nombre de la campaña o aviso\r\n
        Clasificación del servicio\r\n
        Categoría del servicio\r\n
        Subcategoría del servicio\r\n
        Unidad\r\n
        Sujeto obligado contratante\r\n
        Partida contratante\r\n
        Sujeto obligado solicitante\r\n
        Partida solicitante\r\n
        Área administrativa solicitante\r\n
        Descripción del servicio o producto adquirido\r\n
        Cantidad\r\n
        Precio unitario con I.V.A incluido\r\n
        Monto\r\n
        Estatus\r\n";
     }

     private function leemeContratosyOrdenes() {
        return "TPO Ver 2.0\n" .
               "A continuación se detalla la exportación de la opción \"Contratos y órdenes de compra\", " . 
               "del sitio " . base_url() .  
               ", relacionandose los archivos por medio de los ID's. \n\n" .
        $this->leemeContratos(). "\n\n".
        $this->leemeConvenios(). "\n\n".
        $this->leemeOrdenCompra() . "\n\n";
     } 

     private function leemeOrdenCompra() {
        return $this->getDateTimeMD5( 'orden_compra' ) ."Orden de compra \r\n
        ID (Orden de compra)\r\n
        Proveedor\r\n
        Procedimiento\r\n
        Contrato\r\n
        Ejercicio\r\n
        Trimestre\r\n
        Sujeto obligado ordenante\r\n
        Campaña o aviso institucional\r\n   
        Sujeto obligado solicitante\r\n
        Justificación\r\n
        Fecha de orden\r\n
        Archivo de la orden de compra en PDF (Vínculo al documento)\r\n
        Estatus\r\n";   
    }

     private function leemeConvenios() {
        return $this->getDateTimeMD5( 'convenios' ) ."Convenio modificatorio\r\n
        ID (Número de convenio modificatorio)\r\n
        ID (Número de contrato)\r\n
        Ejercicio\r\n
        Trimestre\r\n
        Objeto\r\n
        Fundamento jurídico\r\n
        Fecha celebración\r\n
        Monto\r\n
        Archivo convenio en PDF (Vinculo al archivo)\r\n
        Estatus\r\n";
    }

     private function leemeSO() {
        return "TPO Ver 2.0\n" .
               "A continuación se detalla la exportación de la opción \"Sujetos obligados\", " . 
               "del sitio " . base_url() .  
               ", relacionandose los archivos por medio de los ID's. \n\n" .
        $this->leemeSujetosObligados() . "\n\n" .
        $this->leemeOrdenCompra() . "\r\n\r\n".
        $this->leemeContratos(). "\r\n\r\n".
        $this->leemeConvenios(). "\r\n\r\n";
    }

    private function leemeSujetosObligados () {
        return $this->getDateTimeMD5( 'sujetos_obligados' ) . "Detalle del sujeto obligado \r\n
        ID de S.O.\r\n
        Función\r\n
        Orden (Federal, Estatal, Municipal)\r\n
        Estado\r\n
        Nombre\r\n
        Siglas\r\n
        URL de página\r\n";
    }   
    
    private function leemeErogaciones() {
        return "TPO Ver 2.0\n" .
               "A continuación se detalla la exportación de la opción \"Erogaciones\", " . 
               "del sitio " . base_url() .  
               ", relacionandose los archivos por medio de los ID's. \n\n" .
        $this->leemeFacturas() . "\n\n" .
        $this->leemeDetalleFacturas() . "\n\n";      
    } 

    private function leemeDesglosePartidas () {
        return $this->getDateTimeMD5( 'desglosepartidas' ) . "Desglose de partidas \r\n
        ID de desglose\r\n
        ID de presupuesto\r\n
        Partida presupuestal\r\n
        Monto asignado\r\n
        Monto de modificación\r\n
        Estado\r\n";
    }

    private function leemeInicio() {
        return "TPO Ver 2.0\r\n" .
               "A continuación se detalla la exportación de la opción \"Inicio\", " . 
               "del sitio " . base_url() .  
               ", relacionandose los archivos por medio de los ID's. \r\n\r\n" .
        $this->leemeFacturas() . "\r\n\r\n" .
        $this->leemeDetalleFacturas() . "\r\n\r\n".
        $this->leemeOrdenCompra() . "\r\n\r\n".
        $this->leemeContratos(). "\r\n\r\n".
        $this->leemeCampanasyAvisos(). "\n\n".
        $this->leemeCampanasyAvisosEdad(). "\n\n".
        $this->leemeCampanasyAvisosLugar(). "\n\n".
        $this->leemeCampanasyAvisosSocioeconomico(). "\n\n".
        $this->leemeCampanasyAvisosEducacion(). "\n\n".
        $this->leemeCampanasyAvisosSexo(). "\n\n".
        $this->leemeCampanaAudios(). "\n\n".
        $this->leemeCampanaVideo(). "\n\n".
        $this->leemeCampanaImagenes(). "\n\n".
        $this->leemeConvenios(). "\r\n\r\n".
        $this->leemePresupuesto(). "\n\n".
        $this->leemeDesglosePartidas(). "\n\n".
        $this->leemeProveedores(). "\n\n";     
    }

    private function leemeProveedores () {
        return $this->getDateTimeMD5( 'proveedores' ) . "Proveedores \r\n
        ID\r\n
        Personalidad jurídica\r\n
        Nombre o razón social\r\n
        Nombre comercial\r\n
        R.F.C.\r\n
        Estatus\r\n";
    }

    private function leemePNT() {
        return "TPO Ver 2.0\n" .
               "A continuación se detalla la exportación de la opción \"PNT\", " . 
               "del sitio " . base_url() .  
               ", relacionandose los archivos por medio de los ID's. \n\n" .
        $this->leemeF70FXXIIIA(). "\n\n".
        $this->leemeF70FXXIIIB(). "\n\n".
        $this->leemeF70FXXIIIB_tabla_10632(). "\n\n".
        $this->leemeF70FXXIIIB_tabla_10633(). "\n\n".
        $this->leemeF70FXXIIIB_tabla_10656(). "\n\n".
		$this->leemeF70FXXIIIC(). "\n\n".
		$this->leemeF70FXXIIIC_tabla_333914(). "\n\n".
		$this->leemeF70FXXIIID(). "\n\n";
    }

    private function leemeF70FXXIIIA() {
        return $this->getDateTimeMD5( 'F70FXXIIIA' ) . "F70FXXIIIA\r\n
        Ejercicio\r\n
        Denominación del documento\r\n
        Fecha de publicación en el DOF\r\n
        Hipervínculo al documento\r\n
        Fecha de validación\r\n
        Área responsable de la información\r\n
        Año\r\n
        Fecha de actualización\r\n
        Nota\r\n";
    }

    private function leemeF70FXXIIIB() {
        return $this->getDateTimeMD5( 'F70FXXIIIB' ) . "F70FXXIIIB\r\n
        Función del sujeto obligado\r\n
        Función del sujeto obligado\r\n
        Área administrativa encargada de solicitar el servicio\r\n
        Clasificación de los servicios\r\n
        Ejercicio\r\n
        Periodo que se informa\r\n
        Tipo de servicio\r\n
        Tipo de medio\r\n
        Descripción de unidad\r\n
        Tipo: Campaña o aviso institucional\r\n
        Nombre de la campaña o Aviso Institucional\r\n
        Año de la campaña\r\n
        Tema de la campaña o aviso institucional\r\n
        Objetivo institucional\r\n
        Objetivo de comunicación\r\n
        Costo por unidad\r\n
        Clave única de identificación de campaña\r\n
        Autoridad que proporcionó la clave\r\n
        Cobertura\r\n
        Ámbito geográfico de cobertura\r\n
        Fecha de inicio de la campaña o aviso\r\n
        Fecha de término de los servicios contratados\r\n
        Sexo\r\n
        Lugar de residencia\r\n
        Nivel educativo\r\n
        Grupo de edad\r\n
        Nivel socioeconómico\r\n
        Respecto a los proveedores y su contratación (Factura-Orden de compra-Contrato-Proveedor)\r\n
        Respecto a los recursos y el presupuesto (Factura-Orden de compra-Contrato-Proveedor)\r\n
        Respecto al contrato y los montos (Factura-Orden de compra-Contrato-Proveedor)\r\n
        Fecha de validación\r\n
        Área responsable de la información\r\n
        Año\r\n
        Fecha de actualización\r\n
        Nota\r\n";
    }

    private function leemeF70FXXIIIB_tabla_10633() {
        return $this->getDateTimeMD5( 'F70FXXIIIB_tabla_10633' ) . "F70FXXIIIB_tabla_10633\r\n
        ID Respecto a los recursos y el presupuesto (Factura-Orden de compra-Contrato-Proveedor\r\n
        Partida genérica\r\n
        Clave del concepto\r\n
        Presupuesto asignado por concepto\r\n
        Presupuesto modificado por concepto\r\n
        Presupuesto total ejercido por concepto\r\n
        Denominación de cada partida\r\n
        Presupuesto total asignado a cada partida\r\n
        Presupuesto modificado por partida\r\n
        Presupuesto ejercido al periodo\r\n";           
    }

    private function leemeF70FXXIIIB_tabla_10656() {
        return $this->getDateTimeMD5( 'F70FXXIIIB_tabla_10656' ) . "F70FXXIIIB_tabla_10656\r\n
        ID Respecto al contrato y los montos (Factura-Orden de compra-Contrato-Proveedor)\r\n
        Fecha de firma de contrato\r\n
        Número o referencia de identificación del contrato\r\n
        Objeto del contrato\r\n
        Hipervínculo al contrato firmado\r\n
        Hipervínculo al convenio modificatorio, en su caso\r\n
        Monto total del contrato\r\n
        Monto pagado al periodo publicado\r\n
        Fecha de inicio\r\n
        Fecha de término\r\n
        Número de Factura\r\n
        Hipervínculo a la factura\r\n";      
    }

    private function leemeF70FXXIIIB_tabla_10632() {
        return $this->getDateTimeMD5( 'F70FXXIIIB_tabla_10632' ) . "F70FXXIIIB_tabla_10632\r\n
        ID Respecto a los proveedores y su contratación (Factura-Orden de compra-Contrato-Proveedor)\r\n
        Razón social\r\n
        Nombre (s)\r\n
        Primer apellido\r\n
        Segundo apellido\r\n
        Registro Federal de Contribuyentes\r\n
        Procedimiento de contratación:\r\n
        Fundamento jurídico\r\n
        Razones que justifican la elección\r\n
        Nombre comercial\r\n";
    }

    private function leemeF70FXXIIIC() {
        return $this->getDateTimeMD5( 'F70FXXIIIC' ) . "F70FXXIIIC\r\n
        Ejercicio\r\n
        Denominación del documento\r\n
        Fecha de publicación en el DOF\r\n
        Hipervínculo al documento\r\n
        Fecha de validación\r\n
        Área responsable de la información\r\n
        Año\r\n
        Fecha de actualización\r\n
        Nota\r\n";
    }

    private function leemeF70FXXIIIC_tabla_333914() {
        return $this->getDateTimeMD5( 'F70FXXIIIC_tabla_333914' ) . "F70FXXIIIC_tabla_333914\r\n
        Ejercicio\r\n
        Denominación del documento\r\n
        Fecha de publicación en el DOF\r\n
        Hipervínculo al documento\r\n
        Fecha de validación\r\n
        Área responsable de la información\r\n
        Año\r\n
        Fecha de actualización\r\n
        Nota\r\n";
    }
	
	private function leemeF70FXXIIID() {
        return $this->getDateTimeMD5( 'F70FXXIIID' ) . "F70FXXIIID\r\n
        Ejercicio\r\n
        Denominación del documento\r\n
        Fecha de publicación en el DOF\r\n
        Hipervínculo al documento\r\n
        Fecha de validación\r\n
        Área responsable de la información\r\n
        Año\r\n
        Fecha de actualización\r\n
        Nota\r\n";
    }
	
    //CAMPANAS Y AVISOS

    function campanas(){

        $file_videos = $this->crear_archivo_videos('data/', 'campanasyavisos_videos.csv');
        $file_socioeconomicos = $this->crear_archivo_socioeconomicos('data/', 'campanasyavisos_socioeconomicos.csv');
        $file_campanasyavisos = $this->crear_archivo_campanasyavisos('data/', 'campanasyavisos.csv');
        $file_sexo = $this->crear_archivo_sexo('data/', 'campanasyavisos_sexo.csv');
        $file_lugar = $this->crear_archivo_lugar('data/', 'campanasyavisos_lugar.csv');
        $file_imagenes = $this->crear_archivo_imagenes('data/', 'campanasyavisos_imagenes.csv');
        $file_educacion = $this->crear_archivo_educacion('data/', 'campanasyavisos_educacion.csv');
        $file_edad = $this->crear_archivo_edad('data/', 'campanasyavisos_edad.csv');
        $file_audios = $this->crear_archivo_audios('data/', 'campanasyavisos_audios.csv');
        
        //$files =array($file_videos, $file_socioeconomicos, $file_sexo, $file_lugar, $file_imagenes, $file_educacion, $file_edad, $file_audios, $file_campanasyavisos);
               

        $files =array($file_videos,$file_socioeconomicos, $file_campanasyavisos, $file_sexo, $file_lugar, $file_imagenes, $file_educacion, $file_edad, $file_audios);

        $leemefile = 'leeme.txt';
    
        $leemetexto = $this->leemeCampanaAviso();
        $this->creaZip($leemefile, $leemetexto, $files, "data/CampanasyAvisosData.zip");

        $urlfilename = base_url() . "data/CampanasyAvisosData.zip"; 

        sleep( 1 );
        header('Content-type: application/json');
        echo json_encode( $urlfilename );

    }


    function crear_archivo_videos($path, $namefile)
    {
        $this->load->model('tpoadminv1/campanas/Campana_model');
        $this->load->model('tpoadminv1/Generales_model');
        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $query = $this->db->get('rel_campana_mvideo');

        $csv_header = array('#',
                    utf8_decode('Campaña / Aviso institucional'),
                    utf8_decode('Tipo liga'),
                    utf8_decode('Nombre del vídeo'),
                    utf8_decode('URL del vídeo')
        );
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if($query->num_rows() > 0)
        {
            $count = 1;
            foreach ($query->result_array() as $row) 
            {
                $csv = array(
                    utf8_decode($count),
                    utf8_decode($this->Campana_model->dame_nombre_campana($row['id_campana_aviso'])),
                    utf8_decode($this->Campana_model->dame_nombre_liga($row['id_tipo_liga'])),
                    utf8_decode($row['nombre_campana_mvideo']),
                    utf8_decode($row['url_video']),
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }

    function crear_archivo_socioeconomicos($path, $namefile)
    {
        $this->load->model('tpoadminv1/campanas/Campana_model');
        $this->load->model('tpoadminv1/Generales_model');
        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $query = $this->db->get('rel_campana_nivel');

        $csv_header = array('#',
                    utf8_decode('Campaña/Aviso institucional'),
                    utf8_decode('Nivel Socioeconómico'),
        );
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if($query->num_rows() > 0)
        {
            $count = 1;
            foreach ($query->result_array() as $row) 
            {
                $csv = array(
                    //utf8_decode($count),
                    utf8_decode($row['id_rel_campana_nivel']),
                    utf8_decode($this->Campana_model->dame_nombre_campana($row['id_campana_aviso'])),
                    utf8_decode($this->Campana_model->dame_nombre_nivel($row['id_poblacion_nivel'])),
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }


    function crear_archivo_sexo($path, $namefile)
    {
        $this->load->model('tpoadminv1/campanas/Campana_model');
        $this->load->model('tpoadminv1/Generales_model');
        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $query = $this->db->get('rel_campana_sexo');

        $csv_header = array('#',
                    utf8_decode('Campaña/Aviso institucional'),
                    utf8_decode('Población sexo'),
        );
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if($query->num_rows() > 0)
        {
            $count = 1;
            foreach ($query->result_array() as $row) 
            {
                $csv = array(
                    //utf8_decode($count),
                    utf8_decode($row['id_rel_campana_sexo']),
                    utf8_decode($this->Campana_model->dame_nombre_campana($row['id_campana_aviso'])),
                    utf8_decode($this->Campana_model->dame_nombre_sexo($row['id_poblacion_sexo'])),
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }

    function crear_archivo_lugar($path, $namefile)
    {
        $this->load->model('tpoadminv1/campanas/Campana_model');
        $this->load->model('tpoadminv1/Generales_model');
        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $query = $this->db->get('rel_campana_lugar');

        $csv_header = array('#',
                    utf8_decode('Campaña/Aviso institucional'),
                    utf8_decode('Población lugar'),
        );
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if($query->num_rows() > 0)
        {
            $count = 1;
            foreach ($query->result_array() as $row) 
            {
                $csv = array(
                    //utf8_decode($count),
                    utf8_decode($row['id_campana_lugar']),
                    utf8_decode($this->Campana_model->dame_nombre_campana($row['id_campana_aviso'])),
                    utf8_decode($row['poblacion_lugar']),
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }

    function crear_archivo_imagenes($path, $namefile)
    {
        $this->load->model('tpoadminv1/campanas/Campana_model');
        $this->load->model('tpoadminv1/Generales_model');
        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $query = $this->db->get('rel_campana_mimagenes');

        $csv_header = array('#',
                    utf8_decode('Campaña / Aviso institucional'),
                    utf8_decode('Tipo liga'),
                    utf8_decode('Nombre de la imagen'),
                    utf8_decode('URL de la imagen')
        );
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if($query->num_rows() > 0)
        {
            $count = 1;
            foreach ($query->result_array() as $row) 
            {
                $csv = array(
                    utf8_decode($count),
                    utf8_decode($this->Campana_model->dame_nombre_campana($row['id_campana_aviso'])),
                    utf8_decode($this->Campana_model->dame_nombre_liga($row['id_tipo_liga'])),
                    utf8_decode($row['nombre_campana_mimagen']),
                    utf8_decode($row['url_imagen']),
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }

    function crear_archivo_educacion($path, $namefile)
    {
        $this->load->model('tpoadminv1/campanas/Campana_model');
        $this->load->model('tpoadminv1/Generales_model');
        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $query = $this->db->get('rel_campana_nivel_educativo');

        $csv_header = array('#',
                    utf8_decode('Campaña/Aviso institucional'),
                    utf8_decode('Nivel educativo'),
        );
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if($query->num_rows() > 0)
        {
            $count = 1;
            foreach ($query->result_array() as $row) 
            {
                $csv = array(
                    //utf8_decode($count),
                    utf8_decode($row['id_rel_campana_nivel_educativo']),
                    utf8_decode($this->Campana_model->dame_nombre_campana($row['id_campana_aviso'])),
                    utf8_decode($this->Campana_model->dame_nombre_nivel_educativo($row['id_poblacion_nivel_educativo'])),
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }

    function crear_archivo_edad($path, $namefile)
    {
        $this->load->model('tpoadminv1/campanas/Campana_model');
        $this->load->model('tpoadminv1/Generales_model');
        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $query = $this->db->get('rel_campana_grupo_edad');

        $csv_header = array('#',
                    utf8_decode('Campaña/Aviso institucional'),
                    utf8_decode('Población grupo edad'),
        );
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if($query->num_rows() > 0)
        {
            $count = 1;
            foreach ($query->result_array() as $row) 
            {
                $csv = array(
                    //utf8_decode($count),
                    utf8_decode($row['id_rel_campana_grupo_edad']),
                    utf8_decode($this->Campana_model->dame_nombre_campana($row['id_campana_aviso'])),
                    utf8_decode($this->Campana_model->dame_nombre_grupo_edad($row['id_poblacion_grupo_edad'])),
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }

    function crear_archivo_audios($path, $namefile)
    {
        $this->load->model('tpoadminv1/campanas/Campana_model');
        $this->load->model('tpoadminv1/Generales_model');
        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $query = $this->db->get('rel_campana_maudio');

        $csv_header = array('#',
                    utf8_decode('Campaña / Aviso institucional'),
                    utf8_decode('Tipo liga'),
                    utf8_decode('Nombre del audio'),
                    utf8_decode('URL del audio')
        );
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if($query->num_rows() > 0)
        {
            $count = 1;
            foreach ($query->result_array() as $row) 
            {
                $csv = array(
                    utf8_decode($count),
                    utf8_decode($this->Campana_model->dame_nombre_campana($row['id_campana_aviso'])),
                    utf8_decode($this->Campana_model->dame_nombre_liga($row['id_tipo_liga'])),
                    utf8_decode($row['nombre_campana_maudio']),
                    utf8_decode($row['url_audio']),
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }


    function crear_archivo_campanasyavisos($path, $namefile)
    {
        $this->load->model('tpoadminv1/campanas/Campana_model');
        $this->load->model('tpoadminv1/Generales_model');
        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $query = $this->db->get('tab_campana_aviso');

        $csv_header = array('#',
                    utf8_decode('Cobertura'),
                    utf8_decode('Tipo'),
                    utf8_decode('Subtipo'),
                    utf8_decode('Tema'),
                    utf8_decode('Objetivo'),
                    utf8_decode('Ejercicio'),
                    utf8_decode('Trimestre'),
                    utf8_decode('Sujeto obligado contratante'),
                    utf8_decode('Sujeto obligado solicitante'),
                    utf8_decode('Tiempo oficial'),
                    utf8_decode('Nombre'),
                    utf8_decode('Objetivo comunicación'),
                    utf8_decode('Fecha inicio'),
                    utf8_decode('Fecha termino'),
                    utf8_decode('Fecha inicio tiempo oficial'),
                    utf8_decode('Fecha termino tiempo oficial'),
                    utf8_decode('Publicación SEGOB'),
                    utf8_decode('Ámbito geográfico'),
                    utf8_decode('Documento PACS'),
                    utf8_decode('Fecha de publicación'),
                    utf8_decode('Evaluación'),
                    utf8_decode('Documento de evaluación'),
                    utf8_decode('Fecha de validación'),
                    utf8_decode('Área responsable'),
                    utf8_decode('Período'),
                    utf8_decode('Fecha de actualización'),
                    utf8_decode('Nota'),
                    utf8_decode('Autoridad'),
                    utf8_decode('Clave campana'),
                    utf8_decode('Estatus'),
        );
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if($query->num_rows() > 0)
        {
            $count = 1;
            foreach ($query->result_array() as $row) 
            {
                $csv = array(
                    //utf8_decode($count),
                    utf8_decode($row['id_campana_aviso']),
                    utf8_decode($this->Campana_model->dame_cobertura_nombre($row['id_campana_cobertura'])),
                    utf8_decode($this->Campana_model->dame_camp_tipo_nombre($row['id_campana_tipo'])),
                    utf8_decode($this->Campana_model->dame_camp_subtipo_nombre($row['id_campana_subtipo'])),
                    utf8_decode($this->Campana_model->dame_tema_nombre($row['id_campana_tema'])),
                    utf8_decode($this->Campana_model->dame_objetivo_nombre($row['id_campana_objetivo'])),
                    utf8_decode($this->Campana_model->dame_ejercicio_nombre($row['id_ejercicio'])),
                    utf8_decode($this->Campana_model->dame_trimestre_nombre($row['id_trimestre'])),
                    utf8_decode($this->Campana_model->dame_nombre_contratante($row['id_so_contratante'])),
                    utf8_decode($this->Campana_model->dame_nombre_solicitante($row['id_so_solicitante'])),
                    utf8_decode($this->Campana_model->dame_tiempo_oficial_nombre($row['id_tiempo_oficial'])),
                    utf8_decode($row['nombre_campana_aviso']),
                    utf8_decode($this->Generales_model->clear_html_tags($row['objetivo_comunicacion'])),
                    utf8_decode($row['fecha_inicio']),
                    utf8_decode($row['fecha_termino']),
                    utf8_decode($row['fecha_inicio_to']),
                    utf8_decode($row['fecha_termino_to']),
                    utf8_decode($row['publicacion_segob']),
                    utf8_decode($row['campana_ambito_geo']),
                    utf8_decode($this->Campana_model->dame_docs_nombre($row['id_presupuesto'])),
                    utf8_decode($row['fecha_dof']),
                    utf8_decode($this->Generales_model->clear_html_tags($row['evaluacion'])),
                    utf8_decode($row['evaluacion_documento']),
                    utf8_decode($row['fecha_validacion']),
                    utf8_decode($row['area_responsable']),
                    utf8_decode($row['periodo']),
                    utf8_decode($row['fecha_actualizacion']),
                    utf8_decode($this->Generales_model->clear_html_tags($row['nota'])),
                    utf8_decode($row['autoridad']),
                    utf8_decode($row['clave_campana']),
                    utf8_decode($this->Campana_model->get_estatus_name($row['active'])),
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }

    private function leemeCampanaAviso() {
        return "TPO Ver 2.0\n" .
               "A continuación se detalla la exportación de la opción \"Campañas y avisos institucionales\", " . 
               "del sitio " . base_url() . "index.php/tpov1/campana_aviso" .  
               ", relacionandose los archivos por medio de los ID's. \n\n" .
        $this->leemeCampanasyAvisos(). "\n\n".
        $this->leemeCampanasyAvisosEdad(). "\n\n".
        $this->leemeCampanasyAvisosLugar(). "\n\n".
        $this->leemeCampanasyAvisosSocioeconomico(). "\n\n".
        $this->leemeCampanasyAvisosEducacion(). "\n\n".
        $this->leemeCampanasyAvisosSexo(). "\n\n".
        $this->leemeCampanaAudios(). "\n\n".
        $this->leemeCampanaVideo(). "\n\n".
        $this->leemeCampanaImagenes(). "\n\n";
    }

    private function leemeCampanasyAvisos () {
        return $this->getDateTimeMD5( 'campanasyavisos' ) . "Campañas y avisos institucionales\r\n
        ID de campaña o aviso institucional\r\n
        Tipo\r\n
        Subtipo\r\n
        Nombre\r\n
        Ejercicio\r\n
        Trimestre\r\n
        Sujeto obligado contratante\r\n
        Sujeto obligado solicitante\r\n
        Tema\r\n
        Objetivo institucional\r\n
        Objetivo de comunicación\r\n
        Cobertura\r\n
        Ámbito geográfico\r\n
        Fecha inicio\r\n
        Fecha término\r\n
        Tiempo oficial\r\n
        Fecha inicio tiempo oficial\r\n
        Fecha término tiempo oficial\r\n
        Publicación SEGOB.\r\n
        Documento del PACS\r\n
        Fecha publicación\r\n
        Estatus\r\n";
    }
    
    private function leemeCampanaAudios() {
        return $this->getDateTimeMD5( 'campanasyavisos_audios' ) . "Audios \r\n
        ID de audio\r\n
        ID de campaña o aviso institucional\r\n
        Audios (Vínculo al archivo)\r\n
        Audios (Vínculo al archivo)\r\n";
    }

    private function leemeCampanaImagenes() {
        return $this->getDateTimeMD5( 'campanasyavisos_imagenes' ) . "Imágenes \r\n
        ID de imagen\r\n
        ID de campaña o aviso institucional\r\n
        Imágenes (Vínculo al archivo)\r\n
        Imágenes (Vínculo al archivo)\r\n";
    }

    private function leemeCampanaVideo() {
        return $this->getDateTimeMD5( 'campanasyavisos_videos' ) . "Videos \r\n
        ID de videos\r\n
        ID de campaña o aviso institucional\r\n
        Videos (Vínculo al archivo)\r\n
        Videos (Vínculo al archivo)\r\n";
    }

    private function leemeCampanasyAvisosEdad () {
        return $this->getDateTimeMD5( 'campanasyavisos_edad' ) . "Grupo de edad \r\n
        ID de grupo de edad\r\n
        ID de campaña o aviso institucional\r\n";
    }

    private function leemeCampanasyAvisosLugar () {
        return $this->getDateTimeMD5( 'campanasyavisos_lugar' ) . "Lugar\r\n
        ID de lugar\r\n
        ID de campaña o aviso institucional\r\n
        Lugar\r\n";
    }

    private function leemeCampanasyAvisosSocioeconomico () {
        return $this->getDateTimeMD5( 'campanasyavisos_socioeconomico' ) . "Nivel socioeconómico \r\n
        ID de nivel socioeconómico\r\n
        ID de campaña o aviso institucional\r\n
        Nivel socioeconómico\r\n";
    }

    private function leemeCampanasyAvisosEducacion () {
        return $this->getDateTimeMD5( 'campanasyavisos_educacion' ) . "Educación \r\n
        ID de educación\r\n
        ID de campaña o aviso institucional\r\n
        Educación\r\n";
    }

    private function leemeCampanasyAvisosSexo () {
        return $this->getDateTimeMD5( 'campanasyavisos_sexo' ) . "Sexo\r\n
        ID de sexo\r\n
        ID de campaña o aviso institucional\r\n
        Sexo\r\n";
    }

    function campanas_otros_table(){
        $this->load->model('tpov1/campanas_v1/Graficas_model');
        $str = $this->Graficas_model->limpiar_Cadena($this->uri->segment(4));

        $this->crear_archivo_campanas_otros_table('data/archivos/', 'otros_servicios_campanas_avisos.csv', $str);

        $urlfilename = base_url() . "data/archivos/otros_servicios_campanas_avisos.csv"; 
        sleep( 1 );
        header('Content-type: application/json');
        echo json_encode( $urlfilename );  
    }

    function campanas_servicios_table(){
        $this->load->model('tpov1/campanas_v1/Graficas_model');
        $str = $this->Graficas_model->limpiar_Cadena($this->uri->segment(4));

        $this->crear_archivo_campanas_servicios_table('data/archivos/', 'servicios_difusion_campanas_avisos.csv', $str);

        $urlfilename = base_url() . "data/archivos/servicios_difusion_campanas_avisos.csv"; 
        sleep( 1 );
        header('Content-type: application/json');
        echo json_encode( $urlfilename );  
    }

    function campanas_table(){
        $this->crear_archivo_campanas_table('data/archivos/', 'lista_campanas.csv');

        $urlfilename = base_url() . "data/archivos/lista_campanas.csv"; 
        sleep( 1 );
        header('Content-type: application/json');
        echo json_encode( $urlfilename );  
    }
    
    function avisos_table(){
        $this->crear_archivo_avisos_table('data/archivos/', 'lista_avisos.csv');

        $urlfilename = base_url() . "data/archivos/lista_avisos.csv"; 
        sleep( 1 );
        header('Content-type: application/json');
        echo json_encode( $urlfilename );  
    }

    function subconceptos_erogacion_table(){
        $this->load->model('tpov1/graficas/Graficas_model');
        $str = $this->Graficas_model->limpiar_Cadena($this->uri->segment(4));

        $this->crear_archivo_subconceptos_erogacion_table('data/archivos/', 'subconceptos_de_la_erogacion.csv', $str);

        $urlfilename = base_url() . "data/archivos/subconceptos_de_la_erogacion.csv"; 
        sleep( 1 );
        header('Content-type: application/json');
        echo json_encode( $urlfilename );  
    }

    function erogaciones_table(){

        $this->crear_archivo_erogaciones_table('data/archivos/', 'lista_erogaciones.csv');

        $urlfilename = base_url() . "data/archivos/lista_erogaciones.csv"; 
        sleep( 1 );
        header('Content-type: application/json');
        echo json_encode( $urlfilename );
    }

    function so_contratos_table(){

        $this->load->model('tpov1/graficas/Graficas_model');
        $str = $this->Graficas_model->limpiar_Cadena($this->uri->segment(4));

        $this->crear_archivo_so_contratos_table('data/archivos/', 'contratos_asociados_a_sujeto_obligado.csv', $str);

        $urlfilename = base_url() . "data/archivos/contratos_asociados_a_sujeto_obligado.csv"; 
        sleep( 1 );
        header('Content-type: application/json');
        echo json_encode( $urlfilename );  
    }

    function so_ordenes_table(){
        $this->load->model('tpov1/graficas/Graficas_model');
        $str = $this->Graficas_model->limpiar_Cadena($this->uri->segment(4));

        $this->crear_archivo_so_ordenes_table('data/archivos/', 'ordenes_compra_asociadas_a_sujeto_obligado.csv', $str);

        $urlfilename = base_url() . "data/archivos/ordenes_compra_asociadas_a_sujeto_obligado.csv"; 
        sleep( 1 );
        header('Content-type: application/json');
        echo json_encode( $urlfilename );  
    }

    function sujetos_obligados_table(){

        $this->crear_archivo_sujetos_obligados_table('data/archivos/', 'lista_sujetos_obligados.csv');

        $urlfilename = base_url() . "data/archivos/lista_sujetos_obligados.csv"; 
        sleep( 1 );
        header('Content-type: application/json');
        echo json_encode( $urlfilename );  
    }

    function contratos_ordenes_table(){
        $this->load->model('tpov1/graficas/Graficas_model');
        $str = $this->Graficas_model->limpiar_Cadena($this->uri->segment(4));

        $this->crear_archivo_contratos_ordenes_table('data/archivos/', 'ordenes_compra_asociadas_a_contrato.csv',$str);

        $urlfilename = base_url() . "data/archivos/ordenes_compra_asociadas_a_contrato.csv"; 
        sleep( 1 );
        header('Content-type: application/json');
        echo json_encode( $urlfilename ); 
    }

    function contratos_convenios_table(){
        $this->load->model('tpov1/graficas/Graficas_model');
        $str = $this->Graficas_model->limpiar_Cadena($this->uri->segment(4));

        $this->crear_archivo_contratos_convenios_table('data/archivos/', 'convenios_modificatorios_contrato.csv',$str);

        $urlfilename = base_url() . "data/archivos/convenios_modificatorios_contrato.csv"; 
        sleep( 1 );
        header('Content-type: application/json');
        echo json_encode( $urlfilename ); 
    }

    function contratos_servicios_table(){
        $this->load->model('tpov1/graficas/Graficas_model');
        $str = $this->Graficas_model->limpiar_Cadena($this->uri->segment(4));

        $this->crear_archivo_contratos_servicios_table('data/archivos/', 'servicios_difusion_contrato.csv',$str, 1);

        $urlfilename = base_url() . "data/archivos/servicios_difusion_contrato.csv"; 
        sleep( 1 );
        header('Content-type: application/json');
        echo json_encode( $urlfilename ); 
    }

    function contratos_otros_table(){
        $this->load->model('tpov1/graficas/Graficas_model');
        $str = $this->Graficas_model->limpiar_Cadena($this->uri->segment(4));

        $this->crear_archivo_contratos_servicios_table('data/archivos/', 'otros_servicios_difusion_contrato.csv',$str, 2);

        $urlfilename = base_url() . "data/archivos/otros_servicios_difusion_contrato.csv"; 
        sleep( 1 );
        header('Content-type: application/json');
        echo json_encode( $urlfilename ); 
    }

    function ordenes_servicios_table(){
        $this->load->model('tpov1/graficas/Graficas_model');
        $str = $this->Graficas_model->limpiar_Cadena($this->uri->segment(4));

        $this->crear_archivo_ordenes_servicios_table('data/archivos/', 'servicios_difusion_orden_compra.csv',$str, 1);

        $urlfilename = base_url() . "data/archivos/servicios_difusion_orden_compra.csv"; 
        sleep( 1 );
        header('Content-type: application/json');
        echo json_encode( $urlfilename ); 
    }

    function ordenes_otros_table(){
        $this->load->model('tpov1/graficas/Graficas_model');
        $str = $this->Graficas_model->limpiar_Cadena($this->uri->segment(4));

        $this->crear_archivo_ordenes_servicios_table('data/archivos/', 'otros_servicios_difusion_orden_compra.csv',$str, 2);

        $urlfilename = base_url() . "data/archivos/otros_servicios_difusion_orden_compra.csv"; 
        sleep( 1 );
        header('Content-type: application/json');
        echo json_encode( $urlfilename ); 
    }

    function ordenes_table(){
        $this->crear_archivo_ordenes_table('data/archivos/', 'lista_ordenes_compra.csv');

        $urlfilename = base_url() . "data/archivos/lista_ordenes_compra.csv"; 
        sleep( 1 );
        header('Content-type: application/json');
        echo json_encode( $urlfilename ); 
    }

    function contratos_table(){
        $this->crear_archivo_contratos_table('data/archivos/', 'lista_contratos.csv');

        $urlfilename = base_url() . "data/archivos/lista_contratos.csv"; 
        sleep( 1 );
        header('Content-type: application/json');
        echo json_encode( $urlfilename ); 
    }

    function tiposervicios_table(){
        
        $this->crear_archivo_tiposervicios_table('data/archivos/', 'gasto_por_tipo_servicio.csv');

        $urlfilename = base_url() . "data/archivos/gasto_por_tipo_servicio.csv"; 
        sleep( 1 );
        header('Content-type: application/json');
        echo json_encode( $urlfilename ); 
    }

    function contratos_proveedor_table(){
        $this->load->model('tpov1/graficas/Graficas_model');
        $str = $this->Graficas_model->limpiar_Cadena($this->uri->segment(4));
        
        $this->crear_archivo_contratos_proveedor_table('data/archivos/', 'contratos_asociadas_a_proveedor.csv', $str);

        $urlfilename = base_url() . "data/archivos/contratos_asociadas_a_proveedor.csv"; 
        sleep( 1 );
        header('Content-type: application/json');
        echo json_encode( $urlfilename );
    }

    function ordenes_proveedor_table(){
        $this->load->model('tpov1/graficas/Graficas_model');
        $str = $this->Graficas_model->limpiar_Cadena($this->uri->segment(4));
        
        $this->crear_archivo_ordenes_compra_proveedor_table('data/archivos/', 'ordenes_compra_asociadas_a_proveedor.csv', $str);

        $urlfilename = base_url() . "data/archivos/ordenes_compra_asociadas_a_proveedor.csv"; 
        sleep( 1 );
        header('Content-type: application/json');
        echo json_encode( $urlfilename );
    }

    function porproveedores_table(){
        $this->crear_archivo_porproveedores_table('data/archivos/', 'gasto_por_proveedores.csv');

        $urlfilename = base_url() . "data/archivos/gasto_por_proveedores.csv"; 
        sleep( 1 );
        header('Content-type: application/json');
        echo json_encode( $urlfilename );
    }

    function presupuesto_table()
    {
        $this->crear_archivo_presupuestos_table('data/archivos/', 'presupuesto.csv');

        $urlfilename = base_url() . "data/archivos/presupuesto.csv"; 
        sleep( 1 );
        header('Content-type: application/json');
        echo json_encode( $urlfilename );
    }

    private function crear_archivo_campanas_servicios_table($path, $namefile, $id)
    {
        $this->load->model('tpov1/campanas_v1/Graficas_model');

        $registros =  $this->Graficas_model->dame_serv_dif_campana_id($id);

        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $csv_header = array(
            'Ejercicio',
            'Factura',
            'Fecha',
            'Proveedor',
            utf8_decode('Categoría'),
            utf8_decode('Subcategoría'),
            'Tipo',
            utf8_decode('Campaña o aviso'),
            'Monto gastado');

        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if(isset($registros) && !empty($registros) && sizeof($registros) > 0)
        {
            $count = 1;
            foreach ($registros as $row) 
            {
                $csv = array(
                    utf8_decode($row['ejercicio']),
                    utf8_decode($row['factura']),
                    utf8_decode($row['fecha_erogacion']),
                    utf8_decode($row['proveedor']),
                    utf8_decode($row['nombre_servicio_categoria']),
                    utf8_decode($row['nombre_servicio_subcategoria']),
                    utf8_decode($row['tipo']),
                    utf8_decode($row['nombre_campana_aviso']),
                    utf8_decode($row['monto_servicio'])
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }

    private function crear_archivo_campanas_otros_table($path, $namefile, $id){
        
        $this->load->model('tpov1/campanas_v1/Graficas_model');
        
        $registros =  $this->Graficas_model->dame_otros_serv_dif_campana_id($id);

        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $csv_header = array(
            'Ejercicio',
            'Factura',
            'Fecha',
            'Proveedor',
            utf8_decode('Categoría'),
            utf8_decode('Subcategoría'),
            'Tipo',
            utf8_decode('Campaña o aviso'),
            'Monto gastado');

        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if(isset($registros) && !empty($registros) && sizeof($registros) > 0)
        {
            $count = 1;
            foreach ($registros as $row) 
            {
                $csv = array(
                    utf8_decode($row['ejercicio']),
                    utf8_decode($row['factura']),
                    utf8_decode($row['fecha_erogacion']),
                    utf8_decode($row['proveedor']),
                    utf8_decode($row['nombre_servicio_categoria']),
                    utf8_decode($row['nombre_servicio_subcategoria']),
                    utf8_decode($row['tipo']),
                    utf8_decode($row['nombre_campana_aviso']),
                    utf8_decode($row['monto_servicio'])
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }

    private function crear_archivo_campanas_table($path, $namefile){

        $this->load->model('tpov1/campanas_v1/Graficas_model');
        
        $str = $this->Graficas_model->limpiar_Cadena($this->uri->segment(4));
        $ejercicio = $this->Graficas_model->dame_nombre_ejercicio($str); 

        $registros =  $this->Graficas_model->get_desglose_campanas_avisos($ejercicio);

        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $csv_header = array(
            '#',
            'Ejercicio',
            'Trimestre',
            'Tipo',
            utf8_decode('Nombre de la campaña o aviso institucional'),
            'Contratante',
            'Solicitante',
            'Tiempo oficial',
            'Monto total ejercido');

        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if(isset($registros) && !empty($registros) && sizeof($registros) > 0)
        {
            $count = 1;
            foreach ($registros as $row) 
            {
                $csv = array(
                    utf8_decode($row['id']),
                    utf8_decode($row['ejercicio']),
                    utf8_decode($row['trimestre']),
                    utf8_decode($row['nombre_campana_tipo']),
                    utf8_decode($row['nombre_campana_aviso']),
                    utf8_decode($row['contratante']),
                    utf8_decode($row['solicitante']),
                    utf8_decode($row['nombre_tipo_tiempo']),
                    utf8_decode($row['monto_total'])
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }

    private function crear_archivo_avisos_table($path, $namefile){
        $this->load->model('tpov1/campanas_v1/Graficas_model');

        $str = $this->Graficas_model->limpiar_Cadena($this->uri->segment(4));
        $ejercicio = $this->Graficas_model->dame_nombre_ejercicio($str); 

        $registros =  $this->Graficas_model->get_desglose_avisos($ejercicio);

        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $csv_header = array(
            '#',
            'Ejercicio',
            'Trimestre',
            'Tipo',
            utf8_decode('Nombre de la campaña o aviso institucional'),
            'Contratante',
            'Solicitante',
            'Tiempo oficial',
            'Monto total ejercido');

        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if(isset($registros) && !empty($registros) && sizeof($registros) > 0)
        {
            $count = 1;
            foreach ($registros as $row) 
            {
                $csv = array(
                    utf8_decode($row['id']),
                    utf8_decode($row['ejercicio']),
                    utf8_decode($row['trimestre']),
                    utf8_decode($row['nombre_campana_tipo']),
                    utf8_decode($row['nombre_campana_aviso']),
                    utf8_decode($row['contratante']),
                    utf8_decode($row['solicitante']),
                    utf8_decode($row['nombre_tipo_tiempo']),
                    utf8_decode($row['monto_total'])
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }

    private function crear_archivo_subconceptos_erogacion_table($path, $namefile, $id){
        $this->load->model('tpoadminv1/capturista/Facturas_model');;

        $registros =  $this->Facturas_model->dame_todas_facturas_desglose($id, true);

        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $csv_header = array(
            '#',
            utf8_decode('Campaña o aviso institucional'),
            utf8_decode('Clasificación'),
            utf8_decode('Categoría del servicio'),
            'Monto del subconcepto');

        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if(isset($registros) && !empty($registros) && sizeof($registros) > 0)
        {
            $count = 1;
            foreach ($registros as $row) 
            {
                $csv = array(
                    utf8_decode($row['id']),
                    utf8_decode($row['nombre_campana_aviso']),
                    utf8_decode($row['nombre_servicio_clasificacion']),
                    utf8_decode($row['nombre_servicio_categoria']),
                    utf8_decode($row['monto_desglose_format'])
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }

    private function crear_archivo_erogaciones_table($path, $namefile){
        $this->load->model('tpov1/graficas/Tablas_model');
        $this->load->model('tpoadminv1/sujetos/Sujeto_model');
        $this->load->model('tpov1/graficas/Graficas_model');
        
        $str = $this->Graficas_model->limpiar_Cadena($this->uri->segment(4));
        $ejercicio = $this->Graficas_model->dame_nombre_ejercicio($str); 
        $registros =  $this->Tablas_model->get_erogaciones($ejercicio);

        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $csv_header = array(
            '#',
            'Ejercicio',
            'Trimestre',
            'Proveedor',
            utf8_decode('Clave única'),
            'Fecha',
            'Monto total');

        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if(isset($registros) && !empty($registros) && sizeof($registros) > 0)
        {
            $count = 1;
            foreach ($registros as $row) 
            {
                $csv = array(
                    utf8_decode($row['id']),
                    utf8_decode($row['ejercicio']),
                    utf8_decode($row['trimestre']),
                    utf8_decode($row['proveedor']),
                    utf8_decode($row['numero_factura']),
                    utf8_decode($row['fecha_erogacion']),
                    utf8_decode($row['monto'])
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }

    private function crear_archivo_so_contratos_table($path, $namefile, $id){
        $this->load->model('tpov1/graficas/Tablas_model');
        $this->load->model('tpoadminv1/sujetos/Sujeto_model');

        $ejercicio = null; 
        $so = $this->Sujeto_model->get_sujeto_id($id);
        $nombre = empty($so) ? '' : $so['nombre'];

        $registros =  $this->Tablas_model->get_contratos_so($nombre, $ejercicio);

        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $csv_header = array(
            '#',
            'Ejercicio',
            'Trimestre',
            'Contrato',
            'Sujeto obligado contratante',
            'sujeto obligado solicitante',
            'Proveedor',
            'Monto total del contrato',
            'Monto total ejercido');

        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if(isset($registros) && !empty($registros) && sizeof($registros) > 0)
        {
            $count = 1;
            foreach ($registros as $row) 
            {
                $csv = array(
                    utf8_decode($row['id']),
                    utf8_decode($row['ejercicio']),
                    utf8_decode($row['trimestre']),
                    utf8_decode($row['numero_contrato']),
                    utf8_decode($row['nombre_so_contratante']),
                    utf8_decode($row['nombre_so_solicitante']),
                    utf8_decode($row['nombre_proveedor']),
                    utf8_decode($row['monto_contrato']),
                    utf8_decode($row['monto_ejercido'])
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }

    private function crear_archivo_so_ordenes_table($path, $namefile, $id){
        $this->load->model('tpov1/graficas/Tablas_model');
        $this->load->model('tpoadminv1/sujetos/Sujeto_model');

        $ejercicio = null; 
        $so = $this->Sujeto_model->get_sujeto_id($id);
        $nombre = empty($so) ? '' : $so['nombre'];

        $registros =  $this->Tablas_model->get_ordenes_compra_so($nombre, $ejercicio);

        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $csv_header = array(
            '#',
            'Ejercicio',
            'Trimestre',
            'Orden de compra',
            'Sujeto obligado contratante',
            'sujeto obligado solicitante',
            'Proveedor',
            'Total ejercido');

        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if(isset($registros) && !empty($registros) && sizeof($registros) > 0)
        {
            $count = 1;
            foreach ($registros as $row) 
            {
                $csv = array(
                    utf8_decode($row['id']),
                    utf8_decode($row['ejercicio']),
                    utf8_decode($row['trimestre']),
                    utf8_decode($row['numero_orden_compra']),
                    utf8_decode($row['nombre_so_contratante']),
                    utf8_decode($row['nombre_so_solicitante']),
                    utf8_decode($row['nombre_proveedor']),
                    utf8_decode($row['monto_ejercido'])
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }

    private function crear_archivo_sujetos_obligados_table($path, $namefile)
    {
        $this->load->model('tpov1/graficas/Tablas_model');
        $this->load->model('tpov1/graficas/Graficas_model');
        
        $str = $this->Graficas_model->limpiar_Cadena($this->uri->segment(4));
        $ejercicio = "";
        if($str != "" && $str != "Todos"){
            $ejercicio = $str;
        }
        $registros =  $this->Tablas_model->get_sujetos_montos($ejercicio);
        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $csv_header = array(
            '#',
            'Ejercicio',
            utf8_decode('Función'),
            'Orden',
            'Estado',
            'Nombre',
            'Siglas',
            'Monto total');

        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if(isset($registros) && !empty($registros) && sizeof($registros) > 0)
        {
            $count = 1;
            foreach ($registros as $row) 
            {
                $csv = array(
                    utf8_decode($row['id']),
                    utf8_decode($row['ejercicio']),
                    utf8_decode($row['funcion']),
                    utf8_decode($row['orden']),
                    utf8_decode($row['estado']),
                    utf8_decode($row['nombre_sujeto_obligado']),
                    utf8_decode($row['siglas_sujeto_obligado']),
                    utf8_decode($row['monto_formato'])
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }

    private function crear_archivo_contratos_convenios_table($path, $namefile, $str){
        $this->load->model('tpoadminv1/capturista/Contratos_model');
        $registros =  $this->Contratos_model->dame_todos_convenios_modificatorios($str);
        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $csv_header = array(
            '#',
            'Ejercicio',
            'Trimestre',
            'Convenio modificatorio',
            'Monto'
        );
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if(isset($registros) && !empty($registros) && sizeof($registros) > 0)
        {
            $count = 1;
            foreach ($registros as $row) 
            {
                $csv = array(
                    utf8_decode($row['id']),
                    utf8_decode($row['ejercicio']),
                    utf8_decode($row['trimestre']),
                    utf8_decode($row['numero_convenio']),
                    utf8_decode($row['monto_convenio_format'])
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }

    private function crear_archivo_contratos_ordenes_table($path, $namefile, $str){
        $this->load->model('tpoadminv1/capturista/Ordenes_Compra_model');
        $registros =  $this->Ordenes_Compra_model->dame_todos_ordenes_compra_by_contrato($str);
        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $csv_header = array(
            '#',
            'Ejercicio',
            'Trimestre',
            'Orden de compra',
            'Fecha',
            'Solicitante',
            utf8_decode('Campaña o aviso'),
            'Monto'

        );
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if(isset($registros) && !empty($registros) && sizeof($registros) > 0)
        {
            $count = 1;
            foreach ($registros as $row) 
            {
                $csv = array(
                    utf8_decode($row['id']),
                    utf8_decode($row['ejercicio']),
                    utf8_decode($row['trimestre']),
                    utf8_decode($row['numero_orden_compra']),
                    utf8_decode($row['fecha_orden']),
                    utf8_decode($row['nombre_so_solicitante']),
                    utf8_decode($row['campana_aviso']),
                    utf8_decode($row['monto'])
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }

    private function crear_archivo_contratos_servicios_table($path, $namefile, $str, $tipo){
        $this->load->model('tpov1/graficas/Tablas_model');
        $registros =  $this->Tablas_model->get_servicios_contratos_gasto($str, $tipo);
        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $csv_header = array(
            '#',
            'Ejercicio',
            'Factura',
            'Fecha',
            'Proveedor',
            utf8_decode('Categoría'),
            utf8_decode('Subcategoría'),
            'Tipo',
            utf8_decode('Campaña o aviso'),
            'Monto gastado'
        );
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if(isset($registros) && !empty($registros) && sizeof($registros) > 0)
        {
            $count = 1;
            foreach ($registros as $row) 
            {
                $csv = array(
                    utf8_decode($row['id']),
                    utf8_decode($row['ejercicio']),
                    utf8_decode($row['factura']),
                    utf8_decode($row['fecha_erogacion']),
                    utf8_decode($row['proveedor']),
                    utf8_decode($row['nombre_servicio_categoria']),
                    utf8_decode($row['nombre_servicio_subcategoria']),
                    utf8_decode($row['tipo']),
                    utf8_decode($row['nombre_campana_aviso']),
                    utf8_decode($row['monto_servicio'])
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }

    private function crear_archivo_ordenes_servicios_table($path, $namefile, $str, $tipo){
        $this->load->model('tpov1/graficas/Tablas_model');
        $registros =  $this->Tablas_model->get_servicios_ordenes_gasto($str, $tipo);
        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $csv_header = array(
            '#',
            'Ejercicio',
            'Factura',
            'Fecha',
            'Proveedor',
            utf8_decode('Categoría'),
            utf8_decode('Subcategoría'),
            'Tipo',
            utf8_decode('Campaña o aviso'),
            'Monto gastado'
        );
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if(isset($registros) && !empty($registros) && sizeof($registros) > 0)
        {
            $count = 1;
            foreach ($registros as $row) 
            {
                $csv = array(
                    utf8_decode($row['id']),
                    utf8_decode($row['ejercicio']),
                    utf8_decode($row['factura']),
                    utf8_decode($row['fecha_erogacion']),
                    utf8_decode($row['proveedor']),
                    utf8_decode($row['nombre_servicio_categoria']),
                    utf8_decode($row['nombre_servicio_subcategoria']),
                    utf8_decode($row['tipo']),
                    utf8_decode($row['nombre_campana_aviso']),
                    utf8_decode($row['monto_servicio'])
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }

    private function crear_archivo_ordenes_table($path, $namefile){
        $this->load->model('tpov1/graficas/Graficas_model');
        
        $str = $this->Graficas_model->limpiar_Cadena($this->uri->segment(4));
        $ejercicio = $this->Graficas_model->dame_nombre_ejercicio($str); 
        $resultados =  $this->Graficas_model->get_ordenes_compra($ejercicio);
        $registros = $resultados['data'];
        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $csv_header = array(
            '#',
            'Ejercicio',
            'Trimestre',
            'Contrato',
            'Sujeto obligado solicitante',
            'Sujeto obligado contratante',
            'Proveedor',
            'Monto total ejercido'
        );
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if(isset($registros) && !empty($registros) && sizeof($registros) > 0)
        {
            $count = 1;
            foreach ($registros as $row) 
            {
                $csv = array(
                    utf8_decode($row['id']),
                    utf8_decode($row['ejercicio']),
                    utf8_decode($row['trimestre']),
                    utf8_decode($row['numero_orden_compra']),
                    utf8_decode($row['so_solicitante']),
                    utf8_decode($row['so_contratante']),
                    utf8_decode($row['proveedor']),
                    utf8_decode($row['monto_ejercido'])
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }

    private function crear_archivo_contratos_table($path, $namefile){
        $this->load->model('tpov1/graficas/Graficas_model');

        $str = $this->Graficas_model->limpiar_Cadena($this->uri->segment(4));
        $ejercicio = $this->Graficas_model->dame_nombre_ejercicio($str); 
        $resultados =  $this->Graficas_model->get_contratos($ejercicio);
        $registros = $resultados['data'];
        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $csv_header = array(
            '#',
            'Ejercicio',
            'Trimestre',
            'Contrato',
            'Sujeto obligado contratante',
            'Sujeto obligado solicitante',
            'Proveedor',
            'Monto total del contrato',
            'Monto total ejercido'
        );
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if(isset($registros) && !empty($registros) && sizeof($registros) > 0)
        {
            $count = 1;
            foreach ($registros as $row) 
            {
                $csv = array(
                    utf8_decode($row['id']),
                    utf8_decode($row['ejercicio']),
                    utf8_decode($row['trimestre']),
                    utf8_decode($row['numero_contrato']),
                    utf8_decode($row['so_contratante']),
                    utf8_decode($row['so_solicitante']),
                    utf8_decode($row['proveedor']),
                    utf8_decode($row['monto_contrato']),
                    utf8_decode($row['monto_ejercido'])
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }

    private function crear_archivo_tiposervicios_table($path, $namefile){
        $this->load->model('tpov1/graficas/Tablas_model');
        $this->load->model('tpov1/graficas/Graficas_model');

        $str = $this->Graficas_model->limpiar_Cadena($this->uri->segment(4));
        $ejercicio = $this->Graficas_model->dame_nombre_ejercicio($str); 
        $registros =  $this->Tablas_model->get_servicios_gasto($ejercicio);
        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $csv_header = array(
            '#',
            'Ejercicio',
            'Factura',
            'Fecha',
            'Proveedor',
            utf8_decode('Clasificación'),
            utf8_decode('Categoría'),
            utf8_decode('Subcategoría'),
            'Tipo',
            utf8_decode('Campaña o aviso'),
            'Monto gastado'
        );
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if(isset($registros) && !empty($registros) && sizeof($registros) > 0)
        {
            $count = 1;
            foreach ($registros as $row) 
            {
                $csv = array(
                    utf8_decode($row['id']),
                    utf8_decode($row['ejercicio']),
                    utf8_decode($row['factura']),
                    utf8_decode($row['fecha_erogacion']),
                    utf8_decode($row['proveedor']),
                    utf8_decode($row['nombre_servicio_clasificacion']),
                    utf8_decode($row['nombre_servicio_categoria']),
                    utf8_decode($row['nombre_servicio_subcategoria']),
                    utf8_decode($row['tipo']),
                    utf8_decode($row['nombre_campana_aviso']),
                    utf8_decode($row['monto_servicio'])
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }

    private function crear_archivo_contratos_proveedor_table($path, $namefile, $id_proveedor){
        $this->load->model('tpov1/graficas/Tablas_model');
        $registros =  $this->Tablas_model->get_contratos_proveedor($id_proveedor);
        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $csv_header = array(
            '#',
            'Ejercicio',
            'Trimestre',
            'Contratante',
            'Solicitante',
            'Contrato',
            'Monto original del contrato',
            'Monto modificado',
            'Monto total',
            'Monto pagado'
        );
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if(isset($registros) && !empty($registros) && sizeof($registros) > 0)
        {
            $count = 1;
            foreach ($registros as $row) 
            {
                $csv = array(
                    utf8_decode($row['id']),
                    utf8_decode($row['ejercicio']),
                    utf8_decode($row['trimestre']),
                    utf8_decode($row['so_contratante']),
                    utf8_decode($row['so_solicitante']),
                    utf8_decode($row['numero_contrato']),
                    utf8_decode($row['monto_contrato']),
                    utf8_decode($row['monto_modificado']),
                    utf8_decode($row['monto_total']),
                    utf8_decode($row['monto_pagado'])
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }

    private function crear_archivo_ordenes_compra_proveedor_table($path, $namefile, $id_proveedor){
        $this->load->model('tpov1/graficas/Tablas_model');
        $registros =  $this->Tablas_model->get_ordenes_proveedor($id_proveedor);
        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $csv_header = array(
            '#',
            'Ejercicio',
            'Trimestre',
            'Orden de compra',
            'Proveedor',
            utf8_decode('Campaña o aviso institucional'),
            'Monto');
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if(isset($registros) && !empty($registros) && sizeof($registros) > 0)
        {
            $count = 1;
            foreach ($registros as $row) 
            {
                $csv = array(
                    utf8_decode($row['id']),
                    utf8_decode($row['ejercicio']),
                    utf8_decode($row['trimestre']),
                    utf8_decode($row['numero_orden_compra']),
                    utf8_decode($row['proveedor']),
                    utf8_decode($row['nombre_campana_aviso']),
                    utf8_decode($row['monto'])
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }

    private function crear_archivo_porproveedores_table($path, $namefile)
    {
        $this->load->model('tpov1/graficas/Tablas_model');
        $this->load->model('tpov1/graficas/Graficas_model');
        $str = $this->Graficas_model->limpiar_Cadena($this->uri->segment(4));
        $ejercicio = $this->Graficas_model->dame_nombre_ejercicio($str); 

        $registros =  $this->Tablas_model->get_valores_tabla_proveedores($ejercicio);
        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $csv_header = array(
            '#',
            'Ejercicio',
            'Proveedor',
            'Contratos',
            utf8_decode('Órdenes de compra'),
            'Monto total pagado');
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if(isset($registros) && !empty($registros) && sizeof($registros) > 0)
        {
            $count = 1;
            foreach ($registros as $row) 
            {
                $csv = array(
                    utf8_decode($row['id']),
                    utf8_decode($row['ejercicio']),
                    utf8_decode($row['nombre']),
                    utf8_decode($row['contratos']),
                    utf8_decode($row['ordenes']),
                    utf8_decode($row['monto'])
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }

    private function crear_archivo_presupuestos_table($path, $namefile)
    {
        $this->load->model('tpov1/graficas/Graficas_model');
        $str = $this->Graficas_model->limpiar_Cadena($this->uri->segment(4));
        $ejercicio = $this->Graficas_model->dame_nombre_ejercicio($str); 
        $registros =  $this->Graficas_model->get_desglose_partidas_presupuesto($ejercicio);
        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $csv_header = array(
            'Ejercicio',
            'Clave de partida',
            utf8_decode('Descripción'),
            'Presupuesto original',
            'Monto modificado',
            'Presupuesto modificado',
            'Presupuesto ejercido');
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if(isset($registros) && !empty($registros) && sizeof($registros) > 0)
        {
            $count = 1;
            foreach ($registros as $row) 
            {
                $csv = array(
                    utf8_decode($row['ejercicio']),
                    utf8_decode($row['partida']),
                    utf8_decode($row['descripcion']),
                    utf8_decode($row['original']),
                    utf8_decode($row['modificaciones']),
                    utf8_decode($row['presupuesto']),
                    utf8_decode($row['ejercido'])
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }

}

?>