-- Migration: create drinks table

CREATE DATABASE eurosong
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE eurosong;

CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE countries (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    code CHAR(2) NOT NULL UNIQUE,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE events (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    year INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    winner_participant_id BIGINT UNSIGNED NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE participants (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    event_id BIGINT UNSIGNED NOT NULL,
    country_id BIGINT UNSIGNED NOT NULL,
    artist VARCHAR(255) NOT NULL,
    song VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_participants_event
        FOREIGN KEY (event_id) REFERENCES events(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_participants_country
        FOREIGN KEY (country_id) REFERENCES countries(id)
        ON DELETE RESTRICT
);

CREATE TABLE scores (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    participant_id BIGINT UNSIGNED NOT NULL,
    song_score TINYINT UNSIGNED NOT NULL CHECK (song_score <= 10),
    outfit_score TINYINT UNSIGNED NOT NULL CHECK (outfit_score <= 10),
    act_score TINYINT UNSIGNED NOT NULL CHECK (act_score <= 10),
    total_score TINYINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_scores_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_scores_participant
        FOREIGN KEY (participant_id) REFERENCES participants(id)
        ON DELETE CASCADE,

    CONSTRAINT unique_user_participant
        UNIQUE (user_id, participant_id)
);

ALTER TABLE events
ADD CONSTRAINT fk_events_winner
FOREIGN KEY (winner_participant_id)
REFERENCES participants(id)
ON DELETE SET NULL;

INSERT INTO countries (name, code) VALUES
('Belgium', 'BE'),
('Netherlands', 'NL'),
('France', 'FR'),
('Sweden', 'SE'),
('Italy', 'IT'),
('United Kingdom', 'GB'),
('Germany', 'DE'),
('Spain', 'ES'),
('Australia', 'AU');

