<?php  require'../../Control_Sesiones_Forms/frmControlSesionUsuario.php'; $FECHA=date('d/m/Y');
/*VERIFICA SI EXISTE LA CARPETA*/
$carpeta = date('Y');
if (!file_exists($carpeta)) {
    mkdir($carpeta, 0777, true);
}
require '../../Conexion_BD/Dbms_Usuario.php'; 
 /*BLOQEU Y DESBLOQUEO DE USUARIO*/
 if($ESTADOS=='BLOQUEO'){
		  $query = mysql_query("UPDATE usuarios SET ESTADO='BLOQUEADO POR EL ADMINISTRADOR $US_SIOI.' where USUARIO='$USUARIO' and ESTADO='DESBLOQUEADO'"); 
		  }else{
			  	$CONTRA=date('dmy').rand(1,100);
				$CONTRASE=md5($CONTRA);
			    $query = mysql_query("UPDATE usuarios SET ESTADO='DESBLOQUEADO',PASSWORD='$CONTRASE' where USUARIO='$USUARIO'"); 
			  }
 
$dias = array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");// Obtenemos y traducimos el nombre del mes
$mes=date("F");if ($mes=="January") $mes="Enero";if ($mes=="February") $mes="Febrero";if ($mes=="March") $mes="Marzo";if ($mes=="April") $mes="Abril";if ($mes=="May") $mes="Mayo";if ($mes=="June") $mes="Junio";if ($mes=="July") $mes="Julio";if ($mes=="August") $mes="Agosto";if ($mes=="September") $mes="Septiembre";if ($mes=="October") $mes="Octubre";if ($mes=="November") $mes="Noviembre";if ($mes=="December") $mes="Diciembre";// Obtenemos el número del día
$dia2=date("d");
// Obtenemos el año
$ano=date("Y");$HOY_ES=$dias[date('w')]." $dia2  $mes de $ano";$HORA=date('H:i:s');$GESTION=date('Y');
$result=mysql_query("select MAX(REPORTE) from nro_reporte ");if($fila=mysql_fetch_array($result)){$NRONUEVO=$fila[0]+1;$NROANT=$fila[0];$REPORTE="$NRONUEVO-$GESTION";}$query = mysql_query("UPDATE nro_reporte SET REPORTE='$NRONUEVO'"); 


require('fpdf.php');class PDF extends FPDF{//Cabecera de página
function Header(){    //Logo
   // $this->Image('Archivos_Pdfs/CODIGO_SEG.png',170,45,33);    //Arial bold 15
    $this->SetFont('courier', 'B', 12);    //Movernos a la derecha
    $this->Cell(140);}//Pie de página
function Footer(){    //Posición: a 1,5 cm del final
    $this->SetY(-25);    //Arial italic 8
    $this->SetFont('courier','I',8);   //Número de página
    $this->Cell(0,7,'Página '.$this->PageNo().'/{nb}',0,0,'C');}}//Creación del objeto de la clase heredada
$pdf=new PDF();$pdf->AliasNbPages();$pdf->AddPage();$pdf->SetLeftMargin(20);$pdf->SetAuthor("$US_ADM"); $pdf->SetFont('courier', '', 9);
$pdf->Ln(1);
$pdf->SetFont('courier','B', 10);
$pdf->Multicell(180,4,'ADMINISTRACION DE USUARIOS',0,'C');
$pdf->Multicell(180,4,'HERRAMIENTA INFORMATICA GREMIAL',0,'C');$pdf->Ln(1);$pdf->Multicell(180,4,'REPORTE DE '.$ESTADOS.' Nº. 000'.$NRONUEVO,0,'C');$pdf->SetFont('courier', '', 9);$pdf->Multicell(180,4,'-------------------------------------------------------------------------------------------',0,'C');$pdf->Ln(2);$pdf->SetFont('courier', '', 9);$pdf->Multicell(180,4,'Datos Generales :',0,'L');$pdf->Ln(1);$pdf->Multicell(180,4,'I. DATOS GENERALES :',0,'L');
 $resulty=mysql_query("select * from usuarios  WHERE  usuario='$USUARIO'");while($rowy=mysql_fetch_array($resulty)){
$pdf->Multicell(180,4,'NRO. DOCUMENTO:    '.$rowy["CEDULA_IDENTIDAD"].' '.$rowy["EXPEDIDO"],0,'L');$pdf->Multicell(180,4,'NOMBRE(S):         '.$rowy["NOMBRES"],0,'L');$pdf->Multicell(180,4,'PRIMER APELLIDO:   '.$rowy["PRIMER_APELLIDO"],0,'L');$pdf->Multicell(180,4,'SEGUNDO APELLIDO:  '.$rowy["SEGUNDO_APELLIDO"],0,'L');} $pdf->Ln(2);$pdf->Multicell(180,4,'CUENTA ASIGNADA:   '.$USUARIO,0,'L');
if(isset($CONTRA)){$pdf->Multicell(180,4,'CONTRASEÑA:        '.$CONTRA,0,'L');

}$pdf->Ln(4);$pdf->SetFont('courier','',8);
$pdf->Ln(3);$pdf->Multicell(180,3,'II. ROL(ES) ASIGNADO(S) - VIGENTE(S).',0,'L');$pdf->Multicell(180,2,'-------------------------------------------------------------------------------------------------------',0,'C');

$result=mysql_query("select * from asignacion_roles  WHERE USUARIO='$USUARIO' and APLICACION='SIOI' and ESTADO='VIGENTE' order by  SIGLA,CODIGO_ROL");while($row=mysql_fetch_array($result)){ $CODIGO_ROL=$row["CODIGO_ROL"];
$resultp=mysql_query("select * from menu_oi  WHERE  CODIGO_ROL='$CODIGO_ROL' and ESTADO='ACTIVO'");while($rowp=mysql_fetch_array($resultp)){
$pdf->Multicell(180,4,'- '.$rowp["SIGLA"].' :: '.$rowp["DESCRIPCION"],0,'J');
}}


$pdf->Ln(3);$pdf->Multicell(180,3,'III. RECOMENDACIONES',0,'L');$pdf->Multicell(180,4,'Todas las transacciones realizadas por el usuario con los roles detallados(Roles actuales), son de su responsabilidad. Para ello debe tomar en cuenta las siguientes consideraciones:',0,'J');$pdf->Multicell(180,4,'1. Mantener su cuenta y contraseña en absoluta reserva.',0,'J');$pdf->Multicell(180,4,'2. Cambiar su contraseña periódicamente(Recomendado).',0,'J');$pdf->Multicell(180,4,'3. En caso de sospecha o evidencia de que su contraseña fue copiada o utilizada sin su autorización, realizar el cambio de contraseña y dar parte por escrito a su superior en forma inmediata.',0,'J');$pdf->Ln(4);$pdf->Multicell(180,4,'IV. OBSERVACIONES',0,'L');$pdf->Multicell(180,4,'El usuario '.$USUARIO.' se '.$ESTADOS.' en fecha '.$HOY_ES.' a horas '.$HORA.'. El alcance del '.$ESTADOS.' se extiende a los roles que se  detallan en el numeral II de este reporte.',0,'J');$pdf->Ln(1);$pdf->Multicell(180,2,'--------------------------------------------------------------------------------------------------------',0,'C');$pdf->Multicell(180,3,'La información que se registra en este formulario es de carácter confidencial. Asimismo la información suministrada en este formulario representa una declaración Jurada, la cual deberá ser verdadera y confiable.',0,'J');$pdf->Ln(4);$pdf->Multicell(180,4,'El Alto, '.$HOY_ES,0,'R');$pdf->Ln(7);$pdf->Multicell(190,1,'Firma Usuario',0,'J');
$pdf->Ln(2);
$pdf->Multicell(190,4,'Aclaración de Firma:',0,'J');
$pdf->Ln(1);
$pdf->Multicell(190,4,'Número de Cédula de Identidad:',0,'J');
$GUARDAR="SIFM-$NRONUEVO-$GESTION"; 
/*GUARDA EL REPORTE GENERADO*/
//$sql="insert into reporte_generados_doc(PC_NAME,PC_IP,USUARIO_ADM,NOMBRE_ADM,FECHA,HORA,USUARIO,REPORTE,SISTEMA,TAREA,ENLACE)values('$hostname','$hostlocal','$US_SIAU','$SIAUNOMBRES $SIAUPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$USUARIO','$REPORTE','SIATP','$ESTADOS DEL SISTEMA SIATP DEL USUARIO $USUARIO','$GESTION/$GUARDAR.pdf')";$result=mysql_query($sql)or die ("NO SE PUDO EN LA RELACION reporte_generados_doc");
$pdf->Output("$GESTION/$GUARDAR.pdf",'f');echo "<script language='javascript'>window.open('$GESTION/$GUARDAR.pdf','_self','');</script>";
require '../../Conexion_BD/Cerrar_Dbms.php';/*para ver el archivo pdf generadoexit;*/?>