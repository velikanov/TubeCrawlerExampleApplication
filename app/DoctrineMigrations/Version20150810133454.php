<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150810133454 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tube ADD video_block_selector LONGTEXT NOT NULL, ADD video_uri_selector LONGTEXT NOT NULL, ADD video_image_selector LONGTEXT NOT NULL, ADD video_title_selector LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE video ADD video_uri LONGTEXT DEFAULT NULL, ADD image_uri LONGTEXT DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tube DROP video_block_selector, DROP video_uri_selector, DROP video_image_selector, DROP video_title_selector');
        $this->addSql('ALTER TABLE video DROP video_uri, DROP image_uri');
    }
}
