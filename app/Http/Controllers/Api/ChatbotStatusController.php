<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chatbot;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ChatbotStatusController extends Controller
{
    public function streamStatus(Chatbot $chatbot): StreamedResponse
    {
        // Verify ownership
        if ($chatbot->user_id !== auth()->id()) {
            abort(403);
        }

        return response()->stream(function () use ($chatbot) {
            while (true) {
                if (connection_aborted()) {
                    break;
                }

                $status = $chatbot->statusLogs()->latest()->first();
                
                if ($status) {
                    echo "data: " . json_encode([
                        'status' => $status->status,
                        'message' => $status->message,
                        'timestamp' => $status->created_at
                    ]) . "\n\n";
                }

                ob_flush();
                flush();
                sleep(1);
            }
        }, 200, [
            'Cache-Control' => 'no-cache',
            'Content-Type' => 'text/event-stream',
            'X-Accel-Buffering' => 'no'
        ]);
    }
} 