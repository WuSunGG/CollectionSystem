cat >  /etc/my.cnf <<EOF
[mysqld]
datadir=/var/lib/mysql
socket=/var/lib/mysql/mysql.sock
# Disabling symbolic-links is recommended to prevent assorted security risks
symbolic-links=0
# Settings user and group are ignored when systemd is used.
# If you need to run mysqld under a different user or group,
# customize your systemd unit file for mariadb according to the
# instructions in http://fedoraproject.org/wiki/Systemd
character-set-server=utf8


[mysqld_safe]
log-error=/var/log/mariadb/mariadb.log
pid-file=/var/run/mariadb/mariadb.pid

#
# include all files from the config directory
#
!includedir /etc/my.cnf.d

[client]
default-character-set=utf8
EOF
/usr/libexec/mariadb-prepare-db-dir
systemctl start mariadb.service
systemctl start httpd.service
mysql -uroot < /var/www/html/db2.sql

sed  -i  -e "s/const host =.*/const host = '${API_IP_PORT}';/" /var/www/html/public/js/commonv2.js
sed  -i  -e "s/YOUR_HOST/${API_IP_PORT}/" /var/www/html/public/addclassv2.html
sed  -i  -e "s/YOUR_HOST/${API_IP_PORT}/" /var/www/html/public/importAdmin.html
