<?php
include_once("class-AdministrableItem.php");

class Admin extends AdministrableItem {
	
    public $id;
    public $username;
    public $permissionid;
    public $password;
    public $name;
    public $lastname;
    public $email;
    public $phonenumber;
    public $cellphonenumber;
    public $info;
    public $active;
    
    public function __construct($id = null, $tablename = "admins", $itemtype = ITEM_TYPE_ADMIN) {
        $this->requiresfolder = false;
        parent::__construct($id, $tablename, $itemtype);
    }
    
    public function add($query = "", $queryParams = []) {
        if($this->adminExists($this->username)) {
            $this->errors[] = "User already exists";
            return false;
        }
        if(empty($query)) {
            $query = "INSERT INTO ".$this->tablename. " VALUES (
                        null, :username, :password, :permissionid, :name, :lastname,
                        :email, :phonenumber, :cellphonenumber, :info, :active)";
        }
        if(empty($queryParams)) {
        $queryParams = [":username"=>$this->username, ":password"=>$this->password, ":permissionid"=>$this->permissionid, 
                        ":name"=>$this->name, ":lastname"=>$this->lastname, ":email"=>$this->email, 
                        ":phonenumber"=>$this->phonenumber, ":cellphonenumber"=>$this->cellphonenumber, 
                        ":info"=>$this->info, ":active"=>$this->active];
        }
        return parent::add($query, $queryParams);
    }
	
	public function update($query = "", $queryParams = []) {
        if(empty($this->id)) {
            return false;
        }
        if(empty($queryParams)) {
            $queryParams = [":email"=>$this->email, ":phonenumber"=>$this->phonenumber,
                            ":cellphonenumber"=>$this->cellphonenumber, ":active"=>$this->active];
        }
        if(empty($query)) {
            $query = "UPDATE ".$this->tablename. " SET ";
            if(!empty($this->password)) {
                $query .= "password = '".$this->password."', ";
            }        
            
            //If permission id is set, it's because it can be changed, therefore,
            //the admin being modified is not the default admin.
            if(!empty($this->permissionid)) {
                $query .= " permissionid = :permissionid,
                            name = :name,
                            lastname = :lastname,
                            info = :info,";
                $queryParams = $queryParams + [":permissionid"=>$this->permissionid, 
                                                ":name"=>$this->name,
                                                ":lastname"=>$this->lastname, 
                                                ":info"=>$this->info];
            }
            $query .= " email = :email,
                        phonenumber = :phonenumber,
                        cellphonenumber = :cellphonenumber,
                        active = :active
                        WHERE id = ".$this->id;
        }
        //echo $query; var_dump($queryParams);exit;
        return parent::update($query, $queryParams);
	}
    
    public function find($params = []) {
        /*
         * -- BASE QUERY
         */
        $query = "SELECT * FROM ".$this->tablename;
        //echo $query; exit; //DEBUG
        
        /*
         *  -- CONDITIONS
         */
        
        //SEARCH ALGORITHM
        if(isset($params["search"])) {
            $query .= " WHERE username LIKE :search OR
                        firstname LIKE :search OR
                        lastname LIKE :search OR
                        email LIKE :search OR
                        info LIKE :search"; 
            $whereused = true;
        }
        
        //Returning inactive or active items
        if(!empty($params["activeonly"])) {
            if(!$whereused) {
                $query .= " WHERE active = 1"; 
            } else if($whereused) {
                $query .= " AND ctive = 1"; 
            }
        } else if(!empty($params["inactiveonly"])) {
            if(!$whereused) {
                $query .= " WHERE active = 0"; 
            } else if($whereused) {
                $query .= " AND active = 0"; 
            }
        } // ELSE Return both anyway
        //echo $query; exit; //DEBUG

        //For pagination
        if(!empty($params["limit"]) && !empty($params["set"])) {
            $set = ($params["set"] - 1) * $params["limit"];
            $query .= " LIMIT ".$set.", ".$params["limit"];
        }
        //var_dump($params);
        //echo $query; exit; //DEBUG
        /*
         *  -- END OF QUERY ALGORITHM
         */
        
        $q = $this->conn->prepare($query);
        if(isset($params["search"])) {
            $q->bindValue(":search", "'%".$params["search"]."%'");
        }
		if($q->execute()) {
			$array = $q->fetchAll(PDO::FETCH_ASSOC);
            if(!empty($params["returnCount"])) {
                $countQuery = "SELECT FOUND_ROWS()";
                $theCount = $this->conn->query($countQuery)->fetch(PDO::FETCH_COLUMN);
                $array["totalCount"] = $theCount;
            }
			return $array;
		} else {
            $this->errors[] = "Could not execute the prepared query";
			return false;
		}
	}
    
    public function validateAdminSession() {
        if(!isset($_SESSION["admininfo"]) || $_SESSION["sessionid"] !== session_id()) {
            session_destroy();
        } else {
            return true;
        }
    }
    
    public function login($username, $password) {
        try {
            $query = $this->conn->prepare("SELECT id, permissionid, username, name, lastname, email, info, phonenumber, cellphonenumber FROM ".$this->tablename." WHERE 
                                            username = :user AND password = :pass AND active = 1");	
            $query->bindValue(":user", $username);
            $query->bindValue(":pass", md5($password));
            $query->execute();
            if($query->rowCount() > 0) {
                return $query->fetch(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
        } catch(PDOException $e) {
            $this->errors[] = $e->getMessage();
            return false;
        }
	}

    public function logout() {
        unset($_SESSION["admininfo"]);
    }
    
    public function adminExists($username = null) {
        if(empty($username)) {
            $username = $this->username;
        }
        $query = "SELECT COUNT(*) FROM ".$this->tablename." WHERE username = '".$username."'";
        $result = $this->conn->query($query);
        if($result->fetchColumn() > 0) {
            return true;
        }
        return false;
    }
    
    public function isActive() {
        $id = $this->id;
        $query = "SELECT active FROM ".$this->tablename." WHERE id = ".$id;
        $result = $this->conn->query($query);
        $arr = $result->fetch(PDO::FETCH_ASSOC);
        if((int)$arr["active"] == 1) {
            return true;
        } else {
            return false;
        }
    }
    
    public function isLogedIn() {
        if(empty($this->id)) {
            return false;
        }
        if(isset($_SESSION["admininfo"]) && $_SESSION["admininfo"]["id"] == $this->id) {
            return true;
        } else {
            return false;
        }
    }
    
    public function getLogedAdminInfo() {
        if(!empty($_SESSION["admininfo"])) {
            $this->id = $_SESSION["admininfo"]["id"];
            return $this->getById();
        }
        return false;
    }
    
    public function getAdminEmails() {
        $json = "../admin/emailconfig.json";
        if(is_file($json)) {
            $json = file_get_contents($json);
            $data = json_decode($json, true);
            return $data;
        } else {
            return false;
        }
    }
    
    public function getPermissions() {
        $json = file_get_contents(BASE_PATH."/admin/permissions.json");
        $arr = json_decode($json, true);
        return $arr;
    }
    
    public function getPermission($id) {
        $arr = $this->getPermissions();
        return $arr[$id];
    }
    
    public function getPermissionName($id) {
        $arr = $this->getPermissions();
        return $arr[$id]["title"];
    }
    
    public function getPermissionDescription($id) {
        $arr = $this->getPermissions();
        return $arr[$id]["desc"];
    }
	
}