<?php session_start();
unset($_SESSION['US_SIOI'],$_SESSION['SIOIUNOMBRES'],$_SESSION['USNOMBRES'],$_SESSION["USPRIMERAPELLIDO"],$_SESSION['SIAUPRIMERAPELLIDO'],$_SESSION["USSEGUNDOAPELLIDO"],$_SESSION['SIAUSEGUNDOAPELLIDO']);
if($INTENTOS==0){}else{
if($INTENTOS>3){
echo"<script>alert('USUARIO y/o CONTRASEÑA NO VALIDA, VUELVA A INTENTARLO LUEGO.');</script>";
echo"<script> location.href='../Control_Sesiones_Forms/frmLogeoUsuarioNoAutentificacion.php';</script>";
}else{
echo"<script>alert('USUARIO y/o CONTRASEÑA NO VALIDA.');</script>";
	}
}?>
<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6 lt8"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7 lt8"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8 lt8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="UTF-8" />
        <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">  -->
        <title>.:: GAMEA - GREMIAL ::.</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <meta name="description" content="Login and Registration Form with HTML5 and CSS3" />
        <meta name="keywords" content="html5, css3, form, switch, animation, :target, pseudo-class" />
        <meta name="author" content="Codrops" />
        <link rel="shortcut icon" href="../favicon.ico"> 
        <link rel="stylesheet" type="text/css" href="css/demo.css" />
        <link rel="stylesheet" type="text/css" href="css/style3.css" />
		<link rel="stylesheet" type="text/css" href="css/animate-custom.css" />
        <script language="JavaScript" src='Js/frmMax.js' type="text/javascript"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style type="text/css">
    body {
	background-image: url(images/fondo3.jpg);
}
    </style>
    </head>
<body>
        <div class="container">
            <!-- Codrops top bar -->
            <div class="codrops-top">
                         <span class="left"><strong>Fecha : </strong><?php echo $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y'); ?></span>
               
                <span class="right">
                    <a href=" #">
                        <strong>.:: GOBIERNO AUTONOMO MUNICIPAL DE EL ALTO .:. SECRETARIA MUNICPAL ADMINISTRATIVA FINANCIERA .:. DIRECCION DE ADMINISTRACION TRIBUTARIA MUNICIPAL ::.</strong>
                    </a>
                </span>
              <div class="clr"></div>
            </div><!--/ Codrops top bar -->
            <header>
                <h1>GAMEA<span style="color: #F90"> NOMBRE DEL SISTEMA</span></h1>
				
            </header>
            <section>				
                <div id="container_demo" >
                    <!-- hidden anchor to stop jump http://www.css3create.com/Astuce-Empecher-le-scroll-avec-l-utilisation-de-target#wrap4  -->
                    <a class="hiddenanchor" id="toregister"></a>
                    <a class="hiddenanchor" id="tologin"></a>
                    <div id="wrapper">
                        <div id="login" class="animate form">
                            <form  action="e675ecdca6c032b8791a651b1d56e47b.php" autocomplete="off"> 
                                <h1>Usuario del Sistema</h1> 
                                <p> 
                                    <label for="username" class="uname" data-icon="u" > Usuario Asignado	 </label>
                                    <input id="username" name="username" required="required" type="text" onChange="javascript:this.value=this.value.toUpperCase();" placeholder="Usuario Asignado"/>
                                </p>
                                <p> 
                                    <label for="password" class="youpasswd" data-icon="p"> Contraseña </label>
                                    <input id="password" name="password" required="required" type="password" placeholder="Ingrese su contraseña" /> 
                                </p>
                               
                                <p class="login button"> 
                                    <input type="submit" value="Ingresar" /> 
								</p>
                                <p class="change_link">
									No tengo Usuario
									<a href="javascript:window.close();" class="to_register">Salir</a>
								</p>
                            </form>
                        </div>
                    </div>
                </div>  
            </section>
        </div>
    </body>
</html>