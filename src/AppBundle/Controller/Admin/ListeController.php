<?php

namespace AppBundle\Controller\Admin;

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
     * @Route("admin/categories", name="admin_liste_categories")
     */
    public function adminListeCategoriesAction()
    {
        $categories = $this->getDoctrine()->getManager()->getRepository('AppBundle:Category')->findAll();

        return $this->render(':Admin/Liste:categories.html.twig', array(
            'categories' => $categories
        ));
    }

    /**
     * @Route("admin/categorie/{slug}", name="admin_liste_category")
     */
    public function adminListeCategoryAction(Category $category)
    {
        return $this->render(':Admin/Liste:subcategories.html.twig', array(
            'category' => $category
        ));
    }

    /**
     * @Route("admin/recettes-en-cours/{page}", name="admin_liste_recipes", defaults={"page" = 1})
     */
    public function adminListeRecipesAction(Request $request, $page)
    {
        $recipes = $this->getDoctrine()->getManager()->getRepository('AppBundle:Recipe')->getRecipeOfUserForStatus($this->getUser(), Recipe::RECIPE_DELETE,Recipe::RECIPE_TO_VALIDATE);

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
     * @Route("admin/en-attente/{page}", name="admin_liste_recipes_to_validate", defaults={"page" = 1})
     */
    public function adminListeRecipesToValidateAction(Request $request, $page)
    {
        $recipes = $this->getDoctrine()->getManager()->getRepository('AppBundle:Recipe')->findBy(
            array('status' => Recipe::RECIPE_TO_VALIDATE, 'userAdmin' => $this->getUser()),
            array('updateDate' => 'asc')
        );

        $paginator = $this->get('knp_paginator');
        $recipes = $paginator->paginate(
            $recipes,
            $request->query->getInt('page', $page),
            $request->query->getInt('limit', $this->getParameter('nb_recipes_per_page'))
        );

        return $this->render(':Admin/Liste:tovalidate.html.twig', array(
            'recipes' => $recipes
        ));
    }

    /**
     * @Route("admin/unites/{page}", name="admin_liste_units", defaults={"page" = 1})
     */
    public function adminListeUnitsAction(Request $request, $page)
    {
        $units = $this->getDoctrine()->getManager()->getRepository('AppBundle:Unity')->findAll();

        $paginator = $this->get('knp_paginator');
        $units = $paginator->paginate(
            $units,
            $request->query->getInt('page', $page),
            $request->query->getInt('limit', $this->getParameter('nb_recipes_per_page'))
        );

        return $this->render(':Admin/Liste:unity.html.twig', array(
            'units' => $units
        ));
    }

    /**
     * @Route("admin/liaisons/{page}", name="admin_liste_liaisons", defaults={"page" = 1})
     */
    public function adminListeLiaisonsAction(Request $request, $page)
    {
        $liaisons = $this->getDoctrine()->getManager()->getRepository('AppBundle:Liaison')->findAll();

        $paginator = $this->get('knp_paginator');

        $liaisons = $paginator->paginate(
            $liaisons,
            $request->query->getInt('page', $page),
            $request->query->getInt('limit', $this->getParameter('nb_recipes_per_page'))
        );
        return $this->render(':Admin/Liste:liaisons.html.twig', array(
            'liaisons' => $liaisons
        ));
    }

    /**
     * @Route("admin/ingredients/{page}", name="admin_liste_ingredients", defaults={"page" = 1})
     */
    public function adminListeIngredientsAction(Request $request, $page)
    {
        $ingredients = $this->getDoctrine()->getManager()->getRepository('AppBundle:Ingredient')->findAll();

        $paginator = $this->get('knp_paginator');

        $ingredients = $paginator->paginate(
            $ingredients,
            $request->query->getInt('page', $page),
            $request->query->getInt('limit', $this->getParameter('nb_recipes_per_page'))
        );

        return $this->render(':Admin/Liste:ingredients.html.twig', array(
            'ingredients' => $ingredients
        ));
    }

    /**
     * @Route("admin/types-de-cuisson/{page}", name="admin_liste_cuisson_type", defaults={"page" = 1})
     */
    public function adminListeCuissonTypeAction(Request $request, $page)
    {
        $cookingType = $this->getDoctrine()->getManager()->getRepository('AppBundle:CookingType')->findAll();

        $paginator = $this->get('knp_paginator');

        $cookingType = $paginator->paginate(
            $cookingType,
            $request->query->getInt('page', $page),
            $request->query->getInt('limit', $this->getParameter('nb_recipes_per_page'))
        );

        return $this->render(':Admin/Liste:cookingtype.html.twig', array(
            'cookingType' => $cookingType
        ));
    }

    /**
     * @Route("admin/unites-de-cuisson/{page}", name="admin_liste_cuisson_unity", defaults={"page" = 1})
     */
    public function adminListeCuissonUnityAction(Request $request, $page)
    {
        $cookingUnity = $this->getDoctrine()->getManager()->getRepository('AppBundle:CookingUnity')->findAll();

        $paginator = $this->get('knp_paginator');

        $cookingUnity = $paginator->paginate(
            $cookingUnity,
            $request->query->getInt('page', $page),
            $request->query->getInt('limit', $this->getParameter('nb_recipes_per_page'))
        );

        return $this->render(':Admin/Liste:cookingunity.html.twig', array(
            'cookingUnity' => $cookingUnity
        ));
    }

    /**
     * @Route("admin/types-dappareil/{page}", name="admin_liste_device_type", defaults={"page" = 1})
     */
    public function adminListeDeviceTypeAction(Request $request, $page)
    {
        $deviceType = $this->getDoctrine()->getManager()->getRepository('AppBundle:DeviceType')->findAll();

        $paginator = $this->get('knp_paginator');

        $deviceType = $paginator->paginate(
            $deviceType,
            $request->query->getInt('page', $page),
            $request->query->getInt('limit', $this->getParameter('nb_recipes_per_page'))
        );

        return $this->render(':Admin/Liste:devicetype.html.twig', array(
            'deviceType' => $deviceType
        ));
    }

    /**
     * @Route("admin/modes-dappareil/{page}", name="admin_liste_device_mode", defaults={"page" = 1})
     */
    public function adminListeDeviceModeAction(Request $request, $page)
    {
        $deviceMode = $this->getDoctrine()->getManager()->getRepository('AppBundle:DeviceMode')->findAll();

        $paginator = $this->get('knp_paginator');

        $deviceMode = $paginator->paginate(
            $deviceMode,
            $request->query->getInt('page', $page),
            $request->query->getInt('limit', $this->getParameter('nb_recipes_per_page'))
        );

        return $this->render(':Admin/Liste:devicemode.html.twig', array(
            'deviceMode' => $deviceMode
        ));
    }
}
