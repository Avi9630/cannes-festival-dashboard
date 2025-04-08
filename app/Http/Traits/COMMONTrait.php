<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use App\Models\Assignedservice;
use App\Http\Traits\LOGTrait;
use App\Models\Permission;
use App\Models\Credential;
use App\Models\ApiPartner;
use App\Models\TokenReq;
use App\Libraries\Curl;
use App\Models\Config;
use App\Libraries\Jwt;
use App\Models\User;
use DB;

trait COMMONTrait
{
    use LOGTrait;

    public static function create_otp($min, $max)
    {
        return (unpack("N", openssl_random_pseudo_bytes(4))[1] % ($max - $min)) + $min;
    }

    public static function generatetoken($ip)
    {
        return sha1("MCRKRD" . $ip . time());
    }

    public static function dbdatetime($date)
    {
        if (!empty($date) && !is_null($date)) {
            return date("Y-m-d H:i:s", strtotime($date));
        }
    }

    public static function dbdate($date)
    {
        if (!empty($date) && !is_null($date)) {
            return date("Y-m-d", strtotime($date));
        }
    }

    public function cahngeDateFormat($str)
    {

        return date("d/m/Y", strtotime(substr($str, 0, 16)));
    }

    public static function dateonlyFormat($date)
    {
        if (!empty($date) && !is_null($date)) {
            return date("d F, Y", strtotime($date));
        }
    }

    public static function dateonlyFormat2($date)
    {
        if (!empty($date) && !is_null($date)) {
            return date("d-m-Y", strtotime($date));
        }
    }

    public static function dateFormat($date)
    {
        if (!empty($date) && !is_null($date)) {
            return date("d F, Y @ h:i A", strtotime($date));
        }
    }

    public static function timeFormat($time)
    {
        if (!empty($time) && !is_null($time)) {
            return date("h:i A", strtotime($time));
        }
    }
    public function response($input = '', $params = array())
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
                'statuscode' => 500,
                'status' => false,
                'message' => 'Exception Error!',
            ),
            'incorrectinfo' => array(
                'statuscode' => 200,
                'status' => false,
                'message' => 'The provided information is incorrect!',
            ),
            'updateError' => array(
                'statuscode' => 200,
                'status' => false,
                'message' => 'Error while Updating!',
            ),
            'notvalid' => array(
                'statuscode' => 200,
                'status' => false,
                'message' => 'The provided information is not Valid!',
            ),
            'apierror' => array(
                'statuscode' => 408,
                'status' => false,
                'message' => 'API is not responding right now!',
            ),
            'validatorerrors' => array(
                'statuscode' => 200,
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
                'statuscode' => 401,
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
            'created' => array(
                'statuscode' => 201,
                'status' => false,
                'message' => 'Created Successfully!',
            ),
        );
        if (isset($statusResp[$input])) {
            $data = $statusResp[$input];
            $statuscode = $statusResp[$input]['statuscode'];
            unset($data['statuscode']);
            if (!empty($params)) {
                $data = array_merge($data, $params);
            }
            return response()->json($data, $statuscode);
        } else {
            return response()->json($params);
        }
    }

    public function validation_response($message)
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

    public function sendOtp($mobile_no, $otp)
    {
        $msg            =   "Do not share your login OTP with anyone.$otp OTP to accessing your Account. Please report unauthorised access to customer care. Powered by RNFI.";
        $message        =   urlencode($msg);
        $number         =   trim($mobile_no);
        $sender         =   "RNFIBC";
        $url            =   "https://alerts.cbis.in/SMSApi/send?userid=rnfiotp&password=PeterKivani@!1&sendMethod=quick&mobile=" . $number . "&msg=" . $message . "&senderid=" . $sender . "&msgType=text&duplicatecheck=true&format=json";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $buffer = curl_exec($ch);
        curl_close($ch);
        return $otp;
    }

    public static function arrayColumnSearch($search, $array, $key, $value)
    {
        $response = array_search($search, array_column($array, $key));
        if ($response === 0) {
            return $array[$response][$value];
        } else if (!empty($response)) {
            return $array[$response][$value];
        } else {
            return false;
        }
    }

    public static function keytovalue($key = '')
    {
        $data = ucwords(str_replace("_", " ", $key));
        return $data;
    }

    public function getCredential($id)
    {
        $credential = Credential::select('created_at', 'updated_at', 'data')
            ->where('id', $id)
            ->first()
            ->toArray();

        if (!empty($credential)) {
            $decodeData =   json_decode($credential['data'], true);
            $decodeData =   Crypt::decrypt($decodeData['body']);
            $decodeData['created_at']   =  $credential['created_at'];
            $decodeData['updated_at']   =  $credential['updated_at'];
            return   $decodeData;
        } else {
            $res = [
                'message' => 'Credentials not found!!'
            ];
            return $this->response('exception', $res);
        }
    }

    public static function websiteType()
    {
        return [
            'IP'    =>  1,
            'OTT'   =>  2,
            'CMOT'  =>  3
        ];
    }
}
