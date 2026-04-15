<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class ChatBotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
 public function index()
    {
        return view('front.chat-bot.index');
    }

    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'history' => 'nullable|array',
        ]);

        $userMessage = $request->input('message');
        $history     = $request->input('history', []);

        // Build Gemini-format contents array
        $contents = collect($history)
            ->map(fn($m) => [
                'role'  => $m['role'] === 'assistant' ? 'model' : 'user',
                'parts' => [['text' => $m['content']]],
            ])
            ->push([
                'role'  => 'user',
                'parts' => [['text' => $userMessage]],
            ])
            ->values()
            ->toArray();

        $apiKey = config('services.gemini.key');
        $model  = 'gemini-2.5-flash';
        $response = Http::timeout(30)
            ->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}", [
                'system_instruction' => [
                    'parts' => [['text' => $this->systemPrompt()]],
                ],
                'contents'           => $contents,
                'generationConfig'   => [
                    'maxOutputTokens' => 1024,
                    'temperature'     => 0.7,
                ],
            ]);

        if ($response->failed()) {
            return response()->json([
                'error' => 'Failed to reach AI service. Please try again later.'
            ], 500);
        }
// if ($response->failed()) {
//     return response()->json([
//         'error' => $response->json('error.message') ?? $response->body()
//     ], 500);
// }
        $reply = data_get(
            $response->json(),
            'candidates.0.content.parts.0.text',
            'Sorry, I could not generate a response.'
        );

        return response()->json(['reply' => $reply]);
    }

    private function systemPrompt(): string
    {
        return <<<PROMPT
You are a professional medical AI assistant for a healthcare clinic. Your role is to:

1. Answer general health questions clearly and accurately.
2. Provide information about symptoms, medications, and general wellness.
3. Guide users to book appointments or consult doctors for serious conditions.
4. Always remind users that your answers are for informational purposes only and do not replace professional medical advice.
5. Be empathetic, professional, and concise.
6. If a question is outside medical topics, politely redirect to health-related discussions.
7. Respond in the same language the user uses (Arabic or English).

Never diagnose conditions definitively. Always recommend seeing a doctor for serious concerns.
PROMPT;
    }
}
