<?php


use Phinx\Migration\AbstractMigration;

class CreateMerchantOwnerTable extends AbstractMigration
{
    /**
    * Migrate Up.
    */
    public function up()
    {
        $merchant_owners = $this->table('merchant_owners');
        $merchant_owners->addColumn('name', 'string')
            ->addColumn('identity_type', 'enum', ['values' => ['NONE','KTP', 'SIM']])
            ->addColumn('identity_number', 'string')
            ->addColumn('phone', 'string')
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {

    }
}
