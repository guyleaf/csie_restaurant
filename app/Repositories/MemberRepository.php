<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use DateTime, DateTimeZone, Exception;


class MemberRepository
{
    /**
     * @var \Illuminate\Database\Query\Builder $memberTable
     */
    protected $memberTable;

    /**
     * @var \Illuminate\Database\Query\Builder $memberTable
     */
    protected $customerTable;

    /**
     * Member Repository constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->memberTable = DB::table('member');
        $this->customerTable = DB::table('customer');
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

    public function addMember($payload)
    {
        DB::beginTransaction();

        try
        {
            $payload['member']['created_at'] = new DateTime('now', new DateTimeZone('Asia/Taipei'));
            $payload['member']['created_at'] = $payload['member']['created_at']->format('Y-m-d H:i:s');
            $payload['member']['updated_at'] = $payload['member']['created_at'];

            $id = $this->memberTable
            ->orderByDesc('id')
            ->limit(1)
            ->lockForUpdate()
            ->get(['id'])->first()->id + 1;

            $payload['member']['id'] = $id;
            $payload['customer']['id'] = $id;

            $this->memberTable
            ->insert($payload['member']);

            $this->customerTable
            ->insert($payload['customer']);

            DB::commit();
        }
        catch (Exception $e)
        {
            DB::rollBack();
            throw $e;
        }

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
