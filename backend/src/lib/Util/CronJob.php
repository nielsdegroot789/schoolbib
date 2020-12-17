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
        $db = new DB();
        $results = $db->updateFines();
        foreach($results as $res){
            if ($res == -1) continue;
            //Send reminder mail
            $daysUntilHandin = $res[0];
            $address = $res[1];
            $body = $this->container->get('twig')->render('returnReminder.twig', ['daysUntilHandin' => $daysUntilHandin]);
            $subject = "Return reminder";
            $this->container->get('mailer')->sendMail($address, $body, $subject);
        }

        return $response;
    }
}