<?php
	namespace core\classes;

	use \PDO;
	use \SQLException;

	class Database{
		private $conexao = null;

		//-------------------------------------------------------------------
		// Conexão com o Banco de Dados
		//-------------------------------------------------------------------

		private function conectar(){
			try{
				$config = array(
					PDO::ATTR_PERSISTENT => true,
					PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
					PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
					PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
					PDO::ATTR_CASE => PDO::CASE_NATURAL
				);

				$this->conexao = new PDO('mysql:host=' . MYSQL_SERVER . '; dbname=' . MYSQL_DATABASE . '; charset=' . MYSQL_CHARSET, MYSQL_USERNAME, MYSQL_PASSWORD, $config);
				$this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
			}catch(PDOException $e){
				$this->desconectar();
				echo '<h4>ERRO NA CONEXÃO COM O BANCO DE DADOS[' . $e->getCode() . ']: ' . $e->getMessage() . '</h4>';
			}
		}

		//-------------------------------------------------------------------
		// Desconectar com o Banco de Dados
		//-------------------------------------------------------------------

		private function desconectar(){
			$this->conexao = null;
		}

		//-------------------------------------------------------------------
		// CRUD
		//-------------------------------------------------------------------

		//-------------------------------------------------------------------
		// Executa função de pesquisa no mysql
		//-------------------------------------------------------------------

		public function EXECUTE_QUERY(?string $sql, ?array $parametros = null) : ?array{
			$sql = trim($sql);

			try{
				//Conectando com o banco de dados
				$this->conectar();

				//Verificando se a conexão não é nula

				$resultados = array();

				if(!is_null($this->conexao)):
					$executar = $this->conexao->prepare($sql);

					if(!empty($parametros)){
						if(is_array($parametros)) $executar->execute($parametros);
						else $executar->execute();
					}
					else $executar->execute();
					
					$resultados = $executar->fetchAll(PDO::FETCH_CLASS);
				endif;

				//Desconectando com o banco de dados
				$this->desconectar();

				//Retornando resultados
				return $resultados;
			}catch(PDOException $e){
				return array();
			}
		}

		//-------------------------------------------------------------------
		// Executa um insert, update ou delete no mysql
		//-------------------------------------------------------------------

		public function EXECUTE_NON_QUERY(?string $sql, ?array $parametros = null) : ?bool{
			$sql = trim($sql);

			try{
				//Conectando com o banco de dados
				$this->conectar();

				//Verificando se a conexão não é nula

				$resultado = false;

				if(!is_null($this->conexao)):
					$this->conexao->beginTransaction();

					try{
						$executar = $this->conexao->prepare($sql);

						if(!empty($parametros)){
							if(is_array($parametros)) $executar->execute($parametros);
							else $executar->execute();
						}
						else $executar->execute();

						$this->conexao->commit();
						
						$resultado = true;
					}catch(PDOException $e){
						$this->conexao->rollBack();
						$resultado = false;
					}
				endif;

				//Desconectando com o banco de dados
				$this->desconectar();

				//Retornando resultado
				return $resultado;
			}catch(PDOException $e){
				return false;
			}
		}
	}
?>