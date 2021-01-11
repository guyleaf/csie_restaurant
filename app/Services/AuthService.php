<?php
namespace App\Services;

use App\Models\Member;
use App\Repositories\MemberRepository;

class AuthService
{
    /**
     * @param App\Models\MemberRepository $memberRepository
     */
    protected $memberRepository;

    /**
     * Constructor
     *
     * @param App\Models\MemberRepository $memberRepository
     *
     * @return void
     */
    public function __construct(MemberRepository $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }

    public function register($payload)
    {
        $this->memberRepository
        ->addCustomer($payload);
    }
}
?>
