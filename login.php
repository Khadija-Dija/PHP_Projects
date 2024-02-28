<?php 
//random_bytes(16) génère une chaîne d'octets aléatoires de longueur 16
//bin2hex convertit les données binaires en une représentation hexadécimale. 
  $token=bin2hex(random_bytes(16));
//   var_dump($token);

  
?>

<!doctype html>
<html lang="en" class="h-100" data-bs-theme="auto">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <title>Gestion commandes</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet" >
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <style>
        body {
    padding-top: 90px;
}
.panel-login {
	border-color: #ccc;
	-webkit-box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
	-moz-box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
	box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
}
.panel-login>.panel-heading {
	color: #00415d;
	background-color: #fff;
	border-color: #fff;
	text-align:center;
}
.panel-login>.panel-heading a{
	text-decoration: none;
	color: #666;
	font-weight: bold;
	font-size: 15px;
	-webkit-transition: all 0.1s linear;
	-moz-transition: all 0.1s linear;
	transition: all 0.1s linear;
}
.panel-login>.panel-heading a.active{
	color: #029f5b;
	font-size: 18px;
}
.panel-login>.panel-heading hr{
	margin-top: 10px;
	margin-bottom: 0px;
	clear: both;
	border: 0;
	height: 1px;
	background-image: -webkit-linear-gradient(left,rgba(0, 0, 0, 0),rgba(0, 0, 0, 0.15),rgba(0, 0, 0, 0));
	background-image: -moz-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
	background-image: -ms-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
	background-image: -o-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
}
.panel-login input[type="text"],.panel-login input[type="email"],.panel-login input[type="password"] {
	height: 45px;
	border: 1px solid #ddd;
	font-size: 16px;
	-webkit-transition: all 0.1s linear;
	-moz-transition: all 0.1s linear;
	transition: all 0.1s linear;
}
.panel-login input:hover,
.panel-login input:focus {
	outline:none;
	-webkit-box-shadow: none;
	-moz-box-shadow: none;
	box-shadow: none;
	border-color: #ccc;
}
.btn-login {
	background-color: #59B2E0;
	outline: none;
	color: #fff;
	font-size: 14px;
	height: auto;
	font-weight: normal;
	padding: 14px 0;
	text-transform: uppercase;
	border-color: #59B2E6;
}
.btn-login:hover,
.btn-login:focus {
	color: #fff;
	background-color: #53A3CD;
	border-color: #53A3CD;
}
.forgot-password {
	text-decoration: underline;
	color: #888;
}
.forgot-password:hover,
.forgot-password:focus {
	text-decoration: underline;
	color: #666;
}

.btn-register {
	background-color: #1CB94E;
	outline: none;
	color: #fff;
	font-size: 14px;
	height: auto;
	font-weight: normal;
	padding: 14px 0;
	text-transform: uppercase;
	border-color: #1CB94A;
}
.btn-register:hover,
.btn-register:focus {
	color: #fff;
	background-color: #1CA347;
	border-color: #1CA347;
}

    </style>
    <script>
        $(function() {
        $('#login-form-link').click(function(e) {
            $("#login-form").delay(100).fadeIn(100);
            $("#register-form").fadeOut(100);
            $('#register-form-link').removeClass('active');
            $(this).addClass('active');
            e.preventDefault();
        });
        $('#register-form-link').click(function(e) {
            $("#register-form").delay(100).fadeIn(100);
            $("#login-form").fadeOut(100);
            $('#login-form-link').removeClass('active');
            $("#password-forgot-form").fadeOut(100);
            $('#password-forgot-form-link').removeClass('active');
            $('#password-forgot-form-link').css("display","none");
            $("#login-form-link").css("display","block");
            $(this).addClass('active');
            e.preventDefault();
        });
        $('#password-forgot-form-link').click(function(e) {
            $("#password-forgot-form").delay(100).fadeIn(100);
            $("#login-form").fadeOut(100);
            $('#register-form-link').removeClass('active');
            $(this).addClass('active');
            e.preventDefault();
        });

        });

    </script>
  <script>
    function checkpassword(){
        let pwd = $("#password").val();
        let confirm_pwd = $("#confirm_password").val();
        if(pwd != confirm_pwd){
            // Supprimer toutes les classes d'alerte précédentes
            $("#checkpass").removeClass("alert-danger alert-success");
            // Ajouter la classe d'alerte pour mot de passe non correspondant
            $("#checkpass").addClass("alert alert-danger");
            $("#checkpass").html("Les mots de passe ne correspondent pas !");
        }
        else{
            // Supprimer toutes les classes d'alerte précédentes
            $("#checkpass").removeClass("alert-danger alert-success");
            // Ajouter la classe d'alerte pour mot de passe correspondant
            $("#checkpass").addClass("alert alert-success");
            $("#checkpass").html("Les mots de passe identiques !");
        }
    }

    $(document).ready(function(){

        $("#forgot").click(function(e){
            e.preventDefault();
            $("#login-form").css("display","none");
            $("#password-forgot-form").css("display","block");
            $("#password-forgot-form-link").addClass("active");
            $("#password-forgot-form-link").css("display","block");
            $("#login-form-link").removeClass("active");
            $("#login-form-link").css("display","none");

        });
        $("#register-form").submit(function(ev) {
        ev.preventDefault();
        $.ajax({
        type: 'POST',
        url: 'ajaxData.php',
        data: $("#register-form").serialize(),
        dataType: 'json',
        success: function(response) {
            if (response.username) {
            console.log(response);
            $("#checkusername").addClass("alert alert-danger");
            $("#checkusername").html(response.username);
            } else {
            if (response.email) {
                console.log(response);
                $("#checkusername").removeClass();
                $("#checkusername").empty();
                $("#checkemail").addClass("alert alert-danger");
                $("#checkemail").html(response.email);
                console.log("Une erreur");
                console.log(response.value);
            } else {
                $("#checkusername").removeClass();
                $("#checkusername").empty();
                $("#checkemail").removeClass();
                $("#checkemail").empty();
                if (response.value) {
                console.log("register avec succes");
                toastr.success(response.msg);
                $("#register-form")[0].reset();
                $("#register-form-link").removeClass("active");
                $("#checkpass").removeClass();
                $("#checkpass").empty();
                $("#login-form-link").addClass("active");
                $("#login-form").css("display", "block");
                $("#register-form").css("display", "none");
                } else {
                toastr.error(response.msg);
                }
            }
            }
        }
        });
  });
        // Déclencher la méthode checkpassword
        $("#confirm_password").keyup(checkpassword);
        $("#login-form").submit(function(e){
            e.preventDefault();
            $.ajax({
            type: 'POST',
            url: 'ajaxData.php',
            data: $("#login-form").serialize(),
            dataType: 'json',
            success: function(response) {
                if(response.user){
                    console.log(response.user);
                    $("#checkuser").addClass("alert alert-danger");
                    $("#checkuser").html(response.user);
                }
                else{
                        $("#checkuser").removeClass();
                        $("#checkuser").empty();
                    if(response.value==false){
                  
                        $("#checkpwd").addClass("alert alert-danger");
                        $("#checkpwd").html(response.msg);
                    }
                    else{

                        //redirection si le mot de passe est valide
                        window.location="index.php";
                    }
                }
            }
            })

        });
        //mot de passe oublie
        $("#password-forgot-form").submit(function(e){
            e.preventDefault();
            $.ajax({
            type: 'POST',
            url: 'ajaxData.php',
            data: $("#password-forgot-form").serialize(),
            dataType: 'json',
            success: function(response) {
                if(!response.value){
                    $("#checkemail").addClass("alert alert-danger");
                    $("#checkemail").html(response.msg);
                    // $("#password-forgot-form")[0].reset();
                }
                else{
                    $("#checkemail").removeClass();
                    $("#checkemail").empty();
                    toastr.success(response.msg);
                    // $("#password-forgot-form")[0].reset();

                }
            }
            })

        });
       //changer le mot de passe change-pwd-form
       $("#change-pwd-form").submit(function(e){
            e.preventDefault();
            $.ajax({
            type: 'POST',
            url: 'ajaxData.php',
            data: $("#change-pwd-form").serialize(),
            dataType: 'json',
            success: function(response) {
                // console.log(response.msg);
              if(!response.value){

                $("#checkuser").addClass("alert alert-danger");
                $("#checkuser").html(response.msg);
              }
              else{

                console.log(response.msg);
                window.location="login.php";
              }
            }
            })

        });
            
 });
</script>

    </head>
    <body>
    <?php 
    //verifer si les variable email et token existe dans la requete
    $email=!empty($_GET["email"])?trim($_GET["email"]):"";
    $token=!empty($_GET["token"])?trim($_GET["token"]):"";
  

    ?>
    <!------ Include the above in your HEAD tag ---------->
    <div class="container">
       <?php if($email && $token){?>
   
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="panel panel-login">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <a href="#" class="active" id="change-pwd-form-link">Changer le mot de passe</a>
                                    </div>
                                </div>
                                <hr>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <form id="change-pwd-form" action="" method="post" role="form">
                                            <div id="checkuser"></div>
                                            <div class="form-group">
                                               
                                                <input type="text" name="user_token" value=<?php echo $token?>>
                                                <input type="text" name="user_mail" value=<?php echo $email?>>
                                                <input type="password" name="new_password" id="password" tabindex="2" class="form-control" placeholder="Nouveau mot de passe" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="confirm_new_password" id="confirm_password" tabindex="2" class="form-control" placeholder="Confirmer mot de passe" required>
                                            </div>
                                            <div id="checkpass">
                                            </div> 
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-sm-6 col-sm-offset-3">
                                                        <input type="submit" name="change-pwd-submit" id="change-pwd-submit" tabindex="4" class="form-control btn btn-register" value="Submit">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        
        <?php }else{?>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-login">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-6">
                                    <a href="#" class="active" id="login-form-link">Se connecter</a>
                                    <a href="#" id="password-forgot-form-link"style="display: none;">Mot de passe oublié</a>
                                </div>
                                <div class="col-xs-6">
                                    <a href="#"  id="register-form-link">Créer un compte</a>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form id="login-form" action="" method="post" role="form"  style="display: block;">
                                        <div class="form-group">
                                            <input type="text" name="username_login" id="username_login" tabindex="1" class="form-control" placeholder="Nom " required>
                                        </div>
                                        <div id="checkuser"></div>
                                        <div class="form-group">
                                            <input type="password" name="password_login" id="password_login" tabindex="2" class="form-control" placeholder="Mot de passe" required>
                                        </div>
                                        <div id="checkpwd"></div>
                                        <div class="form-group text-center">
                                            <input type="checkbox" tabindex="3" class="" name="remember" id="remember">
                                            <label for="remember"> Remember Me</label>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-6 col-sm-offset-3">
                                                    <input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Log In">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="text-center">
                                                        <a href="" id="forgot" tabindex="5" class="forgot-password">Mot de passe oublié?</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <form id="password-forgot-form" action="" method="post" role="form" style="display: none;">
                                        <div class="form-group">
                                            <input type="email" name="email_pwd_forgot" id="email_pwd_forgot" tabindex="1" class="form-control" placeholder="Email" required>
                                        </div>
                                        <div id="checkemail"></div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-6 col-sm-offset-3">
                                                    <input type="submit" name="password_forgot_submit" id="password_forgot_submit" tabindex="4" class="form-control btn btn-register" value="Submit" >
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="text-center">
                                                        <a href=""  tabindex="5" class="forgot-password">Se connecter</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <form id="register-form" action="" method="post" role="form" style="display: none;">
                                        <div class="form-group">
                                            <input type="text" name="username_register" id="username_register" tabindex="1" class="form-control" placeholder="Nom" required>
                                        </div>
                                        <div id="checkusername"></div>
                                        <div class="form-group">
                                            <input type="email" name="email_register" id="email_register" tabindex="1" class="form-control" placeholder="Email" required>
                                        </div>
                                        <div id="checkemail"></div>
                                        <div class="form-group">
                                            <input type="password" name="password_register" id="password" tabindex="2" class="form-control" placeholder="Mot de passe" required>
                                        </div>
                     
                                        <div class="form-group">
                                            <input type="password" name="confirm-password_register" id="confirm_password" tabindex="2" class="form-control" placeholder="Confirmer mot de passe" required>
                                        </div>
                                        <div id="checkpass">
                                        </div> 
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-6 col-sm-offset-3">
                                                    <input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Register Now">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php }?>
    </div>
        <script src=" https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" ></script>
    </body>
</html>