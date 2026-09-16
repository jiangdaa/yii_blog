#!/usr/bin/env bash
set -e

until mysqladmin ping -h db -u root --protocol=tcp --silent; do
    sleep 2
done

php yii migrate --interactive=0 || true
php yii migrate --migrationPath=@yii/rbac/migrations --interactive=0 || true

exec apache2-foreground
