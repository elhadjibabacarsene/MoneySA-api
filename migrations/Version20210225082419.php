<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210225082419 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction DROP CONSTRAINT fk_723705d1d0f2e719');
        $this->addSql('ALTER TABLE transaction DROP CONSTRAINT fk_723705d1bb85042f');
        $this->addSql('DROP INDEX idx_723705d1d0f2e719');
        $this->addSql('DROP INDEX idx_723705d1bb85042f');
        $this->addSql('ALTER TABLE transaction RENAME COLUMN user_emetteur_id TO user_depot_id');
        $this->addSql('ALTER TABLE transaction RENAME COLUMN user_recepteur_id TO user_retrait_id');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1659D30DE FOREIGN KEY (user_depot_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1D99F8396 FOREIGN KEY (user_retrait_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_723705D1659D30DE ON transaction (user_depot_id)');
        $this->addSql('CREATE INDEX IDX_723705D1D99F8396 ON transaction (user_retrait_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE transaction DROP CONSTRAINT FK_723705D1659D30DE');
        $this->addSql('ALTER TABLE transaction DROP CONSTRAINT FK_723705D1D99F8396');
        $this->addSql('DROP INDEX IDX_723705D1659D30DE');
        $this->addSql('DROP INDEX IDX_723705D1D99F8396');
        $this->addSql('ALTER TABLE transaction RENAME COLUMN user_depot_id TO user_emetteur_id');
        $this->addSql('ALTER TABLE transaction RENAME COLUMN user_retrait_id TO user_recepteur_id');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT fk_723705d1d0f2e719 FOREIGN KEY (user_emetteur_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT fk_723705d1bb85042f FOREIGN KEY (user_recepteur_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_723705d1d0f2e719 ON transaction (user_emetteur_id)');
        $this->addSql('CREATE INDEX idx_723705d1bb85042f ON transaction (user_recepteur_id)');
    }
}
