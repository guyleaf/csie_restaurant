<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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

    public function getCustomers($currentNumber, $requiredNumber)
    {
        
        $customers = $this->memberTable
            ->join('customer as C', 'C.member_id', '=', 'id')
            ->where('is_deleted', '=', false)
            ->orderBy('id')
            ->skip($currentNumber)
            ->take($requiredNumber)
            ->get(['id as customer_id', 'name', 'username', 'created_at','email', 'phone', 'member_status']);

        $this->memberTable = DB::table('member');
        $numbers = $this->memberTable
        ->join('customer as C', 'C.member_id', '=', 'id')
        ->where('is_deleted', '=', false)
        ->count();
        
        return [$numbers, $customers];
    }

    public function getSellers($currentNumber, $requiredNumber)
    {

        $sellers = $this->memberTable
            ->join('seller as S', 'S.member_id', '=', 'id')
            ->where('is_deleted', '=', false)
            ->orderBy('id')
            ->skip($currentNumber)
            ->take($requiredNumber)
            ->get(['id as seller_id', 'name', 'username', 'email', 'created_at', 'phone', 'member_status', 'counter_number']);

        $this->memberTable = DB::table('member');
        $numbers =$this->memberTable
        ->join('seller as S', 'S.member_id', '=', 'id')
        ->where('is_deleted', '=', false)
        ->count();

        return [$numbers, $sellers];
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
        $now = new DateTime('now', new DateTimeZone('Asia/Taipei'));
        $this->memberTable
        ->where('id', '=', $id)
        ->update(['is_deleted' => true, 'updated_at' => $now->format('Y-m-d H:i:s')]);
    }

    private function addMember($payload)
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
        $payload['password'] = Hash::make($payload['password']);
        $this->memberTable = DB::table('member');
        $this->memberTable
        ->insert($payload);

        return $id;
    }

    public function addCustomer($payload)
    {
        DB::beginTransaction();

        try
        {
            $member_id = $this->addMember($payload['member']);

            $payload['customer']['member_id'] = $member_id;

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

    public function addSeller($payload)
    {
        DB::beginTransaction();

        try
        {
            $member_id = $this->addMember($payload['member']);

            $payload['seller']['member_id'] = $member_id;

            if ($payload['seller']['header_image'])
                $payload['seller']['header_image'] = '/storage/restaurant/' . strval($member_id) . '/header.jpg';
            else
                $payload['seller']['header_image'] = '/storage/restaurant/' . 'default_header.jpg';
            
            $counter = $this->sellerTable
            ->where('counter_number', '=', $payload['seller']['counter_number'])
            ->count();

            if ($counter != 0)
                throw 'Counter number exists';

            $this->sellerTable = DB::table('seller');
            $this->sellerTable
            ->insert($payload['seller']);

            DB::commit();
        }
        catch (Exception $e)
        {
            DB::rollBack();
            throw $e;
        }

        return $member_id;
    }
}
?>
