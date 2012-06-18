<?php
namespace Boilerplate\ArchitectureBundle\Request;

use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

use Boilerplate\ArchitectureBundle\Request\Behavior\Sortable;
use Boilerplate\ArchitectureBundle\Request\Behavior\Paginable;

/**
 * @DI\Service("boilerplate.architecture.request.user.listing")
 */
class UserListingRequest
{
    
    protected $validator;
    protected $behaviors;
    
    /**
     * @DI\InjectParams({"validator"  = @DI\Inject("validator")})
     */
    function __construct($validator) 
    {
        $this->validator = $validator;
        $this->behaviors = array(
            "sortable" => new Sortable(array("lastname", "firstname")),
            "paginable" => new Paginable($validator, 5)
        );
    }
    
    // This tow methods should be factorized into a MultiBehaviorRequest class for example
    
    public function bind(HttpRequest $request) 
    {
        foreach($this->behaviors as $behavior) {
            $behavior->bind($request);
        }
    }
    
    public function validate()
    {
        foreach($this->behaviors as $behavior) {
            $behavior->validate();
        }
    }
    
    // This is just white noise...
    
    public function getSortBy()
    {
        return $this->behaviors["sortable"]->getSortByField();
    }
    
    public function getOrderBy()
    {
        return $this->behaviors["sortable"]->getSortByOrder();
    }
    
    public function getRows()
    {
        return $this->behaviors["paginable"]->getRows();
    }
    
    public function getOffset()
    {
        return $this->behaviors["paginable"]->getOffset();
    }
}
