USE db_gestiondepenses;

-- Création de la table "roles"
CREATE TABLE roles (
  id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
);

-- Modification de la table "users" pour ajouter la clé étrangère "idrole"
ALTER TABLE users ADD COLUMN idrole BIGINT(20) UNSIGNED NULL AFTER id;

-- Ajout de la contrainte de clé étrangère dans la table "users"
ALTER TABLE users ADD CONSTRAINT fk_user_role FOREIGN KEY (idrole) REFERENCES roles(id);

-- Création de la table "activities"
CREATE TABLE activities (
  id INT NOT NULL AUTO_INCREMENT,
  title VARCHAR(255) NOT NULL,
  description VARCHAR(255) NOT NULL,
  created_at DATE NOT NULL,
  updated_at DATE NOT NULL,
  user_id BIGINT(20) UNSIGNED NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Création de la table "expenses"
CREATE TABLE expenses (
  id INT NOT NULL AUTO_INCREMENT,
  title VARCHAR(255) NOT NULL,
  description VARCHAR(255) NOT NULL,
  amount DECIMAL(10,2) NOT NULL,
  created_at DATE NOT NULL,
  updated_at DATE NOT NULL,
  activity_id INT NOT NULL,
  user_id BIGINT(20) UNSIGNED NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT fk_activity FOREIGN KEY (activity_id) REFERENCES activities(id),
  CONSTRAINT fk_user_created FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Création de la table "expense_participants"
CREATE TABLE expense_participants (
  expense_id INT NOT NULL,
  user_id BIGINT(20) UNSIGNED NOT NULL,
  PRIMARY KEY (expense_id, user_id),
  CONSTRAINT fk_expense_user FOREIGN KEY (user_id) REFERENCES users(id),
  CONSTRAINT fk_expense FOREIGN KEY (expense_id) REFERENCES expenses(id)
);

-- Création de la table "participates"
CREATE TABLE participates (
  activity_id INT NOT NULL,
  user_id BIGINT(20) UNSIGNED NOT NULL,
  PRIMARY KEY (activity_id, user_id),
  CONSTRAINT fk_participant_user FOREIGN KEY (user_id) REFERENCES users(id),
  CONSTRAINT fk_participant_activity FOREIGN KEY (activity_id) REFERENCES activities(id)
);

-- Ajout des index
CREATE UNIQUE INDEX users_id_unique ON users (id);
CREATE UNIQUE INDEX activities_id_unique ON activities (id);
CREATE INDEX activities_user_id_index ON activities (user_id);
CREATE UNIQUE INDEX expenses_id_unique ON expenses (id);
CREATE INDEX expenses_activity_id_index ON expenses (activity_id);
CREATE INDEX expenses_user_id_index ON expenses (user_id);
CREATE UNIQUE INDEX expense_participants_id_unique ON expense_participants (expense_id, user_id);
CREATE INDEX expense_participants_user_id_index ON expense_participants (user_id);
CREATE UNIQUE INDEX participates_id_unique ON participates (activity_id, user_id);
CREATE INDEX participates_user_id_index ON participates (user_id);
