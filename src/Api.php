<?php

namespace Zetgram;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use Zetgram\Exceptions\UndefinededException;

class Api extends ApiAbstract
{
    protected const API_END_POINT = 'https://api.telegram.org/bot';

    /**
     * @var HttpClient
     */
    protected HttpClient $client;

    /**
     * @var string
     */
    protected string $api_url;

    /**
     * @var ExceptionHandler
     */
    protected ExceptionHandler $exceptionHandler;

    /**
     * Api constructor.
     * @param HttpClient $client
     * @param string $token
     * @param ExceptionHandler $exceptionHandler
     */
    public function __construct(HttpClient $client, string $token, ExceptionHandler $exceptionHandler)
    {
        $this->client = $client;
        $this->api_url = self::API_END_POINT . $token . '/';
        $this->exceptionHandler = $exceptionHandler;
    }

    protected function sendRequest(string $uri, array $data = [])
    {
        if (empty($data)) {
            return $this->getRequest($uri);
        }
        return $this->postRequest($uri, $data);
    }

    protected function request($method, $data = [])
    {
        $uri = $this->api_url . $method;
        try {
            $response = $this->sendRequest($uri, $data);
            $body = $response->getBody()->getContents();
            return json_decode($body)->result;
        } catch (ClientException $exception) {
            $this->handleException($exception);
        }
        return null;
    }

    protected function postRequest(string $uri, array $data)
    {
        return $this->client->request('POST', $uri, [
            'form_params' => $data
        ]);
    }

    protected function getRequest(string $uri)
    {
        return $this->client->request('GET', $uri);
    }

    /**
     * @param ClientException $exception
     * @throws UndefinededException
     */
    protected function handleException(ClientException $exception) {
        $body = $exception->getResponse()->getBody()->getContents();
        $data = json_decode($body);

        if(!isset($data->ok) && $data->ok === false)
            throw $exception;

        throw new UndefinededException($data->description);
    }
}
