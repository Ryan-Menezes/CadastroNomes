<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title><?= $titulo ?></title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../public/assets/CSS/config.css">
	<link rel="stylesheet" type="text/css" href="../public/assets/CSS/fontawesome-free-5.15.3-web/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="../public/assets/CSS/fontawesome-free-5.15.3-web/css/brands.min.css">
	<link rel="stylesheet" type="text/css" href="../public/assets/CSS/fontawesome-free-5.15.3-web/css/fontawesome.min.css">
	<link rel="stylesheet" type="text/css" href="../public/assets/CSS/fontawesome-free-5.15.3-web/css/regular.min.css">
	<link rel="stylesheet" type="text/css" href="../public/assets/CSS/fontawesome-free-5.15.3-web/css/solid.min.css">
	<link rel="stylesheet" type="text/css" href="../public/assets/CSS/fontawesome-free-5.15.3-web/css/svg-with-js.min.css">
	<link rel="stylesheet" type="text/css" href="../public/assets/CSS/fontawesome-free-5.15.3-web/css/v4-shims.min.css">
</head>
<body>

<!-- Modals -->

<section id="modalFormEditar">
	<form action="javascript:void(0)" method="POST" id="formularioEditar" data-rota='edita_cliente'>
		<h5>Formulário de Edição</h5>

		<input type="text" name="nome" placeholder="Nome Completo" maxlength="100" class="input">
		<input type="text" name="cpf" placeholder="CPF" maxlength="11" class="input">
		<input type="text" name="telefone" placeholder="Telefone" maxlength="11" class="input">
		<input type="text" name="email" placeholder="E-Mail" maxlength="100" class="input">

		<input type="hidden" name="cpf_atual" class="input">

		<div style="display: flex; justify-content: flex-end;">
			<button type="button" id="btnCancelarEdit">Cancelar</button>
			<input type="submit" value="Salvar Edição">
			<input type="reset" style="display: none;">
		</div>
	</form>
</section>

<section id="modalEscolha">
	<main>
		<p>Ops!, Você realmente deseja deletar este cliente?</p>
		<div>
			<button id="btnCancelar">Cancelar</button>
			<button id="btnDeletar">Sim, Quero deletar!</button>
		</div>
	</main>
</section>

<section id="modalLoading">
	<div></div>
</section>