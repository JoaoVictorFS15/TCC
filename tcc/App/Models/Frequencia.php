<?php 

namespace App\Models;

use MF\Model\Model;

class Frequencia extends Model{

	private $Turma_idTurma;
	private $Aluno_idAluno;
	private $presenca;
	private $data;




	public function __get($atributo){
		return $this->$atributo;
	}

	public function __set($atributo, $valor){
		$this->$atributo = $valor;
	}


	public function inserirFrequencia(){

	$query = 'insert into frequencia (Turma_idTurma, Aluno_idAluno, presenca, data) values (:Turma_idTurma, :Aluno_idAluno, :presenca, :data)';
			$stmt= $this->db->prepare($query);
			$stmt->bindValue(':Turma_idTurma',$this->__get('Turma_idTurma'));
			$stmt->bindValue(':Aluno_idAluno',$this->__get('Aluno_idAluno'));
			$stmt->bindValue('presenca',$this->__get('presenca'));
			$stmt->bindValue('data',$this->__get('data'));
			
			$stmt->execute();
	}

		
		public function getAluno() {//read
	
			$query = 'select 
							*
						from 
							frequencia as f
							inner join turma as t on (f.Turma_idTurma = t.idTurma)
							left join aluno as a on (f.Aluno_idAluno = a.idAluno)
							where 
							a.nome = :nome AND data = :data';

		
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':nome',$this->__get('nome'));
			$stmt->bindValue(':data',$this->__get('data'));
			
			$stmt->execute();
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		}


		public function getTurma() {//read
	
			$query = 'select 
							*
						from 
							frequencia as f
							inner join turma as t on (f.Turma_idTurma = t.idTurma)
							left join aluno as a on (f.Aluno_idAluno = a.idAluno)
							where 
							 t.idTurma = :idTurma AND data = :data';

		
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':idTurma',$this->__get('idTurma'));
			$stmt->bindValue(':data',$this->__get('data'));
			
			$stmt->execute();
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		}



		public function alunoTurma() {//read
	
			$query = 'select 
							*
						from 
							frequencia as f 
							LEFT JOIN turma as t on (f.Turma_idTurma = t.idTurma)
							left join aluno as a on (f.Aluno_idAluno = a.idAluno)
							where 
							t.idTurma = :idTurma and f.data = "0000-00-00"
							ORDER BY a.nome ASC';
							

			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':idTurma',$this->__get('idTurma'));

			$stmt->execute();
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		}


		public function alunoR() {//read
	
			$query = 'select 
							a.nome
						from 
							frequencia as f 
							LEFT JOIN turma as t on (f.Turma_idTurma = t.idTurma)
							left join aluno as a on (f.Aluno_idAluno = a.idAluno)
                            LEFT JOIN responsavel ON (a.Responsavel_idResponsavel = responsavel.idResponsavel)
                            LEFT JOIN usuario ON (responsavel.Usuario_idUsuario = usuario.idUsuario)
							where 
							t.idTurma = :idTurma and f.data = "0000-00-00" AND usuario.idUsuario = :idUsuario
							ORDER BY a.nome ASC';
							

			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':idTurma',$this->__get('idTurma'));
			$stmt->bindValue(':idUsuario',$this->__get('idUsuario'));

			$stmt->execute();
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		}

	
}
?>