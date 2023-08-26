<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class CrispService
{

    public $key;
    public $identefier;
    public $secret;
    public $websiteId;
    public $client;
    public $headers;
    public $url = 'https://api.crisp.chat/v1';


    public function __construct()
    {
        $this->key = config('crisp.key');
        $this->identefier = config('crisp.identefier');
        $this->secret = config('crisp.secret');
        $this->websiteId = config('crisp.website_id');
        $this->client = new Client();

        $credentials = base64_encode("$this->identefier:$this->key");

        $this->headers = [
            'Content-Type' => 'application/json',
            'X-Crisp-Tier' => 'plugin',
            'Authorization' => "Basic $credentials"
        ];
    }


    public function listConvirsations($page = 1, $options = [])
    {

        // /v1/website/{website_id}/conversations/{page_number}{?search_query}{&search_type}{&search_operator}{&include_empty}{&filter_unread}{&filter_resolved}{&filter_not_resolved}{&filter_mention}{&filter_assigned}{&filter_unassigned}{&filter_date_start}{&filter_date_end}{&order_date_created}{&order_date_updated}
        try {
            $defaultOptions = [
                'search_query' => null,
                'search_type' => null,
                'search_operator' => null,
                'include_empty' => 0,
                'filter_unread' => 0,
                'filter_resolved' => 0,
                'filter_not_resolved' => 0,
                'filter_mention' => 0,
                'filter_assigned' => null,
                'filter_unassigned' => 0,
                'filter_date_start' => null,
                'filter_date_end' => null,
                'order_date_created' => 0,
                'order_date_updated' => 0,
            ];

            $options = array_merge($defaultOptions, $options);

            $queryParams = [
                'page_number' => $page,
            ];

            foreach ($options as $key => $value) {
                if ($value !== null) {
                    $queryParams[$key] = $value;
                }
            }

            $response = $this->client->request('GET', "$this->url/website/$this->websiteId/conversations/$page", [
                'headers' => $this->headers,
                'query' => $queryParams,
            ]);

            $data = json_decode($response->getBody(), true);

            if ($data['error'] == false) {
                return $data['data'];
            }
            throw new \Exception("Error Processing Request");
        } catch (\Exception $e) {
            //TODO 
            dd($e);

        }


    }

    public function getConversation($sessionId)
    {
        try {
            $response = $this->client->request('GET', "$this->url/website/$this->websiteId/conversation/$sessionId", [
                'headers' => $this->headers,
            ]);

            $data = json_decode($response->getBody(), true);

            if ($data['error']) {
                throw new \Exception("Error Processing Request");
            }

            return $data['data'];

        } catch (\Exception $e) {
            // Handle the exception or log it
            dd($e);
            return false;
        }
    }

    public function assignConversationRouting($sessionId, $userId)
    {
        try {
            $payload = [
                'assigned' => [
                    'user_id' => $userId
                ],
            ];

            $response = $this->client->request('PATCH', "$this->url/website/$this->websiteId/conversation/$sessionId/routing", [
                'headers' => $this->headers,
                'json' => $payload,
            ]);

            $data = json_decode($response->getBody(), true);

            if ($data['error'] == false) {
                return true;
            }

            return false;
        } catch (\Exception $e) {
            // Handle the exception or log it
            dd($e);
            return false;
        }
    }

    public function listOperators()
    {
        try {
            $response = $this->client->request('GET', "$this->url/website/$this->websiteId/operators/list", [
                'headers' => $this->headers,
            ]);

            $data = json_decode($response->getBody(), true);

            if (!$data['error']) {
                return $data['data'];
            }

            throw new \Exception("Error Processing Request");
        } catch (\Exception $e) {
            // Handle the exception or log it
            dd($e);
            return false;
        }
    }

    public function getOperator($userId)
    {
        try {
            $response = $this->client->request('GET', "$this->url/website/$this->websiteId/operator/$userId", [
                'headers' => $this->headers,
            ]);

            $data = json_decode($response->getBody(), true);

            if (!$data['error']) {
                return $data['data'];
            }

            throw new \Exception("Error Processing Request");
        } catch (\Exception $e) {
            // Handle the exception or log it
            dd($e);
            return false;
        }
    }

    public function inviteOperator($email, $role, $verify)
    {
        try {
            $payload = [
                'email' => $email,
                // owner Or member
                'role' => $role,
                'verify' => $verify,
            ];

            $response = $this->client->request('POST', "$this->url/website/$this->websiteId/operator", [
                'headers' => $this->headers,
                'json' => $payload,
            ]);

            $data = json_decode($response->getBody(), true);

            if (!$data['error']) {
                return $data['data'];
            }

            throw new \Exception("Error Processing Request");
        } catch (\Exception $e) {
            // Handle the exception or log it
            dd($e);
            return false;
        }
    }



    ///////////////////////  HANDLE HOOKS  ///////////////////// 
    public function sessionRequestInitiateHook(Request $request)
    {
        $data = $request->all();

        /*
            {
                "website_id": "42286ab3-b29a-4fde-8538-da0ae501d825",
                "event": "session:request:initiated",

                "data": {
                    "website_id": "42286ab3-b29a-4fde-8538-da0ae501d825",
                    "session_id": "session_36ba3566-9651-4790-afc8-ffedbccc317f"
                },

                "timestamp": 1667412361763
            }
        */
    }

    public function messageSendHook(Request $request)
    {
        $data = $request->all();

        /*
        {
            "website_id": "42286ab3-b29a-4fde-8538-da0ae501d825",
            "event": "message:send",

            "data": {
                "type": "text",
                "origin": "chat",
                "content": "Hello Crisp, this is a message from a visitor!",
                "timestamp": 1632396148646,
                "fingerprint": 163239614854320,
                "website_id": "42286ab3-b29a-4fde-8538-da0ae501d825",
                "session_id": "session_36ba3566-9651-4790-afc8-ffedbccc317f",
                "from": "user",

                "user": {
                "nickname": "visitor607",
                "user_id": "session_36ba3566-9651-4790-afc8-ffedbccc317f"
                },

                "stamped": true
            },

            "timestamp": 1632396148743
        }
        */
    }

    public function messageUpdatedHook(Request $request)
    {
        $data = $request->all();

        /*
       {
        "website_id": "42286ab3-b29a-4fde-8538-da0ae501d825",
        "event": "message:updated",

        "data": {
            "fingerprint": 163240180126629,
            "content": "This is an edited message!",
            "website_id": "42286ab3-b29a-4fde-8538-da0ae501d825",
            "session_id": "session_36ba3566-9651-4790-afc8-ffedbccc317f"
        },

        "timestamp": 1632401830425
        }
        */
    }

    public function messageReceivedHook(Request $request)
    {
        $data = $request->all();

        /*
       {
            "website_id": "42286ab3-b29a-4fde-8538-da0ae501d825",
            "event": "message:received",
            "data": {
                "website_id": "42286ab3-b29a-4fde-8538-da0ae501d825",
                "type": "text",
                "from": "operator",
                "origin": "chat",
                "content": "Hello! This is a message from an operator!",
                "fingerprint": 163239623329114,

                "user": {
                "nickname": "John Doe",
                "user_id": "012d1926-8753-4af6-9957-4853bb6fa294"
                },

                "mentions": [],
                "timestamp": 1632396233539,
                "stamped": true,
                "session_id": "session_36ba3566-9651-4790-afc8-ffedbccc317f"
            },

            "timestamp": 1632396233588
        }
        */
    }

    public function messageRemovedHook(Request $request)
    {
        $data = $request->all();

        /*
            {
                "website_id": "42286ab3-b29a-4fde-8538-da0ae501d825",
                "event": "message:removed",

                "data": {
                    "fingerprint": 163240180126629,
                    "website_id": "42286ab3-b29a-4fde-8538-da0ae501d825",
                    "session_id": "session_36ba3566-9651-4790-afc8-ffedbccc317f"
                },

                "timestamp": 1632401830425
            }
        */
    }

}