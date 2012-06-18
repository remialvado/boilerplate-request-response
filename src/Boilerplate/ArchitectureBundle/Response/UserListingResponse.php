<?php
namespace Boilerplate\ArchitectureBundle\Response;

use Boilerplate\ArchitectureBundle\Request\UserListingRequest;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * @DI\Service("boilerplate.architecture.response.user.listing")
 */
class UserListingResponse {
    
    protected $providers;
    
    /**
     * @DI\InjectParams({
     *     "usersProvider" = @DI\Inject("boilerplate.architecture.response.provider.users")
     * })
     */
    public function __construct($usersProvider)
    {
        $this->providers = array(
            "usersProvider" => $usersProvider
        );
    }
    
    public function fetchData(UserListingRequest $request)
    {
        $this->providers["usersProvider"]->fetchData($request->getSortBy(), $request->getOrderBy(), $request->getRows(), $request->getOffset());
    }
    
    public function getUsers()
    {
        return $this->providers["usersProvider"]->getUsers();
    }
}

?>
