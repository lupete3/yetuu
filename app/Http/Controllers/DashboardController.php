<?php

namespace App\Http\Controllers;

use App\Models\Advisorie;
use App\Models\Alert;
use App\Models\ClimaticData;
use App\Models\CropManagement;
use App\Models\Farm;
use App\Models\Farmer;
use App\Models\FarmerAccompaniement;
use App\Models\FieldVisit;
use App\Models\Payment;
use App\Models\Region;
use App\Models\RiskAssessment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;
use App\Services\WeatherService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function getWeather(Request $request)
    {
        $latitude = $request->input('lat', '-2.5034752');
        $longitude = $request->input('lon', '28.8555008');

        $cacheKey = "weather_{$latitude}_{$longitude}";
        $weather = Cache::remember($cacheKey, now()->addMinutes(30), function () use ($latitude, $longitude) {
            $apiKey = config('app.openweathermap_api_key', env('OPENWEATHER_API_KEY'));
            $url = "https://api.openweathermap.org/data/2.5/weather";

            try {
                $response = Http::timeout(10)->get($url, [
                    'lat' => $latitude,
                    'lon' => $longitude,
                    'appid' => $apiKey,
                    'units' => 'metric',
                    'lang' => 'en',
                ]);

                return $response->successful() ? $response->json() : null;
            } catch (\Exception $e) {
                return null;
            }
        });

        return response()->json($weather);
    }

    // Main DashboardController

    public function dashboard(Request $request): View
    {
        $viewData = [];
        $viewData['title'] = 'Dashboard';

        // Statistiques
        $today = Carbon::today();

        // Utiliser des clones pour éviter les modifications involontaires
        $startOfWeek = $today->copy()->startOfWeek();
        $endOfWeek = $today->copy()->endOfWeek();

        $farmersToday = Farmer::whereDate('created_at', $today)->count();
        $farmersSupportToday = FarmerAccompaniement::whereDate('created_at', $today)->count();
        $farmsToday = Farm::whereDate('created_at', $today)->count();
        $fieldVisitToday = FieldVisit::whereDate('created_at', $today)->count();

        $farmersThisWeek = Farmer::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
        $farmersSupportThisWeek = FarmerAccompaniement::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
        $farmsThisWeek = Farm::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
        $fieldVisitThisWeek = FieldVisit::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();

        $farmersThisMonth = Farmer::whereMonth('created_at', $today->month)->count();
        $farmersSupportThisMonth = FarmerAccompaniement::whereMonth('created_at', $today->month)->count();
        $farmsThisMonth = Farm::whereMonth('created_at', $today->month)->count();
        $fieldVisitThisMonth = FieldVisit::whereMonth('created_at', $today->month)->count();

        $farmers = Farmer::count(); // Retrieve all farmers with their associated farmers
        $farmersSupport = FarmerAccompaniement::count(); // Retrieve all farmers Support with their associated farmers
        $farms = Farm::with('farmer')->get(); // Retrieve all farms with their associated farmers
        $fieldVisits = FieldVisit::all(); // Retrieve all FieldVisits with their associated farmers

        $nonSupport = $farmers - $farmersSupport;


        // Géolocalisation par défaut ou fournie
        $latitude = $request->input('lat', '-2.5034752');
        $longitude = $request->input('lon', '28.8555008');

        // Clé de cache unique pour cette localisation
        $cacheKey = "weather_{$latitude}_{$longitude}";
        $weather_data = Cache::remember($cacheKey, now()->addMinutes(30), function () use ($latitude, $longitude) {
            // Configuration API
            $apiKey = config('app.openweathermap_api_key', env('OPENWEATHER_API_KEY'));
            $url = "https://api.openweathermap.org/data/2.5/weather";

            try {
                $response = Http::timeout(10)->get($url, [
                    'lat' => $latitude,
                    'lon' => $longitude,
                    'appid' => $apiKey,
                    'units' => 'metric',
                    'lang' => 'en',
                ]);

                if ($response->successful()) {
                    return $response->json();
                }

                // Retourner null si l'API échoue
                return null;
            } catch (\Exception $e) {
                // En cas d'erreur réseau/API
                return null;
            }
        });

        if ($weather_data) {
            $weather = $weather_data;
        } else {
            // Si une erreur survient, utilisez des données par défaut
            $weather = [
                'main' => ['temp' => 25, 'humidity' => 50, 'pressure' => 1013],
                'weather' => [['description' => 'clear sky', 'icon' => '01d']],
                'wind' => ['speed' => 3.5],
                'clouds' => ['all' => 0],
                'sys' => ['sunrise' => time() - 3600, 'sunset' => time() + 3600],
                'name' => 'Default City',
                'rain' => ['1h' => 0],
            ];
        }

        // Stats mensuelles (12 mois)
        $year = Carbon::now()->year;

        $months = collect(range(1, 12))->map(function ($month) {
            return Carbon::create()->month($month)->format('F');
        });

        $farmersByMonth = [];
        $farmsByMonth = [];
        $fieldVisitsByMonth = [];
        $farmerSupportByMonth = [];

        foreach (range(1, 12) as $month) {
            $farmersByMonth[] = Farmer::whereYear('created_at', $year)
                                ->whereMonth('created_at', $month)
                                ->count();

            $farmsByMonth[] = Farm::whereYear('created_at', $year)
                                ->whereMonth('created_at', $month)
                                ->count();

            $fieldVisitsByMonth[] = FieldVisit::whereYear('visit_date', $year)
                                    ->whereMonth('visit_date', $month)
                                    ->count();

            $farmerSupportByMonth[] = FarmerAccompaniement::whereYear('created_at', $year)
                                    ->whereMonth('created_at', $month)
                                    ->count();
        }

        // Affichage de la vue
        return view('dashboard', compact(
            'weather',
            'farmersToday',
            'farmersSupportToday',
            'farmsToday',
            'fieldVisitToday',
            'farmersThisWeek',
            'farmersSupportThisWeek',
            'farmsThisWeek',
            'fieldVisitThisWeek',
            'farmersThisMonth',
            'farmersSupportThisMonth',
            'farmsThisMonth',
            'fieldVisitThisMonth',
            'farmers',
            'farmersSupport',
            'farms',
            'fieldVisits',
            'months',
            'farmersByMonth',
            'farmsByMonth',
            'fieldVisitsByMonth',
            'farmerSupportByMonth',
            'nonSupport'
        ))->with('viewData', $viewData);
    }


}
