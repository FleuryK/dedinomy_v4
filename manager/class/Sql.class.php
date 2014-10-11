<?php
class Sql extends PDO
{
	protected static $_db;
	public static $_message=null;
	public static $_lastId=null;
	private static function initDB()
	{
		try
		{
			self::$_db = new PDO('mysql:host='.Server.';port='.Port.';dbname='.Base, User, Password, array(
				PDO::ATTR_PERSISTENT=>true,
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				)
			);
			self::$_db->exec('SET NAMES utf8');
			return true;
		}
		catch(PDOException $e)
		{
			self::$_db = false;
			self::$_message = '<strong>Erreur :</strong> '.$e->getMessage();
			return false;
		}
	}
	public static function getAll($req,$options=array())
	{
		if(self::initDB())
		{
			$data = self::$_db->prepare($req);
			if($data->execute())
			{
				$data = self::$_db->query($req);
				$data->setFetchMode(PDO::FETCH_OBJ);
				return $data->fetchAll();
			}
			else
			{

				$t1=$data->errorInfo();
				$t2=$t1[2];
				self::$_message=$t2;
				return false;
			}
		}
		return false;
	}
	public static function get($req,$options=array())
	{
		if(self::initDB())
		{
			$data = self::$_db->prepare($req);
			if($data->execute())
			{
				$data->setFetchMode(PDO::FETCH_OBJ);
				return $data->fetch();
			}
			else
			{
				$t1=$data->errorInfo();
				$t2=$t1[2];
				self::$_message=$t2;
				return false;
			}
		}
		else return false;
	}
	public static function update($req,$options=array())
	{
		if(self::initDB())
		{
			$data=self::$_db->prepare($req);
			if($data->execute())
			{
				return true;
			}
			else
			{
				$t1=$data->errorInfo();
				$t2=$t1[2];
				self::$_message=$t2;
				return false;
			}
		}
		else return false;
	}
	public static function delete($req,$options=array())
	{
		if(self::initDB())
		{
			$data=self::$_db->prepare($req);
			if($data->execute())
			{
				return true;
			}
			else
			{
				$t1=$data->errorInfo();
				$t2=$t1[2];
				self::$_message=$t2;
				return false;
			}
		}
		
	}
	public static function insert($req,$options=array())
	{
		if(self::initDB())
		{
			$data=self::$_db->prepare($req);
			if($data->execute())
			{
				self::$_lastId=self::$_db->lastInsertId();
				return true;
			}
			else
			{
				$t1=$data->errorInfo();
				$t2=$t1[2];
				self::$_message=$t2;
				return false;
			}
		}
		else return false;
	}
	public static function count($req,$options=array())
	{
		if(self::initDB())
		{
			$data=self::$_db->prepare($req);
			if($data->execute())
			{
				$return=$data->fetch(PDO::FETCH_NUM);
				return $return[0];
			}
			else
			{
				$t1=$data->errorInfo();
				$t2=$t1[2];
				self::$_message=$t2;
				return false;
			}
		}
		else return false;
	}
	public static function Pcount($table,$options)
	{
		if(self::initDB())
		{
			$data=self::$_db->prepare("SELECT count(*) FROM $table $options");
			if($data->execute())
			{
				$return=$data->fetch(PDO::FETCH_NUM);
				return $return[0];
			}
			else
			{
				$t1=$data->errorInfo();
				$t2=$t1[2];
				self::$_message=$t2;
				return false;
			}
		}
		else return false;
	}
}