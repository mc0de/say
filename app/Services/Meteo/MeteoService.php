<?php

namespace App\Services\Meteo;

use Illuminate\Http\Client\PendingRequest as Client;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class MeteoService
{
    protected string $baseUrl = 'https://api.meteo.lt/v1/';

    protected Client $client;

    public function __construct()
    {
        $this->client = Http::baseUrl($this->baseUrl);
    }

    public function places(string $placeCode): Response
    {
        /** @var Response $response */
        $response = $this->client->get("places/{$placeCode}");

        return $response;
    }

    public function forecasts(string $placeCode): Response
    {
        /** @var Response $response */
        $response = $this->client->get("places/{$placeCode}/forecasts");

        return $response;
    }

    public function longTermForecast(string $placeCode): Response
    {
        /** @var Response $response */
        $response = $this->client->get("places/{$placeCode}/forecasts/long-term");

        return $response;
    }

    public function vilnius(): Forecast
    {
        $res = $this->longTermForecast('vilnius')->json();

        return new Forecast(...$res['forecastTimestamps'][0]);
    }
}
