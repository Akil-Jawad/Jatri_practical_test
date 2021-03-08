<?php

namespace App\Http\Controllers;

use App\Repositories\DataRepositoryInterface;
use Illuminate\Http\Request;

class FareMobilityController extends Controller
{
    //
    private $dataRepository;

    public function __construct(DataRepositoryInterface $dataRepository)
    {
        $this->dataRepository = $dataRepository; ///////repository pattern
    }

    public function getFareModality()
    {
        $getRoads = $this->dataRepository->getRoads();/////get all routes
        if(count($getRoads)>0){
            $stoppageSequence = json_decode($getRoads[0]->stoppage_sequence);///////currently there is only one route
            $allDetailsArray = array();
            $routeWithFareDetails = array();
            for ($i=0;$i<count($stoppageSequence);$i++){
                $stoppageFrom = $stoppageSequence[$i];
                $stoppageFromName = $this->dataRepository->getStoppage($stoppageFrom);/////get start destination name
                $routeArray = array();
                for ($j=$i+1;$j<count($stoppageSequence);$j++){
                    $route = array();
                    $stoppageTo = $stoppageSequence[$j];
                    $stoppageToName = $this->dataRepository->getStoppage($stoppageTo); ////get end destination name
                    $getFare = $this->dataRepository->getFare($stoppageFrom,$stoppageTo);///get fare bt start and end destination
                    if($getFare!= 0) {
                        $route["to_stoppage"] = $stoppageToName;
                        $route["fare"] = $getFare;

                        array_push($routeArray, $route);//store it in an array
                    }
                }
                if(count($routeArray)>0){
                    $routeWithFareDetails["from_stoppage"] = $stoppageFromName;
                    $routeWithFareDetails["to_stoppages"] = $routeArray;

                    array_push($allDetailsArray,$routeWithFareDetails);////store it in array by start stoppage
                }
            }
            return response($allDetailsArray,200);
        }
    }

}
