<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Feedback;
use AppBundle\Entity\Phone;
use AppBundle\Entity\User;
use AppBundle\Exceptions\AppException;
use AppBundle\Models\Feedback\FeedbackType;
use AppBundle\Models\FlickrPhoto\FlickrPhoto;
use AppBundle\Models\FlickrPhoto\ResponseDecode;

use AppBundle\Models\Mars\SetData;
use AppBundle\Models\Registration\RegistrationData;
use AppBundle\Models\Registration\RegistrationFormType;
use Doctrine\Common\Collections\ArrayCollection;
use ReCaptcha\ReCaptcha;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator;

/**
 * Class DefaultController
 * @package AppBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * @var FlickrPhoto
     */
    private $photo;

    /**
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request) {
        return $this->render('menu.html.twig');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function menuAction(Request $request) {
        $response = new JsonResponse();
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $content = json_encode(['items' => [
                ['text' => $this->get('translator')->trans('flickr.photos'), 'path' => $this->generateUrl('flickrPhotos')],
                ['text' => $this->get('translator')->trans('mars'), 'path' => $this->generateUrl('exploringMars')],
                ['text' => $this->get('translator')->trans('users'), 'path' => $this->generateUrl('showUsers')],
                ['text' => $this->get('translator')->trans('sign.out'), 'path' => $this->generateUrl('logout'), 'target' => 'page']
            ]]);
        }
        else if ($this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
            $content = json_encode(['items' => [
                ['text' => $this->get('translator')->trans('flickr.photos'), 'path' => $this->generateUrl('flickrPhotos')],
                ['text' => $this->get('translator')->trans('sign.out'), 'path' => $this->generateUrl('logout'), 'target' => 'page'],
            ]]);
        }
        else {
            $content = json_encode(['items' => [
                ['text' => $this->get('translator')->trans('sign.in'), 'path' => $this->generateUrl('login_route'), 'target' => 'page'],
                ['text' => $this->get('translator')->trans('sign.up'), 'path' => $this->generateUrl('registration'), 'target' => 'page']
            ]]);
        }
        $response->setContent($content);
        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function getRecentAction(Request $request) {
        $request->attributes->set('_locale', $request->getSession()->get('_locale'));
        $requestInfo = $this->setRequest('getRecent', $this->photo);
        if ($requestInfo instanceof Request) {
            $request->initialize($requestInfo->query->all(), $requestInfo->request->all(),
                $requestInfo->attributes->all(), $requestInfo->cookies->all(), $requestInfo->files->all(),
                $requestInfo->server->all(), $requestInfo->getContent());
            $responseDecode = $this->setData($this->photo);
            $arrayPhotos = $responseDecode->decodeRecent();
            foreach ($arrayPhotos as $photo) {
                $response = $this->forward('AppBundle:Default:getSizes', array(
                    'photo' => $photo
                ));
                if ($response->getContent() == $this->get('translator')->trans('no.method')) {
                    $html = $this->render('flickrPhoto/error.html.twig', array(
                        'message' => $response->getContent()))->getContent();
//                    return $this->render('flickrPhoto/error.html.twig', array(
//                        'message' => $response->getContent()));
                }
            }
            $html = $this->render('flickrPhoto/photo.html.twig', array(
                'arrayPhotos' => $arrayPhotos,
                'count' => count($arrayPhotos)
            ))->getContent();
//            return $this->render('flickrPhoto/photo.html.twig', array(
//                'arrayPhotos' => $arrayPhotos,
//                'count' => count($arrayPhotos)
//            ));
        }
        else {
            $html = $this->render('flickrPhoto/error.html.twig', array(
                'message' => $requestInfo
            ))->getContent();
//            return $this->render('flickrPhoto/error.html.twig', array(
//                'message' => $requestInfo
//            ));
        }
        $response = $this->createJsonResponse($html, $this->get('translator')->trans('flickr.photos'));
        return $response;
    }

    /**
     * @param FlickrPhoto $photo
     * @param Request $request
     * @return Response
     */
    public function getSizesAction(FlickrPhoto $photo, Request $request) {
        $requestInfo = $this->setRequest('getSizes', $photo);
        if ($requestInfo instanceof Request) {
            $request->initialize($requestInfo->query->all(), $requestInfo->request->all(),
                $requestInfo->attributes->all(), $requestInfo->cookies->all(), $requestInfo->files->all(),
                $requestInfo->server->all(), $requestInfo->getContent());
            $responseDecode = $this->setData($photo);
            $this->photo = $responseDecode->decodeSizes();
            return new Response();
        }
        else {
            return new Response($requestInfo);
        }
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function marsAction(Request $request) {
        $setData = new SetData();
        $results = [];
        $form = $this->createForm($this->get('mars_type'), $setData, ['attr' => ['novalidate' => 'novalidate']]);
        $form->handleRequest($request);
        $recaptchaResponse = $request->request->get('g-recaptcha-response');
        if ($form->isSubmitted() && $form->isValid()) {
            $verifyResponse = $this->verifyRecaptcha($recaptchaResponse);
            if ($verifyResponse) {
                $setData->setAll();
                $results = $setData->execute();
            }
            else {
                $form->addError(new FormError($this->get('translator')->trans('recaptcha.check', [], 'validators')));
            }
        }
        $html = $this->render('mars/mars.html.twig', array(
            'form' => $form->createView(),
            'results' => $results
        ))->getContent();
        $response = $this->createJsonResponse($html, $this->get('translator')->trans('mars'));
        return $response;
//        return $this->render('mars/mars.html.twig', array(
//            'form' => $form->createView(),
//            'results' => $results
//        ));
    }

    /**
     * @param $html
     * @return JsonResponse
     */
    public function createJsonResponse($html, $data) {
        $response = new JsonResponse();
        $content = json_encode(['html' => $html, 'data' => $data]);
        $response->setContent($content);
        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function registerAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $registrationData = new RegistrationData();
        $formSignUp = $this->createForm(new RegistrationFormType(), $registrationData, [
            'attr' => ['novalidate' => 'novalidate'],
        ]);
        $formSignUp->handleRequest($request);
        $recaptchaResponse = $request->request->get('g-recaptcha-response');
        if ($formSignUp->isSubmitted() && $formSignUp->isValid()) {
            $verifyResponse = $this->verifyRecaptcha($recaptchaResponse);
            if ($verifyResponse) {
                $registration = $formSignUp->getData();
                $user = $registration->getUser();
                $encoder = $this->container->get('security.password_encoder');
                $encodedPassword = $encoder->encodePassword($user, $user->getPassword());
                $user->setPassword($encodedPassword);
                $user->setRoles(['ROLE_USER']);
                $em->persist($user);
                $em->flush();
                return $this->redirectToRoute('login_route');
            }
            else {
                $formSignUp->addError(new FormError($this->get('translator')->trans('recaptcha.check', [], 'validators')));
            }
        }
        return $this->render('registration/registration.html.twig', [
            'form_sign_up' => $formSignUp->createView(),
        ]);
    }

    /**
     * @return Response
     */
    public function showUsersAction() {
        $users = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->findAll();
        $phones = $this->getDoctrine()
            ->getRepository('AppBundle:Phone')
            ->findBy(['user' => $users]);
        $html = $this->render('registration/display.html.twig', ['users' => $users, 'phones' => $phones])->getContent();
        $response = $this->createJsonResponse($html, $this->get('translator')->trans('users'));
        return $response;
//        return $this->render('registration/display.html.twig', ['users' => $users, 'phones' => $phones]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function removeUserAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->find($id);
        $phones = new ArrayCollection();
        foreach ($user->getPhones() as $phone) {
            $phones->add($phone);
        }
        foreach ($phones as $phone) {
            if (false !== $user->getPhones()->contains($phone)) {
                $phone->setUser(null);
                $em->remove($phone);
            }
        }
        $em->remove($user);
        $em->flush();
        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function validateAction(Request $request) {
        $response = new JsonResponse();
        $errors = new ConstraintViolationList();
        $em = $this->getDoctrine()->getManager();
        $name = $request->request->get('name');
        $value = $request->request->get('value');
        if (strpos($name, 'app_registration') !== false) {
            $propertiesUser = $em->getClassMetadata('AppBundle:User')->getFieldNames();
            $propertiesPhone = $em->getClassMetadata('AppBundle:Phone')->getFieldNames();
            $properties = array_unique(array_merge($propertiesUser, $propertiesPhone));
            $object = new User();
        }
        else if (strpos($name, 'app_feedback') !== false) {
            $properties = $em->getClassMetadata('AppBundle:Feedback')->getFieldNames();
            $object = new Feedback();
        }
        if ($name == 'g-recaptcha-response') {
            $verifyResponse = $this->verifyRecaptcha($value);
            if ($verifyResponse) {
                $content = json_encode(['code' => 0]);
            }
            else {
                $content = json_encode(['code' => 1, 'message' => $this->get('translator')->trans('recaptcha.check', [], 'validators')]);
            }
        }
        else {
            $content = $this->validateValue($object, $properties, $name, $value, $request);
        }
        $response->setContent($content);
        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function feedbackAction(Request $request) {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $name = $this->getUser()->getUsername();
            $readonly = true;
        }
        else {
            $name = '';
            $readonly = false;
        }
        $em = $this->getDoctrine()->getManager();
        $feedback = new Feedback();
        $form = $this->createForm(new FeedbackType(), $feedback, ['attr' => ['novalidate' => 'novalidate']]);
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            $recaptchaResponse = $request->request->get('g-recaptcha-response');
            if ($form->isSubmitted() && $form->isValid()) {
                $verifyResponse = $this->verifyRecaptcha($recaptchaResponse);
                if ($verifyResponse) {
                    $feedback = $form->getData();
                    $em->persist($feedback);
                    $em->flush();
                    $response = new JsonResponse();
                    $response->setContent(json_encode(['code' => 0, 'message' => $this->get('translator')->trans('sent')]));
                    return $response;
                } else {
                    $form->addError(new FormError($this->get('translator')->trans('recaptcha.check', [], 'validators')));
                }
            }
        }
        return $this->render('feedback.html.twig', array(
            'form' => $form->createView(),
            'value' => $feedback->getMessage(),
            'name' => $name,
            'readonly' => $readonly
        ));
    }

    /**
     * @param $object
     * @param $properties
     * @param $name
     * @param $value
     * @param Request $request
     * @return string
     */
    public function validateValue($object, $properties, $name, $value, Request $request) {
        $validator = $this->get('validator');
        $content = '';
        foreach ($properties as $property) {
            if (strpos($name, $property) !== false) {
                if (strpos($name, 'number') !== false) {
                    $errors = $validator->validatePropertyValue(new Phone(), 'number', $value);
                } else if (strpos($name, '_username') !== false) {
                    $errors = $this->isUsernameValid($object, $value, $validator);
                } else {
                    $errors = $validator->validatePropertyValue($object, $property, $value);
                }

                if ($errors->has(0)) {
                    $content = json_encode(['code' => 1, 'message' => $errors->get(0)->getMessage()]);
                } else if (strpos($name, 'password') !== false && strpos($name, 'first') !== false) {
                    $content = $this->isPasswordStrong($value);
                } else if ((strpos($name, 'password') !== false && strpos($name, 'second') !== false)) {
                    $content = $this->doPasswordsMatch($request, $value);
                } else {
                    $content = json_encode(['code' => 0]);
                }

                break;
            }
        };
        return $content;
    }

    /**
     * @param User $user
     * @param $value
     * @param Validator\RecursiveValidator $validator
     * @return \Symfony\Component\Validator\ConstraintViolationListInterface
     */
    public function isUsernameValid(User $user, $value, Validator\RecursiveValidator $validator) {
        $user->setUsername($value);
        $unique = new UniqueEntity('_username');
        $unique->message = 'value.same';
        $errorsUnique = $validator->validate($user, $unique);
        $errors = $validator->validatePropertyValue($user, '_username', $value);
        if ($errorsUnique->has(0)) {
            $errors->add($errorsUnique->get(0));
        }
        return $errors;
    }

    /**
     * @param $value
     * @return string
     */
    public function isPasswordStrong($value) {
        if (strlen($value) <= 4) {
            $content = json_encode(['code' => 2, 'message' => $this->get('translator')->trans('password.weak')]);
        } else {
            $content = json_encode(['code' => 0, 'message' => $this->get('translator')->trans('password.strong')]);
        }
        return $content;
    }

    /**
     * @param Request $request
     * @param $value
     * @return string
     */
    public function doPasswordsMatch(Request $request, $value) {
        $firstValue = $request->request->get('first_value');
        if ($firstValue != $value) {
            $content = json_encode(['code' => 1, 'message' => $this->get('translator')->trans('value.confirm.error', [], 'validators')]);
        }
        else {
            $content = json_encode(['code' => 0]);
        }
        return $content;
    }

    /**
     * @param $value
     * @return bool
     */
    public function verifyRecaptcha($value) {
        $recaptcha = new ReCaptcha($this->container->getParameter('recaptcha_secret'));
        $verifyResponse = $recaptcha->verify($value);
        return $verifyResponse->isSuccess();
    }

    /**
     * @param FlickrPhoto|null $photo
     * @return mixed
     */
    public function setData(FlickrPhoto $photo = null) {
        $sendRequest = $this->get('curl');
        $data = substr($sendRequest->curlExec(), 14, -1);
        $responseDecode = ResponseDecode::getInstance();
        $responseDecode->setPhoto($photo);
        $responseDecode->setResponse($data);
        return $responseDecode;
    }

    /**
     * @param $apiMethod
     * @param FlickrPhoto|null $photo
     * @return Request
     *
     */
    public function setRequest($apiMethod, FlickrPhoto $photo = null) {
        $requestParameters = $this->get('request_parameters');
        try {
            switch ($apiMethod) {
                case 'getRecent':
                    $requestInfo = Request::create($this->container->getParameter('end_point'), 'GET',
                        $requestParameters->getRecent());
                    break;
                case 'getSizes':
                    $requestInfo = Request::create($this->container->getParameter('end_point'), 'GET',
                        $requestParameters->getSizes($photo->getId()));
                    break;
                default:
                    throw new AppException('no.method');
            }
        }
        catch (AppException $e) {
            $requestInfo = $this->get('translator')->trans($e);
        }
        return $requestInfo;
    }
}
