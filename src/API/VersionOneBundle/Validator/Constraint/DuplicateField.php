<?php

namespace API\VersionOneBundle\Validator\Constraint;

use Symfony\Component\Validator\Constraint;


/**
 * @Annotation
 */
class DuplicateField extends Constraint
{
    public $fieldname;
    
    public $entityname;
    
    public $message;
    
    public function validatedBy() 
    {
        return 'api_one_duplicate_db';
    }
    
    
    
    public function getRequiredOptions() 
    {
        return array('fieldname', 'entityname');
    }
}
