<?php


class worker
{
    private $conn;

    public $name;

    public $cabinet_id;


    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function createWorker()
    {
        $query = 'INSERT INTO worker SET  cabinet_id = :cabinet_id,name = :name';
        $stmt = $this->conn->prepare($query);
        $this->cabinet_id = htmlspecialchars(strip_tags($this->cabinet_id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $stmt->bindParam(':cabinet_id', $this->cabinet_id);
        $stmt->bindParam(':name', $this->name);
        if ($stmt->execute()) {
            return true;
        }
        printf("Error %s\n", $stmt->error);
        return false;
    }
    public function readWorker()
    {
        $query = ' SELECT 
                      w.id, 
                      w.cabinet_id,
                      w.name,
                      c.id as cabinetId,
                      c.title,
                      c.floor_id,
                      f.id as floorId,
                      f.name as floor
                  FROM worker as w 
                  INNER JOIN cabinet as c on w.cabinet_id = c.id  
                  INNER JOIN floor as f on c.floor_id = f.id 
                  ';
        $em = $this->conn->prepare($query);
        $em->execute();
        return $em;
    }
    public function allWorker()
    {
        $resultWorker = $this->readWorker();
        $row = $resultWorker->rowCount();
        $worker_arr = array();
        if ($row > 0) {
            while ($row = $resultWorker->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $worker_item = array(
                    'id' => $id,
                    'name' => $name,
                    'title' => $title
                );
                array_push($worker_arr, $worker_item);
            }
        }
        return $worker_arr;
    }
}