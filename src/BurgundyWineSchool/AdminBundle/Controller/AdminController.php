<?php
/**
*   Admin controller
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
use BurgundyWineSchool\AdminBundle\Entity\Appearance;

/**
* Admin controller (create, index)
*
* @category  PHP
* @package   Trunkadmin
* @author    Felix MOTOT <felix@motot.fr>
* @copyright 2015 Félix Motot
* @license   Sopra http://choosealicense.com/licenses/bsd-2-clause/
* @link      http://soprasteria.com  
*/
class AdminController extends Controller
{
    /**
    * Display appearance customization
    *
    * @param string $templateName name of template to be displayed
    *
    * @return void
    */
    public function indexAction($templateName)
    {
        return $this->render('AdminBundle:Admin:' . $templateName . '.html.twig');
    }
    
    /**
    * Edit appearance 
    *
    * @param Request $request      form status
    * @param string  $templateName name of template to display
    *
    * @return void
    */
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
            
            $request->getSession()->getFlashBag()->add(
                'notice', 'Modifications enregistrées avec succès.'
            );
            
            return $this->redirect($this->generateUrl('admin_appearance'));
        }
        
        return $this->render(
            'AdminBundle:Admin:' . $templateName . '.html.twig', array(
                'form' => $form->createView(),
            )
        );
    }
}
