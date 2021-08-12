<?php
	namespace core\classes;

	class Store{
		function layout(array $estruturas, array $dados = null){
			// Verifica se estruturas é um array

			if(!is_array($estruturas)) throw new Exception('Coleção de estruturas inválida!!!');

			// Variáveis

			if(!empty($dados) && is_array($dados)) extract($dados);

			// Apresentar as views da aplicação

			foreach($estruturas as $estrutura) include_once('../core/views/' . $estrutura . '.php');
		}

		function redirect(string $acao){
			header('location: ' . URL . '?' . http_build_query(['a' => $acao]));
		}
	}
?>