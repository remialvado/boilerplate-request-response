<?php

namespace Boilerplate\ArchitectureBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use Boilerplate\ArchitectureBundle\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    
    /**
     * @Template
     */
    public function exempleRequestAction(HttpRequest $request)
    {
        $userListingRequest = $this->getUserListingRequest();
        $userListingRequest->bind($request);
        try {
            $userListingRequest->validate();
        }
        catch (BadRequestException $e) {
            return new Response($e->getMessage(), 400);
        }
        
        return array(
            "sortBy"  => $userListingRequest->getSortBy(),
            "orderBy" => $userListingRequest->getOrderBy(),
            "rows"    => $userListingRequest->getRows(),
            "offset"  => $userListingRequest->getOffset()
        );
    }
    
    /**
     * @Template
     */
    public function indexAction(HttpRequest $request)
    {
        $userListingRequest = $this->getUserListingRequest();
        $userListingRequest->bind($request);
        try {
            $userListingRequest->validate();
        }
        catch (BadRequestException $e) {
            return new Response($e->getMessage(), 400);
        }
        
        $userListingResponse = $this->getUserListingResponse();
        $userListingResponse->fetchData($userListingRequest);
        return array(
            "users" => $userListingResponse->getUsers()
        );
    }
    
    /**
     * @return Boilerplate\ArchitectureBundle\Request\UserListingRequest 
     */
    protected function getUserListingRequest() {
        return $this->get("boilerplate.architecture.request.user.listing");
    }
    
    /**
     * @return Boilerplate\ArchitectureBundle\Response\UserListingResponse
     */
    protected function getUserListingResponse() {
        return $this->get("boilerplate.architecture.response.user.listing");
    }
}
