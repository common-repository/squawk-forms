<?php
if(! defined('ABSPATH')) exit;

/**
 * @author Matias Escudero <matias@meweb.dev>
 */

class MEWEBDEV_FormValidation
{
    private $data;
    public $fieldNames = array();

    public function __construct($data)
    {
        $this->data = $data;

        foreach($this->data as $key => $value)
        {
            switch($value->name)
            {
                case "mewebdev_txt_name":
                    {
                        $this->validateName($value->value);
                    }
                    break;

                case "mewebdev_txt_email":
                    {
                        $this->validateEmail($value->value);
                    }
                    break;
                
                case "mewebdev_txt_message":
                    {
                        $this->validateMessage($value->value);
                    }
                    break;
            }
        }

        unset($value);
    }

    public function getData()
    {
        return $this->fieldNames;
    }

    public function validateScreening($data)
    {
        if(!empty($data))
        {
            if(strlen($data) > 3)
            {
                throw new Exception("Invalid screening data");
            }
        }
    }

    public function validateName($name)
    {
        if (empty($name))
        {
            throw new Exception('Please enter your name', 1);
        }
        elseif (strlen($name) > 40)
        {
            throw new Exception('The entered name is too long', 2);
        }
        else
        {
            if(is_numeric($name))
            {
                throw new Exception('Name can not be a number', 3);
            }
        }
    }

    public function validateEmail($email)
    {
        if (empty($email))
        {
            throw new exception('Please enter your email', 7);
        } 
        elseif (strlen($email) > 100)
        {
            throw new exception('The entered last email address is too long', 8);
        } 
        else
        {            
            $emailAddress = new MEWEBDEV_EmailAddress($email);
            
            if(!$emailAddress->isValid())
            {
                throw new exception('The entered email is not valid', 9);
            }
        }
    }

    public function validateMessage($message)
    {
        if(empty($message) || trim($message) == "")
        {
            throw new Exception("Please enter a message", 43);
        }
        else
        {
            if(strlen($message) > 1500)
            {
                throw new Exception("This text is too long. Please use up to 1500 characters", 44);
            }
        }
    }


}