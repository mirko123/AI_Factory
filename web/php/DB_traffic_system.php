<?php 

require_once("DB.php");

class DBTrafficSystem
{
	protected $db;

	function __construct()
	{
		require_once("DB.php");
		$this->db = DB::getInstance();;
	}

	public function add($name)
	{	
		$query = "INSERT INTO `traffic_system` (name) VALUES (:name)";
		$statement = $this->db->connection->prepare($query);
		$statement->bindParam(":name",$name);
		$res = $statement->execute();
		return $res;
	}

	public function remove($id)
	{
		$dbRoadway = new DBRoadway();
		$dbRoadway->removeBySystemId($id);

		$query = "DELETE FROM `traffic_system` WHERE id=:id";
		$statement = $this->db->connection->prepare($query);
		$statement->bindParam(":id",$id);
		$res = $statement->execute();
	}

	public function getAll()
	{	
		// $query = "SELECT `(:tableName)`.id, `(:tableName)`.name FROM `(:tableName)`";
		$query = "SELECT traffic_system.id, traffic_system.name FROM traffic_system";
		$statement = $this->db->connection->prepare($query);
		// $statement->bindParam(":tableName",$tableName);
		$statement->execute();
		$count = $statement->rowCount();

		if($count != 0) return $statement->fetchAll(PDO::FETCH_ASSOC);
		return array();
	}
}




class DBRoadway
{
	protected $db;
	function __construct()
	{
		require_once("DB.php");
		$this->db = DB::getInstance();;
	}

	public function add($systemId, $discription)
	{	
		$query = "INSERT INTO `roadways` (systemId, discription) VALUES (:systemId, :discription)";
		$statement = $this->db->connection->prepare($query);
		$statement->bindParam(":systemId",$systemId);
		$statement->bindParam(":discription",$discription);
		$res = $statement->execute();
		return $res;
	}

	public function remove($id)
	{
		$dbLanes = new DBLanes();
		$dbLanes->removeByRoadwayId($id);

		$query = "DELETE FROM `roadways` WHERE id=:id";
		$statement = $this->db->connection->prepare($query);
		$statement->bindParam(":id",$id);
		$res = $statement->execute();
	}

	public function removeBySystemId($systemId)
	{

		$roadways = $this->getBySystemId($systemId);
		foreach ($roadways as $key => $roadway) {
			$roadwayId = $roadway["id"];
			$dbLanes = new DBLanes();
			$dbLanes->removeByRoadwayId($roadwayId);
		}

		$query = "DELETE FROM `roadways` WHERE systemId=:systemId";
		$statement = $this->db->connection->prepare($query);
		$statement->bindParam(":systemId",$systemId);
		$res = $statement->execute();
	}

	public function getBySystemId($systemId)
	{	
		$query = "SELECT roadways.id, roadways.systemId, roadways.discription FROM roadways WHERE roadways.systemId = :systemId";
		$statement = $this->db->connection->prepare($query);
		$statement->bindParam(":systemId",$systemId);
		$statement->execute();
		$count = $statement->rowCount();
		if($count != 0) return $statement->fetchAll(PDO::FETCH_ASSOC);
		return array();
	}

	public function getAll()
	{	
		$query = "SELECT roadways.id, roadways.systemId, roadways.discription FROM roadways";
		$statement = $this->db->connection->prepare($query);
		$statement->execute();
		$count = $statement->rowCount();

		if($count != 0) return $statement->fetchAll(PDO::FETCH_ASSOC);
		return array();
	}
}

class DBLanes
{
	protected $db;
	function __construct()
	{
		require_once("DB.php");
		$this->db = DB::getInstance();;
	}

	public function add($roadwayId, $direction)
	{	
		$query = "INSERT INTO `lanes` (roadwayId, direction) VALUES (:roadwayId, :direction)";
		$statement = $this->db->connection->prepare($query);
		$statement->bindParam(":roadwayId",$roadwayId);
		$statement->bindParam(":direction",$direction);
		$res = $statement->execute();
		return $res;
	}

	public function remove($id)
	{
		$query = "DELETE FROM `lanes` WHERE id=:id";
		$statement = $this->db->connection->prepare($query);
		$statement->bindParam(":id",$id);
		$res = $statement->execute();
	}

	public function removeByRoadwayId($roadwayId)
	{
		$query = "DELETE FROM `lanes` WHERE lanes.roadwayId=:roadwayId";
		$statement = $this->db->connection->prepare($query);
		$statement->bindParam(":roadwayId",$roadwayId);
		$res = $statement->execute();
	}


	public function getByRoadwayId($roadwayId)
	{	
		$query = "SELECT lanes.id, lanes.roadwayId, lanes.direction FROM lanes WHERE lanes.roadwayId = :roadwayId";
		$statement = $this->db->connection->prepare($query);
		$statement->bindParam(":roadwayId",$roadwayId);
		$statement->execute();
		$count = $statement->rowCount();

		if($count != 0) return $statement->fetchAll(PDO::FETCH_ASSOC);
		return array();
	}

	public function getAll()
	{	
		$query = "SELECT lanes.id, lanes.roadwayId, lanes.direction FROM lanes";
		$statement = $this->db->connection->prepare($query);
		$statement->execute();
		$count = $statement->rowCount();

		if($count != 0) return $statement->fetchAll(PDO::FETCH_ASSOC);
		return array();
	}
}

 ?>






