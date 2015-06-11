<?php
include_once("class-Model.php");
include_once(BASE_PATH."/modules/class-Utils.php");
include_once(BASE_PATH."/modules/imageresize/ImageResize.php");

class AdministrableItem extends Model {
    
    public $id;
    public $itemtype;
    public $title;
    
    protected $requiresfolder = true;
    protected $uploadsfolder = "uploads";
    protected $targetfolder;
    
    const MAX_ITEM_IMAGE_WIDTH = 800;
    const MAX_ITEM_IMAGE_HEIGHT = 1024;
    const MAX_GALLERY_IMAGE_WIDTH = 1024;
    const MAX_GALLERY_IMAGE_HEIGHT = 1280;
    
    public function __construct($id = null, $tablename = null, $itemtype = null) {
        if(!empty($tablename)) {
            $this->tablename = $tablename;
        }
        if(!empty($itemtype)) {
            $this->itemtype = $itemtype;
        }
        parent::__construct();
        if(!empty($id) && !empty($tablename) && !empty($itemtype)) {
            $this->id = $id;
            $this->getById(true);
        }
    }
    
    protected function add($query, $queryParams) {
        if(empty($query) || empty($queryParams)) {
            return false;
        }
        //echo $query; var_dump($queryParams); exit;
        try {
            $this->conn->beginTransaction();
            $q = $this->conn->prepare($query);
            $q->execute($queryParams);
            $lastInsertedId = $this->conn->lastInsertId();
            if($lastInsertedId > 0) {
                $this->id = $lastInsertedId;
                if($this->requiresfolder) {
                    if($this->setTargetFolder()) {
                        if(is_dir($this->targetfolder)) {
                            Utils::deleteFolder($this->targetfolder);
                        }
                        if(!mkdir($this->targetfolder."/files", 0777, true)) {
                            $this->errors[] = "Folder could not be created";
                            $this->conn->rollBack();
                        } else {
                            mkdir($this->targetfolder."/gallery", 0777, true);
                        }
                    } else {
                        $this->errors[] = "Target folder failed to be created in the instance";
                        $this->conn->rollBack();
                    }
                }
                $this->conn->commit();
                return $this->id;
            } else {
                $this->errors[] = "The query returned 0 ID inserted";
            }
        } catch(PDOException $e) {
            $this->errors[] = $e->getMessage();
        }
        return false;
    }
    
    protected function update($query, $queryParams) {
        if(empty($this->id)) {
            $this->errors[] = "Object ID is not set. Cannot Update";
            return false;
        }
        
        //echo $query;exit; //DEBUG
        try {
            $q = $this->conn->prepare($query);
            /*
             *var_dump($query);
             *var_dump($queryParams); 
            //DEBUG
             */
            $executed = $q->execute($queryParams);
            if($q->rowCount() > 0 || $executed === true) {
                return true;
            } else {
                $this->errors[] = "The UPDATE query could not be executed";   
                //var_dump($this); exit; //DEBUG
            }
        } catch(PDOException $e) {
            $this->errors[] = $e->getMessage();
        }
        return false;
    }
    
    public function remove() {
        if(!empty($this->id)) {
            $this->setTargetFolder();
            $query = "DELETE FROM ".$this->tablename." WHERE id = ".$this->id;
            $del = $this->conn->prepare($query);
            $del->execute();
            if($del->rowCount() > 0) {
                if($this->requiresfolder) {
                    if(!Utils::deleteFolder($this->targetfolder)) {
                        $this->errors[] = "Folder ".$this->targetfolder." could not be deleted or does not exist";
                    }
                }
                return true;
            } else {
                $this->errors[] = "DELETE query could not be executed | Zero rows affected";
                return false;
            }
        } else {
            $this->errors[] = "Objet ID property is not set";
            return false;
        }
    }
    
    public function removeAll() {
        $query = "TRUNCATE TABLE ".$this->tablename;
        $foldersToDelete = $this->getAdministrableItemTypes();
        try {    
            if($this->conn->query($query)) {
                if($this->requiresfolder) {
                    foreach($foldersToDelete as $folderToDelete) {
                        $folder = "../".$this->uploadsfolder."/".$folderToDelete["title"]."/";
                        if(!Utils::deleteFolder($folder)) {
                            $this->errors[] = "Folder '".$folder."' could not be deleted or does not exist";
                        }
                    }
                }
                return true;
            } else {
                $this->errors[] = "Could not TRUNCATE ".$this->tablename.". Make sure permissions are set or the table exists";
                return false;
            }
        } catch(PDOException $e) {
            $this->errors[] = $e->getMessage();
        }
        return false;
    }
    
    //Fetches and Paginates results
    public function find($params = array()) {   
        $query = "SELECT SQL_CALC_FOUND_ROWS ".$this->tablename.".* FROM ".$this->tablename; 
                    

        if(!empty($params["orderby"])) {
            $query .= " ORDER BY ".$this->tablename.".".$params["orderby"];
        } else {
            $query .= " ORDER BY ".$this->tablename.".id DESC";
        }
        
        //For pagination
        if(!empty($params["limit"]) && !empty($params["set"])) {
            $set = ($params["set"] - 1) * $params["limit"];
            $query .= " LIMIT ".$set.", ".$params["limit"];
        }
        
        //echo $query; //exit; //DEBUG
        
        $q = $this->conn->prepare($query);
        if(!empty($params["search"])) {
            $q->bindValue(":search", $params["search"]);
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
    
    //Only works with children classes that have featured property
    protected function getFeatured($limit) {
        $query = "SELECT ".$this->tablename.".* FROM ".$this->tablename." 
                    WHERE featured = 1
                    ORDER BY ".$this->tablename.".id DESC LIMIT 0, ".$limit;
        $q = $this->conn->prepare($query);
		if($q->execute()) {
			$array = $q->fetchAll(PDO::FETCH_ASSOC);
			return $array;
		} else {
            $this->errors[] = "Could not execute the prepared query";
			return false;
		}
    }
    
    public function getLastAdded($limit) {
        $query = "SELECT * FROM ".$this->tablename."
                    ORDER BY id DESC LIMIT 0, ".$limit;
        $q = $this->conn->prepare($query);
        $q->execute();
        $result = $this->conn->query($query);
		if($result) {
			$array = $result->fetchAll(PDO::FETCH_ASSOC);
			return $array;
		} else {
            $this->errors[] = "Could not fetch items from the database";
			return false;
		}
	}
    
    public function getById($setProperties = false, $_query = "") {
        if(empty($this->id)) {
            return false;
        }
        if(empty($_query)) {
            $query = "SELECT * FROM ".$this->tablename." WHERE id = ".$this->id;
        } else {
            $query = $_query;
        }
        
        //echo $query; exit;
        $result = $this->conn->query($query);
        if($result) {
            $properties = $result->fetch(PDO::FETCH_ASSOC);
            if($setProperties) {
                if(!empty($properties)) {
                    $this->setItemProperties($properties);
                    return true;
                } else {
                    $this->errors[] = "Could not set Item Properties";
                }
            }
        } else {
            $this->errors[] = "Could not fetch item from the database";
        }
        if(!empty($properties)) {
            return $properties;
        } else {
            $this->errors[] = "Could not retrieve the properties from the database";
        }
        return false;
    }
    
    public function setMainImage($uploadedfile, $resize = false) {
        $tmpname = $uploadedfile["tmp_name"];
        $filename = $uploadedfile["name"];
		$filesize = $uploadedfile["size"];
        $destinationfolder = $this->targetfolder."/picture.".Utils::getFileExtension($filename);
        if(Utils::validateUpload($uploadedfile, IMAGE_MAX_SIZE, Utils::IMAGES)) {
            try {
                $existingPics = glob($this->targetfolder."/picture.*");
                if(!empty($existingPics)) {
                    foreach($existingPics as $fileToDelete) {
                        unlink($fileToDelete);
                    }
                }
                if(move_uploaded_file($tmpname, $destinationfolder)) {
 
                    /*
                     * Resizing and saving process
                     */
                    if($resize) {
                        $imageresize = new \Eventviva\ImageResize($destinationfolder);
                        if(($imageresize->getSourceWidth() > self::MAX_ITEM_IMAGE_WIDTH)) {
                            $imageresize->resizeToWidth(self::MAX_ITEM_IMAGE_WIDTH);
                        } 
                        if($imageresize->getSourceHeight() > self::MAX_ITEM_IMAGE_HEIGHT) {
                            $imageresize->resizeToHeight(self::MAX_ITEM_IMAGE_HEIGHT);
                        }
                        $imageresize->save($destinationfolder); //Saves main picture
                        $imageresize->resizeToWidth(300); //Resizes for thumbnails
                        $imageresize->save(str_replace("picture", "thumb", $destinationfolder)); //Saves as thumbnail
                        /*
                         * -- End Resizing and saving process
                         */
                    }
                    return true;
                } else {
                    $this->errors[] = "File could not be moved to ".$destinationfolder.". Check the target path";
                    return false;
                }
            } catch(Exception $e) {
                $this->erros[] = $e->getMessage();
                return false;
            }
        } else {
            $this->errors[] = "File could not be validated for the upload";
        }
        return false;
    }
    
    public function setImageGallery($uploadedimages, $resize = false) {
        try {
            for($i = 0; $i < count($uploadedimages["name"]); $i++) {
                $fileExtension = Utils::getFileExtension($uploadedimages["name"][$i]);
                $fileSize = $uploadedimages["size"][$i];
                if(Utils::extensionIsValid($fileExtension, Utils::IMAGES) && Utils::sizeIsValid($fileSize, IMAGE_MAX_SIZE)) {
                    $filename = $this->targetfolder."/gallery/".$uploadedimages["name"][$i];
                    move_uploaded_file($uploadedimages["tmp_name"][$i], $filename);
                    
                    /*
                     * -- Resizing process
                     */
                    if($resize) {
                        $imageresize = new \Eventviva\ImageResize($filename);
                        if($imageresize->getSourceWidth() > self::MAX_GALLERY_IMAGE_WIDTH) {
                            $imageresize->resizeToWidth(self::MAX_GALLERY_IMAGE_WIDTH);
                        }
                        if($imageresize->getSourceHeight() > self::MAX_GALLERY_IMAGE_HEIGHT) {
                            $imageresize->resizeToHeight(self::MAX_GALLERY_IMAGE_HEIGHT);
                        }
                        $imageresize->save($filename);
                    }
                    /*
                     * -- End Resizing and saving process
                     */
                }
            }
            return true;
        } catch(Exception $e) {
            $this->errors[] = $e->getMessage();
            return false;
        }
    }
    
    public function deleteImages($images) {
        if(!empty($images)) {
            foreach($images as $image) {
                if(!unlink($image)) {
                    $this->errors[] = "One or more images could not be deleted. Verify if file exist";
                }
            }
        }
    }
    
    public function getMainImage($id = null, $thumb = false) {
        if(empty($id) ) {
            if(!empty($this->id)) {
                $path = str_replace("..", BASE_PATH, $this->targetfolder);
                if($thumb) {
                    $pic = glob($path."/thumb.*");
                } else {
                    $pic = glob($path."/picture.*");
                }
                if(!empty($pic)) {
                    return str_replace(BASE_PATH, APP_URL, $pic[0]);
                } 
            } else {
                return false;
            }
        } else {
            $obj = new $this($id, $this->tablename, $this->itemtype);
            return $obj->getMainImage(null, $thumb);
        }
        return false;
    }
    
    public function getImageGallery($id = null, $absolutePath = false) {
        if(empty($id)) {
            $imagesArray = array();
            //echo $this->targetfolder; exit;
            foreach(glob($this->targetfolder."/gallery/*.*") as $filePath) {
                $extension = Utils::getFileExtension($filePath);
                if(Utils::extensionIsValid($extension, Utils::IMAGES)) {
                        if(!$absolutePath) {
                            $imagesArray[] = $filePath;
                        } else {
                            $imagesArray[] = str_replace("..", APP_URL, $filePath);
                        }
                }
            }
            if(empty($imagesArray)) {
                foreach(glob(str_replace("../", "", $this->targetfolder)."/gallery/*.*") as $filePath) {
                    $extension = Utils::getFileExtension($filePath);
                    if(Utils::extensionIsValid($extension, Utils::IMAGES)) {
                        if(!$absolutePath) {
                            $imagesArray[] = $filePath;
                        } else {
                            $imagesArray[] = APP_URL."/".$filePath;
                        }
                    }
                }
            }
            return $imagesArray;
        } else if(is_numeric($id)) {
            $obj = new $this($id, $this->tablename, $this->itemtype);
            return $obj->getImageGallery(null, $absolutePath);
        } else {
            return false;
        }
    }
    
    public function getFiles($id = null) {
        if(empty($id)) {
            $imagesArray = array();
            foreach(glob($this->targetfolder."/files/*.*") as $filePath) {
                $extension = Utils::getFileExtension($filePath);
                if(Utils::extensionIsValid($extension, Utils::GENERAL)) {
                    $imagesArray[] = $filePath;
                }
            }
            return $imagesArray;
        } else if(is_int($id)) {
            $obj = new $this($id, $this->tablename, $this->itemtype);
            return $obj->getFiles();
        } else {
            return false;
        }
    }
    
    public function setFiles($uploadedfiles) {
        try {
            for($i = 0; $i < count($uploadedfiles["name"]); $i++) {
                $fileExtension = Utils::getFileExtension($uploadedfiles["name"][$i]);
                $fileSize = $uploadedfiles["size"][$i];
                if(Utils::extensionIsValid($fileExtension, Utils::GENERAL) && Utils::sizeIsValid($fileSize, FILE_MAX_SIZE)) {
                    move_uploaded_file($uploadedfiles["tmp_name"][$i], $this->targetfolder."/files/".Utils::formatFileName(Utils::getFileNameWithOutExtension($uploadedfiles["name"][$i])).".".$fileExtension);
                }
                $this->errors[] = "One file could not be uploaded to the Files folder";
            }
        } catch(Exception $e) {
            return false;
        }
    }
    
    public function deleteFiles($files) {
        if(!empty($files)) {
            foreach($files as $file) {
                if(!unlink($file)) {
                    $this->errors[] = "One or more files could not be deleted. Verify if file exist";
                }
            }
        }
    }
    
    public function getAdministrableItemTypeName($itemid) {
        $content = file_get_contents(BASE_PATH."/admin/itemtypes.json");
        $arr = json_decode($content, true);
        return $arr[(string)$itemid];
    }
    
    protected function setTargetFolder() {
        if(!$this->requiresfolder) {
            return false;
        }
        if(!empty($this->itemtype) && !empty($this->id) && $this->getAdministrableItemTypeName($this->itemtype)) {
            $this->targetfolder = "../".$this->uploadsfolder."/".$this->getAdministrableItemTypeName($this->itemtype)."/".$this->id;
            return true;
        } else {
            $this->errors[] =  "Could not set target folder";
        }
        return false;
    }
    
    public function getTargetFolder() {
        if(!empty($this->itemtype) && !empty($this->id)) {
            return $this->targetfolder;
        } else {
            return false;
        }
    }
    
    protected function setItemProperties($properties) {
        try {
            foreach($properties as $property=>$value) {
                $this->$property = $value;
            }
            $this->setTargetFolder();
            return true;
        } catch(Exception $e) {
            $this->errors[] = $e->getMessage();
        }
        return false;
    }
    
}
