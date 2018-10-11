<?php
/**
 * Created by PhpStorm.
 * User: connector
 * Date: 16/07/2018
 * Time: 16:44
 */

namespace App\Model;

use App\Entity\Thumbnails;
use PDO;

class ThumbnailManager extends Manager
{
    public function  __construct()
    {
        parent::__construct('thumbnails');
    }

    public function destroyThumb($id)
    {
        $this->pdostatement = $this->pdo->prepare('
        DELETE
        FROM thumbnails WHERE id = :id ');
        $this->pdostatement->bindValue(':id',$id,PDO::PARAM_INT);

        $executeIsOk = $this->pdostatement->execute();
        return $executeIsOk;

    }

    public function destroyThumbsAll($item)
    {
        $thumbnails = 'img/'.lcfirst($item).'/thumbs/';
        $this->pdostatement=$this->pdo->prepare('
        DELETE 
        FROM thumbnails WHERE dirname = :thumbs 
         ');
        $this->pdostatement->bindValue(':thumbs',$thumbnails,PDO::PARAM_STR);
        $executeIsOk = $this->pdostatement->execute();
        return $executeIsOk;
    }

}