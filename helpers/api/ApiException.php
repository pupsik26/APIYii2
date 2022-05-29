<?php


namespace app\helpers\api;


use Throwable;
use Yii;
use yii\web\Response;

class ApiException extends \Exception
{
    protected $request;

    public function __construct($message = "", $code = 0, $request = null, Throwable $previous = null)
    {
        $this->message = $message;
        $this->code = $code;
        $this->request = $request;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return null
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return array
     */
    public function getAllInfoRequest()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            "message" => $this->getMessage(),
            "code" => $this->getCode(),
            "request" => $this->getRequest(),
        ];
    }

}