<?php

namespace BurgundyWineSchool\CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($templateName, $route = null)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('CmsBundle:MenuItem');
        $menuItems = $repository->FindAll();
        
        if (isset($route)) {
            $menuItem = $repository->findOneByRoute($route);
            if ($menuItem != null) {
                $content = $menuItem->getPage();
            } else {
                $repository = $this->getDoctrine()->getManager()->getRepository('CmsBundle:Page');
                $content = $repository->findOneByIsHomepage(1);
            }
        } else {
            $repository = $this->getDoctrine()->getManager()->getRepository('CmsBundle:Page');
            $content = $repository->findOneByIsHomepage(1);
        }
        
        return $this->render('CmsBundle:Default:' . $templateName . '.html.twig', array(
            'menuItems' => $menuItems, 'content' => $content,
        ));
    }
}
