<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161216005013 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_7D053A932C42079 ON menu');
        $this->addSql('ALTER TABLE menu ADD information_id INT DEFAULT NULL, DROP route');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A932EF03101 FOREIGN KEY (information_id) REFERENCES information (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7D053A932EF03101 ON menu (information_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A932EF03101');
        $this->addSql('DROP INDEX UNIQ_7D053A932EF03101 ON menu');
        $this->addSql('ALTER TABLE menu ADD route VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, DROP information_id');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7D053A932C42079 ON menu (route)');
    }
}
