<?php

namespace AppBundle\Service;

use AppBundle\Document\Book;
use AppBundle\Document\Books;
use League\Csv\Reader;
use League\Csv\Writer;
use Symfony\Component\DomCrawler\Crawler;

class BooksService
{

    const ROW_UNIQUEID = 0;

    /**
     * @var string
     */
    private $dataPath;

    /**
     * BooksService constructor.
     * @param string $dataPath
     */
    public function __construct($dataPath)
    {
        $this->dataPath = $dataPath;
    }

    /**
     * @param Book $book
     * @return Book
     */
    public function addBook(Book $book)
    {
        $this->getWriter()->insertOne([
            $book->getUniqid(),
            $book->getName(),
            $book->getDownloadUrl(),
            $book->getSaxoUrl()
        ]);
        return $book;
    }

    /**
     * @return Books
     */
    public function getBooks()
    {
        $books = new Books();
        $reader = $this->getReader();
        foreach($reader as $row) {
            if (isset($row[1])) {
                $books->addBook($this->getBook($row));
            }
        }
        return $books;
    }

    public function deleteBook($uniqid)
    {
        $uniqCell = self::ROW_UNIQUEID;
        $setDeletedFunction = function($row) use ($uniqCell, $uniqid) {
            if ($row[$uniqCell] != $uniqid) {
                return $row;
            }
        };

        $iterator = $this->getReader()->fetch($setDeletedFunction);
        $tmpPath = sys_get_temp_dir() . '/' . uniqid() . '.temp';
        $writer = $this->getWriter($tmpPath);
        $writer->insertAll($iterator);
        unset($writer, $iterator);
        rename($tmpPath, $this->getFile());
    }

    public function getDescription(Book $book)
    {
        if (! $book->getSaxoUrl()) {
            return '';
        }

        $html = $this->loadSaxoData($book->getSaxoUrl());
        $crawler = new Crawler($html);
        $crawler = $crawler->filter('div.product__description > p.js-more');
        return $crawler->html();
    }

    public function getImage(Book $book)
    {
        if (! $book->getSaxoUrl()) {
            return '';
        }

        $html = $this->loadSaxoData($book->getSaxoUrl());
        $crawler = new Crawler($html);
        return $crawler->filter('#productcolumn > img')->attr('src');
    }

    /**
     * @param string $uniqid
     * @param bool $getRow
     * @return Book
     */
    protected function findBook($uniqid, $getRow = false)
    {
        $row = $this->getReader()->addFilter(function($row) use ($uniqid) {
            return $row[self::ROW_UNIQUEID] == $uniqid;
        })->fetchOne();

        if ($getRow) {
            return $row;
        }

        return $this->getBook($row);
    }

    protected function loadSaxoData($url)
    {
        $path = sprintf('%s/%s.html', $this->dataPath, md5($url));

        if (! file_exists($path)) {
            $data = file_get_contents($url);
            file_put_contents($path, $data);
            return $data;
        }

        return file_get_contents($path);
    }

    /**
     * @param array $row
     * @return Book
     */
    protected function getBook(array $row)
    {
        $book = new Book();
        $book->setUniqid($row[self::ROW_UNIQUEID]);
        $book->setName($row[1]);
        $book->setDownloadUrl($row[2]);
        $book->setSaxoUrl($row[3]);
        return $book;
    }

    protected function getReader($path = null)
    {
        if ($path === null) {
            $path = $this->getFile();
        }

        return Reader::createFromPath($path, 'a+');
    }

    protected function getWriter($path = null)
    {
        if ($path === null) {
            $path = $this->getFile();
        }

        return Writer::createFromPath($path, 'a+');
    }

    protected function getFile()
    {
        return $this->dataPath . '/books.csv';
    }

}
