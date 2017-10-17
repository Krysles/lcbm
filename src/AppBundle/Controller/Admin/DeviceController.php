<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\CookingType;
use AppBundle\Entity\CookingUnity;
use AppBundle\Entity\DeviceMode;
use AppBundle\Entity\DeviceType;
use AppBundle\Entity\Ingredient;
use AppBundle\Entity\Liaison;
use AppBundle\Entity\Unity;
use AppBundle\Form\Type\CookingTypeType;
use AppBundle\Form\Type\CookingUnityType;
use AppBundle\Form\Type\DeviceModeType;
use AppBundle\Form\Type\DeviceTypeType;
use AppBundle\Form\Type\IngredientType;
use AppBundle\Form\Type\LiaisonType;
use AppBundle\Form\Type\UnityType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DeviceController extends Controller
{
    /**
     * @Route("admin/appareil/type/ajouter", name="admin_device_type_add")
     */
    public function adminDeviceTypeAddAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $deviceType = new DeviceType();
        $em->persist($deviceType);

        $form = $this->createForm(DeviceTypeType::class, $deviceType);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em->flush();
                $this->addFlash('success', "Type d'appareil ajouté.");
                return $this->redirectToRoute('admin_liste_device_type');
            } else {
                $this->addFlash('info', "Type d'appareil incorrect.");
            }
        }
        return $this->render(':Admin/DeviceType:add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("admin/appareil/type/modifier/{id}", name="admin_device_type_update")
     */
    public function adminDeviceTypeUpdateAction(Request $request, DeviceType $deviceType)
    {
        $form = $this->createForm(DeviceTypeType::class, $deviceType);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash('success', "Type d'appareil modifié..");
                return $this->redirectToRoute('admin_liste_device_type');
            } else {
                $this->addFlash('info', "Type d'appareil incorrect.");
            }
        }
        return $this->render(':Admin/DeviceType:update.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("admin/appareil/type/supprimer/{id}", name="admin_device_type_delete")
     */
    public function adminDeviceTypeDeleteAction(DeviceType $deviceType)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($deviceType);
        $em->flush();
        $this->addFlash('error', "Type d'appareil supprimé.");
        return $this->redirectToRoute('admin_liste_device_type');
    }

    /**
     * @Route("admin/appareil/mode/ajouter", name="admin_device_mode_add")
     */
    public function adminDeviceModeAddAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $deviceMode = new DeviceMode();
        $em->persist($deviceMode);

        $form = $this->createForm(DeviceModeType::class, $deviceMode);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em->flush();
                $this->addFlash('success', "Mode d'appareil ajouté.");
                return $this->redirectToRoute('admin_liste_device_mode');
            } else {
                $this->addFlash('info', "Mode d'appareil incorrect.");
            }
        }
        return $this->render(':Admin/DeviceMode:add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("admin/appareil/mode/modifier/{id}", name="admin_device_mode_update")
     */
    public function adminDeviceModeUpdateAction(Request $request, DeviceMode $deviceMode)
    {
        $form = $this->createForm(DeviceModeType::class, $deviceMode);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash('success', "Mode d'appareil modifié.");
                return $this->redirectToRoute('admin_liste_device_mode');
            } else {
                $this->addFlash('info', "Mode d'appareil incorrecte.");
            }
        }
        return $this->render(':Admin/DeviceMode:update.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("admin/appreil/mode/supprimer/{id}", name="admin_device_mode_delete")
     */
    public function adminDeviceModeDeleteAction(DeviceMode $deviceMode)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($deviceMode);
        $em->flush();
        $this->addFlash('error', "Mode d'appareil supprimé.");
        return $this->redirectToRoute('admin_liste_device_mode');
    }
}
