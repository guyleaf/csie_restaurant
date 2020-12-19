<?php
namespace App\Services;

use App\Models\Member;

class AuthService
{
    /**
     * @param App\Models\Member $member
     */
    protected $member;

    /**
     * Constructor
     *
     * @param App\Models\Member $member
     *
     * @return void
     */
    public function __construct(Member $member)
    {
        $this->member = $member;
    }
}
?>
