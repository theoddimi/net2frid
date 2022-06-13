<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220610175822 extends AbstractMigration {

    public function getDescription(): string
    {
        return 'Create api_request table to keep track of all the http requests';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("CREATE TABLE api_request (
                id INT AUTO_INCREMENT NOT NULL,
                date_created DATETIME NOT NULL,
                date_updated DATETIME NOT NULL,
                http_request_method VARCHAR(20) NOT NULL,
                url varchar(1500) NOT NULL,
                request_header LONGTEXT DEFAULT NULL,
                request_body LONGTEXT DEFAULT NULL,
                status VARCHAR(4) NOT NULL COMMENT '(DC2Type:api_request_status)',
                INDEX date_created_index (date_created),
                INDEX http_request_method_index (http_request_method),
                INDEX status_index (status),
                PRIMARY KEY (id)
                ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
