<?php
/**
*   Page controller
*
*   PHP version 5.5.12
*
*   @category  PHP
*   @package   AdminBundle
*   @author    Felix MOTOT <felix@motot.fr>
*   @copyright 2015 Félix Motot
*   @license   Sopra http://choosealicense.com/licenses/bsd-2-clause/
*   @link      http://burgundywineschool.com
*/
namespace BurgundyWineSchool\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BurgundyWineSchool\CmsBundle\Entity\Page;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
* Page controller (create, index)
*
* @category  PHP
* @package   Trunkadmin
* @author    Felix MOTOT <felix@motot.fr>
* @copyright 2015 Félix Motot
* @license   Sopra http://choosealicense.com/licenses/bsd-2-clause/
* @link      http://soprasteria.com  
*/
class PageController extends Controller
{
    /**
    * Display pages list
    *
    * @param string $templateName name of template to be displayed
    *
    * @return void
    */
    public function listAction($templateName)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(
            'CmsBundle:Page'
        );
        $pages = $repository->FindAll();
        
        return $this->render(
            'AdminBundle:Page:' . $templateName . '.html.twig', array (
                'pages' => $pages,
            )
        );
    }
    
    /**
    * Create / Update a page
    *
    * @param Request $request      form status
    * @param string  $templateName name of template to be displayed
    * @param int     $id           id of menuItem to be updated
    *
    * @return void
    */
    public function newAction(Request $request, $templateName, $id = null)
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
            
            $request->getSession()->getFlashBag()->add(
                'notice', 'Page enregistrée avec succès.'
            );
            
            if ($form->get('Enregistrer')->isClicked()) {
                
                return $this->redirect($this->generateUrl('admin_page_update', array('id' => $page->getId())));
            } else {
                
                return $this->redirect($this->generateUrl('admin_page_list'));
            }
        }
        
        return $this->render(
            'AdminBundle:Page:' . $templateName . '.html.twig', array(
                'form' => $form->createView(), 'page' => $page
            )
        );
    }
    
    /**
    * Delete a page
    *
    * @param int     $id           id of page to be updated
    * @param Request $request      request
    * @param string  $templateName name of template to be displayed
    *
    * @return void
    */
    public function deleteAction($id, Request $request, $templateName)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('CmsBundle:Page');
        $page = $repository->findOneById($id);
        if ($page != null) {
            if ($page->getIsHomepage()) {
                $request->getSession()->getFlashBag()->add(
                    'warning', 'Cette page est définie en temps que page d\'accueil
                    , veuillez en définir une autre en tant que telle avant de la 
                    supprimer.'
                );
            } else {
                $em->remove($page);
                $em->flush();
                $request->getSession()->getFlashBag()->add(
                    'notice', 'Page supprimée avec succès.'
                );
            }
        }

        return $this->redirect($this->generateUrl('admin_page_list'));
    }
    
    /**
    * Ajax deletion of menuItem
    *
    * @return void
    */
    public function deleteAjaxAction()
    {
        $request = $this->container->get('request');

        if ($request->isXmlHttpRequest()) {
            $id = '';
            $id = $request->request->get('id');
            
            if ($id != '') {
                $em = $this->getDoctrine()->getManager();
                $repository = $em->getRepository('CmsBundle:Page');
                $page = $repository->findOneById($id);
                if ($page != null) {
                    if ($page->getIsHomepage()) {

                        return new JsonResponse(
                            array(
                                'isSuccess' => "0"
                                , "notice" => "Cette page est utilisée comme page 
                                    d'accueil, veuillez en définir une autre en 
                                    tant que telle avant de la supprimer."
                            )
                        );
                    } else {
                        $em->remove($page);
                        $em->flush();

                        return new JsonResponse(
                            array(
                                'isSuccess' => "1"
                            )
                        );
                    }
                }
            } else {

                return new JsonResponse(
                    array(
                        'isSuccess' => "0"
                        , "notice" => "Cette page n'existe pas
                            , veuillez actualiser la page et réessayer."
                    )
                );
            }
        } else {

            return new JsonResponse(
                array(
                    'isSuccess' => "0"
                    , "notice" => "Une erreur s'est produite, veuillez réessayer."
                )
            );
        }
    }
}
