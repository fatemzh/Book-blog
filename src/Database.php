<?php
/**
 * ETML
 * Auteur: Salma Abdulkadir
 * Date: 21.11.2023
 * Description: Programme de la calsse Database. Contient les méthodes privées et publiques utilisées tout au long de l'application.
 */

 class Database {


    // Variable de classe
    private $connector;

    /**
     * Constructeur de la classe Database.
     * Initialise la connexion à la base de données en utilisant les paramètres définis dans le fichier de configuration.
     */
    public function __construct(){
        //Configuration de la base de donnée
        $configs = include("config.php");

        //Connexion via PDO et utilise la variable de classe $connector
        try
        {
            $this->connector = new PDO('mysql:host='. $configs['host'] . ':' . $configs['port'] . ';dbname=' . $configs['dbname'] . ';charset=utf8' , $configs['username'], $configs['password']);
        }
        catch (PDOException $e)
        {
            die('Erreur : ' . $e->getMessage());
        }
        
    }

    /**
     * Exécute une requête de type simple (sans clause WHERE).
     * @param string $query La requête SQL à exécuter.
     * @return mixed Renvoie le résultat de la requête.
     */
    private function querySimpleExecute($query){

        // TODO: permet de préparer et d’exécuter une requête de type simple (sans where)
        //Utilisation de query pour effectuer une requête
        return $this->connector->query($query);;
    }

    /**
     * Prépare, lie les valeurs et exécute une requête avec des paramètres (SELECT avec WHERE, INSERT, UPDATE ou DELETE).
     * @param string $query La requête SQL à exécuter.
     * @param array $binds Les valeurs à lier à la requête.
     * @return mixed Renvoie le résultat de la requête.
     */
    private function queryPrepareExecute($query, $binds){
        
        // TODO: permet de préparer, de binder et d’exécuter une requête (select avec where ou insert, update et delete)
        // A UTILISER PLUS TARD 

        $req = $this->connector->prepare($query);
        foreach($binds as $bind => $value){
            $req->bindValue($bind, $value);
        }
        $req->execute();
        return $req;
    }

    /**
     * Formate les données résultantes d'une requête en tableau associatif.
     * @param mixed $req Le résultat de la requête.
     * @return array Le tableau associatif contenant les données.
     */
    private function formatData($req){

        //Traite les données pour les retourner, par exemple, en tableau associatif
        return $req->fetchALL(PDO::FETCH_ASSOC);
    }

    /**
     * Vide le jeu d'enregistrement.
     * @param mixed $req Le résultat de la requête.
     */
    private function unsetData($req){

        //Vide le jeu d'enregistrement
    }

    /**
     * Récupère tous les enseignants de la table t_teacher.
     * @return array Le tableau associatif contenant les données des enseignants.
     */
    public function getAllUsers(){

        //Exécute la requête pour récupérer tous les enseignants
        $query = 'SELECT * FROM t_user';
        //Appeler la méthode privéer pour avoir le résultat sous forme de tableau
        $req = $this->querySimpleExecute($query);
        //Retourne un tableau associatif
        return $this->formatData($req);

    }

    /**
     * Récupère les informations d'un enseignant spécifique.
     * @param int $idTeacher L'identifiant de l'enseignant.
     * @return array Le tableau associatif contenant les informations de l'enseignant.
     */
    public function getOneBook($idBook){
        
        //Requête SQL pour récupérer un enseignant avec sa section
        $query = "SELECT * FROM t_book  WHERE idBook = :idBook;";
        //Appèle la méthode privée pour executer la requête
        $binds = array("idTeacher" => $idBook);
        $req = $this->queryPrepareExecute($query, $binds);
        //Appèle la méthode privéer pour avoir le résultat sous forme de tableau
        $teachers = $this->formatData($req);
        //Retorune un tableau associatif
        return $teachers[0];
    }
    
 }


?>