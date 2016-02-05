<?php
namespace AppBundle\Controller;

use AppBundle\Form\LoginType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class LoginController
 * @package AppBundle\Controller
 *
 * @Route("/login")
 */
class LoginController extends Controller
{

    const SESSION_LOGIN_USER = 'user_login';
    const SESSION_ADMIN_USER = 'admin_login';

    /**
     * @Route("/", name="login_index")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm(LoginType::class, null, [
            'method' => 'post'
        ]);
        $form->add('submit', SubmitType::class, [
            'label' => 'Login'
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $password = $form->getData()['login'];
            if ($password == $this->getParameter('admin_login')) {
                $this->get('session')->set(self::SESSION_ADMIN_USER, true);
                $this->get('session')->set(self::SESSION_LOGIN_USER, true);
                return $this->redirectToRoute('homepage');
            }

            if ($password == $this->getParameter('user_login')) {
                $this->get('session')->set(self::SESSION_LOGIN_USER, true);
                return $this->redirectToRoute('homepage');
            }

            $form->addError(new FormError('Forkert kodeord'));
        }

        return $this->render('::login.html.twig', [
            'form' => $form->createView()
        ]);
    }

}