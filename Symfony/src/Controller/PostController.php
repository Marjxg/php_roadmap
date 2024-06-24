<?php

namespace App\Controller;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    private $emi;
    public function __construct(EntityManagerInterface $emi){
        $this->emi = $emi;
    }
    #[Route('/post/{id}', name: 'app_post')]
    public function index($id): Response
    {
        $post = $this->emi->getRepository(Post::class)->find($id);
        $posts = $this->emi->getRepository(Post::class)->findAll();
        $postby = $this->emi->getRepository(Post::class)->findBy(['title'=>'Entrada 1', 'id'=>1]);
        $postoneby = $this->emi->getRepository(Post::class)->findOneBy(['id'=>1]);
        $custom_post = $this->emi->getRepository(Post::class)->findPost($id);
        return $this->render('post/index.html.twig', [
            'post'=> $post,
            'posts' => $posts,
            'postby' => $postby,
            'postoneby' => $postoneby,
            'custom_post' => $custom_post,
        ]);
    }
}
