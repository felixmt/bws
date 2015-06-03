<?php
// src/BurgundyWineSchool/UserBundle/Controller/SecurityController.php;
namespace BurgundyWineSchool\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security; // annotation : /** *]Security('has_role('ROLE_ADMIN')") en entete de fction*/
use FOS\UserBundle\Controller\SecurityController as BaseController;

class SecurityController extends BaseController
{
    public function loginAction(Request $request)
    {
            echo "jojo"; die;
    }
    /*    // if user already logged
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('index'));
        }
        
        $session = $request->getSession();
        
        // check if errors from last form submission
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }
        
        return $this->render('UserBundle:Security:login.html.twig', array (
            // last username filled out by user
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        ));
    }*/
}