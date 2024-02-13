<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240212105507 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product (id INT NOT NULL, category_name VARCHAR(255) DEFAULT NULL, sku VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, shortdesc LONGTEXT DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, link VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, brand VARCHAR(255) DEFAULT NULL, rating DOUBLE PRECISION DEFAULT NULL, caffeine_type VARCHAR(255) DEFAULT NULL, count SMALLINT DEFAULT NULL, flavored TINYINT(1) DEFAULT NULL, seasonal TINYINT(1) DEFAULT NULL, instock TINYINT(1) DEFAULT NULL, facebook SMALLINT DEFAULT NULL, is_kcup SMALLINT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE product');
    }
}
