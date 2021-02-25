<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210225081408 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE transaction_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE transaction (id INT NOT NULL, user_emetteur_id INT NOT NULL, user_recepteur_id INT DEFAULT NULL, montant INT NOT NULL, date_depot DATE NOT NULL, date_retrait DATE NOT NULL, code_transfert VARCHAR(9) NOT NULL, frais INT NOT NULL, montant_avec_frais INT NOT NULL, frais_depot INT NOT NULL, frais_retrait INT NOT NULL, frais_etat INT NOT NULL, frais_systeme INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_723705D1D0F2E719 ON transaction (user_emetteur_id)');
        $this->addSql('CREATE INDEX IDX_723705D1BB85042F ON transaction (user_recepteur_id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1D0F2E719 FOREIGN KEY (user_emetteur_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1BB85042F FOREIGN KEY (user_recepteur_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE transaction_id_seq CASCADE');
        $this->addSql('DROP TABLE transaction');
    }
}
