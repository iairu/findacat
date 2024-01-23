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


php artisan key:generate
php artisan migrate
php artisan serve

todo:
- remove @can