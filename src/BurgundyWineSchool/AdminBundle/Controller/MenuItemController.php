<?php

namespace BurgundyWineSchool\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BurgundyWineSchool\CmsBundle\Entity\MenuItem;
use Symfony\Component\HttpFoundation\JsonResponse;

class MenuItemController extends Controller
{
    public function listAction($templateName)
    {    
        $repository = $this->getDoctrine()->getManager()->getRepository('CmsBundle:MenuItem');
        $menuItems = $repository->FindAll();
        
        return $this->render('AdminBundle:MenuItem:' . $templateName . '.html.twig', array(
            'menuItems' => $menuItems,
        ));
    }

    public function newAction($id = null, Request $request, $templateName)
    {
        $em = $this->getDoctrine()->getManager();
        if (!isset($id)) {
            $menuItem = new MenuItem();
        } else {
            $repository = $em->getRepository('CmsBundle:MenuItem');
            $menuItem = $repository->findOneById($id);
        }
        $form = $this->createForm('menuItem', $menuItem);
        
        if ($form->handleRequest($request)->isValid()) { // check if form has been submitted) {
            $repository = $em->getRepository('CmsBundle:Page');
            // if ($menuItem->getPage() != null) {
                // $page = $repository->findOneById($menuItem->getPage()->getId());
                // $page->setMenuItem($menuItem);
                // $em->persist($page);
            // }
            $em->persist($menuItem);
            $em->flush();
            
            $request->getSession()->getFlashBag()->add('notice', 'Elément enregistré avec succès.');
            if ($form->get('Enregistrer')->isClicked()) {
            
                return $this->render('AdminBundle:MenuItem:' . $templateName . '.html.twig', array(
                    'form' => $form->createView(), 'menuItem' => $menuItem
                ));
            } else {
                return $this->redirect($this->generateUrl('admin_menu_item_list'));
            }
        }
        
        return $this->render('AdminBundle:MenuItem:' . $templateName . '.html.twig', array(
            'form' => $form->createView(), 'menuItem' => $menuItem
        ));
    }
    
    public function deleteAction($id, Request $request, $templateName)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('CmsBundle:MenuItem');
        $menuItem = $repository->findOneById($id);
        if ($menuItem != null) {
            $em->remove($menuItem);
            $em->flush();
                
            $request->getSession()->getFlashBag()->add('notice', 'Elément supprimé avec succès.');
        }
        
        return $this->redirect($this->generateUrl('admin_menu_item_list'));
    }
    
    public function deleteAjaxAction($templateName)
    {
        $request = $this->container->get('request');

        if($request->isXmlHttpRequest())
        {
            $id = '';
            $id = $request->request->get('id');
            
            if ($id != '') {
                $em = $this->getDoctrine()->getManager();
                $repository = $em->getRepository('CmsBundle:MenuItem');
                $menuItem = $repository->findOneById($id);
                if ($menuItem != null) {
                    $em->remove($menuItem);
                    $em->flush();
                    
                    return new JsonResponse(array('isSuccess' => "1"/*, "notice" => "Element supprimé avec succès"*/));
                }
            } else {
                
                return new JsonResponse(array('isSuccess' => "0", "notice" => "Cet élément n'existe pas, veuillez actualiser la page et réessayer."));
            }
        } else {
            
            return new JsonResponse(array('isSuccess' => "0", "notice" => "Une erreur s'est produite, veuillez réessayer."));
        }
    }
}
