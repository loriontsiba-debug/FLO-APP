CREATE DATABASE IF NOT EXISTS flo_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE flo_app;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    current_phase VARCHAR(50) NOT NULL,
    cycle_day INT NOT NULL,
    total_cycle_days INT DEFAULT 28,
    next_period_date DATE,
    fertile_window_start DATE,
    fertile_window_end DATE,
    avg_cycle_length INT DEFAULT 27,
    period_duration INT DEFAULT 5,
    last_period_range VARCHAR(50),
    regularity INT DEFAULT 95,
    registered_cycles INT DEFAULT 6,
    started_since VARCHAR(20)
);

CREATE TABLE IF NOT EXISTS daily_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    log_date DATE NOT NULL,
    mood VARCHAR(50),
    sleep_hours VARCHAR(20),
    energy_level VARCHAR(50),
    pain_level VARCHAR(50),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS cycle_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    month_name VARCHAR(20) NOT NULL,
    days INT NOT NULL,
    is_current TINYINT(1) DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE suivi_quotidien (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date_saisie DATE NOT NULL,
    humeur VARCHAR(50) NOT NULL,
    sommeil VARCHAR(20) NOT NULL,
    energie VARCHAR(50) NOT NULL,
    douleurs VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- Insertion des données de test
/*INSERT INTO users (id, name, current_phase, cycle_day, total_cycle_days, next_period_date, fertile_window_start, fertile_window_end, avg_cycle_length, period_duration, last_period_range, regularity, registered_cycles, started_since)
VALUES (1, 'Sophie M.', 'Phase ovulatoire', 14, 28, '2025-09-12', '2025-09-11', '2025-09-16', 27, 5, '15–19 août', 95, 6, 'avr. 2025');

INSERT INTO daily_logs (user_id, log_date, mood, sleep_hours, energy_level, pain_level)
VALUES (1, '2025-08-29', 'Bien', '7h30', 'Haute', 'Aucune');

INSERT INTO cycle_history (user_id, month_name, days, is_current) VALUES
(1, 'Avr', 27, 0),
(1, 'Mai', 28, 0),
(1, 'Jun', 26, 0),
(1, 'Jul', 28, 0),
(1, 'Août', 28, 1),
(1, 'Sep', 0, 0);*/