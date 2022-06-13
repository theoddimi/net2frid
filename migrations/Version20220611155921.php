<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220611155921 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create api_response table to keep track of all the http responses';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("CREATE TABLE api_response (
                id INT AUTO_INCREMENT NOT NULL,
                api_request_id INT NOT NULL,
                date_created DATETIME NOT NULL,
                date_updated DATETIME NOT NULL,
                response_code VARCHAR(4) NOT NULL,
                response_header LONGTEXT NOT NULL,
                response_body LONGTEXT DEFAULT NULL,
                result VARCHAR(4) NOT NULL COMMENT '(DC2Type:api_response_result)',
                INDEX date_created_index (date_created),
                INDEX api_request_id_index (api_request_id),
                INDEX result_index (result),
                PRIMARY KEY (id)
                ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB");
        $this->addSql('ALTER TABLE api_response ADD CONSTRAINT api_request_fk FOREIGN KEY (api_request_id) REFERENCES api_request (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
