-- PROCEDIMENTO QUE IRÁ INSERIR UM NOVO CLIENTE NA TABELA CLIENTES E TAMBÉM OS SEUS DADOS DE CONTATO NA TABELA CONTATO_CLIENTE

DELIMITER $$
CREATE PROCEDURE cadastra_cliente(IN cpf_cli CHAR(11), IN nome VARCHAR(100), IN telefone CHAR(11), IN email VARCHAR(100))
BEGIN
	-- TRATANDO UM ERRO CASO OCORRA NA EXECUÇÃO DA QUERY

	DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
		ROLLBACK;
		SIGNAL SQLSTATE '01000' SET MESSAGE_TEXT = 'Não foi possível finalizar o cadastro do cliente, Ocorreu um erro no cadastro!';
    END;
    
    -- INICIANDO A TRANSAÇÃO E CADASTRANDO DE FATO O CLIENTE
    
    START TRANSACTION;
		INSERT INTO clientes (cpf, nome_completo) VALUES (cpf_cli, nome);
        INSERT INTO contato_cliente (telefone, email, cpf_cliente) VALUES (telefone, email, cpf_cli);
    COMMIT;
END
$$ DELIMITER ;

-- PROCEDIMENTO QUE IRÁ EDITAR OS DADOS DO CLIENTE

DELIMITER $$
CREATE PROCEDURE edita_cliente(IN cpf_editado CHAR(11), IN nome VARCHAR(100), IN telefone CHAR(11), IN email VARCHAR(100), IN cpf_atual CHAR(11))
BEGIN
	-- TRATANDO UM ERRO CASO OCORRA NA EXECUÇÃO DA QUERY

	DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
		ROLLBACK;
		SIGNAL SQLSTATE '01000' SET MESSAGE_TEXT = 'Não foi possível finalizar a edição do cliente, Ocorreu um erro na edição!';
    END;
    
    -- INICIANDO A TRANSAÇÃO E CADASTRANDO DE FATO O CLIENTE
    
    START TRANSACTION;
		UPDATE contato_cliente SET telefone = telefone, email = email WHERE cpf_cliente = cpf_atual LIMIT 1;
		UPDATE clientes SET cpf = cpf_editado, nome_completo = nome WHERE cpf = cpf_atual LIMIT 1;
    COMMIT;
END
$$ DELIMITER ;

-- PROCEDIMENTO QUE IRÁ DELETAR UM CLIENTE

DELIMITER $$
CREATE PROCEDURE deleta_cliente(IN cpf_cliente CHAR(11))
BEGIN
	-- TRATANDO UM ERRO CASO OCORRA NA EXECUÇÃO DA QUERY

	DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
		ROLLBACK;
		SIGNAL SQLSTATE '01000' SET MESSAGE_TEXT = 'Não foi possível excluir esse cliente, Ocorreu um erro na exclusão!';
    END;
    
    -- INICIANDO A TRANSAÇÃO E CADASTRANDO DE FATO O CLIENTE
    
    START TRANSACTION;
		DELETE FROM clientes WHERE cpf = cpf_cliente LIMIT 1;
    COMMIT;
END
$$ DELIMITER ;
