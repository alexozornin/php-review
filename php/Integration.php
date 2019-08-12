<?php

namespace src\Integration;

class DataProvider
{
    private string $host;
    private string $user;
    private string $password;

    /**
     * @param string $host
     * @param string $user
     * @param string $password
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
