<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230220143317 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE command (id INT AUTO_INCREMENT NOT NULL, price DOUBLE PRECISION NOT NULL, quantity INT NOT NULL, total DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE command_product (command_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_3C20574E33E1689A (command_id), INDEX IDX_3C20574E4584665A (product_id), PRIMARY KEY(command_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE continents (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE countries (id INT AUTO_INCREMENT NOT NULL, continentid_id INT NOT NULL, name VARCHAR(255) NOT NULL, population INT NOT NULL, capital VARCHAR(255) NOT NULL, monney VARCHAR(255) NOT NULL, INDEX IDX_5D66EBAD5418884F (continentid_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, produit_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_C53D045FF347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oras (id INT AUTO_INCREMENT NOT NULL, tara_id INT NOT NULL, name VARCHAR(255) NOT NULL, populatie INT NOT NULL, imagine VARBINARY(255) DEFAULT NULL, INDEX IDX_A09EFE17DF6BC852 (tara_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pays (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, image VARBINARY(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tara (id INT AUTO_INCREMENT NOT NULL, nume VARCHAR(255) NOT NULL, imagine VARBINARY(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vacance (id INT AUTO_INCREMENT NOT NULL, pays_id INT NOT NULL, name VARCHAR(255) NOT NULL, prix INT NOT NULL, description VARCHAR(255) DEFAULT NULL, INDEX IDX_BD3530F2A6E44244 (pays_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE command_product ADD CONSTRAINT FK_3C20574E33E1689A FOREIGN KEY (command_id) REFERENCES command (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE command_product ADD CONSTRAINT FK_3C20574E4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE countries ADD CONSTRAINT FK_5D66EBAD5418884F FOREIGN KEY (continentid_id) REFERENCES continents (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE oras ADD CONSTRAINT FK_A09EFE17DF6BC852 FOREIGN KEY (tara_id) REFERENCES tara (id)');
        $this->addSql('ALTER TABLE vacance ADD CONSTRAINT FK_BD3530F2A6E44244 FOREIGN KEY (pays_id) REFERENCES vacance (id)');
        $this->addSql('DROP TABLE `order`');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, status VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, update_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE command_product DROP FOREIGN KEY FK_3C20574E33E1689A');
        $this->addSql('ALTER TABLE command_product DROP FOREIGN KEY FK_3C20574E4584665A');
        $this->addSql('ALTER TABLE countries DROP FOREIGN KEY FK_5D66EBAD5418884F');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FF347EFB');
        $this->addSql('ALTER TABLE oras DROP FOREIGN KEY FK_A09EFE17DF6BC852');
        $this->addSql('ALTER TABLE vacance DROP FOREIGN KEY FK_BD3530F2A6E44244');
        $this->addSql('DROP TABLE command');
        $this->addSql('DROP TABLE command_product');
        $this->addSql('DROP TABLE continents');
        $this->addSql('DROP TABLE countries');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE oras');
        $this->addSql('DROP TABLE pays');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE tara');
        $this->addSql('DROP TABLE vacance');
    }
}
