<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220611162704 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create message_transport table to keep track of all transports';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("CREATE TABLE message_transport (
                id INT AUTO_INCREMENT NOT NULL,
                api_response_id INT NOT NULL,
                date_created DATETIME NOT NULL,
                date_updated DATETIME NOT NULL,
                status VARCHAR(4) NOT NULL,
                routing_class VARCHAR(255) DEFAULT NULL,
                routing_class_id INT DEFAULT NULL,
                transport VARCHAR(255) DEFAULT NULL,
                routing_key VARCHAR(255) DEFAULT NULL,
                content TEXT DEFAULT NULL,
                INDEX date_created_index (date_created),
                INDEX api_response_id_index (api_response_id),
                INDEX routing_key_index (routing_key),
                PRIMARY KEY (id)
                ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB");

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
