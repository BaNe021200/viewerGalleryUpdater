<?php
/**
 * Created by PhpStorm.
 * User: connector
 * Date: 16/07/2018
 * Time: 17:16
 */

namespace App\Model;
Use App\Entity\Images;
use PDO;

class ImageManager extends Manager
{
    public function  __construct()
    {
        parent::__construct('images');
    }

    public function destroyImg($images_id)
    {
        $this->pdostatement = $this->pdo->prepare('
        DELETE
        FROM images WHERE id = :id ');
        $this->pdostatement->bindValue(':id',$images_id,PDO::PARAM_INT);
        $executeIsOk = $this->pdostatement->execute();

        return $executeIsOk;

    }
    public function destroyImgAll($item)
    {
        $images = 'img/'.$item ;
        $this->pdostatement=$this->pdo->prepare('
        DELETE 
        FROM images WHERE dirname = :images  
        ');
        $this->pdostatement->bindValue(':images',$images,PDO::PARAM_STR);
        $executeIsOk = $this->pdostatement->execute();
        return $executeIsOk;
    }
}


