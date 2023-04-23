<?php 

namespace App\Models;

use MF\Model\Model;

class Observacao extends Model{

	private $idObservacao;
	private $motivo;
	private $Professor_idProfessor;
	private $Aluno_idAluno;




	public function __get($atributo){
		return $this->$atributo;
	}

	public function __set($atributo, $valor){
		$this->$atributo = $valor;
	}

	

	public function inserirObservacao() {//create
			$query = 'insert into observacao (motivo, Professor_idProfessor, Aluno_idAluno) values (:motivo,:Professor_idProfessor, :Aluno_idAluno)';
			$stmt= $this->db->prepare($query);
			$stmt->bindValue(':motivo',$this->__get('motivo'));
			$stmt->bindValue(':Professor_idProfessor',$this->__get('Professor_idProfessor'));
			$stmt->bindValue('Aluno_idAluno',$this->__get('Aluno_idAluno'));

			$stmt->execute();
		}

		public function pesquisarO() {//read
	
			$query = 'select 
							*
						from 
							observacao as  o
							left join aluno as a on (o.Aluno_idAluno = a.idAluno)

							where 
							a.nome = :nome';

							
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':nome',$this->__get('nome'));
			$stmt->execute();
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		}

	
}
?>