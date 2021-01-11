<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MemberService;
use Exception;

class AdminController extends Controller
{
    /**
     * @var \App\Services\MemberService $memberService
     */
    protected $memberService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MemberService $memberService)
    {
        $this->memberService = $memberService;
    }

    /**
     * Get a part of shops via database
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function getCustomers(Request $request)
    {
        try {
            $result = $this->memberService->getCustomers($request->query());
        } catch (Exception $e) {
            return response()->json([
                'status' => $e->getCode(),
                'messages' => unserialize($e->getMessage())
            ], $e->getCode());
        }

        return response()->json(['numbers' => $result[0],'customers' => $result[1]]);
    }

    public function getSellers(Request $request)
    {
        try {
            $result = $this->memberService->getSellers($request->query());
        } catch (Exception $e) {
            return response()->json([
                'status' => $e->getCode(),
                'messages' => unserialize($e->getMessage())
            ], $e->getCode());
        }

        return response()->json(['numbers' => $result[0],'sellers' => $result[1]]);
    }

    public function updateMember(Request $request)
    {
        // $user = auth()->userOrFail();
        // $id = $user->id;
        $this->memberService->updateMember($request->all());
        return response()->json(['message' => 'Success']);
    }

    public function deleteMember(Request $request)
    {
        $this->memberService->deleteMember($request->input('id'));
        return response()->json(['message' => 'Success']);
    }

    public function addMember(Request $request)
    {
        // $this->memberService->addMember($request->all());
        var_dump($request->all());
        return response()->json(['message' => 'Success'], 201);
    }
}
