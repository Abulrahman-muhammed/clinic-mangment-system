<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatBotController extends Controller
{
    public function index()
    {
        return view('front.chat-bot.index');
    }

    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'history' => 'nullable|array|max:20',
        ]);

        $userMessage = $request->input('message');
        $history = array_slice($request->input('history', []), -10);

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

        try {
            $response = Http::timeout(30)
                ->post(
                    "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}",
                    [
                        'system_instruction' => [
                            'parts' => [['text' => $this->systemPrompt()]],
                        ],
                        'contents'         => $contents,
                        'generationConfig' => [
                            'maxOutputTokens' => 1024,
                            'temperature'     => 0.4,
                        ],
                    ]
                );
        } catch (\Exception $e) {
            Log::error('Gemini API error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to reach AI service. Please try again later.'
            ], 500);
        }

        if ($response->failed()) {
            Log::error('Gemini HTTP error', ['status' => $response->status(), 'body' => $response->body()]);
            return response()->json([
                'error' => 'Failed to reach AI service. Please try again later.'
            ], 500);
        }

        $rawReply = data_get(
            $response->json(),
            'candidates.0.content.parts.0.text',
            '{}'
        );

        $aiData = $this->parseAiResponse($rawReply);

        $result = [
            'reply'   => $aiData['message'] ?? 'Sorry, I could not process your request.',
            'doctors' => [],
            'urgency' => $aiData['urgency'] ?? 'low',
            'major'   => null,
        ];

        if (!empty($aiData['major']) && $aiData['major'] !== 'general') {
            $major = Major::where('title', 'like', '%' . $aiData['major'] . '%')
                          ->whereNull('deleted_at')
                          ->first();

            if ($major) {
                $doctors = Doctor::where('major_id', $major->id)
                    ->whereNull('deleted_at')
                    ->with([
                        'user',
                        'schedules' => fn($q) => $q->whereNull('deleted_at')->orderBy('day_of_week'),
                    ])
                    ->limit(3)
                    ->get()
                    ->map(function ($doc) {
                        $nextSchedule = $doc->schedules->first();

                        return [
                            'id'               => $doc->id,
                            'name'             => $doc->user?->name ?? 'Dr. Unknown',
                            'major'            => $doc->major?->title,
                            'consultation_fee' => $doc->consultation_fee,
                            'experience'       => $doc->years_of_experience,
                            'image' => $doc->image
                                ? asset('images/doctors/' . $doc->image)
                                : null,
                            'schedule' => $nextSchedule
                                ? $nextSchedule->day_of_week
                                  . ' ' . substr($nextSchedule->start_time, 0, 5)
                                  . '–' . substr($nextSchedule->end_time, 0, 5)
                                : null,
                            'booking_url' => route('front.booking.create', ['doctor' => $doc->id]),
                        ];
                    });

                $result['doctors'] = $doctors;
                $result['major']   = $major->title;
            }
        }

        return response()->json($result);
    }

    private function parseAiResponse(string $raw): array
    {
        $clean = preg_replace('/```json\s*|\s*```/', '', $raw);
        $clean = trim($clean);

        if (($start = strpos($clean, '{')) !== false) {
            $clean = substr($clean, $start);
        }

        $data = json_decode($clean, true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($data)) {
            return $data;
        }

        Log::warning('Gemini returned non-JSON response', ['raw' => substr($raw, 0, 300)]);
        return ['message' => $raw, 'major' => null, 'urgency' => 'low'];
    }

    private function systemPrompt(): string
    {
        $majors = Major::whereNull('deleted_at')->pluck('title')->join(', ');

        return <<<PROMPT
You are a professional medical AI assistant for a healthcare clinic.

IMPORTANT: Always respond ONLY with a valid JSON object in this exact format, no extra text:
{
  "message": "Your helpful response here",
  "major": "Cardiology",
  "urgency": "low|medium|high"
}

Rules:
- "message": Write a clear, empathetic response in the SAME language the user used (Arabic or English). Use markdown for formatting when helpful (bold, lists, etc).
- "major": Choose ONE from this exact list: [{$majors}]. Use "general" if no specific major fits.
- "urgency": "high" = emergency/life-threatening, "medium" = should see a doctor soon, "low" = routine question or general information.
- Never definitively diagnose. Always recommend seeing a doctor for any medical concern.
- For emergencies (chest pain, difficulty breathing, stroke symptoms, severe bleeding), set urgency to "high" and advise calling emergency services immediately.
- Do NOT include markdown or code blocks around the JSON. Output raw JSON only.
PROMPT;
    }
}