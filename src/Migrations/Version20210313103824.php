<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210313103824 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_BD06F528C4663E4');
        $this->addSql('CREATE TEMPORARY TABLE __temp__Video AS SELECT id, page_id, url, fetchedTime, grabbed_html, downloaded_video, downloaded_qualtity, metadata, fileNameSaved FROM Video');
        $this->addSql('DROP TABLE Video');
        $this->addSql('CREATE TABLE Video (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, page_id INTEGER DEFAULT NULL, url VARCHAR(1024) NOT NULL COLLATE BINARY, fetchedTime DATETIME DEFAULT NULL, grabbed_html BOOLEAN NOT NULL, downloaded_video BOOLEAN NOT NULL, downloaded_qualtity VARCHAR(124) NOT NULL COLLATE BINARY, metadata CLOB DEFAULT NULL COLLATE BINARY --(DC2Type:object)
        , fileNameSaved VARCHAR(1024) DEFAULT NULL COLLATE BINARY, openSubtitlesHash VARCHAR(16), CONSTRAINT FK_BD06F528C4663E4 FOREIGN KEY (page_id) REFERENCES Page (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO Video (id, page_id, url, fetchedTime, grabbed_html, downloaded_video, downloaded_qualtity, metadata, fileNameSaved) SELECT id, page_id, url, fetchedTime, grabbed_html, downloaded_video, downloaded_qualtity, metadata, fileNameSaved FROM __temp__Video');
        $this->addSql('DROP TABLE __temp__Video');
        $this->addSql('CREATE INDEX IDX_BD06F528C4663E4 ON Video (page_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_BD06F528C4663E4');
        $this->addSql('CREATE TEMPORARY TABLE __temp__Video AS SELECT id, page_id, url, fetchedTime, grabbed_html, downloaded_video, downloaded_qualtity, metadata, fileNameSaved FROM Video');
        $this->addSql('DROP TABLE Video');
        $this->addSql('CREATE TABLE Video (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, page_id INTEGER DEFAULT NULL, url VARCHAR(1024) NOT NULL, fetchedTime DATETIME DEFAULT NULL, grabbed_html BOOLEAN NOT NULL, downloaded_video BOOLEAN NOT NULL, downloaded_qualtity VARCHAR(124) NOT NULL, metadata CLOB DEFAULT NULL --(DC2Type:object)
        , fileNameSaved VARCHAR(1024) DEFAULT NULL)');
        $this->addSql('INSERT INTO Video (id, page_id, url, fetchedTime, grabbed_html, downloaded_video, downloaded_qualtity, metadata, fileNameSaved) SELECT id, page_id, url, fetchedTime, grabbed_html, downloaded_video, downloaded_qualtity, metadata, fileNameSaved FROM __temp__Video');
        $this->addSql('DROP TABLE __temp__Video');
        $this->addSql('CREATE INDEX IDX_BD06F528C4663E4 ON Video (page_id)');
    }
}
