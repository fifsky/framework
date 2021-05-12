<?php namespace fifsky\library;
/**
 * Created by PhpStorm.
 * User: 蔡旭东 caixudong@verystar.cn
 * Date: 15/1/26 下午1:54
 */

use Everyman\Neo4j\Client as Neo4jClient;
use Everyman\Neo4j\Cypher;
use Exception;

class Neo4j {

    private $client;

    /**
     * @param string $db
     *
     * @return Neo4jClient
     */
    public function getInstance($db = 'default') {
        static $neo4j_db_instance = [];

        if (!isset($neo4j_db_instance[$db])) {
            $config                 = config('neo4j', $db);
            $neo4j_db_instance[$db] = new Neo4jClient($config['host'], $config['port']);
        }

        $this->client = $neo4j_db_instance[$db];

        return $this;
    }

    public function query($cql ,$params = []) {
        try {
            $query = new Cypher\Query($this->client, $cql, $params);

            return $query->getResultSet();
        }catch(Exception $e){
            echo $e->getMessage();
            return false;
        }
    }
}