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
	.items-formato li{ list-style: none; float: left; margin-right:20px;}
	.items-formato li a.btn-group{ width: 140px; background-color: #cc33ff; border-color: #cc33ff; font-weight: bolder;}
	.here{ 
		background-color: #0277bd !important;
		border-color: #0277bd !important;
	}
	td a { display:block; margin: 4px;}
	#waiting{
		z-index: 200;
		position: absolute;
		background: rgba(0,0,0,0.7);
		min-width:100%;
		min-height:100%;
		top:40px;
		left: 230px;
		display: none;
	}
	#waiting img{
		margin:25% 40%;
	}
</style>

<!-- Main content -->

<!-- Main content -->
<section class="content">
<section class="content">
	<h4>Ejercicios</h4>
	<select id="year">
		<option value="">Selecciona un año</option>	
	</select>

	<br><br>

	<h4>Formatos</h4>

	<ul class="items-formato">
		<li> <a class="formato_lnk btn-group btn btn-info btn-sm <?php echo ($formato == "a")? 'here': '' ?>" id="formato_a" href="<?php echo base_url(); ?>index.php/tpoadminv1/pnt/listado?formato=a"> 70FXXIIIA </a> </li>
		<li> <a class="formato_lnk btn-group btn btn-info btn-sm <?php echo ($formato == "b")? 'here': '' ?>" id="formato_b" href="<?php echo base_url(); ?>index.php/tpoadminv1/pnt/listado?formato=b"> 70FXXIIIB </a> </li>
		<li> <a class="formato_lnk btn-group btn btn-info btn-sm <?php echo ($formato == "c")? 'here': '' ?>" id="formato_c" href="<?php echo base_url(); ?>index.php/tpoadminv1/pnt/listado?formato=c"> 70FXXIIIC </a> </li>
		<li> <a class="formato_lnk btn-group btn btn-info btn-sm <?php echo ($formato == "d")? 'here': '' ?>" id="formato_d" href="<?php echo base_url(); ?>index.php/tpoadminv1/pnt/listado?formato=d"> 70FXXIIID </a> </li>
	</ul>

	<br><br><br>
	<h2> Programa Anual de Comunicación Social o equivalente </h2>
	<table id="grid1" class="dataTable stripe hover order-column row-border cell-border compact" >
		<thead>
	        <tr>
	            <th> ID TPO</th>
	            <th> ID PNT</th>
	            <th> ID PRESUPUESTO</th>
	            <th> Ejercicio</th>
	            <th> Fecha de inicio</th>
	            <th> Fecha de término</th>
	            <th> Denominación del documento</th>
	            <th> Fecha aprobación</th>
	            <th> Hipervínculo al PACS</th>
	            <th> Área(s) responsable(s)</th>
	            <th> Fecha de Validación</th>
	            <th> Fecha de Actualización</th>
	            <th> Nota</th>
	            <th> Estatus PNT</th>
	        </tr>
	    </thead>
	    <tbody>
	        <tr></tr>
	    </tbody>
	    <tfoot></tfoot>
	</table>
</section>

<section id="waiting">
	<img src='<?php echo base_url(); ?>plugins/img/waiting.gif'>
</section>




<script type="text/javascript" src="<?php echo base_url(); ?>plugins/jQuery/jQuery-3.3.1.js"></script>
<script src="<?php echo base_url(); ?>plugins/DataTables2/datatables.min.js" type="text/javascript" ></script>
<script type="text/javascript">



$(document).ready(function(){
	$.fn.dataTable.ext.errMode = 'none';
	var ejercicios_url =  "<?php echo base_url(); ?>index.php/tpoadminv1/pnt/formato_a/ejercicios"
	
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

     $('#year').on("change", function() { 
            year = $(this).val()
            console.log(year)
            if (year != ""){
                $("a.formato_lnk").each( function(i, e){  
                    link = $(e).attr("href").split("#y")[0] 
                    link += "#y" + year
                    $(e).attr("href", link)
                })
            }
            table.draw(); 
        });

     var quitarTags =  function(str){
            str = str.replace(/"/g, "'")
            var contenido = str.replace(/"/g, "'")
            var temporal = document.createElement("div");
            temporal.innerHTML = contenido;
            return temporal.textContent || temporal.innerText || "";
        }

    var table = $('#grid1').DataTable({
    	language: {
	        "decimal": "",
	        "emptyTable": "No hay información",
	        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
	        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
	        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
	        "infoPostFix": "",
	        "thousands": ",",
	        "lengthMenu": "Mostrar _MENU_ Entradas",
	        "loadingRecords": "Cargando...",
	        "processing": "Procesando...",
	        "search": "Buscar:",
	        "zeroRecords": "Sin resultados encontrados",
	        "paginate": {
	            "first": "Primero",
	            "last": "Ultimo",
	            "next": "Siguiente",
	            "previous": "Anterior"
	        }
    	},
    	ajax: {
    		url: "<?php echo base_url(); ?>index.php/tpoadminv1/pnt/formato_a",
    		dataSrc: ''
    	},
		scrollY: true,
    	scrollX: true,
		columns: [
			{ data: 'id_presupuesto' },
	        { data: 'id_pnt' },
	        { data: 'id_presupuesto' },
	        { data: 'ejercicio' },
	        { data: 'fecha_inicio_periodo' },
	        { data: 'fecha_termino_periodo' },
	        { data: 'denominacion' },
	        { data: 'fecha_publicacion' },
	        { data: 'url_programa_anual' }, // 
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
			      	return quitarTags(data)
			    }
			},
	        {
	            targets: 8,
	            data: "data",
	            render: function ( data, type, row, meta ) {
	            	if(data != "") return "<?php echo base_url(); ?>data/programas/" + quitarTags(data)
	            }
	        },
	        {
	            targets: [4, 5, 7, 10, 11 ],
	            data: "data",
	            render: function ( data, type, row, meta ) {
	                try{
	                  return data.split("-").reverse().join("/")
	                } catch(e){ return data}

	                return quitarTags(data)
	            }
	        },
			{
			    targets: 6,
			    data: "data",
			    render: function ( data, type, row, meta ) {
			    	if( !(row.id_pnt) || row.id_pnt === ""){ 
			      		if(!data) return  "<label class='btn'> <small> N/D </small></label>"
			        	return (data.length > 100)? data.substr( 0, 100 ) + "..." : quitarTags(data)
				     //} else return "<input type='text' value='" + data + "'>" 
				    } else return quitarTags(data)
			    }
			}
			/**/
			,
			{
			    targets: 13,
			    data: "data",
			    render: function ( data, type, row, meta ) {
			      	var response = ""
		      		_row = JSON.stringify(row) 
		      		//_row = HtmlSanitizer.SanitizeHtml(_row) 
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
				    } else return quitarTags(data)
			    }
			}
			/**/
		]
    });


	$('#grid1').on( 'draw.dt', function () {
	    //alert( 'Table redrawn' );
		$("#waiting").css("display", "block")
		
		setTimeout(function(){ 
			$("#waiting").css("display", "none")
        }, 5000);

        $(".dataTables_empty").removeClass("dataTables_empty")
	} );


    function validURL(str) {
	 	try { new URL(string) } catch (_){ return false } 
  		return true
	}

	 setTimeout(function(){ 
            var year = window.location.href.split("#y")[1] 
            if(year) $('#year').val(year).trigger('change');
        }, 1500);
	 
	$(document).on("click","a.crear",function(e){
    	e.preventDefault();
    	if( !confirm("¿Está seguro de continuar con esta operación?") ) return false

	    var data = JSON.parse( $(this).attr("data") )
		  , url = "<?php echo base_url(); ?>index.php/tpoadminv1/pnt/formato_a/enviar_pnt";
		
		var a = $(this)
	      , tr = a.parents("tr")
	      , td = a.parents("td")

	    a.css("display", "none")
	    tr.css("background-color", "rgba(0,255,0, 0.2)")
	    td.prepend("<img class='loading' src='<?php echo base_url(); ?>plugins/img/loading.gif'>")

	    var formato = {
			"idFormato": "43322", // Programa Anual de Comunicación Social o equivalente
			"IdRegistro": "",
			"token": '<?php echo $_SESSION["pnt"]["token"]["token"]; ?>',
			"correoUnidadAdministrativa": '<?php echo $_SESSION["user_pnt"]; ?>' ,
			"unidadAdministrativa": '<?php echo $_SESSION["unidad_administrativa"]; ?>',
			"SujetoObligado": '<?php echo $_SESSION["sujeto_obligado"]; ?>',
			"registros": [{
			    "numeroRegistro": 1,
			    "campos": [
			    	{ "idCampo": 333986, "valor": data.ejercicio},
			    	{ "idCampo": 333990, "valor": (data.fecha_inicio_periodo != null)? data.fecha_inicio_periodo.split('-').reverse().join('/') : ''},
			    	{ "idCampo": 333991, "valor": (data.fecha_termino_periodo != null)? data.fecha_termino_periodo.split('-').reverse().join('/') : ''},
			    	{ "idCampo": 333985, "valor": data.denominacion},
			    	{ "idCampo": 333987, "valor": (data.fecha_publicacion != null)? data.fecha_publicacion.split('-').reverse().join('/') : ''},
			    	{ "idCampo": 333994, "valor": data.area_responsable},
			    	{ "idCampo": 333988, "valor": (data.fecha_validacion != null)? data.fecha_validacion.split('-').reverse().join('/') : ''},
			    	{ "idCampo": 333992, "valor": (data.fecha_actualizacion != null)? data.fecha_actualizacion.split('-').reverse().join('/') : ''},
			    	{ "idCampo": 333993, "valor": data.nota},
			    ]
			}],
		  "_id_interno": data.id_presupuesto
		}

		if ( validURL(data.file_programa_anual) ){
			formato.registros[0].campos.push( { "idCampo": 333995, "valor": data.file_programa_anual } )
		}

    	$.post(url, formato, function(res, error){
    		console.log(res)
    		res = JSON.parse(res)

    		if(!res || !('success' in res) || !res.success) {
    			console.log("No se pudo insertar el elemento correctamente")
    			console.log(res, error)
    			a.css("display", "block")
    		} else {
    			tr.children("td").eq(1).text(res.mensaje.registros[0].idRegistro)
    			tr.children("td").eq(13).children("a.eliminar").removeClass("invisible")
    			tr.children("td").eq(13).children("img.check").removeClass("invisible")
    			tr.children("td").eq(13).children("a.crear").addClass("invisible")
				table.draw(); 
    			location.reload(); 
    		}

			td.children("img.loading").remove("")
			if(tr.hasClass("odd")) tr.css("background-color", "#f9f9f9")
			else tr.css("background-color", "#fff")
    	})
    });

	$(document).on("click","a.eliminar",function(e){
   		e.preventDefault();
   		if( !confirm("¿Está seguro de continuar con esta operación?") ) return false
    	var a = $(this)
	      , tr = a.parents("tr")
	      , td = a.parents("td")

	    a.css("display", "none")

	})



	$(document).on("click","a.eliminar",function(e){
    	e.preventDefault();
    	if( !confirm("¿Está seguro de continuar con esta operación?") ) return false
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
			"idFormato": 43322, 
			"correoUnidadAdministrativa": '<?php echo $_SESSION["user_pnt"]; ?>' ,
			"token": token,
			"registros":[ { "numeroRegistro":1, "idRegistro": data.id_pnt || id_pnt } ],
			"id_pnt": data.id_pnt || id_pnt
		}

		var url = "<?php echo base_url(); ?>index.php/tpoadminv1/pnt/formato_a/eliminar_pnt"

    	$.post(url, formato, function(res, error){
    		if(!res || !('success' in res) ) {
    			console.log("No se pudo eliminar el elemento correctamente")
    			a.css("display", "block")
    			a.siblings().css("display", "block")
    		} else {
    			tr.children("td").eq(1).html("<label class='btn'> <small> SIN SUBIR </small></label>")
    			tr.children("td").eq(13).children("a.eliminar").addClass("invisible")
    			tr.children("td").eq(13).children("img.check").addClass("invisible")
    			tr.children("td").eq(13).children("a.crear").css("display", "block")
    			location.reload();
    		}

			td.children("img.loading").remove("")
			if(tr.hasClass("odd")) tr.css("background-color", "#f9f9f9")
			else tr.css("background-color", "#fff")
    	})
    })
})
</script>