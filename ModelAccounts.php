<?php
/**
 *	Manage the table accounts

 */

class ModelAccounts{

    var $accountsTable;
    var $element;
    var $list = array();

    /**
     * Constructor
     * @param pdo link $link
     */
    public function __construct($link){
        $this->accountsTable = '`accounts`';
        $this->link = $link;
        $this->element = array();
        $this->list = array();
    }

    /**
     * Add a row in accounts
     * @param array data
     */
    function add($data){

        $query = "INSERT INTO $this->accountsTable  (id_user, company, url, address, country_code, postcode, phone, api_key, api_secret, create_time, validated_time)
		VALUES (
			:id_user, 
			:company, 
			:url, 
			:address, 
			:country_code, 
			:postcode, 
			:phone, 
			:api_key, 
			:api_secret, 
			:create_time, 
			:validated_time)";
        $q = $this->link->prepare($query);


        if ($q->execute(array(':id_user' => $data['id_user'], ':company' => $data['company'], ':url' => $data['url'], ':address' => $data['address'], ':country_code' => $data['country_code'], ':postcode' => $data['postcode'], ':phone' => $data['phone'], ':api_key' => $data['api_key'], ':api_secret' => $data['api_secret'], ':create_time' => $data['create_time'], ':validated_time' => $data['validated_time']))){
            return ($this->link->lastInsertId());
        }
        else{
            return(0);
        }
    }



    /**
     * Update a row in accounts
     * @param array data
     */
    function update($data){

        $query = "UPDATE $this->accountsTable SET 
		`company` = :company, 
		`url` = :url, 
		`address` = :address, 
		`country_code` = :country_code, 
		`postcode` = :postcode, 
		`phone` = :phone, 
		`api_key` = :api_key, 
		`api_secret` = :api_secret, 
		`create_time` = :create_time, 
		`validated_time` = :validated_time
	WHERE id_user = :id_user ";
        //echo $query;
        $q = $this->link->prepare($query);


        if ($q->execute(array(':id_user' => $data['id_user'], ':company' => $data['company'], ':url' => $data['url'], ':address' => $data['address'], ':country_code' => $data['country_code'], ':postcode' => $data['postcode'], ':phone' => $data['phone'], ':api_key' => $data['api_key'], ':api_secret' => $data['api_secret'], ':create_time' => $data['create_time'], ':validated_time' => $data['validated_time'] ))){
            //echo 'A';
            return (1);
        }
        else{

            return(0);
        }
    }



    /**
     * Delete a row in accounts
     * @param Int id
     */
    function del($id){

        $query = "DELETE FROM $this->accountsTable WHERE id = :id";
        $q = $this->link->prepare($query);

        if ($q->execute(array(':id' => $id ))){
            return (1);
        }
        else{
            return(0);
        }
    }




    /**
     * Get a row in accounts
     * @param Int id
     */
    function get($id){

        $query = "SELECT  `id_user`,  `company`,  `url`,  `address`,  `country_code`,  `postcode`,  `phone`,  `api_key`,  `api_secret`,  `create_time`,  `validated_time`
 		FROM $this->accountsTable
 		WHERE id_user = :id_user ";
        $q = $this->link->prepare($query);
        if ($q->execute(array(':id_user' => $id))){
            if($row = $q->fetch(PDO::FETCH_ASSOC)){
                $this->element['id_user'] = $row['id_user'];
                $this->element['company'] = $row['company'];
                $this->element['url'] = $row['url'];
                $this->element['address'] = $row['address'];
                $this->element['country_code'] = $row['country_code'];
                $this->element['postcode'] = $row['postcode'];
                $this->element['phone'] = $row['phone'];
                $this->element['api_key'] = $row['api_key'];
                $this->element['api_secret'] = $row['api_secret'];
                $this->element['create_time'] = $row['create_time'];
                $this->element['validated_time'] = $row['validated_time'];
                return(1);
            }
            else{
//            print_r($this->link->errorInfo());
//            print_r($q->errorInfo());
                return(0);
            }
        }
        else{
            return(0);
        }
    }





    /**
     * Get a list of row in accounts
     * @param Int limitFrom
     * @param Int limitNumber
     * @param char orderBy
     * @param Int order
     */
    function getList($limitFrom, $limitNumber, $orderBy='', $order='DESC'){

        $query = "SELECT  `id_user`,  `company`,  `url`,  `address`,  `country_code`,  `postcode`,  `phone`,  `api_key`,  `api_secret`,  `create_time`,  `validated_time`
		 FROM $this->accountsTable ";
        if($orderBy){
            $query .= "ORDER BY :orderBy :order ";
        }

        if($limitNumber){
            $query .= "LIMIT :limitFrom, :limitNumber ";
        }

        $q = $this->link->prepare($query);

        if($limitNumber){
            $q->bindValue(':limitFrom', intval($limitFrom), PDO::PARAM_INT);
            $q->bindValue(':limitNumber', intval($limitNumber), PDO::PARAM_INT);
        }
        if($orderBy){
            $q->bindValue(':order', $order);
            $q->bindValue(':orderBy', $orderBy);
        }
        if ($q->execute()){
            $i=0;
            while($row = $q->fetch(PDO::FETCH_ASSOC)){
                $this->list[$i]['id_user'] = $row['id_user'];
                $this->list[$i]['company'] = $row['company'];
                $this->list[$i]['url'] = $row['url'];
                $this->list[$i]['address'] = $row['address'];
                $this->list[$i]['country_code'] = $row['country_code'];
                $this->list[$i]['postcode'] = $row['postcode'];
                $this->list[$i]['phone'] = $row['phone'];
                $this->list[$i]['api_key'] = $row['api_key'];
                $this->list[$i]['api_secret'] = $row['api_secret'];
                $this->list[$i]['create_time'] = $row['create_time'];
                $this->list[$i]['validated_time'] = $row['validated_time'];
                $i++;
            }
            return($i);
        }
        else{
            return(0);
        }
    }





    /**
     * Count row in accounts
     */
    function count(){

        $query = "SELECT COUNT(*) AS nbRows
		 FROM $this->accountsTable";
        $q = $this->link->prepare($query);

        if ($results = $q->execute()){
            if($row = $results->fetch(PDO::FETCH_ASSOC)){
                return($row[nbRows]);
            }
        }
        else{
            return(0);
        }
    }



}

?>