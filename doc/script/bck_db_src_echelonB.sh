#!/bin/bash

fecha_bak_bd=bd_sisecB_`date +"%Y%m%d%H%M%S"`.sql
cd /var/www/html/echelon-B/doc/BD/
rm *.sql

mysqldump -u root -p db_echelon --routines > /var/www/html/echelon-B/doc/BD/${fecha_bak_bd}

cd /var/www/html/

sudo zip -r /var/www/html/backup/src_echelon-B_`date +"%Y%m%d%H%M%S"`.zip echelon-B/

