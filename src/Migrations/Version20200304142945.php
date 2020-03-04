<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200304142945 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE orders RENAME INDEX idx_f5299398e3a151fd TO IDX_E52FFDEEE3A151FD');
        $this->addSql('ALTER TABLE orders RENAME INDEX idx_f5299398a76ed395 TO IDX_E52FFDEEA76ED395');
        $this->addSql('ALTER TABLE orders RENAME INDEX idx_f5299398ebf23851 TO IDX_E52FFDEEEBF23851');
        $this->addSql('ALTER TABLE orders RENAME INDEX idx_f5299398c4f286e7 TO IDX_E52FFDEEC4F286E7');
        $this->addSql('ALTER TABLE order_product ADD CONSTRAINT FK_2530ADE68D9F6D38 FOREIGN KEY (order_id) REFERENCES orders (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_product ADD CONSTRAINT FK_2530ADE64584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE order_product DROP FOREIGN KEY FK_2530ADE68D9F6D38');
        $this->addSql('ALTER TABLE order_product DROP FOREIGN KEY FK_2530ADE64584665A');
        $this->addSql('ALTER TABLE orders RENAME INDEX idx_e52ffdeee3a151fd TO IDX_F5299398E3A151FD');
        $this->addSql('ALTER TABLE orders RENAME INDEX idx_e52ffdeeebf23851 TO IDX_F5299398EBF23851');
        $this->addSql('ALTER TABLE orders RENAME INDEX idx_e52ffdeea76ed395 TO IDX_F5299398A76ED395');
        $this->addSql('ALTER TABLE orders RENAME INDEX idx_e52ffdeec4f286e7 TO IDX_F5299398C4F286E7');
    }
}
