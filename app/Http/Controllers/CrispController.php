<?php

namespace App\Http\Controllers;

use App\Facades\Crisp;
use Illuminate\Http\Request;

class CrispController extends Controller
{



    public function index(Request $request)
    {

        // $data = Crisp::listConvirsations(1, []);
        $mohamdGhanoumUserId = '71e34e0e-0082-4eb3-ae2c-3b407fd0b798';
        // return $data = Crisp::getConversation('session_e18f6087-e51a-4020-8725-c441d7abbc0f');
        // return Crisp::assignConversationRouting('session_f13a9d9d-2594-413e-9461-e700e1ea0e45', $mohamdGhanoumUserId);
        // return Crisp::listOperators();
        return Crisp::getOperator($mohamdGhanoumUserId);

        // dd($data);
        // $CrispClient = new \Crisp\CrispClient;

        // dd(
        //     $CrispClient->websiteVisitors->listVisitors($this->wesiteId, 1)
        // );
        // $CrispClient->setTier("plugin");
        // $CrispClient->authenticate($this->identefier, $this->key);
        // $conversations = $CrispClient->websiteConversations->getList($this->wesiteId, 1);

        return view('crisp.home');
    }
}