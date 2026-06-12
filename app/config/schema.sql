CREATE TABLE IF NOT EXISTS frog_articles (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    content TEXT NOT NULL,
    description TEXT NOT NULL,
    viewed_count INTEGER DEFAULT 0,
    image_description TEXT NULL,
    image_source TEXT NULL,
    image TEXT NULL
);

CREATE INDEX IF NOT EXISTS idx_frog_articles_by_title
ON frog_articles(title);
