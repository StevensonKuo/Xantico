<?php
namespace bootstrap\basic;

use model\bootstrap\basic\Typography;

interface iRequiredInput
{
    // interface for method model, abs class for attribute model.

    public function setRequired ($message = "", $isRequired = true);
    
    public function setRequiredMinLength ($length, $message = "");
    
    public function setRequiredMaxLength ($length, $message = "");
    
    public function setRequiredEqualTo (Typography $input, $message = "");
    
    public function setRequiredEmail ($message = "");
    
}

