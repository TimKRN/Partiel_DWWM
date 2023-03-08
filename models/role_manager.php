<?php
	require_once("connect.php");//Classe mère des managers
	/**
	* Class manager de role
	* @author Timothée KERN
	*/
	class RoleManager extends Manager{
		/**
		* Constructeur de la classe
		*/
		public function __construct(){
			parent::__construct();
		}
		
		/**
		* Méthode de récupération des roles
		* @return array Liste des roles
		*/
		public function findRole(){
			$strRqRole = "SELECT * FROM roles ;";
							
			return $this->_db->query($strRqRole)->fetchAll();
		}
		
	}
?>