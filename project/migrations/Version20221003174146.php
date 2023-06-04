<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221003174146 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, author_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', post_id INT NOT NULL, content LONGTEXT NOT NULL, is_approved TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_9474526CF675F31B (author_id), INDEX IDX_9474526C4B89032C (post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C4B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE category_post RENAME INDEX idx_8c5eafb712469de2 TO IDX_D11116CA12469DE2');
        $this->addSql('ALTER TABLE category_post RENAME INDEX idx_8c5eafb74b89032c TO IDX_D11116CA4B89032C');
        $this->addSql('ALTER TABLE tag_post RENAME INDEX idx_e3394ca2bad26311 TO IDX_B485D33BBAD26311');
        $this->addSql('ALTER TABLE tag_post RENAME INDEX idx_e3394ca24b89032c TO IDX_B485D33B4B89032C');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE comment');
        $this->addSql('ALTER TABLE category_post RENAME INDEX idx_d11116ca12469de2 TO IDX_8C5EAFB712469DE2');
        $this->addSql('ALTER TABLE category_post RENAME INDEX idx_d11116ca4b89032c TO IDX_8C5EAFB74B89032C');
        $this->addSql('ALTER TABLE tag_post RENAME INDEX idx_b485d33b4b89032c TO IDX_E3394CA24B89032C');
        $this->addSql('ALTER TABLE tag_post RENAME INDEX idx_b485d33bbad26311 TO IDX_E3394CA2BAD26311');
    }
}
