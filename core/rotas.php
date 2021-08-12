<?php
	// ROTAS DO SISTEMA

	define('ROTAS', [
		'inicio' => 'main@inicio',
		'cadastro_cliente' => 'main@cadastro_cliente',
		'edita_cliente' => 'main@edita_cliente',
		'busca_clientes' => 'main@busca_clientes',
		'deletar_cliente' => 'main@deletar_cliente'
	]);

	$acao = 'inicio';

	if(isset($_GET['a'])):
		$acao = trim(filter_input(INPUT_GET, 'a', FILTER_SANITIZE_SPECIAL_CHARS));

		if(!array_key_exists($acao, ROTAS)) $acao = 'inicio';
	endif;

	// Tratando a rota passada

	$partes = explode('@', ROTAS[$acao]);

	$controlador = 'core\\controllers\\' . ucfirst($partes[0]);
	$metodo = $partes[1];

	$ctr = new $controlador();
	$ctr->$metodo();
?>