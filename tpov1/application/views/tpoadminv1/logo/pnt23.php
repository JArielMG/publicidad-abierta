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
	<h2> Respecto al contrato y los montos </h2>
	<table id="grid" class="dataTable stripe hover order-column row-border cell-border compact">
		<thead>
	        <tr>
				<td> ID TPO </td>
				<td> ID PNT </td>
				<td> ID </td>
				<td> Ejercicio </td>
				<td> Fecha de firma del contrato</td>
				<td> Número o referencia de identificación del contrato</td>
				<td> Objeto del contrato</td>
				<td> Hipervínculo al contrato firmado</td>
				<td> Hipervínculo al convenio modificatorio en su caso</td>
				<td> Monto total del contrato</td>
				<td> Monto pagado al periodo publicado</td>
				<td> Fecha de inicio de los servicios contratados</td>
				<td> Fecha de término de los servicios contratados</td>
				<td> Número de factura</td>
				<td> Hipervínculo a la factura</td>
				<td> Área(s) responsable(s) que genera(n) posee(n) publica(n) y actualizan la información</td>
				<td> Fecha de validación</td>
				<td> Fecha de actualización</td>
				<td> Nota</td>
				<td> Estatus</td>
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
	    		url: "<?php echo base_url(); ?>index.php/tpoadminv1/logo/logo/registros23",
	    		dataSrc: ''
	    	},
    		scrollY: true,
	    	scrollX: true,
			columns: [
				{ data: 'id_tpo' },
				{ data: 'id_pnt' },
				{ data: 'id' },
				{ data: 'ejercicio' },
				{ data: 'fecha_celebracion' },
				{ data: 'numero_contrato' },
				{ data: 'objeto_contrato' },
				{ data: 'Hipervínculo al contrato firmado' },
				{ data: 'Hipervínculo al convenio modificatorio en su caso' },
				{ data: 'Monto total del contrato' },
				{ data: 'Monto pagado al periodo publicado' },
				{ data: 'Fecha de inicio de los servicios contratados' },
				{ data: 'Fecha de término de los servicios contratados' },
				{ data: 'numeros_factura' },
				{ data: 'files_factura_pdf' },
				{ data: 'area_responsabe' },
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
				    targets: 19,
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
				    targets: [3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18],
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
						
				    ]
				}],
			  "_id_interno": data["ID FACTURA"]
			}

	    	$.post(url, formato, function(res, error){
    			if(!res || !('success' in res) ) {
	    			console.log("No se pudo insertar el elemento correctamente")
	    			a.css("display", "block")
	    			a.siblings().css("display", "block")
	    		} else {
	    			tr.children("td").eq(1).text(res.id_pnt)
	    			tr.children("td").eq(17).children("a.eliminar").removeClass("invisible")
	    			tr.children("td").eq(17).children("img.check").removeClass("invisible")
	    			tr.children("td").eq(17).children("a.crear").addClass("invisible")
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
				"correoUnidadAdministrativa": "so.inai@inai.org.mx",
				"token": token,
				"registros":[ { "numeroRegistro":1, "idRegistro": data.id_pnt || id_pnt } ],
				"id_pnt": data.id_pnt || id_pnt
			}

			var url = "<?php echo base_url(); ?>index.php/tpoadminv1/logo/logo/eliminar_pnt"

	    	$.post(url, formato, function(res, error){
    			if(!res || !('success' in res) ) {
	    			console.log("No se pudo eliminar el elemento correctamente")
	    			a.css("display", "block")
	    			a.siblings().css("display", "block")
	    		} else {
	    			tr.children("td").eq(1).html("<label class='btn'> <small> SIN SUBIR </small></label>")
	    			tr.children("td").eq(17).children("a.eliminar").addClass("invisible")
	    			tr.children("td").eq(17).children("img.check").addClass("invisible")
	    			tr.children("td").eq(17).children("a.crear").css("display", "block")
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