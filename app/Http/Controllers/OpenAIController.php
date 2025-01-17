<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OpenAIService;
use App\Models\ChatConversation;
use Ramsey\Uuid\Uuid;

class OpenAIController extends Controller
{
    protected $openAIService;

    public function __construct(OpenAIService $openAIService)
    {
        $this->openAIService = $openAIService;
    }

    public function getResponse(Request $request)
    {
        $prompt = $request->input('prompt');

        $response = $this->openAIService->getResponse($prompt);

        return response()->json([
            'response' => $response,
        ]);
    }

    public function uploadFile(Request $request)
    {
        $file = $request->file('file');
        $filePath = $file->getPathname();
        $fileId = $this->openAIService->uploadFile($filePath);

        return response()->json([
            'file_id' => $fileId,
        ]);
    }

    public function sendMessage(Request $request)
    {
        $conversationId = $request->input('conversationId') ?? (string) Uuid::uuid4();

        $userMessage = $request->input('message');
        $assistantResponse = $this->openAIService->sendMessage($userMessage);

        $assistantResponseContent = $assistantResponse->json('choices.0.message.content');
        $assistantResponseIntent = $assistantResponse->json('choices.0.message.context.intent');

        # save message from user
        $userMessageCreate = ChatConversation::create([
            "role" => "user",
            "content" => $userMessage,
            "conversation_id" => $conversationId,
        ]);

        # save message from assistant
        $assistantMessageCreate = ChatConversation::create([
            "role" => "assistant",
            "content" => $assistantResponseContent,
            "intent" => $assistantResponseIntent,
            "conversation_id" => $conversationId
        ]);

        return response()->json([
            'response' => $assistantResponseContent,
        ]);
    }

    public function getMessages()
    {
        return $this->openAIService->getMessages();
    }

    public function processCsv(Request $request)
    {
        $file = $request->file('file');
        $filePath = $file->getPathname();
        $content = file_get_contents($filePath);
        $prompt = "Analyze the following CSV content:\n" . $content;
        $response = $this->openAIService->getResponse($prompt);

        return response()->json([
            'response' => $response,
        ]);
    }
}
