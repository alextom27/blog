<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 19/11/18
 * Time: 23:14
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use App\Entity\Article;
use App\Entity\Category;
use App\Form\ArticleSearchType;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category/add", name="add_category")
     *
     * @return Response A response instance
     */
    public function addCategory(Request $request): Response
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();
        }
        return $this->render('blog/category_add.html.twig',
            [
                'form' => $form->createView()
            ]);
    }
}