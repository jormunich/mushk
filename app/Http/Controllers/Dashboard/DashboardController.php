<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UploadRequest;
use App\Services\FileService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    /**
     * @param FileService $fileService
     */
    public function __construct(protected FileService $fileService)
    {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('dashboard.index');
    }

    /**
     * @param UploadRequest $request
     * @return JsonResponse
     */
    public function upload(UploadRequest $request): JsonResponse
    {
        $data = $this->fileService->upload($request->file('upload'));

        return response()->json($data);
    }
}
