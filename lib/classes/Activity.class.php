<?php
include_once("Db.class.php");
class activity {
    private $id;
    private $title;
    private $description;
    private $companyId;
    private $userCount;
    private $dates;
    private $students;
    /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of companyId
     */ 
    public function getCompanyId()
    {
        return $this->companyId;
    }

    /**
     * Set the value of companyId
     *
     * @return  self
     */ 
    public function setCompanyId($companyId)
    {
        $this->companyId = $companyId;

        return $this;
    }

    /**
     * Get the value of dates
     */ 
    public function getDates()
    {
        return $this->dates;
    }

    /**
     * Set the value of dates
     *
     * @return  self
     */ 
    public function setDates($dates)
    {
        $this->dates = $dates;

        return $this;
    }

    /**
     * Get the value of userCount
     */ 
    public function getUserCount()
    {
        return $this->userCount;
    }

    /**
     * Set the value of userCount
     *
     * @return  self
     */ 
    public function setUserCount($userCount)
    {
        $this->userCount = $userCount;

        return $this;
    }

    /**
     * Get the value of students
     */ 
    public function getStudents()
    {
        return $this->students;
    }

    /**
     * Set the value of students
     *
     * @return  self
     */ 
    public function setStudents($students)
    {
        $this->students = $students;

        return $this;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }


    public function createActivity(){
        $conn = Db::getInstance();
        $statement = $conn->prepare("INSERT INTO activities (`title`, `description`, `company_id`, `user_count`) VALUES (:title,:description,:companyId,:userCount)");
        $statement->bindValue(":title", $this->getTitle());
        $statement->bindValue(":description", $this->getDescription());
        $statement->bindValue(":userCount", $this->getUserCount()); 
        $statement->bindValue(":companyId", $this->getCompanyId());    
        $activity_upload = $statement->execute();
        $this->setId($conn->lastInsertId());
        $this->saveDates();
        return $activity_upload;
    }

    public function saveDates(){
        $conn = Db::getInstance();
        $dates = $this->getDates();
        foreach($dates as $key => $date){

            $statement = $conn->prepare("INSERT INTO `activity_date`(`date`, `activity_id`) VALUES (:date,:id)");
            $statement->bindValue(":id", $this->getId());
            $statement->bindValue(":date", $date);
            $activity_upload = $statement->execute();

        }
        return $activity_upload;
    }


    public static function getAllProducts(){
        $conn = Db::getInstance();
        $statement=$conn->prepare("SELECT * FROM products WHERE ended = 0 ORDER BY end_date ASC");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $key => $c){
            $result[$key]['prices'] = Product::getAllPrices($c['id']);
        }
        return $result;

    }  

    public static function getAllPrices($id){
        $conn = Db::getInstance();
        $statement=$conn->prepare("SELECT price,amount FROM prices WHERE product = :id");
        $statement->bindValue(":id", $id);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function getFilteredProducts($type){
        $products = Product::getAllProducts();
        $filteredProducts = [];

        foreach ($products as $key => $p) {
            if ($p['category'] === $type) {
                $filteredProducts[$key] = $p;
            }
        }
        return $filteredProducts;

    }  
    public static function getProduct($id){
        $conn = Db::getInstance();
        $statement=$conn->prepare("SELECT * FROM products WHERE id = :id");
        $statement->bindValue(":id", $id);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $key => $c){
            $result[$key]['prices'] = Product::getAllPrices($c['id']);
        }
        return $result;

    }  

    public static function newBuy($id){
        if(Product::checkBuy($id)){
            $conn = Db::getInstance();
            $statement = $conn->prepare("INSERT INTO buys (user, product) VALUES (:user,:id)");
            $statement->bindValue(":user", $_SESSION['user']);
            $statement->bindValue(":id", $id);
            $buy_new = $statement->execute();
            return $buy_new;
        }else{
            return false;
        }
    }

    public static function checkBuy($id){
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT * FROM buys WHERE user = :user AND product = :id");
        $statement->bindValue(":user", $_SESSION['user']);
        $statement->bindValue(":id", $id);
        $buy_new = $statement->execute();
        if($statement->rowCount()==0){
            return true;
        }
        else{
            return false;
        }
        
    }

}


?>