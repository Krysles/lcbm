<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Recipe;
use AppBundle\Entity\Subcategory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $buzzRecipe = $em->getRepository('AppBundle:Recipe')->findBy(
            array('status' => Recipe::RECIPE_VALIDATE),
            array('updateDate' => 'DESC'),
            5, 0
        );

        return $this->render('base.html.twig', array(
            'buzzRecipe' => $buzzRecipe
        ));
    }

    /*
     * Sidebar
     */
    public function menuAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('AppBundle:Category')->getCategoriesWithSubcategories();

        return $this->render('menu.html.twig', array(
            'categories' => $categories
        ));
    }

    /**
     * @Route("/recette/{slug}", name="view_recipe")
     */
    public function viewRecipeAction(Request $request, Recipe $recipe)
    {
        $em = $this->getDoctrine()->getManager();

        $em->getRepository('AppBundle:Recipe')->getRecipe($recipe);

        return $this->render('recipe.html.twig', array(
            'recipe' => $recipe
        ));
    }

    /**
     * @Route("/{slug}/{page}", name="view_subcategory", defaults={"page" = 1})
     */
    public function viewSubcategoryAction(Request $request, Subcategory $subcategory, $page)
    {
        $em = $this->getDoctrine()->getManager();

        $recipes = $em->getRepository('AppBundle:Recipe')->getRecipesWithSubcategory($subcategory->getId());

        $paginator = $this->get('knp_paginator');
        $recipes = $paginator->paginate(
            $recipes,
            $request->query->getInt('page', $page),
            $request->query->getInt('limit', $this->getParameter('nb_recipes_per_page'))
        );

        return $this->render('subcategory.html.twig', array(
            'subcategory' => $subcategory,
            'recipes' => $recipes
        ));
    }
}
