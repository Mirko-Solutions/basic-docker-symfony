<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231006085638 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('alter table users 
        add is_accepted BOOLEAN NOT NULL DEFAULT true'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('alter table users 
        drop column is_accepted');
    }
}
