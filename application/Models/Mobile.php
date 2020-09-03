<?php

class Mobile
{
    private $phoneNumber;
    private $validationErrors = array();

    /**
     * Created By Nahla Sameh
     * @param $phoneNumber
     * @return $this
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    /**
     * Created By Nahla Sameh
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Created By Nahla Sameh
     * Check if current Object of Mobile Payment is valid
     * @return bool
     */
    public function isValid()
    {
        if (empty($this->phoneNumber)) {
            /* if no phone number found*/
            $this->validationErrors[] = "Phone Number Required";
        } else {

            $filteredPhoneNumber = filter_var($this->phoneNumber, FILTER_SANITIZE_NUMBER_INT);
            $phoneNumberToCheck = str_replace("-", "", $filteredPhoneNumber);
            if (strlen($phoneNumberToCheck) < 10 || strlen($phoneNumberToCheck) > 14) {
                /* if phone number not valid length*/
                $this->validationErrors[] = "Phone Number not valid";
            }
        }

        /* Return true if no validation errors found*/
        if(count($this->validationErrors)>0){
            return false;
        }else{
            return true;
        }
    }

    /**
     * Created By Nahla Sameh
     * @return array
     */
    public function getValidationErrors(){
        return$this->validationErrors;
    }
}
