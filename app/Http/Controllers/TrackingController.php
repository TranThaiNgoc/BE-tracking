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
        $trackingNumberUniqueId = $dataTracking['output']['completeTrackResults'][0]['trackResults'][0]['trackingNumberInfo']['trackingNumberUniqueId'];
        $actual_pickup  = $dataTracking['output']['completeTrackResults'][0]['trackResults'][0]['dateAndTimes'][0]['dateTime'];
        $ship = $dataTracking['output']['completeTrackResults'][0]['trackResults'][0]['dateAndTimes'][1]['dateTime'];
        $actual_tender = $dataTracking['output']['completeTrackResults'][0]['trackResults'][0]['dateAndTimes'][2]['dateTime'];
        $description = $dataTracking['output']['completeTrackResults'][0]['trackResults'][0]['serviceDetail']['description'];
        $histories = $dataTracking['output']['completeTrackResults'][0]['trackResults'][0]['scanEvents'];
        $packageDetails = $dataTracking['output']['completeTrackResults'][0]['trackResults'][0]['packageDetails']['count'];
        $carrierCode = $dataTracking['output']['completeTrackResults'][0]['trackResults'][0]['trackingNumberInfo']['carrierCode'];

        $data = [
            'description' => $description,
            'trackingNumber' => $trackingNumber,
            'histories' => $histories,
            'trackingNumberUniqueId' => $trackingNumberUniqueId,
            'actual_pickup' => $actual_pickup,
            'ship' => $ship,
            'actual_tender' => $actual_tender,
            'packageDetails' => $packageDetails,
            'carrierCode' => $carrierCode,
        ];

        return response()->json($data);
    }
}
