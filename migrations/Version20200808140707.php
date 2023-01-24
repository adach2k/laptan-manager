<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200808140707 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FE38F84430DBA995 ON appointment (appointment_at)');
        $this->addSql('ALTER TABLE care ADD medecin_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE care ADD CONSTRAINT FK_6113A8454F31A84 FOREIGN KEY (medecin_id) REFERENCES medecin (id)');
        $this->addSql('CREATE INDEX IDX_6113A8454F31A84 ON care (medecin_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_FE38F84430DBA995 ON appointment');
        $this->addSql('ALTER TABLE care DROP FOREIGN KEY FK_6113A8454F31A84');
        $this->addSql('DROP INDEX IDX_6113A8454F31A84 ON care');
        $this->addSql('ALTER TABLE care DROP medecin_id');
    }
}
