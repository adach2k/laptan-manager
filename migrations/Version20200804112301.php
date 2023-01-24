<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200804112301 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE care (id INT AUTO_INCREMENT NOT NULL, hospitalization_id INT NOT NULL, type_care_id INT NOT NULL, INDEX IDX_6113A8455992429E (hospitalization_id), INDEX IDX_6113A845DA5192B0 (type_care_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hospitalization (id INT AUTO_INCREMENT NOT NULL, patient_id INT NOT NULL, date_entree DATETIME NOT NULL, date_sortie DATETIME NOT NULL, INDEX IDX_40CF08916B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_care (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE care ADD CONSTRAINT FK_6113A8455992429E FOREIGN KEY (hospitalization_id) REFERENCES hospitalization (id)');
        $this->addSql('ALTER TABLE care ADD CONSTRAINT FK_6113A845DA5192B0 FOREIGN KEY (type_care_id) REFERENCES type_care (id)');
        $this->addSql('ALTER TABLE hospitalization ADD CONSTRAINT FK_40CF08916B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE care DROP FOREIGN KEY FK_6113A8455992429E');
        $this->addSql('ALTER TABLE care DROP FOREIGN KEY FK_6113A845DA5192B0');
        $this->addSql('DROP TABLE care');
        $this->addSql('DROP TABLE hospitalization');
        $this->addSql('DROP TABLE type_care');
    }
}
