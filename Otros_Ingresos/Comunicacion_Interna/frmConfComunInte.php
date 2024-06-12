<?php  require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require 'frmControlSesion.php';
require_once('../Control_Sesiones_Forms/Loading.php'); require '../Conexion_BD/Dbms.php';
$CODIGO_REGISTRO=date('Ymd His');
if($REG==1){
	
$sql1="insert into reg_comunicacion_interna_autoridades(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,NIVEL,NOMBRE_A,CARGO_A)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$CODIGO_REGISTRO','$sltNivel','$txtNombres','$txtCargo')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_comunicacion_interna_autoridades.");	

$sql1="insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$CODIGO_REGISTRO','NO DEFINIDO','NO DEFINIDO','CONFIGURACION DE COMUNICACION INTERNA','CONFIGURACION DE COMUNICACION INTERNA - $sltNivel.','CONFIGURACION DE COMUNICACION INTERNA - $sltNivel.','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones."); 
	}
	
if($REGMOD==1){
$query = mysql_query("UPDATE reg_comunicacion_interna_autoridades  SET ESTADO='NO ACTIVO',OBSERVACIONES='CONFIGURACION MODIFICADO POR EL USUARIO $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, EN FECHA; $FECHA HORA: $HORA.' where NIVEL='$sltNivel' and ESTADO='ACTIVO'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DEL reg_secretario_general_asociacion.");

$sql1="insert into reg_comunicacion_interna_autoridades(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,NIVEL,NOMBRE_A,CARGO_A)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$CODIGO_REGISTRO','$sltNivel','$txtGrado $txtNombres','$txtCargo')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_comunicacion_interna_autoridades.");	

$sql1="insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$CODIGO_REGISTRO','NO DEFINIDO','NO DEFINIDO','MODIFICACION DE CONFIGURACION DE COMUNICACION INTERNA','MODIFICACION DE CONFIGURACION DE COMUNICACION INTERNA - $sltNivel.','MODIFICACION DE CONFIGURACION DE COMUNICACION INTERNA - $sltNivel.','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones."); 	
	}

if($ELIMINAR==1){
$query = mysql_query("UPDATE reg_comunicacion_interna_autoridades  SET ESTADO='NO ACTIVO',OBSERVACIONES='CONFIGURACION MODIFICADO POR EL USUARIO $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, EN FECHA; $FECHA HORA: $HORA.' where NIVEL='$NIVEL' and ESTADO='ACTIVO'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DEL reg_secretario_general_asociacion.");
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
<link rel="stylesheet" href="../CssTablas/Css/bootstrap.min.css">
<link rel="stylesheet" href="../CssTablas/Css/dataTables.bootstrap.min.css">
<script src="../CssTablas/Js/jquery-3.3.1.js"></script>
<script src="../CssTablas/Js/jquery.dataTables.min.js"></script> 
<script src="../CssTablas/Js/dataTables.bootstrap.min.js"></script>
</head>

<body>
<table width="100%" border="0">
  <tr>
    <td><img src="../Img/Blanco.png" width="10" height="6" /></td>
    <td><table width="90%" border="0" align="left">
      <tr>
        <td align="center" class="TITULO"> <?php $result=mysql_query("select * from nombre_formularios where UBICACION='CONFIGURAR COMUNICACION INTERNA' and ESTADO='ACTIVO'"); while($row=mysql_fetch_array($result)){ echo $row['DESCRIPCION']; }?></td>
      </tr>
      <tr>
        <td align="center" class="SUBTITULO">Comunicación Interna</td>
      </tr>
      <tr>
        <td style="font-weight: bold">Configuración de Comunicación Interna.</td>
      </tr>
      <tr>
        <td><img src="../Img/Linea_Negra.png" width="1070" height="19" /></td>
      </tr>
      <tr>
        <td><table id="example" class="table table-striped table-bordered" style="width:100%;">
          <thead>
            <tr>
              <td height="27" align="center" bgcolor="#CCCCCC" style="font-weight: bold">No.</td>
              <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">NIVEL</td>
              <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">NOMBRE DE AUTORIDAD</td>
              <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">CARGO DE AUTORIDAD</td>
              <td align="center" style="font-weight: bold">&nbsp;</td>
            </tr>
          </thead>
          <tbody>
            <?php $result=mysql_query("select * from reg_comunicacion_interna_autoridades where ESTADO='ACTIVO' order by NIVEL "); while($row=mysql_fetch_array($result)){ ?>
            <tr>
              <td><?php $CONT++; echo $CONT; ?></td>
              <td><?php if($row['NIVEL']=='NIVEL 1'){echo 'A';}else{echo $row['NIVEL'];} ?></td>
              <td><?php echo $row['NOMBRE_A']; ?></td>
              <td><?php echo $row['CARGO_A']; ?></td>
              <td align="center" style="font-weight: bold"><table width="80%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="13%"><img src="../Img/Modificares.jpg" width="30" height="30" /></td>
                  <td width="47%"><a href="frmConfComunInte2.php?NIVEL=<?php echo $row['NIVEL'];?>">Modificar</a></td>
                  <td width="7%" align="right"><img src="../Img/Eliminar.png" width="35" height="30" /></td>
                  <td width="33%"><a href="frmConfComunInte.php?ELIMINAR=1&NIVEL=<?php echo $row['NIVEL'];?>">Eliminar</a></td>
                </tr>
              </table>                <a href="frmSecretarioGeneral1.php?COD_ASOCIACION=<?php echo $row['5'];?>&ASOCIACION=<?php echo $row['1'];?>"></a></td>
            </tr> <?php } ?>
            <tr>
              <td><?php echo $CONT=$CONT+1;?></td>
              <td align="center"><a href="frmConfComunInte1.php">................</a></td>
              <td align="center"><a href="frmConfComunInte1.php">................</a></td>
              <td align="center"><a href="frmConfComunInte1.php">................</a></td>
              <td align="center" style="font-weight: bold"><table width="80%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="right"><img src="../Img/Agregar.png" width="35" height="35" /></td>
                  <td><a href="frmConfComunInte1.php">Agregar Nuevo Nivel</a></td>
                </tr>
              </table>                <a href="frmConfComunInte1.php"></a></td>
            </tr>
            <tr>
              <td><?php echo $CONT=$CONT+1;?></td>
              <td>DE</td>
              <td><?php echo $SIAUNOMBRES.' '.$USPRIMERAPELLIDO.' '.$SIAUSEGUNDOAPELLIDO;?></td>
              <td><?php echo $SIOICARGO;?></td>
              <td align="center" style="font-weight: bold"></td>
            </tr>
           
            
          </tbody>
          <tfoot>
          </tfoot>
          <tfoot>
          </tfoot>
        </table></td>
      </tr>
      <tr>
        <td><hr /></td>
      </tr>
      <tr>
        <td class="ASTERISCO">VER. 0</td>
      </tr>
    </table></td>
  </tr>
</table>
<?php include '../CssTablas/frmPieTabla.php'?>
</body>
</html><?php  require '../Conexion_BD/Cerrar_Dbms.php';?>