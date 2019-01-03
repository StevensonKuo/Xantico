<?php

namespace Xantico\Bootstrap\Basic;

interface iRequiredInput
{
    // interface for method model, abs class for attribute model.
    const INPUT_REQUIRED_DEFAULT = "This field is required.";
    const INPUT_REQUIRED_EMAIL = "Email format is needed.";
    const INPUT_REQUIRED_MAXLENGTH = "Max. length is required - ";
    const INPUT_REQUIRED_MINLENGTH = "Min. length is required - ";
    const INPUT_REQUIRED_EQUALTO = "This field needs to be same with - ";

    public function getIsRequired();

    public function getValidation();

    public function setIsRequired($message = "", $isRequired = true);

    public function setValidation($validation);

    public function setRequiredMinLength($length, $message = "");

    public function setRequiredMaxLength($length, $message = "");

    public function setRequiredEqualTo(Typography $input, $message = "");

    public function setRequiredEmail($message = "");


}

