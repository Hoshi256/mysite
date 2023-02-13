<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230210093318 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oras ADD tara_id INT NOT NULL');
        $this->addSql('ALTER TABLE oras ADD CONSTRAINT FK_A09EFE17DF6BC852 FOREIGN KEY (tara_id) REFERENCES tara (id)');
        $this->addSql('CREATE INDEX IDX_A09EFE17DF6BC852 ON oras (tara_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oras DROP FOREIGN KEY FK_A09EFE17DF6BC852');
        $this->addSql('DROP INDEX IDX_A09EFE17DF6BC852 ON oras');
        $this->addSql('ALTER TABLE oras DROP tara_id');
    }
}
