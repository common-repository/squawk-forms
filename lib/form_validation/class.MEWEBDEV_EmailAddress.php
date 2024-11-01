<?php
if(! defined('ABSPATH')) exit;

/**
 * @author Matias Escudero <matias@meweb.dev>
 */

class MEWEBDEV_EmailAddress
{

    private $emailAddress;
    private $emailUsr;
    private $emailDomain;

    public function __construct($emailAddress)
    {
        $this->setEmailAddress($emailAddress);
    }

    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    public function setEmailAddress($strEmailAddress)
    {
        $this->emailAddress = $strEmailAddress;
    }

    public function getEmailAddressUser()
    {
        return $this->emailUsr;
    }

    public function getEmailAddressDomain()
    {
        return $this->emailDomain;
    }

    public function isValid()
    {
        if (!filter_var($this->getEmailAddress(), FILTER_VALIDATE_EMAIL)) 
        {
            return false;
        }
        else
        {
            return true;
        }
    }

}

?>