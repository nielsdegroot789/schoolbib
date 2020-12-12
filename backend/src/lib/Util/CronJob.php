<?php

namespace skoolBiep\Util;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use skoolBiep\DB;

class CronJob
{

    public function __construct(\Psr\Container\ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function start(Request $request, Response $response, array $args)
    {
       //List of executing cronjobs
        
        //Send reminder to those nearing expire date 3days ahead(once)
        $db = new DB();
        $db->updateFines();
        return $response;
    }
}