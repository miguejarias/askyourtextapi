<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;

class AiController extends Controller
{
    public function ask(Request $request)
    {
        $validated = $request->validate([
            'context' => 'required|string',
            'question' => 'required|string',
        ]);

        try {
            $result = OpenAI::chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Provide clear, straightforward answers that are easy to understand in a relaxed conversational and friendly tone. Use natural, conversational language while maintaining accuracy.',
                    ],
                    [
                        'role' => 'user',
                        'content' => "Context: {$validated['context']}\n\nQuestion: {$validated['question']}",
                    ],
                ],
                'temperature' => 0.7,
            ]);

            return response()->json([
                'answer' => $result->choices[0]->message->content,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to process request',
            ], 500);
        }
    }
}
