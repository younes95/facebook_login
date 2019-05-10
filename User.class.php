<?php
/*
 * User Class
 * This class is used for database related (connect, insert, and update) operations
 */
class User {
    private $dbHost     = DB_HOST;
    private $dbUsername = DB_USERNAME;
    private $dbPassword = DB_PASSWORD;
    private $dbName     = DB_NAME;
    private $userTbl    = DB_USER_TBL;
    
    function __construct(){

        if(!isset($this->db)){
            // Connect to the database
            $conn = new mysqli($this->dbHost, $this->dbUsername, $this->dbPassword, $this->dbName);
            
            if($conn->connect_error){
                die("Failed to connect with MySQL: " . $conn->connect_error);
            }else{
                $this->db = $conn;
            }

        }
    }
    
    function checkUser($userData = array()){
     
        if(!empty($userData)){
            
            // Check whether user data already exists in database
           //$prevQ = "SELECT * FROM ".$this->userTbl." WHERE oauth_provider = '".$userData['oauth_provider']."' AND oauth_uid = '".$userData['oauth_uid']."'";
           
            $prevQ = "SELECT * FROM ".$this->userTbl." WHERE oauth_provider =  ? AND oauth_uid = ? ";

            $stmt = $this->db->prepare($prevQ);
            $stmt->bind_param('ss', $userData['oauth_provider'],$userData['oauth_uid']); 
            $stmt->execute();

            $prevR = $stmt->get_result();

            /*$prevQ = "SELECT * FROM ".$this->userTbl." WHERE oauth_provider = '".$userData['oauth_provider']."' AND oauth_uid = '".$userData['oauth_uid']."'";

            $prevR = $this->db->query($prevQ);*/
            
            if($prevR->num_rows > 0){
                
                // Update user data if already exists
               
              //  $query = "UPDATE ".$this->userTbl." SET first_name = '".$userData['first_name']."', last_name = '".$userData['last_name']."', email = '".$userData['email']."', picture = '".$userData['picture']."', is_active = 1, modified = NOW() WHERE oauth_provider = '".$userData['oauth_provider']."' AND oauth_uid = '".$userData['oauth_uid']."'";
                $query = "UPDATE ".$this->userTbl." SET first_name = ?, last_name = ?, email = ?, picture = ?, is_active = 1, modified = NOW() WHERE oauth_provider = ? AND oauth_uid = ?";

                $stmt = $this->db->prepare($query);
                $stmt->bind_param('ssssss', $userData['first_name'],$userData['last_name'],$userData['email'],$userData['picture'],$userData['oauth_provider'],$userData['oauth_uid']); 
                $stmt->execute();


                $update = $stmt->get_result();
            }else{
                
                // Insert user data
                
                $query = "INSERT INTO ".$this->userTbl." SET oauth_provider = '".$userData['oauth_provider']."', oauth_uid = '".$userData['oauth_uid']."', first_name = '".$userData['first_name']."', last_name = '".$userData['last_name']."', email = '".$userData['email']."',  picture = '".$userData['picture']."', is_active = 1, created = NOW(), modified = NOW()";
                $query = "INSERT INTO ".$this->userTbl." SET oauth_provider = ?, oauth_uid = ?, first_name = ?, last_name = ?, email = ?,  picture = ?, is_active = 1, created = NOW(), modified = NOW()";

                $stmt = $this->db->prepare($query);
                $stmt->bind_param('ssssss',$userData['oauth_provider'],$userData['oauth_uid'],$userData['first_name'],$userData['last_name'],$userData['email'],$userData['picture']); 
                $stmt->execute();

                $insert =  $stmt->get_result();
            }
            
            // Get user data from the database
            $stmt = $this->db->prepare($prevQ);
            $stmt->bind_param('ss', $userData['oauth_provider'],$userData['oauth_uid']); 
            $stmt->execute();

            $result = $stmt->get_result();
            $userData = $result->fetch_assoc();
        }
        
        // Return user data
        return $userData;
    }


    function disable($id){
     
               // Set is active to false if the user exist
               
                $query = "UPDATE ".$this->userTbl." SET is_active = 0, modified = NOW() WHERE oauth_uid =  ?";
                $stmt = $this->db->prepare($query);
                $stmt->bind_param('s', $id); 
                $stmt->execute();
                $disable = $stmt->get_result();
    }


}