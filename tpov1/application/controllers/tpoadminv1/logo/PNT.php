<?php

/*
INAI / USUARIOS
*/

if (!defined('BASEPATH')) 
{
    exit('No direct script access allowed');
}

class PNT extends CI_Controller
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

}
