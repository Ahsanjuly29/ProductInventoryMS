<?php

namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait IsValidRequest
{
    public function failedValidation(Validator $validator)
    {
        if ($validator->fails()) {
            throw new HttpResponseException(
                response()->json([
                    'status' => 0,
                    'message' => $validator->getMessageBag()->toArray(),
                    'errors' => $validator->errors(),
                ], 422)
            );
        }
    }
}
