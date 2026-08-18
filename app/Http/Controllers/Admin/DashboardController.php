<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(private readonly DashboardService $dashboard) {}

    public function __invoke(Request $request)
    {
        $data = $this->dashboard->payload();

        return $request->wantsJson()
            ? $this->ok($data)
            : view('admin.dashboard.index', $data);
    }
}
