<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Traits;

trait ApiResponseTrait
{
    private function apiResponse($data, $statusCode = 200, $message = null, $errors = [])
    {
        $response['data'] = (object)$data;
        $response['errors'] = (object)$errors;

        switch ($statusCode) {
            case 200:
                $response['message'] = $message ?? '';
                $response['success'] = true;
                break;
            case 201:
                $response['message'] = $message ?? __('Created');
                $response['success'] = true;
                break;
            case 400:
                $response['message'] = $message ?? __('Bad Request');
                $response['success'] = false;
                break;
            case 401:
                $response['message'] = $message ?? __('Unauthorized');
                $response['success'] = false;
                break;
            case 403:
                $response['message'] = $message ?? __('Forbidden');
                $response['success'] = false;
                break;
            case 404:
                $response['message'] = $message ?? __('Not Found');
                $response['success'] = false;
                break;
            case 405:
                $response['message'] = $message ?? __('Method Not Allowed');
                $response['success'] = false;
                break;
            case 422:
                $response['message'] = $message ?? __('The given data was invalid.');
                $response['success'] = false;
                break;
            default:
                $response['message'] = $message ?? __('Whoops, looks like something went wrong');
                $response['success'] = false;
                break;
        }

        return response()->json($response, $statusCode);
    }

}
