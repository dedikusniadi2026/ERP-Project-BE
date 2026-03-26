<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Services\DashboardService;

class DashboardController extends Controller {
    public function index() {
        return app(DashboardService::class)->stats();
    }
}
?>