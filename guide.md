# DB initialization
config/app.php -> DEBUG true
cp .env.example .env
apt update
apt install mariadb-server
mysql_secure_installation
mariadb
CREATE DATABASE homestead;
GRANT ALL ON *.* TO 'homestead'@'localhost' IDENTIFIED BY 'secret' WITH GRANT OPTION;
FLUSH PRIVILEGES;
exit

# Laravel setup procedure
php artisan key:generate
php artisan migrate
php artisan serve

# Laravel reset procedure
php artisan migrate:reset
php artisan migrate
php artisan serve
