-- init.sql
CREATE TABLE IF NOT EXISTS vote (
    id VARCHAR(64) PRIMARY KEY,
    vote BOOLEAN NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Index pour améliorer les performances
CREATE INDEX idx_vote ON vote(vote);
CREATE INDEX idx_created_at ON vote(created_at);