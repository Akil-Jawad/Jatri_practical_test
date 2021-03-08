<?php
namespace App\Repositories;

interface DataRepositoryInterface{
    public function getRoads();
    public function getFare($from,$to);
    public function getStoppage($stoppage_id);
}
