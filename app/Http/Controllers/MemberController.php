<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MemberService;
use Exception;

class MemberController extends Controller
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
    public function getMembers(Request $request)
    {
        try {
            $result = $this->memberService->getMembers($request->query());
        } catch (Exception $e) {
            return response()->json([
                'status' => $e->getCode(),
                'messages' => unserialize($e->getMessage())
            ], $e->getCode());
        }

        return response()->json($result);
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

    public function addCustomer(Request $request)
    {
        $this->memberService->addCustomer($request->all());
        return response()->json(['message' => 'Success'], 201);
    }

    public function addSeller(Request $request)
    {
        $this->memberService->addSeller($request->all());
        return response()->json(['message' => 'Success'], 201);
    }
}
