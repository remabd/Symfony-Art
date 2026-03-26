<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260326204631 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE art (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, price INT NOT NULL, category_id INT NOT NULL, INDEX IDX_FC35D65412469DE2 (category_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE art_basket (id INT AUTO_INCREMENT NOT NULL, amount INT NOT NULL, art_id INT NOT NULL, basket_id INT NOT NULL, INDEX IDX_6DF91B878C25E51A (art_id), INDEX IDX_6DF91B871BE1FB52 (basket_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE basket (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, INDEX IDX_2246507BA76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE art ADD CONSTRAINT FK_FC35D65412469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE art_basket ADD CONSTRAINT FK_6DF91B878C25E51A FOREIGN KEY (art_id) REFERENCES art (id)');
        $this->addSql('ALTER TABLE art_basket ADD CONSTRAINT FK_6DF91B871BE1FB52 FOREIGN KEY (basket_id) REFERENCES basket (id)');
        $this->addSql('ALTER TABLE basket ADD CONSTRAINT FK_2246507BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE art DROP FOREIGN KEY FK_FC35D65412469DE2');
        $this->addSql('ALTER TABLE art_basket DROP FOREIGN KEY FK_6DF91B878C25E51A');
        $this->addSql('ALTER TABLE art_basket DROP FOREIGN KEY FK_6DF91B871BE1FB52');
        $this->addSql('ALTER TABLE basket DROP FOREIGN KEY FK_2246507BA76ED395');
        $this->addSql('DROP TABLE art');
        $this->addSql('DROP TABLE art_basket');
        $this->addSql('DROP TABLE basket');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
