<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require 'frmControlSesion.php';
require_once('../Control_Sesiones_Forms/Loading.php');
require '../Conexion_BD/Dbms.php';
$FECHA = date('Y-m-d');
$HORA = date('H:i:s');
$CODIGO_REGISTRO = date('Ymd His') . rand(100, 1000);
if ($txtSW == 1) {
  echo "UFVS REGISTRADO";
  $sql1 = "insert into historial_ufvs(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA_REGISTRO,HORA,CODIGO_REGISTRO,GESTION,FECHA,UFV)
   values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$CODIGO_REGISTRO','$sltGestion','$txtFecha','$txtValor')";
  $result = mysql_query($sql1) or die("NO SE PUDO REGISTRAR EN LA ENTIDAD historial_ufvs.");
  echo "<script>alert('Se registro la Ufv Ingresada.')</script>";
  //REGISTRA EN TRANSACCIONES
  $sql1 = "insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$CODIGO_REGISTRO','HISTORIAL UFV','HISTORIAL UFV','HISTORIAL UFV','HISTORIAL UFV DE FECHA $txtFecha VALOR: $txtValor','HISTORIAL UFV DE FECHA $txtFecha VALOR: $txtValor','0')";
  $result = mysql_query($sql1) or die("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones.");
}
if ($MODI == 1) {
  echo "HISTORIAL UFVS MODIFICADO";
  $query = mysql_query("UPDATE historial_ufvs  SET ESTADO='NO ACTIVO',OBSERVACIONES='DATO ELIMINADO EN FECHA $FECHA Hrs.: $HORA - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO' WHERE Id='$IDS' and ESTADO='ACTIVO'") or die("NO SE PUDO ACTUALIZAR LOS DATOS DEL nros_correlativos asociacion.");
  //REGISTRA EN TRANSACCIONES
  $sql1 = "insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$CODIGO_REGISTRO','ELIMINAR HISTORIAL UFV','HISTORIAL UFV','ELIMINAR HISTORIAL UFV','ELIMINAR HISTORIAL UFV DE FECHA $FECHAV','HISTORIAL UFV DE FECHA $FECHAV','0')";
  $result = mysql_query($sql1) or die("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones.");
}

echo "";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
  <link rel="stylesheet" href="../CssTablas/Css/bootstrap.min.css">
  <link rel="stylesheet" href="../CssTablas/Css/dataTables.bootstrap.min.css">
  <script src="../CssTablas/Js/jquery-3.3.1.js"></script>
  <script src="../CssTablas/Js/jquery.dataTables.min.js"></script>
  <script src="../CssTablas/Js/dataTables.bootstrap.min.js"></script>
  <script src="Js/frmValida.js"></script>
</head>
<form method="post" action="frmHistorialUfv.php">

  <body>
    <table width="90%" border="0" align="center">
      <tr>
        <td align="center" class="TITULO">AGREGAR UFV's</td>
      </tr>
      <tr>
        <td align="center" class="SUBTITULO">Agregar Ufv's</td>
      </tr>
      <tr>
        <td style="font-weight: bold">Registro de valores de Ufv's
          <hr />
        </td>
      </tr>
      <tr>
        <td style="font-weight: bold">
          <table width="100%" border="1" cellpadding="2" cellspacing="2" bordercolor="#FFFFFF">
            <tr>
              <td width="30%" align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Gestion :</td>
              <td width="30%"><select name="sltGestion" id="sltGestion">
                  <option><?php echo date('Y'); ?></option>
                </select></td>
              <td width="3%">&nbsp;</td>
              <td width="37%">&nbsp;</td>
            </tr>
            <tr>
              <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Fecha de Ufv :</td>
              <td><input name="txtFecha" type="date" id="txtFecha" style="width:250px; height:20px" value="<?php echo date('Y-m-d'); ?>" min="<?php echo date('Y-') . '01-' . '01'; ?>" required /></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Valor :</td>
              <!-- <td><input type="text" name="txtValor" id="txtValor" style="width:250px; height:20px" onkeypress="return soloNumeros(event)" placeholder="VALOR DE LA UFV"  required/> -->
              <td><input type="text" name="txtValor" id="txtValor" style="width:250px; height:20px" placeholder="VALOR DE LA UFV" required />
                <input name="txtSW" type="hidden" id="txtSW" value="1" />
              </td>
              <td><a href="https://www.bcb.gob.bo/?q=servicios/ufv/datos_estadisticos" target="_new"><img src="../Img/bcb.gif" alt="VER UFV EN BANCO CENTRAL DE BOLIVIA" width="31" height="31" /></a></td>
              <td><a href="https://www.bcb.gob.bo/?q=servicios/ufv/datos_estadisticos" title="VER UFV EN BANCO CENTRAL DE BOLIVIA" target="_new">Cotización Ufv's</a></td>
            </tr>
            <tr>
              <td align="right">&nbsp;</td>
              <td>Valores decimales (.) Punto</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td align="right"><img src="../Img/Blanco.png" width="250" height="6" /></td>
              <td>
                <input type="submit" name="button" id="button" value="Aceptar" style="width:250px; height:35px"   />
              </td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td style="font-weight: bold">&nbsp;</td>
      </tr>
      <tr>
        <td style="font-weight: bold">&nbsp;</td>
      </tr>
      <tr>
        <td style="font-weight: bold">Reporte de valores de Ufv's</td>
      </tr>
      <tr>
        <td>
          <hr />
        </td>
      </tr>
      <tr>
        <td>
          <table id="example" class="table table-striped table-bordered" style="width:100%;">
            <thead>
              <tr>
                <td height="27" align="center" style="font-weight: bold">No.</td>
                <td align="center" style="font-weight: bold">GESTION</td>
                <td align="center" style="font-weight: bold">FECHA</td>
                <td align="center" style="font-weight: bold">VALOR</td>
                <td align="center" style="font-weight: bold">&nbsp;</td>
              </tr>
            </thead>
            <tbody>
              <?php $result = mysql_query("select * from historial_ufvs where ESTADO='ACTIVO' order by Id desc");
              while ($row = mysql_fetch_array($result)) { ?>
                <tr>
                  <td><?php $CONT++;
                      echo $CONT; ?></td>
                  <td><?php echo $row['GESTION']; ?></td>
                  <td><?php echo $row['FECHA']; ?></td>
                  <td><?php echo $row['UFV']; ?></td>
                  <td>
                    <table width="100%" border="0">
                      <tr>
                        <td width="10%"><img src="../Img/Eliminar.png" width="23" height="25" /></td>
                        <td width="90%"><a href="frmHistorialUfv.php?MODI=1&IDS=<?php echo $row['Id']; ?>&FECHAV=<?php echo $row['FECHA']; ?>">Eliminar</a></td>
                      </tr>
                    </table>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
            <tfoot>
            </tfoot>
            <tfoot>
            </tfoot>
          </table>
        </td>
      </tr>
      <tr>
        <td>
          <hr />
        </td>
      </tr>
      <tr>
        <td class="ASTERISCO">VER. 0</td>
      </tr>
    </table><?php include '../CssTablas/frmPieTabla.php'; ?>
  </body>
</form>

</html><?php require '../Conexion_BD/Cerrar_Dbms.php'; ?>


<!-- onLoad="desactivarCrlAlt();" -->