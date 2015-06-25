<?php
/**
*   Default Controller
*
*   PHP version 5.5.12
*
*   @category  PHP
*   @package   Cmsundle
*   @author    Felix MOTOT <felix@motot.fr>
*   @copyright 2015 Félix Motot
*   @license   Sopra http://choosealicense.com/licenses/bsd-2-clause/
*   @link      http://burgundywineschool.com
*/

namespace BurgundyWineSchool\CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
* Default controller
*
* @category  PHP
* @package   Trunkadmin
* @author    Felix MOTOT <felix@motot.fr>
* @copyright 2015 Félix Motot
* @license   Sopra http://choosealicense.com/licenses/bsd-2-clause/
* @link      http://soprasteria.com  
*/
class DefaultController extends Controller
{
    /**
    * Display pages
    *
    * @param string $templateName name of template to be displayed
    * @param string $route        page asked
    *
    * @return void
    */
    public function indexAction($templateName, $route = null)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(
            'CmsBundle:MenuItem'
        );
        $menuItems = $repository->FindAll();
        
        if (isset($route)) {
            $menuItem = $repository->findOneByRoute($route);
            if ($menuItem != null) {
                $content = $menuItem->getPage();
            } else {
                $repository = $this->getDoctrine()->getManager()->getRepository(
                    'CmsBundle:Page'
                );
                $content = $repository->findOneByIsHomepage(1);
            }
        } else {
            $repository = $this->getDoctrine()->getManager()->getRepository(
                'CmsBundle:Page'
            );
            $content = $repository->findOneByIsHomepage(1);
        }
        
        return $this->render(
            'CmsBundle:Default:' . $templateName . '.html.twig', array(
                'menuItems' => $menuItems, 'content' => $content,
            )
        );
    }
}
