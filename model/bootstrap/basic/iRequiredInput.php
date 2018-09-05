<?php
namespace bootstrap\basic;

use model\bootstrap\basic\Typography;

interface iRequiredInput
{
    // interface for method model, abs class for attribute model.

    public function getIsRequired();
    
    public function getValidation();
    
    public function setIsRequired ($message = "", $isRequired = true);
    
    public function setValidation($validation);
    
    public function setRequiredMinLength ($length, $message = "");
    
    public function setRequiredMaxLength ($length, $message = "");
    
    public function setRequiredEqualTo (Typography $input, $message = "");
    
    public function setRequiredEmail ($message = "");
    
    
}

