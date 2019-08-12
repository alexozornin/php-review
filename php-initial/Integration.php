<?php

namespace src\Integration;

class DataProvider
{
    private $host;
    private $user;
    private $password;

    // TODO: В описании конструктора следует указать типы данных аргументов, если возможно, также можно их задать в объявлении полей класса
    /**
     * @param $host
     * @param $user
     * @param $password
     */
    public function __construct($host, $user, $password)
    {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
    }
    
    /**
     * @param array $request
     *
     * @return array
     */
    public function get(array $request)
    {
        // returns a response from external service
    }
}

?>
