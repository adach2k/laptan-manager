<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200807132159 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE facture (id INT AUTO_INCREMENT NOT NULL, numero VARCHAR(255) NOT NULL, montant_total INT NOT NULL, UNIQUE INDEX UNIQ_FE866410F55AE19E (numero), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reglement (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, montant_paye INT NOT NULL, montant_restant INT NOT NULL, etat TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE care ADD facture_id INT NULL, ADD montant INT NOT NULL');
        $this->addSql('ALTER TABLE care ADD CONSTRAINT FK_6113A8457F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id)');
        $this->addSql('CREATE INDEX IDX_6113A8457F2DEE08 ON care (facture_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE care DROP FOREIGN KEY FK_6113A8457F2DEE08');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP TABLE reglement');
        $this->addSql('DROP INDEX IDX_6113A8457F2DEE08 ON care');
        $this->addSql('ALTER TABLE care DROP facture_id, DROP montant');
    }
}
