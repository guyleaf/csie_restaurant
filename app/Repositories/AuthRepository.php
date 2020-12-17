<?php
    namespace App\Repositories;

    use Illuminate\Support\Facades\DB;

    class AuthRepository
    {
        function __construct()
        {
            $member = DB::table('member');
        }

    }
?>
