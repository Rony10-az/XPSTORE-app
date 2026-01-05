<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VideoGame;
use App\Models\GameCode;
use App\Models\User;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Ventas por período (usando códigos vendidos como proxy)
            $today = Carbon::today();
            $weekStart = Carbon::now()->startOfWeek();
            $monthStart = Carbon::now()->startOfMonth();

            // Ventas totales (calculadas desde códigos usados)
            $salesToday = GameCode::where('status', 'usado')
                ->whereDate('used_at', $today)
                ->count();

            $salesWeek = GameCode::where('status', 'usado')
                ->where('used_at', '>=', $weekStart)
                ->count();

            $salesMonth = GameCode::where('status', 'usado')
                ->where('used_at', '>=', $monthStart)
                ->count();

            // Número total de códigos vendidos
            $totalCodesSold = GameCode::where('status', 'usado')->count();

            // Productos más vendidos (top 5) - método simplificado
            $topProductsData = DB::table('game_codes')
                ->select('video_game_id', DB::raw('COUNT(*) as sales_count'))
                ->where('status', 'usado')
                ->groupBy('video_game_id')
                ->orderBy('sales_count', 'desc')
                ->limit(5)
                ->get();

            $topProducts = collect();
            foreach ($topProductsData as $productData) {
                $game = VideoGame::find($productData->video_game_id);
                if ($game) {
                    $game->sales_count = $productData->sales_count;
                    $topProducts->push($game);
                }
            }

            // Stock bajo (productos con menos de 10 unidades)
            $lowStock = VideoGame::where('stock', '<', 10)
                ->where('stock', '>', 0)
                ->orderBy('stock', 'asc')
                ->get();

            // Usuarios nuevos (últimos 7 días)
            $newUsers = User::where('created_at', '>=', Carbon::now()->subDays(7))
                ->where('role', '!=', 'admin')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            // Reseñas pendientes de moderación
            $pendingReviews = Review::whereNull('moderated_at')
                ->with(['user', 'videoGame'])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            // Contadores de reseñas por estado (usando GameReview que tiene la columna status)
            $reviewsApproved = \App\Models\GameReview::where('status', 'aprobada')->count();
            $reviewsRejected = \App\Models\GameReview::where('status', 'rechazada')->count();
            $reviewsPending = \App\Models\GameReview::where('status', 'pendiente')->count();

            return view('admin.dashboard', compact(
                'salesToday',
                'salesWeek',
                'salesMonth',
                'totalCodesSold',
                'topProducts',
                'lowStock',
                'newUsers',
                'pendingReviews',
                'reviewsApproved',
                'reviewsRejected',
                'reviewsPending'
            ));
        } catch (\Exception $e) {
            // Si hay algún error, redirigir al dashboard de usuario con mensaje de error
            return redirect()->route('dashboard.user')->with('error', 'Error al cargar el dashboard de administrador: ' . $e->getMessage());
        }
    }
}
