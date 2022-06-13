<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220612112539 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create grid_message table to store all data that consumed from api on message handle';
    }

    public function up(Schema $schema): void
    {
       $this->addSql("CREATE TABLE grid_message (
                id INT AUTO_INCREMENT NOT NULL,
                date_created DATETIME NOT NULL,
                date_updated DATETIME NOT NULL,
                message_transport_id INT NOT NULL,
                gateway_eui VARCHAR(100) NOT NULL,
                profile_id VARCHAR(100) NOT NULL,
                endpoint_id VARCHAR(100) NOT NULL,
                cluster_id VARCHAR(100) NOT NULL,
                attribute_id VARCHAR(100) NOT NULL,
                value INT NOT NULL,
                timestamp INT NOT NULL,
                INDEX date_created_index (date_created),
                INDEX message_transport_id_index (message_transport_id),
                INDEX gateway_eui_index (gateway_eui),
                INDEX profile_id_index (profile_id),
                INDEX endpoint_id_index (endpoint_id),
                INDEX cluster_id_index (cluster_id),
                INDEX attribute_id_index (attribute_id),
                PRIMARY KEY (id)
                ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB");

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
