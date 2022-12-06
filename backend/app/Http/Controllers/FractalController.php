<?php


namespace App\Http\Controllers;


use App\Helpers\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;

class FractalController extends Controller
{
    /**
     * @var Transformer
     */
    private $transformer;

    /**
     * @var Manager
     */
    private $fractal;
    public $request;


    function __construct($transformer, Request $request)
    {
        $this->fractal = new \League\Fractal\Manager;
        $this->transformer = $transformer;
        $this->request = $request;
        parent::__construct();
    }

    public function PaginatedResponse($paginator, $transformer = null)
    {
        $result = new Collection($paginator->items(), ($transformer) ? $transformer : $this->transformer);
        $result->setPaginator(new IlluminatePaginatorAdapter($paginator));

        $result = $this->fractal->createData($result); // Transform data

        return $result->toArray(); // Get transformed array of data
    }

    public function SimpleResponse($list, $transformer = null)
    {
        $list = new Collection($list, ($transformer) ? $transformer : $this->transformer); // Create a resource collection transformer
        $list = $this->fractal->createData($list); // Transform data

        return $list->toArray();
    }

    public function SingleResponse($model, $transformer = null)
    {
        return [
            'data' => (($transformer) ? $transformer : $this->transformer)->transform($model),
            'errors' => $this->formatValidationErrors()
        ];
    }

}