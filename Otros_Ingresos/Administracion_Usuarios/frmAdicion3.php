<?php
require '../Control_Sesiones_Forms/frmControlSesionUsuario.php';
require_once('../Control_Sesiones_Forms/Loading.php');
require '../Conexion_BD/Dbms_Usuario.php';

$FECHA = date('d/m/Y H:i:s');

// REGISTRO DEL USUARIO
if (isset($hdfReg) && $hdfReg == 1) {

    $CONTRA = md5($txtNoDocumento);

    $sql = "INSERT INTO usuarios
    (FECHA_REGISTRO, CEDULA_IDENTIDAD, EXPEDIDO, NOMBRES,
    PRIMER_APELLIDO, SEGUNDO_APELLIDO, USUARIO, PASSWORD,
    CODIGO_UNIDAD, CODIGO_AREA, CARGO)
    VALUES
    ('$FECHA', '$txtNoDocumento', '$sltExpedido', '$txtNombres',
    '$txtPrimerApellido', '$txtSegundoApellido', '$USUARIO',
    '$CONTRA', '$txtUnidad', '$txtArea', '$txtCargo')";

    $result = mysql_query($sql)
        or die("NO SE PUDO REGISTRAR EN LA TABLA USUARIOS.");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="StyleSheet" href="cssFormato.css" type="text/css" />
</head>

<form method="post" action="Pdf/frmRegUsuarios.php">
<body>

<table width="70%" border="0">

    <tr>
        <td align="center" class="TITULO">REGISTRO DE USUARIO</td>
    </tr>

    <tr>
        <td align="center" class="SUBTITULO">
            AGREGAR, BAJA DE ROL(ES)
        </td>
    </tr>

    <?php
    // DATOS DEL OPERADOR
    $roles = mysql_query(
        "SELECT * FROM usuarios
         WHERE USUARIO='$USUARIO'
         AND ESTADO='DESBLOQUEADO'"
    );

    if ($roles):
        while ($rows = mysql_fetch_array($roles)):
    ?>

    <tr>
        <td>
            <table width="100%" border="0">

                <tr>
                    <td align="left">
                        <span class="TITULO">DATOS DE OPERADOR.</span>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr>
                    <td align="left">
                        <img src="../Img/Linea.png" width="300" height="4" />
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr>
                    <td width="31%" align="right">
                        <table width="100%" height="26" border="1"
                        cellpadding="0" cellspacing="0"
                        bordercolor="#6699FF">
                            <tr bordercolor="#FF9900"
                            bordercolorlight="#FF9900">
                                <td align="right" bordercolor="#6699FF">
                                    No. de Cédula de Identidad :
                                </td>
                            </tr>
                        </table>
                    </td>

                    <td width="69%">
                        <?php echo $rows['CEDULA_IDENTIDAD'].' '.$rows['EXPEDIDO']; ?>
                    </td>
                </tr>

                <tr>
                    <td align="right">
                        <table width="100%" height="26" border="1"
                        cellpadding="0" cellspacing="0"
                        bordercolor="#6699FF">
                            <tr bordercolor="#FF9900"
                            bordercolorlight="#FF9900">
                                <td align="right" bordercolor="#6699FF">
                                    Nombre(s) :
                                </td>
                            </tr>
                        </table>
                    </td>

                    <td>
                        <?php echo $rows['NOMBRES']; ?>
                    </td>
                </tr>

                <tr>
                    <td align="right">
                        <table width="100%" height="26" border="1"
                        cellpadding="0" cellspacing="0"
                        bordercolor="#6699FF">
                            <tr bordercolor="#FF9900"
                            bordercolorlight="#FF9900">
                                <td align="right" bordercolor="#6699FF">
                                    Primer Apellido :
                                </td>
                            </tr>
                        </table>
                    </td>

                    <td>
                        <?php echo $rows['PRIMER_APELLIDO']; ?>
                    </td>
                </tr>

                <tr>
                    <td align="right">
                        <table width="100%" height="26" border="1"
                        cellpadding="0" cellspacing="0"
                        bordercolor="#6699FF">
                            <tr bordercolor="#FF9900"
                            bordercolorlight="#FF9900">
                                <td align="right" bordercolor="#6699FF">
                                    Segundo Apellido :
                                </td>
                            </tr>
                        </table>
                    </td>

                    <td>
                        <?php echo $rows['SEGUNDO_APELLIDO']; ?>
                    </td>
                </tr>

                <tr>
                    <td align="right">
                        <table width="100%" height="26" border="1"
                        cellpadding="0" cellspacing="0"
                        bordercolor="#6699FF">
                            <tr bordercolor="#FF9900"
                            bordercolorlight="#FF9900">
                                <td align="right" bordercolor="#6699FF">
                                    Usuario Asignado :
                                </td>
                            </tr>
                        </table>
                    </td>

                    <td>
                        <?php echo $USUARIO; ?>

                        <input name="USUARIO" type="hidden"
                        id="USUARIO"
                        value="<?php echo $USUARIO; ?>" />
                    </td>
                </tr>

            </table>
        </td>
    </tr>

    <?php
        endwhile;
    endif;
    ?>

    <tr>
        <td colspan="2" align="right">
            <table width="100%" border="0"
            cellpadding="0" cellspacing="0">
                <tr>
                    <td class="TITULO">Asignar Rol(es).</td>
                </tr>
                <tr>
                    <td><hr /></td>
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td colspan="2" align="right">
            <table width="100%" border="0"
            cellpadding="3" cellspacing="3">

                <tr class="TITULO">
                    <td height="40" align="center" bgcolor="#C7DEDD">
                        PERFIL
                    </td>
                    <td align="center" bgcolor="#C7DEDD">
                        DESCRIPCION
                    </td>
                    <td align="center" bgcolor="#C7DEDD">&nbsp;</td>
                </tr>

                <?php

                // ELIMINAR ROL
                if (isset($ELIMINAR)) {

                    $query = mysql_query(
                        "UPDATE asignacion_roles
                         SET ESTADO='NO ACTIVO. DESDE $FECHA
                         ELIMINADO POR EL USUARIO $US_SIOI'
                         WHERE USUARIO='$USUARIO'
                         AND CODIGO_ROL='$ELIMINAR'
                         AND ESTADO='VIGENTE'"
                    );
                }

                // AGREGAR ROL
                if (isset($AGREGAR)) {

                    $sql = "INSERT INTO asignacion_roles
                    (PC_NAME, PC_IP, FECHA_REGISTRO, USUARIO_ADMIN,
                    ASIGNADO_POR, USUARIO, CODIGO_ROL, SIGLA)
                    VALUES
                    ('$hostname', '$hostlocal', '$FECHA', '$US_SIOI',
                    '$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO',
                    '$USUARIO', '$AGREGAR', '$SIGLA')";

                    $result = mysql_query($sql)
                        or die("NO SE PUDO REGISTRAR EN LA TABLA ASIGNACION DE ROLES");
                }

                // LISTAR ROLES DISPONIBLES
                $roles = mysql_query(
                    "SELECT * FROM menu_oi
                     WHERE ESTADO='ACTIVO'
                     ORDER BY SIGLA, DESCRIPCION"
                );

                if ($roles):
                    while ($rows = mysql_fetch_array($roles)):

                        $SW = 0;

                        $rol = mysql_query(
                            "SELECT * FROM asignacion_roles
                             WHERE USUARIO='$USUARIO'
                             AND CODIGO_ROL='".$rows['CODIGO_ROL']."'
                             AND ESTADO='VIGENTE'"
                        );

                        while ($row = mysql_fetch_array($rol)) {
                            $SW = 1;
                        }

                        if ($SW == 0):
                ?>

                <tr>
                    <td bgcolor="#F0F4F4">
                        <?php echo $rows['GRUPO']; ?>
                    </td>

                    <td bgcolor="#F0F4F4">
                        <?php echo $rows['DESCRIPCION']; ?>
                    </td>

                    <td bgcolor="#F0F4F4">
                        <a href="frmAdicion3.php?AGREGAR=<?php echo $rows['CODIGO_ROL']; ?>&SIGLA=<?php echo $rows['SIGLA']; ?>&USUARIO=<?php echo $USUARIO; ?>"
                        title="ASIGNAR ROL">
                            Asignar
                        </a>
                    </td>
                </tr>

                <?php
                        endif;
                    endwhile;
                endif;
                ?>

            </table>
        </td>
    </tr>

    <tr>
        <td>
            <table width="100%" border="0"
            cellpadding="0" cellspacing="0">

                <tr>
                    <td class="TITULO">Rol(es) Asignado(s).</td>
                </tr>

                <tr>
                    <td><hr /></td>
                </tr>

            </table>
        </td>
    </tr>

    <tr>
        <td>
            <table width="100%" border="0"
            cellpadding="3" cellspacing="3">

                <tr class="TITULO">
                    <td height="40" align="center" bgcolor="#C7DEDD">
                        PERFIL
                    </td>
                    <td align="center" bgcolor="#C7DEDD">
                        DESCRIPCION
                    </td>
                    <td align="center" bgcolor="#C7DEDD">&nbsp;</td>
                </tr>

                <?php

                // LISTAR ROLES ASIGNADOS
                $roles = mysql_query(
                    "SELECT MS.SIGLA, MS.DESCRIPCION,
                    MS.CODIGO_ROL, MS.GRUPO
                    FROM asignacion_roles AR, menu_oi MS
                    WHERE AR.USUARIO='$USUARIO'
                    AND AR.APLICACION='SIOI'
                    AND AR.CODIGO_ROL=MS.CODIGO_ROL
                    AND AR.ESTADO='VIGENTE'
                    AND MS.ESTADO='ACTIVO'
                    ORDER BY MS.SIGLA, MS.DESCRIPCION"
                );

                if ($roles):
                    while ($rows = mysql_fetch_array($roles)):
                ?>

                <tr>
                    <td bgcolor="#F0F4F4">
                        <?php echo $rows['GRUPO']; ?>
                    </td>

                    <td bgcolor="#F0F4F4">
                        <?php echo $rows['DESCRIPCION']; ?>
                    </td>

                    <td bgcolor="#F0F4F4">
                        <a href="frmAdicion3.php?ELIMINAR=<?php echo $rows['CODIGO_ROL']; ?>&USUARIO=<?php echo $USUARIO; ?>"
                        title="QUITAR ROL ASIGNADO">
                            Eliminar
                        </a>
                    </td>
                </tr>

                <?php
                    endwhile;
                endif;
                ?>

            </table>
        </td>
    </tr>

    <tr>
        <td align="center">
            <input type="submit" name="button"
            id="button" value="Terminar" />
        </td>
    </tr>

    <tr>
        <td class="TITULO">
            <span class="ASTERISCO">Ver 1.</span>
        </td>
    </tr>

    <tr>
        <td>&nbsp;</td>
    </tr>

</table>

<blockquote>&nbsp;</blockquote>

</body>
</form>
</html>

<?php
require '../Conexion_BD/Cerrar_Dbms.php';
?>