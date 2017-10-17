<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Ingredients;
use AppBundle\Entity\Recipe;
use AppBundle\Entity\Picture;

use AppBundle\Entity\RecipeIngredient;
use AppBundle\Entity\RecipePicture;
use AppBundle\Form\Type\IngredientsType;
use AppBundle\Form\Type\ListIngredientsType;
use AppBundle\Form\Type\ListStepsType;
use AppBundle\Form\Type\PictureType;
use AppBundle\Form\Type\ListPicturesType;
use AppBundle\Form\Type\RecipeType;
use AppBundle\Form\Type\StepType;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class RecipeController extends Controller
{
    /**
     * @Route("admin/ajouter-une-recette", name="admin_recipe_add", defaults={"slug" = null})
     * @Route("admin/ajouter-une-recette/{slug}", name="admin_recipe_add_id")
     */
    public function recipeAddAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        if ($slug) {
            $recipe = $em->getRepository('AppBundle:Recipe')->findOneBy(array('slug' => $slug));
            if (!$recipe) {
                return $this->redirectToRoute('admin_recipe_add');
            }
        } else {
            $recipe = new Recipe();
            $em->persist($recipe);
        }
        $recipe->setUpdateDate(new \DateTime());
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->get('notsaveandcancel')->isClicked()) {
                $this->addFlash('success', "Recette non enregistrée.");
                return $this->redirectToRoute('admin_liste_recipes'); // A CHANGER EN CARNET DE RECETTES
            }
            if ($form->isValid()) {
                if ($form->get('saveandback')->isClicked()) {
                    $recipe->setStatus(RECIPE::RECIPE_INIT);
                    $em->flush();
                    $this->addFlash('success', "Recette enregistrée.");
                    return $this->redirectToRoute('admin_liste_recipes'); // A CHANGER EN CARNET DE RECETTES
                } elseif ($form->get('saveandadd')->isClicked()) {
                    $recipe->setStatus(RECIPE::RECIPE_PICTURE_INIT);
                    $em->flush();
                    $this->addFlash('info', "Recette enregistrée.");
                    return $this->redirectToRoute('admin_recipe_picture_add', array('slug' => $recipe->getSlug()));
                }
            } else {
                $this->addFlash('error', "Problème lors de la validation.");
            }
        }
        return $this->render(':Admin/Recipe:add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("admin/ajouter-une-recette/photo/{slug}", name="admin_recipe_picture_add")
     */
    public function recipePictureAddAction(Request $request, Recipe $recipe)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(ListPicturesType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->get('notsaveandcancel')->isClicked()) {
                $this->addFlash('success', "Photo non enregistré.");
                return $this->redirectToRoute('admin_liste_recipes'); // A CHANGER EN CARNET DE RECETTES
            }
            if ($form->isValid()) {
                $recipe->setUpdateDate(new \DateTime());
                if ($form->get('saveandreturn')->isClicked()) {
                    $recipe->setStatus(RECIPE::RECIPE_INIT);
                    $em->flush();
                    $this->addFlash('success', "Photo enregistré.");
                    return $this->redirectToRoute('admin_recipe_add_id', array('slug' => $recipe->getSlug()));
                } elseif ($form->get('saveandback')->isClicked()) {
                    $recipe->setStatus(RECIPE::RECIPE_PICTURE_INIT);
                    $em->flush();
                    $this->addFlash('success', "Photo enregistré.");
                    return $this->redirectToRoute('admin_liste_recipes'); // A CHANGER EN CARNET DE RECETTES
                } elseif ($form->get('saveandadd')->isClicked()) {
                    $recipe->setStatus(RECIPE::RECIPE_INGREDIENT_INIT);
                    $em->flush();
                    $this->addFlash('info', "Photo enregistré.");
                    return $this->redirectToRoute('admin_recipe_ingredients_add', array('slug' => $recipe->getSlug()));
                }
            } else {
                $this->addFlash('error', "Problème lors de la validation.");
            }
        }
        return $this->render(':Admin/Recipe:pictures_add.html.twig', array(
            'form' => $form->createView(),
            'recipe' => $recipe,
            'picture' => $recipe->getPictures()
        ));
    }

    /**
     * @Route("admin/ajouter-une-recette/ingredients/{slug}", name="admin_recipe_ingredients_add")
     */
    public function recipeIngredientsAddAction(Request $request, Recipe $recipe)
    {
        $em = $this->getDoctrine()->getManager();
        //$recipe = $em->getRepository('AppBundle:Recipe')->find($id);
        $originalIngredients = new ArrayCollection();
        foreach ($recipe->getIngredients() as $ingredient) {
            $originalIngredients->add($ingredient);
        }
        $form = $this->createForm(ListIngredientsType::class, $recipe);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->get('notsaveandcancel')->isClicked()) {
                $this->addFlash('success', "Ingrédients non enregistrés.");
                return $this->redirectToRoute('admin_liste_recipes'); // A CHANGER EN CARNET DE RECETTES
            }
            if ($form->isValid()) {
                $recipe->setUpdateDate(new \DateTime());
                foreach ($originalIngredients as $ingredient) {
                    if (false === $recipe->getIngredients()->contains($ingredient)) {
                        $ingredient->getRecipe()->removeIngredient($ingredient);
                        $em->remove($ingredient);
                    }
                }
                if ($form->get('saveandreturn')->isClicked()) {
                    $recipe->setStatus(RECIPE::RECIPE_PICTURE_INIT);
                    $em->flush();
                    $this->addFlash('success', "Ingrédients enregistrés.");
                    return $this->redirectToRoute('admin_recipe_picture_add', array('slug' => $recipe->getSlug()));
                } elseif ($form->get('saveandback')->isClicked()) {
                    $recipe->setStatus(RECIPE::RECIPE_INGREDIENT_INIT);
                    $em->flush();
                    $this->addFlash('success', "Ingrédients enregistrés.");
                    return $this->redirectToRoute('admin_liste_recipes'); // A CHANGER EN CARNET DE RECETTES
                } elseif ($form->get('saveandadd')->isClicked()) {
                    $recipe->setStatus(RECIPE::RECIPE_STEP_INIT);
                    $em->flush();
                    $this->addFlash('info', "Ingrédients enregistrés.");
                    return $this->redirectToRoute('admin_recipe_steps_add', array('slug' => $recipe->getSlug()));
                }
            } else {
                $this->addFlash('error', "Problème lors de la validation.");
            }
        }
        return $this->render(':Admin/Recipe:ingredients_add.html.twig', array(
            'form' => $form->createView(),
            'recipe' => $recipe
        ));
    }

    /**
     * @Route("admin/ajouter-une-recette/etapes/{slug}", name="admin_recipe_steps_add")
     */
    public function recipeStepAddAction(Request $request, Recipe $recipe)
    {
        $em = $this->getDoctrine()->getManager();
        // $recipe = $em->getRepository('AppBundle:Recipe')->find($id);
        $originalSteps = new ArrayCollection();
        foreach ($recipe->getSteps() as $step) {
            $originalSteps->add($step);
        }
        $form = $this->createForm(ListStepsType::class, $recipe);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->get('notsaveandcancel')->isClicked()) {
                $this->addFlash('success', "Etapes non enregistrées.");
                return $this->redirectToRoute('admin_liste_recipes'); // A CHANGER EN CARNET DE RECETTES
            }
            foreach ($originalSteps as $step) {
                if (false === $recipe->getSteps()->contains($step)) {
                    $step->getRecipe()->removeStep($step);
                    $em->remove($step);
                }
            }

            if ($form->isValid()) {
                $recipe->setUpdateDate(new \DateTime());
                if ($form->get('saveandreturn')->isClicked()) {
                    $recipe->setStatus(RECIPE::RECIPE_INGREDIENT_INIT);
                    $em->flush();
                    $this->addFlash('success', "Etapes enregistrées.");
                    return $this->redirectToRoute('admin_recipe_ingredients_add', array('slug' => $recipe->getSlug()));
                } elseif ($form->get('saveandback')->isClicked()) {
                    $recipe->setStatus(RECIPE::RECIPE_STEP_INIT);
                    $em->flush();
                    $this->addFlash('success', "Etapes enregistrées.");
                    return $this->redirectToRoute('admin_liste_recipes'); // A CHANGER EN CARNET DE RECETTES
                } elseif ($form->get('saveandadd')->isClicked()) {
                    $recipe->setStatus(RECIPE::RECIPE_TO_VALIDATE);
                    $em->flush();
                    $this->addFlash('info', "Recette enregistrée.");
                    return $this->redirectToRoute('admin_liste_recipes'); // A CHANGER EN CARNET DE RECETTES
                }
            } else {
                $this->addFlash('error', "Problème lors de la validation.");
            }
        }
        return $this->render(':Admin/Recipe:steps_add.html.twig', array(
            'form' => $form->createView(),
            'recipe' => $recipe
        ));
    }

    /**
     * @Route("admin/recette/{slug}", name="admin_recipe_view")
     */
    public function recipeViewAction(Recipe $recipe)
    {
        $em = $this->getDoctrine()->getManager();

        $em->getRepository('AppBundle:Recipe')->getRecipe($recipe);

        return $this->render(':Admin/Recipe:view.html.twig', array(
            'recipe' => $recipe
        ));
    }
}
