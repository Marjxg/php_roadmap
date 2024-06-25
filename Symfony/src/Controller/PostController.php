<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    private $emi;
    public function __construct(EntityManagerInterface $emi){
        $this->emi = $emi;
    }

    #[Route('/', name: 'app_post')]
    public function index(Request $request): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->emi->getRepository(User::class)->findOneBy(['id'=> 1]);
            $post->setUser($user);
            $this->emi->persist($post);
            $this->emi->flush();
            return $this->redirectToRoute('app_post');
        }
        return $this->render('post/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/post/{id}', name: 'select_post')]
    public function select($id): Response
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

    #[Route('/insert/post', name: 'insert_post')]
    public function insert(): Response
    {
        $post = new Post('Prueba Insert Post', 'Tipo prueba', 'Soy un post de prueba', 'prueba.txt', 'post-prueba');
        $user = $this->emi->getRepository(User::class)->findOneBy(['id'=>1]);
        $post->setUser($user);
        $this->emi->persist($post);
        $this->emi->flush();
        return new JsonResponse(['success'=>true]);

    }


    #[Route('/update/post', name: 'update_post')]
    public function update(): Response
    {
        $post = $this->emi->getRepository(Post::class)->findOneBy(['id'=> 4]);
        $post->setTitle('Test cambio nombre');
        $this->emi->flush();
        return new JsonResponse(['success'=>true]);

    }

    #[Route('/delete/post', name: 'delete_post')]
    public function delete(): Response
    {
        $post = $this->emi->getRepository(Post::class)->findOneBy(['id'=> 4]);
        $this->emi->remove($post);
        $this->emi->flush();
        return new JsonResponse(['success'=>true]);

    }
}
