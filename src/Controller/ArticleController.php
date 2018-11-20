<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 13/11/18
 * Time: 22:58
 */

namespace App\Controller;

use App\Entity\Category;
use App\Form\ArticleSearchType;
use App\Form\CategoryType;
use App\Form\ArticleType;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Entity\Tag;

class ArticleController extends AbstractController
{
    /**
     * @Route("/articles")
     */
    public function showArticles($id)
    {
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->find($id);
        $articles = $category->getArticles();
        return $this->render('showArticles.html.twig', ['articles' => $articles]);
    }

    /**
     * @Route("/article/add", name="article_add.html.twig")
     *
     * @return Response A response instance
     */
    public function addArticle(Request $request) : Response
    {
        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
            return $this->redirectToRoute('blog_index');
        }

        return $this->render('blog/article_add.html.twig', ['form' => $form->createView()]);
    }
}