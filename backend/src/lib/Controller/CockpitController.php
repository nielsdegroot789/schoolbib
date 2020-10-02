<?php
namespace skoolBiep\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use GuzzleHttp\Client;

use function GuzzleHttp\json_decode;

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
        $filter = ['fields' => 'Notification'];
        $url = $_ENV['COCKPIT_URL'];
        $res = $client->request(
            'POST',
            $url,
            [
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'body' => json_encode($filter)

            ]
        );
        $json = $res->getBody()->getContents();
        $data = json_decode($json);
        $main = $data->entries[1]->Notification;
        $result = json_encode($main);
        $response->getBody()->write($result);
        return $response->withHeader('Content-type' , 'application/json');
    }   
}
