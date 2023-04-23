<?php

namespace App;

use MF\Init\Bootstrap;

class Route extends Bootstrap {

	protected function initRoutes() {

		$routes['testea'] = array(
			'route' => '/testea',
			'controller' => 'AppController',
			'action' => 'testea'
		);

		$routes['home'] = array(
			'route' => '/',
			'controller' => 'indexController',
			'action' => 'index'
		);

		$routes['loginP'] = array(
			'route' => '/loginP',
			'controller' => 'indexController',
			'action' => 'loginP'
		);

		$routes['loginR'] = array(
			'route' => '/loginR',
			'controller' => 'indexController',
			'action' => 'loginR'
		);

		$routes['cadastroR'] = array(
			'route' => '/cadastroR',
			'controller' => 'indexController',
			'action' => 'cadastroR'
		);

		$routes['registrar'] = array(
			'route' => '/registrar',
			'controller' => 'indexController',
			'action' => 'registrar'
		);

		$routes['cadastro'] = array(
			'route' => '/cadastro',
			'controller' => 'indexController',
			'action' => 'cadastro'
		);
	

			$routes['autenticar'] = array(
			'route' => '/autenticar',
			'controller' => 'AuthController',
			'action' => 'autenticar'
		);

			$routes['autenticarP'] = array(
				'route' => '/autenticarP',
				'controller' => 'AuthController',
				'action' => 'autenticarP'
			);

		$routes['homeR'] = array(
			'route' => '/homeR',
			'controller' => 'AppController',
			'action' => 'homeR'
		);

		$routes['homeP'] = array(
			'route' => '/homeP',
			'controller' => 'AppController',
			'action' => 'homeP'
		);

	


		$routes['novaAtividade'] = array(
			'route' => '/novaAtividade',
			'controller' => 'AppController',
			'action' => 'novaAtividade'
		);

		$routes['consultar'] = array(
			'route' => '/consultar',
			'controller' => 'AppController',
			'action' => 'consultar'
		);

		$routes['conteudo'] = array(
			'route' => '/conteudo',
			'controller' => 'AppController',
			'action' => 'conteudo'
		);

		$routes['visualizarConteudo'] = array(
			'route' => '/visualizarConteudo',
			'controller' => 'AppController',
			'action' => 'visualizarConteudo'
		);

			$routes['observacao'] = array(
			'route' => '/observacao',
			'controller' => 'AppController',
			'action' => 'observacao'
		);

			$routes['observacaoConsultarP'] = array(
			'route' => '/observacaoConsultarP',
			'controller' => 'AppController',
			'action' => 'observacaoConsultarP'
		);

			$routes['observacaoConsultarR'] = array(
			'route' => '/observacaoConsultarR',
			'controller' => 'AppController',
			'action' => 'observacaoConsultarR'
		);
		
			$routes['comunicarP'] = array(
			'route' => '/comunicarP',
			'controller' => 'AppController',
			'action' => 'comunicarP'
		);

			$routes['diario'] = array(
			'route' => '/diario',
			'controller' => 'AppController',
			'action' => 'diario'
		);
		
		$routes['frequenciaP'] = array(
			'route' => '/frequenciaP',
			'controller' => 'AppController',
			'action' => 'frequenciaP'
		);

		$routes['comunicadosP'] = array(
			'route' => '/comunicadosP',
			'controller' => 'AppController',
			'action' => 'comunicadosP'
		);

		$routes['frequenciaR'] = array(
			'route' => '/frequenciaR',
			'controller' => 'AppController',
			'action' => 'frequenciaR'
		);

		$routes['conteudoR'] = array(
			'route' => '/conteudoR',
			'controller' => 'AppController',
			'action' => 'conteudoR'
		);

		$routes['consultarR'] = array(
			'route' => '/consultarR',
			'controller' => 'AppController',
			'action' => 'consultarR'
		);

			$routes['comunicarR'] = array(
			'route' => '/comunicarR',
			'controller' => 'AppController',
			'action' => 'comunicarR'
		);
		
		

		$routes['sair'] = array(
			'route' => '/sair',
			'controller' => 'AuthController',
			'action' => 'sair'
		);


		$this->setRoutes($routes);
	}

}

?>