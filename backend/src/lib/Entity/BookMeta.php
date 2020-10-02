<?php

namespace skoolBiep\Entity;

use skoolBiep\DB;

class BookMeta extends DB
{
    protected $id;
    protected $isbnCode;
    protected $title;
    protected $publishDate;
    protected $rating;
    protected $totalPages;
    protected $language;
    protected $sticker;
    protected $readingLevel;
    protected $author;
    protected $publisher;

    //* getters
    public function getId()
    {
        return $this->id;
    }

    public function getIsbnCode()
    {
        return $this->isbnCode;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getPublishDate()
    {
        return $this->publishDate;
    }

    public function getRating()
    {
        return $this->rating;
    }

    public function getTotalPages()
    {
        return $this->totalPages;
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function getSticker()
    {
        return $this->sticker;
    }    

    public function getReadingLevel()
    {
        return $this->readingLevel;
    }   
    
    public function getAuthor()
    {
        return $this->author;
    }

    public function getPublisher()
    {
        return $this->publisher;
    }
   
    //*Setters
    public function setId($value)
    {
        return $this->id = $value;
    }

    public function setIsbnCode($value)
    {
        return $this->isbnCode;
    }

    public function setTitle($value)
    {
        return $this->title = $value;
    }

    public function setPublishDate($value)
    {
        return $this->publishDate = $value;
    }

    public function setRating($value)
    {
        return $this->rating = $value;
    }

    public function setTotalPages($value)
    {
        return $this->totalPages = $value;
    }

    public function setLanguage($value)
    {
        return $this->language = $value;
    }

    public function setSticker($value)
    {
        return $this->sticker = $value;
    }    

    public function setReadingLevel($value)
    {
        return $this->readingLevel = $value;
    }   
    
    public function setAuthor($value)
    {
        return $this->author = $value;
    }

    public function setPublisher($value)
    {
        return $this->publisher = $value;
    }
   
}
