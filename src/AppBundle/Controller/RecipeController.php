<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Recipe;

use AppBundle\Form\Type\RecipeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RecipeController extends Controller
{
    /**
     * @Route("admin/recette", name="admin_recipe")
     */
    public function indexAction()
    {
        return $this->render('::base.html.twig');
    }

    /**
     * @Route("admin/recette/add", name="admin_recipe_add")
     */
    public function recipeAddAction(Request $request)
    {

        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);


        return $this->render(':Admin/Recipe:add.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
