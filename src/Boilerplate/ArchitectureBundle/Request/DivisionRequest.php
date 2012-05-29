<?php
namespace Boilerplate\ArchitectureBundle\Request;

use Symfony\Component\Validator\Constraints as Assert;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use Boilerplate\ArchitectureBundle\Exception\BadRequestException;
use Symfony\Component\Validator\ConstraintViolation;

/**
 * @DI\Service("boilerplate.architecture.request.division")
 */
class DivisionRequest {
    
    const PARAM_DIVIDEND = "a";
    const PARAM_DIVISOR  = "b";
    
    /**
     * @Assert\Type(type = "numeric", message = "'dividend' has to be a numeric value")
     */
    protected $dividend;
    
    /**
     * @Assert\Type(type = "numeric", message = "'divisor' has to be a numeric value")
     */
    protected $divisor;
    
    /**
     * @var Symfony\Component\Validator\ValidatorInterface
     */
    protected $validator;
    
    /**
     * @DI\InjectParams({"validator"  = @DI\Inject("validator")})
     */
    function __construct($validator) 
    {
        $this->validator = $validator;
    }
    
    public function bind(HttpRequest $request) {
        $this->setDividend($request->get(self::PARAM_DIVIDEND));
        $this->setDivisor($request->get(self::PARAM_DIVISOR));
    }
    
    public function validate() 
    {
        $errors = $this->validator->validate($this);
        if ($this->getDivisor() === "0") {
            $errors->add(new ConstraintViolation("divisor has to be a non zero value", array(), null, null, null));
        }
        $errorMessage = "";
        foreach ($errors as $error) {
            $errorMessage .= $error->getMessage() . PHP_EOL;
        }
        if (!empty($errorMessage)) {
            throw new BadRequestException($errorMessage);
        }
    }
    
    public function getDividend() 
    {
        return $this->dividend;
    }

    public function setDividend($dividend) 
    {
        $this->dividend = $dividend;
    }

    public function getDivisor() 
    {
        return $this->divisor;
    }

    public function setDivisor($divisor) 
    {
        $this->divisor = $divisor;
    }
}

?>
