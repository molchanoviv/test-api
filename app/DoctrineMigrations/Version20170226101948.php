<?php

namespace Application\Migrations\Base;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170226101948 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('ALTER TABLE country ADD code VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE auth_code ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE auth_code ADD CONSTRAINT FK_5933D02CA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_5933D02CA76ED395 ON auth_code (user_id)');
        $this->addSql('ALTER TABLE access_token ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE access_token ADD CONSTRAINT FK_B6A2DD68A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_B6A2DD68A76ED395 ON access_token (user_id)');
        $this->addSql('ALTER TABLE client ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_C7440455A76ED395 ON client (user_id)');
        $this->addSql('ALTER TABLE refresh_token ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE refresh_token ADD CONSTRAINT FK_C74F2195A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_C74F2195A76ED395 ON refresh_token (user_id)');
        $this->addSql('CREATE UNIQUE INDEX IDX_CITY_IN_REGION ON city (name, region_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('ALTER TABLE access_token DROP FOREIGN KEY FK_B6A2DD68A76ED395');
        $this->addSql('DROP INDEX IDX_B6A2DD68A76ED395 ON access_token');
        $this->addSql('ALTER TABLE access_token DROP user_id');
        $this->addSql('ALTER TABLE auth_code DROP FOREIGN KEY FK_5933D02CA76ED395');
        $this->addSql('DROP INDEX IDX_5933D02CA76ED395 ON auth_code');
        $this->addSql('ALTER TABLE auth_code DROP user_id');
        $this->addSql('DROP INDEX IDX_CITY_IN_REGION ON city');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455A76ED395');
        $this->addSql('DROP INDEX IDX_C7440455A76ED395 ON client');
        $this->addSql('ALTER TABLE client DROP user_id');
        $this->addSql('ALTER TABLE country DROP code');
        $this->addSql('ALTER TABLE refresh_token DROP FOREIGN KEY FK_C74F2195A76ED395');
        $this->addSql('DROP INDEX IDX_C74F2195A76ED395 ON refresh_token');
        $this->addSql('ALTER TABLE refresh_token DROP user_id');
    }
}
