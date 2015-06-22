<?php

namespace BurgundyWineSchool\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BurgundyWineSchool\CmsBundle\Entity\Page;
use Symfony\Component\HttpFoundation\JsonResponse;

class PageController extends Controller
{
    public function listAction($templateName)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('CmsBundle:Page');
        $pages = $repository->FindAll();
        
        return $this->render('AdminBundle:Page:' . $templateName . '.html.twig', array (
            'pages' => $pages,
        ));
    }
    
    public function newAction($id = null, Request $request, $templateName)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('CmsBundle:Page');
        if (!isset($id)) {
            $page = new Page();
        } else {
            $page = $repository->findOneById($id);
        }
        
        $form = $this->createForm('page', $page);
        
        if ($form->handleRequest($request)->isValid()) {
            if ($page->getIsHomepage()) {
                $pages = $repository->FindAll();
                foreach ($pages as $tmp) {
                    if ($tmp->getId() != $page->getId()) {
                        $tmp->setIsHomepage(0);
                        $em->persist($tmp);
                    }
                }
            }
            $em->persist($page);
            $em->flush();
            
            $request->getSession()->getFlashBag()->add('notice', 'Page enregistrée avec succès.');
            
            if ($form->get('Enregistrer')->isClicked()) {
                
                return $this->render('AdminBundle:Page:' . $templateName . '.html.twig', array(
                    'form' => $form->createView(), 'page' => $page
                ));
            } else {
                
                return $this->redirect($this->generateUrl('admin_page_list'));
            }
        }
        
        return $this->render('AdminBundle:Page:' . $templateName . '.html.twig', array(
            'form' => $form->createView(), 'page' => $page
        ));
    }
    
    public function deleteAction($id, Request $request, $templateName)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('CmsBundle:Page');
        $page = $repository->findOneById($id);
        if ($page != null) {
            if ($page->getIsHomepage()) {
                $request->getSession()->getFlashBag()->add('warning', 'Cette page est définie en temps que page d\'accueil, veuillez en définir une autre en tant que telle avant de la supprimer.');
            } else {
                $em->remove($page);
                $em->flush();
                $request->getSession()->getFlashBag()->add('notice', 'Page supprimée avec succès.');
            }
        }
        
        // $pages = $repository->FindAll();
        
        // return $this->render('AdminBundle:Page:' . $templateName . '.html.twig', array (
            // 'pages' => $pages,
        // ));
        
        return $this->redirect($this->generateUrl('admin_page_list'));
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
                $repository = $em->getRepository('CmsBundle:Page');
                $page = $repository->findOneById($id);
                if ($page != null) {
                    if ($page->getIsHomepage()) {

                        return new JsonResponse(array('isSuccess' => "0", "notice" => "Cette page est utilisée comme page d'accueil, veuillez en définir une autre en tant que telle avant de la supprimer."));
                    } else {
                        $em->remove($page);
                        $em->flush();

                        return new JsonResponse(array('isSuccess' => "1"/*, "notice" => "Page supprimée avec succès"*/));
                    }
                }
            } else {

                return new JsonResponse(array('isSuccess' => "0", "notice" => "Cette page n'existe pas, veuillez actualiser la page et réessayer."));
            }
        } else {

            return new JsonResponse(array('isSuccess' => "0", "notice" => "Une erreur s'est produite, veuillez réessayer."));
        }
    }
}
