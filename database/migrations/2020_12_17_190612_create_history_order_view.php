<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateHistoryOrderView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // DB::statement('CREATE VIEW seller_card_view AS (
        //     SELECT S.member_id, M.name, S.header_image, SCL.category_id as category_id
        //     FROM seller as S, member as M, seller_category_list as SCL
        //     WHERE S.member_id = M.id
        //     AND S.member_id = SCL.seller_id
        //     ORDER BY S.member_id)'
        // );
        DB::statement('CREATE VIEW history_order_view AS (
            select * FROM
            (SELECT M.id, O.customer_id, M.name, O.order_time, O.stars
            FROM "order" as O, member as M
            WHERE O.seller_id = M.id
            ) as G);'
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS history_order_view');
    }
}
