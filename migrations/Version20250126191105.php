<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250126191105 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create product table with basic information';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE product (
          gtin BIGINT NOT NULL,
          brands VARCHAR(255) DEFAULT NULL,
          name VARCHAR(255) NOT NULL,
          PRIMARY KEY(gtin)
        ) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE product');
    }
}
