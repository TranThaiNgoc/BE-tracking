<?php

namespace App\Repositories\Eloquent;

use App\Tracking;
use App\Repositories\Contracts\TrackingRepository;
use GuzzleHttp\Client;

class EloquentTrackingRepository implements TrackingRepository
{
    protected $model;

    public function getToken()
    {
        try {
            $client = new Client();

            $response = $client->request('POST', 'https://apis-sandbox.fedex.com/oauth/token', [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ],
                'form_params' => [
                    'grant_type' => 'client_credentials',
                    'client_id' => 'l7bb165bae674e4bdba0b57f193753b0cb',
                    'client_secret' => 'dc72fb7e7f5a47a2845106fe19ee165c',
                ]
            ]);

            $jsonResponse = json_decode($response->getBody(), true);
        
            $accessToken = $jsonResponse['access_token'];
            
            return $accessToken;

        } catch (RequestException $e) {
            Log::error($e->getMessage());
            return null;
        }
    }

    public function getDataTracking($token) {
        $client = new Client([
            'base_uri' => 'https://apis-sandbox.fedex.com/',
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'X-locale' => 'en_US',
                'Content-Type' => 'application/json',
            ],
        ]);

        $json = '{
            "trackingInfo": [
                {
                    "trackingNumberInfo": {
                        "trackingNumber": "123456789012"
                    }
                }
            ],
            "includeDetailedScans": true
        }';
        
        $data = json_decode($json, true);
          
          
        $response = $client->post('track/v1/trackingnumbers', [
            'json' => $data,
        ]);

        return json_decode($response->getBody(), true);

    }

    public function __construct(Tracking $model)
    {
        $this->model = $model;
    }

    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $model = $this->getById($id);
        $model->update($data);
        return $model;
    }

    public function delete($id)
    {
        $model = $this->getById($id);
        $model->delete();
    }
}
