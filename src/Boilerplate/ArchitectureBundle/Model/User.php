<?php
namespace Boilerplate\ArchitectureBundle\Model;

class User
{
    
    protected $firstname;
    
    protected $lastname;

    function __construct($firstname, $lastname) 
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
    }
    
    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }
}
