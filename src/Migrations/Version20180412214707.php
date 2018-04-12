<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180412214707 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE repository_commit_compare (repository_id INTEGER NOT NULL, status VARCHAR(255) NOT NULL, ahead_by INTEGER NOT NULL, behind_by INTEGER NOT NULL, commits CLOB NOT NULL, PRIMARY KEY(repository_id))');
        $this->addSql('CREATE TABLE repository (id INTEGER NOT NULL, full_name VARCHAR(255) NOT NULL, default_branch VARCHAR(255) NOT NULL, archived BOOLEAN NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, pushed_at DATETIME NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE pull_request (id INTEGER NOT NULL, repository_id INTEGER NOT NULL, state VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, user_login VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, closed_at DATETIME DEFAULT NULL, merged_at DATETIME DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8B9B9EEF50C9D4F7 ON pull_request (repository_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE repository_commit_compare');
        $this->addSql('DROP TABLE repository');
        $this->addSql('DROP TABLE pull_request');
    }
}
