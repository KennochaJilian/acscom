<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200303135851 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE category_questions DROP FOREIGN KEY FK_4DBC86E5E7A1254A');
        $this->addSql('DROP INDEX IDX_4DBC86E5E7A1254A ON category_questions');
        $this->addSql('ALTER TABLE category_questions DROP contact_id');
        $this->addSql('ALTER TABLE contact ADD reason_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E63859BB1592 FOREIGN KEY (reason_id) REFERENCES category_questions (id)');
        $this->addSql('CREATE INDEX IDX_4C62E63859BB1592 ON contact (reason_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE category_questions ADD contact_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE category_questions ADD CONSTRAINT FK_4DBC86E5E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id)');
        $this->addSql('CREATE INDEX IDX_4DBC86E5E7A1254A ON category_questions (contact_id)');
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E63859BB1592');
        $this->addSql('DROP INDEX IDX_4C62E63859BB1592 ON contact');
        $this->addSql('ALTER TABLE contact DROP reason_id');
    }
}
