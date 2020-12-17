<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class MemverRepository
{
    /**
     * @var \Illuminate\Database\Query\Builder $memberTable
     */
    protected $memberTable;

    /**
     * Member Repository constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->memberTable = DB::table('member');
    }
    /**
     * Get shops
     *
     * @param integer $currentNumber
     * @param integer $requiredNumber
     * @return \Illuminate\Support\Collection
     */
    public function getMembers($currentNumber, $requiredNumber)
    {
        $members = $this->memberTable
            ->skip($currentNumber)
            ->take($requiredNumber)
            ->get(['member_id as seller_id', 'name', 'username', 'email', 'created_at', 'phone', 'member_status', ]);

        return $members;
    }
}
?>
