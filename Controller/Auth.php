<?php
class Auth{
    public function __construct(private Usergateway $usergatway){

    }
    public function authen():bool{
        if(empty($_SERVER['HTTP_X_API_KEY']) || !isset($_SERVER['HTTP_X_API_KEY'])){
            http_response_code(404);
            echo json_encode(['message' => 'missing api key']);
            return false;
            }
            if($this->usergatway->checkapikey($_SERVER['HTTP_X_API_KEY']) <= 0){
                http_response_code(401);
                echo json_encode(['message' => 'api key is invalid']);
                return false;
            }
            return true;
    }
}
