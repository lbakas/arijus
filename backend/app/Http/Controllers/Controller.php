<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\MessageBag;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    private $_errors;

    function __construct()
    {
        $this->_errors = new MessageBag;
    }

    public function setErrors($value)
    {
        if (is_array($value)) {
            foreach ($value as $key => $value) {
                $this->_errors->add($key, $value);
            }
        } else {
            $this->_errors = $value;
        }
    }

    public function getErrors()
    {
        return $this->_errors;
    }

    public function returnError($errors) {
        $this->setErrors($errors);
        return [
            'message' => $this->formatValidationErrors()
        ];
    }

    public function formatValidationErrors()
    {
        if ($this->_errors && $this->_errors->isNotEmpty()) {
            return $this->_errors->toArray();
        }
        return null;
    }
}
