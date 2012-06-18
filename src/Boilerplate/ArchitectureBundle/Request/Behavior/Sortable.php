<?php
namespace Boilerplate\ArchitectureBundle\Request\Behavior;

use Symfony\Component\HttpFoundation\Request as HttpRequest;
use Boilerplate\ArchitectureBundle\Exception\BadRequestException;

class Sortable 
{    
    const PARAM_NAME_SORT_BY_FIELD = "sort-by";
    const PARAM_NAME_SORT_BY_ORDER = "order-by";
    
    protected $allowedFieldValues;
    protected $allowedOrderValues;
    protected $defaultField;
    protected $defaultOrder;
    
    protected $sortByField;
    protected $sortByOrder;
    
    public function __construct($allowedFieldValues, $defaultField = null, $allowedOrderValues = null, $defaultOrder = null)
    {
        $this->allowedFieldValues = $allowedFieldValues;
        
        if (!isset($defaultField)) $defaultField = $this->allowedFieldValues[0];
        $this->defaultField = $defaultField;
        
        if (!isset($allowedOrderValues)) $allowedOrderValues = array("asc", "desc");
        $this->allowedOrderValues = $allowedOrderValues;
        
        if (!isset($defaultOrder)) $defaultOrder = $this->allowedOrderValues[0];
        $this->defaultOrder = $defaultOrder;
    }
    
    public function bind(HttpRequest $request) 
    {
        $sortByField = $request->get(self::PARAM_NAME_SORT_BY_FIELD, $this->defaultField);
        $this->setSortByField($sortByField);
        
        $sortByOrder = $request->get(self::PARAM_NAME_SORT_BY_ORDER, $this->defaultOrder);
        $this->setSortByOrder($sortByOrder);
    }
    
    public function validate()
    {
        if (!in_array($this->sortByField, $this->allowedFieldValues)) throw new BadRequestException("'" . $this->sortByField . "' is not an allowed sort by option.");
        if (!in_array($this->sortByOrder, $this->allowedOrderValues)) throw new BadRequestException("'" . $this->sortByOrder . "' is not an allowed order by option.");
    }
    
    public function getSortByField() 
    {
        return $this->sortByField;
    }

    public function setSortByField($sortByField)
    {
        $this->sortByField = $sortByField;
    }

    public function getSortByOrder()
    {
        return $this->sortByOrder;
    }

    public function setSortByOrder($sortByOrder)
    {
        $this->sortByOrder = $sortByOrder;
    }
}
