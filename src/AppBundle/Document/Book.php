<?php
namespace AppBundle\Document;

class Book
{

    /**
     * @var string
     */
    private $uniqid;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $saxoUrl;

    /**
     * @var string
     */
    private $downloadUrl;

    /**
     * @var bool
     */
    private $deleted = false;

    public function __construct()
    {
        $this->uniqid = md5(uniqid('', true));
    }

    /**
     * @return string
     */
    public function getUniqid()
    {
        return $this->uniqid;
    }

    /**
     * @param string $uniqid
     * @return Book
     */
    public function setUniqid($uniqid)
    {
        $this->uniqid = $uniqid;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Book
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getSaxoUrl()
    {
        return $this->saxoUrl;
    }

    /**
     * @param string $saxoUrl
     * @return Book
     */
    public function setSaxoUrl($saxoUrl)
    {
        $this->saxoUrl = $saxoUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getDownloadUrl()
    {
        return $this->downloadUrl;
    }

    /**
     * @param string $downloadUrl
     * @return Book
     */
    public function setDownloadUrl($downloadUrl)
    {
        $this->downloadUrl = $downloadUrl;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param boolean $deleted
     * @return Book
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
        return $this;
    }

}
