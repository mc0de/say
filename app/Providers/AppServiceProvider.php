<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('awtrix', function ($app) {
            return new \App\Services\AwtrixService;
        });

        $this->app->singleton('meteo', function ($app) {
            return new \App\Services\Meteo\MeteoService;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerCarbonMacros();
    }

    protected function registerCarbonMacros(): void
    {
        Carbon::macro('isDay', function (): bool {
            $timezone  = config('app.timezone_meteo');
            $date      = $this->toDateString();
            $todayData = collect($this->getSunriseData($this->year))->firstWhere('date', $date);

            $sunriseTime = Carbon::parse("{$date} {$todayData['sunrise']}", $timezone);
            $sunsetTime  = Carbon::parse("{$date} {$todayData['sunset']}", $timezone);

            return $this->between($sunriseTime, $sunsetTime);
        });

        Carbon::macro('isNight', function (): bool {
            /** @var Carbon $this */
            return ! $this->isDay();
        });

        Carbon::macro('getSunriseData', function ($year): array {
            $timezone = config('app.timezone_meteo');
            $now      = Carbon::createFromFormat('Y', $year)->tz($timezone);
            $cacheKey = "sunrise_sunset_vilnius_{$year}";

            return Cache::remember($cacheKey, now()->addHours(24), function () use ($timezone, $now) {
                $query = [
                    'lat'         => '54.68705',
                    'lng'         => '25.28291',
                    'timezone'    => $timezone,
                    'date_start'  => $now->copy()->startOfYear()->toDateString(),
                    'date_end'    => $now->copy()->endOfYear()->toDateString(),
                    'time_format' => 24,
                ];

                /** @var Response $response */
                $response = Http::baseUrl('https://api.sunrisesunset.io')
                    ->withQueryParameters($query)
                    ->get('/json');

                return $response->json('results');
            });
        });
    }
}
