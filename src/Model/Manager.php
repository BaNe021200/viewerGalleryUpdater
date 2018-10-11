<?php
/**
 * Created by PhpStorm.
 * User: connector
 * Date: 16/07/2018
 * Time: 16:34
 */

namespace App\Model;
use PDO;

class Manager
{

    protected $table;

    protected $pdo;

    protected $pdostatement;


    public function __construct($table)
    {
        $this->pdo = new PDO('mysql:host=localhost;dbname=pinterest','root','nzB69yCSBDz9eK46',array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'));
       /* $this->pdo = new PDO('mysql:host=db753369468.db.1and1.com;dbname=db753369468','dbo753369468','nzB69yCSBDz9eK46',array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'));*/
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);


        $this->table = $table;
    }


}