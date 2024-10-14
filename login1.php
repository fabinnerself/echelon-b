<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingreso al sistema ECHELON</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <link rel="icon" href="lib/img/favicon.png">
    <style>
        .password-input-container {
            position: relative;
        }
        .password-input {
            padding-right: 32px;
        }
        .toggle-password {
            position: absolute;
            top: 8px;
            right: 10px;
            cursor: pointer;
            z-index: 9999;
        }        
        body {
            background-color: #AEF3E7;
        }
        .card {
            background-color: #a0d8ef; /* Borde de la tarjeta del mismo color que el fondo */
        } 
    </style>   
    
    <script type="text/javascript">
	
        function fn_ingresar(){
            
            var form = $('#form_login');  
            var str_login=$('#txt_user_login').val();
            var str_pwd=$('#txt_user_password').val();

            if(str_login!=='' && str_login!==''){

                if (form[0].checkValidity() === false) {
                    //alert ("in false");
                    event.preventDefault();
                    event.stopPropagation();
                    form.addClass('was-validated');
                    return;
                }
                 

                $.ajax({
                    type: 'POST',
                    url: 'login.php',
                    data: form.serialize(),
                    success: function(result) {
                        var result = JSON.parse(result);
                        if (result.success) {
                            alert('Suceso: ' + result.msg);
                            fn_ir();
                        } else {
                            alert('Error: ' + result.msg);
                        }
                    },
                    error: function() {
                        alert('Error en la comunicación con el servidor.');
                    }
                }); 

            }
            else{
                alert("El campo usario y contraseña no pueden estar vacios");
            }        
        }
        
        function fn_ir(){
            $(location).attr('href','index.html');
        }
     
         function fn_cancela(){		 
            $('#form_login').form('clear');
            $('#txt_user_login').focus();
        }
        $(document).ready(function () {
        $(".toggle-password").click(function () {
            var passwordInput = $(this).siblings(".password-input");
            var icon = $(this);
            if (passwordInput.attr("type") === "password") {
                passwordInput.attr("type", "text");
                icon.removeClass("fa-eye").addClass("fa-eye-slash");
            } else {
                passwordInput.attr("type", "password");
                icon.removeClass("fa-eye-slash").addClass("fa-eye");
            }
            $('#form_login').form('load','logout.php');
            fn_cancela();             
        });
    });
    
        </script>    
</head>
<body>

<div class="container mt-5">
    <div class="card mx-auto" style="width: 25rem;">
        <div class="card-body">
            <h5 class="card-title text-center "><b>Ingreso al sistema ECHELON</b></h5>
            <form id="form_login" method="post" novalidate>
                <div class="form-group">
                    <label for="usuario">Usuario:</label>
                    <input type="text" class="form-control" id="txt_user_login" name="txt_user_login" required maxlength="15">
                    <div class='invalid-feedback'>Ingrese su usuario.</div>
                </div>

                <div class='form-group'>
                    <label for='contrasena'>Contraseña:</label>
                    <div class="password-input-container">
                        <input id="txt_user_password" name="txt_user_password" class="form-control password-input"
                               data-options="required:true, missingMessage:'Este campo es Requerido'"
                               type="password" maxlength="15">
                        <i class="toggle-password fa fa-eye"></i>
                    </div>
                    <div class='invalid-feedback'>Ingrese su contraseña.</div>
                </div>
                <div style="align-items: right;">
                <button type='submit' class='btn btn-success' onclick="fn_ingresar()" >Ingresar</button>
                <button type='button' class='btn btn-secondary'>Cancelar</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>

</script>

</body>
</html>
