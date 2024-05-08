<?php

namespace App\Http\Controllers;

use App\Models\Scheduler;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SchedulerController extends Controller
{
    public function handle(Request $request): JsonResponse
    {
        $request->validate([
            'channel' => 'required|string|in:mail,database',
            'message' => 'required|string|max:256',
            'time' => 'date_format:Y-m-d H:i:s',
            'email' => 'required|present_if:channel,mail',
        ]);

        try {
            $scheduler = Scheduler::create($request->all());
            return response()->json($scheduler, Response::HTTP_CREATED);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }
}
