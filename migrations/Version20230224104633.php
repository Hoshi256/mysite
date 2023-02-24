<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230224104633 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, product_id INT NOT NULL, date_in DATETIME NOT NULL, date_out DATETIME NOT NULL, price DOUBLE PRECISION NOT NULL, nb_person INT NOT NULL, INDEX IDX_E00CEDDEA76ED395 (user_id), INDEX IDX_E00CEDDE4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE continents (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE countries (id INT AUTO_INCREMENT NOT NULL, continentid_id INT NOT NULL, name VARCHAR(255) NOT NULL, population INT NOT NULL, capital VARCHAR(255) NOT NULL, monney VARCHAR(255) NOT NULL, INDEX IDX_5D66EBAD5418884F (continentid_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, produit_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_C53D045FF347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oras (id INT AUTO_INCREMENT NOT NULL, tara_id INT NOT NULL, name VARCHAR(255) NOT NULL, populatie INT NOT NULL, imagine VARBINARY(255) DEFAULT NULL, INDEX IDX_A09EFE17DF6BC852 (tara_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pays (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, image VARBINARY(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tara (id INT AUTO_INCREMENT NOT NULL, nume VARCHAR(255) NOT NULL, imagine VARBINARY(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vacance (id INT AUTO_INCREMENT NOT NULL, pays_id INT NOT NULL, name VARCHAR(255) NOT NULL, prix INT NOT NULL, description VARCHAR(255) DEFAULT NULL, INDEX IDX_BD3530F2A6E44244 (pays_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE countries ADD CONSTRAINT FK_5D66EBAD5418884F FOREIGN KEY (continentid_id) REFERENCES continents (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE oras ADD CONSTRAINT FK_A09EFE17DF6BC852 FOREIGN KEY (tara_id) REFERENCES tara (id)');
        $this->addSql('ALTER TABLE vacance ADD CONSTRAINT FK_BD3530F2A6E44244 FOREIGN KEY (pays_id) REFERENCES vacance (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEA76ED395');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE4584665A');
        $this->addSql('ALTER TABLE countries DROP FOREIGN KEY FK_5D66EBAD5418884F');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FF347EFB');
        $this->addSql('ALTER TABLE oras DROP FOREIGN KEY FK_A09EFE17DF6BC852');
        $this->addSql('ALTER TABLE vacance DROP FOREIGN KEY FK_BD3530F2A6E44244');
        $this->addSql('DROP TABLE booking');
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
