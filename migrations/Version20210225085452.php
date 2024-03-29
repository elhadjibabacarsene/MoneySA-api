<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210225085452 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction ADD client_depot_id INT NOT NULL');
        $this->addSql('ALTER TABLE transaction ADD client_retrait_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1ABF6E41B FOREIGN KEY (client_depot_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1EEAC783B FOREIGN KEY (client_retrait_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_723705D1ABF6E41B ON transaction (client_depot_id)');
        $this->addSql('CREATE INDEX IDX_723705D1EEAC783B ON transaction (client_retrait_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE transaction DROP CONSTRAINT FK_723705D1ABF6E41B');
        $this->addSql('ALTER TABLE transaction DROP CONSTRAINT FK_723705D1EEAC783B');
        $this->addSql('DROP INDEX IDX_723705D1ABF6E41B');
        $this->addSql('DROP INDEX IDX_723705D1EEAC783B');
        $this->addSql('ALTER TABLE transaction DROP client_depot_id');
        $this->addSql('ALTER TABLE transaction DROP client_retrait_id');
    }
}
