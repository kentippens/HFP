<?php

namespace App\Exceptions;

use Exception;

class BlogValidationException extends Exception
{
    protected $field;
    protected $validationErrors = [];

    public function __construct($message = "", $field = null, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->field = $field;
    }

    public function setField($field)
    {
        $this->field = $field;
        return $this;
    }

    public function getField()
    {
        return $this->field;
    }

    public function setValidationErrors(array $errors)
    {
        $this->validationErrors = $errors;
        return $this;
    }

    public function getValidationErrors()
    {
        return $this->validationErrors;
    }

    public function toArray()
    {
        return [
            'message' => $this->getMessage(),
            'field' => $this->field,
            'errors' => $this->validationErrors,
        ];
    }
}