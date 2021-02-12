<?php  
if( !( isset($_SESSION['pnt']) ) or !( isset($_SESSION["pnt"]["success"]) ) or !( $_SESSION["pnt"]["success"] ) ){
	header("Location: " . base_url() ."index.php/tpoadminv1/pnt/formato_a/alta_carga_logo");
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
<section class="content">
	<h4>Ejercicios</h4>
	<select id="year">
		<option value="">Selecciona un año</option>	
	</select>

	<br><br>

	<h4>Formatos</h4>

	<ul class="items-formato">
        <li> <a class="formato_lnk btn-group btn btn-info btn-sm <?php echo ($formato == "a")? 'here': '' ?>" id="formato_a" href="<?php echo base_url(); ?>index.php/tpoadminv1/pnt/listado?formato=a"> 70FXXIIIA </a> </li>
        <li> 
            <a class="formato_lnk btn-group btn btn-info btn-sm <?php echo ($formato == "b")? 'here': '' ?>" id="formato_b" href="<?php echo base_url(); ?>index.php/tpoadminv1/pnt/listado?formato=b"> 70FXXIIIB </a> 
            <ul class="subitems">
                <li> <a class="formato_lnk btn-group btn btn-info btn-sm <?php echo ($formato == "b1")? 'here': '' ?>" id="formato_b1" href="<?php echo base_url(); ?>index.php/tpoadminv1/pnt/listado?formato=b1"> 70FXXIIIB1 </a> </li>
                <li> <a class="formato_lnk btn-group btn btn-info btn-sm <?php echo ($formato == "b2")? 'here': '' ?>" id="formato_b2" href="<?php echo base_url(); ?>index.php/tpoadminv1/pnt/listado?formato=b2"> 70FXXIIIB2 </a> </li>
                <li> <a class="formato_lnk btn-group btn btn-info btn-sm <?php echo ($formato == "b3")? 'here': '' ?>" id="formato_b3" href="<?php echo base_url(); ?>index.php/tpoadminv1/pnt/listado?formato=b3"> 70FXXIIIB3 </a> </li>
            </ul>
        </li>
        <li> <a class="formato_lnk btn-group btn btn-info btn-sm <?php echo ($formato == "c")? 'here': '' ?>" id="formato_c" href="<?php echo base_url(); ?>index.php/tpoadminv1/pnt/listado?formato=c"> 70FXXIIIC </a> </li>
        <li> <a class="formato_lnk btn-group btn btn-info btn-sm <?php echo ($formato == "d")? 'here': '' ?>" id="formato_d" href="<?php echo base_url(); ?>index.php/tpoadminv1/pnt/listado?formato=d"> 70FXXIIID </a> </li>
    </ul>

	<br><br><br>
	<h2> Respecto al contrato y los montos </h2>
	<table id="grid" class="dataTable stripe hover order-column row-border cell-border compact">
		<thead>
	        <tr>
				<th> ID TPO </th>
				<th> ID PNT </th>
				<th> ID </th>
				<th> Ejercicio </th>
				<th> Fecha de firma del contrato</th>
				<th> Número o referencia de identificación del contrato</th>
				<th> Objeto del contrato</th>
				<th> Hipervínculo al contrato firmado</th>
				<th> Hipervínculo al convenio modificatorio en su caso</th>
				<th> Monto total del contrato</th>
				<th> Monto pagado al periodo publicado</th>
				<th> Fecha de inicio de los servicios contratados</th>
				<th> Fecha de término de los servicios contratados</th>
				<th> Número de factura</th>
				<th> Hipervínculo a la factura</th>
				<!--td> Estatus</td-->
	        </tr>
	    </thead>
	    <tbody> <tr> </tr> </tbody>
	</table>
</section>



<section id="waiting">
	<img src='<?php echo base_url(); ?>plugins/img/waiting.gif'>
</section>

<script type="text/javascript" src="<?php echo base_url(); ?>plugins/jQuery/jQuery-3.3.1.js"></script>
<link href="<?php echo base_url(); ?>plugins/DataTables2/datatables.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>plugins/DataTables2/datatables.min.js" type="text/javascript" ></script>

<script type="text/javascript">

	$(document).ready(function(){
		var ejercicios_url =  "<?php echo base_url(); ?>index.php/tpoadminv1/pnt/formato_b/ejercicios"
	
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
	    
	    var table = $('#grid').DataTable({
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
	    		url: "<?php echo base_url(); ?>index.php/tpoadminv1/pnt/formato_b/registrosb3",
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
				{ data: 'url_contrato' },
				{ data: 'url_convenio' }, //{ data: 'Hipervínculo al convenio modificatorio en su caso' },
				{ data: 'Monto total del contrato' },
				{ data: 'Monto pagado al periodo publicado' },
				{ data: 'fecha_inicio' },
				{ data: 'fecha_fin' },
				{ data: 'numeros_factura' },
				{ data: 'files_factura_pdf' }/*,
				{ data: 'estatus_pnt' }*/
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
                    targets: [4, 11, 12],
                    data: "data",
                    render: function ( data, type, row, meta ) {
                        try{
                          return data.split("-").reverse().join("/")
                        } catch(e){ return data}

                        return quitarTags(data)
                    }
                }/*,
                {
                    targets: [8],
                    data: "data",
                    render: function ( data, type, row, meta ) {
                    	console.log(data, row)
                    	if("url_convenio" in row && row.url_convenio != "")
                    		//return data
                    		return "<?php echo base_url(); ?>/data/convenios/" +  row.url_convenio
                        //return ""
                    }
                }/**/,
				{
				    targets: [3,4,5,6,7,8,9,10,11,12,13,14],
				    data: "data",
				    render: function ( data, type, row, meta ) {
				    	if( !(row.id_pnt) || row.id_pnt === ""){ 
				      		if(!data) return "<label class='btn'> <small> N/D </small></label>"
				        	return quitarTags(data)
					   } else return "<input type='text' value='" + quitarTags(row) + "'>" 
				    	//} else return data
				    }
				}
			]
	    });

	    $('#grid').on( 'draw.dt', function () {
		    //alert( 'Table redrawn' );
			$("#waiting").css("display", "block")
			setTimeout(function(){ 
				$("#waiting").css("display", "none")
	        }, 5000);
        	$(".dataTables_empty").removeClass("dataTables_empty")

		} );

	    setTimeout(function(){ 
            var year = window.location.href.split("#y")[1] 
            if(year) $('#year').val(year).trigger('change');
        }, 1500);

	})

</script>