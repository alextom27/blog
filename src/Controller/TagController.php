<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 18/11/18
 * Time: 15:13
 */

namespace App\Controller;
use App\Entity\Article;
use App\Entity\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TagController extends AbstractController
{
    /**
     * @param string $category
     *
     * @Route ("/blog/tag/{tag}/all", name="tag_list")
     *
     * @return Response
     *
     */
    public function showAllByTag(string $tag) : Response
    {
        $tag = $this->getDoctrine()
            ->getRepository(Tag::class)
            ->findOneByName($tag);
        if (!$tag) {
            throw $this->createNotFoundException(
                'No tag ' . $tag . " title, found in tag's table"
            );
        }
        $articles = $tag->getArticles();
        return $this->render('blog/tag.html.twig', ['articles' => $articles, 'tag' => $tag]);
    }
}