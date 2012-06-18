<?php
namespace Boilerplate\ArchitectureBundle\Response\Provider;

use JMS\DiExtraBundle\Annotation as DI;

use Boilerplate\ArchitectureBundle\Model\User;

/**
 * An alias is defined in Resources/config/services.yaml to define an alias on sthis service
 * @DI\Service("boilerplate.architecture.response.provider.users.file")
 */
class UserFileProvider {
    
    /**
     * @DI\Inject("%kernel.root_dir%")
     */
    public $basePath;
    
    protected $userFilePath = "src/BoilerPlate/ArchitectureBundle/Resources/data/users.txt";
    
    protected $users;
    
    public function fetchData($sortBy, $orderBy, $rows, $offset)
    {
        $allUsers = $this->getAllUsers();
        if ($sortBy === "firstname" && $orderBy === "asc")  uasort ($allUsers, array($this, "sortByFirstNameAsc"));
        if ($sortBy === "firstname" && $orderBy === "desc") uasort ($allUsers, array($this, "sortByFirstNameDesc"));
        if ($sortBy === "lastname"  && $orderBy === "asc")  uasort ($allUsers, array($this, "sortByLastNameAsc"));
        if ($sortBy === "lastname"  && $orderBy === "desc") uasort ($allUsers, array($this, "sortByLastNameDesc"));
        $this->users = array_slice($allUsers, $offset, $rows);
    }
    
    public function getUsers()
    {
        return $this->users;
    }
    
    protected function getAllUsers()
    {
        $users = array();
        $lines = file($this->basePath . "/../" . $this->userFilePath, FILE_IGNORE_NEW_LINES);
        foreach ($lines as $line) {
            $parts = explode(",", $line);
            $users[] = new User($parts[1], $parts[0]);
        }
        return $users;
    }
    
    public function sortByFirstNameAsc($a, $b) {
        return $a->getFirstname() > $b->getFirstname();
    }
    
    public function sortByFirstNameDesc($a, $b) {
        return $a->getFirstname() < $b->getFirstname();
    }
    
    public function sortByLastNameAsc($a, $b) {
        return $a->getLastname() > $b->getLastname();
    }
    
    public function sortByLastNameDesc($a, $b) {
        return $a->getLastname() < $b->getLastname();
    }
}

?>
