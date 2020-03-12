<?php

namespace App\Service\Comment;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Repository\CommentRepository;

class CommentOptions extends Controller{

    public function deleteComment(int $idcomment){

        $manager = $this->getDoctrine()->getManager();

        $commentToDelete = $manager->getRepository(CommentRepository::class)->find($idcomment);

        $manager->remove($commentToDelete);
        $manager->flush();
    }
}