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
     * @var \Illuminate\Database\Query\Builder $customerTable
     */
    protected $customerTable;

    /**
     * @var \Illuminate\Database\Query\Builder $sellerTable
     */
    protected $sellerTable;

    /**
     * Member Repository constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->memberTable = DB::table('member');
        $this->customerTable = DB::table('customer');
        $this->sellerTable = DB::table('seller');
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

    public function addMember($payload)
    {
        DB::beginTransaction();

        try
        {
            $payload['created_at'] = new DateTime('now', new DateTimeZone('Asia/Taipei'));
            $payload['created_at'] = $payload['created_at']->format('Y-m-d H:i:s');
            $payload['updated_at'] = $payload['created_at'];

            $id = $this->memberTable
            ->orderByDesc('id')
            ->limit(1)
            ->lockForUpdate()
            ->get(['id'])->first()->id + 1;

            $payload['id'] = $id;

            $this->memberTable
            ->insert($payload);

            return $id

            DB::commit();
        }
        catch (Exception $e)
        {
            DB::rollBack();
            throw $e;
        }

    }

    public function addCustomer($payload, $member_id)
    {
        DB::beginTransaction();

        try
        {
            $payload['member_id'] = $member_id;

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

    public function addSeller($payload, $member_id, $image_extension)
    {
        DB::beginTransaction();

        try
        {
            $counter_number = $this->sellerTable
            ->orderByDesc('counter_number')
            ->limit(1)
            ->lockForUpdate()
            ->get(['counter_number'])->first()->counter_number + 1;

            $payload['member_id'] = $member_id;
            $payload['counter_number'] = $counter_number;
            $payload['header_image'] = '/storage/restaurant/' . strval($id) . '/' . 'header' . '.' . $image_extension

            $this->sellerTable
            ->insert($payload);

            return $id

            DB::commit();
        }
        catch (Exception $e)
        {
            DB::rollBack();
            throw $e;
        }

    }
}
?>
