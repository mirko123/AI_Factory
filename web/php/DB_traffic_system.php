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
		$query = "DELETE FROM `traffic_system` WHERE id=:id";
		$statement = $this->db->connection->prepare($query);
		$statement->bindParam(":id",$id);
		$res = $statement->execute();
	}

	// public function getByLecture($lectureName)
	// {	
	// 	$query = "SELECT ids.id, ids.name, ids.lecture, ids.credits, lectures.department FROM ids INNER JOIN lectures ON lectures.username = ids.lecture  WHERE ids.lecture = :lecture";
	// 	$statement = $this->db->connection->prepare($query);
	// 	$statement->bindParam(":lecture",$lectureName);
	// 	$statement->execute();
	// 	$count = $statement->rowCount();

	// 	if($count != 0) return $statement->fetchAll(PDO::FETCH_ASSOC);
	// 	return array();
	// }

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

	public function add($name, $systemId, $discription)
	{	
		$query = "INSERT INTO `platna` (name, systemId, discription) VALUES (:name, :systemId, :discription)";
		$statement = $this->db->connection->prepare($query);
		$statement->bindParam(":name",$name);
		$statement->bindParam(":systemId",$systemId);
		$statement->bindParam(":discription",$discription);
		$res = $statement->execute();
		return $res;
	}

	public function remove($id)
	{
		$query = "DELETE FROM `platna` WHERE id=:id";
		$statement = $this->db->connection->prepare($query);
		$statement->bindParam(":id",$id);
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

class DBLenti
{
	protected $db;
	function __construct()
	{
		require_once("DB.php");
		$this->db = DB::getInstance();;
	}

	public function add($name, $platnoId, $direction)
	{	
		$query = "INSERT INTO `lenti` (name, platnoId, direction) VALUES (:name, :platnoId, :direction)";
		$statement = $this->db->connection->prepare($query);
		$statement->bindParam(":name",$name);
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






