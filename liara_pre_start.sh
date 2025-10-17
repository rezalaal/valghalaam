echo "Running pre-start script for Laravel..."

# run migrations
php artisan migrate --force

# other needed commands
# ...

echo "Pre-start script for Laravel finished."