<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class IndexController
 * @package AppBundle\Controller
 *
 * @Route("/")
 */
class IndexController extends Controller
{

    /**
     * @Route("/", name="homepage")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function indexAction()
    {
        $books = $this->get('app.service.book')->getBooks();
        return $this->render('::index.html.twig', [
            'books' => $books,
            'downloadable' => true
        ]);

    }

}
