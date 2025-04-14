<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chatbot;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function index(): JsonResponse
    {
        $chatbots = auth()->user()->chatbots()->latest()->get();
        
        return response()->json([
            'data' => $chatbots
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $chatbot = auth()->user()->chatbots()->create([
            'name' => $validated['name'],
            'status' => 'inactive',
        ]);

        return response()->json([
            'data' => $chatbot
        ], 201);
    }
} 