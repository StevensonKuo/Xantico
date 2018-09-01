<?php
namespace bootstrap\basic;

interface iRequiredInput
{
    protected $isRequired = false;
    protected $validation = array ();
    
    public function setRequired ($message = "", $isRequired = true);
    
    public function setRequiredMinLength ($length, $message = "");
    
    public function setRequiredMaxLength ($length, $message = "");
    
    public function setRequiredEqualTo (Input $input, $message = "");
    
    public function setRequiredEmail ($message = "");
    
}

