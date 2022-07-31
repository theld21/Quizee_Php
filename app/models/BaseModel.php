<?php

namespace App\Models;

use PDO;

class BaseModel
{

	protected function getConnect()
	{
		$conn = new PDO('mysql:host=127.0.0.1;dbname=js;charset=utf8', 'root', '');
		return $conn;
	}

	// query
	public static function rawQuery($sqlQuery)
	{
		$model = new static();
		$model->queryBuilder = $sqlQuery;
		return $model;
	}

	public static function select($col)
	{
		$model = new static();
		$model->queryBuilder = "select $col from $model->tableName";

		return $model;
	}

	public function join($arr1, $arr2)
	{
		$this->queryBuilder .= " join $arr2[0] on $arr1[0].$arr1[1] = $arr2[0].$arr2[1]";
		return $this;
	}

	public function where($arr)
	{
		$this->queryBuilder .= " where $arr[0] $arr[1] '$arr[2]'";
		return $this;
	}

	public function andWhere($arr)
	{
		$this->queryBuilder .= " and $arr[0] $arr[1] '$arr[2]'";
		return $this;
	}
	public function orWhere($arr)
	{
		$this->queryBuilder .= " or $arr[0] $arr[1] '$arr[2]'";
		return $this;
	}

	public static function sttOrderBy($col, $asc = true)
	{
		$model =  new static();
		$model->queryBuilder = "select * from $model->tableName order by $col";
		$model->queryBuilder .= $asc == true ? " asc " : " desc ";

		return $model;
	}

	public function limit($take, $skip = false)
	{
		$this->queryBuilder .= " limit $take";
		if ($skip != false) {
			$this->queryBuilder .= ", $skip";
		}

		return $this;
	}
	// db
	public function execute()
	{
		$stmt = $this->getConnect()->prepare($this->queryBuilder);
		return $stmt->execute();
	}

	public function insert($arr)
	{
		$this->queryBuilder = "insert into $this->tableName ";
		$cols = " (";
		$vals = " (";
		foreach ($arr as $key => $value) {
			$cols .= " $key,";
			$vals .= " :$key,";
		}
		$cols = rtrim($cols, ',');
		$vals = rtrim($vals, ',');
		$cols .= ") ";
		$vals .= ") ";
		$this->queryBuilder .= $cols . ' values ' . $vals;
		$stmt = $this->getConnect()
			->prepare($this->queryBuilder);
		foreach ($arr as $key => &$value) {
			$stmt->bindParam(":$key", $value);
		}
		$stmt->execute();
		
	}

	public function update($arr)
	{
		$this->queryBuilder = "update $this->tableName set ";

		foreach ($arr as $key => $value) {
			$this->queryBuilder .= " $key = :$key,";
		}
		$this->queryBuilder = rtrim($this->queryBuilder, ',');
		$this->queryBuilder .= " where id = :id";
		$stmt = $this->getConnect()
			->prepare($this->queryBuilder);
		foreach ($arr as $key => &$value) {
			$stmt->bindParam(":$key", $value);
		}
		$stmt->bindParam(":id", $this->id);
		$stmt->execute();
	}

	public static function destroy($id)
	{
		$model = new static();
		$model->queryBuilder = "delete from $model->tableName where id = $id";

		$model->execute();
	}

	// get data
	public static function all()
	{
		$model = new static();
		$query = "select * from $model->tableName";
		$stmt = $model->getConnect()->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_CLASS, get_class($model));
	}

	public function first()
	{

		$stmt = $this->getConnect()->prepare($this->queryBuilder);
		var_dump($this->queryBuilder);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_CLASS, get_class($this));

		if (count($result) > 0) {
			return $result[0];
		} else {
			return null;
		}
	}
	
	public function get()
	{
		$stmt = $this->getConnect()->prepare($this->queryBuilder);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_CLASS, get_class($this));

		return $result;
	}

	//other
	public static function getCurentTime(){
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        return date('Y-m-d H:i:s');
    }
}
