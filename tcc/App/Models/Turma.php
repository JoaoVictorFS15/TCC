<?php 

namespace App\Models;

use MF\Model\Model;

class Turma extends Model {

	private $idTurma;
	private $serie;
	private $turno;


	public function __get($atributo){
		return $this->$atributo;
	}

	public function __set($atributo, $valor){
		$this->$atributo = $valor;
	}

	public function turmaP(){
        $query ='select 
                      idTurma, serie 
                 from 
                    turma
                    INNER join professor_has_turma on (turma.idTurma = professor_has_turma.Turma_idTurma) LEFT join professor on (professor_has_turma.Professor_idProfessor = professor.idProfessor) LEFT JOIN usuario ON(professor.Usuario_idUsuario = usuario.idUsuario) WHERE usuario.idUsuario = :idUsuario';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':idUsuario',$this->__get('idUsuario'));
        $stmt->execute();
        return  $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function turmaR(){
        $query ='select 
                      *
                 from 
                    turma
                    INNER join frequencia on (turma.idTurma = frequencia.Turma_idTurma) 
                    LEFT JOIN aluno ON(frequencia.Aluno_idAluno = aluno.idAluno) 
                    LEFT JOIN responsavel on (aluno.Responsavel_idResponsavel = responsavel.idResponsavel)
                    LEFT JOIN usuario on (responsavel.Usuario_idUsuario = usuario.idUsuario) 
                    WHERE 
                    usuario.idUsuario = :idUsuario and frequencia.data = "0000-00-00"
                    ';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':idUsuario',$this->__get('idUsuario'));
        $stmt->execute();
        return  $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

}
?>