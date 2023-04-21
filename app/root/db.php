<?php
namespace taladashvili\root;

class Database
{
  private $host = '127.0.0.1';
  private $db = 'admini'; 
  private $username = 'admini';
  private $password = 'admini';

  private $server;
  private $options = array(
      \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION, \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
      \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
  );
  protected $conn;

  public $safe;

  private $opened;

  public function __construct()
  {
    $this->server = "mysql:host=" . $this->host . ";dbname=" . $this->db . "; charset=utf8";
    $this->safe = true;
    $this->opened = false;
  }
  public function open()
  {

    if (!isset($this->conn) || empty($this->conn)) {
      try {
        $this->conn = new \PDO($this->server, $this->username, $this->password, $this->options);
        $this->conn->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        $this->conn->exec("set names utf8mb4");
        return $this->conn;
      } catch (\PDOException $e) {
        echo "There is some problem in connection: " . $e->getMessage();
      }
    }


  }

  public function close()
  {
    if ($this->safe == true) {
      $this->conn = null;
    }

  }


  public function SQL($sql, $array, $fetchall)
  {
    self::open();
    $conn = $this->conn;

    $output = null;
    try {
      $stmt = $conn->prepare($sql);
      $stmt->execute($array);
      if ($fetchall) {
        $output = $stmt->fetchAll();
      } else {
        $output = $stmt->fetch();
      }

    } catch (\PDOException $e) {
      $output = ['error' => $e->getMessage()];
    }
    self::close();

    return $output;
  }
  public function SQL_insert($sql, $array)
  {
    self::open();
    $conn = $this->conn;

    $output = null;
    try {
      $stmt = $conn->prepare($sql);

      if ($this->safe != true)
        $conn->beginTransaction();

      $stmt->execute($array);
      $output = $conn->lastInsertId();
      self::commit();

    } catch (\PDOException $e) {
      $output = ['error' => $e->getMessage()];
    }

    self::close();

    return $output;
  }

  public function UPDATE($sql, $array)
  {
    self::open();
    $conn = $this->conn;

    $output = null;
    try {
      $stmt = $conn->prepare($sql);
      $stmt->execute($array);
      self::commit();
    } catch (\PDOException $e) {
      $output = ['error' => $e->getMessage()];
    }

    $this->close();

    return $output;
  }

  public function Existed($table_name, $column_name, $cell_value)
  {
    if (empty($table_name))
      return ['error' => 'table_name is empty'];

    if (empty($column_name))
      return ['error' => 'column_name is empty'];

    if (empty($cell_value))
      return ['error' => 'cell_value is empty'];

    $sql = "select EXISTS(select * from $table_name WHERE $column_name = :cell) as resoult";
    $array = ['cell' => $cell_value];
    self::open();
    $conn = $this->conn;

    $output = null;
    try {
      $stmt = $conn->prepare($sql);
      $stmt->execute($array);
      $output = $stmt->fetch();

    } catch (\PDOException $e) {
      $output = ['error' => $e->getMessage()];
      return $output;
    }
    self::close();

    if (empty($output['resoult']))
      return ['resoult' => false];
    else
      return ['resoult' => true];
  }

  public function commit()
  {
    if ($this->safe == true) {
      try {
        $this->conn->commit();
      } catch (\Throwable $th) {
      }
    }
  }

  public function commit_manual()
  {

    try {
      $this->conn->commit();
    } catch (\Throwable $th) {
      return ['error' => $th];
    }
  }

  public function rollback_manual()
  {
    try {
      $this->conn->rollBack();
    } catch (\Throwable $th) {
      return ['error' => $th];
    }
  }

}