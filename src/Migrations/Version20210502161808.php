<?php

declare(strict_types=1);

namespace DoctrineMigration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210502161808 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE conversation (id INT AUTO_INCREMENT NOT NULL, last_message_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_8A8E26E9BA0E79C3 (last_message_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participant (id INT AUTO_INCREMENT NOT NULL, conversation_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_D79F6B119AC0396 (conversation_id), INDEX IDX_D79F6B11A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E9BA0E79C3 FOREIGN KEY (last_message_id) REFERENCES message (id)');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B119AC0396 FOREIGN KEY (conversation_id) REFERENCES conversation (id)');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B11A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE view');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F70834FA6');
        $this->addSql('DROP INDEX IDX_B6BD307F70834FA6 ON message');
        $this->addSql('ALTER TABLE message ADD user_id INT DEFAULT NULL, DROP id_sender, DROP id_receved, DROP created_at, DROP view, CHANGE bloked_id conversation_id INT DEFAULT NULL, CHANGE message content LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F9AC0396 FOREIGN KEY (conversation_id) REFERENCES conversation (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F9AC0396 ON message (conversation_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307FA76ED395 ON message (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F9AC0396');
        $this->addSql('ALTER TABLE participant DROP FOREIGN KEY FK_D79F6B119AC0396');
        $this->addSql('CREATE TABLE view (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE conversation');
        $this->addSql('DROP TABLE participant');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FA76ED395');
        $this->addSql('DROP INDEX IDX_B6BD307F9AC0396 ON message');
        $this->addSql('DROP INDEX IDX_B6BD307FA76ED395 ON message');
        $this->addSql('ALTER TABLE message ADD bloked_id INT DEFAULT NULL, ADD id_sender INT NOT NULL, ADD id_receved INT NOT NULL, ADD created_at DATETIME NOT NULL, ADD view TINYINT(1) NOT NULL, DROP conversation_id, DROP user_id, CHANGE content message LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F70834FA6 FOREIGN KEY (bloked_id) REFERENCES bloked (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F70834FA6 ON message (bloked_id)');
    }
}
