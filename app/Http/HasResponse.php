<?php

namespace App\Http;

use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

trait HasResponse
{
    private $with = [];
    private $content = [];
    private $headers = [];

    protected function jsonResponse(
        $data,
        string $message = null,
        array $errors = [],
        int $responseCode = null
    ) {
        if ($data instanceof JsonResource) {
            /** @noinspection PhpUnhandledExceptionInspection */
            /** @var Request $request */
            $request = Container::getInstance()->make('request');
            $response = $data->toResponse($request);
            // set response code if not defined
            $responseCode = $responseCode ?? $response->getStatusCode();
            // define headers
            $this->headers = $response->headers->all();
            $response = json_decode($data->toResponse($request)->getContent(), true);
            $data = [];
            $this->jsonWith($response);
        }

        $responseCode = $responseCode ?? 200;
        $message = $message ?? 'Operation performed successfully';

        $this->content['errors'] = $errors;
        $this->content['message'] = $message;
        $this->content['status_code'] = $responseCode;

        $data = collect(['data' => $data])
            ->merge($this->with)
            ->merge($this->content)
            ->toArray();

        return response()->json($data, $responseCode);
    }

    /**
     * Add another keys to the response.
     *
     * @param array $with
     *
     * @return $this
     */
    protected function jsonWith(array $with)
    {
        $this->with = collect($this->with)->merge($with)->toArray();

        return $this;
    }
}