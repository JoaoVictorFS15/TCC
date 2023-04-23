<?php 

namespace App\Models;

use MF\Model\Model;

class Usuario extends Model {

	private $idUsuario;
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

	public function autenticar() {

		$query = "select idUsuario, nome, email, cpf from usuario where email = :email and senha = :senha";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':email', $this->__get('email'));
		$stmt->bindValue(':senha', $this->__get('senha'));
		$stmt->execute();

		$usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

		if($usuario['idUsuario'] != '' && $usuario['nome'] != ''&& $usuario['cpf']!='') {
			$this->__set('idUsuario', $usuario['idUsuario']);
			$this->__set('nome', $usuario['nome']);
			$this->__set('cpf', $usuario['cpf']);
		}

		return $this;
	}

	public function salvar(){
		$query = 'insert into usuario(nome, cpf, email, senha) value (:nome, :cpf, :email, :senha)';


			$stmt= $this->db->prepare($query);
			$stmt->bindValue(':nome',$this->__get('nome'));
			$stmt->bindValue(':cpf',$this->__get('cpf'));
			$stmt->bindValue(':email',$this->__get('email'));
			$stmt->bindValue(':senha',$this->__get('senha'));//md5()-> hash 32 caracteres criptografar senha
			$stmt->execute();
			return $this;
	}

	public function getInfo(){
        $query ='select 
                      idUsuario, nome
                 from 
                    usuario
                   where 
                   idUsuario = :idUsuario';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':idUsuario',$this->__get('idUsuario'));
        $stmt->execute();
        return  $stmt->fetch(\PDO::FETCH_ASSOC);

    }

    	public function getidUsu(){
        $query ='select 
                      idUsuario
                 from 
                    usuario
                   where 
                   cpf = :cpf';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':cpf',$this->__get('cpf'));
        $stmt->execute();
        return  $stmt->fetch(\PDO::FETCH_ASSOC);

    }

    public function validarCadastro(){
		$valido = true;

		if (strlen($this->__get('nome'))< 3){
			$valido = false;
		}


		if (strlen($this->__get('cpf'))< 14){
			$valido = false;
		}

		if (strlen($this->__get('email'))< 3){
			$valido = false;
		}


		if (strlen($this->__get('senha'))< 5){
			$valido = false;
		}

		return $valido;
	}

	//recuperar um usuario por e-mail
	public function getUsuarioPorEmail(){
		$query='select nome, email, cpf from usuario where email = :email';
		$stmt= $this->db->prepare($query);
		$stmt->bindValue(':email',$this->__get('email'));
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function getUsuarioPorCpf(){
		$query='select nome, email, cpf from usuario where cpf = :cpf';
		$stmt= $this->db->prepare($query);
		$stmt->bindValue(':cpf',$this->__get('cpf'));
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}


		public function getidUsuario(){
		$query='select MAX(idUsuario) from usuario ';
		$stmt= $this->db->prepare($query);
		$stmt->execute();
		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}

	

}
?>