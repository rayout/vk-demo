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
        return [
            'get' => $this->cleanData($_GET),
            'post' => $this->cleanData($_POST),
        ];
    }

    public function get($key, $default = false){
        return !empty($this->data['get'][$key]) ? $this->data['get'][$key] : $default;
    }

    public function post($key, $default = false)
    {
        return !empty($this->data['post'][$key]) ? $this->data['post'][$key] : $default;
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