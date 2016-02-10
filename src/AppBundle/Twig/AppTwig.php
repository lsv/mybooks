<?php
namespace AppBundle\Twig;

use AppBundle\Document\Book;
use AppBundle\Service\BooksService;

class AppTwig extends \Twig_Extension
{

    /**
     * @var BooksService
     */
    private $service;

    public function __construct(BooksService $service)
    {
        $this->service = $service;
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('description', [$this, 'getDescription'], ['is_safe' => ['html']]),
            new \Twig_SimpleFilter('image', [$this, 'getImage'])
        ];
    }

    public function getDescription(Book $book)
    {
        $text = $this->service->getDescription($book);
        $pos = strpos($text, '...');
        return str_split($text, $pos)[0];
    }

    public function getImage(Book $book, $height = 100)
    {
        $src = $this->service->getImage($book);
        return str_replace('&width=210', '&height=' . $height, $src);
    }

    public function getName()
    {
        return 'app.twig';
    }
}
