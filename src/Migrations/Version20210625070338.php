<?php

declare(strict_types=1);

namespace DoctrineMigration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210625070338 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart ADD boutique_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B7AB677BE6 FOREIGN KEY (boutique_id) REFERENCES boutique (id)');
        $this->addSql('CREATE INDEX IDX_BA388B7AB677BE6 ON cart (boutique_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B7AB677BE6');
        $this->addSql('DROP INDEX IDX_BA388B7AB677BE6 ON cart');
        $this->addSql('ALTER TABLE cart DROP boutique_id');
    }
}
