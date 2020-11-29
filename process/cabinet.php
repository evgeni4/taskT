<?php


class cabinet
{
    private $conn;
    /**
     * @var int
     */
    public $floor_id;
    /**
     * @var string
     */
    public $title;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function createCabinet()
    {
        $query = 'INSERT INTO cabinet SET floor_id = :floor_id,title = :title';
        $stmt = $this->conn->prepare($query);
        $this->floor_id = htmlspecialchars(strip_tags($this->floor_id));
        $this->title = htmlspecialchars(strip_tags($this->title));
        $stmt->bindParam(':floor_id', $this->floor_id);
        $stmt->bindParam(':title', $this->title);
        if ($stmt->execute()) {
            return true;
        }
        printf("Error %s\n", $stmt->error);
        return false;
    }

    public function readCabinet()
    {
        $query = ' SELECT 
                     c.id, 
                      c.floor_id,
                      c.title,
                      f.id as floorId,
                      f.name
                  FROM cabinet as c
                  INNER JOIN floor as f on c.floor_id = f.id 
                  ';
        $em = $this->conn->prepare($query);
        $em->execute();
        return $em;
    }

    public function allCabinet(){
        $cabinet_arr = array();
        $resultCabinet = $this->readCabinet();
        $row = $resultCabinet->rowCount();
        if ($row > 0) {
            while ($row = $resultCabinet->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $cabinet_item = array(
                    'id' => $id,
                    'name' => $name,
                    'title' => $title
                );
                array_push($cabinet_arr, $cabinet_item);
            }
        }
        return $cabinet_arr;
    }
}