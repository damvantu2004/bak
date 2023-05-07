<?php
require_once './Helper/Paginator.php';
class BaseModel extends Database
{

    protected $connect;

    public function __construct()
    {

        $this->connect = $this->connect();
    }

    //lấy ra tất cả dữ liệu trong bangr
    public function all($table, $select = ['*'], $orderBys = [], $limit = 15)
    {

        $column =  implode(',', $select);

        $orderByString = implode(' ', $orderBys);

        if ($orderByString) {
            $sql = "SELECT ${column} FROM $table ORDER BY $orderByString LIMIT $limit";
        } else {
            $sql = "SELECT ${column} FROM $table LIMIT $limit";
        }

        $query = $this->_query($sql);

        $data = [];

        while ($row = mysqli_fetch_assoc($query)) {
            array_push($data, $row);
        }
        return $data;
    }


    //lấy ra 1 dòng dữ liệu trong bảng
    public function find($table, $select = ['*'], $id)
    {
        $column =  implode(',', $select);

        $sql = "SELECT ${column} FROM $table WHERE id = ${id}";

        $query = $this->_query($sql);

        return mysqli_fetch_assoc($query);
    }

    public function getFirstByQuery($sql)
    {
        $query = $this->_query($sql);
        return mysqli_fetch_assoc($query);
    }
    //===
    public function getByQuery($sql)
    {

        $query = $this->_query($sql);
        $data = [];

        while (($row = mysqli_fetch_assoc($query))) {
            array_push($data, $row);
        }
        return $data;
    }

    public function create($table, $data = [])
    {
        $colums = implode(',', array_keys($data));

        $newValues = array_map(function ($value) {
            return "'" . $value . "'";
        }, array_values($data));

        $values = implode(',', $newValues);

        $sql = "INSERT INTO `${table}` (${colums}) VALUE (${values})";

        $this->_query($sql);

        return $this->getFirstByQuery("SELECT * FROM `${table}` order by id DESC LIMIT 1");
    }

    //cap nhat du lieu
    public function update($table, $id, $data)
    {

        $dataSets = [];

        foreach ($data as $key => $value) {
            array_push($dataSets, "${key} = '${value}'");
        }

        $dataSetString = implode(',', $dataSets);

        $sql = "UPDATE `${table}` SET ${dataSetString} WHERE id = ${id}";

        $this->_query($sql);
    }

    //delete du lieu
    public function delete($table, $id)
    {
        $sql = "DELETE FROM ${table} where  id = ${id}";

        $this->_query($sql);
    }

    public function _query($sql)
    {
        return mysqli_query($this->connect, $sql);
    }
    //pagination
    public function paginate($query)
    {
        $paginate = new Paginator($query);
        return $paginate;
    }
}
