<?php

namespace skoolBiep\Util;

class CronJob
{
    public function start(Request $request, Response $response, array $args)
    {
       //List of executing cronjobs
        
        //Send reminder to those nearing expire date 3days ahead(once)
        //


       //Todo Send reminder day before expire

       //Todo Update fines for all checkouts above expire date and not returned
       return $response;

    }
}