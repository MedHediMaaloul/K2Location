#!/bin/bash

cd /home/ubuntu
sudo npm install pm2 -g
cd /var/www/html
pm2 start server.js