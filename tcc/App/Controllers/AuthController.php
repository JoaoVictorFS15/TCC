<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

ini_set('display_errors', 0 );
error_reporting(0);

class AuthController extends Action {

	
	public function autenticar(){
		$usuario = Container::getModel('Usuario');

		$usuario->__set('email', $_POST['email']);
		$usuario->__set('senha', $_POST['senha']);

		$usuario->autenticar();

		if($usuario->__get('idUsuario')!= '' && $usuario->__get('nome')!= '' && $usuario->__get('cpf')!= '') {
			
			session_start();

			$_SESSION['idUsuario'] = $usuario->__get('idUsuario');
			$_SESSION['nome'] = $usuario->__get('nome');
			$_SESSION['cpf'] = $usuario->__get('cpf');
			header('Location:/homeR');	

		}else {
				header('Location:/loginP?login=erro');	
		}

	}

	public function autenticarP(){
		$usuario = Container::getModel('Usuario');

		$usuario->__set('email', $_POST['email']);
		$usuario->__set('senha', $_POST['senha']);

		$usuario->autenticar();

		if($usuario->__get('idUsuario')!= '' && $usuario->__get('nome')!= '' && $usuario->__get('cpf')!= '') {
			
			session_start();

			$_SESSION['idUsuario'] = $usuario->__get('idUsuario');
			$_SESSION['nome'] = $usuario->__get('nome');
			$_SESSION['cpf'] = $usuario->__get('cpf');
			header('Location:/homeP');	

		}else {
				header('Location:/loginP?login=erro');	
		}

	}


	public function sair(){
		session_start();
		session_destroy();
		header('Location:/');

	}
}

?>