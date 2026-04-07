<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260329082220 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pictures (id INT AUTO_INCREMENT NOT NULL, uri VARCHAR(255) NOT NULL, alt VARCHAR(255) NOT NULL, art_id INT NOT NULL, INDEX IDX_8F7C2FC08C25E51A (art_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE pictures ADD CONSTRAINT FK_8F7C2FC08C25E51A FOREIGN KEY (art_id) REFERENCES art (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pictures DROP FOREIGN KEY FK_8F7C2FC08C25E51A');
        $this->addSql('DROP TABLE pictures');
    }
}
