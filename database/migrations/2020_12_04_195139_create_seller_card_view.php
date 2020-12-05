<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateSellerCardView extends Migration
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
        DB::statement('CREATE VIEW seller_card_view AS (
            select * FROM
            (SELECT S.member_id, M.name, S.header_image, counter_number
            FROM seller as S, member as M
            WHERE S.member_id = M.id
            ORDER BY S.member_id) as S
            left JOIN
            (SELECT seller_id, COUNT(*) as numberOfRatings, AVG(stars) as averageOfRatings
            FROM customer_rating
            GROUP BY seller_id) as R
            on S.member_id = R.seller_id);'
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS seller_card_view');
    }
}
