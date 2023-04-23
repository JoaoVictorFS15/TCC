<?php 

namespace App\Models;

use MF\Model\Model;

class Conteudo extends Model{

	private $idConteudo;
	private $materia;
	private $descricao;
	private $data;
	private $Professor_has_Turma_Professor_idProfessor;
	private $Professor_has_Turma_Turma_idTurma;


	public function __get($atributo){
		return $this->$atributo;
	}

	public function __set($atributo, $valor){
		$this->$atributo = $valor;
	}

	

	public function inserirC() {//create
			$query = 'insert into conteudo (materia, descricao, data, Professor_has_Turma_Professor_idProfessor, Professor_has_Turma_Turma_idTurma) values (:materia, :descricao ,:data, :Professor_has_Turma_Professor_idProfessor, :Professor_has_Turma_Turma_idTurma)';
			$stmt= $this->db->prepare($query);
			$stmt->bindValue(':materia',$this->__get('materia'));
			$stmt->bindValue(':descricao',$this->__get('descricao'));
			$stmt->bindValue(':data',$this->__get('data'));
			$stmt->bindValue('Professor_has_Turma_Professor_idProfessor',$this->__get('Professor_has_Turma_Professor_idProfessor'));$stmt->bindValue('Professor_has_Turma_Turma_idTurma',$this->__get('Professor_has_Turma_Turma_idTurma'));
			
			$stmt->execute();
		}

		
	

		public function pesquisarTurma() {//read
	
			$query = 'select 
							materia, descricao
						from 
							conteudo as c 
							inner join turma as t on (c.Professor_has_Turma_Turma_idTurma = t.idTurma)
							where 
							t.idTurma = :idTurma';

		
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':idTurma',$this->__get('idTurma'));
			$stmt->execute();
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		}

			public function mostrarMaterias() {//read
	
			$query = 'select 
							idConteudo, materia, descricao
						from 
							conteudo 
							';
		
			$stmt = $this->db->prepare($query);
			$stmt->execute();
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		}

}
?>
