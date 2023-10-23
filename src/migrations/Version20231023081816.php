<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231023081816 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE user_gdpr_policy (
                        id INT NOT NULL, 
                        user_id INT DEFAULT NULL, 
                        type VARCHAR(255) NOT NULL, 
                        accepted_at timestamp with time zone NULL, 
                        PRIMARY KEY(id))'
        );
        $this->addSql('CREATE INDEX user_gdpr_policy_user_id_index ON user_token (user_id)');
        $this->addSql('ALTER TABLE user_gdpr_policy 
    ADD CONSTRAINT user_gdpr_policy_users_id_fk FOREIGN KEY (user_id) 
        REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE id CASCADE');
        $this->addSql('ALTER TABLE user_gdpr_policy DROP CONSTRAINT user_gdpr_policy_users_id_fk');
        $this->addSql('DROP TABLE user_gdpr_policy');
    }
}
