<?php

namespace Boilerplate\ArchitectureBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use Boilerplate\ArchitectureBundle\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Response;

class DivisionController extends Controller
{
    
    /**
     * @Template
     */
    public function indexAction(HttpRequest $request)
    {
        $divisionRequest = $this->getDivisionRequest();
        $divisionRequest->bind($request);
        try {
            $divisionRequest->validate();
        }
        catch (BadRequestException $e) {
            return new Response($e->getMessage(), 400);
        }
        $divisionResponse = $this->getDivisionResponse();
        $divisionResponse->fetchData($divisionRequest->getDividend(), $divisionRequest->getDivisor());
        return $divisionResponse->getParametersForTemplate();
    }
    
    /**
     * @return Boilerplate\ArchitectureBundle\Request\DivisionRequest 
     */
    protected function getDivisionRequest() {
        return $this->get("boilerplate.architecture.request.division");
    }
    
    /**
     * @return Boilerplate\ArchitectureBundle\Response\DivisionResponse 
     */
    protected function getDivisionResponse() {
        return $this->get("boilerplate.architecture.response.division");
    }
}
