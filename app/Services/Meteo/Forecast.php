<?php

namespace App\Services\Meteo;

use Carbon\Carbon;

class Forecast
{
    public string $icon;

    public function __construct(
        public readonly string $forecastTimeUtc,
        public readonly float $airTemperature,
        public readonly float $feelsLikeTemperature,
        public readonly int $windSpeed,
        public readonly int $windGust,
        public readonly int $windDirection,
        public readonly int $cloudCover,
        public readonly int $seaLevelPressure,
        public readonly int $relativeHumidity,
        public readonly float $totalPrecipitation,
        public readonly string $conditionCode,
    ) {
        $this->icon = $this->conditionIcon($this->conditionCode);
    }

    public static function fromArray(array $data): self
    {
        return new self(
            forecastTimeUtc: $data['forecastTimeUtc'],
            airTemperature: (float) $data['airTemperature'],
            feelsLikeTemperature: (float) $data['feelsLikeTemperature'],
            windSpeed: (int) $data['windSpeed'],
            windGust: (int) $data['windGust'],
            windDirection: (int) $data['windDirection'],
            cloudCover: (int) $data['cloudCover'],
            seaLevelPressure: (int) $data['seaLevelPressure'],
            relativeHumidity: (int) $data['relativeHumidity'],
            totalPrecipitation: (float) $data['totalPrecipitation'],
            conditionCode: $data['conditionCode'],
        );
    }

    public function forecastTime(): Carbon
    {
        return Carbon::parse($this->forecastTimeUtc);
    }

    public function toArray(): array
    {
        return [
            'forecastTimeUtc'      => $this->forecastTimeUtc,
            'airTemperature'       => $this->airTemperature,
            'feelsLikeTemperature' => $this->feelsLikeTemperature,
            'windSpeed'            => $this->windSpeed,
            'windGust'             => $this->windGust,
            'windDirection'        => $this->windDirection,
            'cloudCover'           => $this->cloudCover,
            'seaLevelPressure'     => $this->seaLevelPressure,
            'relativeHumidity'     => $this->relativeHumidity,
            'totalPrecipitation'   => $this->totalPrecipitation,
            'conditionCode'        => $this->conditionCode,
        ];
    }

    protected function conditionIcon(string $conditionCode)
    {
        return match ($conditionCode) {
            'clear'                         => '',
            'partly-cloudy'                 => '',
            'cloudy-with-sunny-intervals'   => '',
            'cloudy'                        => '',
            'light-rain'                    => '',
            'rain'                          => '',
            'heavy-rain'                    => '',
            'thunder'                       => '',
            'isolated-thunderstorms'        => '',
            'thunderstorms'                 => '',
            'heavy-rain-with-thunderstorms' => '',
            'light-sleet'                   => '',
            'sleet'                         => '',
            'freezing-rain'                 => '',
            'hail'                          => '',
            'light-snow'                    => '',
            'snow'                          => '2289',
            'heavy-snow'                    => '',
            'fog'                           => '',
            default                         => '2289',
        };
    }

    protected function isDay(): bool
    {
        return now(config('app.timezone_meteo'))->isDay();
    }
}
