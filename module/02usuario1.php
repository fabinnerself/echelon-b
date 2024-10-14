<!DOCTYPE html>
	<head>
		<title>Usuarios</title>
		<meta charset="utf-8">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>		
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> 
        <link rel="icon" href="../favicon.png">
		<style>
			body
			{
				margin:0;
				padding:0;
				background-color:#f1f1f1;
			}
			.box
			{
				width:1270px;
				padding:20px;
				background-color:#fff;
				border:1px solid #ccc;
				border-radius:5px;
				margin-top:25px;
			}
		</style>
	</head>
	<body>
		<div class="container box">
			<h1 align="center">Operaciones Usuarios </h1>			 
			<div class="table-responsive">
				<div align="right">
					<button type="button" id="prin_button" data-toggle="modal" data-target="#userModal" class="btn btn-primary ">Principal</button>
				</div>
				<div align="right">
					<button type="button" id="add_button" data-toggle="modal" data-target="#userModal" class="btn btn-success ">Adicionar</button>
				</div>
				
				<table id="user_data" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th width="10%">Id</th>
							<th width="35%">Nombres</th>
							<th width="35%">CI</th>                            
                            <th width="35%">Login</th>
							<th width="10%">Editar</th>
							<th width="10%">Eliminar</th>
						</tr>
					</thead>
				</table>
				
			</div>
		</div>
	</body>
</html>

<div id="userModal" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="user_form" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Adicionar Usuario</h4>
				</div>
				<div class="modal-body">
					<label>Persona</label>
					<input type="text" name="primer_nombre" id="primer_nombre" class="form-control" />
					<br />
					<label>Segundo Nombre</label>
					<input type="text" name="segundo_nombre" id="segundo_nombre" class="form-control" />
					<br />
                    <label>Paterno</label>
					<input type="text" name="paterno" id="paterno" class="form-control" />
					<br />
                    <label>Materno</label>
					<input type="text" name="materno" id="materno" class="form-control" />
					<br />
                    <label>Número Cédula Identidad</label>
					<input type="text" name="ci" id="ci" class="form-control" />
					<br />
                    <label>Fecha Nacimiento</label><br/>					
					<input type="date" id="fech_nac" name="fech_nac" class="form-control">
					<label>Titulo</label><br/>
					<select name="titulo" id="titulo" class="form-control">
						<option value="Lic">Licenciado</option>
						<option value="Ing.">Ingeniero</option>
						<option value="Doc">Doctor</option>
					</select>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="usuario_id" id="usuario_id" />
					<input type="hidden" name="operacao" id="operacao" />
					<input type="submit" name="action" id="action" class="btn btn-success" value="Grabar" />
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript" language="javascript" >
$(document).ready(function(){
	
	$('#add_button').click(function(){
		$('#user_form')[0].reset();
		$('.modal-title').text("Adicionar Usuario");
		$('#action').val("Grabar");
		$('#operacao').val("Add");
		
	});

	$('#prin_button').click(function(){
		window.location.href = '../index.html';
	});	
	
	var dataTable = $('#user_data').DataTable({
        //alert("in ");
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"02buscar_u.php",
			type:"POST"
		},
		"columnDefs":[
			{				
				"targets":[4 , 5],
				"orderable":false,
			},
		],
		"oLanguage": {
                    "sProcessing":   "Procesando...",
                    "sLengthMenu":   "Mostrar _MENU_ registros",
                    "sZeroRecords":  "No fueron encontrados resultados",
                    "sInfo":         "Mostrando de _START_ hasta _END_ de _TOTAL_ registros",
                    "sInfoEmpty":    "Mostrando de 0 hasta 0 de 0 registros",
                    "sInfoFiltered": "",
                    "sInfoPostFix":  "",
                    "sSearch":       "Buscar:",
                    "sUrl":          "",
                    "oPaginate": {
                        "sFirst":    "Primero",
                        "sPrevious": "Anterior",
                        "sNext":     "Siguiente",
                        "sLast":     "Último"
                    }
                },

	});



	$(document).on('submit', '#user_form', function(event){
		event.preventDefault();
		var nome = $('#primer_nombre').val();
		var paterno = $('#paterno').val();
		var fecha_nac = $('#fech_nac').val();
		
			
		if(nome != '' && paterno != '' && fecha_nac!= '')
		{
			$.ajax({
				url:"01inserir_alterar_p.php",
				method:'POST',
				data:new FormData(this),
				contentType:false,
				processData:false,
				success:function(data)
				{
					alert(data);
					$('#user_form')[0].reset();
					$('#userModal').modal('hide');
					dataTable.ajax.reload();
					dataTable.ajax.reload();
				}
			});
		}
		else
		{
			alert("Primer nombre, paterno y fecha de nacimiento, son obligatorios");
		}
	});
	
	$(document).on('click', '.update', function(){
		var usuario_id = $(this).attr("id");
		$.ajax({
			url:"01busca_unica_u.php",
			method:"POST",
			data:{usuario_id:usuario_id},
			dataType:"json",
			success:function(data){
				//alert (data.fech_nac); 
				$('#userModal').modal('show');
				$('#primer_nombre').val(data.primer_nombre);
				$('#segundo_nombre').val(data.segundo_nombre);
				$('#paterno').val(data.paterno);
				$('#materno').val(data.materno);
				$('#ci').val(data.ci);				
				document.getElementById('titulo').value = data.titulo;
				$('#fech_nac').val(data.fech_nac);				
				$('.modal-title').text("Edicion de registro de usuario");
				$('#usuario_id').val(usuario_id);				
				$('#action').val("Grabar");
				$('#operacao').val("Edit");
			}
		})
	});
	
	$(document).on('click', '.delete', function(){
		var persona_codigo = $(this).attr("id");
		//alert (" p "+persona_codigo);
		if(confirm("Esta seguro de eliminar este usuario ?"))
		{
			$.ajax({
				url:"01delete_p.php",
				method:"POST",
				data:{persona_codigo:persona_codigo},
				success:function(data)
				{
					alert(data);
					dataTable.ajax.reload();
					dataTable.ajax.reload();
				}
			});
		}
		else
		{
			return false;	
		}
	});
	
	
});
</script>