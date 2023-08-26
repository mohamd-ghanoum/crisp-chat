<?php

namespace App\Http\Controllers;

use App\Facades\Crisp;
use Illuminate\Http\Request;

class CrispWebhookController extends Controller
{
    public function sessionRequestInitiated(Request $request)
    {
        Crisp::sessionRequestInitiatedHook($request);
    }

    public function messageSend(Request $request)
    {
        Crisp::messageSendHook($request);
    }

    public function messageUpdated(Request $request)
    {
        Crisp::messageUpdatedHook($request);
    }

    public function messageReceived(Request $request)
    {
        Crisp::messageReceivedHook($request);
    }

    public function messageRemoved(Request $request)
    {
        Crisp::messageRemovedHook($request);
    }


}