<?php

namespace BurgundyWineSchool\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BurgundyWineSchool\CmsBundle\Entity\Page;

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
        if (!isset($id)) {
            $page = new Page();
        } else {
            $repository = $em->getRepository('CmsBundle:Page');
            $page = $repository->findOneById($id);
        }
        
        $form = $this->createForm('page', $page);
        
        if ($form->handleRequest($request)->isValid()) {
            if (isset($id) && $page->getIsHomepage()) {
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
            
            return $this->redirect($this->generateUrl('admin_page_list'));
        }
        return $this->render('AdminBundle:Page:' . $templateName . '.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
