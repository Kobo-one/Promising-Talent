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
        $images = ["img/advocaat.jpg", "img/bakker.jpg", "img/code.jpg", "img/dokter.jpg","img/chefkok.jpg", "img/prof.jpg" , "img/tellen.jpg"];
        $images[array_rand($images)];
        $conn = Db::getInstance();
        $statement = $conn->prepare("INSERT INTO activities (`title`, `description`, `company_id`, `user_count`, `img`) VALUES (:title,:description,:companyId,:userCount, :img)");
        $statement->bindValue(":title", $this->getTitle());
        $statement->bindValue(":description", $this->getDescription());
        $statement->bindValue(":userCount", $this->getUserCount()); 
        $statement->bindValue(":companyId", $this->getCompanyId());
        $statement->bindValue(":img", $images[1]);        
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


    public static function getAllActivities(){
        $conn = Db::getInstance();
        $statement=$conn->prepare("SELECT * FROM activities ORDER BY id DESC");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($result as $key => $c){
            $dates = Activity::getAllDates($c['id']);
            $result[$key]['dates'] = $dates;
            
            foreach($dates as $dkey => $d){
                $result[$key]['student'] = Activity::getActivityStudent($d["id"]);
           }
        }
        
        
        return $result;

    }  

    public static function getAllDates($id){
        $conn = Db::getInstance();
        $statement=$conn->prepare("SELECT * FROM activity_date WHERE activity_id = :id");
        $statement->bindValue(":id", $id);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        

        return $result;
    }

    public static function getActivityStudent($id){
        $conn = Db::getInstance();
        $statement=$conn->prepare("SELECT * FROM student_activity WHERE activity_date_id = :id");
        $statement->bindValue(":id", $id);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }



}


?>