<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CustomRequest;

class MiddlewareTestController extends Controller
{
    public function modifyRequest(CustomRequest $request)
    {
        return response()->json([
            'foo_property' => $request->foo,
            'foo_get' => $request->input('foo'),
        ]);
    }
}
