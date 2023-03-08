<?php
	/**
	* Controller des pages
	* @author Timothée KERN
	*/
	class Page_controller extends Base_controller{

		/**
		* Constructeur de la classe
		*/ 
		public function __construct(){
			//user
			require("models/user_manager.php"); 
			require("entities/users_entity.php");
			//product
			require("models/product_manager.php"); 
			require("entities/product_entity.php");
			//roles
			require("models/role_manager.php"); 
			require("entities/roles_entity.php");
			//category
			require("models/category_manager.php"); 
			require("entities/category_entity.php");
		}

		//_______________________________________________________________________________
		
		/**
		* Page Accueil
		*/
		public function accueil(){
			// Pour récupérer les informations dans le formulaire
			$intCat		    = $_POST['cat']??'';
			$strSearch		= $_POST['mots_cles']??'';

			// Liste des catégories
			$objCatManager  	= new CategoryManager(); 
			$arrCat	    		= $objCatManager->findCategory(); 
			$arrSelectedCat		= array();
			
			foreach($arrCat as $arrDetCat){
				$objCat = new Category;
				$objCat->hydrate($arrDetCat);
				if ($intCat == $objCat->getId()) {
					$arrSelectedCat[] = $objCat->getId();
				}
				$arrCatToDisplay[] = $objCat;
			}
			
			//Pour la recherche 		
			$arrResultArticle = array();
			if(count($_POST) >0){
		 		$objSearchManager = new ProductManager();
		 		$arrResultArticle = $objSearchManager->findProduct();
			}


			//Affichage
			var_dump($_COOKIE);
			$this->_arrData['arrSelectedCat']		= $arrSelectedCat;
			$this->_arrData['arrCatToDisplay']		= $arrCatToDisplay;
			$this->_arrData['arrResultArticle']		= $arrResultArticle;
			$this->_arrData['strTitle']	= "Liste des produits";
			$this->_arrData['strPage']	= "index";
			$this->display("index");
		}

		//_______________________________________________________________________________

		/**
		* Page Basket
		*/
		public function basket(){
			//Affichage
			$this->_arrData['strTitle']	= "Mon panier";
			$this->_arrData['strPage']	= "basket";
			$this->display("basket");
		}

		//_______________________________________________________________________________

		/**
		* Page Login
		*/
		public function login(){
			if (count($_POST) > 0){
				$strName 	= $_POST['name'];
				$strPwd 	= $_POST['pwd'];
				
				//Création de l'obet UserManager
				$objUserManager = new UserManager();
				// Vérifier l'utilisateur / mdp en base de données
				$arrUser = $objUserManager->verifUser($strName, $strPwd);
				if ($arrUser === false){
					$this->_arrData['strError'] = "Erreur de connexion";
				}else{
					// Stocker les informations utiles de l'utilisateur en session
					$_SESSION['user']	= $arrUser;
				}
			}
			//Affichage			
			$this->_arrData['strTitle']	= "Se connecter";
			$this->_arrData['strPage']	= "login";
			$this->display("login");
		}

		//_______________________________________________________________________________	

		/**
		* Page Profile
		*/
		public function profile(){
			if (	
				// utilisateur non connecté
				(!isset($_SESSION['user'])) 
		   ){
			header("Location:index.php?ctrl=error&action=error_403");
			}

			//Création de l'obet User et UserManager
			$objUser = new User;
			$objUserManager = new UserManager();

			//Pour la liste des rôles
			$objRoleManager  	= new RoleManager(); 
			$arrRole 	    	= $objRoleManager->findRole(); 

			$arrError = array(); // Tableau des erreurs initialisé

			if (count($_POST) > 0) { // Si le formulaire est envoyé
				// On hydrate l'objet
				$objUser->hydrate($_POST);
				// On teste les informations
				if ($objUser->getPwd() != '' && !password_verify($_POST['confirmpwd'], $objUser->getPwd())){ // Tests sur la confirmation du mot de passe
					$arrError[]	= "Le mot de passe et sa confirmation ne sont pas identiques";
				}
				
				// Si aucune erreur on l'insert en BDD
				if (count($arrError) == 0){ 
					if($objUserManager->updateUser($objUser)){
						// Mettre à jour la session, si compte de l'utilisateur connecté
						if($_SESSION['user']['id'] == $objUser->getId()){
							$_SESSION['user']['name'] = $objUser->getName();
						}
					}else{
						$arrError[]	= "Erreur lors de l'ajout";
					}
				}
				}else{
				// Récupérer les informations de l'utilisateur qui est en session, dans la BDD 
				$arrUser = $objUserManager->getUser();

				// tests sur utilisateur trouvé
				if ($arrUser === false){
					header("Location:index.php?ctrl=error&action=error_403");
				}else{
					// Hydrater l'objet avec la méthode de l'entité
					$objUser->hydrate($arrUser);
				}

			}

			//Liste des rôles dans le formulaire
			foreach($arrRole as $arrDetRole){

				$objRole = new Role;
				$objRole->hydrate($arrDetRole);
				if ($objUser->getRole() == $objRole->getId()) {
					$arrSelectedRole[] = $objRole->getId();
				}
				$arrRoleToDisplay[] = $objRole;
				}

			//Affichage
			$this->_arrData['arrSelectedRole']		= $arrSelectedRole;
			$this->_arrData['arrRoleToDisplay']		= $arrRoleToDisplay;

			$this->_arrData['objUser']	= $objUser;
			$this->_arrData['arrError']	= $arrError;
			$this->_arrData['strTitle']	= "Mon profil";
			$this->_arrData['strPage']	= "profile";
			$this->display("profile");
		}

		//_______________________________________________________________________________

		/**
		* Page Se déconnecter
		*/
		public function logout(){
			//Détruit la Session
			session_destroy();
			//Renvoie vers l'accueil
			header("Location:index.php");
		}

		//_______________________________________________________________________________

		/**
		* Page d'ajout d'un article
		*/
		public function add_article(){
			if (!isset($_SESSION['user']) && $_SESSION['user']['role']!= 1) { // utilisateur non connecté et non admin
				header("Location:index.php?ctrl=error&action=error_403");
			}
			
			// Pour récupérer les informations dans le formulaire
			$intCat		    = $_POST['cat']??'';

			//Création de l'objet product
			$objProduct = new Product;
			
			$arrErrors 	= array(); // Initialisation du tableau des erreurs
			if (count($_POST) > 0){ // si formulaire envoyé

				$objProduct->hydrate($_POST);


				$arrImageInfos		= $_FILES['image']??array();
				// Tests erreurs
				if ($objProduct->getTitle() == ''){
					$arrErrors['title'] = "Merci de renseigner un titre";
				}
				if ($objProduct->getCat() == '0'){
					$arrErrors['cat'] = "Merci de renseigner une catégorie";
				}
				if ($objProduct->getPrice() == '0'){
					$arrErrors['price'] = "Merci de renseigner un prix";
				}
				if ($arrImageInfos['size'] == 0){
					$arrErrors['image'] = "Merci de renseigner une image";
				}
				
				if (count($arrErrors)==0){ 
					// Sauvegarde de l'image sur le serveur
					$strNewName = $this->_photoName($arrImageInfos['name']);
					$boolOk 	= $this->_photoTraitement($arrImageInfos, $strNewName);
					
					if($boolOk){
						// Insertion en BDD, si pas d'erreurs
						$objManager 	= new ProductManager(); // instancier la classe
						$objProduct->setImg($strNewName);
						$objManager->addArticle($objProduct); 
						
						header("Location:index.php"); // Redirection page d'accueil
					}
				}
			}

			// Liste des catégories
			$objCatManager  	= new CategoryManager(); 
			$arrCat	    		= $objCatManager->findCategory(); 
			$arrSelectedCat		= array();
			
			foreach($arrCat as $arrDetCat){
				$objCat = new Category;
				$objCat->hydrate($arrDetCat);
				if ($intCat == $objCat->getId()) {
					$arrSelectedCat[] = $objCat->getId();
				}
				$arrCatToDisplay[] = $objCat;
			}

			// Affichage
			$this->_arrData['arrSelectedCat']		= $arrSelectedCat;
			$this->_arrData['arrCatToDisplay']		= $arrCatToDisplay;

			$this->_arrData['objProduct']	= $objProduct;
			$this->_arrData['arrError']		= $arrErrors;
			$this->_arrData['strTitle']		= "Ajouter un article";
			$this->_arrData['strPage']		= "add_article";
			$this->display("add_article");
		}


		//_______________________________________________________________________________

		/**
		* Page de modification d'un article
		*/
		public function edit_article(){
			// Sécuriser
			if (!isset($_SESSION['user']) && $_SESSION['user']['role']!= 1) { // utilisateur non connecté et non admin
				header("Location:index.php?ctrl=error&action=error_403");
			}

			// Création de l'article
			$objProduct = new Product; //instancier l'objet
			$objManager = new ProductManager(); // instancier la classe

			$arrErrors = array(); // Initialisation du tableau des erreurs
			if (count($_POST) > 0) {
				// hydratation de l'article
				$objProduct->hydrate($_POST);
				$arrImageInfos		= $_FILES['image']??array();

				// Tests erreurs
				if ($objProduct->getTitle() == ''){
					$arrErrors['title'] = "Merci de renseigner un titre";
				}
				if ($objProduct->getCat() == '0'){
					$arrErrors['cat'] = "Merci de renseigner une catégorie";
				}
				if ($objProduct->getPrice() == '0'){
					$arrErrors['price'] = "Merci de renseigner un prix";
				}
				if ($arrImageInfos['size'] == 0){
					$arrErrors['image'] = "Merci de renseigner une image";
				}
					
					if (count($arrErrors)==0){ 
						// Sauvegarde de l'image sur le serveur
						$boolOk 	= true;
						$strNewName	= $objProduct->getImg();
						if ($arrImageInfos['name'] != ''){
							$strNewName = $this->_photoName($arrImageInfos['name']);
							$boolOk 	= $this->_photoTraitement($arrImageInfos, $strNewName);
						}
						if($boolOk){
							// Mise à jour en BDD, si pas d'erreurs
							$objProduct->setImg($strNewName);
							$objManager->updateArticle($objProduct); 
							
							header("Location:index.php"); // Redirection page d'accueil
						}
					}
				}else{
					// Rechercher l'article
					$intArticle = $_GET['id'];
					$arrArticle = $objManager->getArticle($intArticle);
					
					if ($arrArticle === false){
						header("Location:index.php?ctrl=error&action=error_403");
					}else{
						// hydratation de l'article
						$objProduct->hydrate($arrArticle);
					}
				}

			// Pour récupérer les informations dans le formulaire
			$intCat		    = $_POST['cat']??$objProduct->getCat();

			// Liste des catégories
			$objCatManager  	= new CategoryManager(); 
			$arrCat	    		= $objCatManager->findCategory(); 
			$arrSelectedCat		= array();
			
			foreach($arrCat as $arrDetCat){
				$objCat = new Category;
				$objCat->hydrate($arrDetCat);
				if ($intCat == $objCat->getId()) {
					$arrSelectedCat[] = $objCat->getId();
				}
				$arrCatToDisplay[] = $objCat;
			}		
			
			
			
			// Affichage
			$this->_arrData['arrSelectedCat']		= $arrSelectedCat;
			$this->_arrData['arrCatToDisplay']		= $arrCatToDisplay;

			$this->_arrData['objProduct']	= $objProduct;
			$this->_arrData['arrError']		= $arrErrors;
			$this->_arrData['strTitle']		= "Modifier un article";
			$this->_arrData['strPage']		= "edit_article";
			$this->display("add_article");
		}

		//_______________________________________________________________________________

		/**
		* Méthode de supression d'un article/produit
		*/
		public function delete_article(){
			// Création de l'article
			$objProduct = new Product; // instancier l'objet
			$objManager = new ProductManager(); // instancier la classe

			// Rechercher l'article
			$intArticle = $_GET['id'];
			$arrArticle = $objManager->getArticle($intArticle);
			
			if ($arrArticle === false 
			|| 	(!isset($_SESSION['user']) && $_SESSION['user']['role']!= 1)
				){
				header("Location:index.php?ctrl=error&action=error_403");
			}else{
				// hydratation de l'article
				$objManager->deleteArticle($intArticle);
			}

			header("Location:index.php"); // Redirection page d'accueil

		}

		//_______________________________________________________________________________

		/**
		* Méthode d'ajout de produit dans le panier 
		*/
		public function add_product(){
			// Création du cookie (pas eu le temps de finir, mais ça fonctionne)
			if (isset($_COOKIE['test'])) {
				setcookie('test', $_COOKIE['test'] + 1, time()+365*24*3600);
			}else {
				setcookie('test', 1, time()+365*24*3600);
			}
			
		}


	}

?>