<?php

namespace App\Repositories;

use Response;
use Illuminate\Http\Request;

abstract class BaseRepository
{
    /**
     * @param string $message
     *
     * @return \Illuminate\Http\JsonResponse
    */
    public function sendResponse($result, string $message)
    {
        return Response::json(self::makeResponse($message, $result));
    }

    /**
     * @param string $error 
     * @param int $code
     *
     * @return \Illuminate\Http\JsonResponse
    */
    public function sendError(string $error, int $code = 404)
    {
        return Response::json(self::makeError($error), $code);
    }


    /**
     * @param string $message
     *
     * @return \Illuminate\Http\JsonResponse
    */
    public function sendSuccess(string $message)
    {
        return Response::json([
            'success' => true,
            'message' => $message,
        ], 200);
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     */
    abstract public function create(Request $request);

    /**
     * @param string $message
     * @param mixed $data
     *
     * @return array
     */
    private static function makeResponse(string $message, $data)
    {
        return [
            'success' => true,
            'data' => $data,
            'message' => $message,
        ];
    }

    /**
     * @param string $message
     * @param array $data
     *
     * @return array
     */
    private static function makeError(string $message, $data = [])
    {
        $res = [
            'success' => false,
            'message' => $message,
        ];
        if (!empty($data)) {
            $res['data'] = $data;
        }
        return $res;
    }
}
