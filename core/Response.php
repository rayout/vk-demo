<?php

namespace Core;

class Response
{

    /**
     * Response constructor.
     */
    public function __construct()
    {

    }

    /**
     * @param int $code
     *
     * @return $this
     */
    public function setResponseCode($code)
    {
        http_response_code($code);
        return $this;
    }

    /**
     * @param $key
     *
     * @return $this
     */
    public function setContent($key)
    {
        $this->setHeader('Content-Type', $key);
        return $this;
    }

    /**
     * @param $key
     *
     * @return $this
     */
    public function setHeader($key, $value)
    {
        header("$key: $value");

        return $this;
    }

    /**
     * @param string $url
     */
    public function location($url)
    {
        return header("Location: $url");
    }
    /**
     * @param     $data
     * @param int $code
     *
     * @return mixed
     */
    public function json($data, $code = 200)
    {
        $this->setContent('application/json');
        $this->setResponseCode($code);
        echo json_encode($data);
    }

}