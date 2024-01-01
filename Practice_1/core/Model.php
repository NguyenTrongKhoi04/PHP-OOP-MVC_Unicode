<?php
/**
 * * Base Model
 */
class Model extends Database{
    protected $db;

    function __construct(){
        $this->db = new Database();
    }
}