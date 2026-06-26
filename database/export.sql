SET NAMES utf8mb4;

-- Table city
CREATE TABLE IF NOT EXISTS `city` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `city` VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `city` (`id`, `city`) VALUES
(1, 'Montréal'),
(2, 'Québec'),
(3, 'Laval');

-- Table client
CREATE TABLE IF NOT EXISTS `client` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `address` VARCHAR(255) DEFAULT NULL,
    `phone` VARCHAR(20) DEFAULT NULL,
    `email` VARCHAR(100) DEFAULT NULL,
    `birthday` DATE DEFAULT NULL,
    `city_id` INT DEFAULT NULL,
    FOREIGN KEY (`city_id`) REFERENCES `city`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `client` (`id`, `name`, `address`, `phone`, `email`, `birthday`, `city_id`) VALUES
(1, 'Marie Tremblay', '123, rue des Érables', '514-555-0101', 'marie@exemple.com', '1990-04-15', 1),
(2, 'Jean Gagnon', '456, avenue du Parc', '418-555-0202', 'jean@exemple.com', '1985-08-22', 2),
(3, 'Sophie Lavoie', '789, boulevard Saint-Laurent', '450-555-0303', NULL, '1995-12-01', 3),
(5, 'Carole Roy', '321, chemin du Lac', '450-555-0505', 'isa@exemple.com', '2000-06-30', 3);

