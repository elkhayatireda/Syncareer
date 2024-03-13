<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use App\Events\sendMessage;
use App\Models\Conversation;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function fetchContacts(Request $request)
    {
        $user = $request->user();
        $unreadMessages = 0 ;
        if ($user->tokenCan('user')) {
            $type = 'user';



            // $conversations = Conversation::where(function ($query) use ($user) {
            //     $query->where('user1_id', $user->id);
            // })
            // ->with(['messages' => function ($query) {
            //     $query->latest()->first();
            // }])
            // ->get();
            
            // $totalUnreadCount = 0;
            
            // $result = $conversations->map(function ($conversation) use (&$totalUnreadCount) {
            //     $unreadCount = $conversation->messages
            //         ->where('status', '!=', 'read')
            //         ->where('role', '!=', 'user')
            //         ->count();
            
            //     $totalUnreadCount += $unreadCount;
            
            //     // Get the last message in the conversation
            //     $lastMessage = $conversation->messages->first();
            
            //     // Get the name of the company
            //     $company = Company::find($conversation->user2_id); // Adjust the field name accordingly
            //     $companyName = $company ? $company->name : null;
            
            //     // Get the time of the last message in H:mm format
            //     $lastMessageTime = $lastMessage ? $lastMessage->created_at->format('H:mm') : null;
            
            //     // Get the picture from the companies table or use a default string
            //     $companyPicture = $company ? $company->picture : 'default_picture.jpg'; // Replace with the actual field name and default picture name
            
            //     return [
            //         'conversation_id' => $conversation->id,
            //         'company_name' => $companyName,
            //         'last_message' => [
            //             'content' => $lastMessage ? $lastMessage->content : null,
            //             'sent_or_received' => $lastMessage ? ($lastMessage->role === 'user' ? 'sent' : 'received') : null,
            //             'time' => $lastMessageTime,
            //         ],
            //         'unread_messages' => $unreadCount,
            //         'company_picture' => $companyPicture,
            //     ];
            // })->toArray();
            
            // // Include the total unread count in the result
            // $result['total_unread_messages'] = $totalUnreadCount;









            // $conversations = Conversation::where(function ($query) use ($user) {
            //     $query->where('user1_id', $user->id);
            // })
            //     ->with(['messages' => function ($query) {
            //         $query->where('status', 'sent'); 
            //     }])
            //     ->get();
            
            // foreach ($conversations as $conversation) {
            //     $unreadCount = $conversation->messages->count();
            // }

        } elseif ($user->tokenCan('company')) {
            $type = 'company';
        } elseif ($user->tokenCan('admin')) {
            $type = 'admin';
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        
        return response()->json(['conversations' => $result]);
    }

    public function chatmessage(Request $request){
        $user = $request->user();
        $userId = $user->id ;
        $conversationId = $request->input('conversationId');
        $message = $request->input('message');
        event(new sendMessage($message,$userId,1));
        return null ; 
    }
}
