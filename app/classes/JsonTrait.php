<?php

namespace App\Classes;

use function App\get_text;

trait JsonTrait
{
    
    private function _returnStatusMessage(string $message = '', string $status = 'ok', array $data = []): void
    {
        $this->_returnJson(['status' => $status, 'message' => get_text($message)]+$data);
    }

    private function _returnError(string $errorText = 'undefinded_error'): void
    {
        $this->_returnStatusMessage(get_text($errorText), 'error');
    }

    private function _returnJson(array $json): void
    {
        exit(json_encode($json));
    }
}