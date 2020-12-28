<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class CustomerRepository
{

    /**
     * @var \Illuminate\Database\Query\Builder $customer
     */
    protected $customer;

    /**
     * Member Repository constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->customer = DB::table('customer', 'C');
    }
}
?>
