<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230225153920 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE target_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE target (id INT NOT NULL, signal_futur_id INT DEFAULT NULL, signal_spot_id INT DEFAULT NULL, value DOUBLE PRECISION NOT NULL, percent DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_466F2FFCF6938107 ON target (signal_futur_id)');
        $this->addSql('CREATE INDEX IDX_466F2FFC2852F7C0 ON target (signal_spot_id)');
        $this->addSql('ALTER TABLE target ADD CONSTRAINT FK_466F2FFCF6938107 FOREIGN KEY (signal_futur_id) REFERENCES signal_futur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE target ADD CONSTRAINT FK_466F2FFC2852F7C0 FOREIGN KEY (signal_spot_id) REFERENCES signal_spot (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE target_id_seq CASCADE');
        $this->addSql('ALTER TABLE target DROP CONSTRAINT FK_466F2FFCF6938107');
        $this->addSql('ALTER TABLE target DROP CONSTRAINT FK_466F2FFC2852F7C0');
        $this->addSql('DROP TABLE target');
    }
}
