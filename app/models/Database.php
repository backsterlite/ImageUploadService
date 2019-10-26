<?php


namespace App\models;


use Aura\SqlQuery\QueryFactory;
use PDO;

class Database
{
    /**
     * @var QueryFactory
     */
    private $queryFactory;
    /**
     * @var \PDO
     */
    private $pdo;

    public function __construct(QueryFactory $queryFactory, PDO $pdo)
    {

        $this->queryFactory = $queryFactory;
        $this->pdo = $pdo;
    }

    public function all($table, $limit = null)
    {
        $select = $this->queryFactory->newSelect();
        $select->cols(['*'])
                ->from($table)
                ->limit($limit);

        // prepare the statment
        $sth = $this->pdo->prepare($select->getStatement());

        // bind the values and execute
        $sth->execute($select->getBindValues());

        // get the results back as an associative array
        return  $sth->fetchAll(PDO::FETCH_ASSOC);
    }
}