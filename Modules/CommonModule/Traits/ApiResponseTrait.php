<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Traits;

trait ApiResponseTrait
{
    private function apiResponse($responseData, $statusCode = 200, $message = null, $errors = [])
    {
        $data['data'] = (object)$responseData;
        $data['errors'] = (object)$errors;

        if ($message && $statusCode == 400) {
            $data['errors']->error_id = $message;
        }

        switch ($statusCode) {
            case 200:
                $data['message'] = $message ?? '';
                $data['success'] = true;
                break;
            case 201:
                $data['message'] = $message ?? __('Created');
                $data['success'] = true;
                break;
            case 400:
                $data['message'] = $message ?? __('Bad Request');
                $data['success'] = false;
                break;
            case 401:
                $data['message'] = $message ?? __('Unauthorized');
                $data['success'] = false;
                break;
            case 403:
                $data['message'] = $message ?? __('Forbidden');
                $data['success'] = false;
                break;
            case 404:
                $data['message'] = $message ?? __('Not Found');
                $data['success'] = false;
                break;
            case 405:
                $data['message'] = $message ?? __('Method Not Allowed');
                $data['success'] = false;
                break;
            case 422:
                $data['message'] = $message ?? __('The given data was invalid.');
                $data['success'] = false;
                break;
            default:
                $data['message'] = $message ?? __('Whoops, looks like something went wrong');
                $data['success'] = false;
                break;
        }

        return response()->json($data, $statusCode);
    }

}
