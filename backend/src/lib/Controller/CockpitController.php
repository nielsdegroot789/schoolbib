<?php
namespace skoolBiep\Controller;

use function GuzzleHttp\json_decode;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CockpitController
{
    protected $container;
    protected $response;

    private $token = '7b8d3dc4b856cdd4c31464a2fea243';

    public function __construct(\Psr\Container\ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getNotification(Request $request, Response $response, array $args)
    {
        $this->response = $response;
        $client = new Client();
        $filter = ['fields' => 'Notification'];
        $url = $_ENV['COCKPIT_URL'];
        $token = $_ENV['COCKPIT_TOKEN'];
        $res = $client->request(
            'POST',
            $url . 'Notifications',
            [
                'query' => ['token' => $_ENV['COCKPIT_TOKEN']],
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode($filter),

            ]
        );
        $json = $res->getBody()->getContents();
        $data = json_decode($json);
        $main = $data->entries[1]->Notification;
        $result = json_encode($main);
        $response->getBody()->write($result);
        return $response->withHeader('Content-type', 'application/json');
    }

    public function getCockpitFooterData(Request $request, Response $response, array $args)
    {
        $this->response = $response;
        $client = new Client();
        $filter = ['fields' => 'Notification'];
        $url = $_ENV['COCKPIT_URL'];
        $token = $_ENV['COCKPIT_TOKEN'];
        $res = $client->request(
            'POST',
            $url . 'DefaultInformation',
            [
                'query' => ['token' => $_ENV['COCKPIT_TOKEN']],
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode($filter),

            ]
        );
        $json = $res->getBody()->getContents();
        $data = json_decode($json);
        $main = $data->entries;
        $result = json_encode($main);
        $response->getBody()->write($result);
        return $response->withHeader('Content-type', 'application/json');
    }
}
