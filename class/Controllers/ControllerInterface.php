<?php

namespace Api\Controllers;

use Api\Database\Database;
use Api\Response\HttpStatus;
use Api\Response\Response;

abstract class ControllerInterface
{
    const TABLE_NAME = "user";

    public function findByParams()
    {
        global $req;

        $tableName = self::TABLE_NAME;
        $whereFields = [];

        foreach ($req->params AS $key => $value) {
            $whereFields[] = "`{$key}` = '{$value}' ";
        }

        $whereFields = implode("AND", $whereFields);

        $query = "SELECT * FROM {$tableName} WHERE {$whereFields} LIMIT 1;";

        try {
            $db = Database::getInstance();
            $db->exec($query);
            Response::output(HttpStatus::SUCCESS, "Usuário criado com sucesso!");
        } catch (\Exception $e) {
            die(Response::output(HttpStatus::INTERN_ERROR, $e->getMessage()));
        }

        return $db->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function save() {
        $tableName = self::TABLE_NAME;
        $tableFields = "`" . implode("`,`", array_keys(get_object_vars($this))) . "`";
        $classValues = "'" . implode("','", array_values(get_object_vars($this))) . "'";
        $fieldsAndValues = [];

        foreach (get_object_vars($this) AS $key => $value) {
            $fieldsAndValues[] = " `{$key}` = '{$value}' ";
        } 

        $fieldsAndValues = implode(",", $fieldsAndValues);

        $query = "
            INSERT INTO {$tableName} ({$tableFields})
            VALUES ($classValues)
            ON DUPLICATE KEY UPDATE {$fieldsAndValues};
        ";

        
        try {
            $db = Database::getInstance();
            $db->exec($query);
            Response::output(HttpStatus::SUCCESS, "Usuário criado com sucesso!");
        } catch (\Exception $e) {
            die(Response::output(HttpStatus::INTERN_ERROR, $e->getMessage()));
        }
    }
}
