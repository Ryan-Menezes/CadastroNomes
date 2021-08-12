<?php
	namespace core\models;

	use core\classes\Database;

	class Cliente{
		public function cpf_existe($cpf) : bool{
			$db = new Database();

			$dados = [':cpf' => $cpf];

			return (count($db->EXECUTE_QUERY('SELECT * FROM clientes WHERE cpf = :cpf LIMIT 1', $dados)) > 0) ? true : false;
		}

		// -----------------------------------------------------------------------------------------------------------------------------

		public function cadastra_cliente($cpf, $nome, $telefone, $email) : ?bool{
			$db = new Database();

			$dados = [
				':cpf' => $cpf, 
				':nome' => $nome, 
				':telefone' => $telefone, 
				':email' => $email
			];

			return $db->EXECUTE_NON_QUERY('CALL cadastra_cliente(:cpf, :nome, :telefone, :email)', $dados);
		}

		public function edita_cliente($cpf_atual, $cpf, $nome, $telefone, $email) : ?bool{
			$db = new Database();

			$dados = [
				':cpf' => $cpf, 
				':nome' => $nome, 
				':telefone' => $telefone, 
				':email' => $email,
				':cpf_atual' => $cpf_atual
			];

			return $db->EXECUTE_NON_QUERY('CALL edita_cliente(:cpf, :nome, :telefone, :email, :cpf_atual)', $dados);
		}

		// -----------------------------------------------------------------------------------------------------------------------------

		public function deleta_cliente($cpf){
			$db = new Database();

			$dados = [
				':cpf' => $cpf
			];

			return $db->EXECUTE_NON_QUERY('CALL deleta_cliente(:cpf)', $dados);
		}

		// -----------------------------------------------------------------------------------------------------------------------------

		public function busca_clientes(int $min) : array{
			$db = new Database();

			return $db->EXECUTE_QUERY('SELECT * FROM clientes AS c INNER JOIN contato_cliente AS cc ON c.cpf = cc.cpf_cliente LIMIT ' . $min . ', 10');
		}
	}
?>