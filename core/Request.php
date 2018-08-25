<?php
namespace Core;

class Request {

    public $data = [
        'get' => [],
        'post' => [],
    ];

    public function __construct()
    {
        $this->data = $this->getAll();
    }

    /**
     * @return array
     */
    public function getAll()
    {
        $payload = json_decode(file_get_contents('php://input'), true);

        if(empty($payload)) {
            $payload = [];
        }

        return array_merge(
            $this->cleanData($_GET),
            $this->cleanData($_POST),
            $this->cleanData($payload)
        );
    }

    /**
     * Возвращает токен авторизации
     * @return mixed
     */
    public function getAuth(){
        $token = false;
        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $header = trim($_SERVER["HTTP_AUTHORIZATION"]);
            if (preg_match('/Bearer\s(\S+)/', $header, $matches)) {
                $token = $matches[1];
            }
        }
        return $token;
    }

    public function get($key, $default = false){
        return isset($this->data[$key]) ? $this->data[$key] : $default;
    }

    /**
     * @param $data
     *
     * @return array
     */
    private function cleanData(array $data)
    {
        $result = [];
        foreach($data as $key=>$value){
            $result[$key] = strip_tags(htmlspecialchars($value));
        }
        return $result;
    }

}