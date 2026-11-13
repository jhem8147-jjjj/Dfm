<?php
require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require '../Conexion_BD/Dbms.php';
function importarDepFeriasRequestValue($name)
{
  return isset($_POST[$name]) && is_scalar($_POST[$name])
    ? (string)$_POST[$name]
    : '';
}
$COD_ASOCIACION = importarDepFeriasRequestValue('COD_ASOCIACION');
$DOCUMENTOASOC = importarDepFeriasRequestValue('DOCUMENTOASOC');
$ASOCIACION = importarDepFeriasRequestValue('ASOCIACION');
$sltGestion = importarDepFeriasRequestValue('sltGestion');
$REG = importarDepFeriasRequestValue('REG');
if ($COD_ASOCIACION === '') {
  $COD_ASOCIACION = isset($_SESSION['COD_ASOCIACION']) ? $_SESSION['COD_ASOCIACION'] : '';
}
if ($DOCUMENTOASOC === '') {
  $DOCUMENTOASOC = isset($_SESSION['DOCUMENTOASOC']) ? $_SESSION['DOCUMENTOASOC'] : '';
}
if ($ASOCIACION === '') {
  $ASOCIACION = isset($_SESSION['ASOCIACION']) ? $_SESSION['ASOCIACION'] : '';
}
if ($sltGestion === '') {
  $sltGestion = isset($_SESSION['sltGestion']) ? $_SESSION['sltGestion'] : '';
}
if ($REG !== '1' || $COD_ASOCIACION === '' || $DOCUMENTOASOC === '' || $ASOCIACION === '' || $sltGestion === '') {
  echo "<script>alert('La información de asociación o gestión está incompleta. Inicie nuevamente la importación.')</script>";
  echo "<script>location.href='frmImpMasAsocFerias.php';</script>";
  exit;
}
$_SESSION['COD_ASOCIACION'] = $COD_ASOCIACION;
$_SESSION['DOCUMENTOASOC'] = $DOCUMENTOASOC;
$_SESSION['ASOCIACION'] = $ASOCIACION;
$_SESSION['sltGestion'] = $sltGestion;
if ($REG == 1) {
  if (!isset($_FILES['excel']) || !isset($_FILES['excel']['error']) || $_FILES['excel']['error'] !== UPLOAD_ERR_OK) {
    $erroresCarga = array(
      UPLOAD_ERR_INI_SIZE => 'El archivo supera el tamaño máximo permitido por el servidor.',
      UPLOAD_ERR_FORM_SIZE => 'El archivo supera el tamaño máximo permitido por el formulario.',
      UPLOAD_ERR_PARTIAL => 'El archivo se recibió de forma incompleta. Intente subirlo nuevamente.',
      UPLOAD_ERR_NO_FILE => 'No se recibió ningún archivo.',
      UPLOAD_ERR_NO_TMP_DIR => 'El servidor no tiene disponible el directorio temporal de carga.',
      UPLOAD_ERR_CANT_WRITE => 'El servidor no pudo guardar el archivo recibido.',
      UPLOAD_ERR_EXTENSION => 'Una extensión de PHP detuvo la carga del archivo.'
    );
    $codigoErrorCarga = isset($_FILES['excel']['error']) ? $_FILES['excel']['error'] : UPLOAD_ERR_NO_FILE;
    $mensajeImportacion = isset($erroresCarga[$codigoErrorCarga]) ? $erroresCarga[$codigoErrorCarga] : 'Ocurrió un error al recibir el archivo.';
  } else {
    $extension = strtolower(pathinfo($_FILES['excel']['name'], PATHINFO_EXTENSION));
    $extensionesPermitidas = array('xls', 'xlt', 'xlsx', 'xlsm', 'xltx', 'xltm', 'xml', 'ods', 'ots');
    if (!in_array($extension, $extensionesPermitidas, true)) {
      $mensajeImportacion = 'Seleccione un archivo Excel (.xls, .xlsx, .xlsm, .xlt, .xltx, .xltm o .xml) o OpenDocument (.ods, .ots).';
    } else {
      require_once('Classes/PHPExcel.php');
      $libxmlErrorSetting = libxml_use_internal_errors(true);
      try {
        if (!class_exists('ZipArchive')) {
          PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
        }
        $readerType = PHPExcel_IOFactory::identify($_FILES['excel']['tmp_name']);
        $lectoresPermitidos = array('Excel5', 'Excel2007', 'Excel2003XML', 'OOCalc');
        if (!in_array($readerType, $lectoresPermitidos, true)) {
          $mensajeImportacion = 'El archivo no contiene un libro Excel o OpenDocument compatible. Revise el formato y vuelva a intentarlo.';
        } else {
          $objReader = PHPExcel_IOFactory::createReader($readerType);
          if (!$objReader->canRead($_FILES['excel']['tmp_name'])) {
            $mensajeImportacion = 'El contenido del archivo no corresponde a un libro Excel u OpenDocument válido. Revise el formato y vuelva a intentarlo.';
          } else {
            $objPHPExcel = $objReader->load($_FILES['excel']['tmp_name']);
            if ($objPHPExcel->getSheetCount() < 1) {
              $mensajeImportacion = 'El archivo Excel no contiene hojas para importar.';
            } else {
              $objPHPExcel->setActiveSheetIndex(0);
              $ultimaFila = $objPHPExcel->getActiveSheet()->getHighestDataRow();
              $RUAT = trim(strtoupper((string) $objPHPExcel->getActiveSheet()->getCell('Z1')->getCalculatedValue()));
              if ($RUAT == 'GREMIAL') {
                $CONTROL = 1;
              } else {
                $mensajeImportacion = 'El archivo Excel no corresponde al formato de Ferias y Mercados: la celda Z1 debe contener GREMIAL.';
              }
            }
          }
        }
      } catch (Exception $e) {
        $mensajeImportacion = 'No se pudo leer el archivo. Compruebe que sea un libro Excel u OpenDocument compatible y que no esté dañado.';
      }
      libxml_clear_errors();
      libxml_use_internal_errors($libxmlErrorSetting);
    }
  }
  if ($CONTROL == 1) {
    $GESTIONACTUAL = date('Y');
    $REGS = 0;
    //verifica si LA GESTION EXISTE
    $resul = mysql_query("select * from nros_correlativos_registros WHERE GESTION='$GESTIONACTUAL' and ESTADO='ACTIVO'");
    if ($filas = mysql_fetch_array($resul)) {
      $REGS = 1;
    }
    //CONSULTA SI LOS CONTADORES ESTAN ACTUALIZADOS
    if ($REGS == 0) {
      $query = mysql_query("UPDATE nros_correlativos_registros SET ESTADO='NO ACTIVO' WHERE ESTADO='ACTIVO'") or die("NO SE PUDO ACTUALIZAR CONTADORES");

      $sql1 = "insert into nros_correlativos_registros(GESTION,IMPORTACION,COMPROBANTES)values('$GESTIONACTUAL','0','0')";
      $result = mysql_query($sql1) or die("NO SE PUDO REGISTRAR EN LA ENTIDAD nros_correlativos_registros.");
    }

    //EXTARE NROS. DE COMPROBANTES DE PAGO
    $resul = mysql_query("select IMPORTACION from nros_correlativos_registros WHERE GESTION='$GESTIONACTUAL' and ESTADO='ACTIVO'");
    while ($fila = mysql_fetch_array($resul)) {
      $CONTADORES = $fila[0] + 1;
    }
    $query = mysql_query("UPDATE nros_correlativos_registros SET IMPORTACION='$CONTADORES' WHERE GESTION='$GESTIONACTUAL' and ESTADO='ACTIVO'") or die("NO SE PUDO ACTUALIZAR CONTADORES");

    $COD_REGISTRO = date('Ymd His') . rand(1, 10) . $CONTADORES;
    $_SESSION['COD_REGISTRO'] = $COD_REGISTRO;
    if ($CONTROL == 1) {
      $i = 2; //celda inicial en la cual empezara a realizar el barrido de la grilla de excel
      $param = 0;
      $contador = 0;
      $duplicados = 0;
      while ($param == 0 && $i <= $ultimaFila) //Detiene el recorrido al terminar las filas con datos de la hoja.
      {
        if ($objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue() == NULL) //pregunto que si ha encontrado un valor null en una columna inicie un parametro en 1 que indicaria el fin del ciclo while
        {
          $param = 1; //para detener el ciclo cuando haya encontrado un valor NULL
        }
        if ($param == 0) {

          $SW = 0;
          $tipo_puesto = $objPHPExcel->getActiveSheet()->getCell('B' . $i)->getCalculatedValue();
          $tipo_puesto = strtoupper($tipo_puesto);
          $tipo_puesto = normaliza($tipo_puesto);
          $tipo_puesto = trim($tipo_puesto);
          $fila = $objPHPExcel->getActiveSheet()->getCell('C' . $i)->getCalculatedValue();
          $fila = strtoupper($fila);
          $fila = normaliza($fila);
          $fila = trim($fila);
          $puesto = $objPHPExcel->getActiveSheet()->getCell('D' . $i)->getCalculatedValue();
          $puesto = strtoupper($puesto);
          $puesto = normaliza($puesto);
          $puesto = trim($puesto);
          $ci = $objPHPExcel->getActiveSheet()->getCell('E' . $i)->getCalculatedValue();
          $ci = intval(preg_replace('/[^0-9]+/', '', $ci), 10);
          $ci1 = $objPHPExcel->getActiveSheet()->getCell('G' . $i)->getCalculatedValue();
          $ci1 = normaliza($ci1);
          $ci1 = strtoupper($ci1);
          $ci1 = limpia_espacios($ci1);
          $EXPEDIDO = $objPHPExcel->getActiveSheet()->getCell('H' . $i)->getCalculatedValue();
          $EXPEDIDO = strtoupper($EXPEDIDO);
          $EXPEDIDO = normaliza($EXPEDIDO);
          $EXPEDIDO = trim($EXPEDIDO);
          $nombre = $objPHPExcel->getActiveSheet()->getCell('I' . $i)->getCalculatedValue();
          $nombre = normaliza($nombre);
          $nombre = strtoupper($nombre);
          $nombre = trim($nombre);
          //$p_apellido=$objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
          //$p_apellido=strtoupper($p_apellido);
          //$s_apellido=$objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
          //$s_apellido=strtoupper($s_apellido);
          //$e_apellido=$objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
          //$e_apellido=strtoupper($e_apellido);

          //Asigna un correlativo que no exista, incluso si el contador quedó atrasado.
          $res = mysql_query("select NRO_PUESTO from nros_correlativos") or die("NO SE PUDO LEER EL CORRELATIVO DE PUESTOS: " . mysql_error($conexion_usuarios));
          $ro = mysql_fetch_array($res);
          if (!$ro) {
            die("NO EXISTE EL CORRELATIVO DE PUESTOS EN nros_correlativos.");
          }
          $CODIGO_PUESTO = (int) $ro['NRO_PUESTO'] + 1;
          do {
            $CODIGO_PUESTO_SQL = mysql_real_escape_string((string) $CODIGO_PUESTO, $conexion_usuarios);
            $resRegistroExistente = mysql_query("select 1 from reg_contribuyente_habilitado_pago where REGISTRO_GREMIAL='$CODIGO_PUESTO_SQL' limit 1") or die("NO SE PUDO VERIFICAR EL CORRELATIVO GREMIAL: " . mysql_error($conexion_usuarios));
            if (mysql_num_rows($resRegistroExistente) > 0) {
              $CODIGO_PUESTO++;
            } else {
              break;
            }
          } while (true);
          $query = mysql_query("UPDATE nros_correlativos SET NRO_PUESTO='$CODIGO_PUESTO'") or die("NO SE PUDO ACTUALIZAR LOS DATOS DEL correlativo de puestos: " . mysql_error($conexion_usuarios));
          $ci = intval(preg_replace('/[^0-9]+/', '', $ci), 10);
          $CODIGO_CONT = $ci . $ci1 . 'A' . rand(10, 1000);
          $SW = 0;
          $l = 0;
          //PREGUNTA SI ESTA REGISTRADO EL CONTRIBUYENTE
          $resulto = mysql_query("select * from contribuyentes  WHERE DOC_IDENTIDAD='$ci' and DOC_IDENTIDAD_ALFA='$ci1' and ESTADO='ACTIVO'");
          while ($row = mysql_fetch_array($resulto)) {
            $SW = 1;
            $CODIGO_CONT = $row['CODIGO_CONTRIBUYENTE'];
          }

          if ($SW == 0) {
            $sql = "insert into contribuyentes(CODIGO_REGISTRO,CODIGO_CONTRIBUYENTE,DOC_IDENTIDAD,DOC_IDENTIDAD_ALFA,EXPEDIDO,TIPO_DOCUMENTO,NOMBRE_RSOCIAL)
                    values('$COD_REGISTRO','$CODIGO_CONT','$ci','$ci1','$EXPEDIDO','CEDULA DE IDENTIDAD','$nombre')";
            $result = mysql_query($sql) or die("NO SE PUDO REGISTRAR EN LA ENTIDAD contribuyentes.");
            /* registra contribuyente*/
            $sql1 = "insert into reg_contribuyente(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_CONTRIBUYENTE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$COD_REGISTRO','$CODIGO_CONT')";
            $result = mysql_query($sql1) or die("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente.");

            $contador = $contador + 1;
          } else {
            $duplicados = $duplicados + 1;
          }
          $l = $l + 1;
          //registra HABILITA PAGO
          $MONTO_BS = 0;
          $re = mysql_query("select ZT.MONTO,ZT.CODIGO_ZONA from reg_asociacion_zona_tributaria RAZT,zona_tributaria ZT  WHERE RAZT.CODIGO_ASOCIACION='$COD_ASOCIACION' and RAZT.CODIGO_ZONA=ZT.CODIGO_ZONA and ZT.ESTADO='ACTIVO' and RAZT.ESTADO='ACTIVO'");
          while ($ro = mysql_fetch_array($re)) {
            $MONTO_BS = $ro[0];
            $COD_ZONA = $ro[1];
          }
          //REVISA PALABRAS KIOSCO
          if ($tipo_puesto == 'KIOSKO' or $tipo_puesto == 'KIOSCO') {
            $tipo_puesto = 'KIOSCO';
            $MONTO_BS = '60';
          }
          if ($tipo_puesto == 'KIOSKO' or $tipo_puesto == 'KIOSCO') {
            $tipo_puesto = 'KIOSCO';
            $MONTO_BS = '60';
          }

          if (strlen(stristr($tipo_puesto, 'IOS')) > 0) {
            $tipo_puesto = 'KIOSCO';
            $MONTO_BS = '60';
          }
          //PALABRAS PUESTO
          if (strlen(stristr($tipo_puesto, 'PUEST')) > 0) {
            $tipo_puesto = 'PUESTO DE VENTA';
          }
          //PALABRAS CARRITO
          if (strlen(stristr($tipo_puesto, 'RITO')) > 0) {
            $tipo_puesto = 'CARRITO';
          }
          //CONSULTA EL TIPO DE PUESTO DE VENTA
          if ($tipo_puesto == 'CARRITO' or $tipo_puesto == 'PUESTO DE VENTA' or $tipo_puesto == 'KIOSCO') {
          } else {
            $tipo_puesto = 'PUESTO DE VENTA';
          }

          //$res=mysql_query("select * from fechas_vencimiento  WHERE ESTADO='ACTIVO'");while($rows=mysql_fetch_array($res)){ 
          $l++;
          $COD_PAGO = date('Ymd His') . '-' . $i;
          if (strlen($ci) < 4) {
            $sql1 = "insert into reg_contribuyente_habilitado_pago(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,REGISTRO_GREMIAL,CODIGO_CONTRIBUYENTE,CODIGO_ASOCIACION,CODIGO_ZONA,TIPO_VENTA,GESTION,FILA,PUESTO,MONTO,ESTADO,ESTADO_REGISTRO,ESTADO_PAGO,ESTADO_ORDEN_PAGO,COMUNICACION_INTERNA,ENLACE,OBSERVACIONES)
            values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$COD_REGISTRO','$CODIGO_PUESTO','$CODIGO_CONT','$COD_ASOCIACION','$COD_ZONA','$tipo_puesto','$sltGestion','$fila','$puesto','$MONTO_BS','REGISTRO NO VALIDO NO CUMPLE CON LOS REGISTROS DE CAMPOS REQUERIDOS','REGISTRO NO VALIDO NO CUMPLE CON LOS REGISTROS DE CAMPOS REQUERIDOS','REGISTRO NO VALIDO NO CUMPLE CON LOS REGISTROS DE CAMPOS REQUERIDOS','REGISTRO NO VALIDO NO CUMPLE CON LOS REGISTROS DE CAMPOS REQUERIDOS','REGISTRO NO VALIDO NO CUMPLE CON LOS REGISTROS DE CAMPOS REQUERIDOS','REGISTRO NO VALIDO NO CUMPLE CON LOS REGISTROS DE CAMPOS REQUERIDOS','REGISTRO NO VALIDO NO CUMPLE CON LOS REGISTROS DE CAMPOS REQUERIDOS')";
            $result = mysql_query($sql1) or die("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_habilitado_pago. Fila Excel: " . $i . ". Error MySQL: " . mysql_error($conexion_usuarios));
          } else {
            $sql1 = "insert into reg_contribuyente_habilitado_pago(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,REGISTRO_GREMIAL,CODIGO_CONTRIBUYENTE,CODIGO_ASOCIACION,CODIGO_ZONA,TIPO_VENTA,GESTION,FILA,PUESTO,MONTO,COMUNICACION_INTERNA)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$COD_REGISTRO','$CODIGO_PUESTO','$CODIGO_CONT','$COD_ASOCIACION','$COD_ZONA','$tipo_puesto','$sltGestion','$fila','$puesto','$MONTO_BS','NO GENERADO')";
            $result = mysql_query($sql1) or die("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_habilitado_pago. Fila Excel: " . $i . ". Error MySQL: " . mysql_error($conexion_usuarios));
          }
          //}

          /* registra contribuyente ASOCIACION*/
          $sql1 = "insert into reg_contribuyente_asociacion(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,REGISTRO_GREMIAL,CODIGO_CONTRIBUYENTE,CODIGO_ASOCIACION,CODIGO_ZONA,TIPO_VENTA,PUESTO,FILA,OBSERVACIONES)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$COD_REGISTRO','$CODIGO_PUESTO','$CODIGO_CONT','$COD_ASOCIACION','$COD_ZONA','$tipo_puesto','$puesto','$fila','IMPORTADO DATOS PARA GENERAR IMPUESTO EVENTUAL GESTION $sltGestion')";
          $result = mysql_query($sql1) or die("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_asociacion.");

          $i++;
        }
      }
      $totalIngresados = $contador; //(porque se se para con un NULL y le esta registrando como que tambien un dato)
      $query = mysql_query("UPDATE reg_contribuyente_habilitado_pago  SET TIPO_VENTA='KIOSCO',MONTO='60'  where CODIGO_REGISTRO='$COD_REGISTRO' and TIPO_VENTA like '%KIOSKO%' and ESTADO='ACTIVO' and ESTADO_PAGO='NO PAGO'") or die("NO SE PUDO ACTUALIZAR LOS DATOS DEL reg_contribuyente_habilitado_pago.");
      $query = mysql_query("UPDATE reg_contribuyente_habilitado_pago  SET TIPO_VENTA='KIOSCO',MONTO='60'  where CODIGO_REGISTRO='$COD_REGISTRO' and TIPO_VENTA like '%KIOS%' and ESTADO='ACTIVO' and ESTADO_PAGO='NO PAGO'") or die("NO SE PUDO ACTUALIZAR LOS DATOS DEL reg_contribuyente_habilitado_pago.");
    }
  }
} else {
  $mensajeImportacion = 'La solicitud de importación está incompleta. Seleccione nuevamente el archivo.';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
</head>

<body>
  <table width="20%" border="0">
    <tr>
      <td align="center" class="TITULO">IMPORTACION MASIVA </td>
    </tr>
    <tr>
      <td align="center" class="SUBTITULO">Registro de Contribuyentes</td>
    </tr>
    <tr>
      <td><img src="../Img/Blanco.png" width="800" height="6" /></td>
    </tr>
    <tr>
      <td>
        <table width="100%" border="0" cellspacing="3" cellpadding="2">
          <tr>
            <td height="32" align="center" bgcolor="#CCCCCC" style="font-weight: bold">PASO</td>
            <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">DESCRIPCION</td>
            <td align="center" style="font-weight: bold">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#E3F0F2">1</td>
            <td bgcolor="#E3F0F2">Nueva Importación de Datos, permite importar nuevos datos.</td>
            <td>
              <form method="post" action='frmImpMasAsocFerias.php'>
                <input type="submit" name="button3" value="Nueva Importación de Datos" style="width:250px; height:35px" id="more" />
              </form>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="ASTERISCO">VER. 3</td>
    </tr>
  </table>
</body>

</html><?php if ($CONTROL == 1) {
          $totales = $totalIngresados + $duplicados;
          //REGISTRA EN LA TABLA TRANSACCIONES.
          $query = mysql_query("UPDATE reg_contribuyente_habilitado_pago  SET ESTADO='NO ACTIVO',ESTADO_REGISTRO='REGISTRO NO VALIDO NO CUMPLE CON LOS REGISTROS DE CAMPOS REQUERIDOS.',ESTADO_ORDEN_PAGO='REGISTRO NO VALIDO NO CUMPLE CON LOS REGISTROS DE CAMPOS REQUERIDOS',COMUNICACION_INTERNA='REGISTRO NO VALIDO NO CUMPLE CON LOS REGISTROS DE CAMPOS REQUERIDOS',ENLACE='REGISTRO NO VALIDO NO CUMPLE CON LOS REGISTROS DE CAMPOS REQUERIDOS',OBSERVACIONES='REGISTRO NO VALIDO NO CUMPLE CON LOS REGISTROS DE CAMPOS REQUERIDOS'  where CODIGO_REGISTRO='$COD_REGISTRO' and CODIGO_CONTRIBUYENTE='' and TIPO_VENTA='' and MONTO='' and ESTADO='ACTIVO' and ESTADO_PAGO='NO PAGO'") or die("NO SE PUDO ACTUALIZAR LOS DATOS DEL reg_contribuyente_habilitado_pago.");

          $sql1 = "insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$COD_REGISTRO','$COD_ASOCIACION','$ASOCIACION','IMPORTACION DE DATOS MASIVOS FERIAS Y MERCADOS','IMPORTACION DE DATOS DE AFILIADOS ($totales) LISTADO FERIAS Y MERCADOS.','IMPORTACION DE DATOS MASIVOS ARCHIVO EXCEL.')";
          $result = mysql_query($sql1) or die("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones.");

          echo "<script>alert(' ( $totales ) Contribuyente(s) Importados Con Exito.')</script>";
        } else {
          echo "<script>alert(" . json_encode($mensajeImportacion) . ");</script>";
          echo "<script> location.href='frmImpMasExcelFerias.php';</script>";
        }
        function normaliza($cadena)
        {
          $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞ
ßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
          $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuy
bsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
          $cadena = utf8_decode($cadena);
          $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
          $cadena = strtoupper($cadena);
          return utf8_encode($cadena);
        }
        require '../Conexion_BD/Cerrar_Dbms.php';
        function limpia_espacios($cadena)
        {
          $cadena = str_replace(' ', '', $cadena);
          return $cadena;
        } ?>