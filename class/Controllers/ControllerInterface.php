<?php

namespace Api\Controllers;

use Api\Database\Database;
use Api\Response\HttpStatus;
use Api\Response\Response;
use Api\Util\Util;

abstract class ControllerInterface
{
    const TABLE_NAME = "user";

    public function get()
    {
        global $req;

        $tableName = self::TABLE_NAME;
        $whereField = $req->params->userId ? "WHERE u.id = {$req->params->userId}" : '';

        $query = "
            SELECT u.*, (SELECT SUM(w.water_ml) FROM water_drink w WHERE w.user_id = u.id ) AS drink_counter 
                FROM {$tableName} u
                {$whereField}
                ;
        ";

        try {
            $db = Database::getInstance();
            $sttm = $db->prepare($query);
            $sttm->execute();
        } catch (\Exception $e) {
            die(Response::output(HttpStatus::INTERN_ERROR, $e->getMessage()));
        }

        if ($sttm->rowCount() > 0) {
            return [
                'rowCount'  => $sttm->rowCount(),
                'payload'   => $sttm->fetchAll(\PDO::FETCH_ASSOC)
            ];
        }
        return false;
    }

    public function findByParams()
    {
        global $req;

        $tableName = self::TABLE_NAME;
        $whereFields = [];

        foreach ($req->params AS $key => $value) {
            $whereFields[] = "`{$key}` = '{$value}'";
        }

        $whereFields = implode(" AND ", $whereFields);

        $query = "
            SELECT u.*, (SELECT SUM(w.water_ml) FROM water_drink w WHERE w.user_id = u.id) AS drink_counter
                FROM {$tableName} u 
                WHERE {$whereFields};
        ";

        try {
            $db = Database::getInstance();
            $sttm = $db->prepare($query);
            $sttm->execute();
        } catch (\Exception $e) {
            die(Response::output(HttpStatus::INTERN_ERROR, $e->getMessage()));
        }

        if ($sttm->rowCount() > 0) {
            return [
                'rowCount'  => $sttm->rowCount(),
                'payload'   => $sttm->fetchAll(\PDO::FETCH_ASSOC)
            ];
        }
        return false;

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
            Response::output(HttpStatus::SUCCESS, "Usuário criado/alterado com sucesso!");
        } catch (\Exception $e) {
            die(Response::output(HttpStatus::INTERN_ERROR, $e->getMessage()));
        }
    }

    public function remove()
    {
        global $req;

        $tableName = self::TABLE_NAME;

        $query = "DELETE FROM {$tableName} WHERE id = {$req->params->userId};";

        try {
            $db = Database::getInstance();
            $sttm = $db->prepare($query);
            $sttm->execute();
        } catch (\Exception $e) {
            die(Response::output(HttpStatus::INTERN_ERROR, $e->getMessage()));
        }

        if ($sttm->rowCount() > 0) {
            return [
                'rowCount'  => $sttm->rowCount(),
            ];
        }
        return false;
    }

    public function drink($waterDrinked)
    {  
        global $req;

        $tableName = 'water_drink';

        $query = "INSERT INTO {$tableName} (`user_id`, `water_ml`) VALUES (:userId, :waterDrinked);";

        try {
            $db = Database::getInstance();
            $sttm = $db->prepare($query);
            $sttm->bindValue(':userId', (int)$req->params->userId);
            $sttm->bindValue(':waterDrinked', (int)$waterDrinked);
            $sttm->execute();
        } catch (\Exception $e) {
            die(Response::output(HttpStatus::INTERN_ERROR, $e->getMessage()));
        }

        return $this->get();
    }
}
