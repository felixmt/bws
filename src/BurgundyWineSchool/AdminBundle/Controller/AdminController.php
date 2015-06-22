<?php

namespace BurgundyWineSchool\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BurgundyWineSchool\AdminBundle\Entity\Appearance;

class AdminController extends Controller
{
    public function indexAction($templateName)
    {
        return $this->render('AdminBundle:Admin:' . $templateName . '.html.twig');
    }
    
    public function newAction(Request $request, $templateName)
    {
        $em = $this->getDoctrine()->getManager();
        
        // if (!isset($id)) {
            $appearance = new Appearance();
        // } else {
            // $repository = $em->getRepository('AdminBundle:Appearance');
            // $appearance = $repository->findOneById($id);
        // }
        
        $form = $this->createForm('appearance', $appearance);
        
        if ($form->handleRequest($request)->isValid()) {
            $em->persist($appearance);
            $em->flush();
            
            $request->getSession()->getFlashBag()->add('notice', 'Modifications enregistrées avec succès.');
            
            return $this->redirect($this->generateUrl('admin_appearance'));
        }
        
        return $this->render('AdminBundle:Admin:' . $templateName . '.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
