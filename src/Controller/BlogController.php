<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 12/11/18
 * Time: 17:42
 */

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Article;

/**
 * Class BlogController
 * @package App\Controller
 */
class BlogController extends AbstractController
{

    /**
     * Show all row from article's entity
     *
     * @Route("/blog", name="blog_index")
     * @return Response A response instance
     */
    public function index(): Response
    {
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

        if (!$articles) {
            throw $this->createNotFoundException(
                'No article found in article\'s table.'
            );
        }

        return $this->render(
            'blog/index.html.twig',
            ['articles' => $articles]
        );
    }


    /**
     * @Route("/blog/{slug<^[a-z0-9-]+$>}",
     * defaults={"slug" = null},
     * name="blog_show")
     * @return Response A response instance
     */
    public function show($slug): Response
    {
        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find an article in article\'s table.');
        }
        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );
        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);
        if (!$article) {
            throw $this->createNotFoundException(
                'No article with ' . $slug . ' title, found in article\'s table.'
            );
        }
        return $this->render(
            'blog/show.html.twig',
            [
                'article' => $article,
                'slug' => $slug,
            ]
        );
    }

    /**
     * @Route("/category/{category}", name="blog_show_category")
     */
    public function showByCategory(string $category): Response
    {
        $idCategory = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(['name' => $category])
            ->getId();

        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findBy(['category' => $idCategory], ['id' => 'desc'], 3);

        if (!$articles) {
            throw $this->createNotFoundException(
                'No article found in category\'s table.'
            );
        }
        return $this->render(
            'blog/category.html.twig',
            [
                'articles' => $articles,
                'name' => $category
            ]
        );
    }

    /**
     * @Route("/category/{category}/all", name="blog_all_show_category")
     */
    public function showAllByCategory(string $category): Response
    {
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(['name' => $category]);

        $articles = $category->getArticles();

        if (!$articles) {
            throw $this->createNotFoundException(
                'No article found in category\'s table.'
            );
        }
        return $this->render(
            'blog/category.html.twig',
            [
                'articles' => $articles,
                'name' => $category->getName()
            ]
        );
    }



}
