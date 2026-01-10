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

    protected function conditionIcon($conditionCode): string
    {
        return match ($conditionCode) {
            'clear'                         => $this->isDay() ? '53386' : '53383',
            'partly-cloudy'                 => $this->isDay() ? '52173' : '12195',
            'cloudy-with-sunny-intervals'   => $this->isDay() ? '52173' : '12195',
            'cloudy'                        => '91',
            'light-rain'                    => '2720',
            'rain'                          => '2720',
            'heavy-rain'                    => '49300',
            'thunder'                       => '29839',
            'isolated-thunderstorms'        => '49299',
            'thunderstorms'                 => '49299',
            'heavy-rain-with-thunderstorms' => '49299',
            'light-sleet'                   => '49301',
            'sleet'                         => '49301',
            'freezing-rain'                 => '49301',
            'hail'                          => '52158',
            'light-snow'                    => '2289',
            'snow'                          => '2289',
            'heavy-snow'                    => '2289',
            'fog'                           => '52167',
            default                         => '2289',
        };
    }

    protected function isDay(): bool
    {
        return now(config('app.timezone_meteo'))->isDay();
    }
}
