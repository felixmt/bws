<?php
/**
*   Subscriber Controller
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
use BurgundyWineSchool\CmsBundle\Entity\Subscriber;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
* Subscriber controller
*
* @category  PHP
* @package   Trunkadmin
* @author    Felix MOTOT <felix@motot.fr>
* @copyright 2015 Félix Motot
* @license   Sopra http://choosealicense.com/licenses/bsd-2-clause/
* @link      http://soprasteria.com  
*/
class SubscriberController extends Controller
{
    /**
    * NewAjax
    *
    * @param string $templateName name of template to be displayed
    *
    * @return void
    */
    public function newAjaxAction($templateName)
    {
        $request = $this->container->get('request');

        if ($request->isXmlHttpRequest()) {
            $name = '';
            $name = $request->request->get('name');
            $email = '';
            $email = $request->request->get('email');
            
            if ($name != '' && $email != '') {
                if (filter_var($email, FILTER_VALIDATE_EMAIL) != false) {
                    $em = $this->getDoctrine()->getManager();
                    $repository = $em->getRepository('CmsBundle:Subscriber');
                    $tmp = $repository->findOneByEmail($email);
                    if ($tmp != null) {
                    
                        return new JsonResponse(
                            array(
                                "isSuccess" => "0",
                                "notice" => "Cette adresse email est déjà 
                                    utilisée"
                            )
                        );
                    } else {
                        $tmp = new Subscriber();
                        $tmp->setName($name);
                        $tmp->setEmail($email);
                        
                        $em->persist($tmp);
                        $em->flush();
                        
                        $mc = $this->get('hype_mailchimp');
                        $data = $mc->getList()->addMerge_vars(
                            array(
                                'lname' => $name
                            )
                        )->subscribe($email);
                        
                        return new JsonResponse(
                            array(
                                "isSuccess" => "1",
                                "notice" => "Votre inscription a 
                                    bien été prise en compte."
                            )
                        );
                    }
                } else {
                    
                    return new JsonResponse(
                        array(
                            "'isSuccess" => "0", 
                            "notice" => "Veuillez entrer une adresse email valide."
                        )
                    );
                }
            } else {
                
                return new JsonResponse(
                    array(
                        "isSuccess" => "0",
                        "notice" => "Veuillez compléter tous les champs"
                    )
                );
            }
        } else {
            
            return new JsonResponse(
                array(
                    'isSuccess' => "0",
                    "notice" => "Une erreur s'est produite, veuillez réessayer."
                )
            );
        }
    }
    
    /**
    * New subscriber
    *
    * @param string $templateName name of template to be displayed
    *
    * @return void
    */
    // public function newAction($templateName)
    // {
        // $request = $this->container->get('request');
        
        // if ($tmp != null) {
        
        // } else {
            // $tmp = new Subscriber();
            // $tmp->setName($name);
            // $tmp->setEmail($email);
            
            // $em->persist($tmp);
            // $em->flush();
                    // }
        // $em = $this->getDoctrine()->getManager();
        // $repository = $em->getRepository('CmsBundle:MenuItem');
        // $menuItems = $repository->FindAll();
        
        // $repository = $em->getRepository('CmsBundle:Page');
        // $content = $repository->FindOneByIsHomepage(1);
        
        // return $this->render(
            // 'CmsBundle:Default:' . $templateName . '.html.twig', array(
            // 'menuItems' => $menuItems, 'content' => $content,
        // ));
    // }
}
