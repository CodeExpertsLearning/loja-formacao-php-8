<?php 
namespace Database;

class Query
{
    protected $table = '';

    protected $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function insert(array $data = [])
    {
        $fields = implode(', ', array_keys($data));
        $binds  = ':'. implode(', :', array_keys($data));

        $sql  = 'INSERT INTO ' . $this->table . '(' . $fields . ', created_at, updated_at)';
        $sql .= ' VALUES(' . $binds . ', NOW(), NOW())';

        $this->execute($sql, $data);

        return $this->connection->lastInsertId();
    }

    public function getAll($fields = '*')
    {
        $sql = 'SELECT ' . $fields . ' FROM ' . $this->table;

        $result = $this->execute($sql);

        return $result->fetchAll(\PDO::FETCH_OBJ);
    }

    public function where(array $conditions = [], $fields = '*')
    {
        $sql = 'SELECT ' . $fields . ' FROM ' . $this->table . ' WHERE ';

        $where = '';

        foreach($conditions as $key => $cond) {
            if($where) {
                $where .= ' AND ' . $key . ' = ' . ':' . $key;
            } else {
                $where .= $key . ' = ' . ':' . $key;
            }
            
        }

        $sql =  $sql . $where;
        
        $result = $this->execute($sql, $conditions);

        return $result->fetchAll(\PDO::FETCH_OBJ);
    }

    public function find(int $id)
    {
        $result = $this->where(['id' => $id]);

        return current($result);
    }

    private function execute($querySql, array $data = [])
    {
        $pdoExecute = $this->connection->prepare($querySql);
        
        foreach($data  as $key => $value) {
            $pdoExecute->bindValue(':' . $key, $value, 
            gettype($value) != 'integer' ? \PDO::PARAM_STR : \PDO::PARAM_INT );
        }

        $pdoExecute->execute();

        return $pdoExecute;
    }
}
