#!/usr/bin/env bash

BASE_PATH=
USER_SHELL=/bin/bash

while [ -n "$1" ] ; do
    case $1 in
    -u | --user )
        shift
        USER_NAME=$1
        ;;
    -dbp | --dbpass )
        shift
        DBPASS=$1
        ;;
    -b |  --base )
        shift
        BASE_PATH=$1
        ;;
    * )
        echo "ERROR: Unknown option: $1"
        exit -1
        ;;
    esac
    shift
done

if [ $BASE_PATH != "" ]; then
    mkdir /home/$USER_NAME/web/$BASE_PATH
    FULL_PATH=/home/$USER_NAME/web/$BASE_PATH
else
    FULL_PATH=/home/$USER_NAME/web
fi

sudo wget -P /home/$USER_NAME https://wordpress.org/latest.zip
sudo unzip /home/$USER_NAME/latest.zip -d $FULL_PATH;
sudo mv $FULL_PATH/wordpress/* $FULL_PATH;
sudo cp $FULL_PATH/wp-config-sample.php $FULL_PATH/wp-config.php

sudo sed -i 's/database_name_here/'$USER_NAME'/g' $FULL_PATH/wp-config.php
sudo sed -i 's/username_here/'$USER_NAME'/g' $FULL_PATH/wp-config.php
sudo sed -i 's/password_here/'$DBPASS'/g' $FULL_PATH/wp-config.php
sudo curl -k https://api.wordpress.org/secret-key/1.1/salt/ >> $FULL_PATH/wp-config.php

sudo chown -R www-data: /home/$USER_NAME/web
sudo chown -R $USER_NAME:$USER_NAME /home/$USER_NAME/web