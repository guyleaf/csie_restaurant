<?php
namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\ShopRepository;
use InvalidArgumentException;

class SearchService
{
    /**
     * @var \App\Repositories\ShopRepository $shopRepository
     */
    protected $shopRepository;

    /**
     * Shop service constructor
     *
     * @param \App\Repositories\ShopRepository $shopRepository
     */
    public function __construct(ShopRepository $shopRepository)
    {
        $this->shopRepository = $shopRepository;
    }

    /**
     * Validate basic arguments ex.currentNumber
     *
     * @param array $args
     * @return void
     */
    protected function validateBasicArgument($args)
    {
        $validator = Validator::make($args, [
            'currentNumber' => 'required|integer|min:0',
            'requiredNumber' => 'required|integer|min:0|max:50'
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException(serialize($validator->errors()), 400);
        }
    }

    /**
     * Validate shop filters
     *
     * @param array $filters
     * @return void
     */
    protected function validateFilters($filters)
    {
        $validator = Validator::make(['filters' => $filters], [
            'filters' => 'bail|required|array|min:0',
            'filters.*' => 'required|integer|min:0'
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException(serialize($validator->errors()), 400);
        }
    }

    protected function validateId($id)
    {
        $validator = Validator::make(['filters' => $filters], [
            'filters' => 'bail|required|array|min:0',
            'filters.*' => 'required|integer|min:0'
        ]);
        if ($validator->fails()) {
            throw new InvalidArgumentException(serialize($validator->errors()), 400);
        }
    }

    protected function filterNull($data, $value)
    {
        $data = $data->map(function ($item, $key) use ($value) {
            $item->numberofratings = $item->numberofratings == NULL ? $value : (double)$item->numberofratings;
            $item->averageofratings = $item->averageofratings == NULL ? $value : (double)$item->averageofratings;
            return $item;
        });

        return $data;
    }

    /**
     * Get a part of shops via database
     *
     * @param array $numbers
     * @return \Illuminate\Support\Collection
     */
    public function getShops($numbers)
    {
        $this->validateBasicArgument($numbers);

        $currentNumber = (int)$numbers['currentNumber'];
        $requiredNumber = (int)$numbers['requiredNumber'];

        $result = $this->shopRepository
            ->getShops($currentNumber, $requiredNumber);

        return $this->filterNull($result, 0);
    }

    /**
     * Get a part of filtered shops via database
     *
     * @param array:integer $numbers
     * @param array:id $filters
     * @return \Illuminate\Support\Collection
     */
    public function getShopsByfilters($numbers, $filters)
    {
        $this->validateBasicArgument($numbers);
        $this->validateFilters($filters);

        $currentNumber = (int)$numbers['currentNumber'];
        $requiredNumber = (int)$numbers['requiredNumber'];

        $result = $this->shopRepository
            ->getShopsByfilters($currentNumber, $requiredNumber, $filters);
        return $this->filterNull($result, 0);
    }

    public function searchShops($keywords)
    {
        $result = $this->shopRepository
        ->searchShops($keywords);

        return $result;
    }

    public function getCategories()
    {
        $result = $this->shopRepository
            ->getCategories();
        return $result;
    }
}
?>
