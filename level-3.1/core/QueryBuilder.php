<?php

namespace Core;

use Core\DB;
use Aura\SqlQuery\QueryFactory;

class QueryBuilder
{
    private $pdo, $queryFactory;

    public function __construct( QueryFactory $queryFactory)
    {
        $this->pdo = DB::getInstance();
        $this->queryFactory = $queryFactory;
    }

    /**
     * Get all from database
     *
     * @param string $table
     * @return object
     */
    public function findAll($table)
    {

        $select = $this->queryFactory->newSelect();
        $select->cols(["*"])->from($table);

        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        return $sth->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Insert row to databse
     *
     * @param string $table
     * @param array $params
     * @return boolean
     */
    public function insert($table, $params)
    {

        $insert = $this->queryFactory->newInsert();
        $insert->into($table)->cols($params);

        $sth = $this->pdo->prepare($insert->getStatement());
        $sth->execute($insert->getBindValues());
    }

    /**
     * Update row in database
     *
     * @param string $table
     * @param array $params
     * @param integer $id
     * @return boolean
     */
    public function update($table, $params, $id)
    {
        $update = $this->queryFactory->newUpdate();
        $update->table($table)->cols($params)->where(['id' => $id]);
        $sth = $this->pdo->prepare($update->getStatement());
        $sth->execute($update->getBindValues());
    }

    /**
     * Delete row in databse
     *
     * @param string $table
     * @param integer $id
     * @return void
     */
    public function delete ( string $table, int $id )
    {
        $delete = $this->queryFactory->newDelete();
        $delete->from( $table )->where('id = :id')->bindValue('id', $id) ;
        $sth = $this->pdo->prepare( $delete->getStatement() );
        $sth->execute($delete->getBindValues());
    }
}
