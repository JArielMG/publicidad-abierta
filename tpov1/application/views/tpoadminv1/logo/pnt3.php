<?php 
if( !( isset($_SESSION['pnt']) ) or !( isset($_SESSION["pnt"]["success"]) ) or !( $_SESSION["pnt"]["success"] ) ){
  header("Location: " . base_url() ."index.php/tpoadminv1/logo/logo/alta_carga_logo");
  die();
}
?>

<script type="text/javascript" src="<?php echo base_url(); ?>plugins/sanitizer/sanitizer.js"></script>


<link href="<?php echo base_url(); ?>plugins/DataTables2/datatables.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>plugins/colorbox/colorbox.css" rel="stylesheet" type="text/css" />
<style type="text/css">
  body { transition: background-color ease-in 3s; /* tweak to your liking */ }
  .invisible { display: none; }
  .upload{ background-color: #ff0; }
  .loading{ float: left; } 
  h4{ float: left; margin-right: 30px; margin-top: 3px;  }
  .items-formato { margin-left:0; padding: 0 }
  .items-formato li{ list-style: none; float: left; margin-right:20px; max-width: 140px;}
  .items-formato li a.btn-group{ width: 140px; background-color: #cc33ff; border-color: #cc33ff; font-weight: bolder;}
  .subitems{ width: 600px; position: relative; top: 10px; border-left: 3px solid #c3f;
         height: 30px; margin: 0; padding-left: 5px;}
  .subitems li a{ background-color: #ff00bf; }
  .here{ background-color: #0277bd !important; border-color: #0277bd !important;}
</style>

<!-- Main content -->
<section class="content">
  <h4>Ejercicios</h4>
  <select id="year">
    <option value="">Selecciona un año</option> 
  </select>

  <br><br>

  <h4>Formatos</h4>

  <ul class="items-formato">
    <li> <a class="btn-group btn btn-info btn-sm <?php echo ($formato == 1)? 'here': '' ?>" id="formato_1" href="<?php echo base_url(); ?>index.php/tpoadminv1/logo/logo/pnt?formato=1"> 70FXXIIIA </a> </li>
    <li> <a class="btn-group btn btn-info btn-sm <?php echo ($formato == 2)? 'here': '' ?>" id="formato_2" href="<?php echo base_url(); ?>index.php/tpoadminv1/logo/logo/pnt?formato=2"> 70FXXIIIB </a> </li>
    <li> 
      <a class="btn-group btn btn-info btn-sm <?php echo ($formato == 3)? 'here': '' ?>" id="formato_3" href="<?php echo base_url(); ?>index.php/tpoadminv1/logo/logo/pnt?formato=3"> 70FXXIIIC </a> 
      <ul class="subitems">
        <li> <a class="btn-group btn btn-info btn-sm <?php echo ($formato == 31)? 'here': '' ?>" id="formato_31" href="<?php echo base_url(); ?>index.php/tpoadminv1/logo/logo/pnt?formato=31"> 70FXXIIIC1 </a> </li>
      </ul>
    </li>
    <li> <a class="btn-group btn btn-info btn-sm <?php echo ($formato == 4)? 'here': '' ?>" id="formato_4" href="<?php echo base_url(); ?>index.php/tpoadminv1/logo/logo/pnt?formato=4"> 70FXXIIID </a> </li>

  <br><br><br>
  <h2> Utilización de los tiempos oficiales en radio y tv </h2>
  <table id="grid" class="dataTable stripe hover order-column row-border cell-border compact">
    <thead>
          <tr>
              <th> ID TPO </th>
        <th> ID PNT </th>
        <th> ID </th>
        <th> Id Factura </th>
        <th> Factura Desglose </th>
        <th> Ejercicio </th>
        <th> Fecha de inicio del periodo que se informa </th>
        <th> Fecha de termino del periodo que se informa </th>
        <th> Sujeto obligado al que se le proporcionó el servicio/permiso </th>
        <th> Tipo (catálogo) </th>
        <th> Medio de comunicación (catálogo) </th>
        <th> Descripción de unidad por ejemplo: spot de 30 segundos (radio); mensaje en TV 20 segundos </th>
        <th> Concepto o campaña </th>
        <th> Clave única de identificación de campaña o aviso institucional en su caso </th>
        <th> Autoridad que proporcionó la clave única de identificación de campaña o aviso institucional </th>
        <th> Cobertura (catálogo) </th>
        <th> Ámbito geográfico de cobertura </th>
        <th> Sexo (catálogo) </th>
        <th> Lugar de residencia </th>
        <th> Nivel educativo </th>
        <th> Grupo de edad </th>
        <th> Nivel económico </th>
        <th> Concesionario responsable de publicar la campaña o la comunicación correspondiente (razón social) </th>
        <th> Distintivo y/o nombre comercial del concesionario responsable de publicar la campaña o comunicación </th>
        <th> Descripción breve de las razones que justifican la elección del proveedor </th>
        <th> Monto total del tiempo de Estado o tiempo fiscal consumidos </th>
        <th> Área administrativa encargada de solicitar la difusión del mensaje o producto en  </th>su caso
        <th> Fecha de inicio de difusión del concepto o campaña </th>
        <th> Fecha de término de difusión del concepto o campaña </th>
        <th> Número de factura en su caso </th>
        <th> Área(s) responsable(s) que genera(n) posee(n) publica(n) y actualizan la  </th>información
        <th> Fecha de validación </th>
        <th> Fecha de Actualización </th>
        <th> Nota </th>
        <th> Estatus </th>
          </tr>
      </thead>
      <tbody></tbody>
  </table>
</section>

<!--script type="text/javascript" src="<?php echo base_url(); ?>plugins/jQuery/jQuery-3.3.1.js"></script-->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.9.0.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>plugins/sanitizer/sanitizer.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>plugins/colorbox/jquery.colorbox.js"></script>

<link href="<?php echo base_url(); ?>plugins/DataTables2/datatables.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>plugins/DataTables2/datatables.min.js" type="text/javascript" ></script>

<script type="text/javascript">
$(document).ready(function(){
  var ejercicios_url =  "<?php echo base_url(); ?>index.php/tpoadminv1/logo/logo/ejercicios"
  
  $.post(ejercicios_url, function(res, error){
      if(res) {
        for( var i = 0 in res)
          $("#year").append("<option value='" + res[i].ejercicio + "'>" + res[i].ejercicio + "</option>")
      }
  });

  $("#formato_<?php echo $formato?>").css("background-color:", "#0277bd")

    $.fn.dataTable.ext.search.push( function( settings, data, dataIndex ){
        var year = $('#year').val()
        var ejercicio = parseInt( data[3] ) || 0; 

      if (year == "") return true
        return (year == ejercicio);
    });

    $('#year').change( function() { table.draw(); });
    
    table = $('#grid').DataTable({
      ajax: {
        url: "<?php echo base_url(); ?>index.php/tpoadminv1/logo/logo/registros3",
        dataSrc: ''
      },
    scrollY: true,
      scrollX: true,
      columns: [
        { data: 'id_tpo' },
      { data: 'id_pnt' },
      { data: 'id' },
      { data: 'id_factura' },
      { data: 'id_factura_desglose' },
      { data: 'ejercicio' },
      { data: 'fecha_inicio_periodo' },
      { data: 'fecha_termino_periodo' },
      { data: 'nombre_sujeto_obligado' },
      { data: 'nombre_campana_tipoTO' },
      { data: 'nombre_servicio_categoria' },
      { data: 'nombre_servicio_unidad' },
      { data: 'nombre_campana_aviso' },
      { data: 'clave_campana' },
      { data: 'autoridad' },
      { data: 'nombre_campana_cobertura' },
      { data: 'campana_ambito_geo' },
      { data: 'nombre_poblacion_sexo' },
      { data: 'poblacion_lugar' },
      { data: 'nombre_poblacion_nivel_educativo' },
      { data: 'nombre_poblacion_grupo_edad' },
      { data: 'nombre_poblacion_nivel' },
      { data: 'nombre_razon_social' },
      { data: 'nombre_comercial' },
      { data: 'descripcion_justificacion' },
      { data: 'monto_tiempo' },
      { data: 'area_responsable' },
      { data: 'fecha_inicio' },
      { data: 'fecha_termino' },
      { data: 'numero_factura' },
      { data: 'area_responsable' },
      { data: 'fecha_validacion' },
      { data: 'fecha_actualizacion' },
      { data: 'nota' },
      { data: 'estatus_pnt' }
    ],
    columnDefs: [ 
      {
          targets: 1,
          data: "data",
          render: function ( data, type, row, meta ) {
              if(!data) return "<label class='btn'> <small> SIN SUBIR </small></label>"
              return data
          }
      },
      {
          targets: 34,
          data: "data",
          render: function ( data, type, row, meta ) {
              var response = ""
              _row = JSON.stringify(row)  //HtmlSanitizer.SanitizeHtml(JSON.stringify(row)) 
              if( !(row.id_pnt) || row.id_pnt === ""){ 
                response += "<a class='tpo_btn crear' href='#' data='" + _row + "'>" 
                response += "<span class='btn btn-success'><i class='fa fa-plus-circle'></i>  </span> </a>"

                response += "<img class='check invisible' src='<?php echo base_url(); ?>plugins/img/correct.png'>"

                response += "<a class='tpo_btn eliminar invisible' href='#' data='" + _row + "'>" 
                response += "<span class='btn btn-danger btn-sm'><i class='fa fa-close'></i>  </span> </a>"

                response += "<a class='tpo_btn editar invisible' href='#' data='" + _row + "'>" 
                response += "<span class='btn btn-warning btn-sm'> <i class='fa fa-edit'></i>  </span></a>"
              }else{
                response += "<a class='tpo_btn crear invisible' href='#' data='" + _row + "'>" 
                response += "<span class='btn btn-success'><i class='fa fa-plus-circle'></i> </span> </a>"

                response += "<img class='check' src='<?php echo base_url(); ?>plugins/img/correct.png'>"

                response += "<a class='tpo_btn eliminar' href='#' data='" + _row + "'>" 
                response += "<span class='btn btn-danger btn-sm'><i class='fa fa-close'></i>  </span> </a>"

                response += "<a class='tpo_btn editar' href='#' data='" + _row + "'>" 
                response += "<span class='btn btn-warning btn-sm'> <i class='fa fa-edit'></i>  </span></a>"
              }

              response += "<a class='tpo_btn ver_mas' href='#' data='" + row.id_factura_desglose + "'>" 
              response += "<span class='btn btn-warning btn-sm'> <i class='fa fa-edit'></i>  Ver más información </span></a>"

              return response
        }
      },
      {
          targets: [3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33],
          data: "data",
          render: function ( data, type, row, meta ) {
            if( !(row.id_pnt) || row.id_pnt === ""){ 
                if(!data) return "<label class='btn'> <small> N/D </small></label>"
                return data
            //} else return "<input type='text' value='" + data + "'>" 
            } else return data
          }
      }
    ]
    });

  $(document).on("click","a.ver_mas",function(e){ 
        e.preventDefault();
        var id = $(this).attr("data")
        var url = "<?php echo base_url(); ?>index.php/tpoadminv1/logo/logo/registros51";
        

        $.get(url, { id_factura_desglose: id },  function(res, error){
            function get_subtables(tag, data){
                var res = "<tr><td> <h3> Datos de " + tag + " </h3> "

                if (data.length != 0){
                  for (var key in data[0]){
                      if(data[0][key] == "") continue;
                      res += "<p> <b>" + key.toUpperCase() + ": </b>" + data[0][key] + "</p>"
                  }
                }
                
                return res + "</td></tr>";
            }

            var html = "<table>"
                html += get_subtables("Presupuestos", res.presupuesto_desglose)
                html += "</table>"

            $.colorbox({html: html});
            console.log(html)
            
        })
    })

    $(document).on("click","a.crear",function(e){ 
      e.preventDefault();
      var data = JSON.parse( $(this).attr("data") )
      , url = "<?php echo base_url(); ?>index.php/tpoadminv1/logo/logo/agregar_pnt";
    
      var a = $(this)
         , tr = a.parents("tr")
         , td = a.parents("td")

      a.css("display", "none")
      tr.css("background-color", "rgba(0,255,0, 0.2)")
      td.prepend("<img class='loading' src='<?php echo base_url(); ?>plugins/img/loading.gif'>")

      formato = {
      "idFormato": "43360", //"Contratación de servicios de publicidad oficial"
      "IdRegistro": "",
      "token": '<?php echo $_SESSION["pnt"]["token"]["token"]; ?>',
      "correoUnidadAdministrativa": '<?php echo $_SESSION["user_pnt"]; ?>' ,
      "unidadAdministrativa": '<?php echo $_SESSION["unidad_administrativa"]; ?>',
      "SujetoObligado": '<?php echo $_SESSION["sujeto_obligado"]; ?>',
      "registros": [{
          "numeroRegistro": 1,
          "campos": [
            { "idCampo": 334731, "valor": data.ejercicio }, 
          { "idCampo": 334737, "valor": data.fecha_inicio_periodo }, 
          //{ "idCampo": 334737, "valor": ( data.fecha_inicio_periodo != null )?  data["fecha_inicio_periodo"] : "" }, 
          { "idCampo": 334736, "valor": data.fecha_termino_periodo }, 
          //{ "idCampo": 334736, "valor": ( data.fecha_termino_periodo != null )?  data["fecha_termino_periodo"] : "" }, 
          { "idCampo": 334735, "valor": "http://ola.kase" }, 
          //{ "idCampo": 334735, "valor": data."Hipervínculo al Estado analítico del ejercicio del Presupuesto de Egresos" }, 
          { "idCampo": 334739, "valor": data.area_responsable }, 
          { "idCampo": 334732, "valor": data.fecha_validacion }, 
          //{ "idCampo": 334732, "valor": ( data.fecha_validacion != null )? data["fecha_validacion"] : "" }, 
          { "idCampo": 334734, "valor": data.fecha_actualizacion }, 
          //{ "idCampo": 334734, "valor": ( data.fecha_actualizacion != null )? data["fecha_actualizacion"] : "" }, 
          { "idCampo": 334738, "valor": data.nota }

          ]
      }],
      "_id_interno": data.id_factura
    }

      $.post(url, formato, function(res, error){
        res = JSON.parse(res)
        console.log(res)
      if(!res || !('success' in res) ) {
          console.log("No se pudo insertar el elemento correctamente")
          a.css("display", "block")
        } else {
          tr.children("td").eq(1).text( res["mensaje"]["registros"][0]["idRegistro"] )
          tr.children("td").eq(34).children("a.eliminar").removeClass("invisible")
          tr.children("td").eq(34).children("img.check").removeClass("invisible")
          tr.children("td").eq(34).children("a.crear").addClass("invisible")
        }

      td.children("img.loading").remove("")
      
      if(tr.hasClass("odd")) tr.css("background-color", "#f9f9f9")
      else tr.css("background-color", "#fff")
      })
    
    });

  $(document).on("click","a.eliminar",function(e){ 
      e.preventDefault();

      var a = $(this)
        , tr = a.parents("tr")
        , td = a.parents("td")

      a.css("display", "none")
      a.siblings().css("display", "none")
      tr.css("background-color", "rgba(255,0,0, 0.2)")
      td.prepend("<img class='loading' src='<?php echo base_url(); ?>plugins/img/loading.gif'>")

      var id_pnt = tr.children("td").eq(1).text()

      var data = JSON.parse( $(this).attr("data")  )
      , token = '<?php echo $_SESSION["pnt"]["token"]["token"]; ?>'

    var formato = {
      "idFormato": 43360, 
      "correoUnidadAdministrativa": "so.inai@inai.org.mx",
      "token": token,
      "registros":[ { "numeroRegistro":1, "idRegistro": data.id_pnt || id_pnt } ],
      "id_pnt": data.id_pnt || id_pnt
    }

    var url = "<?php echo base_url(); ?>index.php/tpoadminv1/logo/logo/eliminar_pnt"

      $.post(url, formato, function(res, error){
        //if(res.success) location.reload(); 
      if(!res || !('success' in res) ) {
          console.log("No se pudo eliminar el elemento correctamente")
          a.css("display", "block")
          a.siblings().css("display", "block")
        } else {
          tr.children("td").eq(1).html("<label class='btn'> <small> SIN SUBIR </small></label>")
          tr.children("td").eq(12).children("a.eliminar").addClass("invisible")
          tr.children("td").eq(12).children("img.check").addClass("invisible")
          tr.children("td").eq(12).children("a.crear").css("display", "block")
        }

      td.children("img.loading").remove("")
      if(tr.hasClass("odd"))
        tr.css("background-color", "#f9f9f9")
      else
        tr.css("background-color", "#fff")
      })

    })
})
</script>
