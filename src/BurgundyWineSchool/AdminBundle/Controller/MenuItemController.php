<?php
/**
*   MenuItem controller
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
use BurgundyWineSchool\CmsBundle\Entity\MenuItem;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
* MenuItem controller (create, index)
*
* @category  PHP
* @package   Trunkadmin
* @author    Felix MOTOT <felix@motot.fr>
* @copyright 2015 Félix Motot
* @license   Sopra http://choosealicense.com/licenses/bsd-2-clause/
* @link      http://soprasteria.com  
*/
class MenuItemController extends Controller
{
    /**
    * Display menu items list
    *
    * @param string $templateName name of template to be displayed
    *
    * @return void
    */
    public function listAction($templateName)
    {    
        $repository = $this->getDoctrine()->getManager()->getRepository(
            'CmsBundle:MenuItem'
        );
        $menuItems = $repository->FindAll();
        
        return $this->render(
            'AdminBundle:MenuItem:' . $templateName . '.html.twig', array(
                'menuItems' => $menuItems,
            )
        );
    }

    /**
    * Create / Update a menuItem
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
        if (!isset($id)) {
            $menuItem = new MenuItem();
        } else {
            $repository = $em->getRepository('CmsBundle:MenuItem');
            $menuItem = $repository->findOneById($id);
        }
        $form = $this->createForm('menuItem', $menuItem);
        
        if ($form->handleRequest($request)->isValid()
        ) { // check if form has been submitted) {
            $repository = $em->getRepository('CmsBundle:Page');
            // if ($menuItem->getPage() != null) {
                // $page = $repository->findOneById($menuItem->getPage()->getId());
                // $page->setMenuItem($menuItem);
                // $em->persist($page);
            // }
            $em->persist($menuItem);
            $em->flush();
            
            $request->getSession()->getFlashBag()->add(
                'notice', 'Elément enregistré avec succès.'
            );
            if ($form->get('Enregistrer')->isClicked()) {
            
                return $this->redirect($this->generateUrl('admin_menu_item_update', array('id' => $menuItem->getId())));
            } else {
                
                return $this->redirect($this->generateUrl('admin_menu_item_list'));
            }
        }
        
        return $this->render(
            'AdminBundle:MenuItem:' . $templateName . '.html.twig', array(
                'form' => $form->createView(), 'menuItem' => $menuItem
            )
        );
    }
    
    /**
    * Delete a menuItem
    *
    * @param int     $id           id of menuItem to be updated
    * @param Request $request      request
    * @param string  $templateName name of template to be displayed
    *
    * @return void
    */
    public function deleteAction($id, Request $request, $templateName)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('CmsBundle:MenuItem');
        $menuItem = $repository->findOneById($id);
        if ($menuItem != null) {
            $em->remove($menuItem);
            $em->flush();
                
            $request->getSession()->getFlashBag()->add(
                'notice', 'Elément supprimé avec succès.'
            );
        }
        
        return $this->redirect($this->generateUrl('admin_menu_item_list'));
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
                $repository = $em->getRepository('CmsBundle:MenuItem');
                $menuItem = $repository->findOneById($id);
                if ($menuItem != null) {
                    $em->remove($menuItem);
                    $em->flush();
                    
                    return new JsonResponse(
                        array(
                            'isSuccess' => "1"
                        )
                    );
                }
            } else {
                
                return new JsonResponse(
                    array(
                        'isSuccess' => "0"
                        , "notice" => "Cet élément n'existe pas
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
