<?php 

namespace App\Models;

use MF\Model\Model;

class Aluno extends Model{

	private $idAluno;
	private $nome;
	private $matricula;
	private $dataNascimento;
	private $Responsavel_idResponsavel;



	public function __get($atributo){
		return $this->$atributo;
	}

	public function __set($atributo, $valor){
		$this->$atributo = $valor;
	}

	

	public function inserirAluno() {//create
			$query = 'insert into aluno (nome, matricula, dataNascimento) values (:nome, :matricula, :dataNascimento)';
			$stmt= $this->db->prepare($query);
			$stmt->bindValue(':nome',$this->__get('nome'));
			$stmt->bindValue(':matricula',$this->__get('matricula'));
			$stmt->bindValue('dataNascimento',$this->__get('dataNascimento'));
			$stmt->execute();
		}

		public function recuperarAluno() {//read
			$query = 'select 
							*
						from 
							aluno as a 
							left join conteudo as c on (a.Conteudo_idConteudo = c.idConteudo)
							LEFT JOIN turma as t on (c.Professor_has_Turma_Turma_idTurma = t.serie)
							';

						
							

			$stmt = $this->db->prepare($query);

			$stmt->execute();
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		}

		
		public function pesquisarAd() {//read
	
			$query = 'select 
							a.nome, a.dataCadastro, a.dataFim, a.status
						from 
							atividade as  a
							inner join turma as t on (a.Turma_idTurma = t.serie)

							where 
							t.serie = :serie';

							
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':serie',$this->__get('serie'));
			$stmt->execute();
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		}



		public function pesquisarAluno() {//update
			$query = 'select 
							*
						from 
							aluno as  a
							LEFT JOIN responsavel as r on (a.Responsavel_idResponsavel = r.idResponsavel) LEFT JOIN usuario as u on (r.Usuario_idUsuario = u.idUsuario) where u.nome = :nome';

			$stmt= $this->db->prepare($query);
			$stmt->bindValue(':nome',$this->__get('nome'));
			 $stmt->execute();
			 return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		}


		public function relacionarAluno()
		{

			$query = 'UPDATE aluno SET Responsavel_idResponsavel = :Responsavel_idResponsavel WHERE matricula = :matricula AND dataNascimento = :dataNascimento';

			$stmt= $this->db->prepare($query);
			$stmt->bindValue(':Responsavel_idResponsavel',$this->__get('Responsavel_idResponsavel'));
			$stmt->bindValue(':matricula',$this->__get('matricula'));
			$stmt->bindValue(':dataNascimento',$this->__get('dataNascimento'));
			 $stmt->execute();
			 return $stmt->fetchAll(\PDO::FETCH_ASSOC);
			
		}
	
}
?>