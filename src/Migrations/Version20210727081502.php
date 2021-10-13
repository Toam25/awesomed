<?php

declare(strict_types=1);

namespace DoctrineMigration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210727081502 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE votes ADD boutique_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE votes ADD CONSTRAINT FK_518B7ACFAB677BE6 FOREIGN KEY (boutique_id) REFERENCES boutique (id)');
        $this->addSql('CREATE INDEX IDX_518B7ACFAB677BE6 ON votes (boutique_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE votes DROP FOREIGN KEY FK_518B7ACFAB677BE6');
        $this->addSql('DROP INDEX IDX_518B7ACFAB677BE6 ON votes');
        $this->addSql('ALTER TABLE votes DROP boutique_id');
    }
}
