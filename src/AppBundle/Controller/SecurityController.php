<?php
/**
 * Created by PhpStorm.
 * User: vkalachikhin
 * Date: 10.09.15
 * Time: 15:17
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Models\Registration\RegistrationData;
use AppBundle\Models\Registration\RegistrationFormType;
use Symfony\Component\Form\FormError;

class SecurityController extends Controller
{

    /**
     * @param Request $request
     * @return Response
     */
//    public function loginAction(Request $request)
//    {
//        $authenticationUtils = $this->get('security.authentication_utils');
//
//        // get the login error if there is one
//        $error = $authenticationUtils->getLastAuthenticationError();
//
//        // last username entered by the user
//        $lastUsername = $authenticationUtils->getLastUsername();
//
//        return $this->render(
//            'security/login.html.twig',
//            array(
//                // last username entered by the user
//                'last_username' => $lastUsername,
//                'error'         => $error,
//            )
//        );
//    }

    public function loginAction(Request $request) {
        $doctrine = $this->getDoctrine();
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $em = $doctrine->getManager();
        $registrationData = new RegistrationData();
        $formSignUp = $this->createForm(new RegistrationFormType(), $registrationData, ['attr' => ['novalidate' => 'novalidate']]);
//        $signInData = new SignInData();
//        $formSignIn = $this->createForm(new SignInFormType(), $signInData, ['attr' => ['novalidate' => 'novalidate']]);
        if ('POST' === $request->getMethod()) {
            if ($request->request->has('app_registration'))
            {
                $formSignUp->handleRequest($request);
                if ($formSignUp->isSubmitted() && $formSignUp->isValid()) {
                    $registration = $formSignUp->getData();
                    $em->persist($registration->getUser());
                    $em->flush();
                    return $this->redirectToRoute('admin');
                }
            }
//            else {
//                if ($request->request->has('app_sign_in')) {
//                    $formSignIn->handleRequest($request);
//                    if ($formSignIn->isSubmitted() && $formSignIn->isValid()) {
//                        $users = $doctrine
//                            ->getRepository('AppBundle:User')
//                            ->findOneBy([
//                                '_username' => $formSignIn->getData()->getUsername(),
//                                '_password' => $formSignIn->getData()->getPassword()
//                            ]);
//                        if (!$users) {
//                            $formSignIn->addError(new FormError($this->get('translator')->trans('user.not.found')));
//                        } else {
//                            return $this->redirectToRoute('showUsers');
//                        }
//                    }
//                }
//            }
        }
        return $this->render('security/login.html.twig', [
            'form_sign_up' => $formSignUp->createView(),
            'last_username' => $lastUsername,
            'error'         => $error,
//            'form_sign_in' => $formSignIn->createView()
        ]);
    }

    /**
     *
     */
    public function loginCheckAction()
    {
        // this controller will not be executed,
        // as the route is handled by the Security system
    }

}