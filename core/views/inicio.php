<section id="principal">
	<main>
		<form action="javascript:void(0)" method="POST" id="formularioCadastro" data-rota='cadastro_cliente'>
			<h5>Formulário de Cadastro</h5>

			<input type="text" name="nome" placeholder="Nome Completo" maxlength="100" class="input">
			<input type="text" name="cpf" placeholder="CPF" maxlength="11" class="input">
			<input type="text" name="telefone" placeholder="Telefone" maxlength="11" class="input">
			<input type="text" name="email" placeholder="E-Mail" maxlength="100" class="input">

			<div style="display: flex; justify-content: flex-end;">
				<input type="submit" value="Cadastrar Cliente">
				<input type="reset" style="display: none;">
			</div>
		</form>
	</main>
	<main>
		<div style="max-height: 500px;">
			<table>
				<thead>
					<tr>
						<th>CPF</th>
						<th>Nome</th>
						<th>Telefone</th>
						<th>E-Mail</th>
						<th></th>
					</tr>
				</thead>
				<tbody id="dadosTabela">
					<tr id="tdMais">
						<td colspan="5"><button class="loading"></button></td>
					</tr>
				</tbody>
			</table>
		</div>
	</main>
</section>