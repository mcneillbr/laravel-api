<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Make Response Json
     *
     * @param mixed $data
     * @param string $state
     * @param int $code
     * @param iterable $optional
     * @return \stdClass
     */
    protected function makeJsonResponse($data, $state = 'success', $code = 200, iterable $optional = []) {
        $response = new \stdClass;
        $response->code = $code;
        $response->state = $state;
        $response->data =  $data;

        foreach ($optional as $prop => $value ) {
            $response->{$prop} = $value;
        }

        return $response;
    }
}
