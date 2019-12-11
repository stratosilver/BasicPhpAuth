<?php
/**
 *	Manage the users table
 */

class ModelUsers{

    var $users;
    var $element;
    var $list = array();

    /**
     * Constructor
     * @param pdoConnexion $dbConnexion
     */
    public function __construct($dbConnexion){
        $this->users = '`users`';
        $this->dbConnexion = $dbConnexion;
        $this->profile = array();
        $this->list = array();
    }

    /**
     * Add a row in users
     * @param array data
     * @return int 
     */
    function add($data){
        //print_r($data);
        $query = "INSERT INTO $this->users  ( firstname, lastname, email, password, create_time, update_time)
		VALUES (
			:firstname, 
			:lastname, 
			:email, 
			:password, 
			NOW(), 
			NOW())";
        $q = $this->dbConnexion->prepare($query);

        if ($q->execute(array(  ':firstname' => $data['firstname'],
            ':lastname' => $data['lastname'],
            ':email' => $data['email'],
            ':password' => password_hash($data['password'], PASSWORD_DEFAULT)))){
            return ($this->dbConnexion->lastInsertId());
        }
        else{
            //print_r($this->dbConnexion->errorInfo());
            //print_r($q->errorInfo());
            return(0);
        }
    }



    /**
     * Update a row in users
     * @param array data
     * @return int
     */
    function update($data){

        $query = "UPDATE $this->users SET 
		`firstname` = :firstname, 
		`lastname` = :lastname, 
		`email` = :email, 
		`password` = :password,  
		`update_time` = NOW()
	WHERE id = :id ";

        $q = $this->dbConnexion->prepare($query);

        if ($q->execute(array(  ':firstname' => $data['firstname'],
            ':lastname' => $data['lastname'],
            ':email' => $data['email'],
            ':password' => password_hash($data['password'], PASSWORD_DEFAULT),
            ':id' => $data['id_user'] ))){
            return (1);
        }
        else{
            return(0);
        }
    }



    /**
     * Update password for one row
     * @param array data
     * @return int
     */
    function updatePassword($data){

        $query = "UPDATE $this->users SET 
		`password` = :password,  
		`update_time` = NOW()
	    WHERE id = :id ";

        $q = $this->dbConnexion->prepare($query);

        if ($q->execute(array(
                ':password' => password_hash($data['password'], PASSWORD_DEFAULT),
                ':id' => $data['id_user'] )
        )
        ){
            return (1);
        }
        else{
            print_r($this->dbConnexion->errorInfo());
            print_r($q->errorInfo());
            return(0);
        }
    }




    /**
     * Delete a row in users
     * @param Int id
     * @return int
     */
    function del($id){

        $query = "DELETE FROM $this->users WHERE id = :id";
        $q = $this->dbConnexion->prepare($query);

        if ($q->execute(array(':id' => $id ))){
            return (1);
        }
        else{
            return(0);
        }
    }




    /**
     * Get a row in users
     * @param Int $id
     * @return int
     */
    function get($id){
        $this->profile = array();
        
        $query = "SELECT  `id_user`,  `firstname`,  `lastname`,  `email`,  `password`,  `create_time`,  `update_time`
 		FROM $this->users
 		WHERE id_user = :id";
        $q = $this->dbConnexion->prepare($query);

        if ($q->execute(array(':id' => $id))){
            if($row = $q->fetch(PDO::FETCH_ASSOC)){
                $this->profile['id_user'] = $row['id_user'];
                $this->profile['firstname'] = $row['firstname'];
                $this->profile['lastname'] = $row['lastname'];
                $this->profile['email'] = $row['email'];
                $this->profile['password'] = $row['password'];
                $this->profile['create_time'] = $row['create_time'];
                $this->profile['update_time'] = $row['update_time'];

                return(1);
            }
            else{
                return(0);
            }
        }
        else{
            //print_r($this->dbConnexion->errorInfo());
            //print_r($q->errorInfo());
            return(0);
        }
    }


    /**
     * Get a row in users by mail
     * @param styring $email
     * @return int
     */
    function getByMail($email){

        $query = "SELECT  `id_user`,  `firstname`,  `lastname`,  `email`,  `password`,  `create_time`,  `update_time`
 		FROM $this->users
 		WHERE email = :email";
        $q = $this->dbConnexion->prepare($query);

        if ($q->execute(array(':email' => $email))){
            if($row = $q->fetch(PDO::FETCH_ASSOC)){
                $this->profile['id_user'] = $row['id_user'];
                $this->profile['firstname'] = $row['firstname'];
                $this->profile['lastname'] = $row['lastname'];
                $this->profile['email'] = $row['email'];
                $this->profile['password'] = $row['password'];
                $this->profile['create_time'] = $row['create_time'];
                $this->profile['update_time'] = $row['update_time'];
                return(1);
            }
            else{
                return(0);
            }
        }
        else{
            return(0);
        }
    }


    /**
     * Login
     * @param string $email
     * @param string $password
     * @return int
     */
    function login($email, $password){
        $this->profile = array();
        
        $query = "SELECT  `id_user`,  `firstname`,  `lastname`,  `email`,  `password`,  `create_time`,  `update_time`
                    FROM $this->users
                    WHERE email = :email 
                   ";
        $q = $this->dbConnexion->prepare($query);
        
        if ($q->execute(array(  ':email' => $email
            )
        )
        ){
            if($row = $q->fetch(PDO::FETCH_ASSOC)){
                $this->profile['id_user'] = $row['id_user'];
                $this->profile['firstname'] = $row['firstname'];
                $this->profile['lastname'] = $row['lastname'];
                $this->profile['email'] = $row['email'];
                $this->profile['password'] = $row['password'];
                $this->profile['create_time'] = $row['create_time'];
                $this->profile['update_time'] = $row['update_time'];

                if(password_verify( $password, $row['password'])){
                    return(1);
                }
                else{
                    $this->profile = array();
                    return(-2);
                }

            }
            else{
                //print_r($this->dbConnexion->errorInfo());
                //print_r($q->errorInfo());
                return(0);
            }
        }
        else{
            return(-1);
        }
    }




    /**
     * Get a list of row in users
     * @param Int limitFrom
     * @param Int limitNumber
     * @param char orderBy
     * @param Int order
     * @return int
     */
    function getList($limitFrom, $limitNumber, $orderBy='', $order='DESC'){
        $this->list = array();
        
        $query = "SELECT  `id_user`,  `firstname`,  `lastname`,  `email`,  `password`,  `create_time`,  `update_time`
		        FROM $this->users ";
        if($orderBy){
            $query .= " ORDER BY $orderBy $order ";
        }

        if($limitNumber){
            $query .= " LIMIT :limitFrom, :limitNumber ";
        }

        $q = $this->dbConnexion->prepare($query);

        if($limitNumber){
            $q->bindValue(':limitFrom', intval($limitFrom), PDO::PARAM_INT);
            $q->bindValue(':limitNumber', intval($limitNumber), PDO::PARAM_INT);
        }

        if ($q->execute()){
            $i=0;
            while($row = $q->fetch(PDO::FETCH_ASSOC)){
                $this->list[$i]['id_user'] = $row['id_user'];
                $this->list[$i]['firstname'] = $row['firstname'];
                $this->list[$i]['lastname'] = $row['lastname'];
                $this->list[$i]['email'] = $row['email'];
                $this->list[$i]['password'] = $row['password'];
                $this->list[$i]['create_time'] = $row['create_time'];
                $this->list[$i]['update_time'] = $row['update_time'];
                $i++;
            }
            return($this->count());
        }
        else{
            return(0);
        }
    }



    /**
     * Count row in users
     */
    function count(){

        $query = "SELECT COUNT(*) AS nbRows
		 FROM $this->users";
        $q = $this->dbConnexion->prepare($query);

        if ($results = $q->execute()){
            if($row = $q->fetch(PDO::FETCH_ASSOC)){
                return($row[nbRows]);
            }
        }
        else{
            return(0);
        }
    }

}
