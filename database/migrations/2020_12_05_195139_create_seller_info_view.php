<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateSellerInfoView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE VIEW seller_info_view AS (
            select * FROM
            (SELECT S.member_id, M.name, S.header_image, counter_number
            FROM seller as S, member as M
            WHERE S.member_id = M.id
            ORDER BY S.member_id) as S
            left JOIN
            (SELECT seller_id, COUNT(*) as numberOfRatings, AVG(stars) as averageOfRatings
            FROM "order"
            GROUP BY seller_id) as R
            on S.member_id = R.seller_id
            left JOIN
            (SELECT seller_id as seller_id_2, COUNT(*) as numberOfFans
            FROM "customer_favorite"
            GROUP BY seller_id) as CF
            on S.member_id = CF.seller_id_2);'
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS seller_info_view');
    }
}
