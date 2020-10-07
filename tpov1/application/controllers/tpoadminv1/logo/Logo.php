<?php

/*
INAI / USUARIOS
*/

if (!defined('BASEPATH')) 
{
    exit('No direct script access allowed');
}

class Logo extends CI_Controller
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
    
    
    function permiso_administrador()
    {
        //Revisamos que el usuario sea administrador
        if($this->session->userdata('usuario_rol') != '1')
        {
            redirect('tpoadminv1/securecms/sin_permiso');
        }
    }

    /**
     * Redirect with POST data.
     *
     * @param string $url URL.
     * @param array $post_data POST data. Example: array('foo' => 'var', 'id' => 123)
     * @param array $headers Optional. Extra headers to send.
     */
    private function redirect_post($url, array $data, array $headers = null) {
        $params = array(
            'http' => array(
                'method' => 'POST',
                'content' => http_build_query($data)
            )
        );
        if (!is_null($headers)) {
            $params['http']['header'] = '';
            foreach ($headers as $k => $v) {
                $params['http']['header'] .= "$k: $v\n";
            }
        }
        $ctx = stream_context_create($params);
        $fp = @fopen($url, 'rb', false, $ctx);
        if ($fp) {
            echo @stream_get_contents($fp);
            die();
        } else {
            // Error
            throw new Exception("Error loading '$url', $php_errormsg");
        }
    }

    function entrar_pnt(){
        $URL = "http://devcarga.inai.org.mx:8080/sipot-web/spring/generaToken/";
        $data = array(
            "usuario" => $_POST["user"], 
            "password" => $_POST["password"] 
        );

        $options = array(
            'http' => array(
            'method'  => 'POST',
            'content' => json_encode( $data ),
            'header'=>  "Content-Type: application/json\r\n" .
                        "Accept: application/json\r\n"
            )
        );

        $response = json_encode($data);
        $context  = stream_context_create( $options );
        $result = file_get_contents( $URL, false, $context );
        $result = json_decode($result, true);

        
        if( $result["success"] ){
            $_SESSION["user_pnt"] = $data["usuario"];
            $_SESSION["pnt"] = $result;

            $stm  = "SELECT id_sujeto_obligado, nombre_sujeto_obligado, rol, nombre_unidad_administrativa 
                FROM unidades_so WHERE correo_unidad_administrativa = '" . $data["usuario"] . "'";
            $query = $this->db->query($stm);

            $_SESSION["sujeto_obligado"] = $query->row()->nombre_sujeto_obligado;
            $_SESSION["unidad_administrativa"] = $query->row()->nombre_unidad_administrativa;
            $_SESSION["id_sujeto_obligado"] = $query->row()->id_sujeto_obligado;
            $_SESSION["rol"] = $query->row()->rol;
        
         }

        $response = json_encode($result);

        header('Content-Type: application/json');
        echo  $response; 

    }

    function modificar_sujeto(){
        $_SESSION["unidad_administrativa"] = $_POST["unidad_administrativa"];
        $_SESSION["sujeto_obligado"] = $_POST["sujeto_obligado"];
        $query = false;
        
        $this->db->select('nombre_sujeto_obligado');
        $this->db->from('unidades_so');
        $this->db->where('correo_unidad_administrativa', $_SESSION["user_pnt"] );
        $q1 = $this->db->get();



        if ( $q1->num_rows() > 0 ){
            $stm  = "UPDATE unidades_so SET nombre_sujeto_obligado = '" . $_POST["sujeto_obligado"] . "', " .
                    "nombre_unidad_administrativa  = '" . $_POST["unidad_administrativa"] . "' " . 
                    "WHERE correo_unidad_administrativa = '" . $_SESSION["user_pnt"] . "'";
            
            $query = $this->db->query($stm);

        }else{
            $post_data = array(); 
            $post_data['nombre_sujeto_obligado'] =  $_POST["sujeto_obligado"];
            $post_data['nombre_unidad_administrativa'] =  $_POST["unidad_administrativa"];
            $post_data['correo_unidad_administrativa'] =  $_SESSION["user_pnt"];

            $this->db->insert('unidades_so', $post_data);
            $query =  $this->db->insert_id();
        }

        header('Content-Type: application/json');
        echo json_encode($query);
    }

    function salir_pnt(){
        $URL = "http://devcarga.inai.org.mx:8080/sipot-web/spring/generaToken/";
        $data = array('usuario' => '', 'password' => '' );

        $options = array(
            'http' => array(
            'method'  => 'POST',
            'content' => json_encode( $data ),
            'header'=>  "Content-Type: application/json\r\n" .
                        "Accept: application/json\r\n"
            )
        );
 
        $context  = stream_context_create( $options );
        $result = file_get_contents( $URL, false, $context );
        $result = json_decode($result, true);

        // Set session variables
        unset( $_SESSION["user_pnt"]);
        unset( $_SESSION["pnt"]);
        unset( $_SESSION["unidad_administrativa"]);
        unset( $_SESSION["sujeto_obligado"]);

        header('Content-Type: application/json');
        echo json_encode($result);

    }

    private function date_format($dstring){
        if ( !isset( $dstring ) OR $dstring == "" ) return $dstring;

        try {
            $dstring = explode("-", (string)$dstring );  
            $dstring =  array_reverse( $dstring );  
            $dstring =  implode("/",  $dstring );  
            return $dstring;
        } catch (Exception $e) {  return ""; }
    } 

    function agregar_pnt(){
        $URL = "http://devcarga.inai.org.mx:8080/sipot-web/spring/mantenimiento/agrega";

        switch ($_POST["idFormato"]) {
            case "43322":
                $table = "rel_pnt_presupuesto";
                $nombre_id_interno = "id_presupuesto";
                break;
            case "43320":
                $table = "rel_pnt_factura";
                $nombre_id_interno = "id_factura";
                $data2 = $this->_subtabla2($_POST["id_contrato"], $_POST["id_factura"]);

                $d1 = $data2['contratos'][0];
                $d2 = $data2['presupuestos'][0];
                $d3 = $data2['facturas'][0];

                $d1["fecha_validacion"] = $this->date_format($d1["fecha_validacion"]);
                $d1["fecha_actualizacion"] = $this->date_format($d1["fecha_actualizacion"]);
                $d1["Fecha de inicio de los servicios contratados"] = $this->date_format($d1["Fecha de inicio de los servicios contratados"]);
                
                /*
                if ( isset( $d1["fecha_validacion"]) ){
                    try {
                        $d1["fecha_validacion"] = explode('-', (string)$d1["fecha_validacion"] );  
                        $d1["fecha_validacion"] =  array_reverse( $d1["fecha_validacion"] );  
                        $d1["fecha_validacion"] =  implode("/",  $d1["fecha_validacion"] );  
                    } catch (Exception $e) {  $d1["fecha_validacion"] = ""; }
                }else{ $d1["fecha_validacion"] = "";}

                if ( isset( $d1["fecha_actualizacion"]) ){
                    try {
                        $d1["fecha_actualizacion"] = explode('-', (string)$d1["fecha_actualizacion"] );  
                        $d1["fecha_actualizacion"] =  array_reverse( $d1["fecha_actualizacion"] );  
                        $d1["fecha_actualizacion"] =  implode("/",  $d1["fecha_actualizacion"] );  
                    } catch (Exception $e) {  $d1["fecha_actualizacion"] = ""; }
                }else{ $d1["fecha_actualizacion"] = "";}

                if ( isset( $d1["Fecha de inicio de los servicios contratados"]) ){
                    try {
                        $d1["Fecha de inicio de los servicios contratados"] = explode('-', (string)$d1["Fecha de inicio de los servicios contratados"] );  
                        $d1["Fecha de inicio de los servicios contratados"] =  array_reverse( $d1["Fecha de inicio de los servicios contratados"] );  
                        $d1["Fecha de inicio de los servicios contratados"] =  implode("/",  $d1["Fecha de inicio de los servicios contratados"] );  
                    } catch (Exception $e) {  $d1["Fecha de inicio de los servicios contratados"] = ""; }
                }else{ $d1["Fecha de inicio de los servicios contratados"] = "";}
                */

                $con = array(
                    "idCampo" => "333959", 
                    "valor" => array(
                        array(
                            "numeroRegistro" => 1,
                            "IdRegistro" => "",
                            "campos" => array(
                                array("idCampo" => "43275", "valor" => $d1["Fecha de inicio de los servicios contratados"] ),
                                array("idCampo" => "43276", "valor" => $d1["numero_contrato"] ),
                                array("idCampo" => "43277", "valor" => $d1["objeto_contrato"] ),
                                array("idCampo" => "43278", "valor" => $d1["Hipervínculo al contrato firmado"] ),
                                array("idCampo" => "43279", "valor" => $d1["Hipervínculo al convenio modificatorio en su caso"] ),
                                array("idCampo" => "43280", "valor" => $d1["Monto total del contrato"] ),
                                array("idCampo" => "43281", "valor" => $d1["Monto pagado al periodo publicado"] ),
                                array("idCampo" => "43282", "valor" => $d1["Fecha de inicio de los servicios contratados"] ),
                                array("idCampo" => "43283", "valor" => $d1["Fecha de término de los servicios contratados"] ),
                                array("idCampo" => "43284", "valor" => $d1["numeros_factura"] ),
                                array("idCampo" => "43285", "valor" => $d1["files_factura_pdf"] )/*,
                                array("idCampo" => "333967", "valor" => $d1["area_responsable"] ),
                                array("idCampo" => "333961", "valor" => $d1["fecha_actualizacion"] ),
                                array("idCampo" => "333954", "valor" => $d1["fecha_validacion"] ),
                                array("idCampo" => "333966", "valor" => $d1["nota"] )*/
                            ) 
                        ) 
                    ) 
                );

                $pro = array(
                    "idCampo" => "333958", 
                    "valor" => array(
                        array(
                            "numeroRegistro" => 1,
                            "IdRegistro" => "",
                            "campos" => array(
                                array("idCampo" => "43265", "valor" => $d2['partida'] ), //Partida
                                array("idCampo" => "43266", "valor" => $d2['concepto'] ), //Clave de Concepto
                                array("idCampo" => "43267", "valor" => $d2['nombre_concepto'] ), //Nombre del concepto
                                array("idCampo" => "43268", "valor" => $d2['presupuesto'] ), //Presupuesto asignado por concepto
                                array("idCampo" => "43269", "valor" => $d2['total_ejercido'] ), //Presupuesto ejercido al periodo reportado de cada partida
                                array("idCampo" => "43270", "valor" => $d2['modificado'] ), //presupuesto total ejercido por concepto
                                array("idCampo" => "43271", "valor" => $d2['denominacion_partida'] ), //Denominación de cada partida
                                array("idCampo" => "43272", "valor" => $d2['monto_presupuesto'] ), //Presupuesto total asignado a cada partida
                                array("idCampo" => "43273", "valor" => $d2['monto_modificacion'] ), //Presupuesto modificado por partida
                                array("idCampo" => "43274", "valor" => $d2['presupuesto'] ) //Presupuesto modificado por concepto
                            ) 
                        ) 
                    ) 
                );

                switch( $d3['nombre_procedimiento'] ) {
                    case "Licitación pública": $d3['nombre_procedimiento'] = 0;
                        break;
                    case "Adjudicación directa": $d3['nombre_procedimiento'] = 1;
                        break;
                    case "Invitación restringida": $d3['nombre_procedimiento'] = 2;
                        break;
                    default: break;
                }
                            
                $fac = array(
                    "idCampo" => "333957", 
                    "valor" => array(
                        array(
                            "numeroRegistro" => 1,
                            "IdRegistro" => "",
                            "campos" => array(
                                array("idCampo" => "43256", "valor" => $d3['nombre_razon_social'] ),
                                array("idCampo" => "43257", "valor" => $d3['nombres'] ),
                                array("idCampo" => "43258", "valor" => $d3['primer_apellido'] ),
                                array("idCampo" => "43259", "valor" => $d3['segundo_apellido'] ),
                                array("idCampo" => "43260", "valor" => $d3['rfc'] ),
                                array("idCampo" => "43261", "valor" => $d3['nombre_procedimiento'] ), //AQUI
                                array("idCampo" => "43262", "valor" => $d3['fundamento_juridico'] ),
                                array("idCampo" => "43263", "valor" => $d3['descripcion_justificacion'] ),
                                array("idCampo" => "43264", "valor" => $d3['nombre_comercial'] )
                            ) 
                        ) 
                    ) 
                );

                array_push( $_POST["registros"][0]['campos'], $con, $pro, $fac );
                break;

            case "43360":
                $table = "rel_pnt_campana_aviso2";
                $nombre_id_interno = "id_campana_aviso";

                $_POST["registros"][0]["campos"][1]["valor"] = $this->date_format($_POST["registros"][0]["campos"][1]["valor"]);
                $_POST["registros"][0]["campos"][2]["valor"] = $this->date_format($_POST["registros"][0]["campos"][2]["valor"]);
                $_POST["registros"][0]["campos"][5]["valor"] = $this->date_format($_POST["registros"][0]["campos"][5]["valor"]);
                $_POST["registros"][0]["campos"][6]["valor"] = $this->date_format($_POST["registros"][0]["campos"][6]["valor"]);
                break;

            case "43321":
                $table = "rel_pnt_campana_aviso";
                $nombre_id_interno = "id_campana_aviso";
                break;
        }

        $data = array(
            'idFormato' => $_POST["idFormato"], 
            'token' => $_POST["token"], 
            'correoUnidadAdministrativa' => $_POST["correoUnidadAdministrativa"], 
            'unidadAdministrativa' => $_POST["unidadAdministrativa"], 
            'SujetoObligado' => $_POST["SujetoObligado"], 
            'registros' => $_POST["registros"]
        );

        $options = array(
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode( $data ),
                'header'=>  "Content-Type: application/json\r\n" .
                            "Accept: application/json\r\n"
            )
        );

        $context  = stream_context_create( $options );
        $res = file_get_contents( $URL, false, $context );

        $result = json_decode( $res, true );

        $post_data = array();
        $post_data[$nombre_id_interno] = $_POST["_id_interno"];
        $post_data['id_pnt'] = $result['mensaje']['registros'][0]['idRegistro'];
        $post_data['estatus_pnt'] ='SUBIDO';
        
        if( $result["success"] ){
            $this->db->insert($table, $post_data);
            $result['id_tpo'] =  $this->db->insert_id();
        }

        $response = json_encode($result);
        header('Content-Type: application/json');
        echo json_encode($response);
    }


    function agregar_pnt1(){
        $URL = "http://devcarga.inai.org.mx:8080/sipot-web/spring/mantenimiento/agrega";
        
        $table = "rel_pnt_presupuesto";
        $nombre_id_interno = "id_presupuesto";
        

        switch ($_POST["idFormato"]) {
            case 43322:
                $table = "rel_pnt_presupuesto";
                $nombre_id_interno = "id_presupuesto";
                break;
            case 43320:
                $table = "rel_pnt_factura";
                $nombre_id_interno = "id_factura";
                $data2 = $this->_subtabla2($_POST["id_contrato"], $_POST["id_factura"]);
                
                $con = array(
                    "idCampo" => "333959", 
                    "valor" => array(
                        array(
                            "numeroRegistro" => 1,
                            "IdRegistro" => "",
                            "campos" => array(
                                array("idCampo" => "43282", "valor" => $data2['contratos'][0]["Fecha de inicio de los servicios contratados"] ),
                                array("idCampo" => "43283", "valor" => $data2['contratos'][0]["Fecha de término de los servicios contratados"] ),
                                array("idCampo" => "43278", "valor" => $data2['contratos'][0]["Hipervínculo al contrato firmado"] ),
                                array("idCampo" => "43279", "valor" => $data2['contratos'][0]["Hipervínculo al convenio modificatorio en su caso"] ),
                                array("idCampo" => "43281", "valor" => $data2['contratos'][0]["Monto pagado al periodo publicado"] ),
                                array("idCampo" => "43280", "valor" => $data2['contratos'][0]["Monto total del contrato"] ),
                                array("idCampo" => "333967", "valor" => $data2['contratos'][0]["area_responsable"] ),
                                array("idCampo" => "333961", "valor" => ($data2['contratos'][0]["fecha_actualizacion"] != null )? 
                                    join("/", array_reverse( split('-', $data2['contratos'][0]["fecha_actualizacion"] ) ) ) : ""  ),
                                //array("idCampo" => "333954", "valor" => $data2['contratos'][0]["fecha_validacion"] ),
                                array("idCampo" => "333954", "valor" => ($data2['contratos'][0]["fecha_validacion"] != null )? 
                                    join("/", array_reverse( split('-', $data2['contratos'][0]["fecha_validacion"] ) ) ) : ""  ),
                                array("idCampo" => "43285", "valor" => $data2['contratos'][0]["files_factura_pdf"] ),
                                array("idCampo" => "333966", "valor" => $data2['contratos'][0]["nota"] ),
                                array("idCampo" => "43276", "valor" => $data2['contratos'][0]["numero_contrato"] ),
                                array("idCampo" => "43284", "valor" => $data2['contratos'][0]["numeros_factura"] ),
                                array("idCampo" => "43277", "valor" => $data2['contratos'][0]["objeto_contrato"] )
                            ) 
                        ) 
                    ) 
                );

                $pro = array(
                    "idCampo" => "333958", 
                    "valor" => array(
                        array(
                            "numeroRegistro" => 1,
                            "IdRegistro" => "",
                            "campos" => array(
                                array("idCampo" => "43265", "valor" => $data2['presupuestos'][0]['partida'] ), //Partida
                                array("idCampo" => "43266", "valor" => $data2['presupuestos'][0]['concepto'] ), //Clave de Concepto
                                array("idCampo" => "43267", "valor" => $data2['presupuestos'][0]['nombre_concepto'] ), //Nombre del concepto
                                array("idCampo" => "43268", "valor" => $data2['presupuestos'][0]['presupuesto'] ), //Presupuesto asignado por concepto
                                array("idCampo" => "43269", "valor" => $data2['presupuestos'][0]['total_ejercido'] ), //Presupuesto ejercido al periodo reportado de cada partida
                                array("idCampo" => "43270", "valor" => $data2['presupuestos'][0]['modificado'] ), //presupuesto total ejercido por concepto
                                array("idCampo" => "43271", "valor" => $data2['presupuestos'][0]['denominacion_partida'] ), //Denominación de cada partida
                                array("idCampo" => "43272", "valor" => $data2['presupuestos'][0]['monto_presupuesto'] ), //Presupuesto total asignado a cada partida
                                array("idCampo" => "43273", "valor" => $data2['presupuestos'][0]['monto_modificacion'] ), //Presupuesto modificado por partida
                                array("idCampo" => "43274", "valor" => $data2['presupuestos'][0]['presupuesto'] ) //Presupuesto modificado por concepto
                            ) 
                        ) 
                    ) 
                );
                            
                $fac = array(
                    "idCampo" => "333957", 
                    "valor" => array(
                        array(
                            "numeroRegistro" => 1,
                            "IdRegistro" => "",
                            "campos" => array(
                                array("idCampo" => "43256", "valor" => $data2['facturas'][0]['nombre_razon_social'] ),
                                array("idCampo" => "43257", "valor" => $data2['facturas'][0]['nombres'] ),
                                array("idCampo" => "43258", "valor" => $data2['facturas'][0]['primer_apellido'] ),
                                array("idCampo" => "43259", "valor" => $data2['facturas'][0]['segundo_apellido'] ),
                                array("idCampo" => "43260", "valor" => $data2['facturas'][0]['rfc'] ),
                                array("idCampo" => "43261", "valor" => $data2['facturas'][0]['nombre_procedimiento'] ),
                                array("idCampo" => "43262", "valor" => $data2['facturas'][0]['fundamento_juridico'] ),
                                array("idCampo" => "43263", "valor" => $data2['facturas'][0]['descripcion_justificacion'] ),
                                array("idCampo" => "43264", "valor" => $data2['facturas'][0]['nombre_comercial'] )
                            ) 
                        ) 
                    ) 
                );

                array_push( $_POST["registros"][0]['campos'], $con, $pro, $fac );
                break;

            case 43360:
                $table = "rel_pnt_campana_aviso2";
                $nombre_id_interno = "id_campana_aviso";
                break;

            case 43321:
                $table = "rel_pnt_campana_aviso";
                $nombre_id_interno = "id_campana_aviso";
                break;
        }

        $data = array(
            'idFormato' => $_POST["idFormato"], 
            'token' => $_POST["token"], 
            'correoUnidadAdministrativa' => $_POST["correoUnidadAdministrativa"], 
            'unidadAdministrativa' => $_POST["unidadAdministrativa"], 
            'SujetoObligado' => $_POST["SujetoObligado"], 
            'registros' => $_POST["registros"]
        );

        $options = array(
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode( $data ),
                'header'=>  "Content-Type: application/json\r\n" .
                            "Accept: application/json\r\n"
            )
        );


        $context  = stream_context_create( $options );
        $res = file_get_contents( $URL, false, $context );

        $result = json_decode( $res, true, 4 );

        if( $result["success"] ){
            $pntid = $result["mensaje"]["registros"][0]["idRegistro"]; 
            $post_data = array();

            $post_data[ $nombre_id_interno ] = $_POST["_id_interno"];
            $post_data['id_pnt'] = $pntid;
            $post_data['estatus_pnt'] ='SUBIDO';

            $this->db->insert($table, $post_data);
            $result['id_tpo'] =  $this->db->insert_id();
            $result['id_pnt'] =   $pntid;

        }
        
        $response = json_encode($result);
        //$response = json_encode($result);
        header('Content-Type: application/json');
        echo $response;
    }


    function eliminar_pnt(){
        $URL = "http://devcarga.inai.org.mx:8080/sipot-web/spring/mantenimiento/elimina";
        $data = array( 
            "idFormato" => $_POST["idFormato"],
            "correoUnidadAdministrativa" => $_POST["correoUnidadAdministrativa"],  
            "token" => $_POST["token"],  
            "registros" => $_POST["registros"]
        );
        
        $options = array(
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode( $data ),
                'header'=>  "Content-Type: application/json\r\n" .
                            "Accept: application/json\r\n"
            )
        );

        $context  = stream_context_create( $options );
        $res = file_get_contents( $URL, false, $context );
        $result = json_decode( $res, true );

         switch ($_POST["idFormato"]) {
            case 43322:
                $table = "rel_pnt_presupuesto";
                break;
            case 43320:
                $table = "rel_pnt_factura";
                break;
            case 43360:
                $table = "rel_pnt_campana_aviso2";
                break;
             case 43321:
                $table = "rel_pnt_campana_aviso";
                break;
        }



        if( $result["success"] ){
            $stm  = "DELETE FROM " . $table . " WHERE id_pnt = '" . $_POST["id_pnt"] . "'";
            $this->db->query($stm);                                                                                                                              
        }

        header('Content-Type: application/json');
        echo json_encode($result);
        
    }


    function traer_formatos(){
        $URL = "http://devcarga.inai.org.mx:8080/sipot-web/spring/informacionFormato/obtenerFormatos";
        $request = array( "token" => strval($_SESSION['pnt']->token->token) );

        // Al parecer no necesita "concentradora" ni "codigoSO" 
        //$request = array("token" => strval($_SESSION['pnt']->token->token), "concentradora" => 2, "codigoSO" => "INAI" );

        $options = array(
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode($request),
                'header'=>  "Content-Type: application/json\r\n" . "Accept: application/json\r\n"
            )
        );
        
        $context  = stream_context_create($options);
        $result = file_get_contents($URL, false, $context);

        //session_start();

        $data["formatos"] = json_decode($result);

        header('Content-Type: application/json');
        echo json_encode( $data["formatos"] ); 

        //$this->load->view('/tpoadminv1/logo/ver_formatos', $data);

    }

    function panel_pnt(){
        $this->load->view('/tpoadminv1/logo/panel_pnt');
    }

    function traer_campos(){
        $URL = "http://devcarga.inai.org.mx:8080/sipot-web/spring/informacionFormato/camposFormato";

        $idFormato = ( isset($_GET["idFormato"]) )? $_GET["idFormato"] : 22532; /* Quitar valor de prueba*/

        $request = array("token" => strval($_SESSION['pnt']->token->token), "idFormato" => $idFormato );

        $options = array(
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode($request),
                'header'=>  "Content-Type: application/json\r\n" . "Accept: application/json\r\n"
            )
        );
        
        $context  = stream_context_create($options);
        $result = file_get_contents($URL, false, $context);

        //session_start();

        $data["formatos"] = json_decode($result);

        header('Content-Type: application/json');
        echo json_encode( $data["formatos"] ); 
    }

    /**/
    function traer_campo(){
        $URL = "http://devcarga.inai.org.mx:8080/sipot-web/spring/informacionFormato/campoCatalogo";

        $idCampo = ( isset($_GET["idCampo"]) )? $_GET["idCampo"] : 10658; /* Quitar valor de prueba*/

        $request = array("token" => strval($_SESSION['pnt']->token->token), "idCampo" => $idCampo );

        $options = array(
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode($request),
                'header'=>  "Content-Type: application/json\r\n" . "Accept: application/json\r\n"
            )
        );
        
        $context  = stream_context_create($options);
        $result = file_get_contents($URL, false, $context);


        $data["formatos"] = json_decode($result);

        header('Content-Type: application/json');
        echo json_encode( $data["formatos"] ); 
    }

    function ejercicios(){ 
        $query = $this->db->query("SELECT ejercicio FROM cat_ejercicios WHERE active = 1");
        $rows = $query->result_array();

        header('Content-Type: application/json');
        echo json_encode( $rows ); 
    }

    private function _subtabla2($id_contrato, $id_factura){
        $data = array();
        //Datos de Factura
        $cols = array("pnt.id_tpo", "pnt.id_proveedor id", "pnt.id_pnt", "con.descripcion_justificacion", 
                      "e.ejercicio", "proc.nombre_procedimiento", "con.fundamento_juridico", 
                      "prov.nombre_razon_social", "prov.nombres", "prov.primer_apellido", 
                      "prov.segundo_apellido", "prov.nombre_comercial", "prov.rfc", "pnt.estatus_pnt", 
                      "fd.id_presupuesto_concepto");

        foreach ($cols as &$col) {
            $tag = $col;
            if( strpos($col, " ") ) {
                $col_arr = explode(" ", $col); $col = $col_arr[0]; $tag = $col_arr[1];
            } else if ( strpos($col, ".") ) $tag = explode(".", $col)[1];
            $col = "IFNULL(" . $col . ", '') AS $tag";
        }

        $query = $this->db->query("SELECT " . join(", ", $cols) . " FROM tab_facturas f
                    JOIN tab_facturas_desglose fd ON fd.id_factura = f.id_factura
                    JOIN tab_campana_aviso cam ON cam.id_campana_aviso = fd.id_campana_aviso
                    JOIN cat_ejercicios e ON e.id_ejercicio = cam.id_ejercicio 
                    JOIN tab_proveedores prov ON prov.id_proveedor = f.id_proveedor
                    LEFT JOIN tab_contratos con ON con.id_proveedor = prov.id_proveedor
                    LEFT JOIN cat_procedimientos proc ON proc.id_procedimiento = con.id_procedimiento
                    LEFT JOIN rel_pnt_proveedor pnt ON pnt.id_proveedor = prov.id_proveedor
                    WHERE f.id_factura = " . $id_factura . ";");



        $data["facturas"] = $query->result_array();

        // Datos del presupuesto
        $cols = array("pnt.id_presupuesto_desglose id_tpo", "pnt.id_pnt", "pnt.id", "ej.ejercicio", 
                       "pcon.partida", "pcon.concepto", "pcon.nombre_concepto", "total.presupuesto", 
                       "total.modificado", "pcon.denominacion_partida", "pdes.monto_presupuesto", 
                       "pdes.monto_modificacion", "fact.total_ejercido", "pnt.estatus_pnt");

        foreach ($cols as &$col) {
            $tag = $col;
            if( strpos($col, " ") ) {
                $col_arr = explode(" ", $col); $col = $col_arr[0]; $tag = $col_arr[1];
            } else if ( strpos($col, ".") ) $tag = explode(".", $col)[1];
            $col = "IFNULL(" . $col . ", '') AS $tag";
        }

            $query = $this->db->query("SELECT " . join(", ", $cols) . " FROM tab_presupuestos_desglose pdes 
                    JOIN tab_presupuestos pre ON pre.id_presupuesto = pdes.id_presupuesto
                    JOIN cat_ejercicios ej ON ej.id_ejercicio = pre.id_ejercicio
                    LEFT JOIN (SELECT p.id_presupesto_concepto, c.concepto, c.denominacion 'nombre_concepto', 
                               p.partida, p.denominacion 'denominacion_partida'
                          FROM (SELECT id_presupesto_concepto, concepto, partida, denominacion FROM cat_presupuesto_conceptos pc
                              WHERE trim(coalesce(concepto, '')) <> '' AND trim(coalesce(partida, '')) <> '' ) p 
                          JOIN (SELECT concepto, denominacion FROM cat_presupuesto_conceptos
                              WHERE trim(coalesce(concepto, '')) <>'' AND trim(coalesce(partida, '')) = '') c
                          ON c.concepto = p.concepto) pcon 
                    ON pcon.id_presupesto_concepto = pdes.id_presupuesto_concepto
                    LEFT JOIN (
                        ( SELECT pcon.id_presupesto_concepto, pcon.concepto, 
                                  SUM(pdes.monto_presupuesto) presupuesto, SUM(pdes.monto_modificacion) modificado
                           FROM tab_presupuestos_desglose pdes
                           JOIN (SELECT id_presupesto_concepto, p.concepto
                                 FROM (SELECT id_presupesto_concepto, concepto FROM cat_presupuesto_conceptos pc
                                     WHERE trim(coalesce(concepto, '')) <> '' AND trim(coalesce(partida, '')) <> '' ) p 
                                 JOIN (SELECT concepto FROM cat_presupuesto_conceptos
                                     WHERE trim(coalesce(concepto, '')) <>'' AND trim(coalesce(partida, '')) = '') c
                                 ON c.concepto = p.concepto) pcon 
                           ON pcon.id_presupesto_concepto = pdes.id_presupuesto_concepto
                           GROUP BY pcon.concepto, pcon.id_presupesto_concepto)
                    ) total ON total.id_presupesto_concepto = pdes.id_presupuesto_concepto
                    LEFT JOIN (SELECT numero_partida, id_factura, SUM(cantidad) total_ejercido 
                        FROM tab_facturas_desglose WHERE id_factura = " . $id_factura . " 
                        GROUP BY numero_partida, id_factura 
                    ) fact ON fact.numero_partida = pcon.partida 
                    LEFT JOIN rel_pnt_presupuesto_desglose pnt ON pnt.id_presupuesto_desglose = pdes.id_presupuesto_desglose");
        
        $rows = $query->result_array();
        $data["presupuestos"] = $query->result_array();

        /**/
        //Datos de Contrato
        $cols = array("pnt.id_contrato id_tpo", "pnt.id_pnt id_pnt", "pnt.id", "ej.ejercicio", 
                      "cont.fecha_celebracion", "cont.numero_contrato", "cont.objeto_contrato", 
                      "f.numeros_factura", "f.files_factura_pdf", "cont.area_responsable", 
                      "cont.fecha_validacion", "cont.fecha_actualizacion", "cont.nota", "pnt.estatus_pnt");

        foreach ($cols as &$col) {
            $tag = $col;
            if( strpos($col, " ") ) {
                $col_arr = explode(" ", $col); $tag = array_pop($col_arr); $col = join(" ", $col_arr);
            } else if ( strpos($col, ".") ) $tag = explode(".", $col)[1];
            $col = "IFNULL(" . $col . ", '') AS $tag";
        }

        $query = $this->db->query("SELECT " . join(", ", $cols) . ",
                        IFNULL(vcon.`Archivo contrato en PDF (Vinculo al archivo)` , '') AS 'Hipervínculo al contrato firmado',
                        IFNULL(vcmod.`Archivo convenio en PDF (Vinculo al archivo)` , '') AS 'Hipervínculo al convenio modificatorio en su caso',
                        IFNULL(vcon.`Monto original del contrato` , '') AS 'Monto total del contrato',
                        IFNULL(vcon.`Monto pagado a la fecha` , '') AS 'Monto pagado al periodo publicado',
                        IFNULL(vcon.`Fecha inicio` , '') AS 'Fecha de inicio de los servicios contratados',
                        IFNULL(vcon.`Fecha fin` , '') AS 'Fecha de término de los servicios contratados'
                    FROM tab_contratos cont
                    LEFT JOIN vout_contratos vcon ON vcon.`ID (Número de contrato)` = cont.id_contrato
                    LEFT JOIN vout_convenios_modificatorios vcmod ON vcmod.`ID (Número de contrato)` = cont.id_contrato
                    LEFT JOIN (SELECT f.id_contrato, f.numero_factura numeros_factura, 
                                  f.file_factura_pdf files_factura_pdf, f.id_ejercicio
                               FROM tab_facturas f ) f ON f.id_contrato = cont.id_contrato
                    LEFT JOIN cat_ejercicios ej ON ej.id_ejercicio = f.id_ejercicio
                    LEFT JOIN rel_pnt_contrato pnt ON pnt.id_contrato = cont.id_contrato
                    WHERE cont.id_contrato = " . $id_contrato . ";");

        $data["contratos"] = $query->result_array();
        return $data;
    }


    private function _subtabla3($id_factura_desglose){
        $data = array();
        //Datos de Factura
        $cols = array("pnt.id_presupuesto_desglose id_tpo", "pnt.id_pnt", "pnt.id", "ej.ejercicio", 
                      "pcon.denominacion_partida", "pdes.monto_presupuesto", "fact.total_ejercido", 
                      "pnt.estatus_pnt");

        foreach ($cols as &$col) {
            $tag = $col;
            if( strpos($col, " ") ) {
                $col_arr = explode(" ", $col); $col = $col_arr[0]; $tag = $col_arr[1];
            } else if ( strpos($col, ".") ) $tag = explode(".", $col)[1];
            $col = "IFNULL(" . $col . ", '') AS $tag";
        }
        /*

        $query = $this->db->query("SELECT " . join(", ", $cols) . " FROM tab_presupuestos_desglose pdes
                JOIN (SELECT p.id_presupesto_concepto, c.concepto, c.denominacion 'nombre_concepto', 
                           p.partida, p.denominacion 'denominacion_partida'
                      FROM (SELECT id_presupesto_concepto, concepto, partida, denominacion FROM cat_presupuesto_conceptos pc
                          WHERE trim(coalesce(concepto, '')) <> '' AND trim(coalesce(partida, '')) <> '' ) p 
                      JOIN (SELECT concepto, denominacion FROM cat_presupuesto_conceptos
                          WHERE trim(coalesce(concepto, '')) <>'' AND trim(coalesce(partida, '')) = '') c
                      ON c.concepto = p.concepto
                ) pcon ON pcon.id_presupesto_concepto = pdes.id_presupuesto_concepto
                LEFT JOIN (
                    SELECT numero_partida, id_factura_desglose, SUM(cantidad) total_ejercido 
                    FROM tab_facturas_desglose fdes 
                    GROUP BY numero_partida, id_factura_desglose
                ) fact ON fact.numero_partida = pcon.partida
                JOIN tab_presupuestos pre ON pre.id_presupuesto = pdes.id_presupuesto
                JOIN cat_ejercicios ej ON ej.id_ejercicio = pre.id_ejercicio
                LEFT JOIN rel_pnt_presupuesto_desglose2 pnt 
                    ON pnt.id_presupuesto_desglose = pdes.id_presupuesto_desglose
                WHERE fact.id_factura_desglose =" . $id_factura_desglose);

        */
        $query = $this->db->query("SELECT " . join(", ", $cols) . " FROM tab_presupuestos_desglose pdes 
            JOIN ( SELECT p.id_presupesto_concepto, c.concepto, c.denominacion 'nombre_concepto', p.partida, p.denominacion 'denominacion_partida' 
                FROM (SELECT id_presupesto_concepto, concepto, partida, denominacion 
                      FROM cat_presupuesto_conceptos pc 
                      WHERE trim(coalesce(concepto, '')) <> '' 
                      AND trim(coalesce(partida, '')) <> '' ) p 
                JOIN (SELECT concepto, denominacion FROM cat_presupuesto_conceptos 
                      WHERE trim(coalesce(concepto, '')) <>'' 
                      AND trim(coalesce(partida, '')) = '') c 
                ON c.concepto = p.concepto 
            ) pcon ON pcon.id_presupesto_concepto = pdes.id_presupuesto_concepto 
            JOIN tab_presupuestos pre ON pre.id_presupuesto = pdes.id_presupuesto 
            JOIN cat_ejercicios ej ON ej.id_ejercicio = pre.id_ejercicio 
            JOIN ( SELECT  fdes.id_factura_desglose, pc.partida partida, ej.ejercicio, SUM(fdes.cantidad) total_ejercido
                    FROM tab_facturas_desglose fdes 
                    JOIN tab_facturas f ON f.id_factura = fdes.id_factura
                    JOIN cat_ejercicios ej ON ej.id_ejercicio = f.id_ejercicio 
                    JOIN cat_presupuesto_conceptos pc ON pc.id_presupesto_concepto = fdes.id_presupuesto_concepto
                    WHERE fdes.id_factura_desglose = " . $id_factura_desglose . "
                  ) fact ON fact.partida = pcon.partida AND fact.ejercicio = ej.ejercicio
            LEFT JOIN rel_pnt_presupuesto_desglose2 pnt ON pnt.id_presupuesto_desglose = pdes.id_presupuesto_desglose;");
        $data["presupuesto_desglose"] = $query->result_array();
        
        return $data;
    }

    function registros(){ 
        $cols = array("pnt.id_tpo", "pnt.id_pnt", "p.id_presupuesto", "e.ejercicio", 
                      "p.fecha_inicio_periodo", "p.id_sujeto_obligado", "p.fecha_termino_periodo", "p.denominacion", 
                      "p.fecha_publicacion", "p.file_programa_anual", "p.area_responsable", 
                      "p.fecha_validacion", "p.fecha_actualizacion", "p.nota", "pnt.estatus_pnt");

        foreach ($cols as &$col) {
            $tag = $col;
            if( strpos($col, " ") ) {
                $col_arr = explode(" ", $col); $col = $col_arr[0]; $tag = $col_arr[1];
            } else if ( strpos($col, ".") ) $tag = explode(".", $col)[1];
            $col = "IFNULL(" . $col . ", '') AS $tag";
        }
        
        $cond = "WHERE p.id_sujeto_obligado = " . $_SESSION["id_sujeto_obligado"];
        if($_SESSION["rol"] == "admin"){
            $cond .= " OR p.id_sujeto_obligado IN"
                  . "   (SELECT id_sujeto_obligado FROM unidades_so WHERE id_concentrador = " .  $_SESSION["id_sujeto_obligado"] . ")";
        }

        $stm = "SELECT " . join(", ", $cols) . " FROM tab_presupuestos p "
             . "JOIN cat_ejercicios e ON p.id_ejercicio = e.id_ejercicio "
             . "LEFT JOIN rel_pnt_presupuesto pnt ON p.id_presupuesto = pnt.id_presupuesto ";
             //. $cond;
        

        $query = $this->db->query($stm);
        $rows = $query->result_array();

        header('Content-Type: application/json');
        echo json_encode( $rows ); 
    }
    
    function registros2(){
        $cols = array("pnt.id_tpo", "pnt.id_pnt", "f.id_factura", "e.ejercicio", 
                      "fd.area_administrativa",  "fd.id_servicio_clasificacion", 
                      "scat.nombre_servicio_categoria",  "sscat.id_servicio_subcategoria", 
                      "suni.nombre_servicio_unidad", "cam.nombre_campana_aviso", "cam.periodo", 
                      "ctem.nombre_campana_tema", "cobj.campana_objetivo", "cam.objetivo_comunicacion", 
                      "fd.precio_unitarios", "cam.clave_campana", "cam.autoridad", 
                      "cam.campana_ambito_geo", "cam.fecha_inicio fecha_inicio_cam", 
                      "cam.fecha_termino fecha_termino_cam", "lugar.poblaciones", "edu.nivel_educativo", 
                      "edad.rangos_edad", "neco.poblacion_nivel", "f.area_responsable", 
                      "f.fecha_validacion", "f.fecha_actualizacion", "f.nota", "pnt.estatus_pnt");

        foreach ($cols as &$col) {
            $tag = $col;
            if( strpos($col, " ") ) {
                $col_arr = explode(" ", $col); $col = $col_arr[0]; $tag = $col_arr[1];
            } else if ( strpos($col, ".") ) $tag = explode(".", $col)[1];
            $col = "IFNULL(" . $col . ", '') AS $tag";
        }

        $query = $this->db->query("SELECT " . join(", ", $cols) . ", 
                    CONCAT(CASE 
                        WHEN f.id_trimestre = NULL THEN '' WHEN f.id_trimestre = 1 THEN '01/01/'
                        WHEN f.id_trimestre = 2 THEN '01/04/' WHEN f.id_trimestre = 3 THEN '01/07/'
                        WHEN f.id_trimestre = 4 THEN '01/10/'
                    END, IFNULL(e.ejercicio, '') ) fecha_inicio, 
                    CONCAT(CASE 
                        WHEN f.id_trimestre = NULL THEN '' WHEN f.id_trimestre = 1 THEN '31/03/'
                        WHEN f.id_trimestre = 2 THEN '30/06/'  WHEN f.id_trimestre = 3 THEN '30/09/'
                        WHEN f.id_trimestre = 4 THEN '31/12/'
                    END, IFNULL(e.ejercicio, '') ) fecha_termino, 
                    (CASE 
                        WHEN ( (fd.id_so_contratante IS NULL) && (fd.id_so_solicitante IS NULL) ) THEN ''
                        WHEN ( (fd.id_so_contratante IS NOT NULL) && (fd.id_so_solicitante IS NOT NULL) ) THEN 2
                        WHEN ( (fd.id_so_contratante IS NOT NULL) && (fd.id_so_solicitante IS NULL) ) THEN 0
                        WHEN ( (fd.id_so_contratante IS NULL) && (fd.id_so_solicitante IS NOT NULL) ) THEN 1
                    END) funcion_sujeto,
                    (CASE 
                        WHEN cam.id_campana_tipo= NULL THEN '' 
                        WHEN cam.id_campana_tipo = 1 THEN 1
                        WHEN cam.id_campana_tipo = 2 THEN 0
                    END) 'tipo',
                    (CASE 
                        WHEN ccob.id_campana_cobertura = NULL THEN '' 
                        WHEN ccob.id_campana_cobertura = 1 THEN 3
                        WHEN ccob.id_campana_cobertura = 2 THEN 2 
                        WHEN ccob.id_campana_cobertura = 3 THEN 1
                        WHEN ccob.id_campana_cobertura = 4 THEN 0
                    END) 'cobertura', 
                    (CASE 
                        WHEN sexo.poblacion_sexo = NULL THEN '' 
                        WHEN sexo.poblacion_sexo = 1 THEN 1
                        WHEN sexo.poblacion_sexo = 2 THEN 0 
                        WHEN sexo.poblacion_sexo = 3 THEN 2
                    END) 'sexo', 
                    CONCAT(f.id_ejercicio, '-', f.id_factura, '-', f.id_orden_compra, '-', f.id_contrato, '-', f.id_proveedor) 'resp_pro_con', 
                    CONCAT(f.id_ejercicio, '-', f.id_factura, '-', f.id_orden_compra, '-', f.id_contrato, '-', f.id_proveedor) 'resp_rec_pre', 
                    CONCAT(f.id_ejercicio, '-', f.id_factura, '-', f.id_orden_compra, '-', f.id_contrato, '-', f.id_proveedor) 'resp_con_mon'
                FROM tab_facturas f
                JOIN tab_facturas_desglose fd ON fd.id_factura = f.id_factura
                JOIN tab_campana_aviso cam ON cam.id_campana_aviso = fd.id_campana_aviso
                JOIN cat_servicios_clasificacion scla ON scla.id_servicio_clasificacion = fd.id_servicio_clasificacion
                JOIN cat_servicios_categorias scat ON scat.id_servicio_categoria = fd.id_servicio_categoria 
                JOIN cat_servicios_subcategorias sscat ON sscat.id_servicio_subcategoria = fd.id_servicio_subcategoria 
                JOIN cat_servicios_unidades suni ON suni.id_servicio_unidad = fd.id_servicio_unidad 
                JOIN cat_campana_coberturas ccob ON ccob.id_campana_cobertura = cam.id_campana_cobertura
                JOIN cat_ejercicios e ON e.id_ejercicio = cam.id_ejercicio 
                JOIN cat_campana_temas ctem ON ctem.id_campana_tema = cam.id_campana_tema 
                JOIN cat_campana_objetivos cobj ON cobj.id_campana_objetivo = cam.id_campana_objetivo 
                LEFT JOIN (SELECT reda.id_campana_aviso, GROUP_CONCAT(eda.nombre_poblacion_grupo_edad) rangos_edad
                    FROM rel_campana_grupo_edad reda
                    JOIN cat_poblacion_grupo_edad eda ON eda.id_poblacion_grupo_edad = reda.id_poblacion_grupo_edad
                    GROUP BY reda.id_campana_aviso
                ) edad ON edad.id_campana_aviso = cam.id_campana_aviso
                LEFT JOIN (SELECT rsex.id_campana_aviso, GROUP_CONCAT(sex.id_poblacion_sexo) poblacion_sexo
                    FROM rel_campana_sexo rsex
                    JOIN cat_poblacion_sexo sex ON sex.id_poblacion_sexo = rsex.id_poblacion_sexo
                    GROUP BY rsex.id_campana_aviso
                ) sexo ON sexo.id_campana_aviso = cam.id_campana_aviso 
                LEFT JOIN rel_campana_sexo rsex ON rsex.id_campana_aviso = cam.id_campana_aviso 
                LEFT JOIN ( SELECT id_campana_aviso, GROUP_CONCAT(poblacion_lugar) poblaciones 
                    FROM rel_campana_lugar GROUP BY id_campana_aviso) lugar ON lugar.id_campana_aviso = cam.id_campana_aviso
                LEFT JOIN (SELECT cne.id_campana_aviso, GROUP_CONCAT(ne.nombre_poblacion_nivel_educativo) nivel_educativo 
                    FROM rel_campana_nivel_educativo cne
                    JOIN cat_poblacion_nivel_educativo ne ON ne.id_poblacion_nivel_educativo = cne.id_poblacion_nivel_educativo
                    GROUP BY cne.id_campana_aviso) edu ON edu.id_campana_aviso = cam.id_campana_aviso
                LEFT JOIN (SELECT cn.id_campana_aviso, GROUP_CONCAT(pn.nombre_poblacion_nivel) poblacion_nivel 
                    FROM rel_campana_nivel cn
                    JOIN cat_poblacion_nivel pn ON pn.id_poblacion_nivel = cn.id_poblacion_nivel
                    GROUP BY cn.id_campana_aviso) neco ON neco.id_campana_aviso = cam.id_campana_aviso
                LEFT JOIN rel_pnt_factura pnt ON pnt.id_factura = f.id_factura
                ORDER BY pnt.id_tpo DESC");

        $rows = $query->result_array();

        header('Content-Type: application/json');
        echo json_encode( $rows ); 
    }

    function registros21(){
        $cols = array("pnt.id_tpo", "pnt.id_proveedor id", "f.id_factura", "con.descripcion_justificacion", 
                      "e.ejercicio", "proc.nombre_procedimiento", "con.fundamento_juridico", 
                      "prov.nombre_razon_social", "prov.nombres", "prov.primer_apellido", 
                      "prov.segundo_apellido", "prov.nombre_comercial", "prov.rfc", "pnt.estatus_pnt");

        foreach ($cols as &$col) {
            $tag = $col;
            if( strpos($col, " ") ) {
                $col_arr = explode(" ", $col); $col = $col_arr[0]; $tag = $col_arr[1];
            } else if ( strpos($col, ".") ) $tag = explode(".", $col)[1];
            $col = "IFNULL(" . $col . ", '') AS $tag";
        }


        $query = $this->db->query("SELECT " . join(", ", $cols) . " FROM tab_facturas f
                    JOIN tab_facturas_desglose fd ON fd.id_factura = f.id_factura
                    JOIN tab_campana_aviso cam ON cam.id_campana_aviso = fd.id_campana_aviso
                    JOIN cat_ejercicios e ON e.id_ejercicio = cam.id_ejercicio 
                    JOIN tab_proveedores prov ON prov.id_proveedor = f.id_proveedor
                    LEFT JOIN tab_contratos con ON con.id_proveedor = prov.id_proveedor
                    LEFT JOIN cat_procedimientos proc ON proc.id_procedimiento = con.id_procedimiento
                    LEFT JOIN rel_pnt_proveedor pnt ON pnt.id_proveedor = prov.id_proveedor;");

        $rows = $query->result_array();

        header('Content-Type: application/json');
        echo json_encode( $rows ); 
    }

    function registros50(){
        $data = $this->_subtabla2($_GET["id_contrato"], $_GET["id_factura"]);
        header('Content-Type: application/json');
        echo json_encode( $data ); 
    }

    function registros51(){
        $data = $this->_subtabla3($_GET["id_factura_desglose"]);
        header('Content-Type: application/json');
        echo json_encode( $data ); 
    }

    function registros22(){
        $cols = array("pnt.id_presupuesto_desglose id_tpo", "pnt.id_pnt", "pnt.id", "ej.ejercicio", 
                       "pcon.partida", "pcon.capitulo", "pcon.nombre_concepto", "total.presupuesto", 
                       "total.modificado total_modificado", "pcon.denominacion_partida", "pdes.monto_presupuesto", 
                       "pdes.monto_modificacion", "fact.total_ejercido", "pnt.estatus_pnt");

        foreach ($cols as &$col) {
            $tag = $col;
            if( strpos($col, " ") ) {
                $col_arr = explode(" ", $col); $col = $col_arr[0]; $tag = $col_arr[1];
            } else if ( strpos($col, ".") ) $tag = explode(".", $col)[1];
            $col = "IFNULL(" . $col . ", '') AS $tag";
        }

        $query = $this->db->query("SELECT " . join(", ", $cols) . " FROM tab_presupuestos_desglose pdes 
                    JOIN tab_presupuestos pre ON pre.id_presupuesto = pdes.id_presupuesto
                    JOIN cat_ejercicios ej ON ej.id_ejercicio = pre.id_ejercicio
                    JOIN (SELECT p.id_presupesto_concepto, c.capitulo, c.denominacion 'nombre_concepto', 
                               p.partida, p.denominacion 'denominacion_partida'
                          FROM (SELECT id_presupesto_concepto, capitulo, partida, denominacion FROM cat_presupuesto_conceptos pc
                              WHERE trim(coalesce(capitulo, '')) <> '' AND trim(coalesce(partida, '')) <> '' ) p 
                          JOIN (SELECT capitulo, denominacion FROM cat_presupuesto_conceptos
                              WHERE trim(coalesce(capitulo, '')) <>'' AND trim(coalesce(partida, '')) = '') c
                          ON c.capitulo = p.capitulo) pcon 
                    ON pcon.id_presupesto_concepto = pdes.id_presupuesto_concepto
                    JOIN (
                        ( SELECT pcon.id_presupesto_concepto, pcon.concepto, 
                                  SUM(pdes.monto_presupuesto) presupuesto, SUM(pdes.monto_modificacion) modificado
                           FROM tab_presupuestos_desglose pdes
                           JOIN (SELECT id_presupesto_concepto, p.concepto
                                 FROM (SELECT id_presupesto_concepto, concepto FROM cat_presupuesto_conceptos pc
                                     WHERE trim(coalesce(concepto, '')) <> '' AND trim(coalesce(partida, '')) <> '' ) p 
                                 JOIN (SELECT concepto FROM cat_presupuesto_conceptos
                                     WHERE trim(coalesce(concepto, '')) <>'' AND trim(coalesce(partida, '')) = '') c
                                 ON c.concepto = p.concepto) pcon 
                           ON pcon.id_presupesto_concepto = pdes.id_presupuesto_concepto
                           GROUP BY pcon.concepto, pcon.id_presupesto_concepto)
                    ) total ON total.id_presupesto_concepto = pdes.id_presupuesto_concepto
                    LEFT JOIN (SELECT numero_partida, SUM(cantidad) total_ejercido 
                               FROM tab_facturas_desglose GROUP BY numero_partida) fact 
                         ON fact.numero_partida = pcon.partida 
                    LEFT JOIN rel_pnt_presupuesto_desglose pnt ON pnt.id_presupuesto_desglose = pdes.id_presupuesto_desglose");

        $rows = $query->result_array();

        header('Content-Type: application/json');
        echo json_encode( $rows ); 
    }

    function registros23(){
        $cols = array("pnt.id_contrato id_tpo", "pnt.id_pnt id_pnt", "pnt.id", "ej.ejercicio", 
                      "cont.fecha_celebracion", "cont.numero_contrato", "cont.objeto_contrato", 
                      "f.numeros_factura", "f.files_factura_pdf", "conv.file_convenio",
                      "pnt.estatus_pnt");

        foreach ($cols as &$col) {
            $tag = $col;
            if( strpos($col, " ") ) {
                $col_arr = explode(" ", $col); $tag = array_pop($col_arr); $col = join(" ", $col_arr);
            } else if ( strpos($col, ".") ) $tag = explode(".", $col)[1];
            $col = "IFNULL(" . $col . ", '') AS $tag";
        }

        $query = $this->db->query("SELECT " . join(", ", $cols) . ",
                IFNULL(vcon.`Archivo contrato en PDF (Vinculo al archivo)` , '') AS 'Hipervínculo al contrato firmado',
                IFNULL(vcon.`Monto original del contrato` , '') AS 'Monto total del contrato',
                IFNULL(vcon.`Monto pagado a la fecha` , '') AS 'Monto pagado al periodo publicado',
                IFNULL(vcon.`Fecha inicio` , '') AS 'Fecha de inicio de los servicios contratados',
                IFNULL(vcon.`Fecha fin` , '') AS 'Fecha de término de los servicios contratados'
            FROM tab_contratos cont
            LEFT JOIN vout_contratos vcon ON vcon.`ID (Número de contrato)` = cont.id_contrato
            LEFT JOIN vout_convenios_modificatorios vcmod ON vcmod.`ID (Número de contrato)` = cont.id_contrato
            LEFT JOIN (SELECT f.id_contrato, f.numero_factura numeros_factura, 
                       f.file_factura_pdf files_factura_pdf, f.id_ejercicio
                       FROM tab_facturas f ) f ON f.id_contrato = cont.id_contrato
            LEFT JOIN cat_ejercicios ej ON ej.id_ejercicio = f.id_ejercicio
            LEFT JOIN rel_pnt_contrato pnt ON pnt.id_contrato = cont.id_contrato
            LEFT JOIN tab_convenios_modificatorios conv ON conv.id_contrato = cont.id_contrato
            WHERE cont.numero_contrato != 'Sin contrato'; ");

        $rows = $query->result_array();

        header('Content-Type: application/json');
        echo json_encode( $rows ); 
    }

    function registros3(){
        $cols = array("pnt.id_campana_aviso id_tpo", "pnt.id_pnt", "cam.id_campana_aviso id", "ej.ejercicio", "cam.autoridad", 
                      "cam.fecha_inicio_periodo", "cam.fecha_termino_periodo", "so.nombre_sujeto_obligado", 
                      "ctip.nombre_campana_tipoTO", "cscat.nombre_servicio_categoria", "cam.clave_campana", 
                      "cam.descripcion_unidad", "cam.nombre_campana_aviso", "cam.campana_ambito_geo", 
                      "ccob.nombre_campana_cobertura", "sex.nombre_poblacion_sexo", "lug.poblacion_lugar", 
                      "edu.id_poblacion_nivel_educativo", "eda.nombre_poblacion_grupo_edad", 
                      "niv.nombre_poblacion_nivel", "cam.responsable_publisher", "cam.name_comercial", 
                      "cam.razones_supplier", "cam.monto_tiempo", "cam.difusion_mensaje", 
                      "cam.fecha_inicio", "cam.fecha_termino", "fac.id_factura", "cam.num_factura", "fac.area_responsable", 
                      "cam.fecha_validacion", "cam.fecha_actualizacion", "pnt.estatus_pnt", "cam.nota");

        foreach ($cols as &$col) {
            $tag = $col;
            if( strpos($col, " ") ) {
                $col_arr = explode(" ", $col); $tag = array_pop($col_arr); $col = join(" ", $col_arr);
            } else if ( strpos($col, ".") ) $tag = explode(".", $col)[1];
            $col = "IFNULL(" . $col . ", '') AS $tag";
        }
        $query = $this->db->query("SELECT " . join(", ", $cols) . " 
                    -- 'Presupuesto total asignado y ejercido de cada partida',
                  FROM tab_campana_aviso cam
                  JOIN cat_ejercicios ej ON ej.id_ejercicio = cam.id_ejercicio
                  JOIN tab_facturas_desglose fdes ON fdes.id_campana_aviso = cam.id_campana_aviso
                  JOIN tab_facturas fac ON fac.id_factura = fdes.id_factura
                    -- JOIN tab_proveedores prov ON prov.id_proveedor = fac.id_proveedor
                    -- JOIN tab_ordenes_compra ord ON ord.id_proveedor = fac.id_proveedor
                  LEFT JOIN cat_servicios_categorias cscat ON cscat.id_servicio_categoria = cam.id_servicio_categoria
                  JOIN tab_sujetos_obligados so ON so.id_sujeto_obligado = cam.id_so_solicitante
                  JOIN cat_campana_tiposTO ctip ON ctip.id_campana_tipoTO = cam.id_campana_tipoTO
                  JOIN cat_campana_coberturas ccob ON ccob.id_campana_cobertura = cam.id_campana_cobertura
                  JOIN (SELECT csex.id_campana_aviso, sex.nombre_poblacion_sexo
                        FROM rel_campana_sexo csex
                        JOIN cat_poblacion_sexo sex ON sex.id_poblacion_sexo = csex.id_poblacion_sexo) sex 
                  ON sex.id_campana_aviso = cam.id_campana_aviso
                  LEFT JOIN (SELECT clug.id_campana_aviso, clug.poblacion_lugar
                        FROM rel_campana_lugar clug
                        JOIN cat_poblacion_lugar lug ON lug.id_poblacion_lugar = clug.id_campana_lugar) lug
                  ON lug.id_campana_aviso = cam.id_campana_aviso
                  LEFT JOIN (SELECT cedu.id_campana_aviso, edu.id_poblacion_nivel_educativo
                        FROM rel_campana_nivel_educativo cedu
                        JOIN cat_poblacion_nivel_educativo edu ON edu.id_poblacion_nivel_educativo = cedu.id_rel_campana_nivel_educativo) edu
                  ON edu.id_campana_aviso = cam.id_campana_aviso
                  LEFT JOIN (SELECT ceda.id_campana_aviso, eda.nombre_poblacion_grupo_edad
                        FROM rel_campana_grupo_edad ceda
                        JOIN cat_poblacion_grupo_edad eda ON eda.id_poblacion_grupo_edad = ceda.id_rel_campana_grupo_edad) eda
                  ON eda.id_campana_aviso = cam.id_campana_aviso
                  JOIN (SELECT cniv.id_campana_aviso, GROUP_CONCAT(niv.nombre_poblacion_nivel) nombre_poblacion_nivel
                        FROM rel_campana_nivel cniv
                        JOIN cat_poblacion_nivel niv ON niv.id_poblacion_nivel = cniv.id_poblacion_nivel
                        GROUP BY cniv.id_campana_aviso) niv ON niv.id_campana_aviso = cam.id_campana_aviso
                  LEFT JOIN rel_pnt_campana_aviso2 pnt ON pnt.id_campana_aviso = cam.id_campana_aviso ;");

        $rows = $query->result_array();

        header('Content-Type: application/json');
        echo json_encode( $rows ); 
    }

    function registros31(){
        $cols = array("pnt.id_presupuesto_desglose id_tpo", "pnt.id_pnt", "pnt.id", "ej.ejercicio", 
                      "pcon.denominacion_partida", "fact2.total_monto_presupuesto", "fact.total_ejercido", 
                      "pnt.estatus_pnt");

        foreach ($cols as &$col) {
            $tag = $col;
            if( strpos($col, " ") ) {
                $col_arr = explode(" ", $col); $tag = array_pop($col_arr); $col = join(" ", $col_arr);
            } else if ( strpos($col, ".") ) $tag = explode(".", $col)[1];
            $col = "IFNULL(" . $col . ", '') AS $tag";
        }

        $query = $this->db->query("SELECT " . join(", ", $cols) . " FROM tab_presupuestos_desglose pdes
                JOIN (SELECT p.id_presupesto_concepto, c.concepto, c.denominacion 'nombre_concepto', 
                           p.partida, p.denominacion 'denominacion_partida'
                      FROM (SELECT id_presupesto_concepto, concepto, partida, denominacion FROM cat_presupuesto_conceptos pc
                          WHERE trim(coalesce(concepto, '')) <> '' AND trim(coalesce(partida, '')) <> '' ) p 
                      JOIN (SELECT concepto, denominacion FROM cat_presupuesto_conceptos
                          WHERE trim(coalesce(concepto, '')) <>'' AND trim(coalesce(partida, '')) = '') c
                      ON c.concepto = p.concepto
                ) pcon ON pcon.id_presupesto_concepto = pdes.id_presupuesto_concepto
                LEFT JOIN (SELECT numero_partida, SUM(cantidad) total_ejercido 
                           FROM tab_facturas_desglose GROUP BY numero_partida
                ) fact ON fact.numero_partida = pcon.partida
                LEFT JOIN (SELECT numero_partida, SUM(monto_desglose) total_monto_presupuesto
                           FROM tab_facturas_desglose GROUP BY numero_partida
                ) fact2 ON fact2.numero_partida = pcon.partida
                JOIN tab_presupuestos pre ON pre.id_presupuesto = pdes.id_presupuesto
                JOIN cat_ejercicios ej ON ej.id_ejercicio = pre.id_ejercicio
                LEFT JOIN rel_pnt_presupuesto_desglose2 pnt 
                ON pnt.id_presupuesto_desglose = pdes.id_presupuesto_desglose");

        $rows = $query->result_array();

        header('Content-Type: application/json');
        echo json_encode( $rows ); 
    }
//"pnt.id_tpo", "pnt.id_pnt", "f.id_factura"
    function registros4(){
        $cols = array("pnt.id_campana_aviso id_tpo", "pnt.id_pnt", "cam.id_campana_aviso id", "pnt.estatus_pnt", "ej.ejercicio", 
                      "cam.fecha_inicio_periodo", "cam.fecha_termino_periodo", "cam.mensajeTO", "cam.fecha_validacion", 
                      "cam.publicacion_segob", "cam.fecha_actualizacion", "cam.area_responsable", "cam.nota");

        foreach ($cols as &$col) {
            $tag = $col;
            if( strpos($col, " ") ) {
                $col_arr = explode(" ", $col); $tag = array_pop($col_arr); $col = join(" ", $col_arr);
            } else if ( strpos($col, ".") ) $tag = explode(".", $col)[1];
            $col = "IFNULL(" . $col . ", '') AS $tag";
        }

        $query = $this->db->query("SELECT " . join(", ", $cols) . "
                FROM tab_campana_aviso cam 
                JOIN cat_ejercicios ej ON ej.id_ejercicio = cam.id_ejercicio 
                LEFT JOIN rel_pnt_campana_aviso pnt ON pnt.id_campana_aviso = cam.id_campana_aviso;"); 

       $rows = $query->result_array();

        header('Content-Type: application/json');
        echo json_encode( $rows ); 
    }

    function pnt(){
        //Validamos que el usuario tenga acceso
        $this->permiso_administrador();

        $this->load->model('tpoadminv1/logo/Logo_model');

        $data['title'] = "Plataforma Nacional de Transparencia";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_rol_nombre');
        $data['active'] = 'pnt'; // solo active 
        $data['subactive'] = 'carga_pnt'; // class="active"
        $data['body_class'] = 'skin-blue';

        $formato = 1;
        $validpntformato = array(1,2,21,22,23,3,31,4,42, 46, 44);
        if( isset($_GET["formato"]) and in_array( $_GET["formato"], $validpntformato) ){
            $formato = $_GET["formato"];
        }

        $data['main_content'] = 'tpoadminv1/logo/pnt' . $formato;
        $data['formato'] = $formato;

        $data['url_logo'] = base_url() . "data/logo/logotop.png";
        $data['fecha_act'] = $this->Logo_model->dame_fecha_act_manual();

        $data['recaptcha'] = $this->Logo_model->get_registro_recaptcha();
        $data['grafica'] = $this->Logo_model->get_registro_grafica_presupuesto();
        
        $data['registro'] = array(
            'fecha_dof' => '',
            'name_file_imagen' => '',
        );

        // poner true para ocultar los botones
        $data['control_update'] = array (
            'file_by_save' => false,
            'file_saved' => true,
            'file_see' => true,
            'file_load' => true, 
            "mensaje_file" => 'Formatos permitidos PNG.'
        );

        $data['scripts'] = "<script type='text/javascript'>" .
                                "$(function () {" .
                                    
                                    "jQuery.datetimepicker.setLocale('es');". 
                                    "jQuery('input[name=\"fecha_act\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'Y-m-d'," .
                                        "scrollInput: false" .
                                    "});" .
                                    
                                    "$.fn.datepicker.dates['es'] = {" .
                                        "days: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo']," .
                                        "daysShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],".
                                        "daysMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa', 'Do']," .
                                        "months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],".
                                        "monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],".
                                        "today: 'Hoy'," .
                                        "};" .
                                    "setTimeout(function() { " .
                                        "$('.alert').alert('close');" .
                                    "}, 3000);" .
                                    
                                "});" .
                            "</script>";
        
        $this->load->view('tpoadminv1/includes/template', $data);
    }

    function alta_carga_logo(){

        //Validamos que el usuario tenga acceso
        $this->permiso_administrador();

        $this->load->model('tpoadminv1/logo/Logo_model');

        $data['title'] = "Configuraci&oacute;n";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_rol_nombre');
        $data['active'] = 'logo'; // solo active 
        $data['subactive'] = 'carga_logo'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/logo/carga_logo';

        $data['url_logo'] = base_url() . "data/logo/logotop.png";
        $data['fecha_act'] = $this->Logo_model->dame_fecha_act_manual();

        $data['recaptcha'] = $this->Logo_model->get_registro_recaptcha();
        $data['grafica'] = $this->Logo_model->get_registro_grafica_presupuesto();
        
        $data['registro'] = array(
            'fecha_dof' => '',
            'name_file_imagen' => '',
        );

        // poner true para ocultar los botones
        $data['control_update'] = array (
            'file_by_save' => false,
            'file_saved' => true,
            'file_see' => true,
            'file_load' => true, 
            "mensaje_file" => 'Formatos permitidos PNG.'
        );

        $data['scripts'] = "<script type='text/javascript'>" .
                                "$(function () {" .
                                    
                                    "jQuery.datetimepicker.setLocale('es');". 
                                    "jQuery('input[name=\"fecha_act\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'Y-m-d'," .
                                        "scrollInput: false" .
                                    "});" .
                                    
                                    "$.fn.datepicker.dates['es'] = {" .
                                        "days: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo']," .
                                        "daysShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],".
                                        "daysMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa', 'Do']," .
                                        "months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],".
                                        "monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],".
                                        "today: 'Hoy'," .
                                        "};" .
                                    "setTimeout(function() { " .
                                        "$('.alert').alert('close');" .
                                    "}, 3000);" .
                                    
                                "});" .
                            "</script>";
        
        $this->load->view('tpoadminv1/includes/template', $data);
    }


    function validate_alta_carga_logo()
    {
        //Validamos que el usuario tenga acceso
        $permiso = $this->permiso_administrador();
        
        $this->load->model('tpoadminv1/logo/Logo_model');
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('fecha_act', 'Fecha de actualizaci&oacute;n ', 'trim|required');
       // $this->form_validation->set_rules('comentario_act', 'Nombre(s)', 'trim|required|min_length[3]');
        
        $this->form_validation->set_error_delimiters('<p>','</p>');
        
        $data['title'] = "Carga logo o Alta fecha de actualizaci&oacute;n manual";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_job');
        $data['active'] = 'usuarios'; // solo active 
        $data['subactive'] = 'alta_usuario'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/logo/carga_logo';

        $data['recaptcha'] = $this->Logo_model->get_registro_recaptcha();
        $data['grafica'] = $this->Logo_model->get_registro_grafica_presupuesto();

        $data['registro'] = array(
            'fecha_dof' => '',
            'name_file_imagen' => '',
        );

        // poner true para ocultar los botones
        $data['control_update'] = array (
            'file_by_save' => false,
            'file_saved' => true,
            'file_see' => true,
            'file_load' => true, 
            "mensaje_file" => 'Formatos permitidos PNG.'
        );

        $data['scripts'] = "<script type='text/javascript'>" .
                                "$(function () {" .
                                    
                                    "jQuery.datetimepicker.setLocale('es');". 
                                    "jQuery('input[name=\"fecha_act\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    
                                    "$.fn.datepicker.dates['es'] = {" .
                                        "days: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo']," .
                                        "daysShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],".
                                        "daysMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa', 'Do']," .
                                        "months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],".
                                        "monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],".
                                        "today: 'Hoy'," .
                                        "};" .
                                    "$('.datepicker').datepicker({ " .
                                        "format: 'dd.mm.yyyy'," .
                                        "language: 'es'," .
                                        "todayHighlight: true " .
                                    "});" .
                                    
                                "});" .
                            "</script>";
        
        if ($this->form_validation->run() == FALSE) 
        {
            $this->load->view('tpoadminv1/includes/template', $data);
        }
        else 
        {
            $alta = $this->Logo_model->alta_fecha_manual();
            
            switch($alta)
            {
                case 1:
                    $this->session->set_flashdata('exito', "La fecha de actualizaci&oacute;n ".$this->input->post('fecha_act')." ha sido dado de alta exitosamente");
                    redirect('/tpoadminv1/logo/logo/alta_carga_logo');
                    break;
                case 2: 
                    $this->session->set_flashdata('error', "Ya existe la fecha de actualizaci&oacute;n ".$this->input->post('fecha_act'). " ,ingresa otra");
                    $this->load->view('tpoadminv1/includes/template', $data);
                    break;
                default:
                    $this->session->set_flashdata('alerta', "Hubo un error intente de nuevo");
                    $this->load->view('tpoadminv1/includes/template', $data);
                    break;
            }
        }
    }


    
    function upload_file()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_administrador();
        $this->load->model('tpoadminv1/Generales_model');

        $name_file = $this->Generales_model->clean_file_name(basename($_FILES['file_programa_imagen']['name']), false);
        $registro = array('error','<span class="text-danger">No fue posible subir el archivo, intentelo de nuevo.'. $name_file .'</span>');
        if(isset($name_file) && !empty($name_file))
        {
            //poner nombre por default 
            //$name_file = "logo.top"
            $porciones = explode(".", $name_file);
            $size = sizeof($porciones);
            if($size >= 2){
                //$extenciones = array('xlsx','xls','pdf','doc','docx');
                $extenciones = array('png');
                $aux = strtolower($porciones[$size-1]); 
                if(in_array($aux, $extenciones)){
                    // se guarda el archivo
                    $config['upload_path'] = './data/logo';
                    $config['allowed_types']        = '*';
                    $config['detect_mime']          = false;
                    $config['max_size'] = '20000';
                    $config['max_width']  = '150';
                    $config['max_height']  = '90';
                    $config['overwrite']  = TRUE;
                    $config['file_name']  = "logotop.png";

                    $this->load->library('upload', $config);

                    if(!$this->upload->do_upload('file_programa_imagen')){
                        $registro = array('alert', '<span class="text-warning">' . $this->upload->display_errors() . '<span>');
                    }
                    else{
                        $registro = array('exito', $name_file);
                    }
                }else{
                    $registro = array('alert', '<span class="text-danger">Tipo de archivo no permitido</span>');
                }
            } 
        }

        header('Content-type: application/json');
        
        echo json_encode( $registro );

    }


    function clear_file()
    {
        $clear_path = './data/logo/' . $this->input->post('file_archivo_nombre'); //utf8_decode($this->input->post('file_programa_anual'));
        if(file_exists($clear_path))
            unlink($clear_path);

        $registro = array('exito','Eliminado');
        header('Content-type: application/json');
        
        echo json_encode( $registro );
    }


    function actualizar_fecha()
    {
        $this->load->model('tpoadminv1/logo/Logo_model');
        $actualiza = $this->Logo_model->actualiza_fecha();
        
        switch ($actualiza) 
        {   
            case '1': $this->session->set_flashdata('exito', "Se ha actualizado correctamente");
                break;
            case 2: $this->session->set_flashdata('exito', "La fecha de actualizaci&oacute;n " . $this->input->post('fecha_act') . " ha sido inactivada");
               break;
            default: $this->session->set_flashdata('alerta', "Hubo un error intente de nuevo");
                break;
        }
        redirect('/tpoadminv1/logo/logo/alta_carga_logo');
    }

    function actualizar_recaptcha(){
        $this->load->model('tpoadminv1/logo/Logo_model');
        $registro = 0;
        $cad_a = "agregar"; $cad_e = "agregado"; 
        if(!empty($this->input->post('id_settings')) && intval($this->input->post('recaptcha') > 0)){
            $registro = $this->Logo_model->editar_recaptcha();
            $cad_a = "editar"; $cad_e = "editado"; 
        }else{
            $registro = $this->Logo_model->agregar_recaptcha();
        }

        if($registro == 0){
            $this->session->set_flashdata('alerta', "No fue posible ". $cad_a ." la reCATCHA.");
        }else {
            $this->session->set_flashdata('exito', "Se ha ". $cad_e ." la reCATCHA correctamente");
        }

        redirect('/tpoadminv1/logo/logo/alta_carga_logo');
    }

    function habilitarGrafica(){
        $this->load->model('tpoadminv1/logo/Logo_model');

        $registro = $this->Logo_model->habilitar_grafica();
        header('Content-type: application/json');

        echo json_encode( $registro );
    }

}
