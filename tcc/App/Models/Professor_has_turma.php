<?php 

namespace App\Models;

use MF\Model\Model;

class Professor_has_turma extends Model {
  
  
	private $Professor_idProfessor;
	private $Turma_idTurma;



	public function __get($atributo){
		return $this->$atributo;
	}

	public function __set($atributo, $valor){
		$this->$atributo = $valor;
	}


    public function professorTurma() {//create
            $query = 'insert into professor_has_turma (Professor_idProfessor, Turma_idTurma) values (:Professor_idProfessor, :Turma_idTurma)';
            $stmt= $this->db->prepare($query);
            $stmt->bindValue(':Professor_idProfessor',$this->__get('Professor_idProfessor'));
            $stmt->bindValue(':Turma_idTurma',$this->__get('Turma_idTurma'));
           
            $stmt->execute();
        }


}
?>