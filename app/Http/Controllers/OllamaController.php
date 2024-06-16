<?php

namespace App\Http\Controllers;

use Cloudstudio\Ollama\Facades\Ollama;
use Illuminate\Http\Request;
use Log;

class OllamaController extends Controller
{


    public function generateResponse(Request $request)
    {
//        // Retrieve current conversation history from session
//        $conversationHistory = session()->get('conversation_history', []);

//        // Add the user's prompt to the conversation history
//        $conversationHistory[] = "USER: " . $request->input('prompt');

        $history = $request->input('prompt', []);
        $fullPrompt = "Here is the conversation history, reply to the latest user message based on the context:\n";

        foreach ($history as $message) {
            // Ensure 'from' and 'message' keys exist in each message
            if (isset($message['from']) && isset($message['message'])) {
                $fullPrompt .= ($message['from'] == 'user' ? 'User: ' : 'LaraveLLama: ') . $message['message'] . "\n";
            }
        }
        // Make the request to Ollama with the full prompt
        $response = Ollama::agent(
            'You are LaraveLLama, a witty, sarcastic, and friendly assistant with a knack for humor. Respond concisely and with a touch of sarcasm. Keep your answers short and entertaining.'
        )
            ->prompt($fullPrompt)
            ->model('mistral')
            ->options(['temperature' => 0.8])
            ->stream(false)
            ->ask();

//        // Add the bot's response to the conversation history
//        $conversationHistory[] = "BOT: " . $response['response']; // Assuming 'response' contains the actual response text

//        // Update the session with the updated conversation history
//        session()->put('conversation_history', $conversationHistory);

//        // Limit conversation history to the last 10 prompts (if needed)
//        if (count($conversationHistory) > 10) {
//            array_shift($conversationHistory);
//            session()->put('conversation_history', $conversationHistory); // Update session after limiting history
//        }

        // Log the conversation history and bot response
        Log::info('Conversation History: ' . $fullPrompt);


        // Return the bot's response as JSON
        return response()->json($response);
    }

}
