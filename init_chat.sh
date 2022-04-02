#!/bin/sh
echo "init Chatting Servers"

cd chatting
composer update

cd server
nohup php websocket_server.php &
echo "Normal Chatting Servers Started"
nohup php websocket_server_dl.php &
echo "Daily Life Chatting Servers Started"
nohup php websocket_server_fin.php &
echo "Finance Chatting Servers Started"
nohup php websocket_server_it.php &
echo "IT Chatting Servers Started"
nohup php websocket_server_ls.php &
echo "Languages Chatting Servers Started"