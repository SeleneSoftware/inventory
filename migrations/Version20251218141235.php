<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251218141235 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category ADD store_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1B092A811 FOREIGN KEY (store_id) REFERENCES store (id)');
        $this->addSql('CREATE INDEX IDX_64C19C1B092A811 ON category (store_id)');
        $this->addSql('ALTER TABLE store DROP FOREIGN KEY FK_FF57587712469DE2');
        $this->addSql('DROP INDEX IDX_FF57587712469DE2 ON store');
        $this->addSql('ALTER TABLE store DROP category_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1B092A811');
        $this->addSql('DROP INDEX IDX_64C19C1B092A811 ON category');
        $this->addSql('ALTER TABLE category DROP store_id');
        $this->addSql('ALTER TABLE store ADD category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE store ADD CONSTRAINT FK_FF57587712469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_FF57587712469DE2 ON store (category_id)');
    }
}
