<?php

declare(strict_types=1);

namespace Shopsys\ShopBundle\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Shopsys\MigrationBundle\Component\Doctrine\Migrations\AbstractMigration;

class Version20190903175607 extends AbstractMigration
{
    /**
     * @param \Doctrine\DBAL\Schema\Schema $schema
     */
    public function up(Schema $schema): void
    {
        $this->sql('ALTER TABLE promo_codes ADD currency_id INT NOT NULL');
        $this->sql('ALTER TABLE promo_codes ADD customer_id INT DEFAULT NULL');
        $this->sql('ALTER TABLE promo_codes ADD price NUMERIC(20, 6) DEFAULT NULL');
        $this->sql('ALTER TABLE promo_codes ADD domain INT NOT NULL');
        $this->sql('ALTER TABLE promo_codes ADD is_transport BOOLEAN NOT NULL');
        $this->sql('ALTER TABLE promo_codes ADD repeats_left INT DEFAULT NULL');
        $this->sql('COMMENT ON COLUMN promo_codes.price IS \'(DC2Type:money)\'');
        $this->sql('
            ALTER TABLE
                promo_codes
            ADD
                CONSTRAINT FK_C84FDDB38248176 FOREIGN KEY (currency_id) REFERENCES currencies (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->sql('
            ALTER TABLE
                promo_codes
            ADD
                CONSTRAINT FK_C84FDDB9395C3F3 FOREIGN KEY (customer_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->sql('CREATE INDEX IDX_C84FDDB38248176 ON promo_codes (currency_id)');
        $this->sql('CREATE INDEX IDX_C84FDDB9395C3F3 ON promo_codes (customer_id)');
    }

    /**
     * @param \Doctrine\DBAL\Schema\Schema $schema
     */
    public function down(Schema $schema): void
    {
    }
}
