let cpf_cliente = null

function executaFormulario(){
	let formulario = event.target

	event.preventDefault()

	let rota = formulario.dataset.rota // Rota por onde será enviado os dados do formulário

	$.ajax({
		method: 'POST',
		url: 'http://localhost/CadastroNomes/public/?a=' + rota,
		data: new FormData(formulario),
		processData: false,
		contentType: false,
		beforeSend: function(){
			window.document.getElementById('modalLoading').style.display = 'flex'
		}
	})
	.done(function(res){
		let resposta = JSON.parse(res)

		// Paresenta a caixa de mensagem com o resultado da requisição

		let caixa = window.document.getElementById('msgbox')

		caixa.innerHTML = resposta.MSG
		caixa.style.display = 'block'

		if(resposta.RES){
			try{
				formulario.querySelector('input[type=reset]').click()
			}catch{}
		}

		cancelar_edicao()
		window.document.getElementById('modalLoading').style.display = 'none'

		window.document.getElementById('dadosTabela').innerHTML = '<tr id="tdMais"><td colspan="5"><button class="loading"></button></td></tr>'
		buscaClientes()
	})
	.fail(function(){
		window.document.getElementById('modalLoading').style.display = 'none'
	})
}

// Funções para editar um cliente

function editar(dados){
	dados_cliente = JSON.parse(dados)

	let form = window.document.getElementById('modalFormEditar')
	let inputs = form.getElementsByClassName('input')

	inputs['cpf'].value = dados_cliente.CPF
	inputs['nome'].value = dados_cliente.NOME
	inputs['telefone'].value = dados_cliente.TEL
	inputs['email'].value = dados_cliente.EMAIL
	inputs['cpf_atual'].value = dados_cliente.CPF

	form.style.display = 'flex'
}

function cancelar_edicao(){
	let form = window.document.getElementById('modalFormEditar')
	let inputs = form.getElementsByClassName('input')

	for(let input of inputs) input.value = ''

	form.style.display = 'none'
}

// Função para buscar clientes

function buscaClientes(){
	let obj = (event.type === 'click') ? event.target : null

	$.ajax({
		method: 'POST',
		url: 'http://localhost/CadastroNomes/public/?a=busca_clientes',
		data: {min: window.document.getElementsByClassName('trCliente').length},
		beforeSend: function(){
			if(obj !== null){
				obj.innerHTML = ''
				obj.classList.remove('btnMais')
				obj.classList.add('loading')
			}
		}
	})
	.done(function(res){
		window.document.getElementById('tdMais').remove()

		window.document.getElementById('dadosTabela').innerHTML += res
	})
	.fail(function(){
		window.document.getElementById('tdMais').remove()
	})
}

// Função para deletar um cliente

function deletar(cpf){
	cpf_cliente = cpf

	window.document.getElementById('modalEscolha').style.display = 'flex'
}

function deletar_confirmada(){
	$.ajax({
		method: 'POST',
		url: 'http://localhost/CadastroNomes/public/?a=deletar_cliente',
		data: {cpf: cpf_cliente},
		beforeSend: function(){
			window.document.getElementById('modalLoading').style.display = 'flex'
		}
	})
	.done(function(res){
		let resposta = JSON.parse(res)

		// Paresenta a caixa de mensagem com o resultado da requisição

		let caixa = window.document.getElementById('msgbox')

		caixa.innerHTML = resposta.MSG
		caixa.style.display = 'block'

		if(resposta.RES){
			try{
				formulario.querySelector('input[type=reset]').click()
			}catch{}
		}

		window.document.getElementById('modalLoading').style.display = 'none'
		window.document.getElementById('modalEscolha').style.display = 'none'

		window.document.getElementById('dadosTabela').innerHTML = '<tr id="tdMais"><td colspan="5"><button class="loading"></button></td></tr>'
		buscaClientes()
	})
	.fail(function(){
		window.document.getElementById('modalLoading').style.display = 'none'
		window.document.getElementById('modalEscolha').style.display = 'none'
	})
}

function deletar_cancelar(){
	cpf_cliente = null

	window.document.getElementById('modalEscolha').style.display = 'none'
}

window.addEventListener('load', function(){
	window.document.getElementById('formularioCadastro').addEventListener('submit', executaFormulario)
	window.document.getElementById('formularioEditar').addEventListener('submit', executaFormulario)
	window.document.getElementById('msgbox').addEventListener('click', function(){
		let caixa = event.target

		caixa.style.display = 'none'
		caixa.innerHTML = ''
	})

	window.document.getElementById('btnCancelarEdit').addEventListener('click', cancelar_edicao)

	window.document.getElementById('btnCancelar').addEventListener('click', deletar_cancelar)
	window.document.getElementById('btnDeletar').addEventListener('click', deletar_confirmada)

	buscaClientes()
})