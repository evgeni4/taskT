<?php


class floor
{
    private $conn;
    /**
     * @var string
     */
    public $name;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function createFloor()
    {
        $query = 'INSERT INTO floor SET name = :name';
        $stmt = $this->conn->prepare($query);
        $this->name = htmlspecialchars(strip_tags($this->name));
        $stmt->bindParam(':name', $this->name);
        if ($stmt->execute()) {
            return true;
        }
        printf("Error %s\n", $stmt->error);
        return false;
    }
    public function readFloor()
    {
        $query = 'SELECT  id, name FROM floor';
        $em = $this->conn->prepare($query);
        $em->execute();
        return $em;
    }
    public function allFloor(){
        $result = $this->readFloor();
        $num = $result->rowCount();
        $floor_arr = array();
        if ($num > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $floor_item = array(
                    'id' => $id,
                    'name' => $name
                );
                array_push($floor_arr, $floor_item);
            }
        }
        return $floor_arr;
    }
}