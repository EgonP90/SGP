<?php

	// CONFIGURAÇÃO DO BANCO DE DADOS
	const DB = [
		'HOST' => 'localhost',
		'USUARIO' => 'root',
		'SENHA' => 'tedesco7364',
		'BANCO' => 'db_sgp',
		'PORTA' => '3306'
	];

	// CONSTANTES DO SISTEMA
	define('APP', dirname(__FILE__));
	define('URL','http://localhost/sgp');
	define('APP_NOME','Sistema de Gestão de Pedidos');
	define('APP_VERSAO','2.0.0');
	define('USE_PEDIDO_EXPRESS', false);
	define('ALTERA_SENHA_PRIMEIRO_LOGIN', false);
	
?>
