<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Recipe;
use AppBundle\Entity\Subcategory;
use AppBundle\Form\Type\CategoryType;
use AppBundle\Form\Type\SubcategoryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ListeController extends Controller
{
    /**
     * @Route("admin/liste/categories", name="admin_liste_categories")
     */
    public function adminListeCategoriesAction()
    {
        $categories = $this->getDoctrine()->getManager()->getRepository('AppBundle:Category')->findAll();

        return $this->render(':Admin/Liste:categories.html.twig', array(
            'categories' => $categories
        ));
    }

    /**
     * @Route("admin/liste/categorie/{slug}", name="admin_liste_category")
     */
    public function adminListeCategoryAction(Category $category)
    {
        return $this->render(':Admin/Liste:subcategories.html.twig', array(
            'category' => $category
        ));
    }

    /**
     * @Route("admin/liste/recettes/{page}", name="admin_liste_recipes", defaults={"page" = 1})
     */
    public function adminListeRecipesAction(Request $request, $page)
    {
        $recipes = $this->getDoctrine()->getManager()->getRepository('AppBundle:Recipe')->findBy(
            array('status' => Recipe::RECIPE_VALIDATE),
            array('updateDate' => 'desc')
        );

        $paginator = $this->get('knp_paginator');
        $recipes = $paginator->paginate(
            $recipes,
            $request->query->getInt('page', $page),
            $request->query->getInt('limit', $this->getParameter('nb_recipes_per_page'))
        );

        return $this->render(':Admin/Liste:recipes.html.twig', array(
            'recipes' => $recipes
        ));
    }

    /**
     * @Route("admin/liste/unites", name="admin_liste_units")
     */
    public function adminListeUnitsAction()
    {
        $units = $this->getDoctrine()->getManager()->getRepository('AppBundle:Unity')->findAll();

        return $this->render(':Admin/Liste:unity.html.twig', array(
            'units' => $units
        ));
    }

    /**
     * @Route("admin/liste/liaisons", name="admin_liste_liaisons")
     */
    public function adminListeLiaisonsAction()
    {
        $liaisons = $this->getDoctrine()->getManager()->getRepository('AppBundle:Liaison')->findAll();

        return $this->render(':Admin/Liste:liaisons.html.twig', array(
            'liaisons' => $liaisons
        ));
    }

    /**
     * @Route("admin/liste/ingredients", name="admin_liste_ingredients")
     */
    public function adminListeIngredientsAction()
    {
        $ingredients = $this->getDoctrine()->getManager()->getRepository('AppBundle:Ingredient')->findAll();

        return $this->render(':Admin/Liste:ingredients.html.twig', array(
            'ingredients' => $ingredients
        ));
    }

    /**
     * @Route("admin/liste/cuisson/type", name="admin_liste_cuisson_type")
     */
    public function adminListeCuissonTypeAction()
    {
        $cookingType = $this->getDoctrine()->getManager()->getRepository('AppBundle:CookingType')->findAll();

        return $this->render(':Admin/Liste:cookingtype.html.twig', array(
            'cookingType' => $cookingType
        ));
    }

    /**
     * @Route("admin/liste/cuisson/unite", name="admin_liste_cuisson_unity")
     */
    public function adminListeCuissonUnityAction()
    {
        $cookingUnity = $this->getDoctrine()->getManager()->getRepository('AppBundle:CookingUnity')->findAll();

        return $this->render(':Admin/Liste:cookingunity.html.twig', array(
            'cookingUnity' => $cookingUnity
        ));
    }

    /**
     * @Route("admin/liste/appareil/type", name="admin_liste_device_type")
     */
    public function adminListeDeviceTypeAction()
    {
        $deviceType = $this->getDoctrine()->getManager()->getRepository('AppBundle:DeviceType')->findAll();

        return $this->render(':Admin/Liste:devicetype.html.twig', array(
            'deviceType' => $deviceType
        ));
    }

    /**
     * @Route("admin/liste/appareil/mode", name="admin_liste_device_mode")
     */
    public function adminListeDeviceModeAction()
    {
        $deviceMode = $this->getDoctrine()->getManager()->getRepository('AppBundle:DeviceMode')->findAll();

        return $this->render(':Admin/Liste:devicemode.html.twig', array(
            'deviceMode' => $deviceMode
        ));
    }
}
