<?php


/**
 * Description of Print_CI
 *
 * INAI TPO
 */

if (!defined('BASEPATH')) 
{
    exit('No direct script access allowed');
}

class Print_CI extends CI_Controller
{
     // Constructor que manda llamar la funcion is_logged_in
     function __construct()
     {
         parent::__construct();
         $this->is_logged_in();
     }
 
     // Funcion para revisar inicio de session 
     function is_logged_in() 
     {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if (!isset($is_logged_in) || $is_logged_in != true) {
            redirect('tpoadminv1/cms');
        }
     }
     
     // Funcion para cerrar session
     function logout() 
     {
         $this->session->sess_destroy();
         $this->session->sess_create();
         redirect('/');
     }

     function permiso_capturista()
    {
        //Revisamos que el usuario sea capturista
        if($this->session->userdata('usuario_rol') != '2')
        {
            redirect('tpoadminv1/securecms/sin_permiso');
        }else if($this->session->userdata('usuario_id_so_atribucion') != 1 && $this->session->userdata('usuario_id_so_atribucion') != 3 ){
            redirect('tpoadminv1/securecms/sin_permiso');
        }
    }
	
	function permiso_financiero()
    {
        //Revisamos que el usuario sea financiero
        if($this->session->userdata('usuario_rol') != '2' && $this->session->userdata('usuario_rol') != '3')
        {
            redirect('tpoadminv1/securecms/sin_permiso');
        }else if($this->session->userdata('usuario_id_so_atribucion') != 1 && $this->session->userdata('usuario_id_so_atribucion') != 3 ){
            redirect('tpoadminv1/securecms/sin_permiso');
        }
    }
    
    function permiso_administrador()
    {
        //Revisamos que el usuario sea administrador
        if($this->session->userdata('usuario_rol') != '1')
        {
            redirect('tpoadminv1/securecms/sin_permiso');
        }
    }

     function print_coberturas(){
         //Validamos que el usuario tenga acceso
        $this->permiso_administrador();

        $this->load->model('tpoadminv1/catalogos/Coberturas_model');
        
        $data['title'] = "Coberturas de la campa&ntilde;a ";
        $data['registros'] = $this->Coberturas_model->dame_todas_coberturas();
        
        //lista de nombre de las columnas como se carga en el array de registros
        $data['registros_columnas'] = array(
            'id_campana_cobertura',
            'nombre_campana_cobertura',
            'active'
        );
        //lista de nombre de los <th> para la tabla, debe ser el mismo numero de registros que el array de registros_columnas
        $data['nombre_columnas'] = array(
            '#',
            'Coberturas de la campaña',
            'Estatus'
        );

        $this->load->view('tpoadminv1/includes/print_template', $data);
    }

    function print_tiposTO(){
         //Validamos que el usuario tenga acceso
        $this->permiso_administrador();

        $this->load->model('tpoadminv1/catalogos/TiposTO_model');
        
        $data['title'] = "Tipo de Tiempo Oficial";
        $data['registros'] = $this->TiposTO_model->dame_todos_tiposTO();
        
        //lista de nombre de las columnas como se carga en el array de registros
        $data['registros_columnas'] = array(
            'id_campana_tipoTO',
            'nombre_campana_tipoTO',
            'active'
        );
        //lista de nombre de los <th> para la tabla, debe ser el mismo numero de registros que el array de registros_columnas
        $data['nombre_columnas'] = array(
            '#',
            'Tipo de Tiempo Oficial',
            'Estatus'
        );

        $this->load->view('tpoadminv1/includes/print_template', $data);
    }


    function print_objetivos(){

        //Validamos que el usuario tenga acceso
        $this->permiso_administrador();

        $this->load->model('tpoadminv1/catalogos/Coberturas_model');
        
        $data['title'] = "Objetivos de campa&ntilde;as o avisos institucionales";
        $data['registros'] = $this->Coberturas_model->dame_todos_objetivos();
        
        //lista de nombre de las columnas como se carga en el array de registros
        $data['registros_columnas'] = array(
            'id_campana_objetivo',
            'campana_objetivo',
            'estatus'
        );
        //lista de nombre de los <th> para la tabla, debe ser el mismo numero de registros que el array de registros_columnas
        $data['nombre_columnas'] = array(
            '#',
            'Objetivos de campa&ntilde;as o avisos institucionales',
            'Estatus'
        );

        $this->load->view('tpoadminv1/includes/print_template', $data);
    }

    function print_tipos(){
        //Validamos que el usuario tenga acceso
        $this->permiso_administrador();

        $this->load->model('tpoadminv1/catalogos/Coberturas_model');
        
        $data['title'] = "Tipos de campa&ntilde;as o avisos institucionales";
        $data['registros'] = $this->Coberturas_model->dame_todos_tipos();
        
        //lista de nombre de las columnas como se carga en el array de registros
        $data['registros_columnas'] = array(
            'id_campana_tipo',
            'nombre_campana_tipo',
            'estatus'
        );
        //lista de nombre de los <th> para la tabla, debe ser el mismo numero de registros que el array de registros_columnas
        $data['nombre_columnas'] = array(
            '#',
            'Tipos de campa&ntilde;as o avisos institucionales',
            'Estatus'
        );

        $this->load->view('tpoadminv1/includes/print_template', $data);
    }

    function print_subtipos(){
        //Validamos que el usuario tenga acceso
        $this->permiso_administrador();

        $this->load->model('tpoadminv1/catalogos/Coberturas_model');
        
        $data['title'] = "Subtipos de campa&ntilde;a o avisos institucionales";
        $data['registros'] = $this->Coberturas_model->dame_todos_subtipos();
        
        //lista de nombre de las columnas como se carga en el array de registros
        $data['registros_columnas'] = array(
            'id_campana_tipo',
            'nombre_campana_tipo',
            'nombre_campana_subtipo',
            'estatus'
        );
        //lista de nombre de los <th> para la tabla, debe ser el mismo numero de registros que el array de registros_columnas
        $data['nombre_columnas'] = array(
            '#',
            'Tipos de campa&ntilde;a o avisos institucionales',
            'Subtipos de campa&ntilde;a o avisos institucionales',
            'Estatus'
        );

        $this->load->view('tpoadminv1/includes/print_template', $data);
    }

    function print_temas(){

        //Validamos que el usuario tenga acceso
        $this->permiso_administrador();

        $this->load->model('tpoadminv1/catalogos/Coberturas_model');
        
        $data['title'] = "Temas";
        $data['registros'] = $this->Coberturas_model->dame_todos_temas();
        
        //lista de nombre de las columnas como se carga en el array de registros
        $data['registros_columnas'] = array(
            'id_campana_tema',
            'nombre_campana_tema',
            'estatus'
        );
        //lista de nombre de los <th> para la tabla, debe ser el mismo numero de registros que el array de registros_columnas
        $data['nombre_columnas'] = array(
            '#',
            'Temas',
            'Estatus'
        );

        $this->load->view('tpoadminv1/includes/print_template', $data);
    }

    function print_edades(){

        //Validamos que el usuario tenga acceso
        $this->permiso_administrador();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        
        $data['title'] = "Segmentaci&oacute;n de edad";
        $data['registros'] = $this->Catalogos_model->dame_todas_edades();
        
        //lista de nombre de las columnas como se carga en el array de registros
        $data['registros_columnas'] = array(
            'id_poblacion_grupo_edad',
            'nombre_poblacion_grupo_edad',
            'active'
        );
        //lista de nombre de los <th> para la tabla, debe ser el mismo numero de registros que el array de registros_columnas
        $data['nombre_columnas'] = array(
            '#',
            'Segmentaci&oacute;n de edad',
            'Estatus'
        );

        $this->load->view('tpoadminv1/includes/print_template', $data);
    }

    function print_socioeconomicos(){

        //Validamos que el usuario tenga acceso
        $this->permiso_administrador();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        
        $data['title'] = "Nivel socioecon&oacute;mico";
        $data['registros'] = $this->Catalogos_model->dame_todas_socioeconomicos();
        
        //lista de nombre de las columnas como se carga en el array de registros
        $data['registros_columnas'] = array(
            'id_poblacion_nivel',
            'nombre_poblacion_nivel',
            'active'
        );
        //lista de nombre de los <th> para la tabla, debe ser el mismo numero de registros que el array de registros_columnas
        $data['nombre_columnas'] = array(
            '#',
            'Nivel socioecon&oacute;mico',
            'Estatus'
        );

        $this->load->view('tpoadminv1/includes/print_template', $data);
    }

    function print_educacion(){

        //Validamos que el usuario tenga acceso
        $this->permiso_administrador();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        
        $data['title'] = "Niveles de educaci&oacute;n";
        $data['registros'] = $this->Catalogos_model->dame_todas_educacion();
        
        //lista de nombre de las columnas como se carga en el array de registros
        $data['registros_columnas'] = array(
            'id_poblacion_nivel_educativo',
            'nombre_poblacion_nivel_educativo',
            'active'
        );
        //lista de nombre de los <th> para la tabla, debe ser el mismo numero de registros que el array de registros_columnas
        $data['nombre_columnas'] = array(
            '#',
            'Nivel de educaci&oacute;n',
            'Estatus'
        );

        $this->load->view('tpoadminv1/includes/print_template', $data);
    }

    function print_sexos(){

        //Validamos que el usuario tenga acceso
        $this->permiso_administrador();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        
        $data['title'] = "Segmentaci&oacute;n por sexo";
        $data['registros'] = $this->Catalogos_model->dame_todos_sexo();
        
        //lista de nombre de las columnas como se carga en el array de registros
        $data['registros_columnas'] = array(
            'id_poblacion_sexo',
            'nombre_poblacion_sexo',
            'active'
        );
        //lista de nombre de los <th> para la tabla, debe ser el mismo numero de registros que el array de registros_columnas
        $data['nombre_columnas'] = array(
            '#',
            'Segmentaci&oacute;n por sexo',
            'Estatus'
        );

        $this->load->view('tpoadminv1/includes/print_template', $data);
    }

    function print_clasificaciones(){

        //Validamos que el usuario tenga acceso
        $this->permiso_administrador();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        
        $data['title'] = "Clasificaci&oacute;n del servicio";
        $data['registros'] = $this->Catalogos_model->dame_todas_clasificaciones();
        
        //lista de nombre de las columnas como se carga en el array de registros
        $data['registros_columnas'] = array(
            'id_servicio_clasificacion',
            'nombre_servicio_clasificacion',
            'active'
        );
        //lista de nombre de los <th> para la tabla, debe ser el mismo numero de registros que el array de registros_columnas
        $data['nombre_columnas'] = array(
            '#',
            'Clasificaci&oacute;n del servicio',
            'Estatus'
        );

        $this->load->view('tpoadminv1/includes/print_template', $data);
    }

    function print_categorias(){

        //Validamos que el usuario tenga acceso
        $this->permiso_administrador();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        
        $data['title'] = "Categor&iacute;as del servicio";
        $data['registros'] = $this->Catalogos_model->dame_todas_categorias();
        
        //lista de nombre de las columnas como se carga en el array de registros
        $data['registros_columnas'] = array(
            'id_servicio_categoria',
            'nombre_servicio_clasificacion',
            'nombre_servicio_categoria',
            'titulo_grafica',
            'color_grafica',
            'active'
        );
        //lista de nombre de los <th> para la tabla, debe ser el mismo numero de registros que el array de registros_columnas
        $data['nombre_columnas'] = array(
            '#',
            'Clasificaci&oacute;n del servicio',
            'Categor&iacute;a del servicio',
            'T&iacute;tulo gr&aacute;fica',
            'Color gr&aacute;fica',
            'Estatus'
        );

        $this->load->view('tpoadminv1/includes/print_template', $data);
    }

    function print_subcategorias(){

        //Validamos que el usuario tenga acceso
        $this->permiso_administrador();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        
        $data['title'] = "Subcategor&iacute;as del servicio";
        $data['registros'] = $this->Catalogos_model->dame_todas_subcategorias();
        
        //lista de nombre de las columnas como se carga en el array de registros
        $data['registros_columnas'] = array(
            'id_servicio_subcategoria',
            'nombre_servicio_categoria',
            'nombre_servicio_subcategoria',
            'active'
        );
        //lista de nombre de los <th> para la tabla, debe ser el mismo numero de registros que el array de registros_columnas
        $data['nombre_columnas'] = array(
            '#',
            'Categor&iacute;a del servicio',
            'Subcategor&iacute;a del servicio',
            'Estatus'
        );

        $this->load->view('tpoadminv1/includes/print_template', $data);
    }

    function print_unidades(){

        //Validamos que el usuario tenga acceso
        $this->permiso_administrador();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        
        $data['title'] = "Unidades del servicio";
        $data['registros'] = $this->Catalogos_model->dame_todas_unidades();
        
        //lista de nombre de las columnas como se carga en el array de registros
        $data['registros_columnas'] = array(
            'id_servicio_unidad',
            'nombre_servicio_subcategoria',
            'nombre_servicio_unidad',
            'active'
        );
        //lista de nombre de los <th> para la tabla, debe ser el mismo numero de registros que el array de registros_columnas
        $data['nombre_columnas'] = array(
            '#',
            'Subcategor&iacute;a del servicio',
            'Unidad del servicio',
            'Estatus'
        );

        $this->load->view('tpoadminv1/includes/print_template', $data);
    }

    function print_atribuciones(){

        //Validamos que el usuario tenga acceso
        $this->permiso_administrador();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        
        $data['title'] = "Funciones del sujeto obligado";
        $data['registros'] = $this->Catalogos_model->dame_todas_atribuciones();
        
        //lista de nombre de las columnas como se carga en el array de registros
        $data['registros_columnas'] = array(
            'id_so_atribucion',
            'nombre_so_atribucion',
            'active'
        );
        //lista de nombre de los <th> para la tabla, debe ser el mismo numero de registros que el array de registros_columnas
        $data['nombre_columnas'] = array(
            '#',
            'Funci&oacute;n del sujeto obligado',
            'Estatus'
        );

        $this->load->view('tpoadminv1/includes/print_template', $data);
    }

    function print_estados(){

        //Validamos que el usuario tenga acceso
        $this->permiso_administrador();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        
        $data['title'] = "Estados";
        $data['registros'] = $this->Catalogos_model->dame_todos_estados();
        
        //lista de nombre de las columnas como se carga en el array de registros
        $data['registros_columnas'] = array(
            'id_so_estado',
            'nombre_so_estado',
            'codigo_so_estado',
            'active'
        );
        //lista de nombre de los <th> para la tabla, debe ser el mismo numero de registros que el array de registros_columnas
        $data['nombre_columnas'] = array(
            '#',
            'Nombre del estado',
            'C&oacute;digo del estado',
            'Estatus'
        );

        $this->load->view('tpoadminv1/includes/print_template', $data);
    }

    function print_ordenes(){
        //Validamos que el usuario tenga acceso
        $this->permiso_administrador();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        
        $data['title'] = "&Oacute;rdenes de gobierno";
        $data['registros'] = $this->Catalogos_model->dame_todos_ordenes();
        
        //lista de nombre de las columnas como se carga en el array de registros
        $data['registros_columnas'] = array(
            'id_so_orden_gobierno',
            'nombre_so_orden_gobierno',
            'active'
        );
        //lista de nombre de los <th> para la tabla, debe ser el mismo numero de registros que el array de registros_columnas
        $data['nombre_columnas'] = array(
            '#',
            '&Oacute;rdenes de gobierno',
            'Estatus'
        );

        $this->load->view('tpoadminv1/includes/print_template', $data);
    }

    function print_presupuestos(){
        //Validamos que el usuario tenga acceso
        $this->permiso_administrador();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        
        $data['title'] = "Partidas presupuestarias";
        $data['registros'] = $this->Catalogos_model->dame_todos_presupuestos();
        
        //lista de nombre de las columnas como se carga en el array de registros
        $data['registros_columnas'] = array(
            'id_presupesto_concepto',
            'capitulo',
            'concepto',
            'partida',
            'denominacion',
            'descripcion',
            'id_captura',
            'active'
        );
        //lista de nombre de los <th> para la tabla, debe ser el mismo numero de registros que el array de registros_columnas
        $data['nombre_columnas'] = array(
            '#',
            'Concepto',
            'Partida genérica',
            'Partida específica',
            'Denominaci&oacute;n',
            'Descripci&oacute;n',
            'Captura',
            'Estatus'
        );

        $this->load->view('tpoadminv1/includes/print_template', $data);
    }

    function print_trimestres(){
        //Validamos que el usuario tenga acceso
        $this->permiso_administrador();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        
        $data['title'] = "Trimestres";
        $data['registros'] = $this->Catalogos_model->dame_todos_trimestres(false);
        
        //lista de nombre de las columnas como se carga en el array de registros
        $data['registros_columnas'] = array(
            'id_trimestre',
            'trimestre',
            'active'
        );
        //lista de nombre de los <th> para la tabla, debe ser el mismo numero de registros que el array de registros_columnas
        $data['nombre_columnas'] = array(
            '#',
            'Trimestre',
            'Estatus'
        );

        $this->load->view('tpoadminv1/includes/print_template', $data);
    }

    function print_ejercicios(){

        //Validamos que el usuario tenga acceso
        $this->permiso_administrador();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        
        $data['title'] = "Ejercicios";
        $data['registros'] = $this->Catalogos_model->dame_todos_ejercicios(false);
        
        //lista de nombre de las columnas como se carga en el array de registros
        $data['registros_columnas'] = array(
            'id_ejercicio',
            'ejercicio',
            'active'
        );
        //lista de nombre de los <th> para la tabla, debe ser el mismo numero de registros que el array de registros_columnas
        $data['nombre_columnas'] = array(
            '#',
            'Ejercicio',
            'Estatus'
        );

        $this->load->view('tpoadminv1/includes/print_template', $data);
    }

    function print_personalidades(){
        //Validamos que el usuario tenga acceso
        $this->permiso_administrador();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        
        $data['title'] = "Pesonalidad jur&iacute;dica del proveedor ";
        $data['registros'] = $this->Catalogos_model->dame_todos_personalidades(false);
        
        //lista de nombre de las columnas como se carga en el array de registros
        $data['registros_columnas'] = array(
            'id_personalidad_juridica',
            'nombre_personalidad_juridica',
            'active'
        );
        //lista de nombre de los <th> para la tabla, debe ser el mismo numero de registros que el array de registros_columnas
        $data['nombre_columnas'] = array(
            '#',
            'Personalidad jur&iacute;dica',
            'Estatus'
        );

        $this->load->view('tpoadminv1/includes/print_template', $data);
    }

    function print_procedimientos(){
        //Validamos que el usuario tenga acceso
        $this->permiso_administrador();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        
        $data['title'] = "Procedimientos de contrataci&oacute;n";
        $data['registros'] = $this->Catalogos_model->dame_todos_procedimientos(false);
        
        //lista de nombre de las columnas como se carga en el array de registros
        $data['registros_columnas'] = array(
            'id_procedimiento',
            'nombre_procedimiento',
            'active'
        );
        //lista de nombre de los <th> para la tabla, debe ser el mismo numero de registros que el array de registros_columnas
        $data['nombre_columnas'] = array(
            '#',
            'Procedimiento de contrataci&oacute;n',
            'Estatus'
        );

        $this->load->view('tpoadminv1/includes/print_template', $data);
    }

    function print_ligas(){
        //Validamos que el usuario tenga acceso
        $this->permiso_administrador();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        
        $data['title'] = "Tipos de ligas";
        $data['registros'] = $this->Catalogos_model->dame_todos_ligas(false);
        
        //lista de nombre de las columnas como se carga en el array de registros
        $data['registros_columnas'] = array(
            'id_tipo_liga',
            'tipo_liga',
            'active'
        );
        //lista de nombre de los <th> para la tabla, debe ser el mismo numero de registros que el array de registros_columnas
        $data['nombre_columnas'] = array(
            '#',
            'Tipo de liga',
            'Estatus'
        );

        $this->load->view('tpoadminv1/includes/print_template', $data);
    }

    /*** print de capturista/presupuestos  ***/

    function print_proveedores()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();


        $this->load->model('tpoadminv1/capturista/Proveedores_model');
        
        $data['title'] = "Proveedores";
        $data['registros'] = $this->Proveedores_model->dame_todos_proveedores(false);
        
        //lista de nombre de las columnas como se carga en el array de registros
        $data['registros_columnas'] = array(
            'id',
            'nombre_personalidad_juridica',
            'nombre_razon_social',
            'nombre_comercial',
            'rfc',
            'active'
        );
        //lista de nombre de los <th> para la tabla, debe ser el mismo numero de registros que el array de registros_columnas
        $data['nombre_columnas'] = array(
            '#',
            'Personalidad jur&iacute;dica',
            'Nombre o raz&oacute;n social ',
            'Nombre comercial',
            'R.F.C.',
            'Estatus'
        );

        $this->load->view('tpoadminv1/includes/print_template', $data);
    }

    function print_planeacion_presupuestos(){

        //Validamos que el usuario tenga acceso

		$this->permiso_financiero();

        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        
        $data['title'] = "Planeaci&oacute;n y presupuestos";
        $data['registros'] = $this->Presupuestos_model->dame_todos_presupuestos();
        
        //lista de nombre de las columnas como se carga en el array de registros
        $data['registros_columnas'] = array(
            'id',
            'ejercicio',
            'nombre_sujeto_obligado',
            'monto_presupuesto',
            'monto_modificacion',
            'presupuesto_modificado',
            'active'
        );
        //lista de nombre de los <th> para la tabla, debe ser el mismo numero de registros que el array de registros_columnas
        $data['nombre_columnas'] = array(
            '#',
            'Ejercicio',
            'Sujeto obligado',
            'Presupuesto original',
            'Monto modificado',
            'presupuesto modificado',
            'Estatus'
        );

        $this->load->view('tpoadminv1/includes/print_template', $data);
    }

    /*** print de capturista/presupuestos  ***/
    function print_presupuestos_partidas(){

        //Validamos que el usuario tenga acceso

        $this->permiso_financiero();

        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        
        $data['title'] = "Desglose de partidas";
        $data['registros'] = $this->Presupuestos_model->dame_todos_presupuestos_conceptos($this->uri->segment(4));
        
        //lista de nombre de las columnas como se carga en el array de registros
        $data['registros_columnas'] = array(
            'id',
            'nombre_presupuesto_concepto',
            'monto_presupuesto_format',
            'monto_modificacion_format',
            'active'
        );
        //lista de nombre de los <th> para la tabla, debe ser el mismo numero de registros que el array de registros_columnas
        $data['nombre_columnas'] = array(
            '#',
            'Partida presupuestal',
            'Monto asignado',
            'Monto de modificaci&oacute;n',
            'Estatus'
        );

        $this->load->view('tpoadminv1/includes/print_template', $data);
    }

    /** imprimir contratos **/
    function print_contratos(){

        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/capturista/Contratos_model');
        
        $data['title'] = "Contratos";
        $data['registros'] = $this->Contratos_model->dame_todos_contratos(false);
        
        //lista de nombre de las columnas como se carga en el array de registros
        $data['registros_columnas'] = array(
            'id',
            'ejercicio',
            'trimestre',
            'nombre_so_contratante',
            'nombre_so_solicitante',
            'numero_contrato',
            'nombre_proveedor',
            'monto_contrato',
            'monto_modificado',
            'monto_total',
            'monto_pagado',
            'active'
        );
        //lista de nombre de los <th> para la tabla, debe ser el mismo numero de registros que el array de registros_columnas
        $data['nombre_columnas'] = array(
            '#',
            'Ejercicio',
            'Trimestre',
            'Sujeto obligado contratante',
            'Sujeto obligado solicitante',
            'N&uacute;mero de contrato',
            'Nombre o raz&oacute;n social del proveedor',
            'Monto original del contrato',
            'Monto modificado',
            'Monto total',
            'Monto pagado a la fecha',
            'Estatus'
        );

        $this->load->view('tpoadminv1/includes/print_template', $data);
    }

    function print_convenios_modificatorios(){

        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();
        
        $this->load->model('tpoadminv1/capturista/Contratos_model');
        
        $data['title'] = "Convenios modificatorios";
        $data['registros'] = $this->Contratos_model->dame_todos_convenios_modificatorios($this->uri->segment(4));
        
        //lista de nombre de las columnas como se carga en el array de registros
        $data['registros_columnas'] = array(
            'id',
            'ejercicio',
            'trimestre',
            'numero_convenio',
            'monto_convenio_format',
            'active'
        );
        //lista de nombre de los <th> para la tabla, debe ser el mismo numero de registros que el array de registros_columnas
        $data['nombre_columnas'] = array(
            '#',
            'Ejercicio',
            'Trimestre',
            'Convenio modificatorio',
            'Monto',
            'Estatus'
        );

        $this->load->view('tpoadminv1/includes/print_template', $data);
    }

    function print_ordenes_compra(){
        
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/capturista/Ordenes_compra_model');
        
        $data['title'] = "&Oacute;rdenes de compra";
        $data['registros'] = $this->Ordenes_compra_model->dame_todos_ordenes_compra(false);
        
        //lista de nombre de las columnas como se carga en el array de registros
        $data['registros_columnas'] = array(
            'id',
            'ejercicio',
            'trimestre',
            'proveedor',
            'campana',
            'numero_orden_compra',
            'active'
        );
        //lista de nombre de los <th> para la tabla, debe ser el mismo numero de registros que el array de registros_columnas
        $data['nombre_columnas'] = array(
            '#',
            'Ejercicio',
            'Trimestre',
            'Nombre a raz&oacute;n social del proveedor',
            'Campa&ntilde;a o aviso institucional',
            'Orden de compra', 
            'Estatus'
        );

        $this->load->view('tpoadminv1/includes/print_template', $data);
    }

    function print_facturas(){
        
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/capturista/Facturas_model');
        
        $data['title'] = "Facturas";
        $data['registros'] = $this->Facturas_model->dame_todas_facturas(false);
        
        //lista de nombre de las columnas como se carga en el array de registros
        $data['registros_columnas'] = array(
            'id',
            'contrato',
            'orden',
            'ejercicio',
            'trimestre',
            'proveedor',
            'numero_factura',
            'fecha_erogacion',
            'monto_factura',
            'active'
        );
        //lista de nombre de los <th> para la tabla, debe ser el mismo numero de registros que el array de registros_columnas
        $data['nombre_columnas'] = array(
            '#',
            'Contrato',
            'Orden',
            'Ejercicio',
            'Trimestre',
            'Proveedor',
            'N&uacute;mero de factura',
            'Fecha de erogaci&oacute;n',
            'Monto', 
            'Estatus'
        );

        $this->load->view('tpoadminv1/includes/print_template', $data);
    }

    function exportar_facturas(){
        
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/capturista/Facturas_model');
        
        $data['title'] = "Creando archivo facturas.csv";
        $data['scripts'] = "<script type='text/javascript'>" .
                                "$(function () {" .
                                    "preparar_exportacion();" .
                                " })".
                            "</script>";

        $this->load->view('tpoadminv1/includes/export_template', $data);
    }

    function print_factura_desglose()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/capturista/Facturas_model');
        
        $data['title'] = "Detalle factura";

        $factura = $this->Facturas_model->dame_factura_id($this->uri->segment(4), false);
        if(!empty($factura))
        {
            $data['title'] = "Detalle factura " . $factura['numero_factura'];
        }
        
        $data['registros'] = $this->Facturas_model->dame_todas_facturas_desglose($this->uri->segment(4), false);
        
        //lista de nombre de las columnas como se carga en el array de registros
        $data['registros_columnas'] = array(
            'id',
            'nombre_campana_aviso',
            'monto_subconcepto',
            'active'
        );
        //lista de nombre de los <th> para la tabla, debe ser el mismo numero de registros que el array de registros_columnas
        $data['nombre_columnas'] = array(
            '#',
            'Campa&ntilde;a o aviso institucional',
            'Monto',
            'Estatus'
        );

        $this->load->view('tpoadminv1/includes/print_template', $data);
    }
}

?>