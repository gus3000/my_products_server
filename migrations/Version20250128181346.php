<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250128181346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create join table between users and their owned products';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE xuser_product (
          id INT AUTO_INCREMENT NOT NULL,
          user_id INT NOT NULL,
          product_id BIGINT NOT NULL,
          INDEX IDX_1F1135A3A76ED395 (user_id),
          INDEX IDX_1F1135A34584665A (product_id),
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE
          xuser_product
        ADD
          CONSTRAINT FK_1F1135A3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE
          xuser_product
        ADD
          CONSTRAINT FK_1F1135A34584665A FOREIGN KEY (product_id) REFERENCES product (gtin)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE xuser_product DROP FOREIGN KEY FK_1F1135A3A76ED395');
        $this->addSql('ALTER TABLE xuser_product DROP FOREIGN KEY FK_1F1135A34584665A');
        $this->addSql('DROP TABLE xuser_product');
    }
}
