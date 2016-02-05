<?php
namespace AppBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;

class Books
{

    /**
     * @var Book[]|ArrayCollection
     */
    private $books;

    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    /**
     * @param Book $book
     * @return $this
     */
    public function addBook(Book $book)
    {
        $this->books->add($book);
        return $this;
    }

    /**
     * @param array|null $books
     * @return $this
     */
    public function setBooks(array $books = null)
    {
        $this->books = new ArrayCollection();
        if ($books) {
            foreach($books as $book) {
                $this->addBook($book);
            }
        }
        return $this;
    }

    /**
     * @param Book $book
     * @return $this
     */
    public function removeBook(Book $book)
    {
        $this->books->removeElement($book);
        return $this;
    }

    /**
     * @return Book[]|ArrayCollection
     */
    public function getBooks()
    {
        return $this->books;
    }

}
