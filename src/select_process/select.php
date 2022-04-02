<?php

class Select{

  private $db;
  public $fetch;
  public $count;

  private function conn_db() {
    $conn = new db_connection();
    $this->db = $conn->connect();
    return $this->db;
  }

  /**
   * @param string $table_name Compulsory - Table which contains data to be received.
   * @param string $column_name Optional - Column name to be retrieved. Default value: NULL.
   * @param mixed $column_value Optional - The value of the column to be received. Default value: NULL.
   * @param int $limit_value Optional - Data limit to be received in total. Default value: NULL.
   * @return array $this-fetch - Stores data which fetched from database.
   * @return int $this-fetch - Stores lenght of data which fetched from database.
   */
  public function select($table_name, $column_name = NULL, $column_value = NULL, $limit_value = NULL){
    
    /** @var bool $receive_all_table Stores true if the entire table is to be fetched. */
    $receive_all_table = false;

    /** @var bool $receive_all_table_limited Stores true if the entire table is to be fetched with limited number of times. */
    $receive_all_table_limited = false;

    /** @var bool $receive_particular_column Stores true if the particular row/rows to be fetched. */
    $receive_particular_column = false;

    /** @var bool $receive_particular_column_limited Stores true if the particular row/rows to be fetched with limited number of times. */
    $receive_particular_column_limited = false;

    /** @var string $query_string Query syntax will be prepared with respect to above parameters. */
    $query_string = "";

    /** @var bool $fetching_process The variable that will stop the process when there is a problem in the process. */
    $fetching_process = true;
    
    /** @var $db Database connection */
    $db = $this->conn_db();

    if ($column_name != NULL && $column_value != NULL) {
      if ($limit_value != NULL) {
        $receive_particular_column_limited = true;
      } else {
        $receive_particular_column = true;
      }
    } else {
      if ($limit_value != NULL) {
        $receive_all_table_limited = true;
      } else {
        $receive_all_table = true;
      }
    }

    if ($receive_all_table) {
      $query_string = "SELECT * FROM {$table_name}";
    }
    else if ($receive_all_table_limited) {
      $query_string = "SELECT * FROM {$table_name} LIMIT {$limit_value}";
    }
    else if ($receive_particular_column) {
      $query_string = "SELECT * FROM {$table_name} WHERE {$column_name} = '$column_value'";
    }
    else if ($receive_particular_column_limited) {
      $query_string = "SELECT * FROM {$table_name} WHERE {$column_name} = '$column_value' LIMIT {$limit_value}";
    } else {
      $fetching_process = false;
    }

    if ($fetching_process) {
      $query = $db->query($query_string, PDO::FETCH_ASSOC);

      $this->count = 0;
      $this->fetch = array();

      foreach ($query as $row) {
          $this->fetch[$this->count] = $row;
          $this->count++;
      }

      $this->fetch_json = json_encode($this->fetch);

    }
  }


  /**
   * @param string $table_name Compulsory - Table which contains data to be received.
   * @param string $first_column_name Compulsory - Name of the first column to pull data from.
   * @param string $second_column_name Compulsory - Name of the second column to pull data from.
   * @param mixed $first_column_value - Compulsory - The value of the value sought in the first column from which the data will be drawn.
   * @param mixed $second_column_value - Compulsory - The value of the value sought in the second column from which the data will be drawn.
   * @return bool When there is a data in data table it returns true, if not it returns false.
   */
  public function select_with_two_params($table_name, $first_column_name, $second_column_name, $first_column_value, $second_column_value){
      
      /** @var $db Database connection */
      $db = $this->conn_db();
      $query_string = "SELECT * FROM {$table_name} WHERE {$first_column_name} = '$first_column_value' AND {$second_column_name} = '$second_column_value'";
      
      $query = $db->query($query_string, PDO::FETCH_ASSOC);

      $this->count = 0;
      $this->fetch = array();

      foreach ($query as $row) {
        $this->fetch[$this->count] = $row;
        $this->count++;
      }

      if ($this->count != 0) {
        return true;
      } else {
        return false;
      }
  }

}
?>
