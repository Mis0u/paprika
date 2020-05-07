<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200504034237 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23CA76ED395');
        $this->addSql('ALTER TABLE mission ADD is_validate TINYINT(1) NOT NULL');
        $this->addSql('DROP INDEX idx_9067f23ca76ed395 ON mission');
        $this->addSql('CREATE INDEX IDX_9067F23C365247D8 ON mission (mission_user_id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23CA76ED395 FOREIGN KEY (mission_user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23C365247D8');
        $this->addSql('ALTER TABLE mission DROP is_validate');
        $this->addSql('DROP INDEX idx_9067f23c365247d8 ON mission');
        $this->addSql('CREATE INDEX IDX_9067F23CA76ED395 ON mission (mission_user_id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C365247D8 FOREIGN KEY (mission_user_id) REFERENCES user (id)');
    }
}
