<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250105133546 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product (
          id INT AUTO_INCREMENT NOT NULL,
          gtin INT NOT NULL,
          brand VARCHAR(255) DEFAULT NULL,
          model VARCHAR(255) DEFAULT NULL,
          name VARCHAR(255) NOT NULL,
          last_updated VARCHAR(255) DEFAULT NULL,
          gs1_country VARCHAR(255) DEFAULT NULL,
          gtin_type VARCHAR(255) DEFAULT NULL,
          offers_count VARCHAR(255) DEFAULT NULL,
          min_price VARCHAR(255) DEFAULT NULL,
          min_price_compensation VARCHAR(255) DEFAULT NULL,
          currency VARCHAR(255) DEFAULT NULL,
          categories VARCHAR(255) DEFAULT NULL,
          url VARCHAR(255) DEFAULT NULL,
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER
        SET
          utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE product');
    }
}
