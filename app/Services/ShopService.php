<?php
namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\ShopRepository;

class ShopService
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
     * Get a part of shops via database
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getShops(Request $request)
    {
        $validator = Validator::make($request->query(), [
            'currentNumber' => 'required|integer|min:0',
            'requiredNumber' => 'required|integer|min:0|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 400);
        }

        $currentNumber = (int)$request->get('currentNumber');
        $requiredNumber = (int)$request->get('requiredNumber');

        $result = $this->shopRepository->getShops($currentNumber, $requiredNumber);
        return response()->json($result);
    }
}
?>
