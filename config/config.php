<?php

use Lib\Config;

/* Seta as nossas configurações: */

// Noma do site
Config::set('site_name', 'Mercado Info');
Config::set('base_uri', '/Mercado/');

// Linguagens suportadas
Config::set('languages', ['pt_br', 'en']);

// Rotas para diferenciar usuários normais e administradores
// Na URL apareceria ...admin_view, por exemplo, quando o adm tiver mexendo
Config::set('routes', ['default' => '', 'admin' => 'admin_']);

// Rota padrão
Config::set('default_route', 'default');

// Idioma padrão
Config::set('default_language', 'pt_br');

// Controller padrão
Config::set('default_controller', 'produto');

// Ação padrão
Config::set('default_action', 'index');

// Definições de banco de dados
Config::set('db.host', 'localhost');
Config::set('db.user', 'root');
Config::set('db.password', '');
Config::set('db.name', 'infomercado');