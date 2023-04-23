<?php 

namespace App\Models;

use MF\Model\Model;

ini_set('display_errors', 0 );
error_reporting(0);

class Responsavel extends Model{

	private $idResponsavel;
	private $Usuario_idUsuario;


	public function __get($atributo){
		return $this->$atributo;
	}

	public function __set($atributo, $valor){
		$this->$atributo = $valor;
	}

	//salvar
	

	//validar se um cadastro pode ser feito
	public function validarCadastro(){
		$valido = true;

		if (strlen($this->__get('nome'))< 3){
			$valido = false;
		}


		if (strlen($this->__get('cpf'))< 14){
			$valido = false;
		}

		if (strlen($this->__get('email'))< 3){
			$valido = false;
		}


		if (strlen($this->__get('senha'))< 5){
			$valido = false;
		}

		return $valido;
	}

	public function relacionarResponsavel()
	{

			$query= "INSERT INTO responsavel ( Usuario_idUsuario) VALUES ( :Usuario_idUsuario)";
			$stmt= $this->db->prepare($query);
			$stmt->bindValue(':Usuario_idUsuario',$this->__get('Usuario_idUsuario'));
			$stmt->execute();
			return $stmt->fetch(\PDO::FETCH_ASSOC);
		
	}

	

	
	public function autenticar(){
		$query='select id_responsavel, nome, cpf, email from responsavel where  email = :email and senha = :senha';
		$stmt= $this->db->prepare($query);
		$stmt->bindValue(':email',$this->__get('email'));
		$stmt->bindValue(':senha',$this->__get('senha'));
		$stmt->execute();
		$responsavel = $stmt->fetch(\PDO::FETCH_ASSOC);

		if ($responsavel['id_responsavel']!='' && $responsavel['nome']!='' && $responsavel['cpf']!='' ) {
			$this->__set('id_responsavel', $responsavel['id_responsavel']);
			$this->__set('nome', $responsavel['nome']);
			$this->__set('cpf', $responsavel['cpf']);
		}

		return $this;
	}

	public function pesquisarResponsavel() {

			$query = 'select 
							*
						from 
							responsavel as r
							LEFT JOIN usuario as u on (r.Usuario_idUsuario = u.idUsuario) 
							';

			$stmt= $this->db->prepare($query);
			
			 $stmt->execute();
			 return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		}

		public function pesquisarAlunoR() {

			$query = 'select 
							*
						from 
							responsavel as r
							LEFT JOIN usuario as u on (r.Usuario_idUsuario = u.idUsuario) 
							LEFT join aluno as a on (r.idResponsavel = a.Responsavel_idResponsavel)
							where
							u.idUsuario = :idUsuario
							';
			$stmt= $this->db->prepare($query);
			$stmt->bindValue(':idUsuario',$this->__get('idUsuario'));
			 $stmt->execute();
			 return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		}

	
}
?>