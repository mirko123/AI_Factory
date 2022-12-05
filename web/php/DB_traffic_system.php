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
		$dbPlatna = new DBPlatna();
		$dbPlatna->removeBySystemId($id);

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




class DBPlatna
{
	protected $db;
	function __construct()
	{
		require_once("DB.php");
		$this->db = DB::getInstance();;
	}

	public function add($systemId, $discription)
	{	
		$query = "INSERT INTO `platna` (systemId, discription) VALUES (:systemId, :discription)";
		$statement = $this->db->connection->prepare($query);
		$statement->bindParam(":systemId",$systemId);
		$statement->bindParam(":discription",$discription);
		$res = $statement->execute();
		return $res;
	}

	public function remove($id)
	{
		$dbLanes = new DBLanes();
		$dbLanes->removeByPlatnoId($id);

		$query = "DELETE FROM `platna` WHERE id=:id";
		$statement = $this->db->connection->prepare($query);
		$statement->bindParam(":id",$id);
		$res = $statement->execute();
	}

	public function removeBySystemId($systemId)
	{

		$platna = $this->getBySystem($systemId);
		foreach ($platna as $key => $platno) {
			$platnoId = $platno["id"];
			$dbLanes = new DBLanes();
			$dbLanes->removeByPlatnoId($platnoId);
		}

		$query = "DELETE FROM `platna` WHERE systemId=:systemId";
		$statement = $this->db->connection->prepare($query);
		$statement->bindParam(":systemId",$systemId);
		$res = $statement->execute();
	}

	public function getBySystem($systemId)
	{	
		$query = "SELECT platna.id, platna.systemId, platna.discription FROM platna WHERE platna.systemId = :systemId";
		$statement = $this->db->connection->prepare($query);
		$statement->bindParam(":systemId",$systemId);
		$statement->execute();
		$count = $statement->rowCount();
		if($count != 0) return $statement->fetchAll(PDO::FETCH_ASSOC);
		return array();
	}

	public function getAll()
	{	
		$query = "SELECT platna.id, platna.systemId, platna.discription FROM platna";
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

	public function add($platnoId, $direction)
	{	
		$query = "INSERT INTO `lenti` (platnoId, direction) VALUES (:platnoId, :direction)";
		$statement = $this->db->connection->prepare($query);
		$statement->bindParam(":platnoId",$platnoId);
		$statement->bindParam(":direction",$direction);
		$res = $statement->execute();
		return $res;
	}

	public function remove($id)
	{
		$query = "DELETE FROM `lenti` WHERE id=:id";
		$statement = $this->db->connection->prepare($query);
		$statement->bindParam(":id",$id);
		$res = $statement->execute();
	}

	public function removeByPlatnoId($platnoId)
	{
		$query = "DELETE FROM `lenti` WHERE lenti.platnoId=:platnoId";
		$statement = $this->db->connection->prepare($query);
		$statement->bindParam(":platnoId",$platnoId);
		$res = $statement->execute();
	}


	public function getByPlatnoId($platnoId)
	{	
		$query = "SELECT lenti.id, lenti.platnoId, lenti.direction FROM lenti WHERE lenti.platnoId = :platnoId";
		$statement = $this->db->connection->prepare($query);
		$statement->bindParam(":platnoId",$platnoId);
		$statement->execute();
		$count = $statement->rowCount();

		if($count != 0) return $statement->fetchAll(PDO::FETCH_ASSOC);
		return array();
	}

	public function getAll()
	{	
		$query = "SELECT lenti.id, lenti.platnoId, lenti.direction FROM lenti";
		$statement = $this->db->connection->prepare($query);
		$statement->execute();
		$count = $statement->rowCount();

		if($count != 0) return $statement->fetchAll(PDO::FETCH_ASSOC);
		return array();
	}
}

 ?>






