<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200807134854 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE care CHANGE facture_id facture_id INT NOT NULL');
        $this->addSql('ALTER TABLE reglement ADD facture_id INT NOT NULL');
        $this->addSql('ALTER TABLE reglement ADD CONSTRAINT FK_EBE4C14C7F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id)');
        $this->addSql('CREATE INDEX IDX_EBE4C14C7F2DEE08 ON reglement (facture_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE care CHANGE facture_id facture_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reglement DROP FOREIGN KEY FK_EBE4C14C7F2DEE08');
        $this->addSql('DROP INDEX IDX_EBE4C14C7F2DEE08 ON reglement');
        $this->addSql('ALTER TABLE reglement DROP facture_id');
    }
}
