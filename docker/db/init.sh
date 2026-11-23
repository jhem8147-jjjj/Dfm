#!/bin/bash
set -euo pipefail

: "${MYSQL_ROOT_PASSWORD:?MYSQL_ROOT_PASSWORD es obligatorio}"

export MYSQL_PWD="${MYSQL_ROOT_PASSWORD}"

MYSQL=(
  mysql
  -h db
  -u root
  --default-character-set=utf8
  --max-allowed-packet=1G
)

echo "==> Esperando a que MySQL esté disponible..."

INTENTOS=0
until "${MYSQL[@]}" -N -e "SELECT 1" >/dev/null 2>&1; do
  INTENTOS=$((INTENTOS + 1))

  if [ "${INTENTOS}" -ge 150 ]; then
    echo "ERROR: MySQL no respondió a tiempo." >&2
    exit 1
  fi

  sleep 2
done

echo "==> Verificando si la base ya fue inicializada..."

if "${MYSQL[@]}" -N -e "SELECT 1 FROM otros_ingresos.__dfm_init_done LIMIT 1" >/dev/null 2>&1; then
  echo "==> La base ya está inicializada. No se modifica nada."
  exit 0
fi

echo "==> Eliminando y creando bases limpias..."

"${MYSQL[@]}" <<'SQL'
DROP DATABASE IF EXISTS otros_ingresos;
DROP DATABASE IF EXISTS usuarios_drm;
CREATE DATABASE otros_ingresos DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
CREATE DATABASE usuarios_drm DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
SQL

echo "==> Importando usuarios_drm.sql..."
INICIO=$(date +%s)
"${MYSQL[@]}" usuarios_drm < /backup/usuarios_drm.sql
FIN=$(date +%s)
echo "==> usuarios_drm importada en $((FIN - INICIO))s"

echo "==> Importando otros_ingresos.sql (puede tardar 10-15 minutos)..."
INICIO=$(date +%s)
"${MYSQL[@]}" otros_ingresos < /backup/otros_ingresos.sql
FIN=$(date +%s)
echo "==> otros_ingresos importada en $((FIN - INICIO))s"

echo "==> Verificando datos importados..."

USUARIOS=$("${MYSQL[@]}" -N -e "SELECT COUNT(*) FROM usuarios_drm.usuarios")
ROLES=$("${MYSQL[@]}" -N -e "SELECT COUNT(*) FROM usuarios_drm.menu_oi")
CONTRIBUYENTES=$("${MYSQL[@]}" -N -e "SELECT COUNT(*) FROM otros_ingresos.contribuyentes")

echo "    usuarios:       ${USUARIOS}"
echo "    menu_oi:        ${ROLES}"
echo "    contribuyentes: ${CONTRIBUYENTES}"

if [ "${USUARIOS:-0}" -le 0 ] || [ "${ROLES:-0}" -le 0 ] || [ "${CONTRIBUYENTES:-0}" -le 0 ]; then
  echo "ERROR: la importación quedó incompleta." >&2
  exit 1
fi

echo "==> Creando marcador de inicialización..."
"${MYSQL[@]}" -e "CREATE TABLE otros_ingresos.__dfm_init_done (id TINYINT NOT NULL PRIMARY KEY) ENGINE=MyISAM; INSERT INTO otros_ingresos.__dfm_init_done VALUES (1);"

echo "==> Inicialización completa."
