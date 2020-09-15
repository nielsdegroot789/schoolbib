<?php
namespace skoolBiep\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use GuzzleHttp\Client;

class CockpitController {
    protected $container;
    protected $response;

    private $token = '7b8d3dc4b856cdd4c31464a2fea243';

    public function __construct(\Psr\Container\ContainerInterface $container)
    {
        $this->container = $container;
    }


    public function getNotification(Request $request, Response $response, array $args) {
        $this->response = $response;
        $client = new Client();
        $url = 'http://skoolbiep.fullstacksyntra.be/cockpit/api/collections/get/Notifications?token=' . $this->token;
        $res = $client->request(
            'POST',
            $url,
            [
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
            ]
        );
        $json = $res->getBody()->getContents();
        $response->getBody()->write($json);
        return $response->withHeader('Content-type' , 'application/json');
    }   
}
