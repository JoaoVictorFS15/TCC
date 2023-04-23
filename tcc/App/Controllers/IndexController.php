<?php

	
namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;





//ini_set('display_errors', 0 );
//error_reporting(0);

class IndexController extends Action {


	
	public function index() {

		

		$this->render('index');
	}

	public function loginP() {

		$this->view->login = isset($_GET['login']) ? $_GET['login'] : '';
		$this->render('loginP');
	}

	public function loginR() {

		$this->view->login = isset($_GET['login']) ? $_GET['login'] : '';
		$this->render('loginR');
	}

	public function cadastroR() {

		$this->view->responsavel = array(
				'nome' => '',
				'cpf' => '',
				'email' => ''
				//'matricula' => ''
			);
		$this->view->erroCadastro = false;

		$this->render('cadastroR');
	}


	public function cadastro() {

		

		//receber dados do formulario


		$usuario =Container::getModel('Usuario');
		$usuario->__set('nome',$_POST['nome']);
		$usuario->__set('cpf',$_POST['cpf']);
		$cpfusu = $_POST['cpf'];
		$usuario->__set('email',$_POST['email']);
		$usuario->__set('senha',$_POST['senha']);
		$idUsu;
				
		//sucesso
		if($usuario->validarCadastro() && count($usuario->getUsuarioPorEmail()) == 0 && count($usuario->getUsuarioPorCpf()) == 0){

				$usuario->salvar();
				$this->render('/cadastro');

		//erro
		} else {

			$this->view->usuario = array(
				'nome' => $_POST['nome'],
				'cpf' => $_POST['cpf'],
				'email' => $_POST['email']
			);

			$this->view->erroCadastro = true;
			$this->render('cadastroR');
		}

		$idUsu = 'select 
                      idUsuario
                 from 
                    usuario
                   where 
                   cpf = $cpfusu';
          $resultUsu = mysqli_query($conn, $idUsu);        
 

		var_dump($resultUsu);


		
	}





}


?>