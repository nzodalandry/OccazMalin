<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191219141507 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ads (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', created_by_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', category_id INT NOT NULL, location_id INT NOT NULL, title VARCHAR(90) NOT NULL, slug VARCHAR(90) NOT NULL, price NUMERIC(10, 2) NOT NULL, description LONGTEXT DEFAULT NULL, language CHAR(2) NOT NULL, state enum(\'new\', \'used\', \'broken\'), date_publish DATETIME NOT NULL, date_expire DATETIME NOT NULL, INDEX IDX_7EC9F620B03A8386 (created_by_id), INDEX IDX_7EC9F62012469DE2 (category_id), INDEX IDX_7EC9F62064D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attachments (id INT AUTO_INCREMENT NOT NULL, media_id INT NOT NULL, ad_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', title VARCHAR(80) DEFAULT NULL, INDEX IDX_47C4FAD6EA9FDD75 (media_id), INDEX IDX_47C4FAD64F34D596 (ad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medias (id INT AUTO_INCREMENT NOT NULL, created_by_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', type VARCHAR(255) NOT NULL, path VARCHAR(40) NOT NULL, INDEX IDX_12D2AF81B03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', picture_id INT DEFAULT NULL, address_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(40) NOT NULL, lastname VARCHAR(40) NOT NULL, screenname VARCHAR(50) NOT NULL, phone VARCHAR(20) DEFAULT NULL, birthday DATE NOT NULL, language CHAR(2) NOT NULL, is_active TINYINT(1) NOT NULL, activation_token VARCHAR(255) DEFAULT NULL, passwordtoken VARCHAR(255) DEFAULT NULL, password_token_expiration DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), INDEX IDX_1483A5E9EE45BDBF (picture_id), INDEX IDX_1483A5E9F5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favorites (users_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', ads_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_E46960F567B3B43D (users_id), INDEX IDX_E46960F5FE52BF81 (ads_id), PRIMARY KEY(users_id, ads_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, slug VARCHAR(30) NOT NULL, color CHAR(7) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE addresses (id INT AUTO_INCREMENT NOT NULL, address VARCHAR(255) DEFAULT NULL, additional VARCHAR(255) DEFAULT NULL, postalcode VARCHAR(10) NOT NULL, city VARCHAR(80) NOT NULL, region VARCHAR(80) DEFAULT NULL, country CHAR(2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offers (id INT AUTO_INCREMENT NOT NULL, user_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', ad_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', price NUMERIC(10, 2) NOT NULL, message LONGTEXT DEFAULT NULL, offer_date DATETIME NOT NULL, INDEX IDX_DA460427A76ED395 (user_id), INDEX IDX_DA4604274F34D596 (ad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ads ADD CONSTRAINT FK_7EC9F620B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE ads ADD CONSTRAINT FK_7EC9F62012469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE ads ADD CONSTRAINT FK_7EC9F62064D218E FOREIGN KEY (location_id) REFERENCES addresses (id)');
        $this->addSql('ALTER TABLE attachments ADD CONSTRAINT FK_47C4FAD6EA9FDD75 FOREIGN KEY (media_id) REFERENCES medias (id)');
        $this->addSql('ALTER TABLE attachments ADD CONSTRAINT FK_47C4FAD64F34D596 FOREIGN KEY (ad_id) REFERENCES ads (id)');
        $this->addSql('ALTER TABLE medias ADD CONSTRAINT FK_12D2AF81B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9EE45BDBF FOREIGN KEY (picture_id) REFERENCES medias (id)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9F5B7AF75 FOREIGN KEY (address_id) REFERENCES addresses (id)');
        $this->addSql('ALTER TABLE favorites ADD CONSTRAINT FK_E46960F567B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favorites ADD CONSTRAINT FK_E46960F5FE52BF81 FOREIGN KEY (ads_id) REFERENCES ads (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offers ADD CONSTRAINT FK_DA460427A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE offers ADD CONSTRAINT FK_DA4604274F34D596 FOREIGN KEY (ad_id) REFERENCES ads (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE attachments DROP FOREIGN KEY FK_47C4FAD64F34D596');
        $this->addSql('ALTER TABLE favorites DROP FOREIGN KEY FK_E46960F5FE52BF81');
        $this->addSql('ALTER TABLE offers DROP FOREIGN KEY FK_DA4604274F34D596');
        $this->addSql('ALTER TABLE attachments DROP FOREIGN KEY FK_47C4FAD6EA9FDD75');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9EE45BDBF');
        $this->addSql('ALTER TABLE ads DROP FOREIGN KEY FK_7EC9F620B03A8386');
        $this->addSql('ALTER TABLE medias DROP FOREIGN KEY FK_12D2AF81B03A8386');
        $this->addSql('ALTER TABLE favorites DROP FOREIGN KEY FK_E46960F567B3B43D');
        $this->addSql('ALTER TABLE offers DROP FOREIGN KEY FK_DA460427A76ED395');
        $this->addSql('ALTER TABLE ads DROP FOREIGN KEY FK_7EC9F62012469DE2');
        $this->addSql('ALTER TABLE ads DROP FOREIGN KEY FK_7EC9F62064D218E');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9F5B7AF75');
        $this->addSql('DROP TABLE ads');
        $this->addSql('DROP TABLE attachments');
        $this->addSql('DROP TABLE medias');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE favorites');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE addresses');
        $this->addSql('DROP TABLE offers');
    }
}
