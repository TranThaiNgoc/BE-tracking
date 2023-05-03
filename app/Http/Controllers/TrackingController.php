<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contracts\TrackingRepository;

class TrackingController extends Controller
{
    protected $TrackingRepository;

    public function __construct(TrackingRepository $TrackingRepository)
    {
        $this->TrackingRepository = $TrackingRepository;
    }

    public function index() {
        $token = $this->TrackingRepository->getToken();
        $dataTracking = $this->TrackingRepository->getDataTracking($token);
        
        $trackingNumber = $dataTracking['output']['completeTrackResults'][0]['trackingNumber'];
        $description = $dataTracking['output']['completeTrackResults'][0]['trackResults'][0]['serviceDetail']['description'];

        $data = [
            'description' => $description,
            'trackingNumber' => $trackingNumber
        ];

        return response()->json($data);
    }
}
