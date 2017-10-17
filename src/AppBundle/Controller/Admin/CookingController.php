<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\CookingType;
use AppBundle\Entity\CookingUnity;
use AppBundle\Entity\Ingredient;
use AppBundle\Entity\Liaison;
use AppBundle\Entity\Unity;
use AppBundle\Form\Type\CookingTypeType;
use AppBundle\Form\Type\CookingUnityType;
use AppBundle\Form\Type\IngredientType;
use AppBundle\Form\Type\LiaisonType;
use AppBundle\Form\Type\UnityType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CookingController extends Controller
{
    /**
     * @Route("admin/cuisson/type/ajouter", name="admin_cooking_type_add")
     */
    public function adminCookingTypeAddAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $cookingType = new CookingType();
        $em->persist($cookingType);

        $form = $this->createForm(CookingTypeType::class, $cookingType);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em->flush();
                $this->addFlash('success', "Type de cuisson ajoutée.");
                return $this->redirectToRoute('admin_liste_cuisson_type');
            } else {
                $this->addFlash('info', "Type de cuisson incorrecte.");
            }
        }
        return $this->render(':Admin/CookingType:add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("admin/cuisson/type/modifier/{id}", name="admin_cooking_type_update")
     */
    public function adminCookingTypeUpdateAction(Request $request, CookingType $cookingType)
    {
        $form = $this->createForm(CookingTypeType::class, $cookingType);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash('success', "Type de cuisson modifiée.");
                return $this->redirectToRoute('admin_liste_cuisson_type');
            } else {
                $this->addFlash('info', "Type de cuisson incorrecte.");
            }
        }
        return $this->render(':Admin/CookingType:update.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("admin/cuisson/type/supprimer/{id}", name="admin_cooking_type_delete")
     */
    public function adminCookingTypeDeleteAction(CookingType $cookingType)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($cookingType);
        $em->flush();
        $this->addFlash('error', "Type de cuisson supprimée.");
        return $this->redirectToRoute('admin_liste_cuisson_type');
    }

    /**
     * @Route("admin/cuisson/unite/ajouter", name="admin_cooking_unity_add")
     */
    public function adminCookingUnityAddAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $cookingUnity = new CookingUnity();
        $em->persist($cookingUnity);

        $form = $this->createForm(CookingUnityType::class, $cookingUnity);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em->flush();
                $this->addFlash('success', "Unité de cuisson ajoutée.");
                return $this->redirectToRoute('admin_liste_cuisson_unity');
            } else {
                $this->addFlash('info', "Unité de cuisson incorrecte.");
            }
        }
        return $this->render(':Admin/CookingUnity:add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("admin/cuisson/unite/modifier/{id}", name="admin_cooking_unity_update")
     */
    public function adminCookingUnityUpdateAction(Request $request, CookingUnity $cookingUnity)
    {
        $form = $this->createForm(CookingUnityType::class, $cookingUnity);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash('success', "Unité de cuisson modifiée.");
                return $this->redirectToRoute('admin_liste_cuisson_unity');
            } else {
                $this->addFlash('info', "Unité de cuisson incorrecte.");
            }
        }
        return $this->render(':Admin/CookingUnity:update.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("admin/cuisson/unite/supprimer/{id}", name="admin_cooking_unity_delete")
     */
    public function adminCookingUnityDeleteAction(CookingUnity $cookingUnity)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($cookingUnity);
        $em->flush();
        $this->addFlash('error', "Unité de cuisson supprimée.");
        return $this->redirectToRoute('admin_liste_cuisson_unity');
    }
}
