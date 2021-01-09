<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class MemberRepository
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
            ->get(['id as seller_id', 'name', 'username', 'email', 'created_at', 'phone', 'member_status', ]);

        return $members;
    }

    public function updateMember($payload)
    {
        $now = new DateTime('now', new DateTimeZone('Asia/Taipei'));
        $payload['updated_at'] = $now->format('Y-m-d H:i:s');

        $this->memberTable
        ->where('id', '=', $payload['id'])
        ->update($payload);
    }

    public function deleteMember($id)
    {
        $this->memberTable
        ->where('id', '=', $id)
        ->delete();
    }
}
?>
