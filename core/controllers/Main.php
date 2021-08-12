<?php
	namespace core\controllers;

	use core\models\Cliente;
	use core\classes\Store;

	class Main{
		public function inicio(){
			$dados = ['titulo' => 'Início'];

			Store::layout([
				'layouts/html_header',
				'layouts/header',
				'inicio',
				'layouts/html_footer'
			], $dados);
		}

		// Função que irá executar o cadastro de um novo cliente e retornar o resultado

		public function cadastro_cliente(){
			if($_SERVER['REQUEST_METHOD'] != 'POST'):
				Store::redirect('inicio');
				return;
			endif;

			// Pegando os dados do cliente

			$nome = trim(filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS));
			$cpf = trim(filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_NUMBER_INT));
			$telefone = trim(filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_NUMBER_INT));
			$email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));

			if(!empty($nome) && !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($telefone) && !empty($cpf)):
				$cliente = new Cliente();

				if(!$cliente->cpf_existe($cpf)):
					if($cliente->cadastra_cliente($cpf, $nome, $telefone, $email)):
						echo json_encode(['RES' => true, 'MSG' => 'Cliente cadastrado com sucesso!']);
					else:
						echo json_encode(['RES' => false, 'MSG' => 'Cliente NÃO cadastrado!, Ocorreu um erro no cadastro!']);
					endif;
				else:
					echo json_encode(['RES' => false, 'MSG' => 'Cliente NÃO cadastrado!, Já existe um cliente cadastrado com esse CPF!']);
				endif;
			else:
				echo json_encode(['RES' => false, 'MSG' => 'Preencha todos os campos corretamente para finalizar o cadastro!']);
			endif;
		}

		public function edita_cliente(){
			if($_SERVER['REQUEST_METHOD'] != 'POST'):
				Store::redirect('inicio');
				return;
			endif;

			// Pegando os dados do cliente

			$nome = trim(filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS));
			$cpf = trim(filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_NUMBER_INT));
			$telefone = trim(filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_NUMBER_INT));
			$email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
			$cpf_atual = trim(filter_input(INPUT_POST, 'cpf_atual', FILTER_SANITIZE_NUMBER_INT));

			if(!empty($nome) && !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($telefone) && !empty($cpf) && !empty($cpf_atual)):
				$cliente = new Cliente();

				if(!$cliente->cpf_existe($cpf) || $cpf === $cpf_atual):
					if($cliente->edita_cliente($cpf_atual, $cpf, $nome, $telefone, $email)):
						echo json_encode(['RES' => true, 'MSG' => 'Cliente editado com sucesso!']);
					else:
						echo json_encode(['RES' => false, 'MSG' => 'Cliente NÃO editado!, Ocorreu um erro na edição!']);
					endif;
				else:
					echo json_encode(['RES' => false, 'MSG' => 'Cliente NÃO editado!, Já existe um cliente cadastrado com esse CPF!']);
				endif;
			else:
				echo json_encode(['RES' => false, 'MSG' => 'Preencha todos os campos corretamente para finalizar a edição!']);
			endif;
		}

		// Função que irá deletar o cliente

		public function deletar_cliente(){
			if($_SERVER['REQUEST_METHOD'] != 'POST'):
				Store::redirect('inicio');
				return;
			endif;

			$cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_NUMBER_INT);

			if(!empty($cpf)):
				$cliente = new Cliente();

				if($cliente->deleta_cliente($cpf)):
					echo json_encode(['RES' => true, 'MSG' => 'Cliente deletado com sucesso!']);
				else:
					echo json_encode(['RES' => false, 'MSG' => 'Cliente NÃO excluido!, Ocorreu um erro na exclusão!']);
				endif;
			endif;
		}

		// Função que irá buscar os clientes do sistema

		public function busca_clientes(){
			if($_SERVER['REQUEST_METHOD'] != 'POST'):
				Store::redirect('inicio');
				return;
			endif;

			$min = filter_input(INPUT_POST, 'min', FILTER_SANITIZE_NUMBER_INT);

			$html = '';

			if(is_numeric($min)):
				$cliente = new Cliente();
				$dados = $cliente->busca_clientes($min);

				if(count($dados) > 0):
					foreach ($dados as $dado):
						$html .= '<tr class="trCliente">';
						$html .= '<td>' . $dado->cpf . '</td>';
						$html .= '<td>' . $dado->nome_completo . '</td>';
						$html .= '<td>' . $dado->telefone . '</td>';
						$html .= '<td>' . $dado->email . '</td>';
						$html .= '<td><i class="fas fa-trash-alt" onclick="deletar('. $dado->cpf .')"></i><i class="fas fa-pencil-alt" onclick=\'editar(`'. json_encode(['CPF' => $dado->cpf, 'NOME' => $dado->nome_completo, 'TEL' => $dado->telefone, 'EMAIL' => $dado->email]) .'`)\'></i></td>';
						$html .= '</tr>';
					endforeach;

					if(count($dados) >= 10):
						$html .= '<tr id="tdMais"><td colspan="5"><button class="btnMais" onclick="buscaClientes()">+</button></td></tr>';
					endif;
				else:
					$html .= '<tr><td colspan="5"><h4>Não há clientes cadastrados no sistema</h4></td></tr>';
				endif;
			endif;

			echo $html;
		}
	}
?>