#!/bin/bash

# Establecer permisos en directorios clave
echo "🔧 Estableciendo permisos..."
## Asigna permisos 775 a todo el proyecto
chown -R www-data:www-data /var/www/html
chmod -R 775 /var/www/html
#chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

echo "🚀 Permisos aplicados."
exec "$@"

#!/bin/bash //CODIGO ANTERIOR

# Carpetas a las que queremos dar permisos
   # DIRS=(
    #"src/storage"
    #"src/bootstrap/cache"    
    # "src/public"
    # "src/database"
    #)

    #for DIR in "${DIRS[@]}"; do
    #if [ -d "$DIR" ]; then
        #echo "Aplicando permisos en $DIR"
        #chown -R www-data:www-data "$DIR"
        #chmod -R 775 "$DIR"
    #else
        #echo "No existe la carpeta $DIR, la salto"
    #fi
    #done

    #exec "$@"