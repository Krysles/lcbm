<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Recipe;
use AppBundle\Entity\SearchTitle;
use AppBundle\Entity\Subcategory;
use AppBundle\Form\Type\SearchTitleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $searchtitle = new SearchTitle();

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(SearchTitleType::class, $searchtitle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                if ($form->get('search')->isClicked()) {
                    return $this->redirectToRoute('view_search', array('searchtitle' => $searchtitle->getSearchtitle()));
                }

        }

        $buzzRecipe = $em->getRepository('AppBundle:Recipe')->findBy(
            array('status' => Recipe::RECIPE_VALIDATE),
            array('updateDate' => 'DESC'),
            5, 0
        );

        return $this->render('base.html.twig', array(
            'form' => $form->createView(),
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
        if($recipe->getStatus() != Recipe::RECIPE_VALIDATE) {
            throw $this->createNotFoundException("La recette n'existe pas.");
        }
        $em = $this->getDoctrine()->getManager();
        $em->getRepository('AppBundle:Recipe')->getRecipe($recipe);
        return $this->render('recipe.html.twig', array(
            'recipe' => $recipe
        ));
    }

    /**
     * @Route("/mentions-legales", name="view_mentions")
     */
    public function viewMentionsAction(Request $request)
    {
        return $this->render('mentions.html.twig');
    }

    /**
     * @Route("mes-recettes/{page}", name="my_recipes", defaults={"page" = 1})
     */
    public function myRecipesAction(Request $request, $page)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException('Vous devez être inscrit pour voir vos recettes.');
        }
        $recipes = $this->getDoctrine()->getManager()->getRepository('AppBundle:Recipe')->findBy(
            array('status' => Recipe::RECIPE_VALIDATE, 'userAdmin' => $this->getUser()),
            array('updateDate' => 'desc')
        );

        $paginator = $this->get('knp_paginator');
        $recipes = $paginator->paginate(
            $recipes,
            $request->query->getInt('page', $page),
            $request->query->getInt('limit', $this->getParameter('nb_recipes_per_page'))
        );

        return $this->render('::myrecipes.html.twig', array(
            'recipes' => $recipes
        ));
    }

    /**
     * @Route("/recherche/{searchtitle}/{page}", name="view_search", defaults={"page" = 1})
     */
    public function viewSearchAction(Request $request, $searchtitle, $page)
    {
        $em = $this->getDoctrine()->getManager();

        $recipes = $em->getRepository('AppBundle:Recipe')->getRecipesInForTitle($searchtitle);

        $paginator = $this->get('knp_paginator');

        $recipes = $paginator->paginate(
            $recipes,
            $request->query->getInt('page', $page),
            $request->query->getInt('limit', $this->getParameter('nb_recipes_per_page'))
        );

        return $this->render('searchtitle.html.twig', array(
            'recipes' => $recipes
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
