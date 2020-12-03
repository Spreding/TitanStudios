<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201203135723 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE links_realisation DROP FOREIGN KEY FK_6F73A13CB685E551');
        $this->addSql('DROP INDEX IDX_6F73A13CB685E551 ON links_realisation');
        $this->addSql('ALTER TABLE links_realisation DROP realisation_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE links_realisation ADD realisation_id INT NOT NULL');
        $this->addSql('ALTER TABLE links_realisation ADD CONSTRAINT FK_6F73A13CB685E551 FOREIGN KEY (realisation_id) REFERENCES realisations (id)');
        $this->addSql('CREATE INDEX IDX_6F73A13CB685E551 ON links_realisation (realisation_id)');
    }
}
