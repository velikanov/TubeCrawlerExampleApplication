<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150810003427 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE video ADD tube_id INT NOT NULL');
        $this->addSql('UPDATE video SET tube_id = 4');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2CA8AE880A FOREIGN KEY (tube_id) REFERENCES tube (id)');
        $this->addSql('CREATE INDEX IDX_7CC7DA2CA8AE880A ON video (tube_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2CA8AE880A');
        $this->addSql('DROP INDEX IDX_7CC7DA2CA8AE880A ON video');
        $this->addSql('ALTER TABLE video DROP tube_id');
    }
}
