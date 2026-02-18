<?php

namespace App\Services;

use GuzzleHttp\Client;

class WeatherService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('OPENWEATHER_API_KEY'); // Clé API à mettre dans le fichier .env
    }

    public function getWeather($city = 'bukavu')
    {
        $url = "https://api.openweathermap.org/data/2.5/weather?q={$city}&units=metric&appid={$this->apiKey}";

        try {
            $response = $this->client->get($url);
            $data = json_decode($response->getBody(), true);
            return [
                'temperature' => round($data['main']['temp']),
                'description' => ucfirst($data['weather'][0]['description']),
                'wind_speed' => $data['wind']['speed'],
                'icon' => $data['weather'][0]['icon'],
            ];
        } catch (\Exception $e) {
            return [
                'temperature' => null,
                'description' => 'Error fetching data',
                'wind_speed' => null,
                'icon' => '01d', // Icône par défaut
            ];
        }
    }
}
