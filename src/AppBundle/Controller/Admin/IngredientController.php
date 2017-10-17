<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Ingredient;
use AppBundle\Entity\Liaison;
use AppBundle\Entity\Unity;
use AppBundle\Form\Type\IngredientType;
use AppBundle\Form\Type\LiaisonType;
use AppBundle\Form\Type\UnityType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class IngredientController extends Controller
{
    /**
     * @Route("admin/unite/ajouter", name="admin_unity_add")
     */
    public function adminUnityAddAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $unity = new Unity();
        $em->persist($unity);

        $form = $this->createForm(UnityType::class, $unity);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em->flush();
                $this->addFlash('success', "Unité ajoutée.");
                return $this->redirectToRoute('admin_liste_units');
            } else {
                $this->addFlash('info', "Unité incorrecte.");
            }
        }
        return $this->render(':Admin/Unity:add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("admin/unite/modifier/{id}", name="admin_unity_update")
     */
    public function adminUnityUpdateAction(Request $request, Unity $unity)
    {
        $form = $this->createForm(UnityType::class, $unity);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash('success', "Unité modifiée.");
                return $this->redirectToRoute('admin_liste_units');
            } else {
                $this->addFlash('info', "Unité incorrecte.");
            }
        }
        return $this->render(':Admin/Unity:update.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("admin/unite/supprimer/{id}", name="admin_unity_delete")
     */
    public function adminUnityDeleteAction(Unity $unity)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($unity);
        $em->flush();
        $this->addFlash('error', "Unité supprimée.");
        return $this->redirectToRoute('admin_liste_units');
    }

    /**
     * @Route("admin/liaison/ajouter", name="admin_liaison_add")
     */
    public function adminLiaisonAddAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $liaison = new Liaison();
        $em->persist($liaison);

        $form = $this->createForm(LiaisonType::class, $liaison);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em->flush();
                $this->addFlash('success', "Liaison ajoutée.");
                return $this->redirectToRoute('admin_liste_liaisons');
            } else {
                $this->addFlash('info', "Liaison incorrecte.");
            }
        }
        return $this->render(':Admin/Liaison:add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("admin/liaison/modifier/{id}", name="admin_liaison_update")
     */
    public function adminLiaisonUpdateAction(Request $request, Liaison $liaison)
    {
        $form = $this->createForm(LiaisonType::class, $liaison);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash('success', "Liaison modifiée.");
                return $this->redirectToRoute('admin_liste_liaisons');
            } else {
                $this->addFlash('info', "Liaison incorrecte.");
            }
        }
        return $this->render(':Admin/Liaison:update.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("admin/liaison/supprimer/{id}", name="admin_liaison_delete")
     */
    public function adminLiaisonDeleteAction(Liaison $liaison)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($liaison);
        $em->flush();
        $this->addFlash('error', "Liaison supprimée.");
        return $this->redirectToRoute('admin_liste_liaisons');
    }

    /**
     * @Route("admin/ingredient/ajouter", name="admin_ingredient_add")
     */
    public function adminIngredientAddAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $ingredient = new Ingredient();
        $em->persist($ingredient);

        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em->flush();
                $this->addFlash('success', "Ingrédient ajouté.");
                return $this->redirectToRoute('admin_liste_ingredients');
            } else {
                $this->addFlash('info', "Ingrédient incorrect.");
            }
        }
        return $this->render(':Admin/Ingredient:add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("admin/ingredient/modifier/{id}", name="admin_ingredient_update")
     */
    public function adminIngredientUpdateAction(Request $request, Ingredient $ingredient)
    {
        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash('success', "Ingrédient modifié.");
                return $this->redirectToRoute('admin_liste_ingredients');
            } else {
                $this->addFlash('info', "Ingrédient incorrect.");
            }
        }
        return $this->render(':Admin/Ingredient:update.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("admin/ingredient/supprimer/{id}", name="admin_ingredient_delete")
     */
    public function adminIngredientDeleteAction(Ingredient $ingredient)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($ingredient);
        $em->flush();
        $this->addFlash('error', "Ingrédient supprimé.");
        return $this->redirectToRoute('admin_liste_ingredients');
    }
}
