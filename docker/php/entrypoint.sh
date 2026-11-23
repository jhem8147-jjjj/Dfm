#!/bin/bash
set -euo pipefail

cd /var/www/html

# Carpetas donde la aplicación escribe archivos en tiempo de ejecución.
# Se usa chmod y no chown porque Podman corre en modo rootless.
DIRECTORIOS=(
  "Otros_Ingresos/Registrar_Asociacion/ORDENANZA_MUNICIPAL"
  "Otros_Ingresos/Modificacion_Datos_Asociacion/ORDENANZA_MUNICIPAL/generated"
  "Otros_Ingresos/Administracion_Usuarios/Pdf"
  "Otros_Ingresos/Validacion_Datos_Importados/Pdf_Comunicacion_Interna/generated"
  "Otros_Ingresos/Cambio_Nombre/Pdf_Cambio_Nombre"
  "Otros_Ingresos/Complemento_Contribuyentes/Pdf_Complementos/generated"
)

for DIRECTORIO in "${DIRECTORIOS[@]}"; do
  mkdir -p "${DIRECTORIO}"
  chmod -R a+rwX "${DIRECTORIO}"
done

echo "==> Esperando la restauración de la base de datos..."

INTENTOS=0
MAX_INTENTOS=360

while ! php /var/www/html/docker/php/wait-for-db.php; do
  INTENTOS=$((INTENTOS + 1))

  if [ "${INTENTOS}" -ge "${MAX_INTENTOS}" ]; then
    echo "ERROR: timeout esperando la restauración de la base de datos." >&2
    exit 1
  fi

  sleep 5
done

echo "==> Base de datos lista. Iniciando Apache..."
exec "$@"
