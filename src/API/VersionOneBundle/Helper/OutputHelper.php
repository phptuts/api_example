<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OutputHelper
 *
 * @author student
 */
namespace API\VersionOneBundle\Helper;

class OutputHelper 
{
    public static function formatFormError($output, $formname)
    {
        $errorList = [];
        
        foreach($output as $fieldname => $err)
        {
            $name = str_replace($formname . "_", "", $fieldname);
            if($name === "")
            {
                $name = 'root';
            }
            
            $errorList[$name] = $err[0];
        }
        
        return $errorList;
    }
}
