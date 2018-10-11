<?php

namespace App\Controller;

use App\Model\ImageManager;
use App\Model\ThumbnailManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Thumbnails;
use App\Entity\Images;
use App\Controller\ImagesController;

class DownloadController extends AbstractController
{

    //Fonction update

    public function update($item)
    {

        $messages = [];
        $srcSize = null;
        $imgs = glob('img/' . lcfirst($item) . '/*.jpg');
        foreach ($imgs as $img) {
            $imgBasename[] = basename($img); 
            @$srcSize= filesize($img);
            if($srcSize['error']==2){$messages[] = "Le fichier ".$imgBasename." est trop volumineux";}
            if($srcSize['error']==1){$messages[]= 'votre fichier excède la taille de configuration du serveur.Veuillez Uploader un fichier < à 1.4mo ';}
        }

        
        $thumbs = glob('img/' . lcfirst($item) . '/thumbs/*.jpg');
        foreach ($thumbs as $thumb) {
            $thumbBasename[] = basename($thumb);
        }



        @$data = array_diff(@$imgBasename, @$thumbBasename);

        if(empty($imgBasename)){
            $messages[]="Votre dossier photos est vide";
            $explo=  exec("C:\WINDOWS\\explorer.exe /e,/select,D:\Benoit\FileZilla\\viewerGallery\\viewerCaseSensitive\public\img\\".lcfirst($item)."\\thumbs");
            return $this->render('images/' . $item . '/success' . $item . '.html.twig', [
                'message' => $messages,

            ]);
        }elseif(empty($thumbBasename)){

            return $this->firstCropImagesForUpdate($item);



        }else
        {



            foreach ($data as $datum) {
                $pictures[] = 'img/' . lcfirst($item) . '/' . $datum; //var_dump($data);die;
            }


            if (!empty($data)) {



                $images = $pictures;
                foreach ($images as $image) {


                    $src = $image;
                    $srcName = basename($src);
                    $srcSize= filesize($src);
                    if($srcSize > 1600000 )
                    {$messages[] =nl2br("Le fichier ".$srcName." est trop volumineux\r\n ");


                    }else {

                        $infoName = pathinfo($src);
                        $cropName = $infoName['basename'];//var_dump($image);die;
                        $image = imagecreatefromjpeg($src);
                        $size = min(imagesx($image), imagesy($image));
                        $im2 = imagecrop($image, ['x' => 0, 'y' => 0, 'width' => $size, 'height' => $size]);
                        if ($im2 !== FALSE) {
                            imagejpeg($im2, 'img/' . lcfirst($item) . '/thumbs/' . $cropName);
                        }

                        $entityManager = $this->getDoctrine()->getManager();
                        $image = new Images();


                        $image->setDirname('img/' . lcfirst($item));
                        $image->setBasename($cropName);
                        $entityManager->persist($image);
                        $entityManager->flush($image);
                        $imageId = $image->getId();

                        $thumbnail = new Thumbnails();
                        $thumbnail->setImagesId($imageId);
                        $thumbnail->setDirname('img/' . lcfirst($item) . '/thumbs/');
                        $thumbnail->setBasename($cropName);
                        $entityManager->persist($thumbnail);
                        $entityManager->flush($thumbnail);
                        if(@$thumbnail)
                        {
                            $messages[]= nl2br("le fichier ".$srcName." a été uploadé\r\n");
                        }

                    }



                }

            }else {
                $messages[] = "Il n'y a rien à mettre à jour";
            }
            return $this->render('images/' . $item . '/success' . $item . '.html.twig', [
                'message' => $messages,
            ]);
        }
    }

    public function updateItem1()
    {
        return $this->update('Item1');

    }

    public function updateItem2_1()
    {
        return $this->update('Item2_1');

    }

    public function updateItem2_2()
    {
        return $this->update('Item2_2');

    }

    public function firstCropImagesForUpdate($item){



        $images=glob('img/'.lcfirst($item).'/*.jpg');


        $messages=[];
        foreach ($images as $image){


            $src= $image;
            $infoName= pathinfo($src);
            $cropName=$infoName['basename'];
            $image = imagecreatefromjpeg($src);
            $size = min(imagesx($image), imagesy($image));
            $im2 = imagecrop($image, ['x' => 0, 'y' => 0, 'width' => $size, 'height' => $size]);
            if ($im2 !== FALSE) {
                imagejpeg($im2, 'img/'.lcfirst($item).'/thumbs/' . $cropName);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $image = new Images();


            $image->setDirname('img/'.lcfirst($item));
            $image->setBasename($cropName);
            $entityManager->persist($image);
            $entityManager->flush();
            $imageId= $image->getId();

            $thumbnail = new Thumbnails(); 
            $thumbnail->setImagesId($imageId);
            $thumbnail->setDirname('img/'.lcfirst($item).'/thumbs/');
            $thumbnail->setBasename($cropName);
            $entityManager->persist($thumbnail);
            $entityManager->flush();
        }
        if($thumbnail){
            $messages[]="Vos photos sont maintenant à jours";
        }else{
            $messages[]="Une erreur est survenue, imossible de mettre vos photos à jour";
        }
        return $this->render('images/' . $item . '/success' . $item . '.html.twig', [
            'message' => $messages,
        ]);

    }


    //Fonction EraseModal

    public function eraseModal($item,$basename,$id,$images_id)
    {

        return $this->render('images/'.$item.'/erase'.$item.'.html.twig',[
            'basename' => $basename,
            'id' =>$id ,
            'images_Id'=>$images_id
        ]);
    }

    public function eraseModalItem1($basename,$id,$images_id)
    {
        return($this->eraseModal('Item1',$basename,$id,$images_id));
    }

    public function eraseModalItem2_1($basename,$id,$images_id)
    {
        return($this->eraseModal('Item2_1',$basename,$id,$images_id));
    }

    public function eraseModalItem2_2($basename,$id,$images_id)
    {
        return($this->eraseModal('Item2_2',$basename,$id,$images_id));
    }


    //Fonction destroy



    public function destroy($item,$id,$images_id)
    {
        $messages=[];
        $tManager = new ThumbnailManager();
        $destroyThumb = $tManager->destroyThumb($id);
        if($destroyThumb)
        {
            $messages[]="La miniature à bien été détruite !</br> ";
        }
        else{
            $messages[]="Une erreur a surgit du fond de la nuit. La miniature n'a pu être détruite";
        }

        $iManager = new ImageManager();
        $destroyImg = $iManager->destroyImg($images_id);
        if($destroyImg){
            $messages[]="L'image a bien été détruite !";
        }
        else{
            $messages[]="Une erreur a surgit du fond de la nuit. L'image n'a pu être détruite";
        }


        return $this->render('images/'.$item.'/success'.$item.'.html.twig',[
            'message' => $messages

        ]);



    }

    public function destroyItem1($id,$images_id)
    {
        return($this->destroy('Item1',$id,$images_id));
    }

    public function destroyItem2_1($id,$images_id)
    {
        return($this->destroy('Item2_1',$id,$images_id));
    }

    public function destroyItem2_2($id,$images_id)
    {
        return($this->destroy('Item2_2',$id,$images_id));
    }

    /* fonction EraseAll*/

    public function eraseModalAll($item)
    {

        return $this->render('images/'.$item.'/eraseAll'.$item.'.html.twig',[
            'theme'=> $item

        ]);
    }

    public function eraseModalItem1All()
    {
        return $this->eraseModalAll('Item1');
    }

    public function eraseModalItem2_1All()
    {
        return $this->eraseModalAll('Item2_1');
    }

    public function eraseModalItem2_2All()
    {
        return $this->eraseModalAll('Item2_2');
    }

    /*Fonction destroy all*/

    public function destroyAll($item)
    {
        $messages=[];
        $tManager = new ThumbnailManager();
        $destroyThumbs = $tManager->destroyThumbsAll($item);
        if($destroyThumbs)
        {
            $messages[]="Les miniatures ont bien été détruite !</br> ";
        }
        else{
            $messages[]="Une erreur a surgit du fond de la nuit. Les miniatures n'ont pu être détruite";
        }

        $iManager = new ImageManager();
        $destroyImgs = $iManager->destroyImgAll($item);
        if($destroyImgs){
            $messages[]="Les images ont bien été détruite !";
        }
        else{
            $messages[]="Une erreur a surgit du fond de la nuit. Les images n'ont pu être détruite";
        }


        return $this->render('images/'.$item.'/success'.$item.'.html.twig',[
            'message' => $messages

        ]);


    }



    public function destroyItem1All()
    {
        return $this->destroyAll('Item1');
    }

    public function destroyItem2_1All()
    {
        return $this->destroyAll('Item2_1');
    }

    public function destroyItem2_2All()
    {
        return $this->destroyAll('Item2_2');
    }






}
