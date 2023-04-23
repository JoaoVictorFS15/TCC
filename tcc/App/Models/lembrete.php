<?php

namespace App\Models;

use MF\Model\Model;

	class Lembrete extends Model{

		private $id;
		private $id_status;
		private $id_prof;
		private $lembrete;
		private $data_cadastro;
		private $data_lembrete;

		public function __get($atributo){
				return $this->$atributo;
		}

		public function __set($atributo, $valor){
			$this->$atributo = $valor;
		}

			//CRUD
		public function inserir() {//create
			$query = 'insert into lembrete(id_prof, lembrete, data_lembrete) value (:id_prof,:lembrete, :data_lembrete)';
			$stmt= $this->db->prepare($query);
			$stmt->bindValue(':id_prof',$this->__get('id_prof'));
			$stmt->bindValue(':lembrete',$this->__get('lembrete'));
			$stmt->bindValue(':data_lembrete',$this->__get('data_lembrete'));
			$stmt->execute();
		}

	


		public function atualizar() {//update
			$query = "update lembrete set lembrete = :lembrete, data_lembrete = :data_lembrete where id = :id ";
			$stmt= $this->db->prepare($query);
			$stmt->bindValue(':lembrete',$this->__get('lembrete'));
			$stmt->bindValue(':data_lembrete',$this->__get('data_lembrete'));
			$stmt->bindValue(':id',$this->__get('id'));
			 $stmt->execute();
			 return $stmt->fetchAll(\PDO::FETCH_ASSOC);

		}

		public function lembreteDeCada(){
        $query ='select 
					l.id, l.id_prof, s.status, l.lembrete, DATE_FORMAT(l.data_lembrete,"%d/%m/%Y") as data_lembrete
                 from 
                 lembrete as l
                 left join tb_status as s on (l.id_status = s.id)
                 left join professor as p on (p.id_professor = l.id_prof )
                 where 
                 l.id_prof= :id_prof';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_prof',$this->__get('id_prof'));
        
        $stmt->execute();
        return  $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

		public function remover() {//delete
			$query = "delete from lembrete where id = :id ";
			$stmt= $this->db->prepare($query);
			$stmt->bindValue(':id',$this->__get('id'));
			$stmt->execute();
			return $stmt->fetch(\PDO::FETCH_ASSOC);

		}

		public function marcarRealizada() {//update
			$query = "update lembrete set id_status = :id_status where id = :id";
			$stmt= $this->db->prepare($query);
			$stmt->bindValue(':id_status',$this->__get('id_status'));
			$stmt->bindValue(':id',$this->__get('id'));
			 $stmt->execute();
			 return $stmt->fetch(\PDO::FETCH_ASSOC);

		}
	}

?>