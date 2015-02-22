<?php

namespace API\VersionOneBundle\Validator\Constraint;

use Symfony\Component\Validator\Constraint;


/**
 * @Annotation
 */
class DuplicateFieldEdit extends Constraint
{
    public $fieldname;
    
    public $entityname;
    
    public $message;
    
    public function validatedBy() 
    {
        return 'api_one_duplicate_edit_db';
    }
    
    
    
    public function getRequiredOptions() 
    {
        return array('fieldname', 'entityname');
    }
}