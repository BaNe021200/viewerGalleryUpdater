<?php

namespace App\Controller;

use App\Entity\Thumbnails;
use App\Entity\Images;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Controller\DownloadController;
use App\Model\ThumbnailManager;
use App\Model\ImageManager;


class ImagesController extends Controller
{




    public function index()
    {
        return $this->render('images/Doudounes/Item1.html.twig', [
            'controller_name' => 'ImagesController',
        ]);
    }



    public function item($item, Request $request)
    {

        $dir = 'img/'.$item.'/thumbs/';


        $bg_ramdom2 = mt_rand(1, 2);
        $bg_ramdom3 = mt_rand(1, 3);
        $bg_ramdom6 = mt_rand(1, 6);

        $em = $this->getDoctrine()->getManager();

        $thumbsQuery= $em->getRepository(Thumbnails::class)

            ->findByDirname($dir);


        $paginator = $this->get('knp_paginator');

        $thumbs = $paginator->paginate($thumbsQuery, $request->query->getInt('page',1),12


        );



        return $this->render('images/'.$item.'/'.$item.'.html.twig',[

            'thumbs' => $thumbs,
            'bg_ramdom' => $bg_ramdom2,
            'bg_ramdom3' => $bg_ramdom3,
            'bg_ramdom6' =>$bg_ramdom6,


        ]);
    }

    public function item1(Request $request)
    {
        return ($this->item('Item1',$request));
    }



    public function item2_1(Request $request)
    {
        return ($this->item('Item2_1',$request));
    }

    public function item2_2(Request $request)
    {
        return ($this->item('Item2_2',$request));
    }







    /*public function openExplo($item)
    {
     $explo=  exec("C:\WINDOWS\\explorer.exe /e,/select,C:\wamp64\www\PhpTraining\pinterest\pinterest2\public\img\\".$item."\\thumbs");

        return $this->redirect($this->item($item));


    }*/





}
