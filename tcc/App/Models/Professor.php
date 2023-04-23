<?php 

namespace App\Models;

use MF\Model\Model;

class Professor extends Model{

	private $id_professor;
	private $nome;
	private $cpf;
	private $email;
	private $senha;

	public function __get($atributo){
		return $this->$atributo;
	}

	public function __set($atributo, $valor){
		$this->$atributo = $valor;
	}

	

	public function autenticar(){
		$query='select id_professor, nome, cpf, email from professor where  email = :email and senha = :senha';
		$stmt= $this->db->prepare($query);
		$stmt->bindValue(':email',$this->__get('email'));
		$stmt->bindValue(':senha',$this->__get('senha'));
		$stmt->execute();
		$professor = $stmt->fetch(\PDO::FETCH_ASSOC);

		if ($professor['id_professor']!='' && $professor['nome']!='' && $professor['cpf']!='' ) {
			$this->__set('id_professor', $professor['id_professor']);
			$this->__set('nome', $professor['nome']);
			$this->__set('cpf', $professor['cpf']);
		}

		return $this;
	}

	public function getAll(){
        $query ='select 
                    p.id_professor, p.nome, p.cpf, p.email
                 from 
                    professor as p';
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return  $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function getInfo(){
        $query ='select 
                      id_professor, nome
                 from 
                    professor
                   where 
                   id_professor = :id_professor';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_professor',$this->__get('id_professor'));
        $stmt->execute();
        return  $stmt->fetch(\PDO::FETCH_ASSOC);

    }

public function importarTurma(){

	

}

public function pesquisarProfessor() {

			$query = 'select 
							*
						from 
							professor as p
							INNER JOIN professor_has_turma on (p.idProfessor = professor_has_turma.Professor_idProfessor) LEFT JOIN turma on (professor_has_turma.Turma_idTurma = turma.idTurma)
							LEFT JOIN usuario as u on (p.Usuario_idUsuario = u.idUsuario)
							';

		

			$stmt= $this->db->prepare($query);
			
			 $stmt->execute();
			 return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		}
	
}
?>