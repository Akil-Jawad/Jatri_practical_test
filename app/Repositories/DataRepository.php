<?php


namespace App\Repositories;

class DataRepository implements DataRepositoryInterface
{

    public function getRoads()
    {
        // TODO: Implement getRoads() method.
        return \DB::table('test_db.roads')
            ->selectRaw("test_db.roads.*")
            ->get();
    }

    public function getFare($from, $to)
    {
        // TODO: Implement getFare() method.
        $getFare = \DB::table('test_db.fares')
            ->select("test_db.fares.fare")
            ->where("from_stoppage_id","=",$from)
            ->where("to_stoppage_id","=",$to)
            ->get();
        if(count($getFare)>0){
            return $getFare[0]->fare;
        }else{
            return 0;
        }
    }

    public function getStoppage($stoppage_id)
    {
        // TODO: Implement getStoppage() method.
        $getStoppage = \DB::table('test_db.stoppages')
            ->select("test_db.stoppages.name")
            ->where("id","=",$stoppage_id)
            ->get();
        return $getStoppage[0]->name;
    }
}
