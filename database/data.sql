-- ============================================================
--  FLO-APP — Base de données MySQL complète
-- ============================================================

CREATE DATABASE IF NOT EXISTS flo_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE flo_app;

-- Table : users

CREATE TABLE IF NOT EXISTS users(
    id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom           VARCHAR(100)        NOT NULL,
    prenom        VARCHAR(100)        NOT NULL,
    email         VARCHAR(100)        NOT NULL,
    password      VARCHAR(100)        NOT NULL,
    conf_mot_pass VARCHAR(255)        NOT NULL 
);
-- Table : cycles
CREATE TABLE IF NOT EXISTS cycles (
    id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id       INT UNSIGNED        NOT NULL,
    date_debut    DATE                NOT NULL,
    date_fin      DATE                DEFAULT NULL,
    duree         TINYINT UNSIGNED    DEFAULT NULL,
    duree_regles  TINYINT UNSIGNED    DEFAULT NULL,
    notes         TEXT                DEFAULT NULL,
    date_creation DATETIME            NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ;

-- Table : period_days
CREATE TABLE IF NOT EXISTS period_days (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    cycle_id    INT UNSIGNED        NOT NULL,
    user_id     INT UNSIGNED        NOT NULL,
    date        DATE                NOT NULL,
    intensite   ENUM('légère','moyenne','abondante','très abondante') NOT NULL DEFAULT 'moyenne',
    date_creation DATETIME          NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_user_date (user_id, date),
    FOREIGN KEY (cycle_id) REFERENCES cycles(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id)  REFERENCES users(id)  ON DELETE CASCADE
) ;

-- Table : symptoms
CREATE TABLE IF NOT EXISTS symptoms (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id     INT UNSIGNED        NOT NULL,
    date        DATE                NOT NULL,
    type        VARCHAR(50)         NOT NULL,
    intensite   TINYINT UNSIGNED    NOT NULL DEFAULT 1,
    notes       TEXT                DEFAULT NULL,
    date_creation DATETIME          NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ;

-- Table : moods
CREATE TABLE IF NOT EXISTS moods (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id     INT UNSIGNED        NOT NULL,
    date        DATE                NOT NULL,
    humeur      ENUM('triste','neutre','bien','heureuse','euphorique') NOT NULL,
    notes       TEXT                DEFAULT NULL,
    date_creation DATETIME          NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_user_date (user_id, date),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Table : sleep_logs
CREATE TABLE IF NOT EXISTS sleep_logs (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id     INT UNSIGNED        NOT NULL,
    date        DATE                NOT NULL,
    heures      DECIMAL(4,1)        NOT NULL,
    qualite     TINYINT UNSIGNED    NOT NULL DEFAULT 3,
    date_creation DATETIME          NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_user_date (user_id, date),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;



-- Table : notes
CREATE TABLE IF NOT EXISTS notes (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id     INT UNSIGNED        NOT NULL,
    date        DATE                NOT NULL,
    contenu     TEXT                NOT NULL,
    date_creation DATETIME          NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Table : articles
CREATE TABLE IF NOT EXISTS articles (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    titre       VARCHAR(255)        NOT NULL,
    slug        VARCHAR(255)        NOT NULL UNIQUE,
    contenu     LONGTEXT            NOT NULL,
    extrait     TEXT                DEFAULT NULL,
    categorie   VARCHAR(50)         NOT NULL DEFAULT 'general',
    image       VARCHAR(255)        DEFAULT NULL,
    duree_lecture TINYINT UNSIGNED  DEFAULT 5,
    publie      TINYINT(1)          NOT NULL DEFAULT 1,
    date_creation DATETIME          NOT NULL DEFAULT CURRENT_TIMESTAMP
) ;

-- Table : settings
CREATE TABLE IF NOT EXISTS settings (
    id                      INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id                 INT UNSIGNED NOT NULL UNIQUE,
    duree_cycle_moy         TINYINT UNSIGNED DEFAULT 28,
    duree_regles_moy        TINYINT UNSIGNED DEFAULT 5,
    notif_journal           TINYINT(1)       DEFAULT 1,
    notif_heure_journal     TIME             DEFAULT '20:00:00',
    notif_alerte_regles     TINYINT(1)       DEFAULT 1,
    notif_jours_avant       TINYINT UNSIGNED DEFAULT 2,
    notif_ovulation         TINYINT(1)       DEFAULT 1,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ;
