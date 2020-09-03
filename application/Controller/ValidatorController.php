<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '../../Models/CreditCard.php';
require_once __DIR__ . '../../Models/Mobile.php';

class ValidatorController extends BaseController
{
    /**
     * Created By Nahla Sameh
     * Validate Credit cards according to request data
     */
    static function validate()
    {
        try {
            /* Check if request authorized*/
            if (parent::isAuthorized()) {

                /* Get request paymentType*/
                $paymentType = array_key_exists('paymentType', $_POST) ? $_POST['paymentType'] : "";

                /* Check paymentType if it is creditCard */
                if ($paymentType === 'creditCard') {

                    /* Set CreditCard Data from $_POST array */
                    $creditCard = new CreditCard();
                    $creditCard->setCreditCardNumber(array_key_exists('creditCardNumber', $_POST) ? $_POST['creditCardNumber'] : "");
                    $creditCard->setEmail(array_key_exists('email', $_POST) ? $_POST['email'] : "");
                    $creditCard->setExpirationDate(array_key_exists('expirationDate', $_POST) ? $_POST['expirationDate'] : "");
                    $creditCard->setCvv2(array_key_exists('cvv2', $_POST) ? $_POST['cvv2'] : "");

                    /* Prepare response array with validation result and errors */
                    $responseData = array('valid' => $creditCard->isValid(), 'errors' => $creditCard->getValidationErrors());
                } elseif ($paymentType === 'mobile') { /* Check paymentType if it is mobile */

                    /* Set Mobile Data from $_POST array */
                    $mobile = new Mobile();
                    $mobile->setPhoneNumber(array_key_exists('phoneNumber', $_POST) ? $_POST['phoneNumber'] : "");

                    /* Prepare response array with validation result and errors*/
                    $responseData = array('valid' => $mobile->isValid(), 'errors' => $mobile->getValidationErrors());
                } else {
                    /* enter here when have not valid payment type */

                    /* Prepare response array */
                    $responseData = array('valid' => false, 'errors' => array("Invalid Payment Type"));
                }

                /* Get response format from request data*/
                $responseFormat = array_key_exists('format', $_POST) ? $_POST['format'] : "json";
                if ($responseFormat === 'xml') {

                    /* prepare response with xml format*/
                    return parent::prepareXmlResponse($responseData);
                } elseif ($responseFormat === 'json') {

                    /* prepare response with json format*/
                    return parent::prepareJsonResponse($responseData);
                } else {
                    /* prepare response with json format*/
                    $responseData = array('valid' => false, 'errors' => array("Invalid Response format"));
                    return parent::prepareJsonResponse($responseData);
                }
            } else {
                /* If Not authorized request it will return invalid request with json format*/
                $responseData = array('valid' => false, 'errors' => array("Invalid Request"));
                return parent::prepareJsonResponse($responseData);
            }
        } catch (Exception $exception) {
            /* If any issue happend then back with error message*/
            $responseData = array('valid' => false, 'errors' => array("Sorry, Something went wrong!"));
            return parent::prepareJsonResponse($responseData);
        }
    }
}
