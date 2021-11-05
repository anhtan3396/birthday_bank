<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\TestRepository;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class RankingController extends Controller
{
    public function topOfMonth(TestRepository $testRepository)
    {
        $type = 'm';
        $tops = $testRepository->getPointAnswers($type);
        $pos = 1;

        $new_array = array();
        foreach ($tops as $data_object) {
            $data_array = get_object_vars($data_object);
            $data_array['rank'] = $pos;
            $new_array[] = $data_array;
            $pos++;
        }

        //Get current page form url e.g. &page=6
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        //Create a new Laravel collection from the array data
        $collection = new Collection($new_array);
        //Define how many items we want to be visible in each page
        $perPage = 20;
        //Slice the collection to get the items to display in current page
        $currentPageSearchResults = $collection->slice(($currentPage-1) * $perPage, $perPage)->all();
        //Create our paginator and pass it to the view
        $paginatedSearchResults= new LengthAwarePaginator($currentPageSearchResults, count($collection), $perPage);
        //return view
        return view('Backend.ranking.topOfMonth',['listTops' => $paginatedSearchResults]);
    }

    public function topOfQuarterOfTheYear(TestRepository $testRepository)
    {
        $type = "q";
        $tops = $testRepository->getPointAnswers($type);
        $pos = 1;
        $new_array = array();
        foreach ($tops as $data_object) {
            $data_array = get_object_vars($data_object);
            $data_array['Rank'] = $pos;
            $new_array[] = $data_array;
            $pos++;
            }
        //Get current page form url e.g. &page=6
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        //Create a new Laravel collection from the array data
        $collection = new Collection($new_array);
        //Define how many items we want to be visible in each page
        $perPage = 20;
        //Slice the collection to get the items to display in current page
        $currentPageSearchResults = $collection->slice(($currentPage-1) * $perPage, $perPage)->all();
        //Create our paginator and pass it to the view
        $paginatedSearchResults= new LengthAwarePaginator($currentPageSearchResults, count($collection), $perPage);
        //return view    
        return view('Backend.ranking.topOfQuarterOfTheYear',['listTops' => $paginatedSearchResults]);
    }

    public function topOfYear(TestRepository $testRepository)
    {
        $type = "y";
        $tops = $testRepository->getPointAnswers($type);
        $pos = 1;
        $new_array = array();
        foreach ($tops as $data_object) {
            $data_array = get_object_vars($data_object);
            $data_array['Rank'] = $pos;
            $new_array[] = $data_array;
            $pos++;
            }
            //Get current page form url e.g. &page=6
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        //Create a new Laravel collection from the array data
        $collection = new Collection($new_array);
        //Define how many items we want to be visible in each page
        $perPage = 20;
        //Slice the collection to get the items to display in current page
        $currentPageSearchResults = $collection->slice(($currentPage-1) * $perPage, $perPage)->all();
        //Create our paginator and pass it to the view
        $paginatedSearchResults= new LengthAwarePaginator($currentPageSearchResults, count($collection), $perPage);
        //return view  
        return view('Backend.ranking.topOfYear',['listTops' => $paginatedSearchResults]);
    }
}
