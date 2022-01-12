<?php

namespace App\Database;

class QueryBuilder
{
    private $selectables = [];
    private $table;
    private $whereClause;
    private $limit;
    protected $pdo;

    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    function selectAll($table)
    {
        $statement = $this->pdo->prepare("select * from {$table}");
        $statement->execute();
        //return $statement->fetchAll(\PDO::FETCH_CLASS);
        return $statement->fetchAll();
    }

    public function selec()
    {
        $this->selectables = func_get_args();
        return $this;
    }

    public function query($sql)
    {
        return $statement = $this->pdo->prepare($sql);
    }
}
