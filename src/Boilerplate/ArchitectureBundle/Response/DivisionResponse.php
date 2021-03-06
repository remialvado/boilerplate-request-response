<?php
namespace Boilerplate\ArchitectureBundle\Response;

use Boilerplate\ArchitectureBundle\Request\DivisionRequest;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * @DI\Service("boilerplate.architecture.response.division")
 */
class DivisionResponse 
{
    protected $quotient;
    
    public function fetchData($dividend, $divisor)
    {
        $this->setQuotient($dividend / $divisor);
    }
    
    public function getParametersForTemplate() 
    {
        return array(
            "quotient" => $this->getQuotient(),
        );
    }
    
    public function getQuotient() 
    {
        return $this->quotient;
    }

    public function setQuotient($quotient) 
    {
        $this->quotient = $quotient;
    }
}

?>
