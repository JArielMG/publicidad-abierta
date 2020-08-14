<?php 
if( !( isset($_SESSION['pnt']) ) or !( isset($_SESSION["pnt"]["success"]) ) or !( $_SESSION["pnt"]["success"] ) ){
	header("Location: " . base_url() ."index.php/tpoadminv1/logo/logo/alta_carga_logo");
	die();
}
?>
<script type="text/javascript" src="<?php echo base_url(); ?>plugins/sanitizer/sanitizer.js"></script>

<link href="<?php echo base_url(); ?>plugins/DataTables2/datatables.min.css" rel="stylesheet" type="text/css" />
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
		<li> 
			<a class="btn-group btn btn-info btn-sm <?php echo ($formato == 2)? 'here': '' ?>" id="formato_2" href="<?php echo base_url(); ?>index.php/tpoadminv1/logo/logo/pnt?formato=2"> 70FXXIIIB </a> 
			<ul class="subitems">
				<li> <a class="btn-group btn btn-info btn-sm <?php echo ($formato == 21)? 'here': '' ?>" id="formato_21" href="<?php echo base_url(); ?>index.php/tpoadminv1/logo/logo/pnt?formato=21"> 70FXXIIIB1 </a> </li>
				<li> <a class="btn-group btn btn-info btn-sm <?php echo ($formato == 22)? 'here': '' ?>" id="formato_22" href="<?php echo base_url(); ?>index.php/tpoadminv1/logo/logo/pnt?formato=22"> 70FXXIIIB2 </a> </li>
				<li> <a class="btn-group btn btn-info btn-sm <?php echo ($formato == 23)? 'here': '' ?>" id="formato_23" href="<?php echo base_url(); ?>index.php/tpoadminv1/logo/logo/pnt?formato=23"> 70FXXIIIB3 </a> </li>
				
			</ul>
		</li>
		<li> <a class="btn-group btn btn-info btn-sm <?php echo ($formato == 3)? 'here': '' ?>" id="formato_3" href="<?php echo base_url(); ?>index.php/tpoadminv1/logo/logo/pnt?formato=3"> 70FXXIIIC </a> </li>
		<li> <a class="btn-group btn btn-info btn-sm <?php echo ($formato == 4)? 'here': '' ?>" id="formato_4" href="<?php echo base_url(); ?>index.php/tpoadminv1/logo/logo/pnt?formato=4"> 70FXXIIID </a> </li>
	</ul>

	<br><br><br>
	<h2> Respecto a los proveedores y su contratación </h2>
	<table id="grid" class="dataTable stripe hover order-column row-border cell-border compact">
		<thead>
	        <tr>
	           	<th>ID TPO</th>
	           	<th>ID</th>
	           	<th>ID PNT</th>
	           	<th>Ejercicio</th>
	           	<th>Razón social</th>
				<th>Nombre(s)</th>
				<th>Primer apellido</th>
				<th>Segundo apellido</th>
				<th>Nombre(s) de los proveedores y/o responsables</th>
				<th>Registro Federal de Contribuyente</th>
				<th>Procedimiento de contratación</th>
				<th>Fundamento jurídico del proceso de contratación</th>
				<th>Descripción breve de las razones que justifican</th>
				<th>Estatus</th>
	        </tr>
	    </thead>
	    <tbody> <tr> </tr> </tbody>
	</table>
</section>


<script type="text/javascript" src="<?php echo base_url(); ?>plugins/jQuery/jQuery-3.3.1.js"></script>
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
	    		url: "<?php echo base_url(); ?>index.php/tpoadminv1/logo/logo/registros21",
	    		dataSrc: ''
	    	},
    		scrollY: true,
	    	scrollX: true,
			columns: [
				{ data: 'id_tpo' },
				{ data: 'id_pnt' },
				{ data: 'id' },
				{ data: 'ejercicio' },
				{ data: 'descripcion_justificacion' },
				{ data: 'nombre_razon_social' },
				{ data: 'nombres' },
				{ data: 'primer_apellido' },
				{ data: 'segundo_apellido' },
				{ data: 'nombre_comercial' },
				{ data: 'rfc' },
				{ data: 'nombre_procedimiento' },
				{ data: 'fundamento_juridico' },
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
				    targets: 6,
				    data: "data",
				    render: function ( data, type, row, meta ) {
				    	if( !(row.id_pnt) || row.id_pnt === ""){ 
				      		if(!data || data == '') return  "<label class='btn'> <small> N/D </small></label>"
			        		if(data == 1) return "Contratante" 
					      	if(data == 2) return "Solicitante" 
					      	if(data == 3) return "Contratante y Solicitante"
					    } else return "<input type='text' value='" + data + "'>" 
				    }
				},
				{
				    targets: 13,
				    data: "data",
				    render: function ( data, type, row, meta ) {
			      	var response = ""
		      		_row = row //HtmlSanitizer.SanitizeHtml(JSON.stringify(row)) 
			      	if( !(row.id_pnt) || row.id_pnt === ""){ 
			      		response += "<a class='tpo_btn crear' href='#' data='" + _row + "'>" 
			      		response += "<span class='btn btn-success'><i class='fa fa-plus-circle'></i>  </span> </a>"

			      		response += "<a class='tpo_btn eliminar invisible' href='#' data='" + _row + "'>" 
			      		response += "<span class='btn btn-danger btn-sm'><i class='fa fa-close'></i>  </span> </a>"

			      		response += "<a class='tpo_btn editar invisible' href='#' data='" + _row + "'>" 
			      		response += "<span class='btn btn-warning btn-sm'> <i class='fa fa-edit'></i>  </span></a>"
			      	}else{
			      		response += "<a class='tpo_btn crear invisible' href='#' data='" + _row + "'>" 
			      		response += "<span class='btn btn-success'><i class='fa fa-plus-circle'></i> </span> </a>"

			      		response += "<a class='tpo_btn eliminar' href='#' data='" + _row + "'>" 
			      		response += "<span class='btn btn-danger btn-sm'><i class='fa fa-close'></i>  </span> </a>"

			      		response += "<a class='tpo_btn editar' href='#' data='" + _row + "'>" 
			      		response += "<span class='btn btn-warning btn-sm'> <i class='fa fa-edit'></i>  </span></a>"
			      	}
			      	return response
				}
				},
				{
				    targets: [3,4,5,6,7,8,9,10,11,12],
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
				"idFormato": 43320, //"Contratación de servicios de publicidad oficial"
				"IdRegistro": "",
				"token": '<?php echo $_SESSION["pnt"]["token"]["token"]; ?>',
				"correoUnidadAdministrativa": '<?php echo $_SESSION["user_pnt"]; ?>' ,
				"unidadAdministrativa": '<?php echo $_SESSION["unidad_administrativa"]; ?>',
				"SujetoObligado": '<?php echo $_SESSION["sujeto_obligado"]; ?>',
				"registros": [{
				    "numeroRegistro": 1,
				    "campos": [
				    	{"idCampo": 333943, "valor": data["Ejercicio"] },
						{"idCampo": 333963, "valor": ( data["Fecha de inicio del periodo que se informa"] != null )? data["Fecha de inicio del periodo que se informa"].split('-').reverse().join('/') : '' },
						{"idCampo": 333964, "valor": ( data["Fecha de término del periodo que se informa"] != null )? data["Fecha de término del periodo que se informa"].split('-').reverse().join('/') : '' },
						{"idCampo": 333962, "valor": parseInt(data["Función del Sujeto Obligado (catálogo)"]) },
						{"idCampo": 333950, "valor": data["Área administrativa Encargada de Solicitar El Servicio o Producto, en su caso"]},
						{"idCampo": 333968, "valor": data["Clasificación Del(los) Servicios (catálogo)"]},
						{"idCampo": 333940, "valor": data["Tipo de Servicio<"]},
						{"idCampo": 333969, "valor": data["Tipo de Medio(catálogo)"] },
						{"idCampo": 333970, "valor": data["Descripción de Unidad"]},
						{"idCampo": 333956, "valor": parseInt(data["Tipo (catálogo)"]) },
						{"idCampo": 333947, "valor": data["Nombre de la Campaña o Aviso Institucional"]},
						{"idCampo": 333942, "valor": data["Año de la Campaña"]},
						{"idCampo": 333948, "valor": data["Tema de la Campaña o Aviso Institucional"]},
						{"idCampo": 333951, "valor": data["Objetivo Institucional"]},
						{"idCampo": 333949, "valor": data["Objetivo de Comunicación"]},
						{"idCampo": 333972, "valor": data["Costo por unidad"]},
						{"idCampo": 333944, "valor": data["Clave Única de Indentificación de Campaña"]},
						{"idCampo": 333973, "valor": data["Autoridad que proporcionó la Clave"]},
						{"idCampo": 333955, "valor": parseInt(data["Cobertura (catálogo)"]) },
						{"idCampo": 333971, "valor": data["Ámbito Geográfico de Cobertura"]},
						{"idCampo": 333952, "valor": ( data["Fecha de inicio de la Campaña o Aviso Institucional"] != null )? data["Fecha de inicio de la Campaña o Aviso Institucional"].split('-').reverse().join('/') : '' },
						{"idCampo": 333953, "valor": ( data["Fecha de término de la Campaña o Aviso Institucional"] != null )? data["Fecha de término de la Campaña o Aviso Institucional"].split('-').reverse().join('/') : '' },
						{"idCampo": 333965, "valor": parseInt(data["Sexo (catálogo)"]) },
						{"idCampo": 333946, "valor": data["Lugar de Residencia"]},
						{"idCampo": 333941, "valor": data["Nivel Educativo"]},
						{"idCampo": 333945, "valor": data["Grupos de Edad"]},
						{"idCampo": 333974, "valor": data["Nivel Socioeconómico"]},

						//(data.fecha_termino_periodo != null)? data.fecha_termino_periodo.split('-').reverse().join('/') : ''
						//{"idCampo": 333957, "valor": "Respecto a los proveedores y su contratación"}, 
						
						//{"idCampo": 43256, "valor": "Razón social"},
						//{"idCampo": 43257, "valor": "Nombre(s)"},
						//{"idCampo": 43258, "valor": "Primer apellido"},
						//{"idCampo": 43259, "valor": "Segundo apellido"},
						//{"idCampo": 43260, "valor": "Registro Federal de Contribuyente"},
						//{"idCampo": 43261, "valor": "Procedimiento de contratación"},
						//{"idCampo": 43262, "valor": "Fundamento jurídico del proceso de contratación"},
						//{"idCampo": 43263, "valor": "Descripción breve del las razones que justifican"},
						//{"idCampo": 43264, "valor": "Nombre(s) de los proveedores y/o responsables"},
						//{"idCampo": 333958, "valor": "Respecto a los recursos y el presupuesto"},
						//{"idCampo": 43265, "valor": "Partida genérica"},
						//{"idCampo": 43266, "valor": "Clave del concepto"},
						//{"idCampo": 43267, "valor": "Nombre del concepto"},
						//{"idCampo": 43268, "valor": "Presupuesto asignado por concepto"},
						//{"idCampo": 43269, "valor": "Presupuesto ejercido al periodo reportado de cada partida"},
						//{"idCampo": 43270, "valor": "presupuesto total ejercido por concepto"},
						//{"idCampo": 43271, "valor": "Denominación de cada partida"},
						//{"idCampo": 43272, "valor": "Presupuesto total asignado a cada partida"},
						//{"idCampo": 43273, "valor": "Presupuesto modificado por partida"},
						//{"idCampo": 43274, "valor": "Presupuesto modificado por concepto"},
						//{"idCampo": 333959, "valor": "Respecto al contrato y los montos"},
						//{"idCampo": 43275, "valor": "Fecha de firma del contrato"},
						//{"idCampo": 43276, "valor": "Número o referencia de identificación del contrato"},
						//{"idCampo": 43277, "valor": "Objeto del contrato"},
						//{"idCampo": 43278, "valor": "Hipervínculo al contrato firmado"},
						//{"idCampo": 43279, "valor": "hipervínculo al convenio modificatorio, en su caso"},
						//{"idCampo": 43280, "valor": "Monto total del contrato"},
						//{"idCampo": 43281, "valor": "Monto pagado al periodo publicado"},
						//{"idCampo": 43282, "valor": "Fecha de inicio de los servicios contratados"},
						//{"idCampo": 43283, "valor": "Fecha de término de los servicios contratados"},
						//{"idCampo": 43284, "valor": "Número de factura"},
						//{"idCampo": 43285, "valor": "Hipervínculo a la factura"}, 
						{"idCampo": 333967, "valor": data["Área(s) Responsable(s) que generan(n) posee(n), Publica(n) y Actualiza(n) la información"]},
						{"idCampo": 333954, "valor": (data["Fecha de Validación"] != null )? data["Fecha de Validación"].split('-').reverse().join('/') : '' },
						{"idCampo": 333961, "valor": (data["Fecha de Actualización"] != null )? data["Fecha de Actualización"].split('-').reverse().join('/') : '' },
						{"idCampo": 333966, "valor": data["Nota"]}
				    ]
				}],
			  "_id_interno": data["ID FACTURA"]
			}

	    	$.post(url, formato, function(res, error){
	    		if(!res || !('success' in res) ){
	    			console.log("No se pudo insertar el elemento correctamente")
	    			a.css("display", "block")
	    		} else {
	    			tr.children("td").eq(1).text(res.id_pnt)
	    			tr.children("td").eq(10).children("a.eliminar").removeClass("invisible")
	    			tr.children("td").eq(10).children("img.check").removeClass("invisible")
	    			tr.children("td").eq(10).children("a.crear").addClass("invisible")
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
				"idFormato": 43320, 
				"correoUnidadAdministrativa": '<?php echo $_SESSION["user_pnt"]; ?>',
				"token": token,
				"registros":[ { "numeroRegistro":1, "idRegistro": data.id_pnt || id_pnt } ],
				"id_pnt": data.id_pnt || id_pnt
			}

			var url = "<?php echo base_url(); ?>index.php/tpoadminv1/logo/logo/eliminar_pnt"

	    	$.post(url, formato, function(res, error){
	    		//if(res.success) location.reload(); 
	    		if(!res || !('success' in res) ){
	    			console.log("No se pudo eliminar el elemento correctamente")
	    			a.css("display", "block")
	    			a.siblings().css("display", "block")
	    		} else {
	    			tr.children("td").eq(1).html("<label class='btn'> <small> SIN SUBIR </small></label>")
	    			tr.children("td").eq(10).children("a.eliminar").addClass("invisible")
	    			tr.children("td").eq(10).children("img.check").addClass("invisible")
	    			tr.children("td").eq(10).children("a.crear").css("display", "block")
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