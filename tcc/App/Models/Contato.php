<?php 

namespace App\Models;

use MF\Model\Model;

class Contato extends Model{

	private $idContato;
	private $motivo;
	private $resposta;
	private $status;
	private $Professor_idProfessor;
	private $Aluno_Responsavel_idResponsavel;
	


	public function __get($atributo){
		return $this->$atributo;
	}

	public function __set($atributo, $valor){
		$this->$atributo = $valor;
	}

	

	public function inserirComunicado() {//create
			$query = 'insert into contato (motivo, resposta, status, Professor_idProfessor, Aluno_Responsavel_idResponsavel) values (:motivo,:resposta, :status, :Professor_idProfessor, :Aluno_Responsavel_idResponsavel)';
			$stmt= $this->db->prepare($query);
			$stmt->bindValue(':motivo',$this->__get('motivo'));
			$stmt->bindValue(':resposta',$this->__get('resposta'));
			$stmt->bindValue('status',$this->__get('status'));
			$stmt->bindValue('Professor_idProfessor',$this->__get('Professor_idProfessor'));
			$stmt->bindValue('Aluno_Responsavel_idResponsavel',$this->__get('Aluno_Responsavel_idResponsavel'));

			$stmt->execute();
		}


		public function responderComunicado() {//create

			
			$query = 'update contato set resposta = :resposta, status = :status WHERE contato.idContato = :idContato';
			$stmt= $this->db->prepare($query);
			$stmt->bindValue(':resposta',$this->__get('resposta'));
			$stmt->bindValue('status',$this->__get('status'));
			$stmt->bindValue('idContato',$this->__get('idContato'));
			$stmt->execute();
		}

		public function pesquisarUsuario() {//read
	
			$query = 'select 
							*
						from 
							contato as  c
							left join responsavel as r on (c.Aluno_Responsavel_idResponsavel = r.idResponsavel)
							LEFT JOIN usuario as u on (r.Usuario_idUsuario = u.idUsuario) 
							WHERE u.nome = :nome
							';

							
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':nome',$this->__get('nome'));
			$stmt->execute();
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		}

		public function comunicados() {//read
	
			$query = 'select 
							*
						from 
							contato as  c
							inner join responsavel as r on (c.Aluno_Responsavel_idResponsavel = r.idResponsavel)
							LEFT JOIN usuario as u on (r.Usuario_idUsuario = u.idUsuario) 
	
							';

							
			$stmt = $this->db->prepare($query);
			$stmt->execute();
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		}

		public function comunicadoA() {//read
	
			$query = 'select 
							*
						from 
							contato as  c
							inner join responsavel as r on (c.Aluno_Responsavel_idResponsavel = r.idResponsavel)
							LEFT JOIN aluno as a on (r.idResponsavel = a.Responsavel_idResponsavel) ';

							
			$stmt = $this->db->prepare($query);
			$stmt->execute();
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		}

}
?>