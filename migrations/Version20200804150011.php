<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200804150011 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bed (id INT AUTO_INCREMENT NOT NULL, bedroom_id INT DEFAULT NULL, numero INT NOT NULL, disponible TINYINT(1) NOT NULL, INDEX IDX_E647FCFFBDB6797C (bedroom_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bedroom (id INT AUTO_INCREMENT NOT NULL, building_id INT NOT NULL, numero VARCHAR(255) NOT NULL, INDEX IDX_E61543514D2A7E12 (building_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE building (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bed ADD CONSTRAINT FK_E647FCFFBDB6797C FOREIGN KEY (bedroom_id) REFERENCES bedroom (id)');
        $this->addSql('ALTER TABLE bedroom ADD CONSTRAINT FK_E61543514D2A7E12 FOREIGN KEY (building_id) REFERENCES building (id)');
        $this->addSql('ALTER TABLE hospitalization ADD bed_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE hospitalization ADD CONSTRAINT FK_40CF089188688BB9 FOREIGN KEY (bed_id) REFERENCES bed (id)');
        $this->addSql('CREATE INDEX IDX_40CF089188688BB9 ON hospitalization (bed_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hospitalization DROP FOREIGN KEY FK_40CF089188688BB9');
        $this->addSql('ALTER TABLE bed DROP FOREIGN KEY FK_E647FCFFBDB6797C');
        $this->addSql('ALTER TABLE bedroom DROP FOREIGN KEY FK_E61543514D2A7E12');
        $this->addSql('DROP TABLE bed');
        $this->addSql('DROP TABLE bedroom');
        $this->addSql('DROP TABLE building');
        $this->addSql('DROP INDEX IDX_40CF089188688BB9 ON hospitalization');
        $this->addSql('ALTER TABLE hospitalization DROP bed_id');
    }
}
