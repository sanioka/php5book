<?php


class MySQlException extends Exception
{

    public function __construct($message, $errorno)
    {
        if ($errorno >= 5000) {
            $message = "тип " . __CLASS__ . ". Некорректное использование класса. " . $message;
        } else {
            $message = __CLASS__ . ' — ' . $message;
        }

        parent::__construct($message, $errorno);
    }

    public function __toString()
    {
        return "Ошибка $this->code - $this->message";
    }

}