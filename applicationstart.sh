#!/bin/bash

cd /home/ubuntu
sudo npm install -g pm2
pm2 -f start server.js 