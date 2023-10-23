<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230926074924 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('alter table users 
    add first_name VARCHAR(255) NOT NULL, 
    add last_name VARCHAR(255) NOT NULL,
    add recovery_token varchar(255) null, 
    add created_at TIMESTAMPTZ NOT NULL DEFAULT NOW(), 
    add updated_at TIMESTAMPTZ NOT NULL DEFAULT NOW(), 
    add deleted_at TIMESTAMPTZ NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('alter table users 
        drop column recovery_token, 
        drop first_name, 
        drop last_name,
        drop created_at, 
        drop updated_at, 
        drop deleted_at');
    }
}
