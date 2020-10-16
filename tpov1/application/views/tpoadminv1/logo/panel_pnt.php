<?php

/* 
 INAI / PANEL PNT
 */
?>
<section class="content">
	<h2> Panel PNT </h2>
	<div >
		<form id="traer_campos">
			<select id="formatos"> <option> Selecciona un Formato </option> </select>
			 <input type="submit" /> 
		</form>
	</div>
</section>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$.post("http://localhost/tpov2/index.php/tpoadminv1/logo/logo/traer_formatos", {}, function(data){
			/*
			console.log(data.mensaje[0].codigo);
			console.log(data.mensaje[0].id);
			console.log(data.mensaje[0].nombre);
			/**/

			var rdata;
			for (var i in data.mensaje[0].normatividades[0] ){
				rdata = data.mensaje[0].normatividades[0].estructuraFormatos
				for( var j in rdata ){
					$("#formatos").append("<option value='" + rdata[j].idFormato + "''>" + rdata[j].nombreFormato + "</option>")
				}
			}
			console.log( data.mensaje[0].normatividades[0] );

			/*
			console.log( data.mensaje[0].normatividades[0] );
			console.log( data.mensaje[0].normatividades[0].id );
			console.log( data.mensaje[0].normatividades[0].nombre );
			console.log( data.mensaje[0].normatividades[0].estructuraFormatos );
			*/
		})

		$("#traer_campos").on("submit", function(){
			$.post("http://localhost/tpov2/index.php/tpoadminv1/logo/logo/traer_campos", {"idFormato": 43344}, function(data){
				console.log(data)
			})
			return false;

		})
	})
</script>
