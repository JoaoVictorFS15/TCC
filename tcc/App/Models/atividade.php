<?php 

namespace App\Models;

use MF\Model\Model;

class Atividade extends Model{

	private $idAtividade;
	private $dataCadastro;
	private $dataFim;
	private $nome;
	private $status;
	private $Conteudo_idConteudo;
	private $Turma_idTurma;


	public function __get($atributo){
		return $this->$atributo;
	}

	public function __set($atributo, $valor){
		$this->$atributo = $valor;
	}

	

	public function inserirA() {//create
			$query = 'insert into atividade (dataFim, nome, Conteudo_idConteudo) values (:dataFim, :nome, :Conteudo_idConteudo)';
			$stmt= $this->db->prepare($query);
			$stmt->bindValue(':dataFim',$this->__get('dataFim'));
			$stmt->bindValue(':nome',$this->__get('nome'));
			$stmt->bindValue('Conteudo_idConteudo',$this->__get('Conteudo_idConteudo'));
			
			
			$stmt->execute();
		}

	

		
		public function pesquisarA() {//read
	
			$query = 'select 
							a.idAtividade, a.nome,DATE_FORMAT(a.dataCadastro,"%d/%m/%Y") as dataCadastro , DATE_FORMAT(a.dataFim,"%d/%m/%Y") as dataFim, a.status 
						from 
							atividade as  a
							INNER JOIN conteudo on (a.Conteudo_idConteudo = conteudo.idConteudo) LEFT JOIN professor_has_turma on (conteudo.Professor_has_Turma_Turma_idTurma = professor_has_turma.Turma_idTurma) LEFT JOIN turma on (professor_has_turma.Turma_idTurma = turma.idTurma)
							where 
							turma.idTurma = :idTurma';

							
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':idTurma',$this->__get('idTurma'));
			$stmt->execute();
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		}



		public function atualizar() {//update
			$query = "update atividade set atividade = :atividade, data_final = :data_final where id = :id ";
			$stmt= $this->db->prepare($query);
			$stmt->bindValue(':atividade',$this->__get('atividade'));
			$stmt->bindValue(':data_final',$this->__get('data_final'));
			$stmt->bindValue(':id',$this->__get('id'));
			 $stmt->execute();
			 return $stmt->fetchAll(\PDO::FETCH_ASSOC);

		}



		public function marcarRealizada() {//update
			$query = "update atividade set status = :status where idAtividade = :idAtividade";
			$stmt= $this->db->prepare($query);
			$stmt->bindValue(':status',$this->__get('status'));
			$stmt->bindValue(':idAtividade',$this->__get('idAtividade'));
			 $stmt->execute();
			 return $stmt->fetch(\PDO::FETCH_ASSOC);

		}
	
}
?>