<?php
require '../Control_Sesiones_Forms/frmControlSesionUsuario.php';
require '../Conexion_BD/Dbms_Usuario.php';

// Recuperar el usuario de la sesión
$US_SIOI = isset($_SESSION['US_SIOI']) ? $_SESSION['US_SIOI'] : '';
$usuario = mysql_real_escape_string($US_SIOI);

?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>.:: GAMEA - GREMIALES ::.</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link href="skins/page.css" rel="stylesheet" />
    <link href="skins/light/accordion-menu.css" rel="stylesheet" />
    <script src="accordion-menu.js"></script>

    <style type="text/css">
        body {
            margin-left: 0px;
            margin-top: 0px;
            margin-right: 0px;
            margin-bottom: 0px;
            background-color: #CCC;
        }
    </style>
</head>

<body>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center" bgcolor="#591F94">

            <img src="../Img/gamea.png"
     style="max-height:123px; max-width:100%; width:auto; height:auto;">

        </td>
    </tr>

    <tr>
        <td align="center" bgcolor="#591F94"
            style="color: #fff; font-weight: bold; font-size: 11px;">

            <?php
            echo htmlspecialchars(
                $SIAUNOMBRES . ' ' .
                $USPRIMERAPELLIDO . ' ' .
                $SIAUSEGUNDOAPELLIDO,
                ENT_QUOTES,
                'UTF-8'
            );
            ?>

        </td>
    </tr>

    <tr>
        <td align="center" bgcolor="#591F94"
            style="color: #fff; font-weight: bold; font-size: 11px;">
            &nbsp;
        </td>
    </tr>
</table>

<div id="accordion">
<ul>

<?php

// Obtener los grupos del menú según los permisos del usuario
$roles = mysql_query("
    SELECT DISTINCT
        CASE
            WHEN MS.ENLACE LIKE '%Desimportacion_Masiva_Impuesto_Anual%'
              OR (
                  MS.DESCRIPCION LIKE '%Inhabilitar%'
                  AND MS.DESCRIPCION LIKE '%Contribuyente%'
              )
                THEN 'Contribuyente'
            ELSE MS.GRUPO
        END AS GRUPO
    FROM asignacion_roles AS AR
    INNER JOIN menu_oi AS MS
        ON AR.CODIGO_ROL = MS.CODIGO_ROL
    WHERE AR.ESTADO = 'VIGENTE'
      AND AR.USUARIO = '$usuario'
      AND AR.APLICACION = 'SIOI'
      AND MS.ESTADO = 'ACTIVO'
    ORDER BY GRUPO
");

if (!$roles) {
    error_log("Error al consultar grupos del menú: " . mysql_error());
} else {

    while ($rows = mysql_fetch_array($roles)) {

        $grupo = mysql_real_escape_string($rows['GRUPO']);

        // Obtener los módulos activos de cada grupo
        $rol = mysql_query("
            SELECT DISTINCT
                MS.DESCRIPCION,
                MS.ENLACE,
                MS.POSICION
            FROM asignacion_roles AS AR
            INNER JOIN menu_oi AS MS
                ON AR.CODIGO_ROL = MS.CODIGO_ROL
            WHERE (
                CASE
                    WHEN MS.ENLACE LIKE '%Desimportacion_Masiva_Impuesto_Anual%'
                      OR (
                          MS.DESCRIPCION LIKE '%Inhabilitar%'
                          AND MS.DESCRIPCION LIKE '%Contribuyente%'
                      )
                        THEN 'Contribuyente'
                    ELSE MS.GRUPO
                END
            ) = '$grupo'
              AND AR.ESTADO = 'VIGENTE'
              AND AR.USUARIO = '$usuario'
              AND AR.APLICACION = 'SIOI'
              AND MS.ESTADO = 'ACTIVO'
            ORDER BY
                CASE
                    WHEN (
                        CASE
                            WHEN MS.ENLACE LIKE '%Desimportacion_Masiva_Impuesto_Anual%'
                              OR (
                                  MS.DESCRIPCION LIKE '%Inhabilitar%'
                                  AND MS.DESCRIPCION LIKE '%Contribuyente%'
                              )
                                THEN 'Contribuyente'
                            ELSE MS.GRUPO
                        END
                    ) = 'Contribuyente'
                     AND MS.DESCRIPCION LIKE '%Importar%'
                        THEN 1
                    WHEN (
                        CASE
                            WHEN MS.ENLACE LIKE '%Desimportacion_Masiva_Impuesto_Anual%'
                              OR (
                                  MS.DESCRIPCION LIKE '%Inhabilitar%'
                                  AND MS.DESCRIPCION LIKE '%Contribuyente%'
                              )
                                THEN 'Contribuyente'
                            ELSE MS.GRUPO
                        END
                    ) = 'Contribuyente'
                     AND MS.DESCRIPCION LIKE '%Validaci%'
                        THEN 2
                    WHEN MS.ENLACE LIKE '%Desimportacion_Masiva_Impuesto_Anual%'
                      OR (
                          MS.DESCRIPCION LIKE '%Inhabilitar%'
                          AND MS.DESCRIPCION LIKE '%Contribuyente%'
                      )
                        THEN 3
                    ELSE 4
                END,
                MS.DESCRIPCION
        ");

        if (!$rol) {
            error_log("Error al consultar módulos del menú: " . mysql_error());
            continue;
        }
?>

    <li>
        <div>
            <?php echo htmlspecialchars($rows['GRUPO'], ENT_QUOTES, 'UTF-8'); ?>
        </div>

        <ul>

        <?php while ($row = mysql_fetch_array($rol)) { ?>

            <li>
                <a href="<?php echo htmlspecialchars($row['ENLACE'], ENT_QUOTES, 'UTF-8'); ?>"
                   target="<?php echo htmlspecialchars($row['POSICION'], ENT_QUOTES, 'UTF-8'); ?>">

                    <?php echo htmlspecialchars($row['DESCRIPCION'], ENT_QUOTES, 'UTF-8'); ?>

                </a>
            </li>

        <?php } ?>

        </ul>
    </li>

<?php
    }
}
?>

</ul>
</div>

</body>
</html>

<?php
require '../Conexion_BD/Cerrar_Dbms.php';
?>