<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

ini_set('display_errors', 0 );
error_reporting(0);

class AppController extends Action {

	public function testea()
	{
		$this->render('testea');
		header('Location:/diario?pesquisarPor=recuperar');
	}

	public function homeR(){

		session_start();

			
		
		if ($_SESSION['idUsuario'] != '' && $_SESSION ['nome']!= '' && $_SESSION ['cpf']!='') {

			
			$nomeP = Container::getModel('Usuario');
			$resp = Container::getModel('Responsavel');
			$resp->__set('Usuario_idUsuario', $_SESSION['idUsuario']);
			$respo = $resp->relacionarResponsavel();
 			$this->view->respo = $respo;

 			$nomeP->__set('idUsuario', $_SESSION['idUsuario']);
			$nomePr = $nomeP->getInfo();

			$this->view->nomePr = $nomePr;


 			$mat = 0001;
 			$dtNas = "1997-03-02";
			
			$alus=Container::getModel('Aluno');
			$alus->__set('Responsavel_idResponsavel', $_SESSION['idUsuario']);
			$alus->__set('matricula',$mat);
			$alus->__set('dataNascimento',$dtNas);
			$aluso = $alus->relacionarAluno();

			$this->view->aluso = $aluso;

			$this->render('homeR');



		}else {
			header('Location:/loginP?login=erro');	
		}
	}

	public function homeP(){

		session_start();
		
		if ($_SESSION['idUsuario'] != '' && $_SESSION ['nome']!= '' && $_SESSION ['cpf']!='') {

			
			$nomeP = Container::getModel('Usuario');
			$nomeP->__set('idUsuario', $_SESSION['idUsuario']);
			$nomePr = $nomeP->getInfo();

			$this->view->nomePr = $nomePr;

			$this->render('homeP');



		}else {
			header('Location:/loginP?login=erro');	
		}
	}

	public function nomeP(){

		$nomeP = Container::getModel('Usuario');
		$nomeP->__set('nome', $_POST['nome']);
		$nomeP->__set('idUsuario', $_SESSION['idUsuario']);

		header('Location:/homeP');
	}


	public function novaAtividade()
	{	
		session_start();
		
		if ($_SESSION['idUsuario'] != '' && $_SESSION ['nome']!= '' && $_SESSION ['cpf']!='') {

			$nomeP = Container::getModel('Usuario');
			$nomeP->__set('idUsuario', $_SESSION['idUsuario']);
			$nomePr = $nomeP->getInfo();
			$this->view->nomePr = $nomePr;

			$turma = Container::getModel('Turma');
			$turma->__set('idUsuario',$_SESSION['idUsuario']);
			$turmas = $turma->turmaP();
			$this->view->turmas = $turmas;

			$conteudo = Container::getModel('Conteudo');
			$conteudos = $conteudo->mostrarMaterias();
			$this->view->conteudos = $conteudos;



			$this->render('novaAtividade');
			$this->cadastrarNovaAtividade();


			}else {
				
				header('Location:/loginP?login=erro');	
			}

		}	


		public function cadastrarNovaAtividade(){

			$acao = isset($_GET['acao']) ? $_GET['acao'] : $acao = '';
			
			if($acao == 'inserir'){
				$atividade = Container::getModel('Atividade');
				$atividade->__set('idUsuario',$_SESSION['idUsuario']);
				$atividade->__set('nome',$_POST['nome']);
				$atividade->__set('dataFim',$_POST['dataFim']);
				$atividade->__set('Conteudo_idConteudo',$_POST['Conteudo_idConteudo']);
				

				
				$a = $atividade->inserirA();	

				$this->view->a = $a;
				

			}

	}

	public function consultar()
	{	
		session_start();
		
	if ($_SESSION['idUsuario'] != '' && $_SESSION ['nome']!= '' && $_SESSION ['cpf']!='') {

			$nomeP = Container::getModel('Usuario');
			$nomeP->__set('idUsuario', $_SESSION['idUsuario']);
			$nomePr = $nomeP->getInfo();
			$this->view->nomePr = $nomePr;


			
			$acao = isset($_GET['acao']) ? $_GET['acao'] : '';

			if ($acao == 'recuperar') {
				$atividade = Container::getModel('Atividade');
				$atividade->__set('idUsuario',$_SESSION['idUsuario']);
				
				$turma = Container::getModel('Turma');
				$turma->__set('idUsuario',$_SESSION['idUsuario']);
				$turmas = $turma->turmaP();
				$this->view->turmas = $turmas;


				$this->render('consultar');





			} elseif ($acao == 'marcarRealizada') {


				$atividade = Container::getModel('Atividade');

				$atividade->__set('idUsuario',$_SESSION['idUsuario']);
				$atividade->__set('idTurma', $acao);

				$atividades = $atividade->pesquisarA();
				$this->view->atividades = $atividades;

				$turma = Container::getModel('Turma');
				$turma->__set('idUsuario',$_SESSION['idUsuario']);
				$turmas = $turma->turmaP();
				$this->view->turmas = $turmas;
				


				$atividade->__set('idAtividade', $_GET['idAtividade']);
				$atividade->__set('status',1);

		
				$marcar = $atividade->marcarRealizada();
				$this->view->a = $marcar;

				$this->render('consultar');	
				header('Location:/consultar?acao=recuperar');
				 			
 			}



			else if ($acao != '') {

				$atividade = Container::getModel('Atividade');

				$atividade->__set('idUsuario',$_SESSION['idUsuario']);
				$atividade->__set('idTurma', $acao);

				$atividades = $atividade->pesquisarA();
				$this->view->atividades = $atividades;

				$turma = Container::getModel('Turma');
				$turma->__set('idUsuario',$_SESSION['idUsuario']);
				$turmas = $turma->turmaP();
				$this->view->turmas = $turmas;

				$this->render('consultar');

			}
			else {
				
				header('Location:/loginP?login=erro');	
			}
		}
}


		public function conteudo()
			{	
		session_start();
		
		if ($_SESSION['idUsuario'] != '' && $_SESSION ['nome']!= '' && $_SESSION ['cpf']!='') {

			$nomeP = Container::getModel('Usuario');
			$nomeP->__set('idUsuario', $_SESSION['idUsuario']);
			$nomePr = $nomeP->getInfo();
			$this->view->nomePr = $nomePr;

			$turma = Container::getModel('Turma');
			$turma->__set('idUsuario',$_SESSION['idUsuario']);
			$turmas = $turma->turmaP();
			$this->view->turmas = $turmas;

			$this->render('conteudo');
			$this->cadastrarConteudo();


			}else {
				
				header('Location:/loginP?login=erro');	
			}

		}	

		public function cadastrarConteudo(){

			$acao = isset($_GET['acao']) ? $_GET['acao'] : $acao = '';


			
			if($acao == 'inserir'){

				$conteudo = Container::getModel('Conteudo');
				$conteudo->__set('Professor_has_Turma_Professor_idProfessor',1);
				$conteudo->__set('materia',$_POST['materia']);
				$conteudo->__set('descricao',$_POST['descricao']);
				$conteudo->__set('data',$_POST['data']);
				$conteudo->__set('Professor_has_Turma_Turma_idTurma',1);
				
				$c = $conteudo->inserirC();	

				$this->view->a = $c;
				

			}

	}


	public function visualizarConteudo()
	{	
		session_start();
		
	if ($_SESSION['idUsuario'] != '' && $_SESSION ['nome']!= '' && $_SESSION ['cpf']!='') {

			$nomeP = Container::getModel('Usuario');
			$nomeP->__set('idUsuario', $_SESSION['idUsuario']);
			$nomePr = $nomeP->getInfo();
			$this->view->nomePr = $nomePr;


			$pesquisarPor = isset($_GET['pesquisarPor']) ? $_GET['pesquisarPor'] : '';

	
			
			if ($pesquisarPor == 'recuperar') {
					$conteudo = Container::getModel('Conteudo');
				$conteudo->__set('idUsuario',$_SESSION['idUsuario']);

				$turma = Container::getModel('Turma');
				$turma->__set('idUsuario',$_SESSION['idUsuario']);
				$turmas = $turma->turmaP();
				$this->view->turmas = $turmas;
				

				$this->render('visualizarConteudo');

				
			}else if ($pesquisarPor != '') {

				$conteudo = Container::getModel('Conteudo');

				$conteudo->__set('idUsuario',$_SESSION['idUsuario']);
				$conteudo->__set('idTurma', $pesquisarPor);

				$conteudos = $conteudo->pesquisarTurma();
				$this->view->conteudos = $conteudos;

				$turma = Container::getModel('Turma');
				$turma->__set('idUsuario',$_SESSION['idUsuario']);
				$turmas = $turma->turmaP();
				$this->view->turmas = $turmas;
			
				$this->render('visualizarConteudo');
			

			}
			else {
				
				header('Location:/loginP?login=erro');	
			}
		}
		}



			public function observacao()
			{	
		session_start();
		
	if ($_SESSION['idUsuario'] != '' && $_SESSION ['nome']!= '' && $_SESSION ['cpf']!='') {

			$nomeP = Container::getModel('Usuario');
			$nomeP->__set('idUsuario', $_SESSION['idUsuario']);
			$nomePr = $nomeP->getInfo();
			$this->view->nomePr = $nomePr;

			

			$pesquisarPor = isset($_GET['pesquisarPor']) ? $_GET['pesquisarPor'] : '';

			$this->inserirO();

			if ($pesquisarPor == 'recuperar') {

				$turma = Container::getModel('Turma');
				$turma->__set('idUsuario',$_SESSION['idUsuario']);
				$turmas = $turma->turmaP();
				$this->view->turmas = $turmas;
				

				$this->render('observacao');
			
			}else if ($pesquisarPor != '') {
				$frequencia = Container::getModel('Frequencia');
				$frequencia->__set('idUsuario',$_SESSION['idUsuario']);
				$frequencia->__set('idTurma', $pesquisarPor);

				
				$turma = Container::getModel('Turma');
				$turma->__set('idUsuario',$_SESSION['idUsuario']);
				$turmas = $turma->turmaP();
				$this->view->turmas = $turmas;

				
				$frequencias = $frequencia->alunoTurma();
				$this->view->frequencias = $frequencias;
				$frequenciaT = $frequencia->getTurma();
				$this->view->frequenciaT = $frequenciaT;

				$this->render('observacao');
			}

			else {
				
				header('Location:/loginP?login=erro');	
			}
		}

		
}
			public function inserirO(){

			$pesquisarPor = isset($_GET['pesquisarPor']) ? $_GET['pesquisarPor'] : $acao = '';

			if($pesquisarPor == 'inserir'){
			

				$observacao = Container::getModel('Observacao');
				$observacao->__set('Professor_idProfessor',1);
				$observacao->__set('motivo',$_POST['motivo']);
				$observacao->__set('Aluno_idAluno',$_POST['Aluno_idAluno']);
				
				$frequencia = Container::getModel('Frequencia');
				$frequencia->__set('idUsuario',$_SESSION['idUsuario']);
				$frequencia->__set('idTurma', $pesquisarPor);

				$turma = Container::getModel('Turma');
				$turma->__set('idUsuario',$_SESSION['idUsuario']);
				$turmas = $turma->turmaP();
				$this->view->turmas = $turmas;
				$frequencias = $frequencia->alunoTurma();
				$this->view->frequencias = $frequencias;
				$frequenciaT = $frequencia->getTurma();
				$this->view->frequenciaT = $frequenciaT;

			
				$o = $observacao->inserirObservacao();	

				$this->view->o = $o;
			
				$this->render('observacao');

}
			}

			public function observacaoConsultarP()
			{	
				session_start();

				if ($_SESSION['idUsuario'] != '' && $_SESSION ['nome']!= '' && $_SESSION ['cpf']!='') {

					$nomeP = Container::getModel('Usuario');
					$nomeP->__set('idUsuario', $_SESSION['idUsuario']);
					$nomePr = $nomeP->getInfo();
					$this->view->nomePr = $nomePr;



					$pesquisarPor = isset($_GET['pesquisarPor']) ? $_GET['pesquisarPor'] : '';


					if ($pesquisarPor == 'recuperar') {

						$turma = Container::getModel('Turma');
						$turma->__set('idUsuario',$_SESSION['idUsuario']);
						$turmas = $turma->turmaP();
						$this->view->turmas = $turmas;


						$this->render('observacaoConsultarP');

					}else if ($pesquisarPor != '') {
						$frequencia = Container::getModel('Frequencia');
						$frequencia->__set('idUsuario',$_SESSION['idUsuario']);
						$frequencia->__set('idTurma', $pesquisarPor);

						$turma = Container::getModel('Turma');
							$turma->__set('idUsuario',$_SESSION['idUsuario']);
						$turmas = $turma->turmaP();
						$this->view->turmas = $turmas;
						$frequencias = $frequencia->alunoTurma();
						$this->view->frequencias = $frequencias;
						$frequenciaT = $frequencia->getTurma();
						$this->view->frequenciaT = $frequenciaT;

						$observacao = Container::getModel('Observacao');
						$observacao->__set('nome', $pesquisarPor);
						$observacoes = $observacao->pesquisarO();
						$this->view->observacoes = $observacoes;


						$this->render('observacaoConsultarP');

						
					}

					else {

				header('Location:/loginP?login=erro');	
					}
				}
			}



			public function comunicarP(){

					session_start();

				if ($_SESSION['idUsuario'] != '' && $_SESSION ['nome']!= '' && $_SESSION ['cpf']!='') {

					$nomeP = Container::getModel('Usuario');
					$nomeP->__set('idUsuario', $_SESSION['idUsuario']);
					$nomePr = $nomeP->getInfo();
					$this->view->nomePr = $nomePr;



					$pesquisarPor = isset($_GET['pesquisarPor']) ? $_GET['pesquisarPor'] : '';

					$this->inserirComunicado();
					if ($pesquisarPor == 'recuperar') {

						$responsavel = Container::getModel('Responsavel');
						$responsavel->__set('idUsuario', $pesquisarPor);
						$responsaveis = $responsavel->pesquisarResponsavel();
						$this->view->responsaveis = $responsaveis;

	

						$this->render('comunicarP');
						

					}else if ($pesquisarPor != '') {
						$aluno = Container::getModel('Responsavel');

						$responsaveis = $aluno->pesquisarResponsavel();
						$this->view->responsaveis = $responsaveis;
						$aluno->__set('idUsuario', $pesquisarPor);
						$alunosR = $aluno->pesquisarAlunoR();
						$this->view->alunosR=$alunosR;

					
						$this->render('comunicarP');

					}

					else {

				header('Location:/loginP?login=erro');	
					}
				}

				
			}

			public function inserirComunicado(){

			$pesquisarPor = isset($_GET['pesquisarPor']) ? $_GET['pesquisarPor'] : $pesquisarPor = '';

			if($pesquisarPor == 'inserir'){
			

				$contato = Container::getModel('Contato');
				$conteudo->__set('Professor_has_Turma_Professor_idProfessor',1);
				$contato->__set('motivo',$_POST['motivo']);
				$contato->__set('status',$_POST['status']);
			
				$contato->__set('Aluno_Responsavel_idResponsavel',$_POST['Aluno_Responsavel_idResponsavel']);

				$aluno = Container::getModel('Responsavel');

						$responsaveis = $aluno->pesquisarResponsavel();
						$this->view->responsaveis = $responsaveis;
						$aluno->__set('idUsuario', $pesquisarPor);
						$alunosR = $aluno->pesquisarAlunoR();
						$this->view->alunosR=$alunosR;
			
				$c = $contato->inserirComunicado();	

				$this->view->c = $c;
			
				$this->render('comunicarP');

			}
			}

			public  function diario()
			{
				session_start();

				if ($_SESSION['idUsuario'] != '' && $_SESSION ['nome']!= '' && $_SESSION ['cpf']!='') {

			$nomeP = Container::getModel('Usuario');
			$nomeP->__set('idUsuario', $_SESSION['idUsuario']);
			$nomePr = $nomeP->getInfo();
			$this->view->nomePr = $nomePr;


			$pesquisarPor = isset($_GET['pesquisarPor']) ? $_GET['pesquisarPor'] : '';


				$turma = Container::getModel('Turma');
				$turma->__set('idUsuario',$_SESSION['idUsuario']);
				$turmas = $turma->turmaP();
				$this->view->turmas = $turmas;

				$frequencia = Container::getModel('Frequencia');
				$frequencia->__set('idUsuario',$_SESSION['idUsuario']);
				$frequencia->__set('idTurma', $pesquisarPor);

				$turma = Container::getModel('Turma');
				$turma->__set('idUsuario',$_SESSION['idUsuario']);
				$turmas = $turma->turmaP();
				$this->view->turmas = $turmas;

				$frequencias = $frequencia->alunoTurma();
				$this->view->frequencias = $frequencias;

			

			$this->inserirFrequencia();

			$this->render('diario');

			if ($pesquisarPor == 'recuperar') {
				

				$turma = Container::getModel('Turma');
				$turma->__set('idUsuario',$_SESSION['idUsuario']);
				$turmas = $turma->turmaP();
				$this->view->turmas = $turmas;
				$this->render('diario');

				
			}else if ($pesquisarPor != '') {

				$frequencia = Container::getModel('Frequencia');
				$frequencia->__set('idUsuario',$_SESSION['idUsuario']);
				$frequencia->__set('idTurma', $pesquisarPor);

				$turma = Container::getModel('Turma');
				$turma->__set('idUsuario',$_SESSION['idUsuario']);
				$turmas = $turma->turmaP();
				$this->view->turmas = $turmas;

				$frequencias = $frequencia->alunoTurma();
				$this->view->frequencias = $frequencias;

		

				$this->render('diario');


			}

					else {

				header('Location:/loginP?login=erro');	
					}
				}
			}


			public function inserirFrequencia()
			{

			$pesquisarPor = isset($_GET['pesquisarPor']) ? $_GET['pesquisarPor'] : $pesquisarPor = '';
			
			if($pesquisarPor == 'inserir'){
			

				$frequencia = Container::getModel('Frequencia');
				$frequencia->__set('Turma_idTurma',$_POST['Turma_idTurma']);
				$frequencia->__set('Aluno_idAluno',$_POST['Aluno_idAluno']);
				$frequencia->__set('presenca',$_POST['presenca']);
				$frequencia->__set('data',$_POST['data']);

			
				$f = $frequencia->inserirFrequencia();	


				$this->view->f = $f;
				
				header('Location:/diario?pesquisarPor=recuperar');	

			}
			}

			public  function importarTurma()
			{
				$acao = isset($_GET['acao']) ? $_GET['acao'] : $acao = '';

				if($acao == 'inserirTurma'){
			

				if(!empty($_FILES['importarTurma']['tmp_name'])){
				$arquivo =  new DomDocument();
				$arquivo->load($_FILES['importarTurma']['tmp_name']);
	
		
				$linhas = $arquivo->getElementsByTagName("Row");
		
				$primeira_linha = true;
		
				foreach($linhas as $linha){
					if($primeira_linha == false){
			
				$matricula = $linha->getElementsByTagName("Data")->item(0)->nodeValue;
				echo "matricula: $matricula <br>";
				
				$nome = $linha->getElementsByTagName("Data")->item(1)->nodeValue;
				echo "nome: $nome <br>";

				$dataNascimento = $linha->getElementsByTagName("Data")->item(2)->nodeValue;
				echo "dataNascimento: $dataNascimento <br>";
				
				echo "<hr>";

				$aluno = Container::getModel('Aluno');
				$aluno->__set('matricula',$_POST['matricula'] );
				$aluno->__set('nome',$_POST['nome'] );
				$aluno->__set('dataNascimento',$_POST['dataNascimento'] );

				$aluno->inserirAluno();

			}
			$primeira_linha = false;
		}
	}
			
				$this->render('diario');

			}

}


	public function frequenciaP()
	{
		session_start();
		
	if ($_SESSION['idUsuario'] != '' && $_SESSION ['nome']!= '' && $_SESSION ['cpf']!='') {

			$nomeP = Container::getModel('Usuario');
			$nomeP->__set('idUsuario', $_SESSION['idUsuario']);
			$nomePr = $nomeP->getInfo();
			$this->view->nomePr = $nomePr;


			$pesquisarPor = isset($_GET['pesquisarPor']) ? $_GET['pesquisarPor'] : '';


	
			
			if ($pesquisarPor == 'recuperar') {
					$conteudo = Container::getModel('Conteudo');
				$conteudo->__set('idUsuario',$_SESSION['idUsuario']);

				$turma = Container::getModel('Turma');
				$turma->__set('idUsuario',$_SESSION['idUsuario']);
				$turmas = $turma->turmaP();
				$this->view->turmas = $turmas;
				$this->render('frequenciaP');

				
			}else if ($pesquisarPor != '') {

				$frequencia = Container::getModel('Frequencia');
				$frequencia->__set('idUsuario',$_SESSION['idUsuario']);
				$frequencia->__set('idTurma', $pesquisarPor);

				$turma = Container::getModel('Turma');
				$turma->__set('idUsuario',$_SESSION['idUsuario']);
				$turmas = $turma->turmaP();
				$this->view->turmas = $turmas;

				$frequencias = $frequencia->alunoTurma();
				$this->view->frequencias = $frequencias;

				
				$presenca = Container::getModel('Frequencia');
				$presenca->__set('nome', $_POST['nome']);
				$presenca->__set('data', $_POST['data']);
				$presencas = $presenca->getAluno();
				$this->view->presencas = $presencas;
				

				$this->render('frequenciaP');


			}
			else {
				
				header('Location:/loginP?login=erro');	
			}
		}
	
	}


	public  function comunicadosP()
			{
				session_start();

				if ($_SESSION['idUsuario'] != '' && $_SESSION ['nome']!= '' && $_SESSION ['cpf']!='') {

			$nomeP = Container::getModel('Usuario');
			$nomeP->__set('idUsuario', $_SESSION['idUsuario']);
			$nomePr = $nomeP->getInfo();
			$this->view->nomePr = $nomePr;


			$pesquisarPor = isset($_GET['pesquisarPor']) ? $_GET['pesquisarPor'] : '';


	
			
			if ($pesquisarPor == 'recuperar') {
				
				$contato = Container::getModel('Contato');
				$contato->__set('idUsuario',$_SESSION['idUsuario']);

				$contatos = $contato->comunicados();
				$this->view->contatos = $contatos;

				$contatoA = $contato->comunicadoA();
				$this->view->contatoA = $contatoA;
				$this->render('comunicadosP');

			

			}else if ($pesquisarPor == 'responder') {
				
				$contato = Container::getModel('Contato');
				$contato->__set('resposta',$_POST['resposta']);
				$contato->__set('status',$_POST['status']);
				$contato->__set('idContato',$_POST['idContato']);
				

				$contatos = $contato->responderComunicado();
				$this->view->contatos = $contatos;
				
				header('Location:/comunicadosP?pesquisarPor=recuperar');
				$this->render('comunicadosP');


			}


					else {

				//header('Location:/loginP?login=erro');	
					}
				}
			}

	public function frequenciaR()
	{
		session_start();
		
	if ($_SESSION['idUsuario'] != '' && $_SESSION ['nome']!= '' && $_SESSION ['cpf']!='') {

			$nomeP = Container::getModel('Usuario');
			$nomeP->__set('idUsuario', $_SESSION['idUsuario']);
			$nomePr = $nomeP->getInfo();
			$this->view->nomePr = $nomePr;


			$pesquisarPor = isset($_GET['pesquisarPor']) ? $_GET['pesquisarPor'] : '';


	
			
			if ($pesquisarPor == 'recuperar') {
				$usuario = Container::getModel('Usuario');
				$usuario->__set('idUsuario',$_SESSION['idUsuario']);

				$turma = Container::getModel('Turma');
				$turma->__set('idUsuario',$_SESSION['idUsuario']);
				$turmas = $turma->turmaR();
				$this->view->turmas = $turmas;
				$this->render('frequenciaR');
				
				
			}else if ($pesquisarPor != '') {

				$usuario = Container::getModel('Usuario');
				$usuario->__set('idUsuario',$_SESSION['idUsuario']);


				$frequencia = Container::getModel('Frequencia');
				$frequencia->__set('idUsuario',$_SESSION['idUsuario']);
				$frequencia->__set('idTurma', $pesquisarPor);

				$turma = Container::getModel('Turma');
				$turma->__set('idUsuario',$_SESSION['idUsuario']);
				$turmas = $turma->turmaR();
				$this->view->turmas = $turmas;

				$frequencias = $frequencia->alunoR();
				$this->view->frequencias = $frequencias;

				
				$presenca = Container::getModel('Frequencia');
				$presenca->__set('nome', $_POST['nome']);
				$presenca->__set('data', $_POST['data']);
				$presencas = $presenca->getAluno();
				$this->view->presencas = $presencas;
				
			
				$this->render('frequenciaR');


			}
			else {
				
				//header('Location:/loginP?login=erro');	
			}
		}
	
	}
	public function ConteudoR()
	{	
		session_start();
		
	if ($_SESSION['idUsuario'] != '' && $_SESSION ['nome']!= '' && $_SESSION ['cpf']!='') {

			$nomeP = Container::getModel('Usuario');
			$nomeP->__set('idUsuario', $_SESSION['idUsuario']);
			$nomePr = $nomeP->getInfo();
			$this->view->nomePr = $nomePr;


			$pesquisarPor = isset($_GET['pesquisarPor']) ? $_GET['pesquisarPor'] : '';

	
			
			if ($pesquisarPor == 'recuperar') {
				$conteudo = Container::getModel('Conteudo');
				$conteudo->__set('idUsuario',$_SESSION['idUsuario']);

				$turma = Container::getModel('Turma');
				$turma->__set('idUsuario',$_SESSION['idUsuario']);
				$turmas = $turma->turmaR();
				$this->view->turmas = $turmas;
				

				$this->render('conteudoR');

				
			}else if ($pesquisarPor != '') {

				$conteudo = Container::getModel('Conteudo');

				$conteudo->__set('idUsuario',$_SESSION['idUsuario']);
				$conteudo->__set('idTurma', $pesquisarPor);

				$conteudos = $conteudo->pesquisarTurma();
				$this->view->conteudos = $conteudos;

				$turma = Container::getModel('Turma');
				$turma->__set('idUsuario',$_SESSION['idUsuario']);
				$turmas = $turma->turmaR();
				$this->view->turmas = $turmas;
			
				$this->render('conteudoR');
			

			}
			else {
				
				header('Location:/loginP?login=erro');	
			}
		}
		}

		public function consultarR()
	{	
		session_start();
		
	if ($_SESSION['idUsuario'] != '' && $_SESSION ['nome']!= '' && $_SESSION ['cpf']!='') {

			$nomeP = Container::getModel('Usuario');
			$nomeP->__set('idUsuario', $_SESSION['idUsuario']);
			$nomePr = $nomeP->getInfo();
			$this->view->nomePr = $nomePr;


			
			$acao = isset($_GET['acao']) ? $_GET['acao'] : '';

			if ($acao == 'recuperar') {
				$atividade = Container::getModel('Atividade');
				$atividade->__set('idUsuario',$_SESSION['idUsuario']);

				
				$turma = Container::getModel('Turma');
				$turma->__set('idUsuario', $_SESSION['idUsuario']);
				$turmas = $turma->turmaR();
				$this->view->turmas = $turmas;


				$this->render('consultarR');


			}else if ($acao != '') {

				$atividade = Container::getModel('Atividade');

				$atividade->__set('idUsuario',$_SESSION['idUsuario']);
				$atividade->__set('idTurma', $acao);

				$atividades = $atividade->pesquisarA();
				$this->view->atividades = $atividades;

				$turma = Container::getModel('Turma');
				$turma->__set('idUsuario', $_SESSION['idUsuario']);
				$turmas = $turma->turmaR();
				$this->view->turmas = $turmas;
				$this->render('consultarR');

			}
			else {
				
				header('Location:/loginP?login=erro');	
			}
		}
		}	


		public function comunicarR(){

					session_start();

				if ($_SESSION['idUsuario'] != '' && $_SESSION ['nome']!= '' && $_SESSION ['cpf']!='') {

					$nomeP = Container::getModel('Usuario');
					$nomeP->__set('idUsuario', $_SESSION['idUsuario']);
					$nomePr = $nomeP->getInfo();
					$this->view->nomePr = $nomePr;

					$this->inserirComunicadoR();

					$pesquisarPor = isset($_GET['pesquisarPor']) ? $_GET['pesquisarPor'] : '';

					
					if ($pesquisarPor == 'recuperar') {

						$professor = Container::getModel('Professor');
						$professor->__set('Professor_idProfessor', $_POST['Professor_idProfessor']);
						$professores = $professor->pesquisarProfessor();
						$this->view->professores = $professores;

						$aluno = Container::getModel('Responsavel');
						$aluno->__set('idUsuario', $_SESSION['idUsuario']);

						$alunosR = $aluno->pesquisarAlunoR();
						$this->view->alunosR=$alunosR;

	

						$this->render('comunicarR');
						

					}

					else {

				header('Location:/loginP?login=erro');	
					}
				}

				
			}

			public function inserirComunicadoR(){

			$pesquisarPor = isset($_GET['pesquisarPor']) ? $_GET['pesquisarPor'] : $pesquisarPor = '';

			if($pesquisarPor == 'inserir'){
			

				$contato = Container::getModel('Contato');
				$contato->__set('Professor_idProfessor', $_POST['Professor_idProfessor']);
				$contato->__set('motivo',$_POST['motivo']);
				$contato->__set('status',$_POST['status']);
			
				$contato->__set('Aluno_Responsavel_idResponsavel',$_POST['Aluno_Responsavel_idResponsavel']);

				$professor = Container::getModel('Professor');
				$professor->__set('Professor_idProfessor', $_POST['Professor_idProfessor']);
				$professores = $professor->pesquisarProfessor();
				$this->view->professores = $professores;

				$aluno = Container::getModel('Responsavel');
				$aluno->__set('idUsuario', $_SESSION['idUsuario']);
				$alunosR = $aluno->pesquisarAlunoR();
				$this->view->alunosR=$alunosR;
			
				$c = $contato->inserirComunicado();	

				$this->view->c = $c;
			
				$this->render('comunicarR');

			}
			}


				public function observacaoConsultarR()
		{	
				session_start();

				if ($_SESSION['idUsuario'] != '' && $_SESSION ['nome']!= '' && $_SESSION ['cpf']!='') {

					$nomeP = Container::getModel('Usuario');
					$nomeP->__set('idUsuario', $_SESSION['idUsuario']);
					$nomePr = $nomeP->getInfo();
					$this->view->nomePr = $nomePr;



					$pesquisarPor = isset($_GET['pesquisarPor']) ? $_GET['pesquisarPor'] : '';


					if ($pesquisarPor == 'recuperar') {

						$turma = Container::getModel('Turma');
						$turma->__set('idUsuario',$_SESSION['idUsuario']);
						$turmas = $turma->turmaR();
						$this->view->turmas = $turmas;


						$this->render('observacaoConsultarR');

					}else if ($pesquisarPor != '') {
						$frequencia = Container::getModel('Frequencia');
						$frequencia->__set('idUsuario',$_SESSION['idUsuario']);
						$frequencia->__set('idTurma', $pesquisarPor);

						$turma = Container::getModel('Turma');
						$turma->__set('idUsuario',$_SESSION['idUsuario']);
						$turmas = $turma->turmaR();
						$this->view->turmas = $turmas;

						$frequencias = $frequencia->alunoR();
						
						$this->view->frequencias = $frequencias;
						
						
						$observacao = Container::getModel('Observacao');
						$observacao->__set('nome', $pesquisarPor);
						$observacoes = $observacao->pesquisarO();
						$this->view->observacoes = $observacoes;


						$this->render('observacaoConsultarR');

						
					}

					else {

				header('Location:/loginP?login=erro');	
					}
				}
			}

		}

?>