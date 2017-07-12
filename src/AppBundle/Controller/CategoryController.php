<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Subcategory;
use AppBundle\Form\Type\CategoryType;
use AppBundle\Form\Type\SubcategoryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends Controller
{
    /**
     * @Route("admin", name="admin")
     */
    public function adminAction()
    {
        return $this->render(':Admin:dashboard.html.twig');
    }

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
     * @Route("admin/liste/categorie/{id}", name="admin_liste_category")
     */
    public function adminListeCategoryAction(Category $category)
    {
        return $this->render(':Admin/Liste:subcategories.html.twig', array(
            'category' => $category
        ));
    }

    /**
     * @Route("admin/categorie/ajouter", name="admin_category_add")
     */
    public function adminCategoryAddAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $category = new Category();
        $em->persist($category);

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em->flush();
                $this->addFlash('success', "Catégorie ajoutée.");
                return $this->redirectToRoute('admin_liste_categories');
            } else {
                $this->addFlash('info', "Catégorie incorrecte.");
            }
        }
        return $this->render(':Admin/Category:add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("admin/categorie/modifier/{id}", name="admin_category_update")
     */
    public function adminCategoryUpdateAction(Request $request, Category $category)
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash('success', "Catégorie modifiée.");
                return $this->redirectToRoute('admin_liste_categories');
            } else {
                $this->addFlash('info', "Catégorie incorrecte.");
            }
        }
        return $this->render(':Admin/Category:update.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("admin/categorie/supprimer/{id}", name="admin_category_delete")
     */
    public function adminCategoryDeleteAction(Category $category)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();
        $this->addFlash('error', "Catégorie supprimée.");
        return $this->redirectToRoute('admin_liste_categories');
    }

    /**
     * @Route("admin/sous-categorie/ajouter/{id}", name="admin_subcategory_add")
     */
    public
    function subcategoryAddAction(Category $category, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $subcategory = new Subcategory();
        $subcategory->setCategory($category);
        $em->persist($subcategory);

        $form = $this->createForm(SubcategoryType::class, $subcategory);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em->flush();
                $this->addFlash('info', "Sous-catégorie ajoutée.");
                return $this->redirectToRoute('admin_liste_category', array('id' => $subcategory->getCategory()->getId()));
            } else {
                $this->addFlash('info', "Sous-catégorie incorrecte.");
            }
        }
        return $this->render(':Admin/Subcategory:add.html.twig', array(
            'form' => $form->createView(),
            'category' => $category
        ));
    }

    /**
     * @Route("admin/sous-categorie/modifier/{id}", name="admin_subcategory_update")
     */
    public function adminSubcategoryUpdateAction(Request $request, Subcategory $subcategory)
    {
        $form = $this->createForm(SubcategoryType::class, $subcategory);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash('success', "Sous-catégorie modifiée.");
                return $this->redirectToRoute('admin_liste_category', array('id' => $subcategory->getCategory()->getId()));
            } else {
                $this->addFlash('info', "Catégorie incorrecte.");
            }
        }
        return $this->render(':Admin/Subcategory:update.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("admin/sous-categorie/supprimer/{id}", name="admin_subcategory_delete")
     */
    public function adminSubcategoryDeleteAction(Subcategory $subcategory)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($subcategory);
        $em->flush();
        $this->addFlash('error', "Sous-catégorie supprimée.");
        return $this->redirectToRoute('admin_liste_category', array('id' => $subcategory->getCategory()->getId()));
    }
}
