<!DOCTYPE html>
	<head>
		<title>Operaciones Persona</title>
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
			<h1 align="center">Operaciones Usuario </h1>			 
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
                            <th width="35%">Nombre Usuario</th>
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
					<select name="id_persona" id="id_persona" class="form-control" class="form-control">
                    <!-- Opciones serán cargadas aquí -->
                	</select>
					<br />
					<label>Nombre de Usuario</label>
					<input type="text" name="login" id="login" class="form-control" />
					<br />
                    <label>Contraseña</label>
					<input type="password" name="pasw" id="pasw" class="form-control" />
					<br />
                    <label>Verificar Contraseña</label>
					<input type="password" name="paswv" id="paswv" class="form-control" />
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

	$(document).ready(function() {
            $.ajax({
                url: '02cbx_persona.php',
                method: 'GET',
                success: function(data) {
                    $('#id_persona').html(data);
                },
                error: function(xhr, status, error) {
                    console.error('Error al obtener los datos:', error);
                }
            });
    });	
	
	$('#add_button').click(function(){
		$('#user_form')[0].reset();
		$('.modal-title').text("Adicionar Usuario");
		$('#action').val("Grabar");
		$('#operacao').val("Add");
		$('#user_uploaded_image').html('');
	});

	$('#prin_button').click(function(){
		window.location.href = '../index.html';
	});	
	
	var dataTable = $('#user_data').DataTable({
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"02buscar_u.php",
			type:"POST"
		},
		"columnDefs":[
			{				
				"targets":[ 4,5],
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

		var pasw1 = $('#pasw').val();
		var pasw2 = $('#pasw').val();
		var login = $('#login').val();		
			
		if(login != '' && pasw1 == pasw2 && pasw2!= ''  ){
			$.ajax({
				url:"02inserir_alterar_u.php",
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
			url:"02busca_unica_u.php",
			method:"POST",
			data:{usuario_id:usuario_id},
			dataType:"json",
			success:function(data){
				//alert (data.fech_nac); 
				$('#userModal').modal('show');
				$('#login').val(data.login);
				$('#pasw').val(data.pasw);
				$('#paswv').val(data.paswv);			
				document.getElementById('id_persona').value = data.id_persona;
				$('.modal-title').text("Edicion de registro de Usuario");
				$('#usuario_id').val(usuario_id);				
				$('#action').val("Grabar");
				$('#operacao').val("Edit");
			}
		})
	});
	
	$(document).on('click', '.delete', function(){
		var user_codigo = $(this).attr("id");
		//alert (" p "+user_codigo);
		if(confirm("Esta seguro de eliminar este usuario ?"))
		{
			$.ajax({
				url:"02delete_u.php",
				method:"POST",
				data:{user_codigo:user_codigo},
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