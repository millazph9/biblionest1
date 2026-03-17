# Installer les dépendances PHP (sauf celles pour dev)
composer install --no-dev --optimize-autoloader

# Nettoyer les caches Laravel
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Exécuter les migrations (création des tables)
php artisan migrate --force
