<?php
namespace AppBundle\Controller;

use AppBundle\Form\BookType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AdminController
 * @package AppBundle\Controller
 *
 * @Route("/admin")
 */
class AdminController extends Controller
{

    /**
     * @Route("/", name="admin_index")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        if (! $this->get('session')->has(LoginController::SESSION_ADMIN_USER)) {
            return $this->redirectToRoute('login_index');
        }

        $form = $this->createForm(BookType::class, null, [
            'method' => 'post'
        ]);
        $form->add('submit', SubmitType::class, [
            'label' => 'Add book'
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('app.service.book')->addBook($form->getData());
            return $this->redirectToRoute('admin_index');
        }

        return $this->render('::admin.html.twig', [
            'books' => $this->get('app.service.book')->getBooks(),
            'deleteable' => true,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/{uniqid}", name="admin_delete")
     * @param string $uniqid
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($uniqid)
    {
        if (! $this->get('session')->has(LoginController::SESSION_ADMIN_USER)) {
            return $this->redirectToRoute('login_index');
        }

        $this->get('app.service.book')->deleteBook($uniqid);
        return $this->redirectToRoute('admin_index');
    }

}
