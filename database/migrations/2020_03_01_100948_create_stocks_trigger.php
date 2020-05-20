<?php

use Illuminate\Database\Migrations\Migration;

class CreateStocksTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE OR REPLACE FUNCTION manage_stock_balances()
                RETURNS trigger AS
            $BODY$
            BEGIN
                INSERT INTO tbl_stock_balance (batch_number, expiry_date, quantity, product_id, organization_id, created_at) 
                VALUES (NEW.batch_number, NEW.expiry_date, NEW.balance, NEW.product_id, NEW.organization_id, NOW())
                ON CONFLICT (batch_number, expiry_date, product_id, organization_id) 
                DO UPDATE SET quantity = NEW.balance, updated_at = NOW();

                RETURN NEW;
            END;
            $BODY$
            LANGUAGE plpgsql;
        ');

        DB::unprepared('
            DROP TRIGGER IF EXISTS trig_stocks_insert ON tbl_stock;
            CREATE TRIGGER trig_stocks_insert AFTER INSERT ON tbl_stock FOR EACH ROW
                EXECUTE PROCEDURE manage_stock_balances();
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {   
        DB::unprepared('DROP TRIGGER IF EXISTS trig_stocks_insert ON tbl_stock');
        DB::unprepared('DROP FUNCTION IF EXISTS manage_stock_balances');
    }
}
