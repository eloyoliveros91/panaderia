<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240520192226 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pedido (id INT AUTO_INCREMENT NOT NULL, usuario_id INT NOT NULL, fecha DATETIME NOT NULL, INDEX IDX_C4EC16CEDB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pedido_producto (id INT AUTO_INCREMENT NOT NULL, pedido_id INT NOT NULL, producto_id INT NOT NULL, cantidad INT NOT NULL, INDEX IDX_DD333C24854653A (pedido_id), INDEX IDX_DD333C27645698E (producto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE producto (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, descripcion VARCHAR(255) NOT NULL, precio DOUBLE PRECISION NOT NULL, disponible TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pedido ADD CONSTRAINT FK_C4EC16CEDB38439E FOREIGN KEY (usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE pedido_producto ADD CONSTRAINT FK_DD333C24854653A FOREIGN KEY (pedido_id) REFERENCES pedido (id)');
        $this->addSql('ALTER TABLE pedido_producto ADD CONSTRAINT FK_DD333C27645698E FOREIGN KEY (producto_id) REFERENCES producto (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pedido DROP FOREIGN KEY FK_C4EC16CEDB38439E');
        $this->addSql('ALTER TABLE pedido_producto DROP FOREIGN KEY FK_DD333C24854653A');
        $this->addSql('ALTER TABLE pedido_producto DROP FOREIGN KEY FK_DD333C27645698E');
        $this->addSql('DROP TABLE pedido');
        $this->addSql('DROP TABLE pedido_producto');
        $this->addSql('DROP TABLE producto');
        $this->addSql('DROP TABLE user');
    }
}
