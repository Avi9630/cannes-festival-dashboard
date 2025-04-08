<?php

namespace App\Traits;

trait HttpResponses
{

    protected function success($data, $message = null, $code = 200)
    {
        return response()->json([
            'status'        =>  true,
            'status_code'   =>  200,
            'message'       =>  $message,
            'data'          =>  $data
        ], $code);
    }

    protected function error($data = [], $message = null, $code = 201)
    {
        return response()->json([
            'status'        =>  false,
            'status_code'   =>  $code,
            'message'       =>  $message,
            'data'          =>  $data
        ]);
    }

    protected function response($input = '', $params = array())
    {
        $statusResp = array(
            'success' => array(
                'statuscode' => 200,
                'status' => true,
                'message' => 'Success!',
            ),
            'noresult' => array(
                'statuscode' => 200,
                'status' => false,
                'message' => 'No Record Found!',
            ),
            'exception' => array(
                'statuscode' => 201,
                'status' => false,
                'message' => 'Exception Error!',
            ),
            'incorrectinfo' => array(
                'statuscode' => 201,
                'status' => false,
                'message' => 'The provided information is incorrect!',
            ),
            'updateError' => array(
                'statuscode' => 201,
                'status' => false,
                'message' => 'Error while Updating!',
            ),
            'notvalid' => array(
                'statuscode' => 201,
                'status' => false,
                'message' => 'The provided information is not Valid!',
            ),
            'apierror' => array(
                'statuscode' => 201,
                'status' => false,
                'message' => 'API is not responding right now!',
            ),
            'validatorerrors' => array(
                'statuscode' => 201,
                'status' => false,
                'message' => 'Validation Error!',
            ),
            'bearertoenerror' => array(
                'statuscode' => 401,
                'status' => false,
                'message' => 'Invalid credential.Please login first',
            ),
            'basictoenerror' => array(
                'statuscode' => 401,
                'status' => false,
                'message' => 'Invalid credential.Please Retry with correct username And apikey',
            ),
            'tokenexp' => array(
                'statuscode' => 408,
                'status' => false,
                'message' => 'Invalid Token.Please Create New Token And Use within 30 min ',
            ),
            'completed' => array(
                'statuscode' => 200,
                'status' => false,
                'message' => 'Your Are Successfully Verified All Steps ',
            ),
            'unauthorized' => array(
                'statuscode' => 401,
                'status' => false,
                'message' => 'Unauthorized Access!',
            ),
        );

        if (isset($statusResp[$input])) {

            $data       =   $statusResp[$input];
            $statuscode =   $statusResp[$input]['statuscode'];

            if (!empty($params)) {
                $data = array_merge($data, $params);
            }
            return response()->json($data, $statuscode);
        } else {
            return response()->json($params);
        }
    }

    protected function validation_response($message)
    {
        $errors = "";
        foreach ($message as $key => $value) {
            foreach ($value as $msg) {
                $errors .= $msg . '<br />';
            }
        }
        $errors = rtrim($errors, "<br />");
        return $this->response('validatorerrors', ['message' => $errors]);
    }
}
