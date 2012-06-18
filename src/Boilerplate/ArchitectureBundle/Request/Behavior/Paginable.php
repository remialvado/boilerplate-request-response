<?php
namespace Boilerplate\ArchitectureBundle\Request\Behavior;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use Boilerplate\ArchitectureBundle\Exception\BadRequestException;

class Paginable 
{    
    const PARAM_NAME_PAGE = "page";
    
    protected $itemsPerPage;
    protected $defaultPage;
    
    /**
     * @Assert\Type(type = "numeric", message = "'page' has to be a numeric value")
     * @Assert\Min(limit = "1", message = "'page' can't be inferior to 1")
     */
    protected $page;
    
    protected $validator;
    
    public function __construct($validator, $itemsPerPage = 10, $defaultPage = 1)
    {
        $this->validator = $validator;
        $this->itemsPerPage = $itemsPerPage;
        $this->defaultPage = $defaultPage;
    }
    
    public function bind(HttpRequest $request) 
    {
        $this->page = $request->get(self::PARAM_NAME_PAGE, $this->defaultPage);
    }
    
    public function validate()
    {
        $errors = $this->validator->validate($this);
        $errorMessage = "";
        foreach ($errors as $error) {
            $errorMessage .= $error->getMessage() . PHP_EOL;
        }
        if (!empty($errorMessage)) {
            throw new BadRequestException($errorMessage);
        }
    }
    
    public function getPage() {
        return $this->page;
    }

    public function setPage($page) {
        $this->page = $page;
    }
    
    public function getRows() {
        return $this->itemsPerPage;
    }
    
    public function getOffset() {
        return ($this->page - 1) * $this->getRows();
    }
}
