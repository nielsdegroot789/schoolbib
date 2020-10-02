<?php

namespace skoolBiep\Entity;

use skoolBiep\DB;

class User extends DB
{
    protected $id;
    protected $userName;
    protected $firstName;
    protected $lastName;
    protected $email;
    protected $phone;
    protected $street;
    protected $street2;
    protected $zip;
    protected $city;
    protected $country;
    protected $status;
    protected $role;


    public function getId()
    {
        return $this->id;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function getStreet()
    {
        return $this->street;
    }

    public function getStreet2()
    {
        return $this->street2;
    }

    public function getZip()
    {
        return $this->zip;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function getName()
    {
        return join(", ", [$this->lastName, $this->firstName]);
    }

    public function getAddress()
    {
        return join('<br/>', [join('<br/>>', [$this->street, $this->street2]), join(", ", [$this->zip, $this->city]), $this->country]);
    }

    public function setId($value)
    {
        return $this->id = $value;
    }

    public function setUserName($value)
    {
        return $this->userName = $value;
    }

    public function setFirstName($value)
    {
        return $this->firstName = $value;
    }

    public function setLastName($value)
    {
        return $this->lastName = $value;
    }

    public function setEmail($value)
    {
        return $this->email = $value;
    }

    public function setPhone($value)
    {
        return $this->phone = $value;
    }

    public function setStreet($value)
    {
        return $this->street = $value;
    }

    public function setStreet2($value)
    {
        return $this->street2 = $value;
    }

    public function setZip($value)
    {
        return $this->zip = $value;
    }

    public function setCity($value)
    {
        return $this->city = $value;
    }

    public function setCountry($value)
    {
        return $this->country = $value;
    }

    public function setStatus($value)
    {
        return $this->status = $value;
    }

    public function setRole($value)
    {
        return $this->role = $value;
    }
}
