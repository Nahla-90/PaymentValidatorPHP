<?php

class CreditCard
{
    private $creditCardNumber;
    private $cvv2;
    private $expirationDate;
    private $email;
    private $validationErrors = array();

    /**
     * Created By Nahla Sameh
     * @param $creditCardNumber
     * @return $this
     */
    public function setCreditCardNumber($creditCardNumber)
    {
        $this->creditCardNumber = $creditCardNumber;
        return $this;
    }

    /**
     * Created By Nahla Sameh
     * @return mixed
     */
    public function getCreditCardNumber()
    {
        return $this->creditCardNumber;
    }

    /**
     * Created By Nahla Sameh
     * @param $cvv2
     * @return $this
     */
    public function setCvv2($cvv2)
    {
        $this->cvv2 = $cvv2;
        return $this;
    }

    /**
     * Created By Nahla Sameh
     * @return mixed
     */
    public function getCvv2()
    {
        return $this->cvv2;
    }

    /**
     * Created By Nahla Sameh
     * @param $expirationDate
     * @return $this
     */
    public function setExpirationDate($expirationDate)
    {
        $this->expirationDate = $expirationDate;
        return $this;
    }

    /**
     * Created By Nahla Sameh
     * @return mixed
     */
    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    /**
     * Created By Nahla Sameh
     * @param $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Created By Nahla Sameh
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Created By Nahla Sameh
     * Check if current object of CreditCard payment is valid
     * @return bool
     */
    public function isValid()
    {
        /* Check validation of creditCardNumber */
        if (empty($this->creditCardNumber)) {
            /* if creditCardNumber empty*/
            $this->validationErrors[] = "Credit Card Number Required";

        } else {
            if (!is_numeric($this->creditCardNumber)) {
                /* if creditCardNumber not numeric*/
                $this->validationErrors[] = "Credit Card Number Should be numeric";
            } else {
                if (!$this->validCreditCardByLuhnAlgo($this->creditCardNumber)) {
                    /* if creditCardNumber not valid with luhn's algorithm validation*/
                    $this->validationErrors[] = "Credit Card Number Invalid";
                }
            }
        }

        /* Check validation of email */
        if (empty($this->email)) {
            /* if email empty*/
            $this->validationErrors[] = "Email Required";
        } else {
            if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                /* if email invalid format*/
                $this->validationErrors[] = "Invalid email format";
            }
        }

        /* Check validation of expirationDate */
        if (empty($this->expirationDate)) {
            /* if expirationDate empty*/
            $this->validationErrors[] = "Expiration Date Required";
        } else {

            /* if expirationDate format*/
            $dateArray = explode('/', $this->expirationDate);
            if (checkdate($dateArray[0], $dateArray[1], $dateArray[2])) {

                /* if expirationDate has valid format*/
                $expirationDate = strtotime($this->expirationDate);
                $todayDate = strtotime(date("m/d/Y"));

                /*Check if expirationDate is expired*/
                if ($expirationDate < $todayDate) {
                    /*Check if expirationDate is expired*/
                    $this->validationErrors[] = "Credit Card expired";
                }
            } else {
                /* if expirationDate has invalid format*/
                $this->validationErrors[] = "Invalid Expiration Date format";
            }
        }

        /* Check validation of cvv2 */
        if (empty($this->cvv2)) {
            /* if cvv2 empty*/
            $this->validationErrors[] = "CVV2 Required";
        } else {
            if (!is_numeric($this->cvv2) || strlen($this->cvv2) < 3 || strlen($this->cvv2) > 4) {
                /* if cvv2 not numeric or has invalid length*/
                $this->validationErrors[] = "Invalid CVV2 format";
            }
        }

        /* return false if there is validation errors found */
        if (count($this->validationErrors) > 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Created By Nahla Sameh
     * Return validation errors
     * @return array
     */
    public function getValidationErrors()
    {
        return $this->validationErrors;
    }

    /**
     * Created By Nahla Sameh
     * validate credit card number using luhn's algorithm
     * @param $creditCardNumber
     * @return bool
     */
    private function validCreditCardByLuhnAlgo($creditCardNumber)
    {
        /* Count credit card numbers*/
        $countOfCreditCardNumbers = strlen($creditCardNumber);

        /* Get Last digit that should be checked*/
        $checkDigit = $creditCardNumber[$countOfCreditCardNumbers - 1];

        /* reverse credit card numbers and put them in $creditCardNumberReverse "without the checkDigit"*/
        $creditCardNumberReverse = array();
        for ($i = $countOfCreditCardNumbers - 1; $i > -1; $i--) {
            if ($i != $countOfCreditCardNumbers - 1) {
                /* fill current digit if it is not the checkDigit*/
                $creditCardNumberReverse[] = $creditCardNumber[$i];
            }
        }

        /* Get The total of digits after some steps*/
        $total = 0;
        for ($i = 0; $i < $countOfCreditCardNumbers - 1; $i++) {
            $currentDigit = $creditCardNumberReverse[$i];

            /* check if current index is odd */
            if ($i % 2 == 0) {

                /* multiply current digit * 2*/
                $currentDigit = 2 * $currentDigit;
                if ($currentDigit > 9) { // if the result > 9 , then substract 9
                    $currentDigit -= 9;
                }
            }

            /* add to total*/
            $total += $currentDigit;
        }

        /* Calcultae Luhn checksum */
        $luhnChecksum = 10 - ($total % 10);

        /* check if $checkDigit is equal $luhnChecksum */
        if ($checkDigit == $luhnChecksum) {
            /* if equal then creadit card number is valid*/
            return true;
        } else {
            return false;
        }
    }

}
